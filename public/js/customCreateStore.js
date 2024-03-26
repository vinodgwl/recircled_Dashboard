// custom.js

$(document).ready(function() {
    $('#dataTable').DataTable();
});

document.addEventListener('DOMContentLoaded', function () {
    const palletWeightInputs = document.querySelectorAll('.pallet-weight-input');
        
    palletWeightInputs.forEach(input => {
        input.addEventListener('input', function () {
            if (parseFloat(input.value) < 1) {
                input.value = 1;
            }
            let totalWeight = 0;
            palletWeightInputs.forEach(input => {
                totalWeight += parseFloat(input.value) || 0;
            });
            let totel_weight  = $('#totel_weight').val();
            // Ensure the input value is at least 1
            
            console.log('totel weight is here=======', totalWeight, 'and totel weight=====', totel_weight);
            if (totalWeight > totel_weight) {
                // toastr.error('Total weight exceeds 100 lbs.');
                // You may add additional logic here if needed
                document.getElementById('totalWeightError').classList.remove('d-none');
                document.getElementById('submitBtn').setAttribute('disabled', 'disabled');
                 document.getElementById('saveAndOpenBtn').setAttribute('disabled', 'disabled');
            } else {
                // Here you can submit the form or perform other actions
                 document.getElementById('totalWeightError').classList.add('d-none');
                 document.getElementById('submitBtn').removeAttribute('disabled');
                 document.getElementById('saveAndOpenBtn').removeAttribute('disabled');
            }
        });
    });
});

function showToastr() {
    toastr.success('This is a success message!666', 'Success');
    // toastr.info('Total weight exceeds 100 lbs.');
    // toastr.error('This is a success message!', '', { 
    //     timeOut: 3000,
    //     positionClass: 'toast-top-right'
    // });
}

function saveAndOpen() {
    // Set the form action URL to the desired route for "Save & Open"
    document.getElementById("palletForm").action = "{{ route('trackbackProductSaveAndOpen.update.stores') }}";
    // Submit the form
    var form = document.getElementById("palletForm");
    // Perform client-side validation
    if (!form.checkValidity()) {
        // If the form is invalid, trigger the form validation
        form.reportValidity();
        return;
    }
    document.getElementById("palletForm").submit();
}
