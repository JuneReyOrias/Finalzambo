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
                                    <form action="">
                                       

                                        
                                        <div class="input-group mb-3">
                                            <button id="exportExcel" class="btn btn-success" title="Download Farmers Data">
                                                <i class="fas fa-file-excel"></i>
                                            </button>
                                            
                                            <select id="date-interview-dropdown" class="form-select">
                                                <option value="">All Farmers</option>
                                                <option value="new">New (Last 6 months)</option>
                                                <option value="old">Old (More than 6 months)</option>
                                            </select>
                                            <select class="form-select" id="district-dropdown">
                                                <option value="">All Districts</option>
                                            </select>
                                            <input type="text"  class="form-control" id="search-input" placeholder="Search">
                                        </div>
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
                                    <tbody id="personal-info-list">
                                        <!-- AJAX data will be inserted here -->
                                    </tbody>
                                </table>
                              
                                
                            {{-- </form> --}}
                                   <!-- Pagination links -->
                                   <div class="d-flex justify-content-between align-items-center mt-3">
                                    <ul id="pagination-links" class="pagination mb-0">
                                        <!-- AJAX pagination links will be inserted here -->
                                    </ul>
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
          

                <!-- Production Data -->
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">Farmer info Details</h6>
                    <h6 class="fw-bold">Full Name: <span id="full_name" class="text-primary"></span></h6>
                    <h6 class="text-secondary mb-3">Age: <span id="age"></span></h6> <!-- Age display here -->
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a. Farmer Info and Contact
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse " aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <div class="farmer-details-container">
                                        <ul class="list-unstyled farmer-details">
                                            <li><strong>Mother's Maiden Name:</strong> <span id="mothers_maiden_name"></span></li>
                                            <li><strong>Agri-District:</strong> <span id="district"></span></li>
                                            <li><strong>Barangay:</strong> <span id="barangay"></span></li>
                                        

                                            <li><strong>Home Address:</strong> <span id="home_address"></span></li>
                                            <li><strong>Street:</strong> <span id="street"></span></li>
                                           
                                            <li><strong>Contact:</strong> <span id="contact_no"></span></li>
                                            <li><strong>Sex/Gender:</strong> <span id="sex"></span></li>
                                           
                                        </ul>
                                    </div>
                                    
                                
                                    
                                </div>
                            </div>
                        </div>
                    
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="demoHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#demoCollapse" aria-expanded="false" aria-controls="demoCollapse">
                                    b. Demographic  Info 
                                </button>
                            </h2>
                            <div id="demoCollapse" class="accordion-collapse collapse " aria-labelledby="demoHeading" data-bs-parent="#demoAccordion">
                                <div class="accordion-body">
                                    <div class="farmer-details">
                                        <ul class="list-unstyled farmer-details">
                                        
                                            <li><strong>Religion:</strong> <span id="religion"></span></li>
                                            <li><strong>Place Of Birth:</strong> <span id="place_of_birth"></span></li>
                                            <li><strong>Civil Status:</strong> <span id="civil_status"></span></li>
                                            <li><strong>Name of Spouse:</strong> <span id="name_legal_spouse"></span></li>
                                            <li><strong>No. of Children:</strong> <span id="no_of_children"></span></li>
                                            <li><strong>Highest Formal Education:</strong> <span id="highest_formal_education"></span></li>
                                            <li><strong>Person with Disability:</strong> <span id="person_with_disability"></span></li>
                                            <li><strong>PWD ID No.:</strong> <span id="pwd_id_no"></span></li>
                                            <li><strong>Government Issued Id:</strong> <span id="government_issued_id"></span></li>
                                            <li><strong>Gov ID Type:</strong> <span id="id_type"></span></li>
                                            <li><strong>Gov ID No.:</strong> <span id="gov_id_no"></span></li>
                                        </ul>
                                    </div>
                                    
                                
                                    
                                </div>
                            </div>
                        </div>
                    
                        <!-- Harvesting Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="harvestingHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#harvestingCollapse" aria-expanded="false" aria-controls="harvestingCollapse">
                                    c.  Association  Info
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


     <script>

