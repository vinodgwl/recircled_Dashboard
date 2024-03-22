<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- <h1>Admin Dashboard</h1> -->
        {{-- <div class="card"> --}}
            <div class="card-header p-1 mt-2 ">
               <h4> New Tackback</h4> 
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
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trackback_product_store_type" value="Warehouse Bulk" id="flexRadioDefault1" {{ isset($prevois_store_data['trackback_product_store_type']) &&$prevois_store_data['trackback_product_store_type'] === 'Warehouse Bulk' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Warehouse Bulk
                                    </label>
                                </div>
                                @error('trackback_product_store_type')
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trackback_product_store_type" value="Customer" id="flexRadioDefault1" {{ isset($prevois_store_data['trackback_product_store_type']) &&$prevois_store_data['trackback_product_store_type'] === 'Customer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Customer
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trackback_product_store_type" value="Store" id="flexRadioDefault1" {{ isset($prevois_store_data['trackback_product_store_type']) && $prevois_store_data['trackback_product_store_type'] === 'Store' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Store
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="asn" type="checkbox"  {{ isset($prevois_store_data['asn']) && $prevois_store_data['asn']  ? 'checked' : '' }}>
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
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="shipment_id" class="form-label">Shipment ID</label>
                                <input type="text" class="form-control" placeholder="Shipment ID" value="{{ $prevois_store_data['shipment_id'] ?? '' }}" name="shipment_id">
                                @error('shipment_id')
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="shipping_origin_zipcode" class="form-label">Shipping origin zipcode</label>
                                <input type="text" class="form-control" placeholder="Zipcode" value="{{ $prevois_store_data['shipping_origin_zipcode'] ?? '' }}" name="shipping_origin_zipcode">
                                @error('shipping_origin_zipcode')
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
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
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1"  class="form-label">Shipping Carrier Name</label>
                                <input type="text" class="form-control" placeholder="Name" value="{{ $prevois_store_data['shipping_carrier_name'] ?? '' }}" name="shipping_carrier_name" id="exampleFormControlInput1">
                                @error('shipping_carrier_name')
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1" class="form-label">Type (pallet/Box)</label>
                                <select class="form-select" name="type" aria-label="Default select example">
                                <option value=""selected>Select</option>
                                    <option value="pallet" {{ old('type', $prevois_store_data['type'] ?? '') == 'pallet' ? 'selected' : '' }}>Pallet</option>
                                    <option value="box" {{ old('type', $prevois_store_data['type'] ?? '') == 'box' ? 'selected' : '' }}>Box</option>
                                </select>
                                @error('type')
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1"  class="form-label">Quantity</label>
                                <input type="text" class="form-control" placeholder="Quantity" value="{{ old('quantity', $prevois_store_data['quantity'] ?? '') }}"  name="quantity" id="exampleFormControlInput1">
                                 @error('quantity')
                                <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1"  class="form-label">Total Weight(lbs)</label>
                                <input type="text" class="form-control" placeholder="Total Weight" value="{{ old('total_weight', $prevois_store_data['total_weight'] ?? '') }}" name="total_weight" id="exampleFormControlInput1">
                                 @error('total_weight')
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                           {{-- <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Shipping Carrier Name</label>
                                <input type="text" class="form-control" name="shipment_id" id="exampleFormControlInput1">
                            </div> --}}
                        </div>
                    </div>
            </div>
        {{-- </div> --}}
        <div class="p-4">
           <div class="row ">
            <div class="col-auto d-flex setBtn">
                <div class="me-2">
                    <a href="{{ route('tackback.stores.cancel') }}" class="btn btn-secondary store-btn-size" style="background-color: #ffffff; color: #000000;">Cancel</a>
                </div>
                <button type="submit" class="btn btn-secondary store-btn-size">Next</button>
            </div>
        </div>

        </div>
         </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
<style>
    .setBtn{
        margin-left: 750px;
    }
    .store-btn-size {
        padding: 7px 30px !important;
    }
    .error-required-msg{
        padding-left: 0px !important;
    }
</style>
