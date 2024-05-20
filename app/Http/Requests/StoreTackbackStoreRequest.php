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
           

            'pallet_qty' => 'required|integer|min:1',
            'total_weight' => 'required|integer|min:1',
            'takeback_id' => 'required',
            'brand_id' => 'required',
            'shipment_information_id' => 'required|unique:rd_takeback_shipments,shipment_information_id',
            'shipping_origin_zipcode' => 'required',
            'shipping_carrier' => 'required',
            'shipping_carrier_name' => 'required',
            'shipment_type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'takeback_id.required' => 'The Tackback Type field is required.',
            // other custom messages...
        ];
    }
}
