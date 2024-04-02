
 $(document).ready(function() {
            $('#dataTable').DataTable();
        });
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
    function clearBoxQuantityData(){
        document.getElementById("myForm").reset();
    }