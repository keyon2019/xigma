<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'description' => 'string',
            'price' => 'required|numeric',
            'special_price' => 'numeric',
            'splash' => 'numeric',
            'is_huge' => 'boolean',
            'preorderable' => 'boolean',
            'daily_production_capacity' => 'nullable|numeric',
            'onesie' => 'boolean',
            'special_price_expiration' => 'date',
            'show' => 'boolean',
            'en_name' => 'string',
            'weight' => 'numeric',
            'width' => 'numeric',
            'height' => 'numeric',
            'depth' => 'numeric',
        ];
    }
}
