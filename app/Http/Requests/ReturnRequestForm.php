<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReturnRequestForm extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => 'required|numeric|exists:orders,id',
            'variation_id' => 'required|numeric|exists:variations,id',
            'quantity' => 'required|numeric',
            'reason' => 'required|numeric',
            'elaboration' => 'required|string',
            'enquiry' => 'required|numeric',
            'images' => 'required|min:1',
            'images.*' => 'file|mimes:jpeg,jpg,png'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            "message" => $validator->errors()->first() ?? __('validation.general'),
            "errors" => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
}
