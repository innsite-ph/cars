<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
             'vin' => 'required|unique:cars',
            'license_plate'=> 'required|unique:cars',
            'brand'=> 'required',
            'model'=> 'required',
            'gearbox_type'=> 'required',
            'colour'=> 'required',
            'fuel_type'=> 'required',
            'engine_capacity'=> 'required',
            'power'=> 'required',
            'engine_code'=> 'required|unique:cars',
            'car_year'=> 'required'
        ];
    }
}
