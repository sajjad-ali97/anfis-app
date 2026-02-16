<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'pavement_area'     => ['required', 'numeric', 'min:0'],
            'asphalt_thickness' => ['required', 'numeric', 'min:0'],


            // Coded selects
            'pavement_age'      => ['required', 'in:1,2,3'],   // 1 New, 2 Medium, 3 Old
            'median_islands'    => ['required', 'in:0,1'],     // 1 Exist, 0 None
            'road_class'        => ['required', 'in:1,2'],     // 1 Main, 2 Secondary
            'road_condition'    => ['required', 'in:1,2,3'],   // 1 Fair, 2 Poor, 3 Very Poor
            'aadt_heavy'        => ['required', 'in:1,2,3'],   // 1 Low, 2 Medium, 3 High
            'drainage_system'   => ['required', 'in:0,1'],     // 1 Exist, 0 None
            'maintenance_type'  => ['required', 'in:1,2,3'],   // 1 Preventive, 2 Routine, 3 Emergency
            'soil_strength'     => ['required', 'in:1,2,3'],   // 1 Weak, 2 Medium, 3 Strong
            'pavement_type'     => ['required', 'in:1,2'],     // 1 Asphalt, 2 Mix
            'traffic_volume'    => ['required', 'in:1,2,3'],   // 1 Low, 2 Medium, 3 High
        ];
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


    protected function prepareForValidation(): void
    {
        // يضمن أن قيم السيليكت 0/1 تنقري كأرقام
        $this->merge([
            'median_islands'  => $this->median_islands !== null ? (int) $this->median_islands : null,
            'drainage_system' => $this->drainage_system !== null ? (int) $this->drainage_system : null,
        ]);
    }

    protected function getRedirectUrl()
    {
        return url()->previous() . '#inputs';
    }
}
