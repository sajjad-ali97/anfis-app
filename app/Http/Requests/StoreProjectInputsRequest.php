<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreProjectInputsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // أو اربطها بصلاحيات لاحقاً
    }

    public function rules(): array
    {
        return [
            // Numeric inputs
            'pavement_area'     => ['required', 'numeric', 'gt:0'],
            'asphalt_thickness' => ['required', 'numeric', 'gt:0'],



            // Coded selects
            'pavement_age'     => ['required', 'integer', Rule::in(config('anfis.codes.pavement_age'))],
            'median_islands'   => ['required', 'integer', Rule::in(config('anfis.codes.binary'))],
            'road_class'       => ['required', 'integer', Rule::in(config('anfis.codes.road_class'))],
            'road_condition'   => ['required', 'integer', Rule::in(config('anfis.codes.road_condition'))],
            'aadt_heavy'       => ['required', 'integer', Rule::in(config('anfis.codes.aadt_heavy'))],
            'drainage_system'  => ['required', 'integer', Rule::in(config('anfis.codes.binary'))],
            'maintenance_type' => ['required', 'integer', Rule::in(config('anfis.codes.maintenance_type'))],
            'soil_strength'    => ['required', 'integer', Rule::in(config('anfis.codes.soil_strength'))],
            'pavement_type'    => ['required', 'integer', Rule::in(config('anfis.codes.pavement_type'))],
            'traffic_volume'   => ['required', 'integer', Rule::in(config('anfis.codes.traffic_volume'))],

        ];
    }
    protected function prepareForValidation(): void
    {
        $fields = [
            'pavement_age',
            'road_condition',
            'pavement_type',
            'maintenance_type',
            'traffic_volume',
            'aadt_heavy',
            'road_class',
            'soil_strength',
            'median_islands',
            'drainage_system',
        ];

        $data = [];
        foreach ($fields as $f) {
            $data[$f] = $this->input($f) !== null ? (int) $this->input($f) : null;
        }

        $this->merge($data);
    }



    public function attributes(): array
    {
        return [
            'pavement_area' => __('ui.inputs.pavement_area'),
            'pavement_age' => __('ui.inputs.pavement_age'),
            'median_islands' => __('ui.inputs.median_islands'),
            'asphalt_thickness' => __('ui.inputs.asphalt_thickness'),
            'hts' => __('ui.inputs.hts'),
            'road_class' => __('ui.inputs.road_class'),
            'road_condition' => __('ui.inputs.road_condition'),
            'aadt_heavy' => __('ui.inputs.aadt_heavy'),
            'drainage_system' => __('ui.inputs.drainage_system'),
            'maintenance_type' => __('ui.inputs.maintenance_type'),
            'soil_strength' => __('ui.inputs.soil_strength'),
            'pavement_type' => __('ui.inputs.pavement_type'),
            'traffic_volume' => __('ui.inputs.traffic_volume'),
        ];
    }




    protected function getRedirectUrl()
    {
        return url()->previous() . '#inputs';
    }
}
