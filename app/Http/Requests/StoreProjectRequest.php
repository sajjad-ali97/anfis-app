<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
        // لاحقاً نربطها بالـ policies اذا صار عندك users وصلاحيات
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:150'],
            'governorate'      => ['required', 'string', 'max:80'],
            'road_name'        => ['required', 'string', 'max:150'],
            'maintenance_date' => ['required', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title'            => __('ui.project_title'),
            'governorate'      => __('ui.governorate'),
            'road_name'        => __('ui.road_name'),
            'maintenance_date' => __('ui.maintenance_date'),
        ];
    }
    protected function getRedirectUrl()
    {
        return url()->previous() . '#create-project';
    }
}
