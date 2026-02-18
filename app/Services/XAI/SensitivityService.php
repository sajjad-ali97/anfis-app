<?php

namespace App\Services\XAI;

use App\Services\Anfis\AnfisService;
use App\DTOs\SensitivityResult;
use RuntimeException;

class SensitivityService
{
    public function __construct(
        protected AnfisService $anfisService
    ) {}

    /**
     * @param array $ordered13  Raw inputs (قبل log/normalize) بنفس ترتيب MATLAB V1..V13
     * @param array $featureIndexes  ['feature_key' => index_in_ordered13]
     */
    public function analyze(array $ordered13, array $featureIndexes): SensitivityResult
    {
        $cfg = config('sensitivity');

        $featuresCfg = $cfg['features'] ?? [];
        $topN = (int)($cfg['top_n'] ?? 10);
        $perturbPercent = (float)($cfg['continuous_perturbation_percent'] ?? 10);

        if (count($ordered13) !== 13) {
            throw new RuntimeException('SensitivityService expects exactly 13 ordered inputs.');
        }

        // 1) Base cost
        $baseCost = (float) $this->anfisService->predictCost($ordered13);

        $barData = [];
        $debug = [];

        foreach ($featureIndexes as $featureKey => $index) {

            if (!array_key_exists($featureKey, $featuresCfg)) {
                // feature غير معرّف بالكونفك
                continue;
            }

            if (!isset($ordered13[$index])) {
                // index غلط
                continue;
            }

            $meta = $featuresCfg[$featureKey];
            $type = $meta['type'] ?? 'categorical';

            $currentValue = $ordered13[$index];

            $maxImpact = 0.0;          // أكبر فرق مطلق
            $bestScenarioCost = $baseCost; // الكلفة بعد "أسوأ تغيير" (أكبر تأثير)
            $bestTestValue = null;     // للقيم التصنيفية: worst_test_value
            $testedValues = null;      // للقيم التصنيفية: values[]
            $testsForContinuous = null; // للـ continuous: [low, high]

            // ========= Continuous (±10%) =========
            if ($type === 'continuous') {

                $cur = (float) $currentValue;

                // لو القيمة صفر، delta راح يصير صفر.
                // (ممكن مستقبلاً نخلي minimum absolute delta إذا تحتاج)
                $delta = $cur * ($perturbPercent / 100.0);

                $low  = max(0.0, $cur - $delta);
                $high = $cur + $delta;

                $testsForContinuous = [
                    'low'  => $low,
                    'high' => $high,
                ];

                foreach ([$low, $high] as $testVal) {
                    $modified = $ordered13;
                    $modified[$index] = $testVal;

                    $newCost = (float) $this->anfisService->predictCost($modified);

                    $diff = abs($newCost - $baseCost);
                    if ($diff > $maxImpact) {
                        $maxImpact = $diff;
                        $bestScenarioCost = $newCost;
                        // continuous ما عدنا "worst_test_value" ثابت، نقدر نخلي bestTestValue = testVal للـ debug
                        $bestTestValue = $testVal;
                    }
                }
            }

            // ========= Categorical (جرّب كل القيم) =========
            else {
                $values = $meta['values'] ?? null;

                if (!is_array($values) || empty($values)) {
                    // categorical بدون values -> ما نقدر نحلله
                    continue;
                }

                $testedValues = array_values($values);

                foreach ($testedValues as $val) {
                    // نتجاهل نفس القيمة الحالية
                    if ((string)$val === (string)$currentValue) {
                        continue;
                    }

                    $modified = $ordered13;
                    $modified[$index] = (float) $val;

                    $newCost = (float) $this->anfisService->predictCost($modified);

                    $diff = abs($newCost - $baseCost);
                    if ($diff > $maxImpact) {
                        $maxImpact = $diff;
                        $bestScenarioCost = $newCost;
                        $bestTestValue = $val; // worst_test_value
                    }
                }
            }

            // 2) Impact percent
            $impactPercent = ($baseCost > 0)
                ? round(($maxImpact / $baseCost) * 100.0, 2)
                : 0.0;

            // 3) Direction + delta
            $deltaCost = $bestScenarioCost - $baseCost; // (+) يعني السيناريو يرفع الكلفة مقارنة بالحالة الحالية
            $direction = $deltaCost > 0
                ? 'increase'
                : ($deltaCost < 0 ? 'decrease' : 'neutral');

            // 4) Bar data row (للـ bar chart)
            $barData[] = [
                'key' => $featureKey,
                'label_ar' => $meta['label_ar'] ?? $featureKey,
                'label_en' => $meta['label_en'] ?? $featureKey,
                'impact_percent' => $impactPercent,
            ];

            // 5) Debug payload row (تفاصيل علمية للتقرير و ExplanationService)
            $debug[] = [
                'feature' => $featureKey,
                'type' => $type,
                'index' => $index,

                'current_value' => is_numeric($currentValue) ? (float)$currentValue : $currentValue,

                // categorical only
                'tested_values' => $testedValues,
                'worst_test_value' => ($type === 'categorical') ? $bestTestValue : null,

                // continuous only
                'perturb_percent' => ($type === 'continuous') ? $perturbPercent : null,
                'continuous_tests' => ($type === 'continuous') ? $testsForContinuous : null,
                'worst_test_value_continuous' => ($type === 'continuous') ? $bestTestValue : null,

                // costs
                'base_cost' => (int) round($baseCost),
                'cost_after_change' => (int) round($bestScenarioCost),

                // delta + direction
                'delta' => (int) round($deltaCost), // cost_after_change - base_cost
                'direction' => $direction,          // increase|decrease|neutral

                // magnitudes
                'absolute_diff' => (int) round($maxImpact),
                'impact_percent' => $impactPercent,
            ];
        }

        // Sort DESC by impact_percent
        usort($barData, fn($a, $b) => ($b['impact_percent'] <=> $a['impact_percent']));

        // Top influencers
        $topInfluencers = array_slice($barData, 0, $topN);

        return new SensitivityResult(
            base_cost: (float) round($baseCost),
            bar_data: $barData,
            top_influencers: $topInfluencers,
            debug_payload: $debug
        );
    }
}
