function addNewTranslation() {
    // Set the form action URL to the desired route for "Save & Open"
    // document.getElementById("translationForm").action = "{{ route('admin.translations.store') }}";
    // Submit the form
    var form = document.getElementById("translationForm");
    // let tabId = this.getAttribute('aria-controls');
    // console.log('check value of selected tab=======', tabId);
    // Perform client-side validation
    if (!form.checkValidity()) {
        // If the form is invalid, trigger the form validation
        form.reportValidity();
        return;
    }
    document.getElementById("translationForm").submit();
}

function exportSampleCsv1(){
   // Get input values
    // var sampleName = document.getElementById("sampleName").value;
    // var rowName = document.getElementById("rowName").value;

    sampleName = 'Key name';
    rowName = 'Value name';
    // Define sample data
    var data = [
        [sampleName, rowName],
        ['welcome', 'welkom'],
        ['language', 'taal'],
    ];

    // Convert data to CSV format
    var csvContent = "data:text/csv;charset=utf-8,";
    data.forEach(function(rowArray) {
        var row = rowArray.join(",");
        csvContent += row + "\r\n";
    });

    // Create a hidden anchor element
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "sample_data.csv");
    document.body.appendChild(link);

    // Trigger the click event to download the CSV file
    link.click();
}

function exportSampleCsv() {
    var language = document.querySelector('select[name="language"]').value;
    // var url = "{{ route('admin.translations.export.sample.csv') }}?language=" + language;
    var exportUrl = document.querySelector('.create-store-btn-size').getAttribute('data-export-url');
    var url = exportUrl + '?language=' + language;
    // alert(url);
    // return true;
    // Trigger AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'blob';
    xhr.onload = function () {
        
        if (xhr.status === 200) {
            // Create a temporary anchor element to initiate the download
            var a = document.createElement('a');
            a.href = window.URL.createObjectURL(xhr.response);
            a.download = 'sample_translations_' + language + '.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
        else {
            alert('Translations not found for the selected language.');
        }
    };
    xhr.send();
}

function clearFormData() {
    // Clear input field values
   document.getElementById("translationForm").reset();
}