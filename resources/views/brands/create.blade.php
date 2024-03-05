<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
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

        <!-- <h1>Admin Dashboard</h1> -->
        <form method="post" action="{{ route('brand.store') }}" enctype="multipart/form-data">
            @csrf
        <div class="card">
            <div class="card-header">
                New Parent Brand
            </div>
            <div class="card-body">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Upload Logo:</label>
                                <input type="file" name="logo_image" class="form-control" id="logo">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" id="exampleFormControlInput1">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" placeholder="Enter Contact" id="exampleFormControlInput1">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" id="exampleFormControlInput1">
                        </div>
                         <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone" id="exampleFormControlInput1">
                        </div>
                    </div>
                </div>
                 <div class="p-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Address</label>
                            <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="1"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">City</label>
                            <input type="text" name="city" class="form-control" id="exampleFormControlInput1">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">State</label>
                            <input type="text" name="state" class="form-control" id="exampleFormControlInput1">
                        </div> 
                    </div>
                </div>
                <div class="p-2">
                    <div class="row">
                         <label for="exampleFormControlInput1" class="form-label">Tackback Type</label>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="takeback_type[]" value="warehouse" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label"  for="inlineCheckbox1">Warehouse Bulk</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="takeback_type[]" value="customer" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox2">Customer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="takeback_type[]" value="store" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">Store</label>
                                </div>
                        </div>
                    </div>
                </div>
                 <div class="p-2">
                    <div class="row">
                         <label for="exampleFormControlInput1" class="form-label">Preferred Shipping</label>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="preferred_shipping[]" value="fedex" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label"  for="inlineCheckbox1">Fedex</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="preferred_shipping[]" value="dhl" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label"  for="inlineCheckbox2">DHL</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="preferred_shipping[]" value="trac" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label"  for="inlineCheckbox1">On-trac</label>
                                </div>
                                 <div class="form-check form-check-inline">
                                <input class="form-check-input" name="preferred_shipping[]" value="carriers"  type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">R+L carriers</label>
                                </div>
                                 <div class="form-check form-check-inline">
                                <input class="form-check-input" name="preferred_shipping[]" value="Pitney"  type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">Pitney Bowes</label>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <div class="row">
                         <label for="exampleFormControlInput1" class="form-label">Tackback Type</label>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="have_sub_brands" value="0" type="checkbox" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Have Sub Brands</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <div class="row">
                         <label for="exampleFormControlInput1" class="form-label">Select Categories</label>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="parent_categories[]" value="apparels" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">Apparels</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="parent_categories[]" value="footwear" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox2">Footwear</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="parent_categories[]" value="accessories" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">Accessories</label>
                                </div>
                                 <div class="form-check form-check-inline">
                                <input class="form-check-input" name="parent_categories[]" value="handbags" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">Handbags</label>
                                </div>
                                 <div class="form-check form-check-inline">
                                    <input class="form-check-input"  name="parent_categories[]" value="beauty"  type="checkbox" id="inlineCheckbox1" value="option1">
                                    <label class="form-check-label" for="inlineCheckbox1">Beauty</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="parent_categories[]" value="equipmment" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox2">Equipment</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" name="parent_categories[]" value="luggage" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox2">Luggage</label>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form> -->
            </div>
        </div>
        <div class="p-4">
            <div class="row justify-content-center">
            <div class="col-auto">
                <button type="button" class="btn btn-danger me-2">Cancel</button>
                <button type="submit" class="btn btn-secondary">Save Brand</button>
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
