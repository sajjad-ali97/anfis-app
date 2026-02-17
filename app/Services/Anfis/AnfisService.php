<?php

namespace App\Services\Anfis;

use InvalidArgumentException;

class AnfisService
{
    private ?FisModel $model = null;

    /**
     * يدخل: ordered13 raw (قبل log/normalization) بنفس ترتيب MATLAB V1..V13
     * يطلع: cost بالدينار (بعد reverse normalization + inverse log)
     */
    public function predictCost(array $ordered13): float
    {
        if (count($ordered13) !== 13) {
            throw new InvalidArgumentException('ANFIS requires exactly 13 inputs.');
        }

        $model = $this->getModel();

        // 1) Log transform: log10(x + 1) (على كل المدخلات مثل MATLAB)
        $xLog = [];
        foreach ($ordered13 as $v) {
            if (!is_numeric($v)) {
                throw new InvalidArgumentException('All ANFIS inputs must be numeric.');
            }
            $xLog[] = $this->log10_safe(((float)$v) + 1.0);
        }

        // 2) Normalize inputs: mapminmax apply (0..1) باستخدام PS_in
        $xNorm = MapMinMax::applyVector(
            $xLog,
            config('anfis.ps_in.gain'),
            config('anfis.ps_in.xoffset'),
            (float) config('anfis.ps_in.ymin'),
            (float) config('anfis.ps_in.yrange')
        );

        // 3) evalfis (Sugeno, prod AND, linear consequents)
        $yNorm = $model->evaluateSugeno($xNorm);

        // 4) Reverse output normalization
        $outLog = MapMinMax::reverseScalar(
            $yNorm,
            (float) config('anfis.ps_out.gain'),
            (float) config('anfis.ps_out.xoffset'),
            (float) config('anfis.ps_out.ymin'),
            (float) config('anfis.ps_out.yrange')
        );

        // 5) Inverse log10: (10 ^ out_log) - 1
        $cost = (pow(10.0, $outLog) - 1.0);

        return $cost;
    }

    private function getModel(): FisModel
    {
        if ($this->model) return $this->model;

        $fisPath = (string) config('anfis.model.fis_path');
        $this->model = FisParser::fromFile($fisPath);

        return $this->model;
    }

    private function log10_safe(float $x): float
    {
        // MATLAB: log10(train_x + 1) => x لازم >= 0 بعد +1
        // هنا نحمي من أي قيمة سالبة غير متوقعة
        if ($x <= 0.0) {
            // بنفس منطق MATLAB تقريباً، بس نحمي التنفيذ
            $x = 1e-12;
        }
        return log($x, 10);
    }
}
