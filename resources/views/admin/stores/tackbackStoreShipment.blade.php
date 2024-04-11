<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <div class="card "> --}}
            {{-- <div class="card-header">
                <div class="mt-2 pallet-list-set-btn-alingments">
                 <a href="{{ route('admin.stores.saveList') }}" class="btn btn-secondary">
                        Back
                 </a>
               </div>
               <div class="mt-2 pallet-list-set-btn-alingments">
                 All Tackback / Shipment ID: {{$storesList->shipment_information_id}}
               </div>
            </div> --}}
            <div class="card-header">
               
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                Sorting / Shipment ID: {{$storesList->shipment_information_id}} 
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                 <a href="{{ route('admin.stores.saveList') }}" class="btn btn-secondary">
                       <i class="bi bi-arrow-left"></i>
                 </a>
                 <span> Open Shipment</span>
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                  Pallet ID: {{$storesList->shipment_information_id}}
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
                                <h4 class="fw-bold mb-2">Shipment ID: {{$storesList->shipment_information_id}}</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Brand:</label>
                                <span class="fw-bold">{{$storesList->brand->name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Tackback Type:</label>
                                <span class="fw-bold">{{$storesList->trackback_type_store_customer_warehouse}}</span>
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
                @php $serial = 1; @endphp
                 @foreach ($StorePallet as $store)
                    <tr>
                        <td>{{ $serial }}</td> <!-- Serial number -->
                        <td>{{$store->pallet_gen_code }}</td>
                        <td>{{ $store->pallet_weight }} lbs</td>
                         <td>{{$store->sub_brand}}</td>
                          {{-- <td>{{ $store->open_count }}/{{ $store->total_count }}</td> --}}
                           <td>--</td>
                         {{-- <td>{{ $store->status_1_count + $store->status_0_count }} ({{$store->status_1_count}}/{{ $store->status_1_count + $store->status_0_count }})</td> --}}
                       {{-- <td style="color: {{ $store->status == 0 ? 'red' : 'black' }}">
                            @if ($store->status == 0)
                              
                                    Unopened <i class="bi bi-chevron-right pallet-list-status-icons"></i>
                            @else
                                    Opened <i class="bi bi-chevron-right pallet-list-status-icons"></i>
                            @endif
                        </td> --}}
                        <td style="color: {{ $store->status == 0 ? 'red' : 'black' }}" class="pallet-list-status-icons">
                            @if ($store->status == 0)
                           <span class="unopned-pallet-list-status"> Unopened</span>
                                <a data-bs-toggle="modal" class="text-decoration-none"
                                data-bs-target="#exampleModal"
                                data-store-id="{{ $store->pallet_id }}"
                                data-pallet-id="{{ $store->pallet_gen_code }}"
                                data-pallet-weight="{{ $store->pallet_weight }}"
                                data-sub-brands="{{ $store->sub_brand }}"
                                href="#" onclick="clearBoxQuantityData(event)">
                                <span class="pallet-list-status-icons">Open Pallet</span>
                                    <i class="bi bi-chevron-right pallet-list-status-icons"></i>
                                </a>
                            @else
                            <span class="unopned-pallet-list-status">Opened</span>
                                <a class="shipment-list-set-alingment-icons text-decoration-none" data-bs-toggle="modal"
                                data-bs-target="#exampleModal1"
                                data-box-id="{{ $store->boxes[0]->box_id }}"
                                 data-box-gen-code="{{ $store->boxes[0]->box_gen_code }}"
                                data-pallet-id="{{ $store->pallet_id }}"
                                data-pallet-gen-code="{{ $store->pallet_gen_code }}"
                                data-pallet-weight="{{ $store->pallet_weight }}"
                                data-sub-brands="{{ $store->sub_brand }}"
                                href="#" onclick="clearBoxData(event)">
                                <span class="pallet-list-status-icons">Open Box</span>
                                     <i class="bi bi-chevron-right pallet-list-status-icons"></i>
                                </a>
                                {{-- <span class="bi bi-ellipsis-h"></span> --}}
                               <button class="dropdown-toggle" href="#" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background-color: transparent;">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path d="M8 9a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm0-4a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm0-4a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                </span>
                               <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                    <li><a class="dropdown-item view-pallet" href="{{ route('admin.stores.pallet-detail', ['pallet_id' => $store->pallet_id  ]) }}">View Pallet</a></li>
                                    <li><a class="dropdown-item edit-pallet" data-bs-toggle="modal"
                                data-bs-target="#updatePallet" 
                                data-pallet-id="{{ $store->pallet_id }}"
                                data-pallet-gen-code="{{ $store->pallet_gen_code }}"
                                data-pallet-weight="{{ $store->pallet_weight }}"
                                data-sub-brands="{{ $store->sub_brand }}"
                                data-box-quantity="{{ $store->box_quantity }}"
                                @isset($store->palletPackagingMaterial) 
                                    data-pallet-packging-material="{{  $store->palletPackagingMaterial }}" 
                                @endisset
                                href="#">Edit pallet info</a></li>
                                    <li><a class="dropdown-item submit-approval" href="#">Submit for Approval</a></li>
                                    <!-- Add more filter options here -->
                                </ul>
                            </button>
                            @endif
                        </td>
                    </tr>
                    <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->pallet_id }}">
                    @php $serial++; @endphp
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
        {{-- model for open pallet --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="myForm" method="post" action="{{ route('tackbackStore.box.creates') }}">
                @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Open Pallet</h5>
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
                                <span class="text-danger pallet-list-error-required-msg pallet-list-custom-error" id="errorMessage" style="display: none;">Quantity field is required and it should be greater than 0</span>
                            
                        </div>
                        <input type="hidden" name="storeId" id="storeId">
                        {{-- <h4 class="mt-4 fw-bold">Pallet Packaging Material</h4> --}}
                         <div class="row">
                            <div class="col-md-9">
                                 <h4 class="mt-4 fw-bold">Pallet Packaging Material</h4>
                            </div>
                            <div class="col-md-3 mt-3">
                                  <button style="margin-left: 10px" type="button" id="addMaterialBtn"
                                class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add New Material
                            </button>
                            </div>
                         </div>
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
                            {{-- <button style="margin-left: -84px" type="button" id="addMaterialBtn"
                                class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add New Material
                            </button> --}}
                        </div>
                        <button type="button" class="btn btn-secondary me-2 pallet-generate-setBtnColor" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-secondary">Save & Open Box</button>
                        <button type="submit" class="btn btn-secondary">Save </button>
                    </div>
                </div>
            </div>
             </form>
        </div>
        {{-- model for open box --}}
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                   <input type="hidden" name="boxId" id="boxId1">
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

         {{-- model for update pallet --}}
        <div class="modal fade" id="updatePallet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="myForm" method="post" action="{{ route('tackbackStore.pallet.update') }}">
                @csrf
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Update Pallet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                Pallet ID: <span class="fw-bold" id="updatePalletGenCode"></span>
                            </div>

                            <div class="col-md-4">
                                Pallet Weight: <span class="fw-bold" id="updatedPalletWeight"></span>
                            </div>
                            <div class="col-md-4">
                                Sub Brands: <span class="fw-bold" id="updatedSubBrands"></span>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <label for="boxQuantity" class="form-label">Box Quantity</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="boxboxQuantity" class="form-control" id="updatedboxQuantity" required>
                            </div>
                                <span class="text-danger pallet-list-error-required-msg pallet-list-custom-error" id="errorMessage" style="display: none;">Quantity field is required and it should be greater than 0</span>
                            
                        </div>
                        <input type="hidden" name="palletId" id="palletId">
                        
                        {{-- <h4 class="mt-4 fw-bold">Pallet Packaging Material</h4> --}}
                         <div class="row">
                            <div class="col-md-9">
                                 <h4 class="mt-4 fw-bold">Pallet Packaging Material</h4>
                            </div>
                            <div class="col-md-3 mt-3">
                                  <button style="margin-left: 10px" type="button" id="addMaterialBtn2"
                                class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add New Material
                            </button>
                            </div>
                         </div>
                        <div class="row mt-4">
                            <div id="materialFields2">
                                {{-- <div class="row mb-3 material-field">
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">Material Type:</label>
                                        <select class="form-select" name="material_type2[]">
                                            <option value="">material type</option>
                                            <option value="paper">Paper</option>
                                            <option value="wood">Wood</option>
                                            <option value="plastic">Plastic</option>
                                            <option value="shrink-wrap">Shrink-Wrap</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="logo" class="form-label">Material weight (lbs)</label>
                                        <input type="number" class="form-control" name="material_weight2[]"
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
                            {{-- <button style="margin-left: -84px" type="button" id="addMaterialBtn"
                                class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Add New Material
                            </button> --}}
                        </div>
                        <button type="button" class="btn btn-secondary me-2 pallet-generate-setBtnColor" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-secondary">Update </button>
                    </div>
                </div>
            </div>
             </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/csstomShipmentDetail.js') }}"></script>
@endpush
<style>
    /* Hide the dropdown arrow */
    #filterDropdown::after {
        display: none;
    }
</style>