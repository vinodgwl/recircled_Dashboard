<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <div class="card "> --}}
           <div class="card-header">
               
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                Sorting / Shipment Detail / Pallet Detail
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                 <a href="{{ route('admin.stores.shipment-detail', ['id' => $StorePallet->shipment_id  ]) }}" class="btn btn-secondary">
                       <i class="bi bi-arrow-left"></i>
                 </a>
                 <span> Pallet Detail</span>
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                   ID: {{$StorePallet->pallet_gen_code}}
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
            <form method="post" action="{{ route('trackbackProduct.update.stores') }}">
                @csrf
                <div class="card-body">
                    <div class="p-3">
                        <div class="row">
                            {{-- <div class="col-md-12">
                                <h4 class="fw-bold mb-2">Pallet ID: TBK65PLDTRO-P011111</h4> 
                            </div> --}}
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Parent Brand:</label>
                                <span class="fw-bold">{{$shipmentList->brand->name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Sub Brand:</label>
                                <span class="fw-bold">{{$StorePallet->sub_brand}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Teckback Type:</label>
                                <span class="fw-bold">{{$shipmentList->trackback_type_store_customer_warehouse}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Pallet Weight</label>
                                <span class="fw-bold">{{$StorePallet->pallet_weight}}</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                                <span class="fw-bold"> 06/03/24 07:52:52 AM</span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Total Box Quantity</label>
                                <span class="fw-bold">{{$StorePallet->box_quantity}}</span> 
                                {{-- <a href="#" class="edit-icon"><i class="bi bi-pencil-square"></i></a> --}}
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Opened Box</label>
                                <span class="fw-bold">0</span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="p-3">
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
                    </div> --}}
                </div>
        {{-- </div> --}}
         <div class="card ">
            <div class="row p-2">
                <div class="col-md-9">
                    <h4 class="fw-bold mb-2">Box Detail</h4> 
                </div>
                <div class="col-md-3">
                    {{-- <h4 class="fw-bold mb-2">Box Detail</h4>  --}}
                      <button style="margin-left: 10px" data-bs-toggle="modal" data-bs-target="#updateBoxModal" 
                        data-box-id="{{ $BoxList->box_id }}"
                         data-box-gen-code="{{ $BoxList->box_gen_code  }}"
                        data-pallet-id="{{ $StorePallet->pallet_id }}"
                        data-pallet-gen-code="{{ $StorePallet->pallet_gen_code }}"
                        data-box-weight="{{ $BoxList->box_weight }}"
                        data-box-sub-brands="{{ $StorePallet->sub_brand }}"
                        data-box-product-category="{{ $BoxList->product_category }}"
                        data-box-pre-consumer="{{ $BoxList->pre_consumer }}"
                        data-box-packging-material = "{{ $BoxPackgingMaterialList }}"
                        
                      type="button" id="addMaterialBtn"
                                class="btn btn-secondary">
                                <i class="bi bi-pencil-square"></i> Edit Box Info
                            </button>
                </div>
                 <div class="col-md-2">
                    <label class="form-check-label" for="flexRadioDefault1">ID:</label>
                    <span class="fw-bold">{{$BoxList->box_gen_code}}</span>
                </div>
                <div class="col-md-2">
                    <label class="form-check-label" for="flexRadioDefault1">Box Weight:</label>
                    <span class="fw-bold">{{$BoxList->box_weight}}</span>
                </div>
                <div class="col-md-2">
                    <label class="form-check-label" for="flexRadioDefault1">Product Category:</label>
                    <span class="fw-bold">{{$BoxList->product_category}}</span>
                </div>
                <div class="col-md-2">
                    <label class="form-check-label" for="flexRadioDefault1">Pre Consumer</label>
                     <span class="fw-bold">
                        @if($BoxList->pre_consumer == 1)
                            Yes
                        @else
                            No
                        @endif
                    </span>
                </div>
            </div>
            <table id="dataTable" class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Tier</th>
                        <th>Quantity</th>
                        <th>Weight</th>
                        <th>Resale Condition</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach ($BoxProductList as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td> <!-- Serial number -->
                         <td>{{ $product->product_tier }}</td> 
                        <td>{{$product->product_quantity }}</td>
                        <td>{{ $product->product_weight }} lbs</td>
                        <td> @if ($product->good_resale_condition == 1)
                                <i class="bi bi-check-lg text-success fs-4"></i>
                            @else
                                <i class="bi bi-x-lg text-danger"></i>
                            @endif
                        </td>
                    </tr>
                    <input type="hidden" name="product_ids[]" id="product_ids" value="{{ $product->pallet_id }}">
                @endforeach 
                @if ($BoxProductList->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No record Found</td>
                </tr>
                @endif
                </tbody>
            </table>
         </div>
        </form>
        {{-- model for open box --}}
        <div class="modal fade" id="updateBoxModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="updatedmyForm" method="post" action="{{ route('tackbackStore.box.product.updated') }}">
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
                                    Box Id <span class="fw-bold" id="NewBoxGenCode"></span>
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
                                {{-- <div class="row mb-3 material-field">
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
                                    </div>
                                </div> --}}
                                <!-- Dynamic material fields will be added here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-6 text-left"> <!-- This column takes up half of the width -->
                           
                        </div>
                        <button type="button" class="btn btn-secondary me-2 pallet-generate-setBtnColor" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Update</button>
                        {{-- <button type="submit" class="btn btn-secondary">Save </button> --}}
                    </div>
                </div>
            </div>
             </form>
        </div>
    </div>
@endsection

@push('scripts')
     <script src="{{ asset('js/customBoxUpdate.js') }}"></script>
@endpush
