<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card ">
            <div class="card-header">
                Tackback Products / Shipment ID: TBK65JHRTYUU / Pallet ID: TBK65PLDTRO-P01
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('successMessage').style.display = 'none';
                    }, 3000); // 3000 milliseconds = 3 seconds
                </script>
            @endif
            <form method="post" action="{{ route('trackbackProduct.update.stores') }}">
                @csrf
                <div class="card-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fw-bold mb-2">Pallet ID: TBK65PLDTRO-P01</h4> 
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Parent Brand:</label>
                                <span class="fw-bold">H & M</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Sub Brand:</label>
                                <span class="fw-bold">Weekday</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Teckback Type:</label>
                                <span class="fw-bold">store</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Pallet Weight</label>
                                <span class="fw-bold">54 lbs</span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                                <span class="fw-bold"> 06/03/24 07:52:52 AM</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Total Box Quantity</label>
                                <span class="fw-bold">42</span> <a href="#" class="edit-icon"><i class="bi bi-pencil-square"></i></a>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Opened Box</label>
                                <span class="fw-bold">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fw-bold mb-2">Add New Box</h4> 
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1" class="form-label">Weight</label>
                                <input type="text" name="products[][weight]" placeholder="Weight" class="form-control" id="exampleFormControlInput1">
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1" class="form-label">Product Category</label>
                                <select name="products[][name]" class="form-select" aria-label="Default select example">
                                    <option selected>Select Product</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1" class="form-label">Pre Consumer</label>
                                <select name="products[][gender]" class="form-select" aria-label="Default select example">
                                    <option selected>Select Consumer</option>
                                    <option value="no">No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-4 justify-content-center">
                            <!-- <button type="button" class="btn btn-secondary">Add</button> -->
                            <button type="button" class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Box No.</th>
                    <th>Box Id</th>
                    <th>Box Weight (lbs)</th>
                    <th>Type of Product</th>
                    <th>Pre Consumer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>TBK65JHRTYUU-B01</td>
                    <td>2</td>
                    <td>Clothes</td>
                    <td>Yes</td>
                    <td class="text-danger">
                        Unopned 
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-pencil"></i> <!-- Edit Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-trash"></i> <!-- Delete Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-arrow-right"></i> <!-- Anchor Tag -->
                        </a>
                    </td>

                </tr>
                <tr>
                    <td>02</td>
                    <td>TBK65JHRTYUU-B02</td>
                    <td>3</td>
                    <td>Clothes</td>
                    <td>No</td>
                    <td class="text-danger">
                        Unopned 
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-pencil"></i> <!-- Edit Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-trash"></i> <!-- Delete Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-arrow-right"></i> <!-- Anchor Tag -->
                        </a>
                    </td>
                </tr>
               <tr>
                    <td>03</td>
                    <td>TBK65JHRTYUU-B03</td>
                    <td>6</td>
                    <td>Clothes</td>
                    <td>Yes</td>
                    <td class="text-danger">
                        Unopned 
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-pencil"></i> <!-- Edit Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-trash"></i> <!-- Delete Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-arrow-right"></i> <!-- Anchor Tag -->
                        </a>
                    </td>
                </tr>
              <tr>
                    <td>04</td>
                    <td>TBK65JHRTYUU-B61</td>
                    <td>2</td>
                    <td>Clothes</td>
                    <td>Yes</td>
                    <td class="text-danger">
                        Unopned 
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-pencil"></i> <!-- Edit Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-trash"></i> <!-- Delete Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-arrow-right"></i> <!-- Anchor Tag -->
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>05</td>
                    <td>TBK65JHRTYUU-B06</td>
                    <td>2</td>
                    <td>Clothes</td>
                    <td>No</td>
                    <td class="text-danger">
                        Unopned 
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-pencil"></i> <!-- Edit Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-trash"></i> <!-- Delete Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-arrow-right"></i> <!-- Anchor Tag -->
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>06</td>
                    <td>TBK65JHRTYUU-B09</td>
                    <td>2</td>
                    <td>Clothes</td>
                    <td>Yes</td>
                    <td class="text-danger">
                        Unopned 
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-pencil"></i> <!-- Edit Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-trash"></i> <!-- Delete Icon -->
                        </a>
                        <a href="#" class="text-decoration-none mx-1">
                            <i class="bi bi-arrow-right"></i> <!-- Anchor Tag -->
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Pallet Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                Pallet ID: <span class="fw-bold" id="palletId">TBK69JHEERTERT</span>
                            </div>

                            <div class="col-md-4">
                                Pallet Weight: <span class="fw-bold" id="palletWeight">102 lbs</span>
                            </div>
                            <div class="col-md-4">
                                Sub Brands: <span class="fw-bold" id="subBrands">Weekday</span>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <label for="boxQuantity" class="form-label">Box Quantity</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="boxQuantity">
                            </div>
                        </div>
                        <h3 class="mt-3">Pallet Packaging Material</h3>
                        <div class="row mt-4">
                            <div id="materialFields">
                                <div class="row mb-3 material-field">
                                    <div class="col">
                                        <select class="form-select" name="material_type[]">
                                            <option value="Type1">Material Type</option>
                                            <option value="Type2">Type2</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" name="material_weight[]"
                                            placeholder="Weight">
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-danger cancel-btn" type="button">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Dynamic material fields will be added here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-6 text-left"> <!-- This column takes up half of the width -->
                            <button style="margin-left: -149px" type="button" id="addMaterialBtn"
                                class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add New Material
                            </button>
                        </div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-secondary">Save & Continue plaller</button>
                    </div>
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
        $(document).ready(function() {
            $('#addMaterialBtn').click(function() {
                var newMaterialField = '<div class="row mb-3 material-field">' +
                    '<div class="col">' +
                    '<select class="form-select" name="material_type[]">' +
                    '<option value="Type1">Material Type</option>' +
                    '<option value="Type2">Type2</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col">' +
                    '<input type="number" class="form-control" name="material_weight[]" placeholder="Weight">' +
                    '</div>' +
                    '<div class="col-auto">' +
                    '<button class="btn btn-danger cancel-btn" type="button"><i class="bi bi-x"></i></button>' +
                    '</div>' +
                    '</div>';

                $('#materialFields').append(newMaterialField);
            });

            // Dynamically added cancel button event handler
            $('#materialFields').on('click', '.cancel-btn', function() {
                $(this).closest('.material-field').remove();
            });
        });
    </script>
@endpush
