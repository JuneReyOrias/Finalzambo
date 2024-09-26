@extends('admin.dashb')
@section('admin')
    @extends('layouts._footer-script')
    @extends('layouts._head')
    
    
    <style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
       
        .input-box {
            display: flex;
            align-items: center;
        }
        .input-box .form-control {
            flex: 1;
        }
        .input-box .btn-outline-danger {
            margin-left: 10px;
            display: none; /* Hide by default, show only for new seeds */}
       
       
       
       
       
       
        .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
            background-color: transparent;
                 font-weight: 500;
                    transition: all 0.3s ease;
                      }
                                    
        .btn-outline-danger:hover {
            background-color: #dc3545;
               color: #fff;
                                  }
                                    
          .btn-outline-danger i {
               font-size: 1.2rem;
                                  }
        :root{
            --primary: #6b59d3;
            --fourth:#05a34a;
            --secondary: #bfc0c0;
            --third:#ffffffc5;
            --white: #fff;
            --text-clr: #5b6475;
            --header-clr: #25273d;
            --next-btn-hover: #8577d2;
            --back-btn-hover: #8b8c8c;
        }
        


        .select-container {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between select and button */
}

.btn-remove {
    padding: 6px 12px; /* Adjust padding for consistency */
}

.btn-remove .fa-trash {
    margin-right: 4px; /* Space between icon and text */
}


        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            outline: none;
            font-family: 'Open Sans', sans-serif;
        }
        
        body{
            background: var(--third);
            color: var(--text-clr);
            font-size: 16px;
            position: relative;
        }




        /* .card-body{
            width: 750px;
            max-width: 80%;
            background: var(--white);
            margin: 10px auto 0;
            padding: 50px;
            border-radius: 5px;
        } */
        
        .card-body .header{
            margin-bottom: 35px;
            display: flex;
            justify-content: center;
        }
        
        .card-body .header ul{
            display: flex;
        }
        
        .card-body .header ul li{
            margin-right: 50px;
            position: relative;
        }
        
        .card-body .header ul li:last-child{
            margin-right: 0;
        }
        
        .card-body .header ul li:before{
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 55px;
            width: 100%;
            height: 2px;
            background: var(--secondary);
        }
        
        .card-body .header ul li:last-child:before{
            display: none;
        }
        
        .card-body .header ul li div{
            padding: 5px;
            border-radius: 50%;
        }
        
        .card-body .header ul li p{
            width: 50px;
            height: 50px;
            background: var(--secondary);
            color: var(--white);
            text-align: center;
            line-height: 50px;
            border-radius: 50%;
        }
        
        .card-body .header ul li.active:before{
            background: var(--primary);
        }
        
        .card-body .header ul li.active p{
            background: var(--primary);
        }
        
        .card-body.form_wrap{
            margin-bottom: 35px;
        }
        
        .card-body .form_wrap h2{
            color: var(--header-clr);
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        
        .card-body .form_wrap .input_wrap{
            width: 350px;
            max-width: 100%;
            margin: 0 auto 20px;
        }
        
        .card-body .form_wrap .input_wrap:last-child{
            margin-bottom: 0;
        }
        
        .card-body .form_wrap .input_wrap label{
            display: block;
            margin-bottom: 5px;
        }
        .placeholder-multiform{
            border: 2px solid var(--secondary);
        }
        .card-body .form_wrap .input_wrap .form-control{
            border: 2px solid var(--secondary);
            border-radius: 3px;
            padding: 10px;
            display: block;
            height: auto;
            width: 100%;	
            font-size: 16px;
            transition: 0.5s ease;
        }
        
        .card-body .form_wrap .input_wrap .form-control:focus{
            border-color: var(--primary);
        }
        
        .card-body .btns_wrap{
            width: 350px;
            max-width: 100%;
            margin: 0 auto;
        }
        
        .card-body .btns_wrap .common_btns{
            display: flex;
            justify-content: space-between;
        }
        
        .card-body .btns_wrap .common_btns.form_1_btns{
            justify-content: flex-end;
        }
        
        .card-body .btns_wrap .common_btns button{
            border: 0;
            padding: 12px 15px;
            background: var(--fourth);
            color: var(--white);
            width: 135px;
            justify-content: center;
            display: flex;
            align-items: center;
            font-size: 16px;
            border-radius: 3px;
            transition: 0.5s ease;
            cursor: pointer;
        }
        
        .card-body .btns_wrap .common_btns button.btn_back{
            background: var(--secondary);
        }
        
        .card-body .btns_wrap .common_btns button.btn_next .icon{
            display: flex;
            margin-left: 10px;
        }
        
        .card-body .btns_wrap .common_btns button.btn_back .icon{
            display: flex;
            margin-right: 10px;
        }
        
        .card-body .btns_wrap .common_btns button.btn_next:hover,
        .card-body .btns_wrap .common_btns button.btn_done:hover{
            background: var (--next-btn-hover);
        }
        
        .card-body .btns_wrap .common_btns button.btn_back:hover{
            background: var (--back-btn-hover);
        }
        
        .modal_wrapper{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            visibility: hidden;
        }
        
        .modal_wrapper .shadow{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            opacity: 0;
            transition: 0.2s ease;
        }
        
        .modal_wrapper .success_wrap{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-800px);
            background: var(--white);
            padding: 50px;
            display: flex;
            align-items: center;
            border-radius: 5px;
            transition: 0.5s ease;
        }
        
        .modal_wrapper .success_wrap .modal_icon{
            margin-right: 20px;
            width: 30px;
            height: 50px;
            background: var(--primary);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
        }
        
        .modal_wrapper.active{
            visibility: visible;
        }
        
        .modal_wrapper.active .shadow{
            opacity: 1;
        }
        
        .modal_wrapper.active .success_wrap{
            transform: translate(-50%,-50%);
        }
        .light-gray-placeholder::placeholder {
        color: lightgray;
        font-size: 0.9rem;
    }



    
    </style>
  <style>
    .step {
        display: none;
    }
    .step.active {
        display: block;
    }
    .farm-profile, .crop-farm {
        margin-bottom: 20px;
    }
    .btn-modern {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 50px;
    border: none;
    text-align: left;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-modern:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 50px;
    border: none;
    text-align: end;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    color: white;
}

.card-header {
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-modern, .btn-secondary {
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 30px;
    }

    .card-header {
        padding: 8px 15px;
    }
}

@media (max-width: 576px) {
    .btn-modern, .btn-secondary {
        padding: 8px 10px;
        font-size: 12px;
        border-radius: 20px;
    }

    .card-header {
        padding: 5px 10px;
    }
}


/* 
    .btn-modern {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 50px;
    border: none;
    text-align: center;
    width: 30%;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-modern:hover {
    background-color: #62b300;
    color: white;
    transform: translateY(-2px);
}

.card-header {
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.btn-modern {
    text-decoration: none;
}


/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-modern {
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 30px;
    }

    .card-header {
        padding: 8px 15px;
    }
}

@media (max-width: 576px) {
    .btn-modern {
        padding: 8px 10px;
        font-size: 10px;
        border-radius: 20px;
      
    }

    .card-header {
        padding: 5px 10px;
    }
}
@media (max-width: 376px) {
    .btn-modern {
        padding: 8px 10px;
        font-size: 10px;
        border-radius: 10px;
     
      
    }

    .card-header {
        padding: 5px 10px;
    }
} */
</style>


                                    <div class="page-content">
                                        <div class="card-forms border rounded">

                                        
                                            <div class="card-forms border rounded">

                                                <div class="card-body">
                                                
                                                <div class="content">
                                    <form  id="form" method="POST">
                                        @csrf
                                     
            
                                    <!-- Farm Info Section -->


        <!-- Step 1: Farm Profile -->
        <div class="step active farm-info" id="step2">
            <!-- Farm Profile and Crop Accordion -->
            <div class="accordion farm-info" id="accordionFarmProfile">
                <!-- Farm Profile Section -->
           
            <div class="card crop-section mb-3" id="crop">
                <div class="card-header d-flex justify-content-between align-items-center" id="headingCrop" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                    <h5 class="mb-0" style="margin: 0;">
                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseCrop" aria-expanded="false" aria-controls="collapseCrop">
                            Add Production Solds
                        </button>
                    </h5>
                    {{-- <button class="btn btn-danger btn-sm ml-auto" type="button" onclick="removeCrop()">
                        Remove
                    </button> --}}
                </div>
                <div id="collapseCrop" class="collapse" aria-labelledby="headingCrop">
                    <div class="card-body">
                      

                        <div class="user-details">
                            <div class="d-flex flex-column mb-3">
                            <!-- Add Sale Button -->
                            <h3 class="mb-3">c. Sales Information</h3>
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-primary" onclick="addSale()">Add Sale</button>
                            </div>
                            <div id="salesSection"></div>
                        </div>


                           
                        </div>

                        <!-- Other fields here -->
                         </div>
                       

                        </div>
                    </div>
                </div>
            </div>
    
        <div id="cropProfiles" class="cropsect">
            <!-- Dynamic Crop Fields Will Be Added Here -->
        </div>

        <!-- Buttons outside the accordions -->
            <div class="button-container mt-3 d-flex justify-content-between">
                <button type="button" class="btn btn-primary" onclick="goBack()">Back</button>
                <button type="submit" class="btn btn-success" id="submitButton">Save</button>
            </div>
                                    </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>                 
