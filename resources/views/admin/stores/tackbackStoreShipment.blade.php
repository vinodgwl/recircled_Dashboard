<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card ">
            <div class="card-header">
                Tackback Products / Shipment ID: TBK65JHRTYUU
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
                                <h4 class="fw-bold mb-2">Shipment ID: TBK65JHRTYUU</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Brand:</label>
                                <span class="fw-bold">H & M</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Tackback Type:</label>
                                <span class="fw-bold">Store</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Total Pallet:</label>
                                <span class="fw-bold">13</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Opened Pallet:</label>
                                <span class="fw-bold">54</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Total Weight</label>
                                <span class="fw-bold">1200 lbs</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                                <span class="fw-bold"> 06/03/24 07:52:52 AM</span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Pallet No.</th>
                    <th>Pallet Id</th>
                    <th>Weight lbs</th>
                    <th>Sub brands</th>
                    <th>Opened/Total Box</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>TBK65JHRTYUU</td>
                    <td>102</td>
                    <td>Weekday</td>
                    <td>-</td>
                    <td class="text-danger">Unopned <i class="bi bi-arrow-right"></i></td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>TBK65JHRTERT</td>
                    <td>101</td>
                    <td>Arket</td>
                    <td>-</td>
                    <td class="text-danger">Unopened <a href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="bi bi-arrow-right"></i></a></td>
                </tr>
                <tr>
                    <td>03</td>
                    <td>TBK65JHRRTTRT</td>
                    <td>76</td>
                    <td>Cos</td>
                    <td>-</td>
                    <td class="text-danger">Unopened <a href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="bi bi-arrow-right"></i></a></td>
                </tr>
                <tr>
                    <td>04</td>
                    <td>TBK69JHEERTERT</td>
                    <td>54</td>
                    <td>H & M Home</td>
                    <td>-</td>
                    <td class="text-danger">Unopened <a href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="bi bi-arrow-right"></i></a></td>
                </tr>
                <tr>
                    <td>05</td>
                    <td>TBK65JHRRTTRT</td>
                    <td>76</td>
                    <td>Cos</td>
                    <td>-</td>
                    <td class="text-danger">Unopened <a href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="bi bi-arrow-right"></i></a></td>
                </tr>
                <tr>
                    <td>06</td>
                    <td>TBK69JHEERTERT</td>
                    <td>54</td>
                    <td>H & M Home</td>
                    <td>-</td>
                    {{-- <td class="text-danger">Unopened <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-arrow-right"></i></a></td> --}}
                    <td class="text-danger">Unopened <a href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="bi bi-arrow-right"></i></a></td>
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
                        <button type="button" class="btn btn-secondary">Save & Continue</button>
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

<style>
</style>