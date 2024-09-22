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
                    
                    <h4>Farmers Data</h4>
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
                        <label for="personainfo">Farmers</label>
                        <div class="tab">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3">
                                    <h5 for="personainfo">I.Personal Information</h5>
                                </div>
                                <a href="{{route("agent.SurveyForm.new_farmer")}}" title="Add Farmer">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <form id="farmProfileSearchForm" action="{{ route('agent.FarmerInfo.farmers_view') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('agent.FarmerInfo.farmers_view') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form>
                            </div>
                               <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead >
                                        <tr >
                    
                                            <th>#</th>
                                            <th class="custom-cell">Farmer Name</th>
                                        
                                            <th class="custom-cell">Home Address</th>
                                           <th class="custom-cell">date of <p> birth</p></th>
                                           <th class="custom-cell">place of <p> birth</p></th>
                                     

                                           <th class="custom-cell">name of farmers ass/org/coop</th>
                                          
                                        
                                           <th class="custom-cell">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($personalinfos->count() > 0)
                                    @foreach($personalinfos as $personalinformation)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td class="custom-cell">{{  $personalinformation->id }}</td>
                                    <td class="custom-cell">
                                    <?php
                                    // Define variables
                                    $first_name = $personalinformation->first_name;
                                    $middle_name = $personalinformation->middle_name;
                                    $last_name = $personalinformation->last_name;
                                    $extension_name = $personalinformation->extension_name;
                                
                                    // Construct the full name
                                    $full_name = $first_name;
                                
                                    // Check and append the middle name
                                    if (!empty($middle_name) && $middle_name !== 'N/A') {
                                        $full_name .= ' ' . $middle_name;
                                    }
                                
                                    $full_name .= ' ' . $last_name;
                                
                                    // Check if extension_name is not empty and not equal to "N/A"
                                    if (!empty($extension_name) && $extension_name !== 'N/A') {
                                        $full_name .= ' ' . $extension_name;
                                    }
                                
                                    // Output the full name
                                    echo htmlspecialchars($full_name);
                                    ?>

                                </td>
                                

                            
                                <td class="custom-cell">
                                    @if ($personalinformation->barangay || $personalinformation->agri_district || $personalinformation->city)
                                        {{ $personalinformation->barangay ?? 'N/A' }}, {{ $personalinformation->agri_district ?? 'N/A' }}, {{ $personalinformation->city ?? 'N/A' }}
                                    @elseif ($personalinformation->home_address)
                                        {{ $personalinformation->home_address }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                
                         
                            {{-- <td class="custom-cell">
                                @if ($personalinformation->religion && $personalinformation->religion != 'N/A')
                                    {{ $personalinformation->religion }}
                                @else
                                
                                @endif
                            </td> --}}
                            <td class="custom-cell">
                            @if ($personalinformation->date_of_birth && $personalinformation->date_of_birth != 'N/A')
                                {{ $personalinformation->date_of_birth }}
                            @else
                      
                                    @endif
                                </td>
                                <td class="custom-cell">
                                    @if ($personalinformation->place_of_birth && $personalinformation->place_of_birth != 'N/A')
                                        {{ $personalinformation->place_of_birth }}
                                    @else
                                    
                                    @endif
                                </td>
                             
                             

                

                    <td class="custom-cell">
                    @if ($personalinformation->nameof_farmers_ass_org_coop && strtolower($personalinformation->nameof_farmers_ass_org_coop) != 'n/a')
                        {{ $personalinformation->nameof_farmers_ass_org_coop }}
                    @else
                    
                    @endif
                    </td>

                    <td class="custom-cell">
                      <a href="{{ route('agent.FarmerInfo.farm_view', $personalinformation->id) }}" title="View farm">
                          <button class="btn btn-success btn-sm">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                          </button>
                      </a>
                      <a href="javascript:void(0);" class="viewfarmerBtn" data-bs-toggle="modal" title="View farmer" data-bs-target="#farmerModal" data-id="{{ $personalinformation->id }}">
                        <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                            <img src="../assets/logo/farmer.png" alt="Crop Icon" style="width: 20px; height: 20px;" class="me-1">
                            <i class="fas fa-rice" aria-hidden="true"></i>
                        </button>
                    </a>
                      <a href="{{ route('agent.FarmerInfo.crudfarmer.edit', $personalinformation->id) }}" title="Edit farmer">
                          <button class="btn btn-primary btn-sm">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </button>
                      </a>
                      <form action="{{ route('agent.FarmerInfo.crudfarmer.delete', $personalinformation->id) }}" method="post" accept-charset="UTF-8" style="display:inline">
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                          </button>
                      </form>
                  </td>
                  
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Farmer info is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                
                                <!-- Pagination links -->
                                <ul class="pagination">
                                    <li><a href="{{ $personalinfos->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($personalinfos->getUrlRange(max(1, $personalinfos->currentPage() - 1), min($personalinfos->lastPage(), $personalinfos->currentPage() + 1)) as $page => $url)
                                    <li class="{{ $page == $personalinfos->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                    <li><a href="{{ $personalinfos->nextPageUrl() }}">Next</a></li>
                                </ul>

                            </div>
                        </div>



                      
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


{{-- farmt --}}
<div class="modal fade" id="farmerModal" tabindex="-1" aria-labelledby="farmerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="farmerModalLabel">Farmer Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Farmer Details -->
        
                {{-- <div class="col-md-9">
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
              
                   
                        <!-- Check if personalInformation relation is loaded and the ID is unique -->
                        @if($personalinfos && !in_array($personalinfos->id, $uniqueFarmers))
                            <h5 for="personainfo">
                                Farmer: 
                                <!-- Apply the formatName function to first_name and last_name -->
                                {{ formatName($personalinfos->first_name) . ' ' . formatName($personalinfos->last_name) }}
                            </h5>
                            
                          
                        @endif
                   
               
                </div> --}}
            

                <!-- Production Data -->
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">Farmer info Details</h6>
                    
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a.  Contact and Demographic  Info
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Date of Birth:</strong> <span id="date_of_birth"></span></li>
                                        <li><strong>Mother's Maiden Name:</strong> <span id="mothers_maiden_name"></span></li>
                                        <li><strong>Agri-District:</strong> <span id="district"></span></li>
                                        <li><strong>Barangay:</strong> <span id="barangay"></span></li>
                                        <li><strong>Country:</strong> <span id="country"></span></li>
                                        <li><strong>Province:</strong> <span id="province"></span></li>
                                        <li><strong>City:</strong> <span id="city"></span></li>
                                        <li><strong>Home Address:</strong> <span id="home_address"></span></li>
                                        <li><strong>Street:</strong> <span id="street"></span></li>
                                        <li><strong>Zip Code:</strong> <span id="zip_code"></span></li>
                                        
                                        <li><strong>Contact:</strong> <span id="contact_no"></span></li>
                                        <li><strong>Sex/Gender:</strong> <span id="sex"></span></li>

                                        <li><strong>Religion:</strong> <span id="religion"></span></li>
                                        <li><strong>Place Of Birth:</strong> <span id="place_of_birth"></span></li>
                                        <li><strong>Civil Status:</strong> <span id="civil_status"></span></li>
                                        <li><strong>Name of Spouse</strong> <span id="name_legal_spouse"></span></li>
                                      
                                        <li><strong>No. of Children:</strong> <span id="no_of_children"></span></li>
                                        <li><strong>Highest Formal Education:</strong> <span id="highest_formal_education"></span></li>
                                        <li><strong>Person with Disability:</strong> <span id="person_with_disability"></span></li>
                                        <li><strong>PWD ID No.:</strong> <span id="pwd_id_no"></span></li>
                                        <li><strong>Government Issued Id:</strong> <span id="government_issued_id"></span></li>
                                        <li><strong>Gov ID Type.:</strong> <span id="id_type"></span></li>
                                        <li><strong>Gov ID no.:</strong> <span id="gov_id_no"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                      
                    
                        <!-- Harvesting Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="harvestingHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#harvestingCollapse" aria-expanded="false" aria-controls="harvestingCollapse">
                                    b.  Association  Info
                                </button>
                            </h2>
                            <div id="harvestingCollapse" class="accordion-collapse collapse" aria-labelledby="harvestingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Member OF farmer Org/Asso/Coop:</strong> <span id="member_ofany_farmers_ass_org_coop"></span></li>
                                        <li><strong>Name of farmer Org/Asso/Coop:</strong> <span id="nameof_farmers_ass_org_coop"></span></li>
                                        <li><strong>Name of Contact Person:</strong> <span id="name_contact_person"></span></li>
                                        <li><strong>Cellphone/Tel.#:</strong> <span id="cp_tel_no"></span></li>
                                        <li><strong>Date of Interview::</strong> <span id="date_interview"></span></li>
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
    $(document).on('click', '.viewfarmerBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
   FarmerData(id); // Fetch data and show the modal
});

