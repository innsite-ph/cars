<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'car_id' => 'required',
            'user_id' => 'required',
            'check_in_date' => 'required|date_format:Y-m-d H:i:s',
            'check_out_date' => 'required|date_format:Y-m-d H:i:s'
        ];
    }
}
