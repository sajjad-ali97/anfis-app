<?php

namespace App\Services\Anfis;

use InvalidArgumentException;

class AnfisService
{
    /**
     * يدخل: ordered13 raw بنفس ترتيب:
     * Var1  = Pavement Area
     * Var2  = Pavement Age
     * Var3  = Road Condition PCI
     * Var4  = Asphalt Thickness
     * Var5  = Pavement Type
     * Var6  = Maintenance Type
     * Var7  = Traffic Volume AADT
     * Var8  = AADT Heavy-Loaded Vehicles
     * Var9  = Road Classification
     * Var10 = HTS
     * Var11 = Soil Strength
     * Var12 = Median Islands
     * Var13 = Drainage System
     *
     * يطلع: Maintenance Cost
     */
    public function predictCost(array $ordered13): float
    {
        $pavementArea     = (float) $ordered13[0];
        $pavementAge      = (float) $ordered13[1];
        $roadCondition    = (float) $ordered13[2];
        $asphaltThickness = (float) $ordered13[3];
        $pavementType     = (float) $ordered13[4];
        $maintenanceType  = (float) $ordered13[5];
        $trafficVolume    = (float) $ordered13[6];
        $heavyLoadedAadt  = (float) $ordered13[7];
        $roadClass        = (float) $ordered13[8];
        $hts              = (float) $ordered13[9];
        $soilStrength     = (float) $ordered13[10];
        $medianIslands    = (float) $ordered13[11];
        $drainageSystem   = (float) $ordered13[12];
        $cost =
            10676.0697 * $pavementArea
            - 1300.3137 * ($pavementArea * $soilStrength)
            + 1256.9190 * ($pavementArea * $pavementAge)
            - 257.3673 * ($pavementArea * $asphaltThickness)
            + 1263.7963 * ($pavementArea * $heavyLoadedAadt)
            + 1249.5076 * ($pavementArea * $trafficVolume)
            + 1218.2262 * ($pavementArea * $roadCondition)
            + 1361.1376 * ($pavementArea * $maintenanceType)
            + 5.4635 * ($pavementArea * $hts)
            - 1210.9035 * ($pavementArea * $roadClass)
            + 1039.4221 * ($pavementArea * $pavementType)
            - (8.9799 * pow(10, -8)) * pow($pavementArea, 3)
            + 0.0073 * (pow($pavementArea, 2) * $pavementType)
            + 1146.6459 * ($pavementArea * $drainageSystem)
            + 1192.4844 * ($pavementArea * $medianIslands)
            - 0.0020 * (pow($pavementArea, 2) * $maintenanceType)
            - 41.5244 * pow($asphaltThickness, 2);

        return round($cost, 2);
    }
}
