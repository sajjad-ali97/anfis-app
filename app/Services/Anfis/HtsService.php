<?php

namespace App\Services\Anfis;

use App\Models\HeatDay;
use Carbon\Carbon;
use RuntimeException;

class HtsService
{
    public function calculate(int $pavementAgeCode, string $maintenanceDate): int
    {
        $yearsSpan = $this->mapAgeToYears($pavementAgeCode);

        $maintenanceYear = (int) Carbon::parse($maintenanceDate)->format('Y');

        $startYear = $maintenanceYear - $yearsSpan;

        if ($startYear < 2000) {
            throw new RuntimeException("HTS range خارج نطاق البيانات المتوفرة.");
        }

        // نجمع السنوات من (startYear + 1) إلى maintenanceYear
        return HeatDay::whereBetween('year', [$startYear + 1, $maintenanceYear])
            ->sum('days_above_40');
    }

    private function mapAgeToYears(int $code): int
    {
        return match ($code) {
            1 => 6,   // New
            2 => 12,  // Medium
            3 => 18,  // Old
            default => throw new RuntimeException("كود عمر الرصف غير صحيح."),
        };
    }
}
