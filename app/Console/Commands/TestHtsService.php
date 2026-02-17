<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Anfis\HtsService;
use App\Models\HeatDay;
use Carbon\Carbon;

class TestHtsService extends Command
{
    protected $signature = 'anfis:test-hts {age : 1/2/3} {date : YYYY-MM-DD}';

    protected $description = 'Test HtsService::calculate and print yearly breakdown of heat_days';

    public function handle(): int
    {
        $age  = (int) $this->argument('age');
        $date = (string) $this->argument('date');

        try {
            $maintenanceYear = (int) Carbon::parse($date)->format('Y');

            $yearsSpan = match ($age) {
                1 => 6,
                2 => 12,
                3 => 18,
                default => throw new \RuntimeException("كود عمر الرصف غير صحيح."),
            };

            $startYear = $maintenanceYear - $yearsSpan;

            if ($startYear < 2000) {
                throw new \RuntimeException("HTS range خارج نطاق البيانات المتوفرة.");
            }

            $fromYear = $startYear + 1;
            $toYear   = $maintenanceYear;

            $this->info("Age code: {$age}");
            $this->info("Maintenance date: {$date}");
            $this->line("------------------------------------");
            $this->info("Range: {$fromYear} .. {$toYear} (years count = " . ($toYear - $fromYear + 1) . ")");
            $this->line("------------------------------------");

            // Breakdown per year
            $rows = HeatDay::whereBetween('year', [$fromYear, $toYear])
                ->orderBy('year')
                ->get(['year', 'days_above_40']);

            $manualSum = 0;

            foreach ($rows as $r) {
                $this->line("Year {$r->year} => {$r->days_above_40} days");
                $manualSum += (int) $r->days_above_40;
            }

            $this->line("------------------------------------");
            $this->info("Manual SUM(days_above_40): {$manualSum}");

            // Service result
            $serviceSum = app(HtsService::class)->calculate($age, $date);
            $this->info("Service HTS: {$serviceSum}");

            if ($manualSum === $serviceSum) {
                $this->info("✅ MATCH");
            } else {
                $this->error("❌ MISMATCH (manual != service)");
            }

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
