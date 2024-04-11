
 $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        // updated pallet  
        $(document).ready(function() {
            $('#addMaterialBtn2').click(function() {
                var newMaterialField = '<div class="row mb-3 material-field">' +
                    '<div class="col-md-4">' +
                    '<select class="form-select" name="material_type2[]">' +
                    '<option value="">Material Type</option>' +
                    '<option value="paper">Paper</option>' +
                    '<option value="wood">Wood</option>' +
                    '<option value="plastic">Plastic</option>' +
                    '<option value="shrink-wrap">Shrink-Wrap</option>'+
                    '</select>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<input type="number" class="form-control" name="material_weight2[]" placeholder="Weight">' +
                    '</div>' +
                    '<div class="col-auto">' +
                     '<button class="btn cancel-btn" type="button" style="background-color: transparent; border: none;">' +
                        '<i class="bi bi-x" style="font-size: 1.5rem;"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>';
                $('#materialFields2').append(newMaterialField);
            });

            // Dynamically added cancel button event handler
            $('#materialFields2').on('click', '.cancel-btn', function() {
                $(this).closest('.material-field').remove();
            });
        });
        //  add material for boxes
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
        // add pallet for popup
         $(document).ready(function() {
            $('#addMaterialBtn').click(function() {
                var newMaterialField = '<div class="row mb-3 material-field">' +
                    '<div class="col-md-4">' +
                    '<select class="form-select" name="material_type[]">' +
                    '<option value="">Material Type</option>' +
                    '<option value="paper">Paper</option>' +
                    '<option value="wood">Wood</option>' +
                    '<option value="plastic">Plastic</option>' +
                    '<option value="shrink-wrap">Shrink-Wrap</option>'+
                    '</select>' +
                    '</div>' +
                    '<div class="col-md-4">' +
                    '<input type="number" class="form-control" name="material_weight[]" placeholder="Weight">' +
                    '</div>' +
                    '<div class="col-auto">' +
                     '<button class="btn cancel-btn" type="button" style="background-color: transparent; border: none;">' +
                        '<i class="bi bi-x" style="font-size: 1.5rem;"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>';
                $('#materialFields').append(newMaterialField);
            });

            // Dynamically added cancel button event handler
            $('#materialFields').on('click', '.cancel-btn', function() {
                $(this).closest('.material-field').remove();
            });
        });
        
        // add for pallet popup
        $(document).ready(function() {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var storeId = button.data('store-id');
            var palletId = button.data('pallet-id');
            var palletWeight = button.data('pallet-weight');
            var subBrands = button.data('sub-brands');
            $('#palletId').text(palletId);
            $('#palletWeight').text(palletWeight);
            $('#subBrands').text(subBrands);
            // $('#storeId').text(storeId);
            // alert(storeId);
            $(this).find('#storeId').val(storeId);
        });
        });
        // add for box popup
        $(document).ready(function() {
        $('#exampleModal1').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var palletId = button.data('pallet-id');
            var  boxId = button.data('box-id');
            var  boxGenCode = button.data('box-gen-code');
            // alert(boxId)
            var palletGenCode = button.data('pallet-gen-code');
            var palletWeight = button.data('pallet-weight');
            var subBrands = button.data('sub-brands');
            $('#BoxpalletId').text(palletGenCode);
            $('#BoxpalletWeight').text(palletWeight);
            $('#BoxsubBrands').text(subBrands);
            $('#BoxpalletGenCode').text(boxGenCode);
            // alert(palletId);
            $(this).find('#palletId').val(palletId);
            $(this).find('#boxId1').val(boxId);
        });
        });
        
         // updated pallet box
        $(document).ready(function() {
            $('#updatePallet').on('show.bs.modal', function (event) {
           
            var button = $(event.relatedTarget);
            var palletId = button.data('pallet-id');
            var boxQuantity = button.data('box-quantity');
            var palletGenCode = button.data('pallet-gen-code');
            var palletWeight = button.data('pallet-weight');
            var subBrands = button.data('sub-brands');
            var palletPackgingMaterial = button.data('pallet-packging-material');
            $('#updatePalletGenCode').text(palletGenCode);
            $('#updatedPalletWeight').text(palletWeight);
            $('#updatedSubBrands').text(subBrands);
                // $('#storeId').text(storeId);
            $('#materialFields2').html('');
                console.log('check data is here for all packaging updations', palletPackgingMaterial);
                var newMaterialFields = '';
                // Loop through the palletPackgingMaterial array
                palletPackgingMaterial.forEach(function(item) {
                    // Generate HTML for each item
                    var materialField = '<div class="row mb-3 material-field">' +
                        '<div class="col-md-4">' +
                        '<select class="form-select" name="material_type2[]">' +
                        '<option value="">Material Type</option>' +
                        '<option value="paper"' + (item.material_type === 'paper' ? ' selected' : '') + '>Paper</option>' +
                        '<option value="wood"' + (item.material_type === 'wood' ? ' selected' : '') + '>Wood</option>' +
                        '<option value="plastic"' + (item.material_type === 'plastic' ? ' selected' : '') + '>Plastic</option>' +
                        '<option value="shrink-wrap"' + (item.material_type === 'shrink-wrap' ? ' selected' : '') + '>Shrink-Wrap</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-4">' +
                        '<input type="number" class="form-control" name="material_weight2[]" value="' + item.material_weight + '" placeholder="Weight">' +
                        '</div>' +
                        '<div class="col-auto">' +
                        '<button class="btn cancel-btn" type="button" style="background-color: transparent; border: none;">' +
                            '<i class="bi bi-x" style="font-size: 1.5rem;"></i>' +
                        '</button>' +
                        '</div>' +
                        '</div>';

                    // Append the generated HTML to newMaterialFields
                    newMaterialFields += materialField;
                });

                // Append the generated HTML to the materialFields1 element
                $('#materialFields2').append(newMaterialFields);
            alert(palletId);
            $(this).find('#palletId').val(palletId);
            $(this).find('#updatedboxQuantity').val(boxQuantity);
        });
        });
        document.addEventListener('DOMContentLoaded', function() {
        // Get the form element
        var form = document.getElementById('myForm');

        // Add event listener for form submission
        form.addEventListener('submit', function(event) {

            var errorMessage = document.getElementById('errorMessage');
            var boxQuantityInput = document.getElementById('boxQuantity');

            // Function to display the error message
            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
            }

            // Function to hide the error message
            function hideError() {
                errorMessage.style.display = 'none';
            }
            // Perform client-side validation here if needed
            var boxQuantity = document.getElementById('boxQuantity').value;
            if (!boxQuantity || isNaN(boxQuantity) || boxQuantity <= 0) {
                // Prevent the default form submission behavior
                event.preventDefault();

                // Optionally, display an error message to the user greater
                // alert('Please enter a valid number for Box Quantity.');
                //  showError('Quantity field is required and must be at least 1');
                showError('Quantity field is required and it should be greater than 0');
                // Keep the modal open
                event.stopPropagation();
            } else {
                hideError();
              //  document.getElementById("myForm").reset(); // Replace "myForm" with the id of your form
            }
        });
        });
        // here check for updated box details
    document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    var form = document.getElementById('updatedmyForm');

    // Add event listener for form submission
    form.addEventListener('submit', function(event) {

        var errorMessage1 = document.getElementById('errorMessage1');
        var boxWeightInput = document.getElementById('box_weight');
        var productCategoryInput = document.getElementById('product_category');
        var boxWeightValidation = document.getElementById('boxWeightValidation');
        var productCategoryValidation = document.getElementById('productCategoryValidation');

        // Function to display the error message
        function showError(element, message) {
            element.textContent = message;
            element.style.display = 'block';
        }

        // Function to hide the error message
        function hideError(element) {
            element.style.display = 'none';
        }

        // Perform client-side validation
        var boxWeight = parseFloat(boxWeightInput.value);
        var productCategory = productCategoryInput.value;

        // Reset validation messages
        hideError(boxWeightValidation);
        hideError(productCategoryValidation);

        if (!boxWeight || isNaN(boxWeight) || boxWeight <= 0) {
            event.preventDefault();
            showError(boxWeightValidation, 'Weight field is required and should be greater than 0');
            event.stopPropagation();
        }

        if (!productCategory) {
            event.preventDefault();
            showError(productCategoryValidation, 'Product Category field is required');
            event.stopPropagation();
        }

        // Check if any validation errors occurred
        if (boxWeightValidation.style.display === 'block' || productCategoryValidation.style.display === 'block') {
            showError(errorMessage1, 'Please fix the errors and resubmit the form.');
        } else {
            hideError(errorMessage1);
        }
    });
});

       
    function clearBoxQuantityData(){
        document.getElementById("myForm").reset();
    }
    
    function clearBoxData() {
        document.getElementById("updatedmyForm").reset();
    }
    
    // Prevent default action when clicking on dropdown items
    document.addEventListener('DOMContentLoaded', function() {
        // Get all dropdown items
        var dropdownItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
        
        // Add event listener to each dropdown item
        dropdownItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
                // Prevent default action (e.g., redirection)
                event.preventDefault();
                
                // Add your custom logic here
                // For example, you can add code to handle the click event
                if (item.classList.contains('view-pallet')) {
                    // Get the URL from the href attribute
                    var url = item.getAttribute('href');
                    
                    // Redirect to the URL
                    window.location.href = url;
                } else if (item.classList.contains('edit-pallet')) {
                    // Handle edit pallet action
                } else if (item.classList.contains('submit-approval')) {
                    // Handle submit approval action
                }
            });
        });
    });