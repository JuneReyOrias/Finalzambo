@extends('agent.agent_Dashboard')

@section('agent')

@extends('layouts._footer-script')
@extends('layouts._head')

<style>

.custom-cell {
    font-size: 14px;
    width: 150px; /* Adjust the width as needed */
    padding: 8px; /* Adjust the padding as needed */

}
</style>

<div class="page-content">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">

                    
                    <h4>Crop Data</h4>
                </div>
                <br>
                @if (session()->has('message'))
                <div class="alert alert-success" id="success-alert">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        
              {{session()->get('message')}}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
                    <!-- Your card content here -->
                    <div class="tabs">
                        <input type="radio" name="tabs" id="personainfo" checked="checked">
                       
                
                        <label for="personainfo">Crop</label>
                        
                        <div class="tab">
                        
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{-- <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button> --}}
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                <a href="{{ route('agent.FarmerInfo.CrudCrop.Add',$farmData->id)}}" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                              
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="" title="back">
                                    
                                      
                                  
                                 </a>
                                 <div class="input-group mb-3">

                                    @php
                                        if (!function_exists('formatName')) {
                                    function formatName($name) {
                                        return ucwords(strtolower(trim($name)));
                                    }
                                }

                                    @endphp 
                                    @if($personalInfos->isNotEmpty())
                                        @foreach($personalInfos as $personalInfo)
                                            <h5 for="personainfo">
                                                Farmer: {{ formatName($personalInfo->first_name) }} {{ formatName($personalInfo->last_name) }}
                                            </h5>
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No personal information available.</h5>
                                    @endif
                                </div>
                                
                                
                                
                                
                                   
                              
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">

                                 </a>
                                  {{-- Loop through each crop in $cropFarms --}}
                            @php
                            // Array to track displayed farm profiles by their unique ID
                            $displayedFarms = [];
                        @endphp
                        
                        @foreach ($cropFarms as $crop)
                            {{-- Check if the farm profile has already been displayed --}}
                            @if (!in_array($crop->farmprofile->id, $displayedFarms))
                                <div class="input-group mb-3">
                                    <h5 for="personainfo">Farm: {{ formatName($crop->farmprofile->tenurial_status) }}</h5>
                                </div>
                        
                                {{-- Add the farm profile ID to the array to mark it as displayed --}}
                                @php
                                    $displayedFarms[] = $crop->farmprofile->id;
                                @endphp
                            @endif
                        @endforeach
                             
                                
                           

                            </div>
                            <form method="GET" action="{{ route('agent.FarmerInfo.crops_view',$farmData->id) }}">
                                <div class="user-details">
      
                                    <div class="input-box">
                                        <select lass="form-control light-gray-placeholder" name="crop_name" id="selectCrop" onchange="this.form.submit()">
                                            
                                            <option value="All" {{ request('crop_name') == 'All' ? 'selected' : '' }}>All Crop</option>
                                            @foreach($cropData->pluck('crop_name')->unique() as $cropName)
                                           
                                                <option value="{{ $cropName }}" {{ request('crop_name') == $cropName ? 'selected' : '' }}>
                                                    {{ $cropName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                            <th>#</th>
                                            <th>type of <p>variety planted</p></th>
                                            <th>Planting Schedule <p>wet season</p></th>
                                            <th>Planting Schedule <p>dry season</p></th>
                                            <th>No. of cropping <p>per year</p></th>
                                            <th>yield_kg_ha</th>
                                       
                                           
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($cropData->count() > 0)
                                    @foreach($cropData as $cropdata)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $cropdata->id }}</td>
                                    
                                   
                                    <td>
                                        @if ($cropdata->type_of_variety_planted && strtolower($cropdata->type_of_variety_planted) != 'n/a')
                                            {{ $cropdata->type_of_variety_planted }}
                                        @elseif ($cropdata->preferred_variety && strtolower($cropdata->preferred_variety) != 'n/a')
                                            {{ $cropdata->preferred_variety }}
                                        @else
                                            <!-- Optionally, you can add a placeholder like 'N/A' here if both values are null or 'n/a' -->
                                        @endif
                                    </td>
                                    
                                        <td>
                                        @if ($cropdata->planting_schedule_wetseason && strtolower($cropdata->planting_schedule_wetseason) != 'n/a')
                                            {{ $cropdata->planting_schedule_wetseason }}
                                        @else
                                        
                                        @endif
                                        </td>
                                        <td>
                                        @if ($cropdata->planting_schedule_dryseason && strtolower($cropdata->planting_schedule_dryseason) != 'n/a')
                                            {{ $cropdata->planting_schedule_dryseason }}
                                        @else
                                        
                                        @endif
                                        </td>
                    
                                        <td>
                                        @if ($cropdata->no_of_cropping_per_year && strtolower($cropdata->no_of_cropping_per_year) != 'n/a')
                                            {{ $cropdata->no_of_cropping_per_year }}
                                        @else
                                        
                                        @endif
                                        </td>
                    
                                        <td>
                                        @if ($cropdata->yield_kg_ha && strtolower($cropdata->yield_kg_ha) != 'n/a')
                                            {{ $cropdata->yield_kg_ha }}
                                        @else
                                        
                                        @endif
                                        </td>
                                       
                     
                    
                       <td>
                        <a href="{{route('agent.FarmerInfo.production_view', $cropdata->id)}}" title="View production">
                            <button class="btn btn-success btn-sm">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                     
                        <a href="javascript:void(0);" class="viewCropBtn" data-bs-toggle="modal" title="View Crop" data-bs-target="#CropModal" data-id="{{ $cropdata->id}}">
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-leaf" aria-hidden="true"></i>
                            </button>
                        </a>   
                        
                        <a href="javascript:void(0);" class="viewCropArchive" data-bs-toggle="modal" title="View Crop Archive Data" data-bs-target="#CropArchiveModal" data-id="{{$cropdata->id }}">
                            <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                                <img src="../assets/logo/history.png" alt="Crop Icon" style="width: 20px; height: 20px;" class="me-1">
                                <i class="fas fa-rice" aria-hidden="true"></i>
                            </button>
                        </a>  
                        <a href="{{route('agent.FarmerInfo.CrudCrop.edit', $cropdata->id)}}" title="edit crop"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('agent.FarmerInfo.CrudCrop.delete', $cropdata->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                           {{-- {{ csrf_field()}} --}}@csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                       </form>

                       </td>
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Crop Data is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                
                                <!-- Pagination links -->
                                <ul class="pagination">
                                    <li><a href="{{ $cropData->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($cropData->getUrlRange(max(1, $cropData->currentPage() - 1), min($cropData->lastPage(), $cropData->currentPage() + 1)) as $page => $url)
                                        <li class="{{ $page == $cropData->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                    <li><a href="{{ $cropData->nextPageUrl() }}">Next</a></li>
                                </ul>
                                

                            </div>
                            <!-- Pagination links -->
                            <div class="button-container mt-3 d-flex justify-content-between">
                                <a href="{{ route('agent.FarmerInfo.farm_view', $farmData->personal_informations_id) }}" button type="button" class="btn btn-primary" onclick="goBack()">Back</button></a>
                              
                            </div>
                            
                        </div>


    
                                
                      
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal of crop archive --}}
<div class="modal fade" id="CropArchiveModal" tabindex="-1" aria-labelledby="CropArchiveModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white" id="CropArchiveModal">Crop Archive Data History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="archives-modal-body">
                <br>
                <div id="table-scroll" class="table-scroll">
                    <div class="table-wrap">
                        <table class="main-table table table-bordered table-striped table-hover">
                            <thead class="bg-light text-dark text-center sticky-top">
                                <tr>
                                    <th class="fixed-side" scope="col"><i class="fas fa-calendar-alt me-1"></i>Date Updated</th>
                                   <th>Crop Name</th>
                                   <th scope="col">Variety</th>
                                 
                                   <th scope="col">Planting Sched(Wet Season)</th>
                                   <th scope="col">Planting Sched(Dry Season)</th>
                                   <th scope="col">No. of Cropping/yr</th>
                                   <th scope="col">Yield</th>
                                  
                                  
                                    
                                    
                                </tr>
                            </thead>
                            <tbody id="archiveHistory">
                                <!-- Rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="CropModal" tabindex="-1" aria-labelledby="CropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="CropModalLabel">Crop Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                        <div class="container mt-4">
                            <h6 class="fw-bold mb-3">Crops Details</h6>
                             <!-- Farmer Information -->
                             <h5>Farmer: {{ $personalInfos->isNotEmpty() ? formatName($personalInfos->first()->first_name . ' ' . $personalInfos->first()->last_name) : 'N/A' }}</h5>
                            
                             <!-- Farm Profile Information -->
                             <h6>Farm Status: {{ $farmData ? formatName($farmData->tenurial_status) : 'No farm information available.' }}</h6>
                           <br>
                            </ul><div class="accordion" id="machineryAccordion">
                                <!-- Plowing Accordion -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="plowingHeading">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                            a. Crops Info
                                        </button>
                                    </h2>
                                    <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                        <div class="accordion-body">
                                            <ul class="list-unstyled farmer-details">
                                                <li><strong>Crop Name</strong> <span id="crop_name"></span></li>
                                                <li><strong>Variety Planted</strong> <span id="type_of_variety_planted"></span></li>
                                                <li><strong>Planting schedule(Wet):</strong> <span id="planting_schedule_wetseason"></span></li>
                                                <li><strong>Planting schedule(Dry):</strong> <span id="planting_schedule_dryseason"></span></li>
                                                <li><strong>No of cropping:</strong> <span id="no_of_cropping_per_year"></span></li>
                                                <li><strong>Yield:</strong> <span id="yield_kg_ha"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Harrowing Accordion -->
                             
                            
                                
                                
                            </div>
                        </div>
                        
                        
                    
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>


