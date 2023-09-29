<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleInsuranceRequest extends FormRequest
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
            'number' => ['required', 'numeric', 'unique:vehicle_insurances'],
            'agence' => ['required', 'string'],
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date'],
            'price' => ['required', 'numeric'],
        ];
    }
}