$(document).ready(function () {
    let sortOrder = 'asc';
    let sortColumn = 'id';

    function getPageRange(currentPage) {
        const startPage = Math.floor((currentPage - 1) / 3) * 3 + 1;
        const endPage = startPage + 2;
        return { startPage, endPage };
    }

    function fetchFarmersData(filters = {}, page = 1) {
        filters.page = page;
        filters.sort_order = sortOrder;
        filters.sort_column = sortColumn;

        $.ajax({
            url: '/admin-view-General-Farmers',
            type: 'GET',
            data: filters,
            success: function (response) {
                $('#personal-info-list').html('');
                $('#farm-profile-list').html('');
                $('#pagination-links').html('');

                // Populate personal information
                response.personalinfos.data.forEach(info => {
                    $('#personal-info-list').append(`
                        <tr class="new-row">
                            <td class="custom-cell">${info.id}</td>
                            <td class="custom-cell">${info.first_name} ${info.middle_name || ''} ${info.last_name} ${info.extension_name || ''}</td>
                            <td class="custom-cell">${info.barangay || info.district || info.city ? `${info.barangay || 'N/A'}, ${info.district || 'N/A'}, ${info.city || 'N/A'}` : info.home_address || 'N/A'}</td>
                            <td class="custom-cell">${info.date_of_birth || 'N/A'}</td>
                            <td class="custom-cell">${info.place_of_birth || 'N/A'}</td>
                            <td class="custom-cell">
                                <a href="/admin-view-Farmers-farm/${info.id}" title="View farm">
                                    <button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </a>
                                <a href="javascript:void(0);" class="viewfarmerBtn" data-bs-toggle="modal" title="View farmer" data-bs-target="#farmerModal" data-id="${info.id}">
                                    <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                                        <img src="../assets/logo/farmer.png" alt="Crop Icon" style="width: 20px; height: 20px;" class="me-1">
                                        <i class="fas fa-rice" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <a href="javascript:void(0);" class="viewArchive" data-bs-toggle="modal" title="View Farmer Archive Data" data-bs-target="#farmerArchiveModal" data-id="${info.id}">
                                    <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                                        <img src="../assets/logo/history.png" alt="Crop Icon" style="width: 20px; height: 20px;" class="me-1">
                                        <i class="fas fa-rice" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <a href="/admin-update-personalinfo/${info.id}" title="Edit farmer">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                </a>
                                <form action="/admin-delete-personalinfo/${info.id}" method="post" style="display:inline">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `);
                });

                // Populate farm profiles
                response.farmProfiles.data.forEach(profile => {
                    $('#farm-profile-list').append(`
                        <tr>
                            <td>${profile.id}</td>
                            <td>${profile.name}</td>
                            <td>${profile.agri_district ? profile.agri_district.name : 'N/A'}</td>
                        </tr>
                    `);
                });

                // Populate districts dropdown
                function toProperCase(text) {
                    return text.replace(/\b\w/g, char => char.toUpperCase());
                }
                response.districts.forEach(district => {
    if (district.agri_district) {
        // Ensure value is escaped to prevent issues with special characters
        let districtValue = escapeHtml(district.agri_district);
        let districtText = toProperCase(district.agri_district);

        // Check if the option already exists in the dropdown
        if (!$(`#district-dropdown option[value="${districtValue}"]`).length) {
            // Append the new option only if it doesn't exist
            $('#district-dropdown').append(`
                <option value="${districtValue}">${districtText}</option>
            `);
        } else {
            // Option already exists; update its text if necessary
            let option = $(`#district-dropdown option[value="${districtValue}"]`);
            if (option.text() !== districtText) {
                option.text(districtText);
            }
        }
    }
});

// Utility function to escape HTML special characters
function escapeHtml(str) {
    return str.replace(/[&<>"']/g, function (match) {
        const escape = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return escape[match];
    });
}



                // Update total rice production
                $('#total-rice-production').text(response.totalRiceProduction);

                // Generate pagination links
                if (response.personalinfos.links) {
                    const totalPages = response.personalinfos.last_page;
                    const { startPage, endPage } = getPageRange(page);

                    for (let i = startPage; i <= endPage && i <= totalPages; i++) {
                        const isActive = (i === page) ? 'active' : '';
                        $('#pagination-links').append(`
                            <li class="page-item ${isActive}">
                                <a href="#" class="page-link" data-page="${i}">${i}</a>
                            </li>
                        `);
                    }

                    $('#pagination-links').prepend(`
                        <li class="page-item ${page === 1 ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${page - 1}"><i class="fas fa-chevron-left"></i></a>
                        </li>
                    `);

                    $('#pagination-links').append(`
                        <li class="page-item ${page === totalPages ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${page + 1}"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    `);
                }
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Fetch data initially
    fetchFarmersData();

    // Handle filters change
    $('#district-dropdown, #search-input, #date-interview-dropdown').on('change keyup', function () {
        const filters = {
            district: $('#district-dropdown').val(),
            search: $('#search-input').val(),
            date_interview: $('#date-interview-dropdown').val()
        };
        fetchFarmersData(filters);
    });

    // Handle pagination link clicks
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            const filters = {
                district: $('#district-dropdown').val(),
                search: $('#search-input').val()
            };
            fetchFarmersData(filters, page);
        }
    });

    // Handle column sorting
    $('#sortable-table th').on('click', function () {
        const column = $(this).data('column');
        if (column) {
            sortColumn = column;
            sortOrder = (sortOrder === 'asc') ? 'desc' : 'asc';
            const filters = {
                district: $('#district-dropdown').val(),
                search: $('#search-input').val()
            };
            fetchFarmersData(filters);
        }
    });
});



     </script>
    <style>




        #pagination-links {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.page-item {
    margin: 0 5px;
}

.page-link {
    padding: 10px 15px;
    background-color: #fff;
    color: #007bff;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.page-link:hover {
    background-color: #007bff;
    color: #fff;
}

.page-link:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(38, 143, 255, 0.5);
}

.page-item:first-child .page-link {
    border-radius: 5px 0 0 5px;
}

.page-item:last-child .page-link {
    border-radius: 0 5px 5px 0;
}

.page-item.disabled .page-link {
    color: #ccc;
    cursor: not-allowed;
}

.page-item a {
    display: flex;
    align-items: center;
    justify-content: center;
}

        
        
        </style> 

<script>
    document.getElementById('exportExcel').addEventListener('click', function () {
        fetch('/admin-view-General-Farmers', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to download Excel file.');
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'all_farmers.xlsx'; // Set the file name
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error downloading file.');
        });
    });
</script>

@endsection