<style>
    /* Modal Content Styling */
   .modal-content {
       border-radius: .5rem;
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
   }
   
   /* Farmer Details Styling */
   .farmer-details {
       list-style: none;
       padding: 0;
       margin: 0;
   }
   
   .farmer-details li {
       margin-bottom: .5rem;
       padding: .5rem 0;
       border-bottom: 1px solid #e9ecef;
   }
   
   .farmer-details li strong {
       font-weight: 600;
   }
   
   .farmer-details li span {
       color: #ffffff;
       background-color: #6c757d; /* Gray background */
       padding: 2px 6px; /* Adds some space around the text */
       border-radius: 4px; /* Rounded corners for a nice effect */
   }
   
   /* Container Styling */
   .container {
       margin-bottom: 1.5rem;
   }
   </style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('searchInput');
        const farmProfileSearchForm = document.getElementById('farmProfileSearchForm');
        const showAllForm = document.getElementById('showAllForm');
  
        let timer;
  
        // Add event listener for search input
        searchInput.addEventListener('input', function() {
            // Clear previous timer
            clearTimeout(timer);
            // Start new timer with a delay of 500 milliseconds (adjust as needed)
            timer = setTimeout(function() {
                // Submit the search form
                farmProfileSearchForm.submit();
            }, 1000);
        });
  
        // Add event listener for "Show All" button
        showAllForm.addEventListener('click', function(event) {
            // Prevent default form submission behavior
            event.preventDefault();
            // Remove search query from input field
            searchInput.value = '';
            // Submit the form
            showAllForm.submit();
        });
    });
  </script>
   <script>
    function goBack() {
        window.history.back(); // This will go back to the previous page in the browser history
    }
    </script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selectCrop').on('change', function() {
                // Get the selected value
                const cropName = $(this).val();
                const farmId = {{ $farmData->id }}; // Pass farm ID from the server
    
                // Send AJAX request
                $.ajax({
                    url: `/agent-FarmerInfo/crops_view/${farmId}`, // Adjust the URL as needed
                    method: 'GET',
                    data: { crop_name: cropName },
                    success: function(response) {
                        // Update the UI based on the response
                        // For example, update a section of the page with the received data
                        $('#resultContainer').html(response); // Assume you have a container to update
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });



        // Function to fetch and display Variable cost Cost data
$(document).on('click', '.viewCropBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    CropsData(id); // Fetch data and show the modal
});

