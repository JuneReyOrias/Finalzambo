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
                                <a href="{{route("admin.farmersdata.samplefolder.farm_edit")}}" title="Add Farmer">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form>
                            </div>
                               <div class="table-responsive">
                                {{-- <form id="multipleDeleteForm" method="POST">
                                    @csrf --}}
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead >
                                        <tr >
                                            {{-- <th><input type="checkbox" id="selectAll"> </th> --}}
                                            <th>#</th>
                                            <th class="custom-cell">Farmer Name</th>
                                        
                                            <th class="custom-cell">Home Address</th>
                                           <th class="custom-cell">date of <p> birth</p></th>
                                           <th class="custom-cell">place of <p> birth</p></th>
                                     

                                         
                                          
                                        
                                           <th class="custom-cell">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($personalinfos->count() > 0)
                                    @foreach($personalinfos as $personalinformation)      
                                <tr class="table-light">
                                    {{-- <td><input type="checkbox" name="ids[]" class="recordCheckbox" value="{{ $personalinformation->id }}"></td> --}}
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
                                    @if ($personalinformation->barangay || $personalinformation->district || $personalinformation->city)
                                        {{ $personalinformation->barangay ?? 'N/A' }}, {{ $personalinformation->district ?? 'N/A' }}, {{ $personalinformation->city ?? 'N/A' }}
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
                            <a href="{{ route('admin.farmersdata.farm', $personalinformation->id) }}" title="View farm">
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

                    <a href="javascript:void(0);" class="viewArchive" data-bs-toggle="modal" title="View Farmer Archive Data" data-bs-target="#farmerArchiveModal" data-id="{{ $personalinformation->id }}">
                        <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                            <img src="../assets/logo/history.png" alt="Crop Icon" style="width: 20px; height: 20px;" class="me-1">
                            <i class="fas fa-rice" aria-hidden="true"></i>
                        </button>
                    </a>
                    <a href="{{ route('personalinfo.edit_info', $personalinformation->id) }}" title="View farmer">
                        <button class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
                    </a>
                    <form action="{{ route('personalinfo.delete', $personalinformation->id) }}" method="post" accept-charset="UTF-8" style="display:inline">
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
                              
                                
                            {{-- </form> --}}
                                <!-- Pagination links -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <ul class="pagination mb-0">
                                        <li><a href="{{ $personalinfos->previousPageUrl() }}">Previous</a></li>
                                        @foreach ($personalinfos->getUrlRange(max(1, $personalinfos->currentPage() - 1), min($personalinfos->lastPage(), $personalinfos->currentPage() + 1)) as $page => $url)
                                            <li class="{{ $page == $personalinfos->currentPage() ? 'active' : '' }}">
                                                <a href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                        <li><a href="{{ $personalinfos->nextPageUrl() }}">Next</a></li>
                                    </ul>
                                    {{-- <button type="button" id="deleteSelected" title="Delete all" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> All
                                    </button> --}}
                                </div>
                                
                            </div>
                        </div>



                      
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="farmerArchiveModal" tabindex="-1" aria-labelledby="farmerArchiveModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white" id="farmerArchiveModal">Farmer Archive Data History</h5>
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
                                    <th >Date of Interview</th>
                                   
                                    <th scope="col"><i class="fas fa-user me-1"></i>FullName</th>
                                    <th scope="col"><i class="fas fa-calendar-alt me-1"></i>Date of Birth</th>
                                     <th scope="col">Sex</th>
                                    <th scope="col"><i class="fas fa-home me-1"></i>Home Address</th>

                                    <th scope="col">Place Of Birth</th>
                                     <th scope="col">Civil Status</th>
                                    <th scope="col">No. of Children</th>
                                    <th scope="col">Mother's Maiden Name</th>
                                    <th scope="col">Highest Formal Education</th>
                                   <th scope="col">Person with Disability</th>
                                   <th scope="col">PWD ID No</th>
                                     <th scope="col">Government Issued Id</th>
                                    <th scope="col">Gov ID Type.</th>
                                    <th scope="col">Gov ID no.</th>
                                     <th scope="col">Member OF farmer Org/Asso/Coop</th>
                                     <th scope="col">Name of farmer Org/Asso/Coop</th>
                                     <th scope="col">Name of Contact Person </th>
                                     <th scope="col">Cellphone/Tel.#</th>
                                   
                                    
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