</form>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="confirmModalLabel"><i class="fas fa-check-circle"></i> Confirm Your Data</h5>
          <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="accordion" id="confirmationAccordion">
            <!-- Farmer Information Accordion -->
            {{-- <div class="accordion-item">
              <h2 class="accordion-header" id="headingFarmerInfo">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFarmerInfo" aria-expanded="true" aria-controls="collapseFarmerInfo">
                  <i class="fas fa-user"></i> Farmer Information
                </button>
              </h2>
              <div id="collapseFarmerInfo" class="accordion-collapse collapse show" aria-labelledby="headingFarmerInfo" data-bs-parent="#confirmationAccordion">
                <div class="accordion-body">
                    <ul class="farmer-details">
                        <li><strong>First Name:</strong> <span id="farmerFirstname"></span></li>
                        <li><strong>Last Name:</strong> <span id="farmerLastname"></span></li>
                        <li><strong>Middle Name:</strong> <span id="farmerMiddleName"></span></li>
                        <li><strong>Extension Name:</strong> <span id="farmerExtensionName"></span></li>
                        <li><strong>Country:</strong> <span id="farmerCountry"></span></li>
                        <li><strong>Province:</strong> <span id="farmerProvince"></span></li>
                        <li><strong>City:</strong> <span id="farmerCity"></span></li>
                        <li><strong>Agri District:</strong> <span id="farmerAgriDistrict"></span></li>
                        <li><strong>Barangay:</strong> <span id="farmerBarangay"></span></li>
                        <li><strong>Street:</strong> <span id="farmerStreet"></span></li>
                        <li><strong>Zip Code:</strong> <span id="farmerZipCode"></span></li>
                        <li><strong>Contact Number:</strong> <span id="farmerContactNo"></span></li>
                        <li><strong>Sex:</strong> <span id="farmerSex"></span></li>
                        <li><strong>Religion:</strong> <span id="farmerReligion"></span></li>
                        <li><strong>Date of Birth:</strong> <span id="farmerDateOfBirth"></span></li>
                        <li><strong>Place of Birth:</strong> <span id="farmerPlaceOfBirth"></span></li>
                        <li><strong>Civil Status:</strong> <span id="farmerCivilStatus"></span></li>
                        <li><strong>Name of Legal Spouse:</strong> <span id="farmerNameLegalSpouse"></span></li>
                        <li><strong>Number of Children:</strong> <span id="farmerNoOfChildren"></span></li>
                        <li><strong>Mother's Maiden Name:</strong> <span id="farmerMothersMaidenName"></span></li>
                        <li><strong>Highest Formal Education:</strong> <span id="farmerHighestFormalEducation"></span></li>
                        <li><strong>Person with Disability:</strong> <span id="farmerPersonWithDisability"></span></li>
                        <li><strong>YESPWD ID Number:</strong> <span id="farmerYespwdIdNo"></span></li>
                        <li><strong>NOPWD ID Number:</strong> <span id="farmerNopwdIdNo"></span></li>
                        <li><strong>Government Issued ID:</strong> <span id="farmerGovernmentIssuedId"></span></li>
                        <li><strong>ID Type:</strong> <span id="farmerIdType"></span></li>
                        <li><strong>Additional ID Type:</strong> <span id="farmerAddIdType"></span></li>
                        <li><strong>Non-Government ID Types:</strong> <span id="farmerNonGovIdTypes"></span></li>
                        <li><strong>Member of Any Farmers' Group:</strong> <span id="farmerMemberOfAnyFarmers"></span></li>
                        <li><strong>Name of Farmers' Group:</strong> <span id="farmerNameOfFarmers"></span></li>
                        <li><strong>Number of Farmers' Groups:</strong> <span id="farmerNoFarmersGroup"></span></li>
                        <li><strong>Additional Farmers' Group:</strong> <span id="farmerAddFarmersGroup"></span></li>
                        <li><strong>Contact Person's Name:</strong> <span id="farmerNameContactPerson"></span></li>
                        <li><strong>Contact Person's Number:</strong> <span id="farmerCpTelNo"></span></li>
                        <li><strong>Date of Interview:</strong> <span id="farmerDateOfInterview"></span></li>
                    </ul>
                    
                    
                
                </div>
              </div>
            </div>
   --}}
            <!-- Farm Information Accordion -->
            {{-- <div class="accordion-item">
              <h2 class="accordion-header" id="headingFarmInfo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFarmInfo" aria-expanded="false" aria-controls="collapseFarmInfo">
                  <i class="fas fa-tractor"></i> Farm Information
                </button>
              </h2>
              <div id="collapseFarmInfo" class="accordion-collapse collapse" aria-labelledby="headingFarmInfo" data-bs-parent="#confirmationAccordion">
                <div class="accordion-body">
                    <ul class="farm-details">
                        <li><strong>Tenurial Status:</strong> <span id="farmTenurialStatus"></span></li>
                        <li><strong>Farm Address:</strong> <span id="farmAddress"></span></li>
                        <li><strong>Number of Years as Farmer:</strong> <span id="farmYearsAsFarmer"></span></li>
                        <li><strong>GPS Longitude:</strong> <span id="farmGpsLongitude"></span></li>
                        <li><strong>GPS Latitude:</strong> <span id="farmGpsLatitude"></span></li>
                        <li><strong>Total Physical Area (ha):</strong> <span id="farmTotalPhysicalArea"></span></li>
                        <li><strong>Total Area Cultivated (ha):</strong> <span id="farmTotalAreaCultivated"></span></li>
                        <li><strong>Land Title Number:</strong> <span id="farmLandTitleNo"></span></li>
                        <li><strong>Lot Number:</strong> <span id="farmLotNo"></span></li>
                        <li><strong>Area Prone To:</strong> <span id="farmAreaProneTo"></span></li>
                        <li><strong>Ecosystem:</strong> <span id="farmEcosystem"></span></li>
                        <li><strong>RSBA Register:</strong> <span id="farmRsbaRegister"></span></li>
                        <li><strong>PCIC Insured:</strong> <span id="farmPcicInsured"></span></li>
                        <li><strong>Government Assisted:</strong> <span id="farmGovernmentAssisted"></span></li>
                        <li><strong>Source of Capital:</strong> <span id="farmSourceOfCapital"></span></li>
                        <li><strong>Remarks:</strong> <span id="farmRemarks"></span></li>
                        <li><strong>OCA District Office:</strong> <span id="farmOcaDistrictOffice"></span></li>
                        <li><strong>Name of Technicians:</strong> <span id="farmNameTechnicians"></span></li>
                        <li><strong>Date of Interview:</strong> <span id="farmDateInterview"></span></li>
                    </ul>
                    
                </div>
              </div>
            </div>
   --}}
            <!-- Crops Information Accordion -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingCropsInfo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCropsInfo" aria-expanded="false" aria-controls="collapseCropsInfo">
                  <i class="fas fa-seedling"></i> Crops Information
                </button>
              </h2>
              <div id="collapseCropsInfo" class="accordion-collapse collapse" aria-labelledby="headingCropsInfo" data-bs-parent="#confirmationAccordion">
                <div class="accordion-body" id="cropAccordionBody">
            
                    
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Cancel</button>
          <button type="button" id="confirmSave" class="btn btn-success"><i class="fas fa-save"></i> Confirm and Save</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Add this CSS for styling -->
  <style>

