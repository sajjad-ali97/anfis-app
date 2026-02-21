<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuickAnalysisController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('pages.quick-analysis', [
                'cost' => null,
            ]);
        }

        $validated = $request->validate([
            'maintenance_date'  => ['required', 'date'], // ضروري لـ HTS حسب كودك
            'pavement_area'     => ['required', 'numeric', 'min:0'],
            'pavement_age'      => ['required', 'integer', 'in:1,2,3'],
            'median_islands'    => ['nullable', 'in:0,1'],
            'asphalt_thickness' => ['required', 'numeric', 'min:0'],
            'road_class'        => ['required', 'integer', 'in:1,2'],
            'road_condition'    => ['required', 'integer', 'in:1,2,3'],
            'aadt_heavy'        => ['required', 'integer', 'in:1,2,3'],
            'drainage_system'   => ['nullable', 'in:0,1'],
            'maintenance_type'  => ['required', 'integer', 'in:1,2,3'],
            'soil_strength'     => ['required', 'integer', 'in:1,2,3'],
            'pavement_type'     => ['required', 'integer', 'in:1,2'],
            'traffic_volume'    => ['required', 'integer', 'in:1,2,3'],
        ]);

        $validated['median_islands']   = (int)($validated['median_islands'] ?? 0);
        $validated['drainage_system']  = (int)($validated['drainage_system'] ?? 0);

        // 1) HTS
        $hts = app(\App\Services\Anfis\HtsService::class)
            ->calculate((int) $validated['pavement_age'], $validated['maintenance_date']);

        // 2) ترتيب الـ 13
        $ordered13 = [
            (float) $validated['pavement_area'],      // Var1
            (int)   $validated['pavement_age'],       // Var2
            (int)   $validated['road_condition'],     // Var3
            (float) $validated['asphalt_thickness'],  // Var4
            (int)   $validated['pavement_type'],      // Var5
            (int)   $validated['maintenance_type'],   // Var6
            (int)   $validated['traffic_volume'],     // Var7
            (int)   $validated['aadt_heavy'],         // Var8
            (int)   $validated['road_class'],         // Var9
            (float) $hts,                             // Var10
            (int)   $validated['soil_strength'],      // Var11
            (int)   $validated['median_islands'],     // Var12
            (int)   $validated['drainage_system'],    // Var13
        ];

        // 3) حساب الكلفة
        $cost = app(\App\Services\Anfis\AnfisService::class)->predictCost($ordered13);

        return redirect()
            ->route('quick.analysis')
            ->withInput()
            ->with('cost', $cost);
    }
}
