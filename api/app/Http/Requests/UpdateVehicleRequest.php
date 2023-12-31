<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
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
            'model' => ['required', 'alpha_num'],
            'model_year' => ['date'],
            'vignette' => ['required', 'date'],
            'vehicle_image' => ['image', 'mimes:jpeg,png'],
            'manufacturer_id' => ['required'],

            'mileage' => ['required', 'numeric'],
        ];
    }
}
