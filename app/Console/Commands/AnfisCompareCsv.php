<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Anfis\AnfisService;

class AnfisCompareCsv extends Command
{
    protected $signature = 'anfis:compare-csv
        {files* : One or more CSV file paths}
        {--output=storage/app/anfis_comparison_all.csv : Output CSV path}';

    protected $description = 'Compare one or more CSV datasets vs ANFIS service predictions and export a single merged CSV with MAPE/RMSE/R² summaries';

    public function handle(): int
    {
        $files = (array) $this->argument('files');
        $outputPath = (string) $this->option('output');

        $anfis = app(AnfisService::class);

        $out = fopen($outputPath, 'w');
        if ($out === false) {
            $this->error("Cannot write output: {$outputPath}");
            return self::FAILURE;
        }

        // Output header (merged)
        fputcsv($out, [
            'dataset',
            'row',
            'actual_cost',
            'predicted_cost',
            'error_actual_minus_pred',
            'abs_pct_err',
        ]);

        $global = $this->newStats();
        $perFileStats = [];

        foreach ($files as $filePath) {
            if (!is_file($filePath)) {
                fclose($out);
                $this->error("File not found: {$filePath}");
                return self::FAILURE;
            }

            $datasetName = pathinfo($filePath, PATHINFO_FILENAME);

            $handle = fopen($filePath, 'r');
            if ($handle === false) {
                fclose($out);
                $this->error("Cannot open file: {$filePath}");
                return self::FAILURE;
            }

            $headers = fgetcsv($handle);
            if (!$headers) {
                fclose($handle);
                fclose($out);
                $this->error("CSV is empty/invalid: {$filePath}");
                return self::FAILURE;
            }

            $headers = array_map(fn($h) => trim((string)$h), $headers);

            $required = [
                'Pavement Area',
                'Pavement Age',
                'Road Condition (PCI)',
                'Asphalt Thickness',
                'Pavement Type',
                'Maintenance Type',
                'Traffic Volume (AADT)',
                'AADT for Heavy-Loaded Vehicles',
                'Road Classification',
                'hts',
                'Soil Strength',
                'Median Islands',
                'Drainage System',
                'cost',
            ];

            $missing = array_values(array_diff($required, $headers));
            if (!empty($missing)) {
                fclose($handle);
                fclose($out);
                $this->error("Missing columns in {$filePath}: " . implode(', ', $missing));
                $this->warn("Headers found: " . implode(' | ', $headers));
                return self::FAILURE;
            }

            $idx = [];
            foreach ($headers as $i => $h) $idx[$h] = $i;

            $fileStats = $this->newStats();
            $rowNo = 0;
            $written = 0;

            $toFloat = fn($v) => (float) str_replace([',', ' '], '', (string)$v);
            $toIntRounded = fn($v) => (int) round($toFloat($v));

            while (($r = fgetcsv($handle)) !== false) {
                $rowNo++;

                if (count($r) < count($headers)) {
                    continue; // skip broken/empty line
                }

                // Read values by header (not by order)
                $pavement_area     = $toFloat($r[$idx['Pavement Area']]);
                $pavement_age      = $toIntRounded($r[$idx['Pavement Age']]);
                $road_condition    = $toIntRounded($r[$idx['Road Condition (PCI)']]);
                $asphalt_thickness = $toFloat($r[$idx['Asphalt Thickness']]);
                $pavement_type     = $toIntRounded($r[$idx['Pavement Type']]);
                $maintenance_type  = $toIntRounded($r[$idx['Maintenance Type']]);
                $traffic_volume    = $toIntRounded($r[$idx['Traffic Volume (AADT)']]);
                $aadt_heavy        = $toIntRounded($r[$idx['AADT for Heavy-Loaded Vehicles']]);
                $road_class        = $toIntRounded($r[$idx['Road Classification']]);
                $hts               = $toFloat($r[$idx['hts']]);
                $soil_strength     = $toIntRounded($r[$idx['Soil Strength']]);
                $median_islands    = $toIntRounded($r[$idx['Median Islands']]);
                $drainage_system   = $toIntRounded($r[$idx['Drainage System']]);

                $actual = $toFloat($r[$idx['cost']]);

                $ordered13 = [
                    (float)$pavement_area,     // V1
                    (int)$pavement_age,        // V2
                    (int)$road_condition,      // V3
                    (float)$asphalt_thickness, // V4
                    (int)$pavement_type,       // V5
                    (int)$maintenance_type,    // V6
                    (int)$traffic_volume,      // V7
                    (int)$aadt_heavy,          // V8
                    (int)$road_class,          // V9
                    (float)$hts,               // V10
                    (int)$soil_strength,       // V11
                    (int)$median_islands,      // V12
                    (int)$drainage_system,     // V13
                ];

                $pred = $anfis->predictCost($ordered13);

                $error = $actual - $pred;
                $absPct = ($actual != 0.0) ? (abs($error) / $actual) * 100.0 : 0.0;

                // write detail row
                fputcsv($out, [
                    $datasetName,
                    $rowNo,
                    (int) round($actual),
                    (int) round($pred),
                    (int) round($error),
                    round($absPct, 2),
                ]);

                // update stats
                $this->statsAdd($fileStats, $actual, $pred);
                $this->statsAdd($global, $actual, $pred);

                $written++;
            }

            fclose($handle);

            $perFileStats[$datasetName] = $fileStats;

            $this->info("Processed {$datasetName}: rows={$rowNo}, written={$written}");
        }

        // Append summaries
        fputcsv($out, []); // empty line
        fputcsv($out, ['SUMMARY']);
        fputcsv($out, ['dataset', 'count', 'MAPE_%', 'RMSE', 'R2']);

        // Per-file summary
        foreach ($perFileStats as $name => $stats) {
            [$mape, $rmse, $r2, $n] = $this->finalizeStats($stats);
            fputcsv($out, [$name, $n, round($mape, 4), (int) round($rmse), round($r2, 6)]);
        }

        // Global summary
        [$mape, $rmse, $r2, $n] = $this->finalizeStats($global);
        fputcsv($out, ['ALL', $n, round($mape, 4), (int) round($rmse), round($r2, 6)]);

        fclose($out);

        $this->info("Done ✅ Output: {$outputPath}");
        return self::SUCCESS;
    }

