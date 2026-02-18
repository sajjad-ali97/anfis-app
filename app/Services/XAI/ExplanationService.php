<?php

namespace App\Services\XAI;

use App\DTOs\ExplanationResult;
use App\DTOs\SensitivityResult;
use App\DTOs\CostGaugeResult;

class ExplanationService
{
    /**
     * يولّد تفسير هندسي احترافي اعتماداً على:
     * - Gauge (تصنيف الكلفة + A)
     * - Sensitivity (Top influencers + debug payload)
     * - القيم الحالية للمدخلات (inputsAssoc)
     */
    public function generate(CostGaugeResult $gauge, SensitivityResult $sensitivity, array $inputsAssoc): ExplanationResult
    {
        $cfg = config('explanation');
        $featuresCfg = $cfg['features'] ?? [];

        $labelKey = $gauge->label_key;
        $gaugeLabelAr = $cfg['gauge_labels'][$labelKey]['ar'] ?? $labelKey;
        $gaugeLabelEn = $cfg['gauge_labels'][$labelKey]['en'] ?? $labelKey;

        $a = (float) $gauge->a;               // cost per m²
        $baseCost = (float) $sensitivity->base_cost;

        // ===== Summary (مختصر + رسمي) =====
        $summaryAr =
            "التكلفة التقديرية ضمن مستوى ({$gaugeLabelAr})، " .
            "وقيمة المؤشر A (الكلفة لكل متر مربع) ≈ " . number_format($a, 2) . " دينار/م². " .
            "الكلفة الكلية المقدّرة ≈ " . number_format($baseCost) . " دينار.";

        $summaryEn =
            "The estimated cost falls in the ({$gaugeLabelEn}) level. " .
            "The A index (cost per square meter) is ≈ " . number_format($a, 2) . " IQD/m², " .
            "with a total estimated cost of ≈ " . number_format($baseCost) . " IQD.";

        // ===== Reasons selection rules =====
        $minPct = (float)($cfg['min_influence_pct'] ?? 2.0);
        $maxReasons = (int)($cfg['max_reasons'] ?? 5);

        $reasonsAr = [];
        $reasonsEn = [];

        $debug = [
            'gauge' => method_exists($gauge, 'toArray') ? $gauge->toArray() : [
                'a' => $a,
                'label_key' => $labelKey,
            ],
            'base_cost' => (int) round($baseCost),
            'min_influence_pct' => $minPct,
            'max_reasons' => $maxReasons,
            'selected_reasons' => [],
        ];

        $debugPayload = $sensitivity->debug_payload ?? [];

        foreach ($sensitivity->top_influencers as $inf) {

            if (count($reasonsAr) >= $maxReasons) break;

            $key = $inf['key'] ?? null;
            $pct = (float)($inf['impact_percent'] ?? 0);

            if (!$key) continue;
            if ($pct < $minPct) continue;
            if (!isset($featuresCfg[$key])) continue;

            $meta = $featuresCfg[$key];
            $value = $inputsAssoc[$key] ?? null;

            $dbg = $this->findDebugForFeature($debugPayload, $key);

            // شرح حالة العامل (حسب كونه categorical أو continuous)
            [$txtAr, $txtEn, $bandKey] = $this->explainFeature($key, $meta, $value);

            // اتجاه التأثير (من debug)
            $direction = $dbg['direction'] ?? 'neutral';
            $delta = (float)($dbg['delta'] ?? 0);
            $scenarioCost = (float)($dbg['cost_after_change'] ?? 0);

            [$dirPhraseAr, $dirPhraseEn] = $this->directionPhrase($direction, $delta);

            // صياغة احترافية: سبب + شرح هندسي + اتجاه التغيير + رقم
            $labelAr = $meta['label_ar'] ?? $key;
            $labelEn = $meta['label_en'] ?? $key;

            $reasonsAr[] =
                "• ({$labelAr}) — تأثير تقريبي {$pct}%.\n" .
                "  {$txtAr}\n" .
                "  {$dirPhraseAr} (فرق ≈ " . number_format(abs($delta)) . " دينار).";

            $reasonsEn[] =
                "• ({$labelEn}) — approx. impact {$pct}%.\n" .
                "  {$txtEn}\n" .
                "  {$dirPhraseEn} (Δ ≈ " . number_format(abs($delta)) . " IQD).";

            $debug['selected_reasons'][] = [
                'feature' => $key,
                'impact_percent' => $pct,
                'current_value' => $value,
                'band_key' => $bandKey,
                'direction' => $direction,
                'delta' => (int) round($delta),
                'cost_after_change' => (int) round($scenarioCost),
            ];
        }

        // fallback إذا ماكو أسباب
        if (empty($reasonsAr)) {
            $reasonsAr[] = "• لم تظهر مؤثرات قوية ضمن العتبة المحددة، وقد تكون الحساسية موزعة بين عدة عوامل.";
            $reasonsEn[] = "• No strong influencers exceeded the selected threshold; sensitivity may be distributed across multiple factors.";
        }

        // ===== Closing paragraph (يربط كلشي بالـ gauge) =====
        $closingAr =
            "بشكل عام، تصنيف الكلفة ({$gaugeLabelAr}) يتوافق مع كون العوامل المسيطرة مرتبطة " .
            "بحالة الرصف والأحمال المرورية وخصائص التربة والمناخ، وهي عوامل تحدد عمق التدخل " .
            "(Surface-level vs Structural) وبالتالي حجم الموارد المطلوبة.";

        $closingEn =
            "Overall, the ({$gaugeLabelEn}) cost classification aligns with dominant factors such as " .
            "pavement condition, heavy-vehicle loading, soil characteristics, and climate severity—" .
            "factors that typically determine intervention depth (surface-level vs structural) and thus required resources.";

        // نلحق الـ closing بالـ summary (حتى يطلع كفقرة رسمية واحدة)
        $summaryAr .= " " . $closingAr;
        $summaryEn .= " " . $closingEn;

        $debug['closing'] = [
            'ar' => $closingAr,
            'en' => $closingEn,
        ];

        return new ExplanationResult(
            summary_ar: $summaryAr,
            summary_en: $summaryEn,
            reasons_ar: $reasonsAr,
            reasons_en: $reasonsEn,
            debug_payload: $debug
        );
    }

