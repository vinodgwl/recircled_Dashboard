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
                               <span class="fw-bold">{{$latestStoreDetail->takebackType->takeback_name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Parent Brand:</label>
                                <span class="fw-bold">{{$latestStoreDetail->brand->name}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Shipment ID:</label>
                                <span class="fw-bold">{{$latestStoreDetail->shipment_information_id}}</span>
                            </div>
                             <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Pallet Quantity</label>
                                <span class="fw-bold">{{$latestStoreDetail->pallet_qty}}</span>
                            </div>
                            <div class="col-md-2">
                                <label class="form-check-label" for="flexRadioDefault1">Total Weight</label>
                                <span class="fw-bold">{{$latestStoreDetail->total_weight}} lbs</span>
                                <input type="hidden" name="totel_weight" id="totel_weight" value="{{$latestStoreDetail->total_weight}}">
                            </div>
                        </div>
                    </div>
                   <div class="row pallet-generate-detailtack">
                            <div class="col-md-3 pl-5">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                               <span class="fw-bold">{{ \Carbon\Carbon::parse($latestStoreDetail->shipment_created_at)->format('d/m/y h:i:s A') }}</span>
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
                    <th>Pallet generated Id</th>
                    <th>Sub Brand</th>
                    <th>Weight (lbs)</th>
                </tr>
            </thead>
            <tbody>
                 @php $serial = 1; @endphp
                 @foreach ($stores as $store)
                    <tr>
                        <td>{{ $serial }}</td>
                        <td>{{ $store->pallet_code }}</td>
                        <td><div class="col-md-6">
                                <select class="form-select" name="sub_brand[]" aria-label="Default select example">
                                    <option value="">N/A</option>
                                    <option value="golf puma">Golf puma</option>
                                    <option value="tretorn puma">Tretorn puma</option>
                                </select>
                            </div></td>
                         <td><div class="col-md-3">
                                <input type="text" class="form-control pallet-weight-input" min="1"  placeholder="Weight" value="{{ $store->pallet_weight }}" name="pallet_weight[]" id="exampleFormControlInput1" required>
                            </div></td>
                    </tr>
                    <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->pallet_id }}">
                    <input type="hidden" name="shipment_information_id" id="another_hidden_field" value="{{$store->shipment_information_id}}">
                    @php $serial++; @endphp
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
                    <a href="{{ route('admin.stores.create') }}"  class="btn btn-secondary me-2 pallet-generate-setBtnColor">Back</a>
                    {{-- <button type="button" onclick="window.location='{{ route('brands.create') }}'" class="btn btn-secondary me-2">Back</button> --}}
                </div>
                <div class="col-auto">
                    {{-- <a href="{{ route('admin.stores.create') }}" class="btn btn-secondary me-2">Back</a> --}}
                    <button type="button" onclick="showToastr()" class="btn btn-secondary me-2 pallet-generate-setBtnColor">Cancel</button>
                    <button type="submit" id="submitBtn" class="btn btn-secondary">Save & Submit for Approval</button>
                    {{-- <button type="button" id="saveAndOpenBtn" onclick="saveAndOpen()" class="btn btn-secondary">Save & Open</button> --}}
                </div>
             </div>
        </div>
         </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/customCreateStore.js') }}"></script>
@endpush
