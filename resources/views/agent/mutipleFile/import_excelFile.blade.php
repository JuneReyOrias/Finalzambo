@extends('agent.agent_Dashboard')

@section('agent')


<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-8 grid-margin">
            <div class="card border rounded shadow-sm">
                <div class="card-body">
                    <!-- Alerts for Success and Errors -->
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li><i class="bi bi-x-circle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Card Title -->
                    <h5 class="card-title text-center mb-4">Multiple Import File</h5>
                    <p class="text-muted text-center mb-4">Import Excel, CSV, or MS Access files only.</p>

                    <!-- File Upload Form -->
                    <form id="upload-form" method="post" enctype="multipart/form-data" class="text-center">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="file" name="upload_file"  style="max-width: 400px; margin: 0 auto;">
                        </div>
                        <button type="submit" class="btn btn-success btn-lg px-5">Upload</button>
                    </form>

                    <!-- Download Data Import Template -->
                    <div class="text-center mt-5">
                        <h5>Download Data Import Template</h5>
                        <p class="text-muted mb-3">Click below to download the Excel template for importing data.</p>
                        <a href="{{ url('agent-import-multipleFile') }}" class="btn btn-primary btn-lg px-5" id="download-template">
                            Download 
                        </a>
                    </div>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                </div>
            </div>
        </div>
    </div>
</div>


            @endsection
            @push('scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#upload-form').submit(function(e) {
                        e.preventDefault(); // Prevent the default form submission
                        saveForm(); // Call the saveForm function
                    });
                });
            
                function saveForm() {
                    var formData = new FormData($('#upload-form')[1]); // Get form data
                    $.ajax({
                        type: "POST",
                        url: "{{ url('AgentsaveUploadForm') }}", // Adjust the route name to match your route
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            $('.form-errors').html('');
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            </script>

<script>
$(document).ready(function() {
    $('#download-template').click(function(e) {
        e.preventDefault(); // Prevent the default action
        downloadTemplate(); // Call the function to download the template
    });
});

function downloadTemplate() {
    $.ajax({
        type: "GET", // The method for the request
        url: "{{ url('agent-import-multipleFile') }}", // Make sure the URL matches your route
        xhrFields: {
            responseType: 'blob' // Ensure the response is treated as a binary file
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
        },
        success: function(response) {
            // Create a blob from the response
            var blob = response;
            var link = document.createElement('a');
            var url = window.URL.createObjectURL(blob);
            link.href = url;
            link.download = 'data_import_template.xlsx'; // Set the filename for download

            // Append the link to the body, trigger a click, and remove the link
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url); // Release the object URL
        },
        error: function(xhr, status, error) {
            console.error('Error downloading file:', status, error);
            alert('There was an error downloading the template.');
        }
    });
}

    </script>
    
            @endpush
            