    /**
     * يجيب debug row الخاص بميزة معينة
     */
    private function findDebugForFeature(array $debugPayload, string $featureKey): ?array
    {
        foreach ($debugPayload as $d) {
            if (($d['feature'] ?? null) === $featureKey) return $d;
        }
        return null;
    }

    /**
     * يحدد نص هندسي "حسب قيمة العامل الحالية"
     * - Continuous: bands + texts + يضيف القيمة الحالية
     * - Categorical: map حسب الكود
     *
     * @return array [txtAr, txtEn, bandKey]
     */
    private function explainFeature(string $key, array $meta, mixed $value): array
    {
        // ===== Continuous =====
        if (isset($meta['bands']) && is_array($meta['bands'])) {

            $v = is_numeric($value) ? (float)$value : 0.0;

            $bandKey = 'unknown';
            foreach ($meta['bands'] as $b) {
                $max = $b['max'] ?? null;
                if ($max === null) continue;

                // INF مدعوم
                if ($v <= $max) {
                    $bandKey = $b['key'] ?? 'unknown';
                    break;
                }
            }

            $txtAr = $meta['texts'][$bandKey]['ar'] ?? 'هذا العامل قد يؤثر على الكلفة بحسب قيمته الحالية.';
            $txtEn = $meta['texts'][$bandKey]['en'] ?? 'This factor may affect cost depending on its current value.';

            // إضافة رقم القيمة الحالية لشفافية التقرير
            $txtAr .= " (القيمة الحالية: " . number_format($v, 2) . ")";
            $txtEn .= " (current value: " . number_format($v, 2) . ")";

            return [$txtAr, $txtEn, $bandKey];
        }

        // ===== Categorical =====
        $bandKey = is_numeric($value) ? (string)(int)$value : 'unknown';
        $vKey = is_numeric($value) ? (int)$value : null;

        $txtAr = $meta['map'][$vKey]['ar'] ?? 'قيمة هذا العامل تشير إلى حالة قد تغيّر من متطلبات الصيانة.';
        $txtEn = $meta['map'][$vKey]['en'] ?? 'This factor value indicates a condition that may change maintenance requirements.';

        return [$txtAr, $txtEn, $bandKey];
    }

    /**
     * جملة توضح اتجاه التأثير بالاعتماد على delta
     * delta = cost_after_change - base_cost
     */
    private function directionPhrase(string $direction, float $delta): array
    {
        return match ($direction) {
            'increase' => [
                'التغيير في هذا العامل ضمن التحليل أدى إلى **رفع الكلفة** مقارنة بالحالة الحالية، ما يعني أن القيمة الحالية أقل كلفة من بعض البدائل.',
                'Changing this factor (in the sensitivity test) **increased the cost** compared to the current state, meaning the current value is cheaper than some alternatives.',
            ],
            'decrease' => [
                'التغيير في هذا العامل ضمن التحليل أدى إلى **خفض الكلفة** مقارنة بالحالة الحالية، ما يعني أن القيمة الحالية ترفع الكلفة مقارنة ببعض البدائل.',
                'Changing this factor (in the sensitivity test) **decreased the cost** compared to the current state, meaning the current value increases cost relative to some alternatives.',
            ],
            default => [
                'التغيير في هذا العامل لم يسبب فرقاً يُذكر ضمن نطاق الاختبار.',
                'Changing this factor caused no meaningful difference within the tested range.',
            ],
        };
    }
}