    // ---------- Stats helpers (MAPE / RMSE / R2) ----------

    private function newStats(): array
    {
        return [
            'n' => 0,
            'sum_abs_pct' => 0.0,
            'sum_sq_err' => 0.0,
            'sum_y' => 0.0,
            'sum_y2' => 0.0,
            'sum_err' => 0.0,
            'sum_pred' => 0.0,
            // for R2 we need SS_res and SS_tot (we compute via sums)
            'ss_res' => 0.0,
            // SS_tot needs mean(y): we can compute from sums after reading all rows
            'ys' => [], // if you prefer no arrays, keep sums only; but arrays not needed
        ];
    }

    private function statsAdd(array &$s, float $actual, float $pred): void
    {
        $err = $actual - $pred;

        $s['n']++;
        $s['sum_sq_err'] += ($err * $err);
        $s['ss_res'] += ($err * $err);

        $s['sum_y'] += $actual;
        $s['sum_y2'] += ($actual * $actual);

        // MAPE
        if ($actual != 0.0) {
            $s['sum_abs_pct'] += (abs($err) / $actual) * 100.0;
        }
    }

    private function finalizeStats(array $s): array
    {
        $n = (int) $s['n'];
        if ($n === 0) {
            return [0.0, 0.0, 0.0, 0];
        }

        $mape = $s['sum_abs_pct'] / $n;
        $rmse = sqrt($s['sum_sq_err'] / $n);

        // R2 = 1 - SS_res / SS_tot
        // SS_tot = sum((y - mean)^2) = sum(y^2) - n * mean^2
        $mean = $s['sum_y'] / $n;
        $ss_tot = $s['sum_y2'] - ($n * $mean * $mean);

        $r2 = ($ss_tot == 0.0) ? 0.0 : (1.0 - ($s['ss_res'] / $ss_tot));

        return [$mape, $rmse, $r2, $n];
    }
}
