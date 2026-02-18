<?php

namespace App\Services\Anfis;


use App\DTOs\CostGaugeResult;
use RuntimeException;

class CostGaugeService
{
    public function evaluate(float $cost, float $area): CostGaugeResult
    {
        if ($area <= 0) {
            throw new RuntimeException('Area must be greater than zero.');
        }

        $a = round($cost / $area, 2);

        $ranges = $this->getRanges();

        $rangeUsed = $this->determineRange($a, $ranges);

        return new CostGaugeResult(
            a: $a,
            label_key: $rangeUsed['key'],
            label: $rangeUsed['label'],
            range_used: [
                'min' => $rangeUsed['min'],
                'max' => $rangeUsed['max'],
                'color' => $rangeUsed['color'],
            ],
            ranges: $ranges,
            min: $ranges[0]['min'],
            max: end($ranges)['max'],
        );
    }

    private function getRanges(): array
    {
        $locale = app()->getLocale();
        $configRanges = config('cost_gauge.ranges');

        return array_map(function ($r) use ($locale) {
            return [
                'key' => $r['key'],
                'label' => $locale === 'ar' ? $r['ar'] : $r['en'],
                'min' => (int) $r['min'],
                'max' => (int) $r['max'],
                'color' => $r['color'],
            ];
        }, $configRanges);
    }

    private function determineRange(float $a, array $ranges): array
    {
        foreach ($ranges as $range) {
            if ($a >= $range['min'] && $a < $range['max']) {
                return $range;
            }
        }

        // أقل من أول رينج
        if ($a < $ranges[0]['min']) {
            return $ranges[0];
        }

        // أعلى من آخر رينج
        return $ranges[count($ranges) - 1];
    }
}
