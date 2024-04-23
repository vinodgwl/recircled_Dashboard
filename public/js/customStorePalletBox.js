$(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $(document).ready(function() {
            $('#addMaterialBtn').click(function() {
                var newMaterialField = '<div class="row mb-3 material-field">' +
                    '<div class="col">' +
                    '<select class="form-select" name="material_type[]">' +
                    '<option value="">Material Type</option>' +
                    '<option value="paper">Paper</option>' +
                    '<option value="wood">Wood</option>' +
                    '<option value="plastic">Plastic</option>' +
                    '<option value="shrink-wrap">Shrink-Wrap</option>'+
                    '</select>' +
                    '</div>' +
                    '<div class="col">' +
                    '<input type="number" class="form-control" name="material_weight[]" placeholder="Weight">' +
                    '</div>' +
                    '<div class="col-auto">' +
                    '<button class="btn btn-danger cancel-btn" type="button"><i class="bi bi-x"></i></button>' +
                    '</div>' +
                    '</div>';
                $('#materialFields').append(newMaterialField);
            });

            // Dynamically added cancel button event handler
            $('#materialFields').on('click', '.cancel-btn', function() {
                $(this).closest('.material-field').remove();
            });
        });
        $(document).ready(function() {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var productId = button.data('product-id');
            var productName = button.data('product-name');
            var productQuantity = button.data('product-quantity');
            var productWeight = button.data('product_weight');
            var productTier = button.data('product-tier');
            var goodResaleCondition = button.data('good-resale-condition');
            // $('#boxTotelWeight').text(box_weight);
            $(this).find('#productName').val(productName);
            $(this).find('#productQuantity').val(productQuantity);
            $(this).find('#productWeight').val(productWeight);
            $(this).find('#productTier').val(productTier);
            // $(this).find('#goodResaleCondition').val(goodResaleCondition);
            $(this).find('#goodResaleCondition').prop('checked', goodResaleCondition);
            $(this).find('#productId').val(productId);
        });
        });
        
        function validateForm() {
        var boxWeight = document.getElementsByName("box_weight")[0].value;
        var productCategory = document.getElementsByName("product_category")[0].value;
        var preConsumer = document.getElementsByName("pre_consumer")[0].value;
        
        var isValid = true;
        
        // Validate box weight
        if (!boxWeight || isNaN(boxWeight) || boxWeight <= 0) {
            document.getElementById("boxWeightError").innerText = "Please enter box weight and it should be greater than 0.";
            document.getElementById("boxWeightError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("boxWeightError").style.display = "none";
        }
        
        // Validate product category
        if (productCategory =="") {
            document.getElementById("productCategoryError").innerText = "Please select product category.";
            document.getElementById("productCategoryError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("productCategoryError").style.display = "none";
        }
        
        // Validate pre consumer
        if (preConsumer == "") {
            document.getElementById("preConsumerError").innerText = "Please select pre consumer.";
            document.getElementById("preConsumerError").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("preConsumerError").style.display = "none";
        }
        // return;
        // If all fields are valid, submit the form
        if (isValid) {
            document.getElementById("myForm").submit();
        }
    }
    function deletePalletBox($id){
        if (confirm('Are you sure you want to delete this box?')) {
            document.getElementById("boxform").submit();
        }
    }
    function clearBoxQuantityData (){
        console.log('clear value');
        // conole.log('ok')
    }
    
    // save and open next box using ajax
    
function saveAndOpenNextBox() {
    // Get the route from the data-route attribute of the button
    var route = $('button[data-route]').data('route');
    
    // var urlParams = new URLSearchParams(route);
    // // Get the values of pallet_id and box_id parameters
    // var palletId = urlParams.get('pallet_id');
    // var boxId = urlParams.get('box_id');
    // Use URLSearchParams to parse the query string
    const params = new URLSearchParams(route.split('?')[1]);

    // Access the values using the parameter names
    let palletId = params.get('pallet_id');
    let boxId = params.get('box_id');

    console.log("Pallet ID:", palletId);
    console.log("Box ID:", boxId);

    // Append the pallet_id and box_id as URL parameters
    var url = route + '?pallet_id=' + encodeURIComponent(palletId) + '&box_id=' + encodeURIComponent(boxId);
        // Make a GET request to retrieve the data
        $.ajax({
            url: url, // Constructed URL with params
            method: 'GET',
            success: function(response) {
                 // Handle successful response
                console.log('Response data:', response);
                if (response.message) {
                    alert('No more boxes available');
                     $('#saveAndOpenBtn').prop('disabled', true);
                } else {
                    var boxData = response.nextRecord;
                    var palletData = response.palletDetail;
                    // You can populate input fields or update UI elements here
                    $('#BoxpalletId').text(boxData.pallet_gen_code);
                    $('#BoxsubBrands').text(palletData.sub_brand);
                    $('#BoxpalletGenCode').text(boxData.box_gen_code);
                    $('#palletId').val(boxData.pallet_id);
                    $('#boxId').val(boxData.box_id);
                    // clear input value 
                    $('input[name="pre_consumer"]').val('');
                    $('input[name="product_category"]').val('');
                    $('input[name="box_weight"]').val('');
                    $('select[name="material_type1[]"]').val('');
                    $('input[name="material_weight1[]"]').val('');
                     $('#saveAndOpenBtn').prop('disabled', false);
                    $('#openNextBox').modal('show');
                    
                    // alert('Data retrieved successfully!');
                    // For example, display the retrieved data in a <div>
                    // $('#displayData').text('Category ID: ' + response.category_id + ', Weight: ' + response.weight);

                    // Optionally, you can also show a success message or perform other actions
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.error(error);
                alert('Failed to retrieve data. Please try again.');
            }
        });
}

//  add material for next open boxes
    $(document).ready(function() {
    $('#addMaterialBtn1').click(function() {
        var newMaterialField = '<div class="row mb-3 material-field">' +
            '<div class="col-md-4">' +
            '<select class="form-select" name="material_type1[]">' +
            '<option value="">Material Type</option>' +
            '<option value="paper">Paper</option>' +
            '<option value="wood">Wood</option>' +
            '<option value="plastic">Plastic</option>' +
            '<option value="shrink-wrap">Shrink-Wrap</option>'+
            '</select>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<input type="number" class="form-control" name="material_weight1[]" placeholder="Weight">' +
            '</div>' +
            '<div class="col-auto">' +
                '<button class="btn cancel-btn" type="button" style="background-color: transparent; border: none;">' +
                '<i class="bi bi-x" style="font-size: 1.5rem;"></i>' +
            '</button>' +
            '</div>' +
            '</div>';
        $('#materialFields1').append(newMaterialField);
    });

    // Dynamically added cancel button event handler
    $('#materialFields1').on('click', '.cancel-btn', function() {
        $(this).closest('.material-field').remove();
    });
    });