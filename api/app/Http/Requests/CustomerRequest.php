<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'first_name' => ['required','string', 'max:255'],
            'last_name' => ['required','string', 'max:255'],
            'email' => ['string', 'max:255', 'email', 'unique:customers'],
            'phone' => ['required','numeric', 'max_digits:10', 'min_digits:10'],

            'cin' => ['required','alpha_num', 'max:15', 'unique:customer_cins'],
            'cin_image_front' => ['image', 'mimes:jpeg,png'],
            'cin_image_back' => ['image', 'mimes:jpeg,png'],

            'driver_licence' => ['required','alpha_num', 'max:50', 'unique:customer_driver_licences'],
            'driver_licence_image_front' => ['image', 'mimes:jpeg,png'],
            'driver_licence_image_back' => ['image', 'mimes:jpeg,png'],
        ];
    }
}
