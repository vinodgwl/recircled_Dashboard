<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- <div class="card"> --}}
            <div class="card-header p-1 mt-2">
                <h4> New Tackback</h4> 
            </div>
            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('successMessage').style.display = 'none';
                     document.getElementById('totalWeightError').style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            </script>
             @endif
            <form id="palletForm" method="post" action="{{ route('trackbackProduct.update.stores') }}">
                @csrf
                <div class="card-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-3">
                               <label class="form-check-label" for="flexRadioDefault1">Tackback Type:</label>
                               <span class="fw-bold">{{$latestStoreDetail->trackback_product_store_type}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Parent Brand:</label>
                                <span class="fw-bold">{{$latestStoreDetail->brand->name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Shipment ID:</label>
                                <span class="fw-bold">{{$latestStoreDetail->shipment_id}}</span>
                            </div>
                             <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Pallet Quantity</label>
                                <span class="fw-bold">{{$latestStoreDetail->quantity}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Total Weight</label>
                                <span class="fw-bold">{{$latestStoreDetail->total_weight}} lbs</span>
                                <input type="hidden" name="totel_weight" id="totel_weight" value="{{$latestStoreDetail->total_weight}}">
                            </div>
                        </div>
                    </div>
                   <div class="row detailtack">
                            <div class="col-md-3 pl-5">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                               <span class="fw-bold">{{ \Carbon\Carbon::parse($latestStoreDetail->created_store_date_time)->format('d/m/y h:i:s A') }}</span>
                                {{-- <span class="fw-bold">{{ $latestStoreDetail->created_store_date_time->format('d/m/y h:i:s A') }}</span> --}}
                            </div>
                        </div>
            </div>
           <div class="row">
                 <div class="col-md-12 mt-3">
                        <h5 class="fw-bold mb-2">Enter Pallet Details</h5> 
                 </div>
           </div>
        {{-- </div> --}}
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Pallet No.</th>
                    <th>Pallet Unique Id</th>
                    <th>Sub Brand</th>
                    <th>Weight (lbs)</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($stores as $store)
                    <tr>
                        <td>{{ $store->id }}</td>
                        <td>{{ $store->pallet_unique_id }}</td>
                        <td><div class="col-md-6">
                                <select class="form-select" name="store_sub_brand[]" aria-label="Default select example">
                                    <option value="">N/A</option>
                                    <option value="golf puma">Golf puma</option>
                                    <option value="tretorn puma">Tretorn puma</option>
                                </select>
                            </div></td>
                         <td><div class="col-md-3">
                                <input type="text" class="form-control pallet-weight-input" min="1"  placeholder="Weight" value="{{ $store->pallet_weight }}" name="pallet_weight[]" id="exampleFormControlInput1" required>
                            </div></td>
                    </tr>
                    <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->id }}">
                    <input type="hidden" name="shipment_id" id="another_hidden_field" value="{{$store->shipment_id}}">
                @endforeach 
                @if ($stores->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No record Found</td>
                </tr>
                @endif
            </tbody>
            <div id="totalWeightError" class="alert alert-danger d-none mt-2">Total weight exceeds {{$latestStoreDetail->total_weight}} lbs.</div>
        </table>
        {{-- {{ $stores->links() }} <!-- Pagination links --> --}}
        {{-- <div class="pagination d-flex justify-content-center">
            {{ $stores->links('pagination::bootstrap-4') }}
        </div> --}}

       {{-- <div class="p-2">
            <div class="row justify-content-between">
                @if ($stores->hasPages())
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $stores->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $stores->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                        </li>

                        {!! $stores->render() !!} <!-- Render the pagination links -->

                        <li class="page-item {{ !$stores->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $stores->nextPageUrl() }}" aria-label="Next">&raquo;</a>
                        </li>
                    </ul>
                </nav>
                @endif
             </div>
        </div> --}}
        <div class="p-4">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <a href="{{ route('admin.stores.create') }}"  class="btn btn-secondary me-2 setBtnColor">Back</a>
                    {{-- <button type="button" onclick="window.location='{{ route('brands.create') }}'" class="btn btn-secondary me-2">Back</button> --}}
                </div>
                <div class="col-auto">
                    {{-- <a href="{{ route('admin.stores.create') }}" class="btn btn-secondary me-2">Back</a> --}}
                    <button type="button" onclick="showToastr()" class="btn btn-secondary me-2 setBtnColor">Cancel</button>
                    <button type="submit" id="submitBtn" class="btn btn-secondary">Save</button>
                    <button type="button" id="saveAndOpenBtn" onclick="saveAndOpen()" class="btn btn-secondary">Save & Open</button>
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
        document.addEventListener('DOMContentLoaded', function () {
        const palletWeightInputs = document.querySelectorAll('.pallet-weight-input');
            
        palletWeightInputs.forEach(input => {
            input.addEventListener('input', function () {
                if (parseFloat(input.value) < 1) {
                    input.value = 1;
                }
                let totalWeight = 0;
                palletWeightInputs.forEach(input => {
                    totalWeight += parseFloat(input.value) || 0;
                });
                let totel_weight  = $('#totel_weight').val();
                // Ensure the input value is at least 1
                
                console.log('totel weight is here=======', totalWeight, 'and totel weight=====', totel_weight);
                if (totalWeight > totel_weight) {
                    // toastr.error('Total weight exceeds 100 lbs.');
                    // You may add additional logic here if needed
                    document.getElementById('totalWeightError').classList.remove('d-none');
                    document.getElementById('submitBtn').setAttribute('disabled', 'disabled');
                     document.getElementById('saveAndOpenBtn').setAttribute('disabled', 'disabled');
                } else {
                    // Here you can submit the form or perform other actions
                     document.getElementById('totalWeightError').classList.add('d-none');
                     document.getElementById('submitBtn').removeAttribute('disabled');
                     document.getElementById('saveAndOpenBtn').removeAttribute('disabled');
                }
                
            });
        });
    });
       function showToastr() {
        toastr.success('This is a success message!666', 'Success');
        // toastr.info('Total weight exceeds 100 lbs.');
        // toastr.error('This is a success message!', '', { 
        //     timeOut: 3000,
        //     positionClass: 'toast-top-right'
        // });
    }
    function saveAndOpen() {
        // Set the form action URL to the desired route for "Save & Open"
        document.getElementById("palletForm").action = "{{ route('trackbackProductSaveAndOpen.update.stores') }}";
        // Submit the form
        var form = document.getElementById("palletForm");
        // Perform client-side validation
        if (!form.checkValidity()) {
            // If the form is invalid, trigger the form validation
            form.reportValidity();
            return;
        }
        document.getElementById("palletForm").submit();
    }
    </script>
@endpush

<style>
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination .page-item {
    display: inline-block;
}

.pagination .page-link {
    color: #333;
    padding: 8px 12px;
    border: 1px solid #ccc;
    text-decoration: none;
    margin: 0 2px; /* Adjust the margin as needed */
}

.pagination .page-link:hover {
    background-color: #f0f0f0;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    pointer-events: none;
    background-color: #f0f0f0;
    color: #ccc;
}

.detailtack {
    margin-left: 4px !important;
}
.setBtnColor {
    background-color: #ffffff !important;
    color: #000000 !important;
}
</style>