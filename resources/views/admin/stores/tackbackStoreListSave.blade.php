<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row m-2">
            
             <div class="search-products justify-content-between d-flex ">
                {{-- <h4>All Tackback<h4> --}}
                     <div class="mt-2 set-btn-alingments">
                        <a href="{{ route('admin.stores.create-store') }}" class="btn btn-secondary">
                                Back
                        </a>
                    </div>
                    <div class="col-md-2 mt-1">
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
                         <td>{{$store->total_weight}}</td>
                         <td>{{$store->status_1_count}}/ {{$store->quantity}}</td>
                         {{-- <td>{{ $store->status_1_count + $store->status_0_count }} ({{$store->status_1_count}}/{{ $store->status_1_count + $store->status_0_count }})</td> --}}
                       {{-- <td style="color: {{ $store->status == 0 ? 'red' : 'black' }}">
                            @if ($store->status == 0)
                              
                                    Unopened <i class="bi bi-chevron-right shipment-list-status-icons"></i>
                            @else
                                    Opened <i class="bi bi-chevron-right shipment-list-status-icons"></i>
                            @endif
                        </td> --}}
                        <td style="color: {{ $store->status == 0 ? 'red' : 'black' }}" class="shipment-list-status-icons">
                            @if ($store->status == 0)
                            Unopened
                                <a href="{{ route('admin.stores.shipment-detail', ['id' => $store->id]) }}">
                                    <i class="bi bi-chevron-right shipment-list-status-icons"></i>
                                </a>
                            @else
                            Opened
                                <a href="{{ route('admin.stores.shipment-detail', ['id' => $store->id]) }}">
                                     <i class="bi bi-chevron-right shipment-list-status-icons"></i>
                                </a>
                            @endif
                        </td>
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
         {{-- <div id="defaultPagination" class="pagination d-flex justify-content-center">
            {{ $stores->links('pagination::bootstrap-4') }}
            <span class="justify-content-end" id="paginationInfo" class="ms-3">
                Showing {{ $stores->firstItem() }} - {{ $stores->lastItem() }} of {{ $stores->total() }}
            </span>
        </div> --}}
        <div  class="pagination-container d-flex justify-content-between align-items-center">
        <div></div>
            <div  style="
            justify-content: center;
        "id="defaultPagination" class="pagination">
                {{ $stores->links('pagination::bootstrap-4') }}
            </div>
            <div style="flex-direction: end;align-items: end;display: flex;">
                <span id="paginationInfo" class="ms-3">
                Showing {{ $stores->firstItem() }} - {{ $stores->lastItem() }} of {{ $stores->total() }}
            </span>
            </div>
        </div>

        
        {{-- <div class="pagination d-flex justify-content-center" id="paginationLinks">
            <!-- Pagination links will be dynamically updated here -->
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
                                '<td>' + data.total_weight + '</td>' +
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
                            '<td>' + item.total_weight + '</td>' +
                            '<td>--</td>' +
                            '<td>--</td>' +
                            '</tr>';
                        $('#dataTable tbody').append(row);
                    });
                    // Add pagination links if available
                    // $('#paginationLinks').html(data.links);
                } else {
                    var newRow =    `<tr>
                        <td colspan="7" class="text-center">No record Found</td>
                        </tr>`
                    $('#dataTable tbody').append(newRow);
                }
            
        }
        $(document).ready(function() {
            $('#searchQuery1').on('input', function() {
                search();
            });
        });
        </script>
@endpush
