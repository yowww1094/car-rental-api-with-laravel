<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VehicleMaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => ['required', 'string', Rule::in(['entretien', 'videnge'])],
            'garage' => ['required', 'string'],
            'description' => ['string'],
            'price' => ['required', 'numeric'],
            'maintenance_date' => ['required', 'date'],
        ];
    }
}