.farm-details {
    display: flex;
    flex-wrap: wrap;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.farm-details li {
    flex: 1 1 50%; /* Adjusts each item to take up half of the container width */
    box-sizing: border-box;
    padding: 5px;
}

    .farmer-details {
    display: flex;
    flex-wrap: wrap;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.farmer-details li {
    flex: 1 1 50%; /* Adjusts each item to take up half of the container width */
    box-sizing: border-box;
    padding: 5px;
}

    .modal-content {
      border-radius: 10px;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }
  
    .modal-header .btn-close {
      font-size: 1.5rem;
      background: none;
      border: none;
    }
  
    .modal-body h6 {
      font-weight: 600;
      color: #343a40;
    }
  
    .modal-footer {
      border-top: none;
      padding-top: 0;
    }
  
    .btn {
      border-radius: 50px;
    }
  
    .btn-outline-secondary {
      border: 2px solid #6c757d;
    }
  
    .btn-success {
      background-color: #28a745;
      border-color: #28a745;
    }
  
    .accordion-body p, .accordion-body ul {
      margin-bottom: 0.5rem;
    }


    .detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.detail-row {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 4px;
    background-color: #12163b;
}

.detail-row h4 {
    margin-bottom: 10px;
}

.detail-row ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.detail-row li {
    margin-bottom: 8px;
}

.remove-crop {
    display: block;
    margin: 20px 0;
    padding: 10px;
    background-color: #f44336;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.remove-crop:hover {
    background-color: #d32f2f;
}
/* CSS */

/* Ensure the container (column) maintains its responsive layout */
.col-d-4 {
    display: flex;
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
}

/* Style the span for responsiveness */
.details {
    display: block; /* Ensure it takes the full width of its container */
    text-align:left; /* Center text horizontally */
    font-size: 1rem; /* Adjust font size for readability */
    margin: 0 auto; /* Center block-level element */
    white-space: nowrap; /* Prevent text from wrapping */
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .details {
        font-size: 0.9rem; /* Slightly smaller font on medium screens */
    }
}

@media (max-width: 992px) {
    .details {
        font-size: 0.8rem; /* Even smaller font on smaller screens */
    }
}

@media (max-width: 768px) {
    .details {
        font-size: 0.9rem; /* Further reduce font size on mobile screens */
    }
}

@media (max-width: 576px) {
    .details {
        font-size: 0.8rem; /* Smallest font size for extra-small screens */
    }
}
.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
}



/* Custom styles for modals */
.modal-content {
    border-radius: 0.5rem;
}

.modal-header {
    background-color: #007bff;
    color: #fff;
}

.modal-title {
    font-weight: bold;
}

.btn-close {
    background: transparent;
    border: none;
    color: #fff;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    transition: background-color 0.3s, border-color 0.3s;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

.modal-body {
    font-size: 1rem;
    color: #212529;
}

/* Ripple effect for button clicks */
.btn:focus, .btn:active {
    outline: none;
    box-shadow: none;
}

.btn-primary:active, .btn-secondary:active {
    position: relative;
    overflow: hidden;
}

.btn-primary:active::after, .btn-secondary:active::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.3s;
}

.btn-primary:active::after {
    background: rgba(255, 255, 255, 0.2);
}

.btn-secondary:active::after {
    background: rgba(0, 0, 0, 0.1);
}

.btn-primary:active::after, .btn-secondary:active::after {
    transform: translate(-50%, -50%) scale(1);
}

  </style>
  
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="successModalLabel">Success</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Your data has been successfully added.</p>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button> --}}
          
            <!-- Link to proceed to another page -->
            <a href="{{ route('admin.farmersdata.production', $cropData->id) }}" class="btn btn-success">Proceed to Production Data</a>

        </div>
      </div>
    </div>
  </div>
  
  






<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="errorModalLabel">Error</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="errorModalBody">
          <!-- Error message will be injected here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  

              <!-- Modal Structure -->
                <div class="modal fade" id="newOrganizationModal" tabindex="-1" aria-labelledby="newOrganizationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="newOrganizationModalLabel">New Organization</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form id="newOrganizationForm">
                            <div class="mb-3">
                            <label for="organizationName" class="form-label">Organization Name</label>
                            <input type="text" class="form-control" id="organizationName" placeholder="Enter organization name" required>
                            <div class="form-text text-danger d-none" id="error-message">Organization name is required.</div>
                            </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="addNewOrganization">Save</button>
                        </div>
                    </div>
                    </div>
                </div> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>







    
// Track available sale numbers for each crop

let saleCounter= 0;
let saleAvailableNumbersMap = [];
let saleCounterMap = [{}];

// Function to add a sale
function addSale() {
    //Initialize available numbers and sale counter if not present for this crop
    if (!saleAvailableNumbersMap[]) {
        saleAvailableNumbersMap[] = [];
        saleCounterMap[] = 0;
    }

    let saleCounter;

    // Check if there are available numbers to reuse
    if (saleAvailableNumbersMap[].length > 0) {
        // Use the lowest available sale number
        saleCounter = saleAvailableNumbersMap[].shift();
    } else {
        // Increment sale counter if no available numbers
        saleCounter = saleCounterMap[]++;
    }

    // Add sale entry dynamically
    const salesSection = document.getElementById(`salesSection`);
    const newSaleEntry = `
        <div class="user-details sale-entry" id="saleEntry_${saleCounter}">
            <div class="input-box col-md-3">
                <label for="sold_to_${saleCounter}">Sold To:</label>
                <input type="text" class="form-control light-gray-placeholder sold_to" name="crop_profiles[${}][sales][${saleCounter}][sold_to]" id="sold_to_${saleCounter}" placeholder="Enter sold to">
            </div>
         <div class="input-box col-md-3">
                <label for="measurement_${saleCounter}">Measurement/unit:</label>
                <select class="form-control light-gray-placeholder measurement"  
                        name="crop_profiles[${}][sales][${saleCounter}][measurement]" 
                        id="measurement_${saleCounter}" 
                        onchange="convertMeasurement(${saleCounter})">
                    <option value="kg">Kilograms</option>
                    <option value="tons">Tons</option>
                </select>
            </div>
            <div class="input-box col-md-3">
                <label for="unit_price_per_kg_${saleCounter}">Unit Price/kg:</label>
                <input type="text" class="form-control light-gray-placeholder unit_price_sold"  
                    name="crop_profiles[${}][sales][${saleCounter}][unit_price]" 
                    id="unit_price_per_kg_${saleCounter}" 
                    placeholder="Enter unit price" 
                    oninput="calculateGrossIncome(${saleCounter})" 
                    onkeypress="return isNumberKey(event)" />
            </div>
            <div class="input-box col-md-3">
                <label for="quantity_${saleCounter}">Quantity:</label>
                <input type="text" class="form-control light-gray-placeholder quantity"  
                    name="crop_profiles[${}][sales][${saleCounter}][quantity]" 
                    id="quantity_${saleCounter}" 
                    placeholder="Enter quantity" 
                    oninput="calculateGrossIncome(${saleCounter})" 
                    onkeypress="return isNumberKey(event)" />
            </div>
            <div class="input-box col-md-3">
                <label for="gross_income_${saleCounter}">Gross Income:</label>
                <input type="text" class="form-control light-gray-placeholder gross_income"  
                    name="crop_profiles[${}][sales][${saleCounter}][gross_income]" 
                    id="gross_income_${saleCounter}" 
                    placeholder="Enter gross income" 
                    readonly />
            </div>
            <div class="remove-button-container">
                <button type="button" class="btn btn-danger remove-sale-btn" onclick="removeSale(${saleCounter})">Remove Sale</button>
            </div>

        </div>
    `;

   
    salesSection.insertAdjacentHTML('beforeend', newSaleEntry);
    updateRemoveButtonVisibility();
}

