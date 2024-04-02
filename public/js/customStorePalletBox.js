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
            var boxId = button.data('box-id');
            var box_weight = button.data('box_weight');
            var productCategory = button.data('product-category');
            var preConsumer = button.data('pre-consumer');
            // $('#boxTotelWeight').text(box_weight);
            $(this).find('#boxTotelWeight').val(box_weight);
            $(this).find('#preConsumer').val(preConsumer);
            $(this).find('#productCategory').val(productCategory);
            // alert(preConsumer);
            $(this).find('#boxId').val(boxId);
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
        // alert($id);
        // document.getElementById("boxform").submit();
        if (confirm('Are you sure you want to delete this box?')) {
            document.getElementById("boxform").submit();
        }
    }
    function clearBoxQuantityData (){
        console.log('clear value');
        // conole.log('ok')
    }