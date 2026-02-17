<?php

namespace App\Services\Anfis;

use RuntimeException;

class FisParser
{
    public static function fromFile(string $path): FisModel
    {
        if (!is_file($path)) {
            throw new RuntimeException("FIS file not found: {$path}");
        }

        $text = file_get_contents($path);
        if ($text === false) {
            throw new RuntimeException("Unable to read FIS file: {$path}");
        }

        return self::fromString($text);
    }

    public static function fromString(string $fis): FisModel
    {
        $lines = preg_split("/\R/", $fis);

        $system = [];
        $inputs = []; // [inputIndex => [mfIndex => ['type'=>..., 'params'=>[...] ]]]
        $outputLinear = []; // [ruleIndex => params(14)]
        $rules = []; // [ruleIndex => ['in'=>[mfIdx...], 'out'=>outIdx, 'weight'=>1.0]]

        $section = null;
        $currentInput = null;

        foreach ($lines as $raw) {
            $line = trim($raw);
            if ($line === '') continue;

            if (preg_match('/^\[(.+)\]$/', $line, $m)) {
                $section = $m[1];
                $currentInput = null;

                if (preg_match('/^Input(\d+)$/', $section, $im)) {
                    $currentInput = (int)$im[1];
                    $inputs[$currentInput] = [];
                }
                continue;
            }

            // System key=val
            if ($section === 'System') {
                if (strpos($line, '=') !== false) {
                    [$k, $v] = array_map('trim', explode('=', $line, 2));
                    $system[$k] = trim($v, "'");
                }
                continue;
            }

            // Inputs: MFk='name':'gauss2mf',[params...]
            if ($currentInput !== null) {
                if (preg_match("/^MF(\d+)=.*:'([^']+)',\[(.+)\]$/", $line, $m)) {
                    $mfIndex = (int)$m[1];
                    $type = $m[2];
                    $params = array_map('floatval', preg_split('/\s+|,/', trim($m[3])));
                    $inputs[$currentInput][$mfIndex] = [
                        'type' => $type,
                        'params' => $params,
                    ];
                }
                continue;
            }

            // Output1: MFk='name':'linear',[14 params]
            if ($section === 'Output1') {
                if (preg_match("/^MF(\d+)=.*:'([^']+)',\[(.+)\]$/", $line, $m)) {
                    $outIndex = (int)$m[1];
                    $type = $m[2]; // linear
                    $params = array_map('floatval', preg_split('/\s+|,/', trim($m[3])));
                    $outputLinear[$outIndex] = $params;
                }
                continue;
            }

            // Rules
            if ($section === 'Rules') {
                // مثال: 1 1 1 ... 1, 1 (1) : 1
                if (preg_match('/^(.+),\s*(\d+)\s*\(([\d\.]+)\)\s*:\s*(\d+)$/', $line, $m)) {
                    $inPart = trim($m[1]);
                    $outIdx = (int)$m[2];
                    $weight = (float)$m[3];
                    $andOr = (int)$m[4];

                    $inIdxs = array_map('intval', preg_split('/\s+/', trim($inPart)));

                    $rules[] = [
                        'in' => $inIdxs,
                        'out' => $outIdx,
                        'weight' => $weight,
                        'andor' => $andOr, // نتوقع 1
                    ];
                }
                continue;
            }
        }

        return new FisModel($system, $inputs, $outputLinear, $rules);
    }
}
