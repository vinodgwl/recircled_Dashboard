
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
                var routeUrl = $(this).data('route');
                search(routeUrl);
            });
        });