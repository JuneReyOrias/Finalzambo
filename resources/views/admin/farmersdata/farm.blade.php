@extends('admin.dashb')
@section('admin')

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

                    
                    <h4>Farm Data</h4>
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
                       
                
                        <label for="personainfo">Farm</label>
                        
                        <div class="tab">
                        
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{-- <a href="{{route('agent.FarmerInfo.farmers_view')}}" title="back">
                                    
                                         <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                  
                                 </a> --}}
                                 <div class="input-group mb-3">
                                    @php
                                        // Check if the formatName function is not already defined
                                        if (!function_exists('formatName')) {
                                            function formatName($name) {
                                                return ucwords(strtolower(trim($name))); // Converts to "Title Case"
                                            }
                                        }
                                        
                                        // Create an array to track unique personal_informations_id
                                        $uniqueFarmers = [];
                                    @endphp
                                
                                    <!-- Check if $farmData is not empty -->
                                    @if($farmData->isNotEmpty())
                                        @foreach($farmData as $farm)
                                            <!-- Check if personalInformation relation is loaded and the ID is unique -->
                                            @if($farm->personalInformation && !in_array($farm->personalInformation->id, $uniqueFarmers))
                                                <h5 for="personainfo">
                                                    Farmer: 
                                                    <!-- Apply the formatName function to first_name and last_name -->
                                                    {{ formatName($farm->personalInformation->first_name) . ' ' . formatName($farm->personalInformation->last_name) }}
                                                </h5>
                                                
                                                @php
                                                    // Add this personal_informations_id to the uniqueFarmers array
                                                    $uniqueFarmers[] = $farm->personalInformation->id;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No farm data available.</h5>
                                    @endif
                                </div>
                                
                                <a href="{{route('farm_profile.farm_index',$personalinfos->id)}}" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
                            
                                {{-- <form id="farmProfileSearchForm" action="{{ route('agent.FarmerInfo.farmers_view') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('agent.FarmerInfo.farmers_view') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                            <th>#</th>
                                         
                                            <th>Agri-District</th>
                                            <th>tenurial status</th>
                                            <th>farm address</th>
                                            <th>years as farmer</th>
                                           
                                            <th>total physical area </th>
                                            <th>total_area_cultivated</th>
                                        
                                         
                                            
                                            
                                            <th>date_interview</th>
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($farmData->count() > 0)
                                    @foreach($farmData as $farmprofile)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $farmprofile->id }}</td>
                                    
                            <td>
                                @if ($farmprofile->agriDistrict->district && $farmprofile->agriDistrict->district != 'N/A')
                                    {{ $farmprofile->agriDistrict->district }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($farmprofile->tenurial_status && $farmprofile->tenurial_status != 'N/A')
                                    {{ $farmprofile->tenurial_status }}
                                @else
                                
                                @endif
                            </td>
                            <td>
                            @if ($farmprofile->farm_address && $farmprofile->farm_address != 'N/A')
                                {{ $farmprofile->farm_address }}
                            @else
                      
                                    @endif
                                </td>
                                <td>
                                    @if ($farmprofile->no_of_years_as_farmers && $farmprofile->no_of_years_as_farmers != 'N/A')
                                        {{ $farmprofile->no_of_years_as_farmers }}
                                    @else
                                    
                                    @endif
                                </td>

                              
                            <td>
                                @if ($farmprofile->total_physical_area && strtolower($farmprofile->total_physical_area) != 'n/a')
                                    {{ number_format($farmprofile->total_physical_area,2) }}
                                @else
                                
                                @endif
                            </td>
                            <td>
                                @if ($farmprofile->total_area_cultivated && strtolower($farmprofile->total_area_cultivated) != 'n/a')
                                    {{ number_format($farmprofile->total_area_cultivated,2) }}
                                @else
                                
                                @endif
                            </td>
                        {{-- <td>
                            @if ($farmprofile->land_title_no && strtolower($farmprofile->land_title_no) != 'n/a')
                                {{ $farmprofile->land_title_no }}
                            @else
                            
                            @endif
                        </td>
                        <td>
                            @if ($farmprofile->lot_no && strtolower($farmprofile->lot_no) != 'n/a')
                                {{ $farmprofile->lot_no }}
                            @else
                            
                            @endif
                        </td> --}}
                     
                  
                    <td>{{ $farmprofile->date_interview}}</td>
                    
                       <td>
                        <a href="{{route('admin.farmersdata.crop', $farmprofile->id)}}" title="View Crop">
                            <button class="btn btn-success btn-sm">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="{{route('farm_profile.farmer_profile', $farmprofile->id)}}" title="View farmer Profile">
                            <button class="btn btn-success btn-sm">
                                <img src="../assets/logo/farmer-profile.png" alt="Crop Icon" style="width: 20px; height: 15px;" class="me-1">
                            </button>
                        </a>
                        <a href="javascript:void(0);" class="viewfarmBtn" data-bs-toggle="modal" title="View farm" data-bs-target="#farmModal" data-id="{{ $farmprofile->id }}">
                            <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                                <img src="../assets/logo/farm.png" alt="Crop Icon" style="width: 20px; height: 20px;" class="me-1">
                                <i class="fas fa-rice" aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="javascript:void(0);" class="viewfarmBtn" data-bs-toggle="modal" title="User Assign as Farmers" data-bs-target="#UserprofileAssignModal" data-id="{{ $farmprofile->id }}">
                            <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                                <img src="../assets/logo/farmer-Assign.png" alt="Crop Icon" style="width: 20px; height:15px;" class="me-1">
                                <i class="" aria-hidden="true"></i>
                            </button>
                        </a>
                                                   
                        <a href="{{route('farm_profile.farm_edit', $farmprofile->id)}}" title="view farm"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('agent.farmprofile.delete', $farmprofile->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                           {{-- {{ csrf_field()}} --}}@csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                       </form>

                       </td>
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Farm Profile Data is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                
                                <!-- Pagination links -->
                                {{-- <ul class="pagination">
                                    <li><a href="{{ $farmData->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($farmData->getUrlRange(max(1, $farmData->currentPage() - 1), min($farmData->lastPage(), $farmData->currentPage() + 1)) as $page => $url)
                                    <li class="{{ $page == $farmData->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                    <li><a href="{{ $farmData->nextPageUrl() }}">Next</a></li>
                                </ul> --}}

                            </div>
                            <!-- Pagination links -->
                              <ul class="pagination">
                                    <li><a href="{{ $farmData->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($farmData->getUrlRange(max(1, $farmData->currentPage() - 1), min($farmData->lastPage(), $farmData->currentPage() + 1)) as $page => $url)
                                    <li class="{{ $page == $farmData->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                    <li><a href="{{ $farmData->nextPageUrl() }}">Next</a></li>
                                </ul>

                                <div class="button-container mt-3 d-flex justify-content-between">
                                    <a href="{{ route('admin.farmersdata.genfarmers') }}" button type="button" class="btn btn-primary" onclick="goBack()">Back</button></a>
                                  
                                </div>
                            
                        </div>


    
                                
                      
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



{{-- farmt --}}
<div class="modal fade" id="farmModal" tabindex="-1" aria-labelledby="farmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="farmModalLabel">Farm Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Farmer Details -->
        
                <div class="col-md-9">
                    <!-- Farmer Information -->
                    @php
                    // Check if the formatName function is not already defined
                    if (!function_exists('formatName')) {
                        function formatName($name) {
                            return ucwords(strtolower(trim($name))); // Converts to "Title Case"
                        }
                    }
                    
                    // Create an array to track unique personal_informations_id
                    $uniqueFarmers = [];
                @endphp
            
                <!-- Check if $farmData is not empty -->
                @if($farmData->isNotEmpty())
                    @foreach($farmData as $farm)
                        <!-- Check if personalInformation relation is loaded and the ID is unique -->
                        @if($farm->personalInformation && !in_array($farm->personalInformation->id, $uniqueFarmers))
                            <h5 for="personainfo">
                                Farmer: 
                                <!-- Apply the formatName function to first_name and last_name -->
                                {{ formatName($farm->personalInformation->first_name) . ' ' . formatName($farm->personalInformation->last_name) }}
                            </h5>
                            
                            @php
                                // Add this personal_informations_id to the uniqueFarmers array
                                $uniqueFarmers[] = $farm->personalInformation->id;
                            @endphp
                        @endif
                    @endforeach
                @else
                    <h5 for="personainfo">No farm data available.</h5>
                @endif
                </div>
            

                <!-- Production Data -->
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">Farm Cost Details</h6>
                    
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a. Farm Location Info
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Particular:</strong> <span id="tenurial_status"></span></li>
                                        <li><strong>Farm Address:</strong> <span id="farm_address"></span></li>
                                        <li><strong>GPS Longitude:</strong> <span id="gps_longitude"></span></li>
                                        <li><strong>GPS Latitude:</strong> <span id="gps_latitude"></span></li>
                                        <li><strong>Total Physical Area (has):</strong> <span id="total_physical_area"></span></li>
                                        <li><strong>Total Area Cultivated (has):</strong> <span id="total_area_cultivated"></span></li>
                                        <li><strong>Land Title No:</strong> <span id="land_title_no"></span></li>
    
                                        <li><strong>Lot No:</strong> <span id="lot_no"></span></li>
                                        <li><strong>Area Prone To:</strong> <span id="area_prone_to"></span></li>
                                        <li><strong>Ecosystem:</strong> <span id="ecosystem"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                      
                    
                        <!-- Harvesting Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="harvestingHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#harvestingCollapse" aria-expanded="false" aria-controls="harvestingCollapse">
                                    b. Insurance and Financial Info
                                </button>
                            </h2>
                            <div id="harvestingCollapse" class="accordion-collapse collapse" aria-labelledby="harvestingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>RSBA Register:</strong> <span id="rsba_registered"></span></li>
                                        <li><strong>PCIC Insured:</strong> <span id="pcic_insured"></span></li>
                                        <li><strong>Government Assisted:</strong> <span id="government_assisted"></span></li>
                                        <li><strong>Source of Capital:</strong> <span id="source_of_capital"></span></li>
                                        <li><strong>Remarks/Recommendation:</strong> <span id="remarks_recommendation"></span></li>
                                     
                                        <li><strong>Name of Technicians:</strong> <span id="name_of_field_officer_technician"></span></li>
            
                                        <li><strong>Date of Interview::</strong> <span id="date_interviewed"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                       
                       
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UserprofileAssignModal" tabindex="-1" aria-labelledby="UserprofileAssignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="UserprofileAssignModalLabel">Assign Farmer Profile to User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <div class="form-group mt-3">
                    <label for="user_id">Select User:</label>
                    <select class="form-control" id="user_id">
                        <option value="">Select a user</option>
                        @foreach ($users as $item)
                        <option value="{{$item->id}}">{{$item->first_name.' '.$item->last_name}}</option>
                            
                        @endforeach
                    </select>
                </div> --}}
               
                    <div class="row">
                        <!-- User Selection -->
                       
                
                        <!-- Farmer Information -->
                        <div class="col-md-9">
                            @php
                                // Check if the formatName function is not already defined
                                if (!function_exists('formatName')) {
                                    function formatName($name) {
                                        return ucwords(strtolower(trim($name))); // Converts to "Title Case"
                                    }
                                }
                
                                // Create an array to track unique personal_informations_id
                                $uniqueFarmers = [];
                            @endphp
                
                            @if($farmData->isNotEmpty())
                                @foreach($farmData as $farm)
                                    @if($farm->personalInformation && !in_array($farm->personalInformation->id, $uniqueFarmers))
                                        <h5 for="personainfo" class="mt-3">
                                            Farmer: 
                                            {{ formatName($farm->personalInformation->first_name) . ' ' . formatName($farm->personalInformation->last_name) }}
                                        </h5>
                                        @php
                                            // Add this personal_informations_id to the uniqueFarmers array
                                            $uniqueFarmers[] = $farm->personalInformation->id;
                                        @endphp
                                    @endif
                                @endforeach
                            @else
                                <h5 for="personainfo" class="mt-3">No farm data available.</h5>
                            @endif
                        </div>
                        <h5 for="personainfo" class="mt-3">
                           Tenurial Status: <span id="tenurial_status"></span>
                        </h5>
                        <div class="form-group mt-3">
                            <label for="user_id">Select User:</label>
                            <select class="form-control" id="users_id">
                                <option value="">Select a user</option>
                                @foreach ($users as $item)
                                <option value="{{$item->id}}">{{$item->first_name.' '.$item->last_name}}</option>
                                    
                                @endforeach
                            </select>
                        </div>
                    </div>
               
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveUserProfile" data-id="{{ $farmprofile->id }}">Save</button>
            </div>
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



    // Function to fetch and display Variable cost Cost data
