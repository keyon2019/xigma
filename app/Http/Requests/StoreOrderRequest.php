<?php

namespace App\Http\Requests;

use App\Interfaces\CartInterface;
use App\Services\ShippingService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'address_id' => 'required|numeric|exists:addresses,id',
            'shipping_methods' => ['array'],
            'gateway_id' => ['required', 'numeric', Rule::in(array_column(config('gateway'), 'id'))],
            'cost_preference' => ['required', 'numeric', Rule::in(ShippingService::COST_PREFERENCES)]
        ];
    }

}
