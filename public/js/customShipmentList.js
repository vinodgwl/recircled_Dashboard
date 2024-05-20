
 document.getElementById('brand_id').addEventListener('input', function() {
            var brandId = this.value;
            var routeUrl = $(this).data('route');
             if (brandId) {
                // Send AJAX request
                $.ajax({
                    url: routeUrl,
                    method: 'GET',
                    data: { brand_id: brandId },
                    success: function(response) {
                        console.log(response);
                        // Iterate over the response data and populate the table rows
                        $('#dataTable tbody').empty();
                        if(response.length > 0){
                             $.each(response, function(index, data) {
                            var newRow = '<tr>' +
                                '<td>' + data.shipment_information_id + '</td>' +
                                '<td>' + data.shipment_created_at + '</td>' +
                                '<td>' + data.takeback_type.takeback_name + '</td>' +
                                '<td>' + data.total_weight + '</td>' +
                                '<td>' + data.status_1_count +'/'+ data.pallet_qty +'</td>' +
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
        function search(routeUrl) {
            var query = $('#searchQuery1').val();
            if(!query){
                query = 0;
            }
            // console.log('check data---------', query);
            // Retrieve route URL from data attribute
            // var routeUrl = $(this).data('route');
            // Send AJAX request
            $.ajax({
                url: routeUrl,
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
                    $.each(data, function (index, item) {
                        //  var statusColor = item.status == 0 ? 'red' : 'black';
                        //     var statusText = item.status == 0 ? 'Unopened' : 'Opened';

                        //     var routeUrl = "{{ route('admin.stores.shipment-detail', ['id' => ':shipment_id']) }}";
                        //     routeUrl = routeUrl.replace(':shipment_id', item.shipment_id);
                        var row = '<tr>' +
                            '<td>' + item.shipment_information_id + '</td>' +
                            '<td>' + item.shipment_created_at + '</td>' +
                            '<td>' + item.takeback_type.takeback_name + '</td>' +
                            '<td>' + item.total_weight + '</td>' +
                            '<td>' + item.status_1_count + '/' + item.pallet_qty + '</td>' +
                            //  '<td>' +
                            //     '<a href="' + routeUrl + '">' +
                            //     '<i class="bi bi-chevron-right shipment-list-status-icons"></i>' +
                            //     '</a>' +
                            //     '</td>' +
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
                var routeUrl = $(this).data('route');
                search(routeUrl);
            });
        });