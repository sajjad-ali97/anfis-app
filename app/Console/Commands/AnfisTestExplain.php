<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Anfis\AnfisService;
use App\Services\Anfis\CostGaugeService;
use App\Services\XAI\SensitivityService;
use App\Services\XAI\ExplanationService;

class AnfisTestExplain extends Command
{
    protected $signature = 'anfis:test-explain
        {v1} {v2} {v3} {v4} {v5} {v6} {v7}
        {v8} {v9} {v10} {v11} {v12} {v13}';

    protected $description = 'Full ANFIS pipeline test (Cost + Gauge + Sensitivity + Explanation)';

    public function handle(): int
    {
        // ===== Collect ordered inputs =====
        $ordered13 = [];
        for ($i = 1; $i <= 13; $i++) {
            $ordered13[] = (float) $this->argument("v$i");
        }

        // ===== 1) Predict cost =====
        $anfis = app(AnfisService::class);
        $cost = $anfis->predictCost($ordered13);

        // ===== 2) Gauge =====
        $area = $ordered13[0];
        $gauge = app(CostGaugeService::class)
            ->evaluate($cost, $area);

        // ===== 3) Sensitivity =====
        $featureIndexes = [
            'pavement_area'     => 0,
            'pavement_age'      => 1,
            'road_condition'    => 2,
            'asphalt_thickness' => 3,
            'pavement_type'     => 4,
            'maintenance_type'  => 5,
            'traffic_volume'    => 6,
            'aadt_heavy'        => 7,
            'hts'               => 9,
            'soil_strength'     => 10,
        ];

        $sensitivity = app(SensitivityService::class)
            ->analyze($ordered13, $featureIndexes);

        // ===== 4) Prepare associative inputs =====
        $inputsAssoc = [
            'pavement_area'     => $ordered13[0],
            'pavement_age'      => (int)$ordered13[1],
            'road_condition'    => (int)$ordered13[2],
            'asphalt_thickness' => $ordered13[3],
            'pavement_type'     => (int)$ordered13[4],
            'maintenance_type'  => (int)$ordered13[5],
            'traffic_volume'    => (int)$ordered13[6],
            'aadt_heavy'        => (int)$ordered13[7],
            'hts'               => $ordered13[9],
            'soil_strength'     => (int)$ordered13[10],
        ];

        // ===== 5) Explanation =====
        $explanation = app(ExplanationService::class)
            ->generate($gauge, $sensitivity, $inputsAssoc);

        // ===============================
        // OUTPUT
        // ===============================

        $this->info("======================================");
        $this->info("TOTAL COST: " . number_format($cost));
        $this->info("======================================");

        $this->info("Gauge Level: " . $gauge->label_key);
        $this->info("A (Cost per m²): " . number_format($gauge->a, 2));
        $this->info("======================================");

        $this->info("Top Influencers:");
        foreach ($sensitivity->top_influencers as $row) {
            $this->line(
                $row['label_en'] . " => " . $row['impact_percent'] . "%"
            );
        }

        $this->info("======================================");
        $this->info("EXPLANATION (AR):");
        $this->line($explanation->summary_ar);
        foreach ($explanation->reasons_ar as $r) {
            $this->line($r);
        }

        $this->info("======================================");
        $this->info("EXPLANATION (EN):");
        $this->line($explanation->summary_en);
        foreach ($explanation->reasons_en as $r) {
            $this->line($r);
        }

        return Command::SUCCESS;
    }
}
