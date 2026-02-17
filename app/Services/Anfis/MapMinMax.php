<?php

namespace App\Services\Anfis;

use InvalidArgumentException;

class MapMinMax
{
    /**
     * MATLAB mapminmax apply:
     * y = (x - xoffset) .* gain + ymin
     */
    public static function applyVector(array $x, array $gain, array $xoffset, float $ymin, float $yrange): array
    {
        if (count($x) !== count($gain) || count($x) !== count($xoffset)) {
            throw new InvalidArgumentException('PS_in vectors sizes mismatch.');
        }

        $y = [];
        foreach ($x as $i => $v) {
            $y[] = (((float)$v - (float)$xoffset[$i]) * (float)$gain[$i]) + $ymin;
        }
        return $y;
    }

    /**
     * MATLAB mapminmax reverse:
     * x = (y - ymin) ./ gain + xoffset
     */
    public static function reverseScalar(float $y, float $gain, float $xoffset, float $ymin, float $yrange): float
    {
        if ($gain == 0.0) {
            throw new InvalidArgumentException('PS_out gain cannot be zero.');
        }

        return (($y - $ymin) / $gain) + $xoffset;
    }
}
