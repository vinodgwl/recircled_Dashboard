<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Tackback Products
            </div>
            @if(session('success'))
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
                            <div class="col-md-3">
                               <label class="form-check-label" for="flexRadioDefault1">Tackback Type:</label>
                               <span class="fw-bold">{{$latestStoreDetail->trackback_product_store_type}}</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Parent Brand:</label>
                                <span class="fw-bold">{{$latestStoreDetail->brand->name}}</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Shipment ID:</label>
                                <span class="fw-bold">{{$latestStoreDetail->shipment_id}}</span>
                            </div>
                             <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Pallet Quantity</label>
                                <span class="fw-bold">{{$latestStoreDetail->quantity}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="row">
                           <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Total Weight</label>
                                <span class="fw-bold">{{$latestStoreDetail->total_weight}} lbs</span>
                            </div>
                            <div class="col-md-3">
                                <label class="form-check-label" for="flexRadioDefault1">Date & Time</label>
                               <span class="fw-bold">{{ \Carbon\Carbon::parse($latestStoreDetail->created_store_date_time)->format('d/m/y h:i:s A') }}</span>
                                {{-- <span class="fw-bold">{{ $latestStoreDetail->created_store_date_time->format('d/m/y h:i:s A') }}</span> --}}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Pallet No.</th>
                    <th>Pallet Unique Id</th>
                    <th>Sub Brand</th>
                    <th>Weight</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($stores as $store)
                    <tr>
                        <td>{{ $store->id }}</td>
                        <td>{{ $store->pallet_unique_id }}</td>
                        <td><div class="col-md-6">
                                <select class="form-select" name="store_sub_brand[]" aria-label="Default select example">
                                    <option value="">Select Sub brand-</option>
                                    <option value="golf puma">Golf puma</option>
                                    <option value="tretorn puma">Tretorn puma</option>
                                </select>
                            </div></td>
                         <td><div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Weight" value="{{ $store->pallet_weight }}" name="pallet_weight[]" id="exampleFormControlInput1">
                            </div></td>
                    </tr>
                    <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->id }}">
                @endforeach 
            </tbody>
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
                    <a href="#" class="btn btn-secondary me-2">Back</a>
                    {{-- <button type="button" onclick="window.location='{{ route('brands.create') }}'" class="btn btn-secondary me-2">Back</button> --}}
                </div>
                <div class="col-auto">
                    {{-- <a href="{{ route('admin.stores.create') }}" class="btn btn-secondary me-2">Back</a> --}}
                    <button type="button" class="btn btn-secondary me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary">Save & Open</button>
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

</style>