// Function to remove a sale
function removeSale(, saleCounter) {
    const saleEntry = document.getElementById(`saleEntry_${saleCounter}`);
    if (saleEntry) {
        saleEntry.remove();

        // Add the sale number back to available numbers for this crop
        saleAvailableNumbersMap[].push(saleCounter);

        // Update visibility of remove buttons
        updateRemoveButtonVisibility();
    }
}

// Update visibility of the remove sale button
function updateRemoveButtonVisibility() {
    const salesSection = document.getElementById(`salesSection`);
    const saleEntries = salesSection.querySelectorAll('.sale-entry');

    saleEntries.forEach(entry => {
        if (saleEntries.length <= 1) {
            entry.querySelector('.remove-sale-btn').classList.add('hidden');
        } else {
            entry.querySelector('.remove-sale-btn').classList.remove('hidden');
        }
    });
}

// Initial setup: Hide remove button if only one sale entry exists
document.querySelectorAll('[id^="salesSection_"]').forEach(section => {
    updateRemoveButtonVisibility(section.id.split('_')[1]);
});

</script>

<script>
    let cropIndex = 1;
    
    function addMoreCrops() {
        const container = document.getElementById('cropSectionsContainer');
    
        // Create a new crop section based on the template
        const newCropSection = document.querySelector('.crop-section-template').cloneNode(true);
        
        // Update IDs and names for the new crop section
        newCropSection.querySelectorAll('[id]').forEach(el => {
            el.id = el.id.replace(/_\d+$/, `_${cropIndex}`);
        });
        newCropSection.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${cropIndex}]`);
        });
    
        // Update collapse target and parent
        newCropSection.querySelector('.collapse').setAttribute('id', `collapseCrop_${cropIndex}`);
        newCropSection.querySelector('.collapse').setAttribute('data-parent', '#accordionFarmProfile');
        newCropSection.querySelector('.accordion').setAttribute('id', `accordionCropDetails_${cropIndex}`);
        
        // Append the new crop section to the container
        container.appendChild(newCropSection);
        
        cropIndex++;
    }
    
    // Initial hide of the crop section template
    document.querySelector('.crop-section-template').style.display = 'none';
    </script>
  <script>


// Assuming you have a form with the ID 'form'
const form = $('#form');

// Bind the submit event to the form
form.on('submit', function(event) {
    event.preventDefault(); // Prevent the form from reloading the page
  
   
    // Gather crop info from the form inputs 

    // Gather production info from the form inputs
    let production = {
        'crops_farms_id': $('select.crops_farms_id').val(),
        'seed-type': $('input.seed-type').val(),
        'seed-used': $('input.seed-used').val(),
        'seed-source': $('select.seed-source').val(),
        'unit': $('input.unit').val(),
        'fertilized-used': $('input.fertilized-used').val(),
        'pesticides-used': $('input.pesticides-used').val(),
        'insecticides-used': $('input.insecticides-used').val(),
        'area-planted': $('input.area-planted').val(),
        'date-planted': $('input.date-planted').val(),
        'date-harvested': $('input.date-harvested').val(),
        'yield-kg': $('input.yield-kg').val(),
       
    };
    let fixedcost = {
        'crops_farms_id': $('select.crops_farms_id').val(),
        // 'crops_farms_id': $('select.crops_farms_id').val(),
        'particular': $('select.particular').val(),
        'no-has': $('input.no-has').val(),
        'cost-has': $('input.cost-has').val(),
        'total-amount': $('input.total-amount').val(),  
    };

    let machineries = {
        // 'crops_farms_id': $('select.crops_farms_id').val(),
     
        'plowing-machine': $('select.plowing-machine').val(),
        'plow_status': $('select.plow_status').val(),
        'no_of_plowing': $('input.no_of_plowing').val(),
        'cost_per_plowing': $('input.cost_per_plowing').val(), 
        'plowing_cost': $('input.plowing_cost').val(), 

        'harro_machine': $('select.harro_machine').val(),
        'harro_ownership_status': $('select.harro_ownership_status').val(),
        'no_of_harrowing': $('input.no_of_harrowing').val(),
        'cost_per_harrowing': $('input.cost_per_harrowing').val(), 
        'harrowing_cost_total': $('input.harrowing_cost_total').val(), 

        'harvest_machine': $('select.harvest_machine').val(),
        'harvest_ownership_status': $('select.harvest_ownership_status').val(),
        'no_of_Harvesting': $('input.no_of_Harvesting').val(),
        'cost_per_Harvesting': $('input.cost_per_Harvesting').val(), 
        'Harvesting_cost_total': $('input.Harvesting_cost_total').val(), 

        'postharves_machine': $('select.postharves_machine').val(),
        'postharv_ownership_status': $('select.postharv_ownership_status').val(),
        'postharvestCost': $('input.postharvestCost').val(),
        // 'cost_per_Harvesting': $('input.cost_per_Harvesting').val(), 
        'total_cost_for_machineries': $('input.total_cost_for_machineries').val(), 
    };

    let variables = {
        // 'crops_farms_id': $('select.crops_farms_id').val(),
        'seed_name': $('select.seed_name').val(),
        'unit': $('input.unit').val(),
        'quantity': $('input.quantity').val(), 
        'unit_price_seed': $('input.unit_price_seed').val(), 
        'total_seed_cost': $('input.total_seed_cost').val(), 

        'no_of_person': $('input.no_of_person').val(),
        'rate_per_person': $('input.rate_per_person').val(),
        'total_labor_cost': $('input.total_labor_cost').val(),

        'name_of_fertilizer': $('select.name_of_fertilizer').val(),
        'no_ofsacks': $('input.no_ofsacks').val(),
        'unitprice_per_sacks': $('input.unitprice_per_sacks').val(),
        'total_cost_fertilizers': $('input.total_cost_fertilizers').val(), 
      

        'pesticides_name': $('select.pesticides_name').val(),
        'no_of_l_kg': $('input.no_of_l_kg').val(),
        'unitprice_ofpesticides': $('input.unitprice_ofpesticides').val(),
        'total_cost_pesticides': $('input.total_cost_pesticides').val(), 

        
        'type_of_vehicle': $('input.type_of_vehicle').val(),
        'total_transport_per_deliverycost': $('input.total_transport_per_deliverycost').val(),
        'total_machinery_fuel_cost': $('input.total_machinery_fuel_cost').val(),
        'total_variable_costs': $('input.total_variable_costs').val(), 
        
    };


                    // Helper function to get the value of an input field within a specific entry
                    function getValue(selector, entry) {
                        let input = entry.querySelector(selector);
                        return input ? input.value : null;
                    }

                    const saleSections = document.querySelectorAll('#salesSection .sale-entry'); // Use proper selector
                    let salesData = [];

                    // Iterate over each sale entry in the sales section
                    saleSections.forEach((entry) => {
                        let saleId = entry.id.split('_')[2]; // Extract the sale ID from the element ID

                        // Get the values of the fields within the current entry
                        let cropsId = getValue('.crops_farms_id', entry);
                        let soldTo = getValue('.sold_to', entry);
                        let measurement = getValue('.measurement', entry);
                        let unit_price_sold = getValue('.unit_price_sold', entry);
                        let quantity = getValue('.quantity', entry);
                        let grossIncometotal = getValue('.gross_income', entry);
                        
                        // Store sale data in the salesData array
                        if (soldTo || measurement || unit_price_sold || grossIncometotal) { // Only push if any field has a value
                            salesData.push({
                                cropsId:cropsId,
                                saleId: saleId,
                                soldTo: soldTo,
                                measurement: measurement,
                                unit_price: unit_price_sold,
                                quantity: quantity,
                                grossIncome: grossIncometotal
                            });
                        }
                    });

                    console.log(salesData); // Output the collected sales data



     
//   // Create the final data object
let dataobject = {
    // 'fixedcost':fixedcost,
    // 'machineries':machineries,
    // 'variables':variables,
    'salesData': salesData,
    // 'productions': production,
};

// Log the entire data object to the console for debugging
console.log("Data Object:", dataobject);


const csrfToken = $('input[name="_token"]').attr('value');

    // Send the AJAX request
    $.ajax({
        url: '/admin-add-Farmers-Solds-Cost/{cropData}',
        method: 'POST',
        contentType: 'application/json', // Set content type for JSON
        data: JSON.stringify(dataobject), // Attach the prepared data here
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
        },
        success: function(response) {

            console.log(response);
            if (response.success) {
            // Set the success message in the modal
            $('#successMessage').text(response.success);
            // Show the modal
            $('#successModal').modal('show');
        }
        },
        error: function(error) {
            console.error('Error:', error.responseJSON.message);
        }
    }); 
}); 




let currentStep = 0;
    const steps = document.querySelectorAll('.step');

    function showStep(step) {
        steps.forEach((stepElement, index) => {
            stepElement.classList.toggle('active', index === step);
        });
    }

    function nextStep() {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function previousStep() {
        currentStep--;
        showStep(currentStep);
    }

    function validateStep(step) {
        const currentStepElement = steps[step];
        const inputs = currentStepElement.querySelectorAll('input');
        let isValid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                isValid = false;
            }
        });
        return isValid;
    }
  </script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      flatpickr("#datepicker", {
          dateFormat: "Y-m-d", // Date format (YYYY-MM-DD)
          // Additional options can be added here
      });
  });
</script>

<script type="text/javascript">
    var map;
    var markers = [];
    var selectedLatLng;
  
    function initMap() {
      var initialLocation = { lat: 6.9214, lng: 122.0790 };
  
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: initialLocation,
        mapTypeId: 'terrain'
      });
  
      // When the map is clicked, set latitude and longitude in modal and main inputs
      map.addListener('click', function(event) {
        if (markers.length >= 1) {
          deleteMarkers();
        }
  
        selectedLatLng = event.latLng;
        addMarker(selectedLatLng);
        $('#modal_latitude').val(selectedLatLng.lat());
        $('#modal_longitude').val(selectedLatLng.lng());
      });
  
      // Add marker on the map
      function addMarker(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
        markers.push(marker);
      }
  
      // Clear markers from the map
      function deleteMarkers() {
        markers.forEach(marker => {
          marker.setMap(null);
        });
        markers = [];
      }
  
      // Listen for manual input in modal latitude/longitude fields
      $('#modal_latitude, #modal_longitude').on('change', function() {
        var lat = parseFloat($('#modal_latitude').val());
        var lng = parseFloat($('#modal_longitude').val());
  
        if (!isNaN(lat) && !isNaN(lng)) {
          var location = { lat: lat, lng: lng };
          map.setCenter(location);
          deleteMarkers();
          addMarker(location);
        }
      });
    }
  
    $(document).ready(function() {
      // Show the modal when latitude or longitude input is focused
      $('#gps_latitude_0, #gps_longitude_0').on('focus', function() {
        $('#mapModal').modal('show');
      });
  
      // Reinitialize the map each time the modal is opened
      $('#mapModal').on('shown.bs.modal', function() {
        if (selectedLatLng) {
          map.setCenter(selectedLatLng); // Center map on previously selected location
        }
        google.maps.event.trigger(map, 'resize');
      });
  
      // Clear previous markers when modal is closed
      $('#mapModal').on('hidden.bs.modal', function() {
        deleteMarkers(); // Clear markers when modal is closed
      });
  
      // Handle the Save Location button click
      $('#saveLocation').on('click', function() {
        // Save the latitude and longitude to the main input fields
        var lat = $('#modal_latitude').val();
        var lng = $('#modal_longitude').val();
        $('#gps_latitude_0').val(lat);
        $('#gps_longitude_0').val(lng);
        
        // Close the modal
        $('#mapModal').modal('hide');
      });
    });

// Function to check membership and display organization input accordingly
function checkMmbership() {
    var membership = document.getElementById("selectMember").value;
    var organizationInput = document.getElementById("YesFarmersGroup");
    var noOrganizationInput = document.getElementById("NoFarmersGroup");

    if (membership === "1") { // Yes
        organizationInput.style.display = "block"; // Show organization input
        noOrganizationInput.style.display = "none"; // Hide no organization input
        checkAgri(); // Call checkAgri to populate organizations based on selected agri_district
    } else if (membership === "0") { // No
        organizationInput.style.display = "none"; // Hide organization input
        noOrganizationInput.style.display = "block"; // Show no organization input
        populateNoOrganizations(); // Populate dropdown with "N/A" or other values if needed
    } else {
        // Handle case if membership value is neither "1" nor "0" (if applicable)
        organizationInput.style.display = "none";
        noOrganizationInput.style.display = "none";
    }
}


// Function to check agri_district and display barangay and organization inputs accordingly
function checkAgri() {
    var agriDistrict = document.getElementById("selectAgri").value;
    var barangayInput = document.getElementById("barangayInput");
    var organizationInput = document.getElementById("YesFarmersGroup");

    if (['ayala', 'vitali', 'culianan', 'tumaga', 'manicahan', 'curuan'].includes(agriDistrict)) {
        barangayInput.style.display = "block"; // Show barangay input
        populateBarangays(agriDistrict); // Populate barangays based on selected district
        if (document.getElementById("selectMember").value === "1") {
            populateOrganizations(agriDistrict); // Populate organizations based on selected district
        }
    } else {
        barangayInput.style.display = "none"; // Hide barangay input
    }
}

$(document).ready(function() {
    function populateBarangays(agriDistrict) {
        var barangaySelect = document.getElementById("SelectBarangay");

        // Clear previous options
        barangaySelect.innerHTML = '';

        // AJAX call to get barangays
        $.ajax({
            url: '/admin-view-Farmers-survey-form',
            method: 'GET',
            data: { district: agriDistrict, type: 'barangays' },
            success: function(response) {
                console.log('Barangays Response:', response);

                if (response.length > 0) {
                    response.forEach(function(barangay) {
                        var option = document.createElement("option");
                        option.text = barangay.barangay_name;
                        option.value = barangay.barangay_name;
                        barangaySelect.appendChild(option);
                    });
                } else {
                    var noOption = document.createElement("option");
                    noOption.text = "No barangays found";
                    noOption.disabled = true;
                    barangaySelect.appendChild(noOption);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error fetching barangays:", error);
            }
        });
    }

    function populateOrganizations(agriDistrict) {
        var organizationSelect = document.getElementById("SelectOrganization");

        // Clear previous options
        organizationSelect.innerHTML = '';

        // AJAX call to get organizations
        $.ajax({
            url: '/admin-view-Farmers-survey-form',
            method: 'GET',
            data: { district: agriDistrict, type: 'organizations' },
            success: function(response) {
                console.log('Organizations Response:', response);

                if (response.length > 0) {
                    response.forEach(function(organization) {
                        var option = document.createElement("option");
                        option.text = organization.organization_name;
                        option.value = organization.organization_name;
                        organizationSelect.appendChild(option);
                    });
                } else {
                    var noOption = document.createElement("option");
                    noOption.text = "No organizations found";
                    noOption.disabled = true;
                    organizationSelect.appendChild(noOption);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error fetching organizations:", error);
            }
        });
    }

    function removeBarangay() {
        var barangaySelect = document.getElementById("SelectBarangay");
        var selectedValue = barangaySelect.value;

        if (selectedValue) {
            var confirmRemove = confirm("Are you sure you want to remove this barangay?");
            if (confirmRemove) {
                var selectedIndex = barangaySelect.selectedIndex;
                barangaySelect.remove(selectedIndex);
            }
        }
    }

    function removeOrganization() {
        var organizationSelect = document.getElementById("SelectOrganization");
        var selectedValue = organizationSelect.value;

        if (selectedValue) {
            var confirmRemove = confirm("Are you sure you want to remove this organization?");
            if (confirmRemove) {
                var selectedIndex = organizationSelect.selectedIndex;
                organizationSelect.remove(selectedIndex);
            }
        }
    }

    // Modal to add new barangay
    $('#saveNewBarangay').click(function() {
        var newBarangayName = $('#newBarangayName').val(); // Get the input value from modal
        if (newBarangayName) {
            var barangaySelect = document.getElementById("SelectBarangay");
            var existingOption = Array.from(barangaySelect.options).find(option => option.value === newBarangayName);

            if (!existingOption) {
                // Add new barangay to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newBarangayName;
                newOption.value = newBarangayName;
                barangaySelect.appendChild(newOption);

                // Set the new barangay as selected
                barangaySelect.value = newBarangayName;

                // Close the modal after adding the barangay
                $('#newBarangayModal').modal('hide');
            } else {
                alert("Barangay already exists.");
            }
        } else {
            alert("Please enter a barangay name.");
        }
    });

    // Clear input when modal closes
    $('#newBarangayModal').on('hidden.bs.modal', function () {
        $('#newBarangayName').val('');
    });

    // Modal to add new organization
    var saveButton = document.getElementById('addNewOrganization');
    var organizationNameInput = document.getElementById('organizationName');
    var errorMessage = document.getElementById('error-message');
    var organizationSelect = document.getElementById("SelectOrganization");

    saveButton.addEventListener('click', function () {
        var newOrganizationName = organizationNameInput.value.trim();

        if (newOrganizationName) {
            var existingOption = Array.from(organizationSelect.options).find(option => option.value === newOrganizationName);

            if (!existingOption) {
                // Add new organization to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newOrganizationName;
                newOption.value = newOrganizationName;
                organizationSelect.appendChild(newOption);

                // Set the new organization as selected
                organizationSelect.value = newOrganizationName;

                // Clear input and error message
                organizationNameInput.value = '';
                errorMessage.classList.add('d-none');

                // Close modal
                var modal = bootstrap.Modal.getInstance(document.getElementById('newOrganizationModal'));
                modal.hide();
            } else {
                alert("Organization already exists.");
            }
        } else {
            // Show error message
            errorMessage.classList.remove('d-none');
        }
    });

    // Clear error message on input change
    organizationNameInput.addEventListener('input', function () {
        if (organizationNameInput.value.trim()) {
            errorMessage.classList.add('d-none');
        }
    });

    // Attach event listeners for removal buttons
    $('#removeBarangay').click(removeBarangay);
    $('#removeOrganization').click(removeOrganization);

    // Call population functions
    var agriDistrict = '{{ $agri_district }}'; // Ensure this is dynamically set
    populateBarangays(agriDistrict);
    populateOrganizations(agriDistrict);
});






  </script>
  

  <script>

// Get references to the input fields
const no_of_ha = document.getElementById('no_of_ha');
const cost_per_ha = document.getElementById('cost_per_ha');
const total_amount = document.getElementById('total_amount');

// Function to calculate and display the total cost
function calculateTotalFertilizerCost() {
    const quantity = parseFloat(no_of_ha.value) || 0;
    const unitPrice = parseFloat(cost_per_ha.value) || 0;

    const totalFertilizerCost = quantity * unitPrice;

    // Display the total fertilizer cost in the input field
    total_amount.value = totalFertilizerCost.toFixed(2); // You can adjust the text of decimal places as needed
}

// Calculate the total fertilizer cost whenever the quantity or unit price changes
no_of_ha.addEventListener('input', calculateTotalFertilizerCost);
cost_per_ha.addEventListener('input', calculateTotalFertilizerCost);

// Initial calculation when the page loads
calculateTotalFertilizerCost();
  </script>
    
    <script>
        function goBack() {
            window.history.back(); // This will go back to the previous page in the browser history
        }
        </script> 
    
    <script>
        // To show the modal
        $('#successModal').modal('show');
        
        // To close the modal programmatically
        $('#successModal').modal('hide');</script>
    
  <script src="{{ asset('js/production.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&libraries=drawing,geometry&callback=initMap"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#datepicker", {
            dateFormat: "Y-m-d", // Date format (YYYY-MM-DD)
            // Additional options can be added here
        });
    });
  </script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    // Assuming you have a form with the ID 'form'
const form = $('#form');

// Bind the submit event to the form
form.on('submit', function(event) {
    event.preventDefault(); // Prevent the form from reloading the page
  
   
    // Gather crop info from the form inputs 

    


                    // Helper function to get the value of an input field within a specific entry
                    function getValue(selector, entry) {
                        let input = entry.querySelector(selector);
                        return input ? input.value : null;
                    }

                    const saleSections = document.querySelectorAll('#salesSection .sale-entry'); // Use proper selector
                    let salesData = [];

                    // Iterate over each sale entry in the sales section
                    saleSections.forEach((entry) => {
                        let saleId = entry.id.split('_')[2]; // Extract the sale ID from the element ID

                        // Get the values of the fields within the current entry
                        let crops_farms_id = getValue('.crops_farms_id', entry);
                        let soldTo = getValue('.sold_to', entry);
                        let measurement = getValue('.measurement', entry);
                        let unit_price_sold = getValue('.unit_price_sold', entry);
                        let quantity = getValue('.quantity', entry);
                        let grossIncometotal = getValue('.gross_income', entry);
                        
                        // Store sale data in the salesData array
                        if (soldTo || measurement || unit_price_sold || grossIncometotal) { // Only push if any field has a value
                            salesData.push({
                                crops_farms_id:crops_farms_id,
                                saleId: saleId,
                                soldTo: soldTo,
                                measurement: measurement,
                                unit_price: unit_price_sold,
                                quantity: quantity,
                                grossIncome: grossIncometotal
                            });
                        }
                    });

                    console.log(salesData); // Output the collected sales data

    

     
//   // Create the final data object
let dataobject = {
 
  
  
    'salesData': salesData,
  
};

// Log the entire data object to the console for debugging
console.log("Data Object:", dataobject);

const csrfToken = $('input[name="_token"]').attr('value');

    // Send the AJAX request
    $.ajax({
        url: '/agent-add-farmer-Production-sold/{cropData}',
        method: 'POST',
        contentType: 'application/json', // Set content type for JSON
        data: JSON.stringify(dataobject), // Attach the prepared data here
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
        },
        success: function(response) {

            console.log(response);

            if (response.success) {
            // Set the success message in the modal
            $('#successMessage').text(response.success);
            // Show the modal
            $('#successModal').modal('show');
        }
        },
        error: function(error) {
            console.error('Error:', error.responseJSON.message);
        }
    }); 
}); 



</script>
    
<script>
   let saleCounter = 0;
let saleAvailableNumbersMap = []; // Track available sale numbers

// Function to add a sale
function addSale() {
    let currentSaleCounter;

    // Check if there are available numbers to reuse
    if (saleAvailableNumbersMap.length > 0) {
        currentSaleCounter = saleAvailableNumbersMap.shift();
    } else {
        currentSaleCounter = saleCounter++;
    }

    // Add sale entry dynamically
    const salesSection = document.getElementById('salesSection');
    const newSaleEntry = `
        <div class="user-details sale-entry" id="saleEntry_${currentSaleCounter}">
            <div class="input-box col-md-4">
                <label for="crops_farms_id_${currentSaleCounter}">Crop Name:</label>
                <select class="form-control crops_farms_id" name="crop_profiles[0][sales][${currentSaleCounter}][crops_farms_id]">
                    <option value="{{$cropData->id}}">{{$cropData->crop_name}}</option>
                </select>
            </div>
            <div class="input-box col-md-4">
                <label for="sold_to_${currentSaleCounter}">Sold To:</label>
                <input type="text" class="form-control light-gray-placeholder sold_to" name="crop_profiles[0][sales][${currentSaleCounter}][sold_to]" id="sold_to_${currentSaleCounter}" placeholder="Enter sold to">
            </div>
            <div class="input-box col-md-4">
                <label for="measurement_${currentSaleCounter}">Measurement/unit:</label>
                <select class="form-control measurement" name="crop_profiles[0][sales][${currentSaleCounter}][measurement]" id="measurement_${currentSaleCounter}" onchange="convertMeasurement(${currentSaleCounter})">
                    <option value="">Select</option>
                    <option value="kg">kg</option>
                    <option value="tons">tons</option>
                </select>
            </div>
            <div class="input-box col-md-4">
                <label for="unit_price_per_kg_${currentSaleCounter}">Unit Price/kg:</label>
                <input type="number" class="form-control light-gray-placeholder unit_price_sold" name="crop_profiles[0][sales][${currentSaleCounter}][unit_price]" id="unit_price_per_kg_${currentSaleCounter}" placeholder="Enter unit price" oninput="calculateGrossIncome(${currentSaleCounter})" onkeypress="return isNumberKey(event)" step="0.01">
            </div>
            <div class="input-box col-md-4">
                <label for="quantity_${currentSaleCounter}">Quantity:</label>
                <input type="number" class="form-control light-gray-placeholder quantity" name="crop_profiles[0][sales][${currentSaleCounter}][quantity]" id="quantity_${currentSaleCounter}" placeholder="Enter quantity" oninput="calculateGrossIncome(${currentSaleCounter})" onkeypress="return isNumberKey(event)" step="0.01">
            </div>
              
            <div class="input-box col-md-4">
                <label for="gross_income_${currentSaleCounter}">Gross Income:</label>
                <input type="number" class="form-control light-gray-placeholder gross_income" name="crop_profiles[0][sales][${currentSaleCounter}][gross_income]" id="gross_income_${currentSaleCounter}" placeholder="Enter gross income" readonly>
            </div>
            <div class="remove-button-container">
                <button type="button" class="btn btn-danger remove-sale-btn" onclick="removeSale(${currentSaleCounter})">Remove Sale</button>
            </div>
        </div>
    `;

    salesSection.insertAdjacentHTML('beforeend', newSaleEntry);
    updateRemoveButtonVisibility();
}

// Function to remove a sale
function removeSale(saleCounter) {
    const saleEntry = document.getElementById(`saleEntry_${saleCounter}`);
    if (saleEntry) {
        saleEntry.remove();
        saleAvailableNumbersMap.push(saleCounter);
        updateRemoveButtonVisibility();
    }
}

// Update visibility of the remove sale button
function updateRemoveButtonVisibility() {
    const salesSection = document.getElementById('salesSection');
    const saleEntries = salesSection.querySelectorAll('.sale-entry');

    saleEntries.forEach((entry, index) => {
        const removeButton = entry.querySelector('.remove-sale-btn');
        if (saleEntries.length <= 1) {
            removeButton.style.display = 'none'; // Hide the button if only one entry exists
        } else {
            removeButton.style.display = 'inline-block'; // Show the button if more than one entry
        }
    });
}

// Function to convert measurement and update quantity
function convertMeasurement(saleCounter) {
    var measurement = document.getElementById('measurement_' + saleCounter).value;
    var quantityField = document.getElementById('quantity_' + saleCounter);
    var quantity = parseFloat(quantityField.value);

    // Convert tons to kilograms if the selected unit is tons
    if (measurement === 'tons' && !isNaN(quantity)) {
        // Convert tons to kg (1 ton = 1000 kg)
        quantityField.value = (quantity * 1000).toFixed(2); // Convert and update the quantity field
    } else if (measurement === 'kg' && !isNaN(quantity)) {
        // If the user switches back to kilograms, keep the value as is
        quantityField.value = quantity.toFixed(2);
    }

    // Recalculate gross income after conversion
    calculateGrossIncome(saleCounter);
}

// Function to calculate gross income based on unit price and quantity
function calculateGrossIncome(saleCounter) {
    var unitPrice = parseFloat(document.getElementById('unit_price_per_kg_' + saleCounter).value);
    var quantity = parseFloat(document.getElementById('quantity_' + saleCounter).value);

    if (!isNaN(unitPrice) && !isNaN(quantity) && unitPrice > 0 && quantity > 0) {
        var grossIncome = unitPrice * quantity;
        document.getElementById('gross_income_' + saleCounter).value = grossIncome.toFixed(2);
    } else {
        document.getElementById('gross_income_' + saleCounter).value = '';
    }
}

// Function to allow only numbers and a decimal point
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
        return false;
    }
    return true;
}

// Initial setup: Hide remove button if only one sale entry exists
document.addEventListener('DOMContentLoaded', () => {
    updateRemoveButtonVisibility();
});
</script>


<script>
// Plowing
document.addEventListener("DOMContentLoaded", function () {
    var noPlowingInput = document.getElementById("noPlowing");
    var plowingPerCostInput = document.getElementById("plowingperCostInput");
    var plowingCostInput = document.getElementById("plowingCostInput");

    function calculatePlowingCost() {
        var noPlowing = parseFloat(noPlowingInput.value) || 0;
        var costPerPlowing = parseFloat(plowingPerCostInput.value) || 0;
        var totalCost = noPlowing * costPerPlowing;

        // Display the total cost in the total plowing cost input field
        plowingCostInput.value = totalCost.toFixed(2);
    }

    // Add event listeners for dynamic calculation
    noPlowingInput.addEventListener("input", calculatePlowingCost);
    plowingPerCostInput.addEventListener("input", calculatePlowingCost);

    // Initial calculation when the page loads
    calculatePlowingCost();
});

// harrowing
document.addEventListener("DOMContentLoaded", function () {
    // Variables for harrowing cost calculation
    var noHarrowingInput = document.getElementById("noHarrowing");
    var costPerHarrowingInput = document.getElementById("costPerHarrowingInput");
    var totalHarrowingCostInput = document.getElementById("totalHarrowingCostInput");

    function calculateHarrowingCost() {
        var noHarrowing = parseFloat(noHarrowingInput.value) || 0;
        var costPerHarrowing = parseFloat(costPerHarrowingInput.value) || 0;
        var totalCost = noHarrowing * costPerHarrowing;

        // Display the total cost in the total harrowing cost input field
        totalHarrowingCostInput.value = totalCost.toFixed(2);
    }

    // Add event listeners for dynamic calculation
    noHarrowingInput.addEventListener("input", calculateHarrowingCost);
    costPerHarrowingInput.addEventListener("input", calculateHarrowingCost);

    // Initial calculation when the page loads
    calculateHarrowingCost();
});



// harvesting

document.addEventListener("DOMContentLoaded", function () {
    // Variables for harvesting cost calculation
    var noHarvestingInput = document.getElementById("noHarvesting");
    var costPerHarvestingInput = document.getElementById("costPerHarvestingInput");
    var totalHarvestingCostInput = document.getElementById("totalHarvestingCostInput");

    function calculateHarvestingCost() {
        var noHarvesting = parseFloat(noHarvestingInput.value) || 0;
        var costPerHarvesting = parseFloat(costPerHarvestingInput.value) || 0;
        var totalCost = noHarvesting * costPerHarvesting;

        // Display the total cost in the total harvesting cost input field
        totalHarvestingCostInput.value = totalCost.toFixed(2);
    }

    // Add event listeners for dynamic calculation
    noHarvestingInput.addEventListener("input", calculateHarvestingCost);
    costPerHarvestingInput.addEventListener("input", calculateHarvestingCost);

    // Initial calculation when the page loads
    calculateHarvestingCost();
});


document.addEventListener("DOMContentLoaded", function () {
    // Get all relevant inputs
    var plowingCostInput = document.getElementById("plowingCostInput");
    var harrowingCostInput = document.getElementById("totalHarrowingCostInput");
    var harvestingCostInput = document.getElementById("totalHarvestingCostInput");
    var postHarvestCostInput = document.getElementById("postHarvestCostInput");
    var totalCostInput = document.getElementById("totalCostInput");

    // Function to calculate total cost for machineries
    function calculateTotalCost() {
        var plowingCost = parseFloat(plowingCostInput.value) || 0;
        var harrowingCost = parseFloat(harrowingCostInput.value) || 0;
        var harvestingCost = parseFloat(harvestingCostInput.value) || 0;
        var postHarvestCost = parseFloat(postHarvestCostInput.value) || 0;

        // Total cost for machineries is the sum of all the above costs
        var totalCost = plowingCost + harrowingCost + harvestingCost + postHarvestCost;
        
        // Set the value to the total cost input
        totalCostInput.value = totalCost.toFixed(2);
    }

    // Attach event listeners to all inputs
    plowingCostInput.addEventListener("input", calculateTotalCost);
    harrowingCostInput.addEventListener("input", calculateTotalCost);
    harvestingCostInput.addEventListener("input", calculateTotalCost);
    postHarvestCostInput.addEventListener("input", calculateTotalCost);

    // Calculate the total cost when the page loads (initial calculation)
    calculateTotalCost();
});


// seeds
document.addEventListener("DOMContentLoaded", function () {
    // Get references to the input fields
    var quantityInput = document.getElementById("quantityInput");
    var unitPriceInput = document.getElementById("unitPriceInput");
    var totalSeedCostInput = document.getElementById("totalSeedCostInput");

    // Function to calculate total seed cost
    function calculateTotalSeedCost() {
        var quantity = parseFloat(quantityInput.value) || 0;
        var unitPrice = parseFloat(unitPriceInput.value) || 0;

        // Calculate total cost by multiplying quantity by unit price
        var totalSeedCost = quantity * unitPrice;

        // Set the value to the total seed cost input
        totalSeedCostInput.value = totalSeedCost.toFixed(2);
    }

    // Attach event listeners to quantity and unit price inputs
    quantityInput.addEventListener("input", calculateTotalSeedCost);
    unitPriceInput.addEventListener("input", calculateTotalSeedCost);

    // Initial calculation when the page loads
    calculateTotalSeedCost();
});


// labors 

document.addEventListener("DOMContentLoaded", function () {
    // Get references to the input fields
    var noOfPersonInput = document.getElementById("noOfPersonInput");
    var ratePerPersonInput = document.getElementById("ratePerPersonInput");
    var totalLaborCostInput = document.getElementById("totalLaborCostInput");

    // Function to calculate total labor cost
    function calculateTotalLaborCost() {
        var noOfPerson = parseFloat(noOfPersonInput.value) || 0;
        var ratePerPerson = parseFloat(ratePerPersonInput.value) || 0;

        // Calculate total labor cost by multiplying no of persons by rate per person
        var totalLaborCost = noOfPerson * ratePerPerson;

        // Set the value to the total labor cost input
        totalLaborCostInput.value = totalLaborCost.toFixed(2);
    }

    // Attach event listeners to no of persons and rate per person inputs
    noOfPersonInput.addEventListener("input", calculateTotalLaborCost);
    ratePerPersonInput.addEventListener("input", calculateTotalLaborCost);

    // Initial calculation when the page loads
    calculateTotalLaborCost();
});

// fertilizewrs
document.addEventListener("DOMContentLoaded", function () {
    // Get references to the input fields
    var noOfSacksInput = document.getElementById("noOfSacksInput");
    var unitPricePerSacksInput = document.getElementById("unitPricePerSacksInput");
    var totalCostFertilizersInput = document.getElementById("totalCostFertilizersInput");

    // Function to calculate total cost of fertilizers
    function calculateTotalCostFertilizers() {
        var noOfSacks = parseFloat(noOfSacksInput.value) || 0;
        var unitPricePerSack = parseFloat(unitPricePerSacksInput.value) || 0;

        // Calculate total cost by multiplying no. of sacks by unit price per sack
        var totalCost = noOfSacks * unitPricePerSack;

        // Set the value to the total cost fertilizers input
        totalCostFertilizersInput.value = totalCost.toFixed(2);
    }

    // Attach event listeners to no of sacks and unit price per sack inputs
    noOfSacksInput.addEventListener("input", calculateTotalCostFertilizers);
    unitPricePerSacksInput.addEventListener("input", calculateTotalCostFertilizers);

    // Initial calculation when the page loads
    calculateTotalCostFertilizers();
});

// pesticides
document.addEventListener("DOMContentLoaded", function () {
    // Get references to the input fields
    var noOfLKgInput = document.getElementById("noOfLKgInput");
    var unitPricePesticidesInput = document.getElementById("unitPricePesticidesInput");
    var totalCostPesticidesInput = document.getElementById("totalCostPesticidesInput");

    // Function to calculate total cost of pesticides
    function calculateTotalCostPesticides() {
        var noOfLKg = parseFloat(noOfLKgInput.value) || 0;
        var unitPricePesticides = parseFloat(unitPricePesticidesInput.value) || 0;

        // Calculate total cost by multiplying number of L or Kg by unit price of pesticides
        var totalCost = noOfLKg * unitPricePesticides;

        // Set the value to the total cost pesticides input
        totalCostPesticidesInput.value = totalCost.toFixed(2);
    }

    // Attach event listeners to number of L or Kg and unit price inputs
    noOfLKgInput.addEventListener("input", calculateTotalCostPesticides);
    unitPricePesticidesInput.addEventListener("input", calculateTotalCostPesticides);

    // Initial calculation when the page loads
    calculateTotalCostPesticides();
});

// total variable cost
document.addEventListener("DOMContentLoaded", function () {
    // Get all relevant inputs
    var totalSeedCostInput = document.getElementById("totalSeedCostInput");
    var totalLaborCostInput = document.getElementById("totalLaborCostInput");
    var totalCostFertilizersInput = document.getElementById("totalCostFertilizersInput");
    var totalCostPesticidesInput = document.getElementById("totalCostPesticidesInput");
    var totalDeliveryCostInput = document.getElementById("totalDeliveryCostInput");
    var totalMachineryFuelCostInput = document.getElementById("totalMachineryFuelCostInput");
    var totalVariableCostInput = document.getElementById("totalVariableCostInput");

    // Function to calculate total variable cost
    function calculateTotalVariableCost() {
        var totalSeedCost = parseFloat(totalSeedCostInput.value) || 0;
        var totalLaborCost = parseFloat(totalLaborCostInput.value) || 0;
        var totalCostFertilizers = parseFloat(totalCostFertilizersInput.value) || 0;
        var totalCostPesticides = parseFloat(totalCostPesticidesInput.value) || 0;
        var totalDeliveryCost = parseFloat(totalDeliveryCostInput.value) || 0;
        var totalMachineryFuelCost = parseFloat(totalMachineryFuelCostInput.value) || 0;

        // Total variable cost is the sum of all the above costs
        var totalVariableCost = totalSeedCost + totalLaborCost + totalCostFertilizers + totalCostPesticides + totalDeliveryCost + totalMachineryFuelCost;
        
        // Set the value of the total variable cost input
        totalVariableCostInput.value = totalVariableCost.toFixed(2);
    }

    // Attach event listeners to all inputs that affect the total variable cost
    totalDeliveryCostInput.addEventListener("input", calculateTotalVariableCost);
    totalMachineryFuelCostInput.addEventListener("input", calculateTotalVariableCost);
    totalCostPesticidesInput.addEventListener("input", calculateTotalVariableCost);
    totalCostFertilizersInput.addEventListener("input", calculateTotalVariableCost);
    totalSeedCostInput.addEventListener("input", calculateTotalVariableCost);
    totalLaborCostInput.addEventListener("input", calculateTotalVariableCost);

    // Initial calculation when the page loads
    calculateTotalVariableCost();
});


function convertMeasurement(saleCounter) {
    var measurement = document.getElementById('measurement_' + saleCounter).value;
    var quantityField = document.getElementById('quantity_' + saleCounter);
    var quantity = parseFloat(quantityField.value);

    // Convert tons to kilograms if the selected unit is tons
    if (measurement === 'tons' && !isNaN(quantity)) {
        // Convert tons to kg (1 ton = 1000 kg)
        quantityField.value = (quantity * 1000).toFixed(2); // Convert and update the quantity field
    } else if (measurement === 'kg' && !isNaN(quantity)) {
        // If the user switches back to kilograms, keep the value as is
        quantityField.value = quantity.toFixed(2);
    }

    // Recalculate gross income after conversion
    calculateGrossIncome(saleCounter);
}

function calculateGrossIncome(saleCounter) {
    var unitPrice = document.getElementById('unit_price_per_kg_' + saleCounter).value;
    var quantity = document.getElementById('quantity_' + saleCounter).value;

    if (!isNaN(unitPrice) && !isNaN(quantity) && unitPrice > 0 && quantity > 0) {
        var grossIncome = unitPrice * quantity;
        document.getElementById('gross_income_' + saleCounter).value = grossIncome.toFixed(2);
    } else {
        document.getElementById('gross_income_' + saleCounter).value = '';
    }
}

// Function to allow only numbers and a decimal point
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
        return false;
    }
    return true;
}

</script>
  @endsection