{{-- farmt --}}
<div class="modal fade" id="farmerModal" tabindex="-1" aria-labelledby="farmerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="farmerModalLabel">Farmer Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             
           
              <!-- Full Name Display -->
              <div class="container mt-3">
                <h6 class="fw-bold">Full Name: <span id="full_name" class="text-primary"></span></h6>
                <h6 class="text-secondary mb-3">Age: <span id="age"></span></h6> <!-- Age display here -->
            </div>

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

                                      
                                        {{-- <li><strong>Date of Birth:</strong> <span id="date_of_birth"></span></li> --}}
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
                                        <li><strong>Date of Interview:</strong> <span id="date_interview"></span></li>
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


function FarmerData(id) {
    $.ajax({
        url: '/admin-update-personalinfo/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'personalinfos' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#first_name').text(response.first_name || 'N/A');
                $('#middle_name').text(response.middle_name || 'N/A');
                $('#last_name').text(response.last_name || 'N/A');
                $('#extension_name').text(response.extension_name || 'N/A');

                // Function to capitalize the first letter of each word
                function capitalizeFirstLetter(string) {
                    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
                }

                // Concatenate full name with proper capitalization
                let fullName = [
                    response.first_name, 
                    response.middle_name, 
                    response.last_name, 
                    response.extension_name
                ]
                .filter(Boolean)
                .map(name => capitalizeFirstLetter(name)) // Capitalize each name part
                .join(' ')
                .trim();

                // If all fields are empty, set 'N/A'
                if (!fullName) {
                    fullName = 'N/A';
                }

                // Display the concatenated and formatted full name
                $('#full_name').text(fullName);

                            // Display Age
                var dateOfBirth = response.date_of_birth ? new Date(response.date_of_birth) : null;
                if (dateOfBirth) {
                    var age = calculateAge(dateOfBirth);
                    $('#age').text(age + ' years old');
                } else {
                    $('#age').text('N/A');
                }

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
    // Function to calculate age based on date of birth
function calculateAge(dateOfBirth) {
    var today = new Date();
    var age = today.getFullYear() - dateOfBirth.getFullYear();
    var monthDifference = today.getMonth() - dateOfBirth.getMonth();
    
    // If the birth date hasn't happened yet this year, subtract one year from age
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dateOfBirth.getDate())) {
        age--;
    }
    
    return age;
}
}

$(document).on('click', '.viewArchive', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    ArchiveData(id); // Fetch data and show the modal
});

