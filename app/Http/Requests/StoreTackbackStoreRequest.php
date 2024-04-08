<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTackbackStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'total_weight' => 'required|integer|min:1',
            'trackback_type_store_customer_warehouse' => 'required', // Add validation for Tackback Type
            'brand_id' => 'required',
            'shipment_id' => 'required',
            'shipping_origin_zipcode' => 'required',
            'shipping_carrier' => 'required',
            'shipping_carrier_name' => 'required', // Add validation for Shipping Carrier Name
            'box_type' => 'required',
            'pallet_weight' => 'required',
            'box_weight'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'trackback_type_store_customer_warehouse.required' => 'The Tackback Type field is required.',
            
            // other custom messages...
        ];
    }
}
