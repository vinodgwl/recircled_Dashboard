<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row m-2">
            
             <div class="search-products  d-flex ">
                {{-- <h4>All Tackback<h4> --}}
                    <div>
                        <div class="col-md-12">
                                <select class="form-select" name="store_sub_brand[]" aria-label="Default select example">
                                    <option value="">Select Brand</option>
                                    <option value="golf puma">Golf puma</option>
                                    <option value="tretorn puma">Tretorn puma</option>
                                </select>
                            </div>
                    {{-- <button id="close-edit-category" type="button"
                        class=" btn btn-secondary">
                        New tackback
                    </button> --}}
                    </div>
                    <fieldset class="form-group position-relative mb-0 search_form setfield-space">
                        <input type="text" class="form-control" id="iconLeft1" placeholder="Search" />
                        <div class="form-control-position form_input_items mt_8">
                            <i class="ft-x font-medium-5 cross_image cursor-pointer"></i>
                            <i alt="icon" class="ft-search font-medium-5 cursor-pointer pr_8"></i>
                        </div>
                    </fieldset>
                    <button id="close-edit-category" type="button"
                        class=" btn btn-secondary">
                        New tackback
                    </button>
                </div>
        </div>
       
        <table id="dataTable" class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Shipment Id</th>
                    <th>Date and Time</th>
                    <th>Type</th>
                    <th>Total Weight (lbs)</th>
                    <th>Opened / Total Pallet</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($stores as $store)
                    <tr>
                        <td>{{ $store->shipment_id }}</td>
                        <td>{{ \Carbon\Carbon::parse($latestStoreDetail->created_store_date_time)->format('d/m/y h:i:s A') }}</td>
                        <td>{{ $store->trackback_product_store_type }}</td>
                         <td>{{$store->pallet_weight}}</td>
                         <td>--</td>
                         <td>--</td>
                    </tr>
                    <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->id }}">
                @endforeach 
            </tbody>
        </table>
        {{-- {{ $stores->links() }} <!-- Pagination links --> --}}
        {{-- <div class="pagination justify-content-center">
            {{ $stores->links() }}
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
        {{-- <div class="p-4">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <button type="button" class="btn btn-secondary me-2">Back</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-secondary me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save index list</button>
                    <button type="button" class="btn btn-primary">Save & Open</button>
                </div>
             </div>
        </div> --}}
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


.setfield-space {
    margin-right: 15px;
}

 .main-search {
    padding: 15px;
}

.search-products {
    max-width: 600px;
    width: 100%;
}

.search-products fieldset {
    max-width: 225px;
    width: 100%;
}

.search-products fieldset input {
    padding-left: 100px
} 

/* .product-table-main-list {
    padding: 20px;
}

</style>