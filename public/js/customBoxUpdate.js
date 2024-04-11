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
        
         $(document).ready(function() {
            $('#updateBoxModal').on('show.bs.modal', function (event) {
               var button = $(event.relatedTarget);
                var palletId = button.data('pallet-id');
                var boxId = button.data('box-id');
                var NewBoxGenCode = button.data('box-gen-code');
                $('#materialFields1').html('');
                var BoxPackgingMaterialData = button.data('box-packging-material');
                // Initialize an empty string to store HTML
                var newMaterialFields = '';

                // Loop through the BoxPackgingMaterialData array
                BoxPackgingMaterialData.forEach(function(item) {
                    // Generate HTML for each item
                    var materialField = '<div class="row mb-3 material-field">' +
                        '<div class="col-md-4">' +
                        '<select class="form-select" name="material_type1[]">' +
                        '<option value="">Material Type</option>' +
                        '<option value="paper"' + (item.material_type === 'paper' ? ' selected' : '') + '>Paper</option>' +
                        '<option value="wood"' + (item.material_type === 'wood' ? ' selected' : '') + '>Wood</option>' +
                        '<option value="plastic"' + (item.material_type === 'plastic' ? ' selected' : '') + '>Plastic</option>' +
                        '<option value="shrink-wrap"' + (item.material_type === 'shrink-wrap' ? ' selected' : '') + '>Shrink-Wrap</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-4">' +
                        '<input type="number" class="form-control" name="material_weight1[]" value="' + item.material_weight + '" placeholder="Weight">' +
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
                $('#materialFields1').append(newMaterialFields);
                
                var palletGenCode = button.data('pallet-gen-code');
                var boxWeight = button.data('box-weight');
                var BoxsubBrands = button.data('box-sub-brands');
                var productCategory = button.data('box-product-category');
                
                var preConsumer = button.data('box-pre-consumer');
                var selectedConsumer = preConsumer == 1 ? 'yes' : 'no';
                $('#BoxpalletId').text(palletGenCode);
                // $('#').text(boxWeight);
                // $('#product_category').text(product_category);
                $('#BoxsubBrands').text(BoxsubBrands);
                $('#NewBoxGenCode').text(NewBoxGenCode);
                alert(palletId);
                $(this).find('#palletId').val(palletId);
                $(this).find('#boxId').val(boxId);
                $(this).find('#box_weight').val(boxWeight);
                $(this).find('#product_category').val(productCategory);
                $(this).find('#pre_consumer').val(selectedConsumer);
            });
        });