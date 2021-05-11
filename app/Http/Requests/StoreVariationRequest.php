<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariationRequest extends FormRequest
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
            'name' => 'required|string',
            'sku' => 'string',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'points' => 'numeric',
            'splash' => 'numeric',
            'options' => 'array'
        ];
    }
}
