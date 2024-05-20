<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <div class="card "> --}}
             <div class="card-header">
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                Sorting / Shipment ID: {{$storesList->shipment_information_id}} / Pallet ID-: {{$StorePallet->pallet_gen_code}} / Box ID-: {{
                    $singleBoxDetail->box_gen_code
                }}
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                 <a href="{{ route('admin.stores.shipment-detail', ['id' => $StorePallet->shipment_id  ]) }}" class="btn btn-secondary">
                       <i class="bi bi-arrow-left"></i>
                 </a>
                 <span> Open Box</span>
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                   ID: {{$singleBoxDetail->box_gen_code}}
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
                                <h4 class="fw-bold mb-2">Box Details</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Brand:</label>
                                <span class="fw-bold">{{$storesList->brand->name}}</span>
                            </div>
                             <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Sub Brand:</label>
                                <span class="fw-bold">{{$StorePallet->sub_brand}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Tackback Type:</label>
                                <span class="fw-bold">{{$storesList->takebackType->takeback_name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Box weight:</label>
                                <span class="fw-bold">{{$singleBoxDetail->box_weight}}</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                                <span class="fw-bold"> {{$singleBoxDetail->created_at}}</span>
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
                           <div class="col-md-3">
                                    <label for="exampleFormControlInput1" class="form-label">Box Packaging Weight</label>
                                    <span class="fw-bold">{{ $singleBoxDetail->box_weight}}</span>
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
                                                <option value="1">Cloth</option>
                                                <option value="2">Jeans</option>
                                                <option value="3">Dress</option>
                                            </select>
                                            @error('product_name')
                                            <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="exampleFormControlInput1" class="form-label">Tier</label>
                                            <select name="product_tier" class="form-select" aria-label="Default select example">
                                                <option selected value="">Select Tier</option>
                                                <option value="1">Tier-1</option>
                                                <option value="2">Tier-2</option>
                                                <option value="3">Tier-3</option>
                                            </select>
                                            @error('product_tier')
                                            <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="exampleFormControlInput1" class="form-label">Quantity</label>
                                            <input type="text" name="product_quantity" class="form-control" id="exampleFormControlInput1">
                                            @error('product_quantity')
                                            <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label for="exampleFormControlInput1" class="form-label">Weight</label>
                                            <input type="text" name="product_weight" class="form-control" id="exampleFormControlInput1">
                                            @error('product_weight')
                                            <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                            @enderror
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
                                <input type="hidden" name="box_id" id="box_id" value="{{$singleBoxDetail->box_id }}">
                                <input type="hidden" name="pallet_id" id="box_id" value="{{$StorePallet->pallet_id }}">
                                <input type="hidden" name="brand_id" id="brand_id" value="{{$StorePallet->brand_id}}">
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
                  @foreach ($productBoxList as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{$product->product_tier  }}</td>
                        <td>{{ $product->product_quantity }} lbs</td>
                         <td>{{$product->product_weight}}</td>
                         <td> @if ($product->good_resale_condition == 1)
                                <i class="bi bi-check-lg text-success fs-4"></i>
                            @else
                                <i class="bi bi-x-lg text-danger"></i>
                            @endif
                        </td>
                       {{-- <td style="display: flex; color: {{ $product->status == 0 ? 'red' : 'black' }}">
                            <i class="bi bi-pencil product-product-list-status-icons" style="color: #9d8787"></i> <i class="bi bi-trash product-product-list-status-icons" style="color: #9d8787"></i></i>
                        </td> --}}
                        <td style="display: flex;">
                        <a style="margin-top: 9px" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-product-id="{{ $product->box_product_id  }}"
                                data-product-name="{{ $product->product_name }}"
                                data-product-tier="{{ $product->product_tier }}"
                                data-product-quantity="{{ $product->product_quantity }}"
                                data-product_weight="{{ $product->product_weight }}"
                                data-good-resale-condition="{{ $product->good_resale_condition }}"
                                 onclick="clearBoxQuantityData(event)">
                                    <i class="bi bi-pencil pallet-box-added-edit-icons"></i>
                       </a>  <form id="boxform" action="{{ route('tackbackStore.box.product.delete', $product->box_product_id ) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="margin-top:2px;" type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete this box?')">
                                        <i class="bi bi-trash pallet-box-added-delete-icons"></i>
                                    </button>
                                    {{-- <a onclick="deletePalletBox({{$box->id}})">
                                        <i class="bi bi-trash pallet-box-added-delete-icons"></i>
                                    </a> --}}
                                </form>  
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
                    <td class="text-danger"><i class="bi bi-pencil" style="color: #9d8787"></i>  <i class="bi bi-trash box-product-list-delete-icons"></i></td>
                </tr> 
                
                <tr>
                    <td>Jeans</td>
                    <td>Tier-3</td>
                    <td>01</td>
                    <td>14</td>
                    <td>-</td>
                    <td class="text-danger"><i class="bi bi-pencil" style="color: #9d8787"></i>  <i class="bi bi-trash box-product-list-delete-icons"></i></td>
                </tr> --}}
            </tbody>
        </table>
        <div class="p-4">
            <div class="row justify-content-end">
                <div class="col-auto">
                    {{-- <a href="{{ route('admin.stores.create') }}" class="btn btn-secondary me-2">Back</a> --}}
                    <button type="button" onclick="showToastr()" class="btn btn-secondary me-2 pallet-generate-setBtnColor">Cancel</button>
                    <a href="{{ route('admin.stores.shipment-detail', ['id' => $StorePallet->shipment_id  ]) }}" id="submitBtn" class="btn btn-secondary box-product-list-save-btn">Save</a>
                    <button type="button" id="saveAndOpenBtn" data-route="{{ route('admin.tackbackStore.pallet-open-next-box', ['pallet_id' => $StorePallet->pallet_id, 'box_id' => $singleBoxDetail->box_id]) }}" onclick="saveAndOpenNextBox()" class="btn btn-secondary">Save & Open Next Box</button>
                </div>
             </div>
        </div>
       {{-- model for update box --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="myForm" method="post" action="{{ route('tackbackStore.box.product-updated') }}">
                @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Update Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Product</label>
                                <select name="product_name" id="productName" class="form-select" aria-label="Default select example">
                                    <option selected value="">Select Product</option>
                                    <option value="cloth">Cloth</option>
                                    <option value="jeans">Jeans</option>
                                    <option value="dress">Dress</option>
                                </select>
                                @error('product_name')
                                <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Tier</label>
                                <select name="product_tier" id="productTier" class="form-select" aria-label="Default select example">
                                    <option selected value="">Select Tier</option>
                                    <option value="tier-1">Tier-1</option>
                                    <option value="tier-2">Tier-2</option>
                                    <option value="tier-3">Tier-3</option>
                                </select>
                                @error('product_tier')
                                <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="exampleFormControlInput1" class="form-label">Quantity</label>
                                <input type="text" name="product_quantity" id="productQuantity" class="form-control" id="exampleFormControlInput1">
                                @error('product_quantity')
                                <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                           
                        </div>
                        {{-- <input type="hidden" name="shipment_id" id="shipment_id"> --}}
                        <input type="hidden" name="productId" id="productId">
                        <div class="row mt-4">
                            <div id="materialFields">
                                <div class="row mb-3 material-field">
                                    <div class="col-md-4">
                                        <label for="exampleFormControlInput1" class="form-label">Weight</label>
                                        <input type="text" name="product_weight" id="productWeight" class="form-control" id="exampleFormControlInput1">
                                        @error('product_weight')
                                        <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-4">
                                            <label for="exampleFormControlInput1" class="form-label">Good Resale Condition</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="good_resale_condition" id="goodResaleCondition" type="checkbox" id="inlineCheckbox1" value="1">
                                                <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                            </div>
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

        {{-- model for open Next box --}}
        <div class="modal fade" id="openNextBox" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="updatedmyForm" method="post" action="{{ route('tackbackStore.box.updated') }}">
                @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Open Box </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                Pallet ID: <span class="fw-bold" id="BoxpalletId"></span>
                            </div>
                            <div class="col-md-4">
                                Sub Brands: <span class="fw-bold" id="BoxsubBrands"></span>
                            </div>
                             <div class="col-md-4">
                                {{-- @if(isset($singlePalletBox))
                                    @endif --}}
                                    Box Id <span class="fw-bold" id="BoxpalletGenCode"></span>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div >
                                <div class="row mb-3 material-field">
                                    <h4 class="fw-bold">Add Box Detail</h4>
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">weight (lbs)</label>
                                        <input type="number" class="form-control" name="box_weight" id="box_weight"
                                            placeholder="Weight">
                                             <div id="boxWeightValidation" class="text-danger"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="exampleFormControlInput1" class="form-label">Product Category</label>
                                        <select name="product_category" id="product_category" class="form-select" aria-label="Default select example">
                                            <option selected value="">Select Product</option>
                                            <option value="cloth">Clothes</option>
                                            <option value="plastic">Plastic</option>
                                            <option value="wood">Wood</option>
                                        </select>
                                         <div id="productCategoryValidation" class="text-danger"></div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="exampleFormControlInput1" class="form-label">Pre Consumer</label>
                                        <select name="pre_consumer" id="pre_consumer" class="form-select" aria-label="Default select example">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                   <input type="hidden" name="palletId" id="palletId">
                                   <input type="hidden" name="boxId" id="boxId">
                                     {{-- <div id="errorMessage1" class="text-danger" style="display: none;"></div> --}}
                                </div>
                                <!-- Dynamic material fields will be added here -->
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-9">
                                 <h4 class="mt-4 fw-bold">Box Packaging Material</h4>
                            </div>
                            <div class="col-md-3 mt-3">
                                  <button style="margin-left: 10px" type="button" id="addMaterialBtn1"
                                class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add New Material
                            </button>
                            </div>
                         </div>
                       
                        <div class="row mt-4">
                            <div id="materialFields1">
                                <div class="row mb-3 material-field">
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">Material Type:</label>
                                        <select class="form-select" name="material_type1[]">
                                            <option value="">material type</option>
                                            <option value="paper">Paper</option>
                                            <option value="wood">Wood</option>
                                            <option value="plastic">Plastic</option>
                                            <option value="shrink-wrap">Shrink-Wrap</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">Material weight (lbs)</label>
                                        <input type="number" class="form-control" name="material_weight1[]"
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
                           
                        </div>
                        <button type="button" class="btn btn-secondary me-2 pallet-generate-setBtnColor" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Save & Continue</button>
                        {{-- <button type="submit" class="btn btn-secondary">Save </button> --}}
                    </div>
                </div>
            </div>
             </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/customStorePalletBox.js') }}"></script>
@endpush
