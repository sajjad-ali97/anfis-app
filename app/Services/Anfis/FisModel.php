<?php

namespace App\Services\Anfis;

use InvalidArgumentException;

class FisModel
{
    public function __construct(
        private array $system,
        private array $inputs,
        private array $outputLinear,
        private array $rules
    ) {}

    /**
     * Evaluate Sugeno FIS on normalized inputs (0..1)
     * Returns normalized output.
     */
    public function evaluateSugeno(array $xNorm): float
    {
        $numInputs = (int) ($this->system['NumInputs'] ?? 0);
        $numRules  = (int) ($this->system['NumRules'] ?? 0);

        if ($numInputs !== 13 || $numRules !== 10) {
            // موديلك الحالي 13 inputs / 10 rules حسب ملفك
            // إذا تغيّر لاحقاً، نقدر نخليها dynamic، بس هسه نثبتها
        }

        if (count($xNorm) !== $numInputs) {
            throw new InvalidArgumentException("Expected {$numInputs} inputs, got " . count($xNorm));
        }

        $andMethod = $this->system['AndMethod'] ?? 'prod';

        $w = [];
        $f = [];

        foreach ($this->rules as $rIndex => $rule) {
            $mfIdxs = $rule['in'];

            // 1) firing strength w = prod(mu_i)
            $wi = 1.0;
            for ($i = 0; $i < $numInputs; $i++) {
                $inputNo = $i + 1;
                $mfNo = $mfIdxs[$i] ?? 0;

                $mf = $this->inputs[$inputNo][$mfNo] ?? null;
                if (!$mf) {
                    throw new InvalidArgumentException("Missing MF: Input{$inputNo} MF{$mfNo}");
                }

                $mu = $this->mf($mf['type'], (float)$xNorm[$i], $mf['params']);

                if ($andMethod === 'prod') {
                    $wi *= $mu;
                } else {
                    // إذا احتجته لاحقاً نضيف min
                    $wi *= $mu;
                }
            }

            $wi *= (float)($rule['weight'] ?? 1.0);

            $w[$rIndex] = $wi;

            // 2) linear consequent f = p1*x1 + ... + p13*x13 + bias
            $outIdx = (int) $rule['out'];
            $p = $this->outputLinear[$outIdx] ?? null;
            if (!$p || count($p) < ($numInputs + 1)) {
                throw new InvalidArgumentException("Missing/invalid output linear params for MF{$outIdx}");
            }

            $fi = 0.0;
            for ($i = 0; $i < $numInputs; $i++) {
                $fi += ((float)$p[$i]) * (float)$xNorm[$i];
            }
            $fi += (float)$p[$numInputs]; // bias

            $f[$rIndex] = $fi;
        }

        $sumW = array_sum($w);
        if ($sumW == 0.0) {
            // إذا صار كل firing strengths صفر (نادر جداً)
            return 0.0;
        }

        // y = sum( (w/sumW) * f )
        $y = 0.0;
        foreach ($w as $i => $wi) {
            $y += ($wi / $sumW) * $f[$i];
        }

        return $y;
    }

    private function mf(string $type, float $x, array $p): float
    {
        // موديلك يستخدم gauss2mf فقط للـ inputs
        if ($type === 'gauss2mf') {
            return $this->gauss2mf($x, $p);
        }

        throw new InvalidArgumentException("Unsupported MF type: {$type}");
    }

    /**
     * MATLAB gauss2mf(x,[s1 c1 s2 c2])
     * Two-sided Gaussian: left decays around c1 with s1, right decays around c2 with s2, middle = 1
     */
    private function gauss2mf(float $x, array $p): float
    {
        [$s1, $c1, $s2, $c2] = array_values($p);

        // حماية من sigma=0
        $s1 = ($s1 == 0.0) ? 1e-12 : $s1;
        $s2 = ($s2 == 0.0) ? 1e-12 : $s2;

        if ($x <= $c1) {
            return exp(-pow($x - $c1, 2) / (2.0 * pow($s1, 2)));
        }

        if ($x >= $c2) {
            return exp(-pow($x - $c2, 2) / (2.0 * pow($s2, 2)));
        }

        return 1.0;
    }
}
