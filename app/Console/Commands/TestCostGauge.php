<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Anfis\CostGaugeService;

class TestCostGauge extends Command
{
    protected $signature = 'anfis:test-gauge
                            {cost : Total cost in IQD}
                            {area : Pavement area in m²}';

    protected $description = 'Test CostGaugeService (cost / area classification)';

    public function handle(): int
    {
        $cost = (float) $this->argument('cost');
        $area = (float) $this->argument('area');

        try {

            $result = app(CostGaugeService::class)
                ->evaluate($cost, $area);

            $this->info("Cost: " . number_format($cost));
            $this->info("Area: " . number_format($area));
            $this->line("------------------------------------");

            $this->info("A (Cost per m²): " . number_format($result->a, 2));
            $this->info("Label Key: {$result->label_key}");
            $this->info("Label: {$result->label}");

            $this->line("------------------------------------");
            $this->info("Range Used:");
            $this->line("Min: {$result->range_used['min']}");
            $this->line("Max: {$result->range_used['max']}");
            $this->line("Color: {$result->range_used['color']}");

            $this->line("------------------------------------");
            $this->info("Gauge Min: {$result->min}");
            $this->info("Gauge Max: {$result->max}");

            $this->line("------------------------------------");
            $this->info("All Ranges:");

            foreach ($result->ranges as $range) {
                $this->line(
                    "{$range['key']} | {$range['label']} | {$range['min']} - {$range['max']}"
                );
            }

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