$(document).on('click', '.viewfarmBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
   FarmData(id); // Fetch data and show the modal
});

$(document).on('click', '.viewfarmBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
   FarmData(id); // Fetch data and show the modal
});

function FarmData(id) {
    $.ajax({
        url: '/admin-update-farmprofile/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'farmprofiles' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#tenurial_status').text(response.tenurial_status || 'N/A');
                $('#farm_address').text(response.farm_address || 'N/A');
                $('#gps_longitude').text(response.gps_longitude ? parseFloat(response.gps_longitude).toFixed(2) : 'N/A');
                $('#gps_latitude').text(response.gps_latitude ? parseFloat(response.gps_latitude).toFixed(2) : 'N/A');
                $('#total_physical_area').text(response.total_physical_area ? parseFloat(response.total_physical_area).toFixed(2) : 'N/A');


                $('#total_area_cultivated').text(response.total_area_cultivated ? parseFloat(response.total_area_cultivated).toFixed(2) : 'N/A');
                $('#lot_no').text(response.lot_no || 'N/A');
                $('#area_prone_to').text(response.area_prone_to || 'N/A');
                $('#ecosystem').text(response.ecosystem || 'N/A');

                $('#rsba_registered').text(response.rsba_registered || 'N/A');
                $('#pcic_insured').text(response.pcic_insured || 'N/A');

                $('#government_assisted').text(response.government_assisted || 'N/A');
                $('#source_of_capital').text(response.source_of_capital || 'N/A');
                $('#remarks_recommendation').text(response.remarks_recommendation || 'N/A');

                $('#name_of_field_officer_technician').text(response.name_of_field_officer_technician || 'N/A');
                $('#date_interviewed').text(response.date_interviewed || 'N/A');
              
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}


$('#saveUserProfile').on('click', function () {
    const farmProfileId = $(this).data('id'); // Fetch farmProfileId from the data-id attribute
    const userId = $('#users_id').val(); // Get the selected user ID

    // Log the farmProfileId and userId to check if they're correct
    console.log('Farm Profile ID:', farmProfileId);
    console.log('Selected User ID:', userId);

    if (userId) {
        $.ajax({
            url: '/admin-asign-farm-profile', // The route where you handle the request
            type: 'POST',
            data: {
                user_id: userId,
                farm_profile_id: farmProfileId,
                _token: '{{ csrf_token() }}' // CSRF token for Laravel
            },
            success: function(response) {
                console.log('Server Response:', response);

                if (response.success) {
                    alert('Farmer Profile updated successfully!');
                    location.reload(); // Optionally refresh the page or update the UI
                } else {
                    alert(response.message || 'Failed to update user ID.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX error:', textStatus, errorThrown);
                alert('An error occurred while saving.');
            }
        });
    } else {
        alert('Please select a user.');
    }
});
  </script>
@endsection
