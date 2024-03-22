<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <div class="card "> --}}
            <div class="card-header">
                <div class="mt-2 set-btn-alingments">
                 <a href="{{ route('tackbackStore.box.palllet-detail', ['pallet_id' => $StorePallet->id, 'tackback_store_id' => $StorePallet->tackback_store_id ]) }}" class="btn btn-secondary">
                        Back
                 </a>
               </div>
               <div class="mt-2 set-btn-alingments">
               All Tackback / Shipment ID: {{$storesList->shipment_id}} / Pallet ID: {{$StorePallet->pallet_unique_id}}/Box ID:
                {{$singleBoxDetail->box_unique_id }}
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
                                <h4 class="fw-bold mb-2">Box ID: {{$singleBoxDetail->box_unique_id}}</h4>
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
                                <label class="form-check-label" for="flexRadioDefault1">Box weight:</label>
                                <span class="fw-bold">{{$singleBoxDetail->box_weight}}</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                                <span class="fw-bold"> {{$singleBoxDetail->created_store_box_date_time}}</span>
                            </div>
                        </div>
                    </div>
                        <div class="row" style="padding-left: 15px;">
                        
                            {{-- <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Pallet weight:</label>
                                <span class="fw-bold">43</span>
                            </div> --}}
                            {{-- <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Opened Pallet:</label>
                                <span class="fw-bold"></span>
                            </div> --}}
                           <div class="col-md-2">
                                    <label for="exampleFormControlInput1" class="form-label">Box Packaging Weight</label>
                                    <input type="text" name="box_weight" placeholder="weight" class="form-control" id="box_weight">
                                    @error('box_weight')
                                    <span class="alert text-danger error-required-msg">{{ $message }}</span>
                                    @enderror
                                    <span class="text-danger error-required-msg custom-error" id="boxWeightError" style="display: none;">Weight field is required and it should be greater than 0</span>
                            </div>
                        </div>
                        <form id="myForm" method="post" action="{{ route('tackbackStore.box.product.save') }}">
                            @csrf
                            <div class="row mt-3" style="padding-left: 15px; margin-bottom: 36px;">
                                <div class="col-md-12">
                                    <h5 class="fw-bold">Enter Products</h5>
                                </div>
                                <div class="p-4">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="exampleFormControlInput1" class="form-label">Product</label>
                                            <select name="product_name" class="form-select" aria-label="Default select example">
                                                <option selected value="">Select Product</option>
                                                <option value="cloth">Cloth</option>
                                                <option value="jeans">Jeans</option>
                                                <option value="dress">Dress</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="exampleFormControlInput1" class="form-label">Tier</label>
                                            <select name="product_tier" class="form-select" aria-label="Default select example">
                                                <option selected value="">Select Tier</option>
                                                <option value="tier-1">Tier-1</option>
                                                <option value="tier-2">Tier-2</option>
                                                <option value="tier-3">Tier-3</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="exampleFormControlInput1" class="form-label">Quantity</label>
                                            <input type="text" name="product_quantity" class="form-control" id="exampleFormControlInput1">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="exampleFormControlInput1" class="form-label">Weight</label>
                                            <input type="text" name="product_weight" class="form-control" id="exampleFormControlInput1">
                                        </div>
                                        
                                        <div class="col-md-2 mt-2">
                                        <label for="exampleFormControlInput1" class="form-label">Good Resale Condition</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="good_resale_condition" type="checkbox" id="inlineCheckbox1" value="1">
                                            <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-3">
                                        <!-- <button type="button" class="btn btn-secondary">Add</button> -->
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="bi bi-plus"></i> Add
                                        </button>
                                        </div>
                                    </div>
                                </div>
                               <input type="hidden" name="shipment_id" id="shipment_id" value="{{ $storesList->shipment_id }}">
                                <input type="hidden" name="box_id" id="box_id" value="{{$singleBoxDetail->id }}">
                                <input type="hidden" name="store_pallet_id" id="box_id" value="{{$StorePallet->id }}">
                            </div>
                        </form>
                </div>
        {{-- </div> --}}
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Tier</th>
                    <th>Quantity</th>
                    <th>Weight(lbs)</th>
                    <th>Resale Condition</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                  @foreach ($productBoxList as $box)
                    <tr>
                        <td>{{ $box->product_name }}</td>
                        <td>{{$box->product_tier  }}</td>
                        <td>{{ $box->product_quantity }} lbs</td>
                         <td>{{$box->product_weight}}</td>
                         <td>@if ($box->good_resale_condition == 0)
                              No
                            @else
                             Yes
                            @endif</td>
                       <td style="display: flex; color: {{ $box->status == 0 ? 'red' : 'black' }}">
                            @if ($box->status == 0)
                              <i class="bi bi-chevron-right status-icons"></i>
                            @else
                                    Opened <i class="bi bi-pencil" style="color: #9d8787"></i> <i class="bi bi-trash" style="color: #9d8787"></i> <i class="bi bi-chevron-right status-icons"></i>
                            @endif
                        </td>
                    </tr>
                    {{-- <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->id }}"> --}}
                @endforeach 
                @if ($productBoxList->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No record Found</td>
                </tr>
                @endif 
                {{-- <tr>
                    <td>Shirt</td>
                    <td>Tier-1</td>
                    <td>04</td>
                    <td>12</td>
                    <td>-</td>
                    <td class="text-danger"><i class="bi bi-pencil" style="color: #9d8787"></i>  <i class="bi bi-trash delete-icons"></i></td>
                </tr> 
                
                <tr>
                    <td>Jeans</td>
                    <td>Tier-3</td>
                    <td>01</td>
                    <td>14</td>
                    <td>-</td>
                    <td class="text-danger"><i class="bi bi-pencil" style="color: #9d8787"></i>  <i class="bi bi-trash delete-icons"></i></td>
                </tr> --}}
            </tbody>
        </table>
        {{-- model for update box --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="myForm" method="post" >
                
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Update Box</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="row">
                            <div class="col-md-4">
                                Pallet ID: <span class="fw-bold" id="palletId"></span>
                            </div>

                            <div class="col-md-4">
                                Pallet Weight: <span class="fw-bold" id="palletWeight"></span>
                            </div>
                            <div class="col-md-4">
                                Sub Brands: <span class="fw-bold" id="subBrands"></span>
                            </div>

                        </div> --}}
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label for="boxQuantity" class="form-label">Box Weight (lbs)</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="boxboxQuantity" class="form-control" id="boxQuantity">
                            </div>
                                <span class="text-danger error-required-msg custom-error" id="errorMessage" style="display: none;">Quantity field is required and it should be greater than 0</span>
                            
                        </div>
                        <input type="hidden" name="storeId" id="storeId">
                        <div class="row mt-4">
                            <div id="materialFields">
                                <div class="row mb-3 material-field">
                                    
                                    <div class="col-md-6">
                                        <label for="exampleFormControlInput1" class="form-label">Product Category</label>
                                        <select name="product_category" id="product_category" class="form-select" aria-label="Default select example">
                                            <option selected value="">Select Product</option>
                                            <option value="cloth">Clothes</option>
                                            <option value="plastic">Plastic</option>
                                            <option value="wood">Wood</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="exampleFormControlInput1" class="form-label">Pre Consumer</label>
                                        <select name="pre_consumer" id="pre_consumer" class="form-select" aria-label="Default select example">
                                            <option selected value="">Select Gender</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Update</button>
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
                    '<div class="col">' +
                    '<select class="form-select" name="material_type[]">' +
                    '<option value="">Material Type</option>' +
                    '<option value="paper">Paper</option>' +
                    '<option value="wood">Wood</option>' +
                    '<option value="plastic">Plastic</option>' +
                    '<option value="shrink-wrap">Shrink-Wrap</option>'+
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
        $(document).ready(function() {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var boxId = button.data('box-id');
            var box_weight = button.data('box_weight');
            var productCategory = button.data('product-category');
            var preConsumer = button.data('pre_consumer');
            // $('#palletId').text(palletId);
            // $('#palletWeight').text(palletWeight);
            // $('#subBrands').text(subBrands);
            // $('#storeId').text(storeId);
            alert(boxId);
            $(this).find('#storeId').val(storeId);
        });
        });
        
        function validateForm() {
        var boxWeight = document.getElementsByName("box_weight")[0].value;
        var productCategory = document.getElementsByName("product_category")[0].value;
        var preConsumer = document.getElementsByName("pre_consumer")[0].value;
        
        var isValid = true;
        
        // Validate box weight
        if (!boxWeight || isNaN(boxWeight) || boxWeight <= 0) {
            document.getElementById("boxWeightError").innerText = "Please enter box weight and it should be greater than 0.";
            document.getElementById("boxWeightError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("boxWeightError").style.display = "none";
        }
        
        // Validate product category
        if (productCategory =="") {
            document.getElementById("productCategoryError").innerText = "Please select product category.";
            document.getElementById("productCategoryError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("productCategoryError").style.display = "none";
        }
        
        // Validate pre consumer
        if (preConsumer == "") {
            document.getElementById("preConsumerError").innerText = "Please select pre consumer.";
            document.getElementById("preConsumerError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("preConsumerError").style.display = "none";
        }
        // return;
        // If all fields are valid, submit the form
        if (isValid) {
            document.getElementById("myForm").submit();
        }
    }
    function deletePalletBox($id){
        alert($id);
        // document.getElementById("boxform").submit();
        if (confirm('Are you sure you want to delete this box?')) {
            document.getElementById("boxform").submit();
        }
    }
    function clearBoxQuantityData (){
        conole.log('ok')
    }
    </script>
@endpush

<style>
    .status-icons {
    background-color: #E8E8E8;
    color: #000000;
    padding: 8px 7px;
}
.error-required-msg {
    padding-left: 0px !important;
}
.delete-icons{
    background-color: #E8E8E8;
    padding: 8px; 
    color: #000000;
    margin-left: 5px;
    
}
.edit-icons {
    /* background-color: #E8E8E8; */
    padding: 2px; 
    color: #000000;
    margin-left: 44px;
}
/* .custom-error {
    margin-left: 141px;
    margin-top: 3px;
} */
.set-btn-alingments {
    margin-left: 17px;
}
</style>