$(document).on('click', '.viewCropBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    CropsData(id); // Fetch data and show the modal
});

function CropsData(id) {
    $.ajax({
        url: '/agent-edit-farmer-crops/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'cropfarm' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {

                
                // Populate the modal with the fetched data
                $('#crop_name').text(response.crop_name || 'N/A');
                $('#type_of_variety_planted').text(response.type_of_variety_planted || 'N/A');
                $('#planting_schedule_wetseason').text(response.planting_schedule_wetseason || 'N/A');
                $('#planting_schedule_dryseason').text(response.planting_schedule_dryseason || 'N/A');
                $('#no_of_cropping_per_year').text(response.no_of_cropping_per_year || 'N/A');
                $('#yield_kg_ha').text(response.yield_kg_ha ? parseFloat(response.yield_kg_ha).toFixed(2) : 'N/A');
              

           
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}


// Handle click event for viewing farm archive
$(document).on('click', '.viewCropArchive', function () {
    var id = $(this).data('id'); // Get the ID from the data attribute
    CropArchiveData(id); // Fetch data and show the modal
});
// Function to fetch archive data
function CropArchiveData(id) {
    $.ajax({
        url: `/agent-edit-farmer-crops/${id}`, // URL to fetch data
        type: 'GET',
        dataType: 'json',
        data: { type: 'archives' }, // Requesting specifically for archives
        success: function (response) {
            console.log("Response:", response); // Debugging the response

            // Handle case when no archives are available
            if (response.message) {
                alert(response.message); // Display message to the user
                $('#archiveHistory').empty(); // Clear the table content
                return; // Stop further processing
            }

            // Assuming `response` contains the array of archive data
            const archives = response;

            // Clear the table body
            $('#archiveHistory').empty();

            // Loop through each archive and create table rows
            archives.forEach(function (archive) {
                console.log("Processing Archive:", archive); // Debugging each archive entry

                // Format the updated date
                const dateUpdated = archive.created_at
                    ? new Date(archive.created_at).toLocaleDateString() 
                    : 'N/A';

                // Create a table row with archive data
                const archiveRow = `
                    <tr>
                        <th class="fixed-side">${dateUpdated}</th>
                        <td>${archive.crop_name || 'N/A'}</td>
                        <td>${archive.type_of_variety_planted || archive.preferred_variety || 'N/A'}</td>
                        <td>${archive.planting_schedule_wetseason || 'N/A'}</td>
                        <td>${archive.planting_schedule_dryseason || 'N/A'}</td>
                        <td>${archive.no_of_cropping_per_year || 'N/A'}</td>
                        <td>${archive.yield_kg_ha || 'N/A'}</td>
                       
                    </tr>
                `;

                // Append the row to the table body
                $('#archiveHistory').append(archiveRow);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', xhr.responseText); // Log detailed error
            if (xhr.status === 404) {
                alert('Farm Profile not found or no archives available.');
            } else {
                alert(`An error occurred: ${xhr.statusText}`); // Display error message
            }
            $('#archiveHistory').empty(); // Clear the table in case of error
        }
    });
}

    </script>
    

    <style>

        .custom-cell {
            font-size: 14px;
            width: 150px; /* Adjust the width as needed */
            padding: 8px; /* Adjust the padding as needed */
        
        }
        
        
        
        /* Style the modal content to make sure the table fits inside */
        #archives-modal-body {
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 200vh; /* Adjust the height based on your requirements */
          
        }
        
        /* Table Scroll Container */
        .table-scroll {
            position: relative;
            max-width: 100%;
            margin: 0 auto;
            overflow-x: auto;  /* Horizontal scrolling */
            overflow-y: auto;  /* Vertical scrolling */
        }
        
        /* Table Wrapper */
        .table-wrap {
            width: 100%;
            overflow: auto;
        }
        
        /* Table styling */
        .main-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        /* Sticky column */
        .fixed-side {
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            z-index: 1;
            border-right: 1px solid #ddd; /* Optional: adds border between sticky column and content */
            box-shadow: 1px 0 0 0 #ddd; /* Optional: adds shadow to improve visibility */
        }
        
        /* Styling table headers */
        .main-table th {
            padding: 10px 15px;
            text-align: left;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        
        /* Styling table data cells */
        .main-table td {
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        
        /* Add styles for table body */
        .main-table tbody {
            background-color: #fff;
        }
        
        
        
        
            .fixed-side {
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            z-index: 2;
            border-right: 1px solid #ddd; /* Optional: Adds a border between sticky column and content */
        }
         .table-scroll {
            position:relative;
            max-width:600px;
            margin:auto;
            overflow:hidden;
            border:1px solid #000;
          }
        .table-wrap {
            width:100%;
            overflow:auto;
        }
        .table-scroll table {
            width:100%;
            margin:auto;
            border-collapse:separate;
            border-spacing:0;
        }
        .table-scroll th, .table-scroll td {
            padding:5px 10px;
            border:1px solid #000;
            background:#fff;
            white-space:nowrap;
            vertical-align:top;
        }
        .table-scroll thead, .table-scroll tfoot {
            background:#f9f9f9;
        }
        .clone {
            position:absolute;
            top:0;
            left:0;
            pointer-events:none;
        }
        .clone th, .clone td {
            visibility:hidden
        }
        .clone td, .clone th {
            border-color:transparent
        }
        .clone tbody th {
            visibility:visible;
            color:red;
        }
        .clone .fixed-side {
            border:1px solid #000;
            background:#eee;
            visibility:visible;
        }
        .clone thead, .clone tfoot{background:transparent;}
        
          </style>
          <script>// requires jquery library
          new DataTable('#example');
            jQuery(document).ready(function() {
              jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
             });</script>
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
@endsection
