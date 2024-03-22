<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <div class="card "> --}}
            <div class="card-header">
                <div class="mt-2 set-btn-alingments">
                 <a href="{{ route('admin.stores.saveList') }}" class="btn btn-secondary">
                        Back
                 </a>
               </div>
               <div class="mt-2 set-btn-alingments">
                 All Tackback / Shipment ID: {{$storesList->shipment_id}}
               </div>
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
           
                <div class="card-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fw-bold mb-2">Shipment ID: {{$storesList->shipment_id}}</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Brand:</label>
                                <span class="fw-bold">{{$storesList->brand->name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Tackback Type:</label>
                                <span class="fw-bold">{{$storesList->trackback_product_store_type}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Total Pallet:</label>
                                <span class="fw-bold">{{$storesList->quantity}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Opened Pallet:</label>
                                <span class="fw-bold">{{$status1Count}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Total Weight</label>
                                <span class="fw-bold">{{$storesList->total_weight}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                                <span class="fw-bold"> {{\Carbon\Carbon::parse($storesList->created_store_date_time)->format('d/m/y h:i:s A')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
        {{-- </div> --}}
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
                 @foreach ($StorePallet as $store)
                    <tr>
                        <td>{{ $store->id }}</td>
                        <td>{{$store->pallet_unique_id }}</td>
                        <td>{{ $store->pallet_weight }} lbs</td>
                         <td>{{$store->store_sub_brand}}</td>
                         <td>--</td>
                         {{-- <td>{{ $store->status_1_count + $store->status_0_count }} ({{$store->status_1_count}}/{{ $store->status_1_count + $store->status_0_count }})</td> --}}
                       {{-- <td style="color: {{ $store->status == 0 ? 'red' : 'black' }}">
                            @if ($store->status == 0)
                              
                                    Unopened <i class="bi bi-chevron-right status-icons"></i>
                            @else
                                    Opened <i class="bi bi-chevron-right status-icons"></i>
                            @endif
                        </td> --}}
                        <td style="color: {{ $store->status == 0 ? 'red' : 'black' }}" class="status-icons">
                            @if ($store->status == 0)
                            Unopened
                                <a data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-store-id="{{ $store->id }}"
                                data-pallet-id="{{ $store->pallet_unique_id }}"
                                data-pallet-weight="{{ $store->pallet_weight }}"
                                data-sub-brands="{{ $store->store_sub_brand }}"
                                href="#" onclick="clearBoxQuantityData(event)">
                                    <i class="bi bi-chevron-right status-icons"></i>
                                </a>
                            @else
                            Opened
                                <a data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-store-id="{{ $store->id }}"
                                data-pallet-id="{{ $store->pallet_unique_id }}"
                                data-pallet-weight="{{ $store->pallet_weight }}"
                                data-sub-brands="{{ $store->store_sub_brand }}"
                                href="#" onclick="clearBoxQuantityData(event)">
                                     <i class="bi bi-chevron-right status-icons"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->id }}">
                @endforeach 
                @if ($StorePallet->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No record Found</td>
                </tr>
                @endif
                {{-- <tr>
                    <td>01</td>
                    <td>TBK65JHRTYUU</td>
                    <td>102</td>
                    <td>Weekday</td>
                    <td>-</td>
                    <td class="text-danger">Unopned <i class="bi bi-arrow-right"></i></td>
                </tr> 
                
                <tr>
                    <td>06</td>
                    <td>TBK69JHEERTERT</td>
                    <td>54</td>
                    <td>H & M Home</td>
                    <td>-</td>
                    <td class="text-danger">Unopened <a href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="bi bi-arrow-right"></i></a></td>
                </tr>--}}
            </tbody>
        </table>
        <div  class="pagination-container d-flex justify-content-between align-items-center">
        <div></div>
            <div  style="
            justify-content: center;
        "id="defaultPagination" class="pagination">
                {{ $StorePallet->links('pagination::bootstrap-4') }}
            </div>
            <div style="flex-direction: end;align-items: end;display: flex;">
                <span id="paginationInfo" class="ms-3">
                Showing {{ $StorePallet->firstItem() }} - {{ $StorePallet->lastItem() }} of {{ $StorePallet->total() }}
            </span>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="myForm" method="post" action="{{ route('tackbackStore.box.creates') }}">
                @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Add Pallet Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                Pallet ID: <span class="fw-bold" id="palletId"></span>
                            </div>

                            <div class="col-md-4">
                                Pallet Weight: <span class="fw-bold" id="palletWeight"></span>
                            </div>
                            <div class="col-md-4">
                                Sub Brands: <span class="fw-bold" id="subBrands"></span>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <label for="boxQuantity" class="form-label">Box Quantity</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="boxboxQuantity" class="form-control" id="boxQuantity">
                            </div>
                                <span class="text-danger error-required-msg custom-error" id="errorMessage" style="display: none;">Quantity field is required and it should be greater than 0</span>
                            
                        </div>
                        <input type="hidden" name="storeId" id="storeId">
                        <h4 class="mt-4 fw-bold">Pallet Packaging Material</h4>
                        <div class="row mt-4">
                            <div id="materialFields">
                                <div class="row mb-3 material-field">
                                    
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">Material Type:</label>
                                        <select class="form-select" name="material_type[]">
                                            <option value="">material type</option>
                                            <option value="paper">Paper</option>
                                            <option value="wood">Wood</option>
                                            <option value="plastic">Plastic</option>
                                            <option value="shrink-wrap">Shrink-Wrap</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">Material weight (lbs)</label>
                                        <input type="number" class="form-control" name="material_weight[]"
                                            placeholder="Weight">
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-danger cancel-btn" type="button" style="background-color: transparent; border: none;">
                                            <i class="bi bi-x" style="font-size: 1.5rem;"></i>
                                        </button>

                                        {{-- <button class="btn btn-danger cancel-btn" type="button">
                                            <i class="bi bi-x"></i>
                                        </button> --}}
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
                        <button type="submit" class="btn btn-secondary">Save & Continue</button>
                    </div>
                </div>
            </div>
             </form>
        </div>
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
                    '<div class="col-md-4">' +
                    '<select class="form-select" name="material_type[]">' +
                    '<option value="">Material Type</option>' +
                    '<option value="paper">Paper</option>' +
                    '<option value="wood">Wood</option>' +
                    '<option value="plastic">Plastic</option>' +
                    '<option value="shrink-wrap">Shrink-Wrap</option>'+
                    '</select>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<input type="number" class="form-control" name="material_weight[]" placeholder="Weight">' +
                    '</div>' +
                    '<div class="col-auto">' +
                     '<button class="btn cancel-btn" type="button" style="background-color: transparent; border: none;">' +
                        '<i class="bi bi-x" style="font-size: 1.5rem;"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>';
                $('#materialFields').append(newMaterialField);
            });

            // Dynamically added cancel button event handler
            $('#materialFields').on('click', '.cancel-btn', function() {
                $(this).closest('.material-field').remove();
            });
        });
        $(document).ready(function() {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var storeId = button.data('store-id');
            var palletId = button.data('pallet-id');
            var palletWeight = button.data('pallet-weight');
            var subBrands = button.data('sub-brands');
            $('#palletId').text(palletId);
            $('#palletWeight').text(palletWeight);
            $('#subBrands').text(subBrands);
            // $('#storeId').text(storeId);
            // alert(storeId);
            $(this).find('#storeId').val(storeId);
        });
        });
        
        document.addEventListener('DOMContentLoaded', function() {
        // Get the form element
        var form = document.getElementById('myForm');

        // Add event listener for form submission
        form.addEventListener('submit', function(event) {

            var errorMessage = document.getElementById('errorMessage');
            var boxQuantityInput = document.getElementById('boxQuantity');

            // Function to display the error message
            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
            }

            // Function to hide the error message
            function hideError() {
                errorMessage.style.display = 'none';
            }
            // Perform client-side validation here if needed
            var boxQuantity = document.getElementById('boxQuantity').value;
            if (!boxQuantity || isNaN(boxQuantity) || boxQuantity <= 0) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Optionally, display an error message to the user greater
                // alert('Please enter a valid number for Box Quantity.');
                //  showError('Quantity field is required and must be at least 1');
                showError('Quantity field is required and it should be greater than 0');
                // Keep the modal open
                event.stopPropagation();
            } else {
                hideError();
              //  document.getElementById("myForm").reset(); // Replace "myForm" with the id of your form
            }
        });
    });
    function clearBoxQuantityData(){
        document.getElementById("myForm").reset();
    }
    </script>
@endpush

<style>
    .status-icons {
    background-color: #E8E8E8; 
    padding: 2px; 
    color: #000000;
    margin-left: 35px;
}
.error-required-msg {
    padding-left: 0px !important;
}
.custom-error {
    margin-left: 141px;
    margin-top: 3px;
}
.set-btn-alingments {
    margin-left: 17px;
}
</style>