<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- <h1>Admin Dashboard</h1> -->
        <div class="card">
            <div class="card-header">
                Tackback Products
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
            <form method="post" action="{{ route('trackbackProduct.store') }}">
                @csrf
                <div class="card-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trackback_product_type" value="Warehouse Bulk" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Warehouse Bulk
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="trackback_product_type" value="Customer Tackback" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Customer Tackback
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="asn" type="checkbox">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">ASN</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1" class="form-label">Brand</label>
                                <select class="form-select" name="brand_id" aria-label="Default select example">
                                    <option value="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                {{-- <option selected>Select Product</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option> --}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Shipment ID</label>
                                <input type="text" class="form-control" name="shipment_id" id="exampleFormControlInput1">
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Quantity</label>
                                <input type="text" class="form-control" name="quantity" id="exampleFormControlInput1">
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Total Weight(kg)</label>
                                <input type="text" class="form-control" name="total_weight" id="exampleFormControlInput1">
                            </div>
                        </div>
                    </div>
                    <h4>Enter Products</h4>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1" class="form-label">Product</label>
                                <select name="products[][name]" class="form-select" aria-label="Default select example">
                                    <option selected>Select Product</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1" class="form-label">Weight</label>
                                <input type="text" name="products[][weight]" class="form-control" id="exampleFormControlInput1">
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1" class="form-label">Quantity</label>
                                <input type="text" name="products[][quantity]" class="form-control" id="exampleFormControlInput1">
                            </div>
                            <div class="col-md-2">
                                <label for="exampleFormControlInput1" class="form-label">Gender</label>
                                <select name="products[][gender]" class="form-select" aria-label="Default select example">
                                    <option selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                            <label for="exampleFormControlInput1" class="form-label">Good Resale Condition</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="products[][good_resale_condition]" type="checkbox" id="inlineCheckbox1" value="1">
                                <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-2 mt-3">
                            <!-- <button type="button" class="btn btn-secondary">Add</button> -->
                            <button type="button" class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add
                            </button>
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
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <!-- <th>#</th> -->
                    <th>Product</th>
                    <th>Gender</th>
                    <th>Quantity</th>
                    <th>Weight</th>
                    <th>Resale Condition</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @endforeach -->
                    {{-- <tr>
                        <td>Shirt</td>
                        <td>Male</td>
                        <td>02</td>
                        <td>42 Kg</td>
                        <td>True</td>
                        <td><a href="#" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                         <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td>Jeans</td>
                        <td>Male</td>
                        <td>12</td>
                        <td>02 Kg</td>
                        <td>True</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr> --}}
            </tbody>
        </table>
        <div class="p-4">
            <div class="row justify-content-center">
            <div class="col-auto">
                <button type="button" class="btn btn-secondary me-2">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
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
