<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <div class="card "> --}}
            <div class="card-header">
               
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                All Tackback / Shipment ID: {{$storesList->shipment_information_id}} 
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                 <a href="{{ route('admin.stores.shipment-detail', ['id' => $StorePallet->shipment_id ]) }}" class="btn btn-secondary">
                       <i class="bi bi-arrow-left"></i>
                 </a>
                 <span> Open Shipment</span>
               </div>
               <div class="mt-2 pallet-box-added-set-btn-alingments">
                  Pallet ID: {{$StorePallet->pallet_gen_code}}
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
                                <h4 class="fw-bold mb-2">Pallet ID: {{$StorePallet->pallet_gen_code}}</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Parent Brand:</label>
                                <span class="fw-bold">{{$storesList->brand->name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Sub-Brand:</label>
                                <span class="fw-bold">{{$StorePallet->sub_brand}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Tackback Type:</label>
                                <span class="fw-bold">{{$storesList->trackback_type_store_customer_warehouse}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Pallet weight:</label>
                                <span class="fw-bold">{{$StorePallet->pallet_weight}}</span>
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
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                                <span class="fw-bold"> {{$StorePallet->pallet_created_at}}</span>
                            </div>
                             <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Total Box Quantity:</label>
                                <span class="fw-bold">{{$StorePallet->box_quantity}} 
                                    {{-- <i class="bi bi-pencil-square"></i></span> --}}
                            </div>
                             <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Opened Box:</label>
                                <span class="fw-bold">--</span>
                            </div>
                        </div>
                        {{-- <form id="myForm" method="post" action="{{ route('tackbackStore.box.save') }}">
                            @csrf
                            <div class="row mt-3" style="padding-left: 15px; margin-bottom: 36px;">
                                <div class="col-md-12">
                                    <h5 class="fw-bold">Add New Boxes</h5>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleFormControlInput1" class="form-label">Weight</label>
                                    <input type="text" name="box_weight" placeholder="weight" class="form-control" id="box_weight">
                                    @error('box_weight')
                                    <span class="alert text-danger pallet-box-added-error-required-msg">{{ $message }}</span>
                                    @enderror
                                    <span class="text-danger pallet-box-added-error-required-msg custom-error" id="boxWeightError" style="display: none;">Weight field is required and it should be greater than 0</span>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleFormControlInput1" class="form-label">Product Category</label>
                                    <select name="product_category" id="product_category" class="form-select" aria-label="Default select example">
                                        <option selected value="">Select Product</option>
                                        <option value="cloth">Clothes</option>
                                        <option value="plastic">Plastic</option>
                                        <option value="wood">Wood</option>
                                    </select>
                                     <span class="text-danger pallet-box-added-error-required-msg custom-error" id="productCategoryError" style="display: none;">Weight field is required and it should be greater than 0</span>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleFormControlInput1" class="form-label">Pre Consumer</label>
                                    <select name="pre_consumer" id="pre_consumer" class="form-select" aria-label="Default select example">
                                        <option selected value="">Select Consumer</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                     <span class="text-danger pallet-box-added-error-required-msg custom-error" id="preConsumerError" style="display: none;">Weight field is required and it should be greater than 0</span>
                                </div>
                                <input type="hidden" name="store_pallet_id" id="store_id" value="{{ $StorePallet->id }}">
                                <input type="hidden" name="pallet_unique_id" id="pallet_unique_id" value="{{ $StorePallet->pallet_unique_id }}">
                                <input type="hidden" name="shipment_id" id="shipment_id" value="{{ $storesList->shipment_id }}">
                                <div class="col-md-2 mt-4">
                                <button type="button" class="btn btn-secondary" onclick="validateForm()">
                                    <i class="bi bi-plus"></i> Add
                                </button>
                                </div>
                            </div>
                        </form> --}}
                </div>
        {{-- </div> --}}
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Box No</th>
                    <th>Box Id</th>
                    <th>Box Weight (lbs)</th>
                    <th>Product category</th>
                    <th>Pre Consumer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                 @php $serial = 1; @endphp
                  @foreach ($storeBoxList as $box)
                    <tr>
                        <td>{{ $serial }}</td>
                        <td>{{$box->box_gen_code  }}</td>
                        <td>{{ $box->box_weight }} lbs</td>
                        <td>@if ($box->product_category == 0)
                             --
                            @else
                             {{$box->product_category}}
                            @endif
                        </td>
                         <td>@if ($box->pre_consumer == 0)
                              No
                            @else
                             Yes
                            @endif</td>
                       <td style="display: flex; color: {{ $box->status == 0 ? 'red' : 'black' }}">
                            @if ($box->status == 0)
                              
                                    Unopened <a style="margin-top: 9px" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-box-id="{{ $box->id }}"
                                data-box_weight="{{ $box->box_weight }}"
                                data-product-category="{{ $box->product_category }}"
                                data-pre-consumer="{{ $box->pre_consumer }}"
                                 onclick="clearBoxQuantityData(event)">
                                    <i class="bi bi-pencil pallet-box-added-edit-icons"></i>
                       </a>  <form id="boxform"  method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="margin-top:2px;" type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete this box?')">
                                        <i class="bi bi-trash pallet-box-added-delete-icons"></i>
                                    </button>
                                </form>  
                                <a style="margin-top: 8px;" href="{{ route('tackbackStore.box.product-list', ['id' => $box->id]) }}">
                                     <i class="bi bi-chevron-right pallet-box-added-status-icons"></i>
                                </a></i>
                            @else
                                    Opened <a style="margin-top: 9px; margin-left: 15px;" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-box-id="{{ $box->id }}"
                                data-box_weight="{{ $box->box_weight }}"
                                data-product-category="{{ $box->product_category }}"
                                data-pre-consumer="{{ $box->pre_consumer }}"
                                 onclick="clearBoxQuantityData(event)">
                                    <i class="bi bi-pencil pallet-box-added-edit-icons"></i>
                       </a>  <form id="boxform" action="{{ route('tackbackStore.box.delete', $box->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="margin-top:2px;" type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete this box?')">
                                        <i class="bi bi-trash pallet-box-added-delete-icons"></i>
                                    </button>
                                </form>  
                                <a style="margin-top: 8px;" href="{{ route('tackbackStore.box.product-list', ['id' => $box->id]) }}">
                                     <i class="bi bi-chevron-right pallet-box-added-status-icons"></i>
                                </a></i>
                            @endif
                        </td>
                    </tr>
                    @php $serial++; @endphp
                    {{-- <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->id }}"> --}}
                @endforeach 
                @if ($storeBoxList->isEmpty())
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
                </tr> --}}
            </tbody>
        </table>
        {{-- model for update box --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <form id="myForm" method="post" action="{{ route('tackbackStore.box.updated') }}">
                @csrf
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
                                <input type="text" name="box_weight" class="form-control" id="boxTotelWeight">
                            </div>
                                <span class="text-danger pallet-box-added-error-required-msg custom-error" id="errorMessage" style="display: none;">Quantity field is required and it should be greater than 0</span>
                        </div>
                        <input type="hidden" name="boxId" id="boxId">
                        <div class="row mt-4">
                            <div id="materialFields">
                                <div class="row mb-3 material-field">
                                    
                                    <div class="col-md-6">
                                        <label for="exampleFormControlInput1" class="form-label">Product Category</label>
                                        <select name="product_category" id="productCategory" class="form-select" aria-label="Default select example">
                                            <option selected value="">Select Product</option>
                                            <option value="cloth" >Clothes</option>
                                            <option value="plastic" >Plastic</option>
                                            <option value="wood" >Wood</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="exampleFormControlInput1" class="form-label">Pre Consumer</label>
                                        <select name="pre_consumer" id="preConsumer" class="form-select" aria-label="Default select example">
                                            <option selected value="">Select Consumer</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
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
     <script src="{{ asset('js/customStorePalletBox.js') }}"></script>
@endpush