function ArchiveData(id) {
    $.ajax({
        url: `/admin-update-personalinfo/${id}`, // URL to fetch data
        type: 'GET',
        dataType: 'json',
        data: { type: 'archives' }, // Fetch archives specifically
        success: function (response) {
            console.log("Response:", response); // Log the response for debugging

            // Handle the case where a message is returned (e.g., no archives found)
            if (response.message) {
                alert(response.message); // Show the message in an alert
                $('#archiveHistory').empty(); // Clear the table
                return; // Stop further processing
            }

            // If archives are returned, process the data
            const archives = response; // Assuming response contains an array of archives

            // Clear existing table rows
            $('#archiveHistory').empty();

            // Process each archive entry
            archives.forEach(function (archive) {
                console.log("Archive Entry:", archive); // Log each archive entry for debugging

                // Format the updated date
                const dateUpdated = archive.created_at 
                    ? new Date(archive.created_at).toLocaleDateString() 
                    : 'N/A';

                // Calculate age if date of birth is available
                const age = archive.date_of_birth 
                    ? calculateAge(new Date(archive.date_of_birth)) 
                    : 'N/A';

                // Concatenate and format full name
                const fullName = [
                    archive.first_name,
                    archive.middle_name,
                    archive.last_name,
                    archive.extension_name
                ]
                .filter(Boolean) // Remove null/undefined values
                .map(capitalizeFirstLetter) // Capitalize each part
                .join(' ') || 'N/A'; // Default to 'N/A' if all parts are empty

                // Format address
                const address = archive.barangay || archive.district || archive.city
                    ? `${archive.barangay || 'N/A'}, ${archive.district || 'N/A'}, ${archive.city || 'N/A'}`
                    : (archive.home_address || 'N/A');

                // Create the table row
                const archiveRow = `
                    <tr>
                        <th class="fixed-side">${dateUpdated}</th>
                          <td>${archive.date_interview || 'N/A'}</td>
                        <td>${fullName}</td>
                        <td>${archive.date_of_birth || 'N/A'}</td>
                        <td>${archive.sex || 'N/A'}</td>
                        <td>${address}</td>

                        <td>${archive.place_of_birth || 'N/A'}</td>
                         <td>${archive.civil_status || 'N/A'}</td>
                        <td>${archive.no_of_children || 'N/A'}</td>
  <td>${archive.mothers_maiden_name || 'N/A'}</td>

                        <td>${archive.highest_formal_education || 'N/A'}</td>
                <td>${archive.person_with_disability ||'N/A'}</td>
                    <td>${archive.pwd_id_no || 'N/A'}</td>
                                <td>${archive.government_issued_id || 'N/A'}</td>
                                    <td>${archive.id_type || 'N/A'}</td>
                                        <td>${archive.gov_id_no || 'N/A'}</td>
                                            <td>${archive.member_ofany_farmers_ass_org_coop || 'N/A'}</td>
                                                <td>${archive.nameof_farmers_ass_org_coop || 'N/A'}</td>
                                                <td>${archive.name_contact_person || 'N/A'}</td>
                                              <td>${archive.cp_tel_no || 'N/A'}</td>
                                          

                    </tr>
                `;

                // Append the row to the table body
                $('#archiveHistory').append(archiveRow);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', xhr.responseText); // Log error response
            if (xhr.status === 404) {
                alert('Personal Information not found or no archives available.');
            } else {
                alert(`An error occurred: ${xhr.statusText}`); // Show network error
            }
            $('#archiveHistory').empty(); // Clear the table in case of error
        }
    });
}

// Helper function to calculate age
function calculateAge(dateOfBirth) {
    const today = new Date();
    let age = today.getFullYear() - dateOfBirth.getFullYear();
    const monthDifference = today.getMonth() - dateOfBirth.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dateOfBirth.getDate())) {
        age--;
    }
    return age;
}

// Helper function to capitalize the first letter of a string
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}



// function ArchiveData(id) {
//     $.ajax({
//         url: '/admin-update-personalinfo/' + id, // Adjust the URL to match your route
//         type: 'GET',
//         dataType: 'json',
//         data: { type: 'archives' }, // Send 'archives' type for AJAX request
//         success: function(response) {
//             if (response.error) {
//                 alert(response.error); // Display error message if provided
//             } else {
//                 // Check if archives exist and display them in a table format
//                 if (response.archives && response.archives.length > 0) {
//                     let tableContent = `
//                         <table class="table table-striped">
//                             <thead>
//                                 <tr>
//                                     <th>ID</th>
//                                     <th>Archive Data</th>
//                                     <th>Created At</th>
//                                     <th>Updated At</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                     `;

//                     // Loop through archives and append rows to the table
//                     response.archives.forEach(function(archive) {
//                         tableContent += `
//                             <tr>
//                                 <td>${archive.id}</td>
//                                 <td>${archive.first_name}</td>
//                                 <td>${archive.created_at}</td>
//                                 <td>${archive.updated_at}</td>
//                             </tr>
//                         `;
//                     });

//                     tableContent += `
//                             </tbody>
//                         </table>
//                     `;

//                     // Insert the table content into the modal body
//                     $('#archives-modal-body').html(tableContent);
//                 } else {
//                     // If no archives are found, show a message
//                     $('#archives-modal-body').html('<p>No archives found for this personal information ID.</p>');
//                 }

//                 // Open the modal
//                 $('#archivesModal').modal('show');
//             }
//         },
//         error: function(xhr) {
//             console.error('Error fetching data:', xhr.responseText);
//             alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
//         }
//     });
// }

  </script>

  <style>

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
