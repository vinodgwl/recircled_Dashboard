<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- <h1>Admin Dashboard</h1> -->
        {{-- <div class="card"> --}}
            <div class="card-header p-1 mt-2 ">
               <h4 class="new-tackback"> 
                {{-- New Tackback --}}
                {{ __('message.new_tackback') }}
            </h4> 
            </div>
            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('successMessage').style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            </script>
             @endif
            <form method="post" action="{{ route('tackback.store') }}">
                @csrf
                <div class="card-body">
                    <div class="p-3">
                        <div class="row">
                            <label for="exampleFormControlInput1" class="form-label">Tackback Type</label>
                            <div class="col-md-6">
                                @foreach($takebackTypes as $takebackType)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="takeback_id" value="{{ $takebackType->takeback_id }}" id="takeback_type_{{ $takebackType->takeback_id }}" {{ isset($prevois_store_data['takeback_id']) && $prevois_store_data['takeback_id'] == $takebackType->takeback_id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="takeback_type_{{ $takebackType->takeback_id }}">
                                            {{ $takebackType->takeback_name }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('takeback_id')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="is_asn" type="checkbox"  {{ isset($prevois_store_data['is_asn']) && $prevois_store_data['is_asn']  ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">ASN</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="brand_id" class="form-label">Parent Brand</label>
                                <select class="form-select" name="brand_id" aria-label="Default select example">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ isset($prevois_store_data['brand_id']) && $prevois_store_data['brand_id'] == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="shipment_information_id" class="form-label">Shipment ID</label>
                                <input type="text" class="form-control" placeholder="Shipment ID" value="{{ $prevois_store_data['shipment_information_id'] ?? '' }}" name="shipment_information_id">
                                @error('shipment_information_id')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="shipping_origin_zipcode" class="form-label">Shipping origin zipcode</label>
                                <input type="text" class="form-control" placeholder="Zipcode" value="{{ $prevois_store_data['shipping_origin_zipcode'] ?? '' }}" name="shipping_origin_zipcode">
                                @error('shipping_origin_zipcode')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="shipping_carrier" class="form-label">Shipping Carrier</label>
                                <select class="form-select" name="shipping_carrier" aria-label="Default select example">
                                    <option value="">Select Carrier</option>
                                    <option value="fedex" {{ isset($prevois_store_data['shipping_carrier']) && $prevois_store_data['shipping_carrier'] === 'fedex' ? 'selected' : '' }}>Fedex</option>
                                    <option value="other" {{ isset($prevois_store_data['shipping_carrier']) && $prevois_store_data['shipping_carrier'] === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('shipping_carrier')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="shipping_carrier" class="form-label">Shipping Carrier Name</label>
                                <select class="form-select" name="shipping_carrier_name" aria-label="Default select example">
                                    <option value="">Select Carrier Name</option>
                                    @foreach($shippingCarrierTypes as $carrier)
                                        <option value="{{ $carrier->shipping_career_id }}" {{ isset($prevois_store_data['shipping_career_id']) && $prevois_store_data['shipping_career_id'] == $carrier->shipping_career_id ? 'selected' : '' }}>
                                            {{ $carrier->shipping_name  }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shipping_carrier')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="col-md-2">
                                <label for="exampleFormControlInput1"  class="form-label">Shipping Carrier Name</label>
                                <input type="text" class="form-control" placeholder="Name" value="{{ $prevois_store_data['shipping_carrier_name'] ?? '' }}" name="shipping_carrier_name" id="exampleFormControlInput1">
                                @error('shipping_carrier_name')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div> --}}
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1" class="form-label">Type (pallet/Box)</label>
                                <select class="form-select" name="shipment_type" aria-label="Default select example">
                                <option value=""selected>Select</option>
                                    <option value="pallet" {{ old('shipment_type', $prevois_store_data['shipment_type'] ?? '') == 'pallet' ? 'selected' : '' }}>Pallet</option>
                                    <option value="box" {{ old('shipment_type', $prevois_store_data['shipment_type'] ?? '') == 'box' ? 'selected' : '' }}>Box</option>
                                </select>
                                @error('shipment_type')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1"  class="form-label">Quantity</label>
                                <input type="text" class="form-control" placeholder="Quantity" value="{{ old('pallet_qty', $prevois_store_data['pallet_qty'] ?? '') }}"  name="pallet_qty" id="exampleFormControlInput1">
                                 @error('pallet_qty')
                                <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1"  class="form-label">Total Weight(lbs)</label>
                                <input type="text" class="form-control" placeholder="Total Weight" value="{{ old('total_weight', $prevois_store_data['total_weight'] ?? '') }}" name="total_weight" id="exampleFormControlInput1">
                                 @error('total_weight')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                           {{-- <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Shipping Carrier Name</label>
                                <input type="text" class="form-control" name="shipment_information_id" id="exampleFormControlInput1">
                            </div> --}}
                        </div>
                    </div>
            </div>
        {{-- </div> --}}
        <div class="p-4">
           <div class="row ">
            <div class="col-auto d-flex set-create-btn">
                <div class="me-2">
                    <a href="{{ route('tackback.stores.cancel') }}" class="btn btn-secondary create-store-btn-size" style="background-color: #ffffff; color: #000000;">
                        {{-- Cancel --}}
                         {{ __('message.cancel') }}
                    </a>
                </div>
                <button type="submit" class="btn btn-secondary create-store-btn-size">
                    {{-- Next --}}
                    {{ __('message.next') }}
                </button>
            </div>
        </div>

        </div>
         </form>
    </div>
@endsection

