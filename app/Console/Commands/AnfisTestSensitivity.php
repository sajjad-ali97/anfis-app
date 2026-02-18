<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\XAI\SensitivityService;

class AnfisTestSensitivity extends Command
{
    protected $signature = 'anfis:test-sensitivity
        {v1} {v2} {v3} {v4} {v5} {v6} {v7}
        {v8} {v9} {v10} {v11} {v12} {v13}';

    protected $description = 'Test SensitivityService using 13 ordered ANFIS inputs (V1..V13)';

    public function handle(): int
    {
        $ordered13 = [];
        for ($i = 1; $i <= 13; $i++) {
            $ordered13[] = (float) $this->argument("v$i");
        }

        // Map feature keys => index inside $ordered13 (0-based)
        // V1..V13 order:
        // 0:V1 area, 1:V2 age, 2:V3 condition, 3:V4 thickness, 4:V5 type, 5:V6 maintenance,
        // 6:V7 traffic, 7:V8 heavy, 8:V9 class, 9:V10 HTS, 10:V11 soil, 11:V12 median, 12:V13 drainage
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

        $service = app(SensitivityService::class);

        // ✅ now returns DTO: SensitivityResult
        $result = $service->analyze($ordered13, $featureIndexes);

        $this->info("======================================");
        $this->info("BASE COST: " . (int) round($result->base_cost));
        $this->info("======================================");

        $this->info("BAR DATA:");
        foreach ($result->bar_data as $row) {
            $this->line($row['label_en'] . " => " . $row['impact_percent'] . "%");
        }

        $this->info("======================================");
        $this->info("TOP INFLUENCERS:");
        foreach ($result->top_influencers as $row) {
            $this->line($row['label_en'] . " => " . $row['impact_percent'] . "%");
        }

        $this->info("======================================");
        $this->info("DEBUG PAYLOAD:");
        $this->line(json_encode($result->debug_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Optional: full payload
        $this->info("======================================");
        $this->info("FULL PAYLOAD (DTO->toArray):");
        $this->line(json_encode($result->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return Command::SUCCESS;
    }
}
