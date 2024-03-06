<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row m-2">
            
             <div class="search-products justify-content-between d-flex ">
                {{-- <h4>All Tackback<h4> --}}
                    <div class="col-md-2">
                        <h4>All Tackback<h4> 
                    </div>
                    <form id="filterForm" method="GET" action="{{ route('admin.stores.brand-filter') }}">
                        <div class="d-flex">
                            <div class="col-md-10">
                                <select class="form-select" name="brand_id" aria-label="Default select example" id="brand_id">
                                   <option value="0">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Search</button>   
                            </div> --}}
                        </div>
                    </form>
                    {{-- <button id="close-edit-category" type="button"
                        class=" btn btn-secondary">
                        New tackback
                    </button> --}}
                    <div class="col-md-4">
                         <fieldset class="form-group position-relative mb-0 search_form setfield-space">
                        <input type="text" class="form-control" placeholder="Search" id="searchQuery1"/>
                        <div class="form-control-position form_input_items mt_8">
                            <i class="ft-x font-medium-5 cross_image cursor-pointer"></i>
                            <i alt="icon" class="ft-search font-medium-5 cursor-pointer pr_8"></i>
                        </div>
                    </fieldset>
                    </div>
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
                        <td>{{ \Carbon\Carbon::parse($store->created_store_date_time)->format('d/m/y h:i:s A') }}</td>
                        <td>{{ $store->trackback_product_store_type }}</td>
                         <td>{{$store->pallet_weight}}</td>
                         <td>--</td>
                         <td>--</td>
                    </tr>
                    <input type="hidden" name="store_ids[]" id="store_ids" value="{{ $store->id }}">
                @endforeach 
                @if ($stores->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">No record Found</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{-- {{ $stores->links() }} <!-- Pagination links --> --}}
        {{-- <div class="pagination justify-content-center">
            {{ $stores->links() }}
        </div> --}}
         <div class="pagination d-flex justify-content-center">
            {{ $stores->links('pagination::bootstrap-4') }}
        </div>

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
            document.getElementById('brand_id').addEventListener('input', function() {
            var brandId = this.value;
            if (brandId) {
                // Send AJAX request
                $.ajax({
                    url: '{{ route("admin.stores.brand-filter") }}',
                    method: 'GET',
                    data: { brand_id: brandId },
                    success: function(response) {
                        console.log(response);
                        // Iterate over the response data and populate the table rows
                        $('#dataTable tbody').empty();
                        if(response.length > 0){
                             $.each(response, function(index, data) {
                            var newRow = '<tr>' +
                                '<td>' + data.shipment_id + '</td>' +
                                '<td>' + data.created_store_date_time + '</td>' +
                                '<td>' + data.trackback_product_store_type + '</td>' +
                                '<td>' + data.pallet_weight + '</td>' +
                                '<td>' + '--' +'</td>' +
                                '<td>' + '--' + '</td>' +
                                // Add more table data as needed
                                '</tr>';
                            $('#dataTable tbody').append(newRow);
                            });
                        } else {
                            var newRow =    `<tr>
                            <td colspan="7" class="text-center">No record Found</td>
                            </tr>`
                            $('#dataTable tbody').append(newRow);
                        }
                        
                        // Handle success response
                        // You can update the table or display the filtered data here
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                    }
                });
            }
        });

        // Function to perform AJAX search request
        function search() {
            var query = $('#searchQuery1').val();
            alert(query);
            if(!query){
                query = 0;
            }
            console.log('check data---------', query);
            // Send AJAX request
            $.ajax({
                url: '{{ route("admin.stores.search-store") }}',
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    console.log('check data1111============');
                    // Update table with search results
                    updateTable(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
           
        }

        // Function to update table with search results
        function updateTable(data) {
            $('#dataTable tbody').empty();
            // Clear existing table rows
                console.log('wow data========', data);
                if(data.length > 0){
                    // Add new rows for each search result
                    $.each(data, function(index, item) {
                        var row = '<tr>' +
                            '<td>' + item.shipment_id + '</td>' +
                            '<td>' + item.created_store_date_time + '</td>' +
                            '<td>' + item.trackback_product_store_type + '</td>' +
                            '<td>' + item.pallet_weight + '</td>' +
                            '<td>--</td>' +
                            '<td>--</td>' +
                            '</tr>';
                        $('#dataTable tbody').append(row);
                    });
                } else {
                    var newRow =    `<tr>
                        <td colspan="7" class="text-center">No record Found</td>
                        </tr>`
                    $('#dataTable tbody').append(newRow);
                }
            
        }
        $(document).ready(function() {
            $('#searchQuery1').on('input', function() {
                // This function will be called whenever the input value changes
                // alert('Input value changed');
                search();
            });
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
    /* padding-left: 100px */
} 

/* .product-table-main-list {
    padding: 20px;
}

</style>