$(document).on('click', '.viewfarmerBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
   FarmerData(id); // Fetch data and show the modal
});

function FarmerData(id) {
    $.ajax({
        url: '/agent-edit-farmers/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'personalinfos' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#date_of_birth').text(response.date_of_birth || 'N/A');
                $('#mothers_maiden_name').text(response.mothers_maiden_name || 'N/A');
                $('#district').text(response.district || 'N/A');
                $('#barangay').text(response.barangay || 'N/A');
              

              
                $('#country').text(response.country || 'N/A');
                $('#province').text(response.province || 'N/A');
                $('#city').text(response.city || 'N/A');

                $('#home_address').text(response.home_address || 'N/A');
                $('#street').text(response.street || 'N/A');

                $('#zip_code').text(response.zip_code || 'N/A');
                $('#contact_no').text(response.contact_no || 'N/A');
                $('#sex').text(response.sex || 'N/A');

                $('#religion').text(response.religion || 'N/A');
                $('#place_of_birth').text(response.place_of_birth || 'N/A');
              

                $('#civil_status').text(response.civil_status || 'N/A');
                $('#name_legal_spouse').text(response.name_legal_spouse || 'N/A');
                $('#no_of_children').text(response.no_of_children || 'N/A');

                $('#highest_formal_education').text(response.highest_formal_education || 'N/A');
                $('#street').text(response.street || 'N/A');

                $('#person_with_disability').text(response.person_with_disability || 'N/A');
                $('#pwd_id_no').text(response.pwd_id_no || 'N/A');
                $('#government_issued_id').text(response.government_issued_id || 'N/A');

                $('#id_type').text(response.id_type || 'N/A');
                $('#gov_id_no').text(response.gov_id_no || 'N/A');

                
                $('#member_ofany_farmers_ass_org_coop').text(response.member_ofany_farmers_ass_org_coop || 'N/A');
                $('#nameof_farmers_ass_org_coop').text(response.nameof_farmers_ass_org_coop || 'N/A');
                $('#name_contact_person').text(response.name_contact_person || 'N/A');

                $('#cp_tel_no').text(response.cp_tel_no || 'N/A');
                $('#date_interview').text(response.date_interview || 'N/A');
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}

  </script>
@endsection
