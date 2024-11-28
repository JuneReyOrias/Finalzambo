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
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" id="headingFarmProfile" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                <h5 class="mb-0" style="margin: 0;">
                    <button class="btn btn-modern" type="button" data-toggle="collapse" data-target="#collapseFarmProfile" aria-expanded="true" aria-controls="collapseFarmProfile">
                        Add Farm Profile
                    </button>
                </h5>
                
                <!-- Button to Add New Crop Section (aligned to the right) -->
                <button class="btn btn-secondary ml-auto" type="button" id="addCropButton">Add Crop</button>
            </div>
            
            <div id="collapseFarmProfile" class="collapse show" aria-labelledby="headingFarmProfile" data-parent="#accordionFarmProfile">
                <div class="card-body">
                    <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                    <div id="farmProfiles"></div>
                    <h3>a. Farm Location </h3>
                    <div class="user-details">
                        <div id="farmProfiles">
                        <div class="user-details">
                            <input type="hidden" class="form-control light-gray-placeholder users_id" value="{{$userId}}" placeholder="Enter farm address" id="rice_farm_address_0">
                            <input type="hidden"class="form-control light-gray-placeholder personalinfo_id" id="personalinfos" value="{{ $personalinfos->id }}">
                            <div class="input-box col-md-4">
                                <span class="details">Tenurial Status:</span>
                                {{-- <label class="detail">Tenurial Status:</label> --}}
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder placeholder-text tenurial_status @error('tenurial_status') is-invalid @enderror" name="tenurial_status" id="selectTenurialStatus" onchange="checkTenurial()" aria-label="label select e">
                                        <option value="">Select</option>
                                        <option  value="Owner" {{ old('tenurial_status') == 'Owner' ? 'selected' : '' }}>Owner</option>
                                        <option value="Owner Tiller" {{ old('tenurial_status') == 'Owner Tiller' ? 'selected' : '' }}>Owner Tiller</option>
                                        <option value="Tenant" {{ old('tenurial_status') == 'Tenant' ? 'selected' : '' }}>Tenant</option>
                                        <option value="Tiller" {{ old('tenurial_status') == 'Tiller' ? 'selected' : '' }}>Tiller</option>
                                        <option value="Lease" {{ old('tenurial_status') == 'Lease' ? 'selected' : '' }}>Lease</option>
                                        <option value="Add" {{ old('tenurial_status') == 'Add' ? 'selected' : '' }}>Add</option>
                                    </select>
                                    <button type="button" id="removeTenurialButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeTenurial()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('tenurial_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Farm Address:</span>
                                <input type="text" class="form-control light-gray-placeholder farm_address" name="farm_profiles[0][farm_address]" placeholder="Enter farm address" id="rice_farm_address_0" onkeypress="return blockSymbolsAndNumbers(event)">
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">No.of Years as Farmer:</span>
                                <input type="text" class="form-control light-gray-placeholder no_of_years_as_farmers" name="farm_profiles[0][no_of_years_as_farmers]" id="no_of_years_as_farmers_0" placeholder="Enter no fo years as farmers">
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">GPS Longitude:</span>
                                <input type="text" class="form-control light-gray-placeholder gps_longitude" name="farm_profiles[0][gps_longitude]" id="gps_longitude_0" placeholder="GPS_longitude" readonly >
                              </div>
                              <div class="input-box col-md-4">
                                <span class="details">GPS Latitude:</span>
                                <input type="text" class="form-control light-gray-placeholder gps_latitude" name="farm_profiles[0][gps_latitude]" id="gps_latitude_0"placeholder="GPS_latitude" readonly>
                              </div>
                            
                                    <!-- Map Modal -->
                                    <div id="mapModal" class="modal fade" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-sm">
                                                <div class="modal-header bg-white text-white">
                                                    <h5 class="modal-title" id="mapModalLabel">
                                                        <i class="fas fa-map-marker-alt me-2"></i>Select Location on Map
                                                    </h5>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">x</button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Map Container -->
                                                    <div id="map" style="height: 400px; width: 100%; border-radius: 8px; overflow: hidden;"></div>
                                                    <!-- Latitude and Longitude Inputs -->
                                                    <div class="row mt-4 g-3">
                                                        <div class="col-12 col-md-6">
                                                            <label for="modal_latitude" class="form-label">Latitude:</label>
                                                            <input type="text" class="form-control border-secondary" placeholder="Enter latitude" id="modal_latitude">
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label for="modal_longitude" class="form-label">Longitude:</label>
                                                            <input type="text" class="form-control border-secondary" placeholder="Enter longitude" id="modal_longitude">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Cancel
                                                    </button>
                                                    <button type="button" class="btn btn-primary" id="saveLocation">
                                                        <i class="fas fa-save me-1"></i>Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
  
                       
                            <div class="input-box col-md-4">
                                <span class="details">Total Physical Area (has):</span>
                                <input type="number" class="form-control light-gray-placeholder total_physical_area_has" name="farm_profiles[0][total_physical_area_has]" id="total_physical_area_has_0" value="{{old('total_physical_area_has')}}" >
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">Total Area Cultivated (has):</span>
                                <input type="number" class="form-control light-gray-placeholder Total_area_cultivated_has" name="farm_profiles[0][Total_area_cultivated_has]"id="rice_area_cultivated_has_0" placeholder=" Enter total area cultivated has" value="{{'total_area_cultivated'}}">
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">Land Title No:</span>
                                <input type="text" class="form-control light-gray-placeholder land_title_no" name="farm_profiles[0][land_title_no]" id="land_title_no_0" placeholder="Enter land title no" value="{{old('land_title_no')}}">
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">Lot No:</span>
                                <input type="text" class="form-control light-gray-placeholder lot_no" name="farm_profiles[0][lot_no]" id="lot_no_0" placeholder="Enter lot no" value="{{old('lot_no')}}">
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">Area Prone To:</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder area_prone_to placeholder-text @error('area_prone_to') is-invalid @enderror" id="selectedAreaprone" onchange="checkProne()" name="area_prone_to" aria-label="Floating label select e">
                                        <option value="">Select</option>
                                        <option  value="Flood" {{ old('area_prone_to') == 'Flood' ? 'selected' : '' }}>Flood</option>
                                        <option value="Drought" {{ old('area_prone_to') == 'Drought' ? 'selected' : '' }}>Drought</option>
                                        <option value="Saline" {{ old('area_prone_to') == 'Saline' ? 'selected' : '' }}>Saline</option>
                                        <option value="N/A" {{ old('area_prone_to') == 'N/A' ? 'selected' : '' }}>N/A</option>
                                        <option value="Add Prone" {{ old('area_prone_to') == 'Add Prone' ? 'selected' : '' }}>Add</option>
                                    </select>
                                    <button type="button" id="removeProneButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeProne()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('area_prone_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- <div class="input-box col-md-4" id="AreaProneInput" style="display: none;">
                                <label for="lot_no_0">Add New area Prone to:</label>
                                <input type="text"id="AreaProneInputField" class="form-control light-gray-placeholder add_newProneYear"value="8434.34" name="farm_profiles[0][lot_no]" id="lot_no_0" >
                            </div> --}}
                            <div class="input-box col-md-4">
                                <span class="details">Ecosystem:</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder ecosystem placeholder-text @error('ecosystem') is-invalid @enderror" id="selectedEcosystem" onchange="checkEcosystem()" name="ecosystem" aria-label="Floating label select e">
                                        <option value="">Select</option>
                                        <option value="Lowland Rain Fed" {{ old('ecosystem') == 'Lowland Rain Fed' ? 'selected' : '' }}>Lowland Rain Fed</option>
                                        <option value="Lowland Irrigated" {{ old('ecosystem') == 'Lowland Irrigated' ? 'selected' : '' }}>Lowland Irrigated</option>
                                        <option value="Add ecosystem" {{ old('ecosystem') == 'Add ecosystem' ? 'selected' : '' }}>Add</option>
                                    </select>
                                    <button type="button" id="removeEcosystemButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeEcosystem()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('ecosystem')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            

                            {{-- <div class="input-box col-md-4" id="EcosystemInput"  style="display: none;">
                                <label for="lot_no_0">Add New Ecosystem:</label>
                                <input type="text"id="EcosystemInputField" class="form-control light-gray-placeholder add_newProneYear"value="rainy land" name="farm_profiles[0][lot_no]" id="lot_no_0" >
                            </div> --}}
                        </div>
                        <h3>b. Insurance and Financial Information</h3><br>
                            <div class="user-details">
                          
                    <div class="input-box col-md-4">
                        <span class="details">RSBA Register:</span>
                               
                                <select class="form-control custom-select light-gray-placeholder rsba_register placeholder-text @error('rsba_register') is-invalid @enderror" id="rsba_register" name="rsba_register" aria-label="Floating label select e">
                                    <option value="">Select</option>
                                    <option value="Yes" {{ old('rsba_register') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('rsba_register') == 'No' ? 'selected' : '' }}>No</option>
                              
                                  </select>
                            
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">PCIC Insured:</span>
                                
                                <select class="form-control custom-select light-gray-placeholder pcic_insured placeholder-text @error('pcic_insured') is-invalid @enderror" id="pcic_insured" name="pcic_insured" aria-label="Floating label select e">
                                    <option value="">Select</option>
                                    <option  value="Yes" {{ old('pcic_insured') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('pcic_insured') == 'No' ? 'selected' : '' }}>No</option>
                              
                                  </select>
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">Government Assisted:</span>
                           
                                <select class="form-control custom-select light-gray-placeholder government_assisted placeholder-text @error('government_assisted') is-invalid @enderror" id="government_assisted" name="government_assisted" aria-label="Floating label select e">
                                    <option selected class="light-gray-placeholder"  disabled>Select</option>

                                    <option value="Yes" {{ old('government_assisted') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('government_assisted') == 'No' ? 'selected' : '' }}>No</option>
                              
                                  </select>
                            
                            </div>
                            <div class="input-box col-md-4">
                                <span class="details">Source of Capital:</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder source_of_capital placeholder-text @error('source_of_capital') is-invalid @enderror" id="selectedSourceCapital" onchange="checkSourceCapital()" name="source_of_capital" aria-label="Floating label select e">
                                        <option value="">Select</option>
                                        <option value="Own" {{ old('source_of_capital') == 'Own' ? 'selected' : '' }}>Own</option>
                                        <option value="Loan" {{ old('source_of_capital') == 'Loan' ? 'selected' : '' }}>Loan</option>
                                        <option value="Financed" {{ old('source_of_capital') == 'Financed' ? 'selected' : '' }}>Financed</option>
                                        <option value="Others" {{ old('source_of_capital') == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    <button type="button" id="removeSourceCapitalButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeSourceCapital()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('source_of_capital')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                          

                            <div class="input-box col-md-4">
                                <span class="details">Remarks/Recommendation:</span>
                                <input type="text" class="form-control light-gray-placeholder remarks" name="farm_profiles[0][remarks_recommendation]" id="remarks_recommendation_0" placeholder=" Enter remarks" onkeypress="return blockSymbolsAndNumbers(event)">
                            </div>
                            {{-- <div class="input-box col-md-4">
                                <label for="oca_district_office_0">OCA District Office:</label>
                                <input type="text" class="form-control light-gray-placeholder oca_district_office" name="farm_profiles[0][oca_district_office]" id="oca_district_office_0" placeholder=" Enter oca district" >
                            </div> --}}
                            <div class="input-box col-md-4">
                                <span class="details">Name of Technicians:</span>
                                <input type="text" class="form-control light-gray-placeholder name_technicians" name="farm_profiles[0][name_technicians]" id="name_technicians_0" placeholder="Enter name of technicians" onkeypress="return blockSymbolsAndNumbers(event)">
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Date of Interview:</span>
                                <input type="text" class="form-control light-gray-placeholder date_interview" name="farm_profiles[0][date_interview]" id="datepicker" placeholder="date interview" required>
                            </div>
                            
                
                            
                        
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
               
  
            <!-- Farm Information Accordion -->
            <div class="accordion-item">
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
<div class="modal fade" id="successCropModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Success!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body text-center py-5">
                <i class="fas fa-smile-beam fa-3x text-success mb-4"></i>
                <p class="fs-5 text-muted">
                    Your data has been successfully added.
                </p>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer justify-content-center border-0">
                <a href="{{ route('admin.farmersdata.farm', $personalinfos->id) }}" class="btn btn-lg btn-success px-5">
                    Proceed to Farm Data
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

  

 


  
  


 <!-- Modal for Adding New Barangay -->
 <div class="modal fade" id="newBarangayModal" tabindex="-1" aria-labelledby="newBarangayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="newBarangayModalLabel">Add New Barangay</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="addBarangayForm">
            <div class="mb-3">
            <label for="newBarangayName" class="form-label">Barangay Name</label>
            <input type="text" class="form-control" id="newBarangayName" placeholder="Enter new barangay name">
            </div>
        </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveNewBarangay">Save</button>
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
                <!-- Modal Structure -->
<div id="cropModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Add Crop</h2>
        <input type="text" id="cropName" class="form-control" placeholder="Crop Name" required>
        <button type="button" class="btn btn-primary" id="confirmAddCropButton">Add Crop</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let cropCounter = 0;
    let availableNumbers = [];
    let cropsInfo = [];
    const submitButton = document.getElementById('submitButton');
    const cropContainer = document.getElementById('cropProfiles');
    const addCropButton = document.getElementById('addCropButton');
    function fetchCropNames() {
    $.ajax({
        url: '/admin-add-farm/{personalinfos}',
        method: 'GET',
        data: { type: 'crops' },
        success: function(response) {
            console.log('AJAX response:', response);
            
            if (response.error) {
                console.error('Error fetching crop names:', response.error);
                return;
            }
            
            if (typeof response === 'object' && Object.keys(response).length > 0) {
                console.log('Received crop names data:', response);
                
                $('#cropProfiles .crop-section select.crop_name').each(function() {
                    const $select = $(this);
                    $select.empty();
                    $select.append('<option value="" disabled selected>Select Crop</option>');
                    
                    console.log('Processing dropdown:', $select);

                    $.each(response, function(id, name) {
                        console.log('Adding crop:', name, 'with ID:', id);
                        $select.append(new Option( id, name));
                    });
                    
                    console.log('Populated crop dropdown with options:', $select.html());
                });
            } else {
                console.warn('No crop names data received or data is empty.');
            }
        },
        error: function(xhr) {
            console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
        }
    });
}

// Function to fetch crop varieties based on selected crop name
function fetchCropVarieties(cropId, selectElement) {
    $.ajax({
        url: '/admin-add-farm/{personalinfos}',
        method: 'GET',
        data: { type: 'varieties', crop_name: cropId },
        success: function(response) {
            if (response.error) {
                console.error('Error fetching crop varieties:', response.error);
                return;
            }

            const $varietySelect = $(selectElement).closest('.crop-section').find('.crop_variety');
            $varietySelect.empty(); // Clear existing options
            $varietySelect.append('<option value="" disabled selected>Select Variety</option>');
            $varietySelect.append('<option value="add">Add New Variety...</option>'); // Option to add new variety

            $.each(response, function(id, variety) {
                $varietySelect.append(new Option(variety, id));
            });
        },
        error: function(xhr) {
            console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
        }
    });
}

// Bind change event to crop name dropdowns
$(document).on('change', '.crop_name', function() {
    const cropId = $(this).val();
    if (cropId) {
        fetchCropVarieties(cropId, this);
    } else {
        // Clear the variety dropdown if no crop is selected
        $(this).closest('.crop-section').find('.crop_variety').empty().append('<option value="" disabled selected>Select Variety</option><option value="add">Add New Variety...</option>');
    }
});

// Bind change event to crop variety dropdowns
$(document).on('change', '.crop_variety', function() {
    const cropVarietySelect = this;

    if (cropVarietySelect.value === "add") {
        var newVariety = prompt("Please enter the name of the crop variety:");

        if (newVariety) {
            var existingOption = Array.from(cropVarietySelect.options).find(option => option.value === newVariety);

            if (!existingOption) {
                var newOption = document.createElement("option");
                newOption.text = newVariety;
                newOption.value = newVariety;
                cropVarietySelect.appendChild(newOption);
                cropVarietySelect.value = newVariety; // Select the newly added variety
            }
        }
    }
});


function fetchCropSeeds(varietyId, selectElement) {
    $.ajax({
        url: '/admin-add-farm/{personalinfos}',
        method: 'GET',
        data: { type: 'seedname', variety_name: varietyId },
        success: function(response) {
            if (response.error) {
                console.error('Error fetching crop seeds:', response.error);
                return;
            }

            const $seedSelect = $(selectElement);
            $seedSelect.empty();
            $seedSelect.append('<option value="" disabled selected>Select Seed</option>');

            // Add fetched seed options
            $.each(response, function(id, seed) {
                $seedSelect.append(new Option(seed, id));
            });

            // Ensure "Add New Seed" option is present
            if ($seedSelect.find('option[value="add_new"]').length === 0) {
                $seedSelect.append('<option value="add_new">Add New Seed</option>');
            }
        },
        error: function(xhr) {
            console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
        }
    });
}

$(document).on('change', '.crop_variety', function() {
    const varietyId = $(this).val();
    if (varietyId) {
        fetchCropSeeds(varietyId, $(this).closest('.crop-section').find('.seed_name'));
    } else {
        const $seedSelect = $(this).closest('.crop-section').find('.seed_name');
        $seedSelect.empty().append('<option value="" disabled selected>Select Seed</option>');
        $seedSelect.append('<option value="add_new">Add New Seed</option>');

        // Hide the remove button
        $(this).closest('.crop-section').find('.btn-outline-danger').hide();
    }
});

$(document).on('change', '.seed_name', function() {
    const $seedSelect = $(this);
    
    const selectedValue = $seedSelect.val();
    const cropCounter = $seedSelect.attr('id').split('_').pop();

    if (selectedValue === 'add_new') {
        // Prompt for new seed name
        const newSeedName = prompt("Please enter a new seed name:");
        if (newSeedName) {
            const newSeedId = 'new_' + Date.now(); // Generate a unique ID for the new option
            $seedSelect.append(new Option(newSeedName, newSeedId));
            $seedSelect.val(newSeedId); // Set the newly added seed as selected
            
            // Remove "Add New Seed" option if it exists
            $seedSelect.find('option[value="add_new"]').remove();

            // Show the remove button for the newly added seed
            $('#seed_remove_' + cropCounter).show();
        }
    } else if (selectedValue.startsWith('new_')) {
        // Show the remove button if a newly added seed is selected
        $('#seed_remove_' + cropCounter).show();
    }
});

// Function to remove newly added seeds
function removeSeed(cropCounter) {
    const $seedSelect = $('#seed_name_' + cropCounter);
    const selectedValue = $seedSelect.val();
    
    if (selectedValue && selectedValue.startsWith('new_')) {
        // Confirm removal
        if (confirm("Are you sure you want to remove this seed?")) {
            $seedSelect.find('option[value="' + selectedValue + '"]').remove();
            
            // Hide the remove button if no new seeds are left
            if ($seedSelect.find('option[value^="new_"]').length === 0) {
                $('#seed_remove_' + cropCounter).hide();
            }
        }
    }
}
// Initialize crop name dropdowns on document ready
$(document).ready(function() {
    fetchCropNames();

});

    // Add Crop Button Click Handler
    document.getElementById('addCropButton').addEventListener('click', () => {
        if (availableNumbers.length > 0) {
            // Use the lowest available number
            cropCounter = availableNumbers.shift();
        } else {
            // Increment counter if no available numbers
            cropCounter++;
        }

        const cropHtml = `
            <div class="card crop-section mb-3" id="crop_${cropCounter}">
                <div class="card-header d-flex justify-content-between align-items-center" id="headingCrop_${cropCounter}" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                    <h5 class="mb-0" style="margin: 0;">
                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseCrop_${cropCounter}" aria-expanded="false" aria-controls="collapseCrop_${cropCounter}">
                            Crop ${cropCounter} Info
                        </button>
                    </h5>
                    <button class="btn btn-danger btn-sm ml-auto" type="button" onclick="removeCrop(${cropCounter})">
                        Remove
                    </button>
                </div>
                <div id="collapseCrop_${cropCounter}" class="collapse" aria-labelledby="headingCrop_${cropCounter}">
                    <div class="card-body">
                        
                        <div class="user-details">
                        <!-- Crop Fields -->
                         <div class="input-box col-md-4">
                              
                                 <span class="details">Crop Name</span>
                                <select class="form-control crop_name" id="crop_name_${cropCounter}" required>
                                   
                                </select>
                            </div>
                            <div class="input-box col-md-4">
                                 <span class="details">Crop Variety:</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control crop_variety" id="crop_variety_${cropCounter}" onchange="checkCropVariety(${cropCounter})"required>
                                        
                                        <option value="add">Add(optional)</option>
                                    </select>
                                    <button type="button" id="crop_variety_remove_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeCropVariety(${cropCounter})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>


                            <div class="input-box col-md-4">
                                  <span class="details">Preferred Variety(optional):</span>
                                <input type="text" class="form-control prferred_variety" name="crop_profiles[${cropCounter}][preferred_variety]" id="preferred_variety_${cropCounter}" placeholder="Enter preferred variety">
                            </div>

                              <div class="input-box col-md-4">
                                 <span class="details">No. of cropping/year:</span>
                                <input type="number" class="form-control no_crop_year" name="crop_profiles[${cropCounter}][no_of_cropping_per_year]"placeholder="no of cropping/year" id="no_of_cropping_per_year_${cropCounter}">
                            </div>
                            <div class="input-box col-md-4">
                                  <span class="details">Planting Schedule (Wet Season):</label>
                                <input type="text" class="form-control wet_season" name="crop_profiles[${cropCounter}][planting_schedule_wetseason]"  id="datepicker_${cropCounter}" placeholder="Planting schedule"
                                    value="{{ old('plant_schedule_wetseason') }}" data-input='true'>
                            </div>
                             <div class="input-box col-md-4">
                                <span class="details">Planting Schedule (Dry Season):</span>
                                <input type="text" class="form-control dry_season" name="crop_profiles[${cropCounter}][planting_schedule_dryseason]"placeholder="Planting schedule"  id="datepicker_${cropCounter}">
                            </div>
                           

                               <div class="input-box col-md-4">
                                <span class="details">Yield Kg/Tons:</span>
                                <input type="number" class="form-control yield_kg_ha" name="crop_profiles[${cropCounter}][yield_kg_ha]"placeholder="Yield Kg/Tons" id="yield_kg_ha_${cropCounter}">
                            </div>
                        </div>

                        <!-- Other fields here -->
                         </div>
                        <div class="accordion" id="accordionCropDetails_${cropCounter}">
                            <!-- Add Production Section -->
                            <div class="card">
                                <div class="card-header" id="headingProduction_${cropCounter}" style="background-color: #e9ecef; border: none; padding: 10px 20px;">
                                    <h5 class="mb-0" style="margin: 0;">
                                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseProduction_${cropCounter}" aria-expanded="false" aria-controls="collapseProduction_${cropCounter}">
                                            Add Production
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseProduction_${cropCounter}" class="collapse" aria-labelledby="headingProduction_${cropCounter}" data-parent="#accordionCropDetails_${cropCounter}">
                                    <div class="card-body">
                                           <h3>a. Seed info and Usage details: </h3>
                                           <div class="user-details">
                                        <!-- Production Fields -->
                                        <div class="input-box col-md-4"">
                                              <span class="details">Seed type Used:</span>
                                            <input type="text" class="form-control seed-type" name="crop_profiles[${cropCounter}][seeds_typed_used]" placeholder=" Enter Seed type used" id="seeds_typed_used_${cropCounter}" onkeypress="return blockSymbolsAndNumbers(event)">
                                        </div>
                                          <div class="input-box col-md-4"">
                                           <span class="details">Seeds used in kg:</span>
                                            <input type="number" class="form-control seed-used" name="crop_profiles[${cropCounter}][seeds_used_in_kg]"placeholder=" Enter Seed used in kg" id="seeds_used_in_kg_${cropCounter}">
                                            
                                            </div>
                                  <div class="input-box col-md-4">
                                       <span class="details">Seed Source:</span>
                                        <div class="d-flex align-items-center">
                                            <select class="form-control custom-select light-gray-placeholder seed-source placeholder-text @error('seed_source') is-invalid @enderror" id="seed_source_${cropCounter}" onchange="checkSeedSource(${cropCounter})" name="seed_source" aria-label="Floating label select e">
                                                <option value="">Select</option>
                                                <option value="Government Subsidy" {{ old('seed_source') == 'Government Subsidy' ? 'selected' : '' }}>Government Subsidy</option>
                                                <option value="Traders" {{ old('seed_source') == 'Traders' ? 'selected' : '' }}>Traders</option>
                                                <option value="Own" {{ old('seed_source') == 'Own' ? 'selected' : '' }}>Own</option>
                                                <option value="Add" {{ old('seed_source') == 'Add' ? 'selected' : '' }}>Add</option>
                                            </select>
                                            <button type="button" id="removeSeedSourceButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeSeedSource(${cropCounter})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        @error('seed_source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                       
                                        <div class="input-box col-md-4">
                                    <span class="details">Unit:</span>
                                    <div class="d-flex align-items-center">
                                        <select class="form-control custom-select light-gray-placeholder unit placeholder-text @error('unit') is-invalid @enderror" id="unit" name="unit" onchange="Unit()">
                                            <option value="">Select</option>
                                            <option value="tons" {{ old('unit') == 'tons' ? 'selected' : '' }}>tons</option>
                                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                                          
                                        </select>
                                        <button type="button" id="removeUnitButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeUnit()">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                          <div class="input-box col-md-4"">
                                           <span class="details">no of fertilizer used in bags:</span>
                                            <input type="number" class="form-control fertilized-used" name="crop_profiles[${cropCounter}][no_of_fertilizer_used_in_bags]"placeholder="Enter no of fertilizer used in bags" id="no_of_fertilizer_used_in_bags_${cropCounter}">
                                        </div>
                                         <div class="input-box col-md-4"">
                                          <span class="details">no of pesticides used in L/KG:</span>
                                            <input type="number" class="form-control pesticides-used" name="crop_profiles[${cropCounter}][no_of_pesticides_used_in_l_per_kg]" placeholder=" Enter no of cropping/year" id="no_of_pesticides_used_in_l_per_kg_${cropCounter}">
                                        </div>
                                        <div class="input-box col-md-4"">
                                            <span class="details">no of insecticides used in L/KG:</span>
                                            <input type="number" class="form-control insecticides-used" name="crop_profiles[${cropCounter}][no_of_insecticides_used_in_l_]" placeholder="Enter no of cropping/year" id="no_of_insecticides_used_in_l_${cropCounter}">
                                        </div>
                                        
                                           
                                    </div>

                                    <h3>b. Crop Planting Details</h3>
                                        <div class="user-details">
                                            <div class="input-box col-md-4">
                                            <span class="details">Area Planted:</span>
                                            <input type="number" class="form-control area-planted" name="crop_profiles[${cropCounter}][area_planted]" placeholder="Enter Area Planted" >
                                        </div>

                                         <div class="input-box col-md-4">
                                          <span class="details">Date Planted:</span>
                                            <input type="text" class="form-control date-planted" name="crop_profiles[${cropCounter}][date_planted]" placeholder="Date Planted"  id="datepicker_${cropCounter}">
                                        </div>
                                    <div class="input-box col-md-4">
                                            <span class="details">Date Harvested:</span>
                                            <input type="text" class="form-control date-harvested" name="crop_profiles[${cropCounter}][date_planted]" placeholder="Date harvested"  id="datepicker_${cropCounter}">
                                        </div>
                                         <div class="input-box col-md-4">
                                            <span class="details">Yield Kg/Tons:</span>
                                            <input type="number" class="form-control yield-kg" name="crop_profiles[${cropCounter}][yield_tons_per_kg]" placeholder="Yield Kg/Tons" id="yield_tons_per_kg_${cropCounter}">
                                        </div>
                                         
 </div>


                            <div class="d-flex flex-column mb-3">
                                <!-- Add Sale Button -->
                                  <h3 class="mb-3">c. Sales Information</h3>
                                <div class="d-flex justify-content-end mb-2">
                                    <button type="button" class="btn btn-primary" onclick="addSale(${cropCounter})">Add Sale</button>
                                </div>
                            </div>

                                <div id="salesSection_${cropCounter}">
                                    </div>

                                    

                                </div>
                            </div>
                            <!-- Add Fixed Cost Section -->
                            <div class="card">
                                <div class="card-header" id="headingFixedCost_${cropCounter}" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                                    <h5 class="mb-0" style="margin: 0;">
                                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseFixedCost_${cropCounter}" aria-expanded="false" aria-controls="collapseFixedCost_${cropCounter}">
                                            Add Fixed Cost
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseFixedCost_${cropCounter}" class="collapse" aria-labelledby="headingFixedCost_${cropCounter}" data-parent="#accordionCropDetails_${cropCounter}">
                                    <div class="card-body">
                                           <h3>Fixed Cost</h3>
                                             <div class="user-details">
                                        <!-- Fixed Cost Fields -->
                                       <div class="input-box col-md-4">
                                        <span class="details">Particular:</span>
                                        <div class="d-flex align-items-center">
                                            <select class="form-control custom-select light-gray-placeholder particular @error('particular') is-invalid @enderror" 
                                                    name="crop_profiles[${cropCounter}][particular]" 
                                                    id="particular_${cropCounter}" 
                                                    onchange="checkParticular(${cropCounter})" 
                                                    aria-label="label select e">
                                                    <option value="">Select</option>
                                                <option selected value="Land Rental Cost" {{ old('particular') == 'Land Rental Cost' ? 'selected' : '' }}>Land Rental Cost</option>
                                                <option value="Land Ownership Cost" {{ old('particular') == 'Land Ownership Cost' ? 'selected' : '' }}>Land Ownership Cost</option>
                                                <option value="Equipment Costs" {{ old('particular') == 'Equipment Costs' ? 'selected' : '' }}>Equipment Costs</option>
                                                <option value="Infrastructure Costs" {{ old('particular') == 'Infrastructure Costs' ? 'selected' : '' }}>Infrastructure Costs</option>
                                                <option value="Other" {{ old('particular') == 'Other' ? 'selected' : '' }}>Others</option>
                                            </select>
                                            <button type="button" id="removeParticularButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeParticular(${cropCounter})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        @error('particular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                     
                                         
                                          
                                      
                               <div class="input-box col-md-4">
                                   <span class="details">No. of Has</span>
                                    <input type="number" class="form-control light-gray-placeholder no-has @error('gross_income_palay') is-invalid @enderror"
                                        name="no_of_ha_${cropCounter}" id="no_of_ha_${cropCounter}" placeholder="Enter No. of Has" 
                                        value="{{ old('no_of_ha') }}" oninput="calculateTotalAmount(${cropCounter})">
                                    @error('gross_income_palay')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-box col-md-4">
                                   <span class="details">Cost/Has (PHP)</span>
                                    <input type="number" class="form-control light-gray-placeholder cost-has @error('gross_income_rice') is-invalid @enderror"
                                        name="cost_per_ha_${cropCounter}" id="cost_per_ha_${cropCounter}" placeholder="Enter Cost/Has" 
                                        value="{{ old('cost_per_ha') }}" oninput="calculateTotalAmount(${cropCounter})">
                                    @error('gross_income_rice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-box col-md-4">
                                   <span class="details">Total Amount (PHP)</span>
                                    <input type="number" class="form-control light-gray-placeholder total-amount @error('gross_income_rice') is-invalid @enderror"
                                        name="total_amount_${cropCounter}" id="total_amount_${cropCounter}" placeholder="Enter total amount"  
                                        value="{{ old('total_amount') }}" readonly>
                                    @error('gross_income_rice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

;
                                   
                                  </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Add Machineries Section -->
                            <div class="card">
                                <div class="card-header" id="headingMachineries_${cropCounter}" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                                    <h5 class="mb-0" style="margin: 0;">
                                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseMachineries_${cropCounter}" aria-expanded="false" aria-controls="collapseMachineries_${cropCounter}">
                                            Add Machineries
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseMachineries_${cropCounter}" class="collapse" aria-labelledby="headingMachineries_${cropCounter}" data-parent="#accordionCropDetails_${cropCounter}">
                                    <div class="card-body">
                                           <h3>a. Plowing  </h3>
                                        <!-- Machineries Fields -->
                                       <div class="user-details">
      
                                                 <div class="input-box col-md-4">
                                                <span class="details">Plowing Machineries Used</span>
                                                <div class="d-flex align-items-center">
                                                <select class="form-control custom-select light-gray-placeholder plowing-machine @error('harro_ownership_status') is-invalid @enderror" 
                                                            name="harro_ownership_status_${cropCounter}" 
                                                            id="selectPlowing_${cropCounter}" 
                                                            onchange="checkPlowing(${cropCounter})" 
                                                            aria-label="label select e">
                                                        <option value="">Select</option>
                                                        <option value="Hand Tractor" {{ old('plowing-machine_${cropCounter}') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                                        <option value="Four-Wheel Tractors" {{ old('plowing-machine_${cropCounter}') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                                        <option value="Compact Tractors" {{ old('plowing-machine_${cropCounter}') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                                        <option value="Rice Transplanters" {{ old('plowing-machine_${cropCounter}') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                                        <option value="Crawler Tractors" {{ old('plowing-machine_${cropCounter}') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                                        <option value="OthersPlowing" {{ old('plowing-machine_${cropCounter}') == 'OthersPlowing' ? 'selected' : '' }}>Others(optional)</option>
                                                    </select>
                                                    <button type="button" id="removePlowingButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePlowing(${cropCounter})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                @error('harro_ownership_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                          
                                           
                                           <div class="input-box col-md-4">
                                            <span class="details">Ownership Status</span>
                                            <div class="d-flex align-items-center">
                                                <select class="form-control custom-select light-gray-placeholder plow_status @error('plowing_machineries_used') is-invalid @enderror" 
                                                        name="plo_ownership_status_${cropCounter}" 
                                                        id="selectPlowingStatus_${cropCounter}" 
                                                        onchange="checkPlowingStatus(${cropCounter})" 
                                                        aria-label="label select e">
                                                    <option value="">Select</option>
                                                    <option  value="Own" {{ old('plo_ownership_status_${cropCounter}') == 'Own' ? 'selected' : '' }}>Own</option>
                                                    <option value="Rent" {{ old('plo_ownership_status_${cropCounter}') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                                    <option value="Other" {{ old('plo_ownership_status_${cropCounter}') == 'Other' ? 'selected' : '' }}>Other(Optional)</option>
                                                </select>
                                                <button type="button" id="removePlowingStatusButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePlowingStatus(${cropCounter})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            @error('plowing_machineries_used')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                     <div class="input-box col-md-4">
                                        <span class="details">No. of Plowing</span>
                                        <input type="number" class="form-control light-gray-placeholder no_of_plowing @error('last_name') is-invalid @enderror"
                                            name="no_of_plowing_${cropCounter}" id="noPlowing_${cropCounter}" placeholder="Enter no. of plowing" 
                                            value="{{ old('no_of_plowing') }}" oninput="calculateTotalPlowingCost(${cropCounter})">
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-box col-md-4">
                                        <span class="details">Cost per Plowing</span>
                                        <input type="number" class="form-control light-gray-placeholder cost_per_plowing @error('plowing_cost') is-invalid @enderror"
                                            name="plowing_cost_${cropCounter}" id="plowingperCostInput_${cropCounter}" placeholder="Enter plowing per cost" 
                                            value="{{ old('plowing_cost') }}" oninput="calculateTotalPlowingCost(${cropCounter})">
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-box col-md-4">
                                        <span class="details">Total Plowing Cost</span>
                                        <input type="number" class="form-control light-gray-placeholder plowing_cost @error('last_name') is-invalid @enderror"
                                            name="total_plowing_cost_${cropCounter}" id="plowingCostInput_${cropCounter}" placeholder="Total plowing cost" 
                                            value="{{ old('plowing_cost') }}" readonly>
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                        
                                </div>


                        <h3>b.Harrowing  </h3>
                        <div class="user-details">
         
                        <div class="input-box col-md-4">
                            <span class="details">Harrowing Machineries Used</span>
                            <div class="d-flex align-items-center">
                                <select class="form-control custom-select light-gray-placeholder harro_machine @error('harrowing_machineries_used') is-invalid @enderror" 
                                        name="harrowing_machineries_used_${cropCounter}" 
                                        id="selectHarrowing_${cropCounter}" 
                                        onchange="checkHarrowing(${cropCounter})" 
                                        aria-label="label select e">
                                    <option value="">Select</option>
                                    <option value="Hand Tractor" {{ old('harrowing_machineries_used_${cropCounter}') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                    <option value="Four-Wheel Tractors" {{ old('harrowing_machineries_used_${cropCounter}') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                    <option value="Compact Tractors" {{ old('harrowing_machineries_used_${cropCounter}') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                    <option value="Rice Transplanters" {{ old('harrowing_machineries_used_${cropCounter}') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                    <option value="Crawler Tractors" {{ old('harrowing_machineries_used_${cropCounter}') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                    <option value="OthersHarrowing" {{ old('harrowing_machineries_used_${cropCounter}') == 'OthersHarrowing' ? 'selected' : '' }}>Others</option>
                                </select>
                                <button type="button" id="removeHarrowingButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeHarrowing(${cropCounter})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            @error('harrowing_machineries_used')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                           
                            <div class="input-box col-md-4">
                                <span class="details">Ownership Status</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder harro_ownership_status @error('harro_ownership_status') is-invalid @enderror" 
                                            name="harro_ownership_status_${cropCounter}" 
                                            id="selectOwnershipStatus_${cropCounter}" 
                                            onchange="checkOwnershipStatus(${cropCounter})" 
                                            aria-label="label select e">
                                        <option value="">Select</option>
                                        <option value="Own" {{ old('harro_ownership_status_${cropCounter}') == 'Own' ? 'selected' : '' }}>Own</option>
                                        <option value="Rent" {{ old('harro_ownership_status_${cropCounter}') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="Other" {{ old('harro_ownership_status_${cropCounter}') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removeOwnershipStatusButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeOwnershipStatus(${cropCounter})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('harro_ownership_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

       
                         <div class="input-box col-md-4">
                            <span class="details">No. of Harrowing</span>
                            <input type="number" class="form-control light-gray-placeholder no_of_harrowing @error('last_name') is-invalid @enderror"
                                name="no_of_harrowing_${cropCounter}" id="noHarrowing_${cropCounter}" placeholder="Enter no. of harrowing" 
                                value="{{ old('no_of_harrowing') }}" oninput="calculateTotalHarrowingCost(${cropCounter})">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-box col-md-4">
                            <span class="details">Cost per Harrowing</span>
                            <input type="number" class="form-control light-gray-placeholder cost_per_harrowing @error('plowing_cost') is-invalid @enderror"
                                name="harrowing_cost_${cropCounter}" id="costPerHarrowingInput_${cropCounter}" placeholder="Enter cost per harrowing" 
                                value="{{ old('harrowing_cost') }}" oninput="calculateTotalHarrowingCost(${cropCounter})">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-box col-md-4">
                            <span class="details">Total Harrowing Cost</span>
                            <input type="number" class="form-control light-gray-placeholder harrowing_cost_total @error('harrowing_cost_total') is-invalid @enderror"
                                name="total_harrowing_cost_${cropCounter}" id="harrowingCostInput_${cropCounter}" placeholder="Total harrowing cost" 
                                value="{{ old('harrowing_cost_total') }}" readonly>
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        </div>

                      <h3>c.Harvesting  </h3>
                        <div class="user-details">
         
                           <div class="input-box col-md-4">
                                <span class="details">Harvesting Machineries Used</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder harvest_machine @error('Harvesting_machineries_used') is-invalid @enderror" 
                                            name="Harvesting_machineries_used_${cropCounter}" 
                                            id="selectHarvestingMachine_${cropCounter}" 
                                            onchange="checkHarvestingMachine(${cropCounter})" 
                                            aria-label="label select e">
                                        <option value="">Select</option>
                                        <option value="Hand Tractor" {{ old('Harvesting_machineries_used_${cropCounter}') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                        <option value="Four-Wheel Tractors" {{ old('Harvesting_machineries_used_${cropCounter}') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                        <option value="Compact Tractors" {{ old('Harvesting_machineries_used_${cropCounter}') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                        <option value="Rice Transplanters" {{ old('Harvesting_machineries_used_${cropCounter}') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                        <option value="Crawler Tractors" {{ old('Harvesting_machineries_used_${cropCounter}') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                        <option value="Others" {{ old('Harvesting_machineries_used_${cropCounter}') == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    <button type="button" id="removeHarvestingMachineButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeHarvestingMachine(${cropCounter})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('Harvesting_machineries_used')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-box col-md-4">
                                <span class="details">Ownership Status</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder harvest_ownership_status @error('harro_ownership_status') is-invalid @enderror" 
                                            name="harro_ownership_status_${cropCounter}" 
                                            id="selectHarvestOwnership_${cropCounter}" 
                                            onchange="checkHarvestOwnership(${cropCounter})" 
                                            aria-label="label select e">
                                        <option value="">Select</option>
                                        <option value="Own" {{ old('harro_ownership_status_${cropCounter}') == 'Own' ? 'selected' : '' }}>Own</option>
                                        <option value="Rent" {{ old('harro_ownership_status_${cropCounter}') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="Other" {{ old('harro_ownership_status_${cropCounter}') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removeHarvestOwnershipButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeHarvestOwnership(${cropCounter})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('harro_ownership_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                         <div class="input-box col-md-4">
                                    <span class="details">No. of Harvesting</span>
                                    <input type="number" class="form-control light-gray-placeholder no_of_Harvesting @error('last_name') is-invalid @enderror"
                                        name="no_of_Harvesting_${cropCounter}" id="noHarvesting_${cropCounter}" placeholder="Enter no. of Harvesting" 
                                        value="{{ old('no_of_Harvesting') }}" oninput="calculateTotalHarvestingCost(${cropCounter})">
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-box col-md-4">
                                    <span class="details">Cost per Harvesting</span>
                                    <input type="number" class="form-control light-gray-placeholder cost_per_Harvesting @error('plowing_cost') is-invalid @enderror"
                                        name="Harvesting_cost_${cropCounter}" id="costPerHarvestingInput_${cropCounter}" placeholder="Enter cost per harvesting" 
                                        value="{{ old('Harvesting_cost') }}" oninput="calculateTotalHarvestingCost(${cropCounter})">
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-box col-md-4">
                                    <span class="details">Total Harvesting Cost</span>
                                    <input type="number" class="form-control light-gray-placeholder Harvesting_cost_total @error('Harvesting_cost_total') is-invalid @enderror"
                                        name="total_harvesting_cost_${cropCounter}" id="harvestingCostInput_${cropCounter}" placeholder="Total harvesting cost" 
                                        value="{{ old('Harvesting_cost_total') }}" readonly>
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                        
                        </div>

                      <h3>d. Post Harvest Machineries  </h3>
                        <div class="user-details">
         
                          <div class="input-box col-md-4">
                                <span class="details">Post-harvest Machineries Used</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder postharves_machine @error('postharvest_machineries_used') is-invalid @enderror"  
                                            name="postharvest_machineries_used_${cropCounter}" 
                                            id="selectPostHarvestMachine_${cropCounter}" 
                                            onchange="checkPostHarvestMachine(${cropCounter})" 
                                            aria-label="label select e">
                                        <option value="">Select</option>
                                        <option value="Hand Tractor" {{ old('postharvest_machineries_used_${cropCounter}') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                        <option value="Four-Wheel Tractors" {{ old('postharvest_machineries_used_${cropCounter}') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                        <option value="Compact Tractors" {{ old('postharvest_machineries_used_${cropCounter}') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                        <option value="Rice Transplanters" {{ old('postharvest_machineries_used_${cropCounter}') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                        <option value="Crawler Tractors" {{ old('postharvest_machineries_used_${cropCounter}') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                        <option value="OthersPostHarvest" {{ old('postharvest_machineries_used_${cropCounter}') == 'OthersPostHarvest' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    <button type="button" id="removePostHarvestMachineButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePostHarvestMachine(${cropCounter})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('postharvest_machineries_used')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           
                           <div class="input-box col-md-4">
                                <span class="details">Post Harvest Machineries Used</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder postharv_ownership_status @error('postharvest_machineries_used') is-invalid @enderror" 
                                            name="postharvest_machineries_used_${cropCounter}" 
                                            id="selectPostHarvestMachineries_${cropCounter}" 
                                            onchange="checkPostHarvestMachineries(${cropCounter})" 
                                            aria-label="label select e">
                                            <option value="">Select</option>
                                        <option value="Own" {{ old('postharvest_machineries_used_${cropCounter}') == 'Own' ? 'selected' : '' }}>Own</option>
                                        <option value="Rent" {{ old('postharvest_machineries_used_${cropCounter}') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="Other" {{ old('postharvest_machineries_used_${cropCounter}') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removePostHarvestMachineryButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePostHarvestMachinery(${cropCounter})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>

       
                            
                       <div class="input-box col-md-4">
                            <span class="details">Post-Harvest Cost</span>
                            <input type="number" class="form-control light-gray-placeholder postharvestCost @error('last_name') is-invalid @enderror"
                                name="post_harvest_cost_${cropCounter}" id="postHarvestCostInput_${cropCounter}" placeholder="Enter post-harvest cost" 
                                value="{{ old('post_harvest_cost') }}" oninput="calculateTotalMachineryCost(${cropCounter})">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input-box col-md-4">
                            <span class="details">Total Cost for Machineries</span>
                            <input type="number" class="form-control light-gray-placeholder total_cost_for_machineries @error('total_cost_for_machineries') is-invalid @enderror"
                                name="total_cost_for_machineries_${cropCounter}" id="totalCostInput_${cropCounter}" placeholder="Enter total expenses" 
                                value="{{ old('total_cost_for_machineries') }}" readonly>
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
       
       </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add Variable Cost Section -->
                            <div class="card">
                                <div class="card-header" id="headingVariableCost_${cropCounter}" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                                    <h5 class="mb-0" style="margin: 0;">
                                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseVariableCost_${cropCounter}" aria-expanded="false" aria-controls="collapseVariableCost_${cropCounter}">
                                            Add Variable Cost
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseVariableCost_${cropCounter}" class="collapse" aria-labelledby="headingVariableCost_${cropCounter}" data-parent="#accordionCropDetails_${cropCounter}">
                                    <div class="card-body">
                                        <!-- Variable Cost Fields -->
                                       <h3>a. Seed Cost </h3><br>

                                        <div class="user-details">
                                           
                                        <div class="input-box col-md-4">
                                            <label for="seed_name_${cropCounter}">Seed name:</label>
                                            <div class="d-flex align-items-center">
                                                <select class="form-control seed_name" id="seed_name_${cropCounter}" onchange="checkSeedName(${cropCounter})">
                                                    <option value="" disabled selected>Select seed</option>
                                                    <option value="add">Add (optional)</option>
                                                </select>
                                                <button type="button" id="seed_remove_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeSeed(${cropCounter})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                                    
                                         <div class="input-box col-md-4">
                                    <span class="details">Unit:</span>
                                    <div class="d-flex align-items-center">
                                        <select class="form-control custom-select light-gray-placeholder unit placeholder-text @error('unit') is-invalid @enderror" id="unit" name="unit" onchange="Unit()">
                                            <option value="">Select</option>
                                            <option value="tons" {{ old('unit') == 'tons' ? 'selected' : '' }}>tons</option>
                                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                                            <option value="Add" {{ old('unit') == 'Add' ? 'selected' : '' }}>Add</option>
                                        </select>
                                        <button type="button" id="removeUnitButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeUnit()">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                  
                                        <div class="input-box col-md-4">
                                                <span class="details">Quantity</span>
                                                <input type="number" class="form-control light-gray-placeholder quantity" 
                                                    name="quantity_${cropCounter}" id="quantityInput_${cropCounter}" 
                                                    placeholder="Enter quantity" value="{{ old('quantity') }}" 
                                                    oninput="calculateTotalSeedCost(${cropCounter})">
                                            </div>

                                            <div class="input-box col-md-4">
                                                <span class="details">Unit Price (PHP)</span>
                                                <input type="number" class="form-control light-gray-placeholder unit_price_seed" 
                                                    name="unit_price_${cropCounter}" id="unitPriceInput_${cropCounter}" 
                                                    placeholder="Enter unit price" value="{{ old('unit_price') }}" 
                                                    oninput="calculateTotalSeedCost(${cropCounter})">
                                            </div>

                                            <div class="input-box col-md-4">
                                                <span class="details">Total Seed Cost (PHP)</span>
                                                <input type="number" class="form-control light-gray-placeholder total_seed_cost" 
                                                    name="total_seed_cost_${cropCounter}" id="totalSeedCostInput_${cropCounter}" 
                                                    placeholder="Enter total seed cost" value="{{ old('total_seed_cost') }}" readonly>
                                            </div>

                                          </div>
                                          <br>
                                            <h3>b. Labor</h3><br>
                                  
                                            <div class="user-details">
                                        <div class="input-box col-md-4">
                                                <span class="details">No of Person</span>
                                                <input type="number" class="form-control light-gray-placeholder no_of_person" 
                                                    name="no_of_person_${cropCounter}" id="noOfPersonInput_${cropCounter}" 
                                                    placeholder="Enter number of persons" value="{{ old('no_of_person') }}" 
                                                    oninput="calculateTotalLaborCost(${cropCounter})">
                                            </div>

                                            <div class="input-box col-md-4">
                                                <span class="details">Rate per Person</span>
                                                <input type="number" class="form-control light-gray-placeholder rate_per_person" 
                                                    name="rate_per_person_${cropCounter}" id="ratePerPersonInput_${cropCounter}" 
                                                    placeholder="Enter rate per person" value="{{ old('rate_per_person') }}" 
                                                    oninput="calculateTotalLaborCost(${cropCounter})">
                                            </div>

                                            <div class="input-box col-md-4">
                                                <span class="details">Total Labor Cost</span>
                                                <input type="number" class="form-control light-gray-placeholder total_labor_cost" 
                                                    name="total_labor_cost_${cropCounter}" id="totalLaborCostInput_${cropCounter}" 
                                                    placeholder="Enter total labor cost" value="{{ old('total_labor_cost') }}" readonly>
                                            </div>

                                      </div>

                              <h3>c. Fertilizers </h3>
                                   <div class="user-details">
                             <div class="input-box col-md-4">
                                <span class="details">Name Of Fertilizer</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder name_of_fertilizer @error('name_of_fertilizer') is-invalid @enderror" 
                                            name="name_of_fertilizer_${cropCounter}" 
                                            id="selectNameOfFertilizer_${cropCounter}" 
                                            onchange="checkNameOfFertilizer(${cropCounter})" 
                                            aria-label="label select e">
                                        <option value="">Select</option>
                                        <option value="Nitrogen Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Nitrogen Fertilizers' ? 'selected' : '' }}>Nitrogen Fertilizers</option>
                                        <option value="Phosphorus Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Phosphorus Fertilizers' ? 'selected' : '' }}>Phosphorus Fertilizers</option>
                                        <option value="Potassium Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Potassium Fertilizers' ? 'selected' : '' }}>Potassium Fertilizers</option>
                                        <option value="Compound Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Compound Fertilizers' ? 'selected' : '' }}>Compound Fertilizers</option>
                                        <option value="Organic Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Organic Fertilizers' ? 'selected' : '' }}>Organic Fertilizers</option>
                                        <option value="Slow-Release Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Slow-Release Fertilizers' ? 'selected' : '' }}>Slow-Release Fertilizers</option>
                                        <option value="Micronutrient Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Micronutrient Fertilizers' ? 'selected' : '' }}>Micronutrient Fertilizers</option>
                                        <option value="Liquid Fertilizers" {{ old('name_of_fertilizer_${cropCounter}') == 'Liquid Fertilizers' ? 'selected' : '' }}>Liquid Fertilizers</option>
                                        <option value="other" {{ old('name_of_fertilizer_${cropCounter}') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removeNameOfFertilizerButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeNameOfFertilizer(${cropCounter})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                                        
             
                               <div class="input-box col-md-4">
                                    <span class="details">No. of Sacks</span>
                                    <input type="number" class="form-control light-gray-placeholder no_ofsacks" 
                                        name="no_ofsacks_${cropCounter}" id="noOfSacksInput_${cropCounter}" 
                                        placeholder="Enter no of sacks" value="{{ old('no_ofsacks') }}" 
                                        oninput="calculateTotalFertilizerCost(${cropCounter})">
                                </div>

                                <div class="input-box col-md-4">
                                    <span class="details">Unit Price per Sack (PHP)</span>
                                    <input type="number" class="form-control light-gray-placeholder unitprice_per_sacks" 
                                        name="unit_${cropCounter}" id="unitPricePerSackInput_${cropCounter}" 
                                        placeholder="Enter unit price per sack" value="{{ old('unitprice_per_sacks') }}" 
                                        oninput="calculateTotalFertilizerCost(${cropCounter})">
                                </div>

                                <div class="input-box col-md-4">
                                    <span class="details">Total Cost of Fertilizers (PHP)</span>
                                    <input type="number" class="form-control light-gray-placeholder total_cost_fertilizers" 
                                        name="total_cost_fertilizers_${cropCounter}" id="totalFertilizerCostInput_${cropCounter}" 
                                        placeholder="Enter total cost" value="{{ old('total_cost_fertilizers') }}" readonly>
                                </div>



                      </div>
                      <br>
                        <h3>d. Pesticides</h3><br>
              
                        <div class="user-details">
              
                         <div class="input-box col-md-4">
                            <span class="details">Pesticides Name</span>
                            <div class="d-flex align-items-center">
                                <select class="form-control custom-select light-gray-placeholder pesticides_name @error('pesticides_name') is-invalid @enderror" 
                                        name="pesticides_name_${cropCounter}" 
                                        id="selectPesticideName_${cropCounter}" 
                                        onchange="checkPesticideName(${cropCounter})" 
                                        aria-label="Floating label select e">
                                    <option value="">Select</option>
                                    <option value="Glyphosate" {{ old('pesticides_name_${cropCounter}') == 'Glyphosate' ? 'selected' : '' }}>Glyphosate</option>
                                    <option value="Malathion" {{ old('pesticides_name_${cropCounter}') == 'Malathion' ? 'selected' : '' }}>Malathion</option>
                                    <option value="Diazinon" {{ old('pesticides_name_${cropCounter}') == 'Diazinon' ? 'selected' : '' }}>Diazinon</option>
                                    <option value="Chlorpyrifos" {{ old('pesticides_name_${cropCounter}') == 'Chlorpyrifos' ? 'selected' : '' }}>Chlorpyrifos</option>
                                    <option value="Lambda-cyhalothrin" {{ old('pesticides_name_${cropCounter}') == 'Lambda-cyhalothrin' ? 'selected' : '' }}>Lambda-cyhalothrin</option>
                                    <option value="Imidacloprid" {{ old('pesticides_name_${cropCounter}') == 'Imidacloprid' ? 'selected' : '' }}>Imidacloprid</option>
                                    <option value="Cypermethrin" {{ old('pesticides_name_${cropCounter}') == 'Cypermethrin' ? 'selected' : '' }}>Cypermethrin</option>
                                    <option value="N/A" {{ old('pesticides_name_${cropCounter}') == 'N/A' ? 'selected' : '' }}>N/A</option>
                                    <option value="OtherPestName" {{ old('pesticides_name_${cropCounter}') == 'OtherPestName' ? 'selected' : '' }}>Others</option>
                                </select>
                                <button type="button" id="removePesticideNameButton_${cropCounter}" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePesticideName(${cropCounter})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>

              
                       <div class="input-box col-md-4">
                                <span class="details">Number of L or kg</span>
                                <input type="number" class="form-control light-gray-placeholder no_of_l_kg" 
                                    name="no_of_l_kg_${cropCounter}" id="noOfLKgInput_${cropCounter}" 
                                    placeholder="Enter no of L or Kg" value="{{ old('no_of_l_kg') }}" 
                                    oninput="calculateTotalPesticideCost(${cropCounter})">
                            </div>

                            <div class="input-box col-md-4">
                                <span class="details">Unit Price of Pesticides (PHP)</span>
                                <input type="number" class="form-control light-gray-placeholder unitprice_ofpesticides" 
                                    name="unitprice_ofpesticides_${cropCounter}" id="unitPriceOfPesticidesInput_${cropCounter}" 
                                    placeholder="Enter unit price of pesticides" value="{{ old('unitprice_ofpesticides') }}" 
                                    oninput="calculateTotalPesticideCost(${cropCounter})">
                            </div>

                            <div class="input-box col-md-4">
                                <span class="details">Total Cost of Pesticides (PHP)</span>
                                <input type="number" class="form-control light-gray-placeholder total_cost_pesticides" 
                                    name="total_cost_pesticides_${cropCounter}" id="totalCostPesticidesInput_${cropCounter}" 
                                    placeholder="Enter total cost" value="{{ old('total_cost_pesticides') }}" readonly>
                            </div>

                  </div>
              
                  <h3>e. Transport & Variable Cost Total</h3><br>
              
                  <div class="user-details">
                  <div class="input-box col-md-4" >
                    <span class="details">Name of Vehicle</span>
                    <input type="text"class="form-control light-gray-placeholder type_of_vehicle" name="type_of_vehicle_${cropCounter}" id="unitPriceInput" placeholder="Enter type of vehicle" value="{{ old('type_of_vehicle') }}" onkeypress="return blockSymbolsAndNumbers(event)">
                  
                  </div>
              
                <div class="input-box col-md-4">
                        <span class="details">Total Delivery Cost (PHP)</span>
                        <input type="number" class="form-control light-gray-placeholder Total_DeliveryCost" 
                            name="total_transport_per_deliverycost_${cropCounter}" id="totalDeliveryCostInput_${cropCounter}" 
                            placeholder="Enter total transport cost" value="{{ old('total_transport_per_deliverycost') }}" 
                            oninput="calculateTotalVariableCost(${cropCounter})">
                    </div>

                    <div class="input-box col-md-4">
                        <span class="details">Total Machineries Fuel Cost</span>
                        <input type="number" class="form-control light-gray-placeholder total_machinery_fuel_cost" 
                            name="total_machinery_fuel_cost_${cropCounter}" id="totalMachineryFuelCostInput_${cropCounter}" 
                            placeholder="Enter total fuel cost" value="{{ old('total_machinery_fuel_cost') }}" 
                            oninput="calculateTotalVariableCost(${cropCounter})">
                    </div>

                    <div class="input-box col-md-4">
                        <span class="details">Total Variable Cost</span>
                        <input type="number" class="form-control light-gray-placeholder total_variable_costs" 
                            name="total_variable_cost_${cropCounter}" id="totalVariableCostInput_${cropCounter}" 
                            placeholder="Enter total variable cost" value="{{ old('total_variable_cost') }}" readonly>
                    </div>
              </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

       

                // Append the new crop section
                $('#cropsContainer').append(cropHtml);



            
// Initialize crop names for the new crop section
fetchCropNames();
// Initial call to add listeners for the first section

// Event listener for crop name changes
$('#cropsContainer').on('change', '.crop_name', function() {
    const cropId = $(this).val();
    fetchCropVarieties(cropId, this);
});

        // Append the new crop HTML to the cropProfiles container
        document.getElementById('cropProfiles').insertAdjacentHTML('beforeend', cropHtml);

         // Initialize flatpickr for the new datepicker input
         flatpickr(`#datepicker_${cropCounter}`, {
                    dateFormat: "Y-m-d",
                });
    });


    // Function to remove a crop section and track available numbers
    window.removeCrop = function(cropId) {
        const cropElement = document.getElementById(`crop_${cropId}`);
        if (cropElement) {
            cropElement.remove();
            // Track the removed number for reuse
            availableNumbers.push(cropId);
            availableNumbers.sort((a, b) => a - b); // Optional: keep the array sorted
        }
    }


});
submitButton.addEventListener('click', function() {
        // Scroll to the Add Crop button
        addCropButton.scrollIntoView({ behavior: 'smooth' });
        openModal();
    });
function calculateTotalAmount(cropCounter) {
    const noOfHa = parseFloat(document.getElementById(`no_of_ha_${cropCounter}`).value) || 0;
    const costPerHa = parseFloat(document.getElementById(`cost_per_ha_${cropCounter}`).value) || 0;
    const totalAmountField = document.getElementById(`total_amount_${cropCounter}`);

    // Calculate total amount
    const totalAmount = noOfHa * costPerHa;

    // Update the total amount field
    totalAmountField.value = totalAmount.toFixed(2); // Format to 2 decimal places}
}

function calculateTotalPlowingCost(cropCounter) {
    const noOfPlowing = parseFloat(document.getElementById(`noPlowing_${cropCounter}`).value) || 0;
    const costPerPlowing = parseFloat(document.getElementById(`plowingperCostInput_${cropCounter}`).value) || 0;
    const totalPlowingCostField = document.getElementById(`plowingCostInput_${cropCounter}`);

    // Calculate total plowing cost
    const totalPlowingCost = noOfPlowing * costPerPlowing;

    // Update the total plowing cost field
    totalPlowingCostField.value = totalPlowingCost.toFixed(2); // Format to 2 decimal places
}

function calculateTotalHarrowingCost(cropCounter) {
    const noOfHarrowing = parseFloat(document.getElementById(`noHarrowing_${cropCounter}`).value) || 0;
    const costPerHarrowing = parseFloat(document.getElementById(`costPerHarrowingInput_${cropCounter}`).value) || 0;
    const totalHarrowingCostField = document.getElementById(`harrowingCostInput_${cropCounter}`);

    // Calculate total harrowing cost
    const totalHarrowingCost = noOfHarrowing * costPerHarrowing;

    // Update the total harrowing cost field
    totalHarrowingCostField.value = totalHarrowingCost.toFixed(2); // Format to 2 decimal places
}


function calculateTotalHarvestingCost(cropCounter) {
    const noOfHarvesting = parseFloat(document.getElementById(`noHarvesting_${cropCounter}`).value) || 0;
    const costPerHarvesting = parseFloat(document.getElementById(`costPerHarvestingInput_${cropCounter}`).value) || 0;
    const totalHarvestingCostField = document.getElementById(`harvestingCostInput_${cropCounter}`);

    // Calculate total harvesting cost
    const totalHarvestingCost = noOfHarvesting * costPerHarvesting;

    // Update the total harvesting cost field
    totalHarvestingCostField.value = totalHarvestingCost.toFixed(2); // Format to 2 decimal places
}


function calculateTotalMachineryCost(cropCounter) {
    const plowingCost = parseFloat(document.getElementById(`plowingCostInput_${cropCounter}`).value) || 0;
    const harrowingCost = parseFloat(document.getElementById(`harrowingCostInput_${cropCounter}`).value) || 0;
    const harvestingCost = parseFloat(document.getElementById(`harvestingCostInput_${cropCounter}`).value) || 0;
    const postHarvestCost = parseFloat(document.getElementById(`postHarvestCostInput_${cropCounter}`).value) || 0;

    // Calculate total machinery cost
    const totalMachineryCost = plowingCost + harrowingCost + harvestingCost + postHarvestCost;

    // Update the total cost field
    document.getElementById(`totalCostInput_${cropCounter}`).value = totalMachineryCost.toFixed(2); // Format to 2 decimal places
}


function calculateTotalSeedCost(cropCounter) {
    const quantity = parseFloat(document.getElementById(`quantityInput_${cropCounter}`).value) || 0;
    const unitPrice = parseFloat(document.getElementById(`unitPriceInput_${cropCounter}`).value) || 0;

    // Calculate total seed cost
    const totalSeedCost = quantity * unitPrice;

    // Update the total seed cost field
    document.getElementById(`totalSeedCostInput_${cropCounter}`).value = totalSeedCost.toFixed(2); // Format to 2 decimal places
}

function calculateTotalLaborCost(cropCounter) {
    const noOfPerson = parseFloat(document.getElementById(`noOfPersonInput_${cropCounter}`).value) || 0;
    const ratePerPerson = parseFloat(document.getElementById(`ratePerPersonInput_${cropCounter}`).value) || 0;

    // Calculate total labor cost
    const totalLaborCost = noOfPerson * ratePerPerson;

    // Update the total labor cost field
    document.getElementById(`totalLaborCostInput_${cropCounter}`).value = totalLaborCost.toFixed(2); // Format to 2 decimal places
}

function calculateTotalFertilizerCost(cropCounter) {
    const noOfSacks = parseFloat(document.getElementById(`noOfSacksInput_${cropCounter}`).value) || 0;
    const unitPricePerSack = parseFloat(document.getElementById(`unitPricePerSackInput_${cropCounter}`).value) || 0;

    // console.log(`No. of Sacks: ${noOfSacks}, Unit Price per Sack: ${unitPricePerSack}`); // Debugging

    const totalCostFertilizers = noOfSacks * unitPricePerSack;

    document.getElementById(`totalFertilizerCostInput_${cropCounter}`).value = totalCostFertilizers.toFixed(2);
}



function calculateTotalPesticideCost(cropCounter) {
    const noOfLKg = parseFloat(document.getElementById(`noOfLKgInput_${cropCounter}`).value) || 0;
    const unitPriceOfPesticides = parseFloat(document.getElementById(`unitPriceOfPesticidesInput_${cropCounter}`).value) || 0;

    // Calculate the total cost
    const totalPesticideCost = noOfLKg * unitPriceOfPesticides;

    // Update the total cost field
    document.getElementById(`totalCostPesticidesInput_${cropCounter}`).value = totalPesticideCost.toFixed(2); // Format to 2 decimal places
}

function calculateTotalVariableCost(cropCounter) {
    // Get the values from each input field
    const totalSeedCost = parseFloat(document.getElementById(`totalSeedCostInput_${cropCounter}`).value) || 0;
    const totalLaborCost = parseFloat(document.getElementById(`totalLaborCostInput_${cropCounter}`).value) || 0;
    const totalFertilizerCost = parseFloat(document.getElementById(`totalFertilizerCostInput_${cropCounter}`).value) || 0;
    const totalPesticideCost = parseFloat(document.getElementById(`totalCostPesticidesInput_${cropCounter}`).value) || 0;
    const totalDeliveryCost = parseFloat(document.getElementById(`totalDeliveryCostInput_${cropCounter}`).value) || 0;
    const totalMachineryFuelCost = parseFloat(document.getElementById(`totalMachineryFuelCostInput_${cropCounter}`).value) || 0;

    // Calculate total variable cost
    const totalVariableCost = totalSeedCost + totalLaborCost + totalFertilizerCost + totalPesticideCost + totalDeliveryCost + totalMachineryFuelCost;

    // Update the total variable cost input field
    document.getElementById(`totalVariableCostInput_${cropCounter}`).value = totalVariableCost.toFixed(2); // Format to 2 decimal places
}

// Track available sale numbers for each crop
let saleCounter = 0;
let saleAvailableNumbersMap = [];
let saleCounterMap = [{}];

// Function to add a sale
function addSale(cropCounter) {
    // Initialize available numbers and sale counter if not present for this crop
    if (!saleAvailableNumbersMap[cropCounter]) {
        saleAvailableNumbersMap[cropCounter] = [];
        saleCounterMap[cropCounter] = 0;
    }

    let saleCounter;

    // Check if there are available numbers to reuse
    if (saleAvailableNumbersMap[cropCounter].length > 0) {
        saleCounter = saleAvailableNumbersMap[cropCounter].shift();
    } else {
        saleCounter = saleCounterMap[cropCounter]++;
    }

    // Add sale entry dynamically
    const salesSection = document.getElementById(`salesSection_${cropCounter}`);
    const newSaleEntry = `
        <div class="user-details sale-entry" id="saleEntry_${cropCounter}_${saleCounter}">
            <div class="input-box col-md-3">
                <label for="sold_to_${cropCounter}_${saleCounter}">Sold To:</label>
                <input type="text" class="form-control light-gray-placeholder sold_to" name="crop_profiles[${cropCounter}][sales][${saleCounter}][sold_to]" id="sold_to_${cropCounter}_${saleCounter}" placeholder="Enter sold to">
            </div>
            <div class="input-box col-md-3">
                <label for="measurement_${cropCounter}_${saleCounter}">Measurement/unit:</label>
                <select class="form-control measurement" name="crop_profiles[${cropCounter}][sales][${saleCounter}][measurement]" id="measurement_${cropCounter}_${saleCounter}" onchange="convertMeasurement(${cropCounter}, ${saleCounter})">
                    <option value="kg">kg</option>
                    <option value="tons">tons</option>
                </select>
            </div>
            <div class="input-box col-md-3">
                <label for="unit_price_per_kg_${cropCounter}_${saleCounter}">Unit Price/kg:</label>
                <input type="number" class="form-control light-gray-placeholder unit_price_sold" name="crop_profiles[${cropCounter}][sales][${saleCounter}][unit_price]" id="unit_price_per_kg_${cropCounter}_${saleCounter}" placeholder="Enter unit price" oninput="calculateGrossIncome(${cropCounter}, ${saleCounter})" onkeypress="return isNumberKey(event)">
            </div>
            <div class="input-box col-md-3">
                <label for="quantity_${cropCounter}_${saleCounter}">Quantity:</label>
                <input type="number" class="form-control light-gray-placeholder quantity" name="crop_profiles[${cropCounter}][sales][${saleCounter}][quantity]" id="quantity_${cropCounter}_${saleCounter}" placeholder="Enter quantity" oninput="calculateGrossIncome(${cropCounter}, ${saleCounter})" onkeypress="return isNumberKey(event)">
            </div>
            <div class="input-box col-md-3">
                <label for="gross_income_${cropCounter}_${saleCounter}">Gross Income:</label>
                <input type="number" class="form-control light-gray-placeholder gross_income" name="crop_profiles[${cropCounter}][sales][${saleCounter}][gross_income]" id="gross_income_${cropCounter}_${saleCounter}" placeholder="Gross income" readonly>
            </div>
            <div class="remove-button-container">
                <button type="button" class="btn btn-danger remove-sale-btn" onclick="removeSale(${cropCounter}, ${saleCounter})">Remove Sale</button>
            </div>
        </div>
    `;

    salesSection.insertAdjacentHTML('beforeend', newSaleEntry);
    updateRemoveButtonVisibility(cropCounter);
}

// Function to convert measurement and update quantity
function convertMeasurement(cropCounter, saleCounter) {
    const measurement = document.getElementById(`measurement_${cropCounter}_${saleCounter}`).value;
    const quantityField = document.getElementById(`quantity_${cropCounter}_${saleCounter}`);
    let quantity = parseFloat(quantityField.value) || 0;

    // Convert tons to kilograms if the selected unit is tons
    if (measurement === 'tons') {
        quantityField.value = (quantity * 1000).toFixed(2); // Convert tons to kg
    } else if (measurement === 'kg') {
        quantityField.value = quantity.toFixed(2); // Keep the value as is
    }

    // Recalculate gross income after conversion
    calculateGrossIncome(cropCounter, saleCounter);
}

// Function to remove a sale
function removeSale(cropCounter, saleCounter) {
    const saleEntry = document.getElementById(`saleEntry_${cropCounter}_${saleCounter}`);
    if (saleEntry) {
        saleEntry.remove();

        // Add the sale number back to available numbers for this crop
        saleAvailableNumbersMap[cropCounter].push(saleCounter);

        // Update visibility of remove buttons
        updateRemoveButtonVisibility(cropCounter);
    }
}

// Update visibility of the remove sale button
function updateRemoveButtonVisibility(cropCounter) {
    const salesSection = document.getElementById(`salesSection_${cropCounter}`);
    const saleEntries = salesSection.querySelectorAll('.sale-entry');

    saleEntries.forEach(entry => {
        if (saleEntries.length <= 1) {
            entry.querySelector('.remove-sale-btn').classList.add('hidden');
        } else {
            entry.querySelector('.remove-sale-btn').classList.remove('hidden');
        }
    });
}

// Function to calculate gross income based on unit price and quantity
function calculateGrossIncome(cropCounter, saleCounter) {
    const unitPrice = parseFloat(document.getElementById(`unit_price_per_kg_${cropCounter}_${saleCounter}`).value) || 0;
    const quantity = parseFloat(document.getElementById(`quantity_${cropCounter}_${saleCounter}`).value) || 0;
    
    const grossIncomeField = document.getElementById(`gross_income_${cropCounter}_${saleCounter}`);
    const grossIncome = unitPrice * quantity;

    grossIncomeField.value = isNaN(grossIncome) ? '' : grossIncome.toFixed(2);
}

// Function to allow only numbers and a decimal point
function isNumberKey(evt) {
    const charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 46) {
        return false; // Allow only numbers and decimal point
    }
    return true;
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
  
    // Gather farmer info from the form inputs
    let farmerInfo = {
        'users_id': $('input.users_id').val(),
        'first_name': $('input.first_name').val(),
        'middle_name': $('input.middle_name').val(),
        'last_name': $('input.last_name').val(),
        'extension_name': $('select.extension_name').val(),
        'country': $('input.country').val(),
        'province': $('input.province').val(),
        'city': $('input.city').val(),
        'agri_district': $('select.agri_district').val(),
        'barangay': $('select.barangay').val(),
        'street': $('input.street').val(),
        'zip_code': $('select.zip_code').val(),
        'contact_no': $('input.contact_no').val(),
        'sex': $('select.sex').val(),
        'religion': $('select.religion').val(),
        'date_of_birth': $('input.date_of_birth').val(),
        'place_of_birth': $('select.place_of_birth').val(),
        'civil_status': $('select.civil_status').val(),
        'name_legal_spouse': $('input.name_legal_spouse').val(),
        'no_of_children': $('select.no_of_children').val(),
        'mothers_maiden_name': $('input.mothers_maiden_name').val(),
        'highest_formal_education': $('select.highest_formal_education').val(),
        // 'add_formEduc': $('select.add_formEduc').val(),
        'person_with_disability': $('select.person_with_disability').val(),
        'YEspwd_id_no': $('input.YEspwd_id_no').val(),
        'Nopwd_id_no': $('select.Nopwd_id_no').val(),
        'government_issued_id': $('select.government_issued_id').val(),
        'id_type': $('select.id_type').val(),
        'add_Idtype': $('input.add_Idtype').val(),
        'non_gov_id_types': $('input.non_gov_id_types').val(),
        'member_ofany_farmers': $('select.member_ofany_farmers').val(),
        'nameof_farmers': $('select.nameof_farmers').val(),
        'NoFarmersGroup': $('select.NoFarmersGroup').val(),
        'add_FarmersGroup': $('input.add_FarmersGroup').val(),
        'name_contact_person': $('input.name_contact_person').val(),
        'cp_tel_no': $('input.cp_tel_no').val(),
        'date_of_interviewed': $('input.date_of_interviewed').val(),
    };

    // Gather farm info from the form inputs
    let farmInfo = {

    'personal_info': $('input.personalinfo_id').val(),
    'user_id': $('input.users_id').val(),
    'tenurial_status': $('select.tenurial_status').val(),
    'farm_address': $('input.farm_address').val(),
    'no_of_years_as_farmers': $('input.no_of_years_as_farmers').val(),
    'gps_longitude': $('input.gps_longitude').val(),
    'gps_latitude': $('input.gps_latitude').val(),
    'total_physical_area_has': $('input.total_physical_area_has').val(),
    'Total_area_cultivated_has': $('input.Total_area_cultivated_has').val(),
    'land_title_no': $('input.land_title_no').val(),
    'lot_no': $('input.lot_no').val(),
    'area_prone_to': $('select.area_prone_to').val(),
    'ecosystem': $('select.ecosystem').val(),
    'rsba_register': $('select.rsba_register').val(),
    'pcic_insured': $('select.pcic_insured').val(),
    'government_assisted': $('select.government_assisted').val(),
    'source_of_capital': $('select.source_of_capital').val(),
    'remarks': $('input.remarks').val(),
    'oca_district_office': $('input.oca_district_office').val(),
    'name_technicians': $('input.name_technicians').val(),
    'date_interview': $('input.date_interview').val(),
};


    // Gather crop info from the form inputs
    


    const cropSections = document.querySelectorAll('#cropProfiles .crop-section','#salesSection .sale-entry');
        
        // Initialize an array to store crop data
        let cropInfo = [];
        
        cropSections.forEach(section => {
    // Extract the crop number from the section's ID
    let cropId = section.id.split('_')[1]; 

    // Function to safely get element value
    const getValue = (selector) => {
        const element = section.querySelector(selector);
        return element ? element.value : null;
    };

    let cropName = getValue('.crop_name');
    let cropVariety = getValue('.crop_variety');
    let PreferredVariety = getValue('.preferred_variety');
    let drySeason = getValue('.dry_season');
    let wetSeason = getValue('.wet_season');
    let noCroppingYear = getValue('.no_crop_year');
    let YieldkgHa = getValue('.yield_kg_ha');

    // Production
    let seedType = getValue('.seed-type');
    let seedUsed = getValue('.seed-used');
    let seedSource = getValue('.seed-source');
    let Unit = getValue('.unit');
    let fertilizedUsed = getValue('.fertilized-used');
    let pesticidesUsed = getValue('.pesticides-used');
    let insecticidesUsed = getValue('.insecticides-used');
    let areaplanted = getValue('.area-planted');
    let Dateplanted = getValue('.date-planted');
    let Dateharvested= getValue('.date-harvested');
    let Yieldkg = getValue('.yield-kg');

    // Fixed cost
    let particular = getValue('.particular');
    let no_of_Has = getValue('.no-has');
    let costPer_has = getValue('.cost-has');
    let TotalFixed = getValue('.total-amount');

    // Machineries
    let PlowingMachine = getValue('.plowing-machine');
    let plow_status = getValue('.plow_status');
    let no_of_plowing = getValue('.no_of_plowing');
    let cost_per_plowing = getValue('.cost_per_plowing');
    let plowing_cost = getValue('.plowing_cost');
    let harro_machine = getValue('.harro_machine');
    let harro_ownership_status = getValue('.harro_ownership_status');
    let no_of_harrowing = getValue('.no_of_harrowing');
    let cost_per_harrowing = getValue('.cost_per_harrowing');
    let harrowing_cost_total = getValue('.harrowing_cost_total');
    let harvest_machine = getValue('.harvest_machine');
    let harvest_ownership_status = getValue('.harvest_ownership_status');
    let no_of_Harvesting = getValue('.no_of_Harvesting');
    let cost_per_Harvesting = getValue('.cost_per_Harvesting');
    let Harvesting_cost_total = getValue('.Harvesting_cost_total');
    let postharv_ownership_status = getValue('.postharv_ownership_status');
    let postharves_machine = getValue('.postharves_machine');
    let postharvestCost = getValue('.postharvestCost');
    let total_cost_for_machineries = getValue('.total_cost_for_machineries');

    // Variables cost
    let var_seed_variety = getValue('.seed_name');
    let seed_name = getValue('.seed_name');
    let unit = getValue('.unit');
    let quantity = getValue('.quantity');
    let unit_price_seed = getValue('.unit_price_seed');
    let total_seed_cost = getValue('.total_seed_cost');
    let no_of_person = getValue('.no_of_person');
    let rate_per_person = getValue('.rate_per_person');
    let total_labor_cost = getValue('.total_labor_cost');
    let name_of_fertilizer = getValue('.name_of_fertilizer');
    let no_ofsacks = getValue('.no_ofsacks');
    let unitprice_per_sacks = getValue('.unitprice_per_sacks');
    let total_cost_fertilizers = getValue('.total_cost_fertilizers');
    let pesticides_name = getValue('.pesticides_name');
    let no_of_l_kg = getValue('.no_of_l_kg');
    let unitprice_ofpesticides = getValue('.unitprice_ofpesticides');
    let total_cost_pesticides = getValue('.total_cost_pesticides');
    let type_of_vehicle = getValue('.type_of_vehicle');
    let Total_DeliveryCost = getValue('.Total_DeliveryCost');
    let total_machinery_fuel_cost = getValue('.total_machinery_fuel_cost');
    let total_variable_costs = getValue('.total_variable_costs');

    // Check if any field has value to avoid empty entries
    let salesData = [];

    let saleEntries = section.querySelectorAll('.sale-entry');
    saleEntries.forEach((entry) => {
        let saleId = entry.id.split('_')[2]; // Adjust based on your ID format

        let soldTo = getValue('.sold_to');
        let measurement = getValue('.measurement');
        let unit_price_sold = getValue('.unit_price_sold');
        let grossIncometotal = getValue('.gross_income');
        
        // Store sale data
        salesData.push({
            saleId: saleId,
            soldTo: soldTo,
            measurement: measurement,
            unit_price: unit_price_sold,
            quantity: quantity,
            grossIncome: grossIncometotal
        });
    });

    cropInfo.push({
        id: cropId,
        crop_name: cropName,
        variety: {
            type_variety: cropVariety,
            preferred: PreferredVariety,
            wet_season: wetSeason,
            dry_season: drySeason,
            no_cropping_year: noCroppingYear,
            yield_kg_ha: YieldkgHa
        },
        production: {
            seedtype: seedType,
            seedUsed: seedUsed,
            seedSource: seedSource,
            unit: Unit,
            fertilizedUsed: fertilizedUsed,
            pesticidesUsed: pesticidesUsed,
            insecticide: insecticidesUsed,
            areaPlanted: areaplanted,
            datePlanted: Dateplanted,
            Dateharvested:Dateharvested,
            yieldkg: Yieldkg
        },
        sales: salesData,
        fixedCost: {
            particular: particular,
            no_of_has: no_of_Has,
            costperHas: costPer_has,
            TotalFixed: TotalFixed
        },
        machineries: {
            PlowingMachine: PlowingMachine,
            plow_status: plow_status,
            no_of_plowing: no_of_plowing,
            cost_per_plowing: cost_per_plowing,
            plowing_cost: plowing_cost,
            harro_machine: harro_machine,
            harro_ownership_status: harro_ownership_status,
            no_of_harrowing: no_of_harrowing,
            cost_per_harrowing: cost_per_harrowing,
            harrowing_cost_total: harrowing_cost_total,
            harvest_machine: harvest_machine,
            harvest_ownership_status: harvest_ownership_status,
            no_of_Harvesting: no_of_Harvesting,
            cost_per_Harvesting: cost_per_Harvesting,
            Harvesting_cost_total: Harvesting_cost_total,
            postharv_ownership_status: postharv_ownership_status,
            postharves_machine: postharves_machine,
            postharvestCost: postharvestCost,
            total_cost_for_machineries: total_cost_for_machineries
        },
        variables: {
            seed_name: seed_name,
            unit: unit,
            quantity: quantity,
            unit_price_seed: unit_price_seed,
            total_seed_cost: total_seed_cost,
            no_of_person: no_of_person,
            rate_per_person: rate_per_person,
            total_labor_cost: total_labor_cost,
            name_of_fertilizer: name_of_fertilizer,
            no_ofsacks: no_ofsacks,
            unitprice_per_sacks: unitprice_per_sacks,
            total_cost_fertilizers: total_cost_fertilizers,
            pesticides_name: pesticides_name,
            no_of_l_kg: no_of_l_kg,
            unitprice_ofpesticides: unitprice_ofpesticides,
            total_cost_pesticides: total_cost_pesticides,
            type_of_vehicle: type_of_vehicle,
            Total_DeliveryCost: Total_DeliveryCost,
            total_machinery_fuel_cost: total_machinery_fuel_cost,
            total_variable_costs: total_variable_costs
        }
    });
});

console.log(cropInfo);


     
//   // Create the final data object
let dataobject = {
    // 'farmer': farmerInfo, 
    'farm': farmInfo,
    'crops': cropInfo,
};

// Log the entire data object to the console for debugging
// console.log("Data Object:", dataobject);

// const csrfToken = $('input[name="_token"]').attr('value');

//     // Send the AJAX request
//     $.ajax({
//         url: '/agent-add-farmer-crops/{farmData}',
//         method: 'POST',
//         contentType: 'application/json', // Set content type for JSON
//         data: JSON.stringify(dataobject), // Attach the prepared data here
//         headers: {
//             'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
//         },
//         success: function(response) {

//             console.log(response);

//             if(response.success) {
//                 console.log(response);
//                 console.log(response.success);
//             }
//         },
//         error: function(error) {
//             console.error('Error:', error.responseJSON.message);
//         }
//     }); 

function openConfirmModal(data) {
    // Check if there are any crops added
    const cropSections = document.querySelectorAll('.crop-section'); // Adjust this selector

    if (cropSections.length > 0) {
        // Clear previous crop info from the modal
        $('#cropAccordionBody').empty();

        // Populate the modal with the farmer's details
        $('#farmTenurialStatus').text(data.farm?.tenurial_status || 'N/A');
        $('#farmAddress').text(data.farm?.farm_address || 'N/A');
        $('#farmYearsAsFarmer').text(data.farm?.no_of_years_as_farmers || 'N/A');
        $('#farmGpsLongitude').text(data.farm?.gps_longitude || 'N/A');
        $('#farmGpsLatitude').text(data.farm?.gps_latitude || 'N/A');
        $('#farmTotalPhysicalArea').text(data.farm?.total_physical_area_has || 'N/A');
        $('#farmTotalAreaCultivated').text(data.farm?.total_area_cultivated_has || 'N/A');
        $('#farmLandTitleNo').text(data.farm?.land_title_no || 'N/A');
        $('#farmLotNo').text(data.farm?.lot_no || 'N/A');
        $('#farmAreaProneTo').text(data.farm?.area_prone_to || 'N/A');
        $('#farmEcosystem').text(data.farm?.ecosystem || 'N/A');
        $('#farmRsbaRegister').text(data.farm?.rsba_register || 'N/A');
        $('#farmPcicInsured').text(data.farm?.pcic_insured || 'N/A');
        $('#farmGovernmentAssisted').text(data.farm?.government_assisted || 'N/A');
        $('#farmSourceOfCapital').text(data.farm?.source_of_capital || 'N/A');
        $('#farmRemarks').text(data.farm?.remarks || 'N/A');
        $('#farmOcaDistrictOffice').text(data.farm?.oca_district_office || 'N/A');
        $('#farmNameTechnicians').text(data.farm?.name_technicians || 'N/A');
        $('#farmDateInterview').text(data.farm?.date_interview || 'N/A');

        // Loop through the crops and populate individual crop details in list format
        data.crops.forEach(function(crop, index) {
            let cropHtml = `
                <div class="crop-info">
                    <h3>Crop ${index + 1}</h3><br>
                    <div class="detail-grid">
                        <div class="detail-row">
                            <h4>Crop Information:</h4><br>
                            <ul class="list-unstyled">
                                <li><strong>Crop Name:</strong> <span>${crop.crop_name || 'N/A'}</span></li>
                                <li><strong>Crop Variety:</strong> <span>${crop.variety.type_variety || 'N/A'}</span></li>
                                <li><strong>Preferred Variety:</strong> <span>${crop.variety.preferred || 'N/A'}</span></li>
                                <li><strong>Wet Season:</strong> <span>${crop.variety.wet_season || 'N/A'}</span></li>
                                <li><strong>Dry Season:</strong> <span>${crop.variety.dry_season || 'N/A'}</span></li>
                                <li><strong>Number of Cropping Years:</strong> <span>${crop.variety.no_cropping_year || 'N/A'}</span></li>
                                <li><strong>Yield (kg/ha):</strong> <span>${crop.variety.yield_kg_ha || 'N/A'}</span></li>
                            </ul>
                        </div>
                        <div class="detail-row">
                            <h4>Production Details:</h4>
                            <ul class="list-unstyled">
                                <li><strong>Seed Type:</strong> <span>${crop.production.seedtype || 'N/A'}</span></li>
                                <li><strong>Seed Used:</strong> <span>${crop.production.seedUsed || 'N/A'}</span></li>
                                <li><strong>Seed Source:</strong> <span>${crop.production.seedSource || 'N/A'}</span></li>
                                <li><strong>Unit:</strong> <span>${crop.production.unit || 'N/A'}</span></li>
                                <li><strong>Fertilizer Used:</strong> <span>${crop.production.fertilizedUsed || 'N/A'}</span></li>
                                <li><strong>Pesticides Used:</strong> <span>${crop.production.pesticidesUsed || 'N/A'}</span></li>
                                <li><strong>Insecticides Used:</strong> <span>${crop.production.insecticide || 'N/A'}</span></li>
                                <li><strong>Area Planted:</strong> <span>${crop.production.areaPlanted || 'N/A'}</span></li>
                                <li><strong>Date Planted:</strong> <span>${crop.production.datePlanted || 'N/A'}</span></li>
                                <li><strong>Date Harvested:</strong> <span>${crop.production.Dateharvested || 'N/A'}</span></li>
                                <li><strong>Yield (kg):</strong> <span>${crop.production.yieldkg || 'N/A'}</span></li>
                            </ul>
                        </div>
                        <div class="detail-row">
                            <h4>Fixed Costs:</h4>
                            <ul class="list-unstyled">
                                <li><strong>Particular:</strong> <span>${crop.fixedCost.particular || 'N/A'}</span></li>
                                <li><strong>Number of Hectares:</strong> <span>${crop.fixedCost.no_of_has || 'N/A'}</span></li>
                                <li><strong>Cost per Hectare:</strong> <span>${crop.fixedCost.costperHas || 'N/A'}</span></li>
                                <li><strong>Total Fixed Cost:</strong> <span>${crop.fixedCost.TotalFixed || 'N/A'}</span></li>
                            </ul>
                        </div>
                        <div class="detail-row">
                            <h4>Machineries:</h4>
                            <ul class="list-unstyled">
                                <li><strong>Plowing Machine:</strong> <span>${crop.machineries.PlowingMachine || 'N/A'}</span></li>
                                <li><strong>Plow Status:</strong> <span>${crop.machineries.plow_status || 'N/A'}</span></li>
                                <li><strong>Number of Plowing:</strong> <span>${crop.machineries.no_of_plowing || 'N/A'}</span></li>
                                <li><strong>Cost per Plowing:</strong> <span>${crop.machineries.cost_per_plowing || 'N/A'}</span></li>
                                <li><strong>Plowing Cost:</strong> <span>${crop.machineries.plowing_cost || 'N/A'}</span></li>
                                <li><strong>Harrow Machine:</strong> <span>${crop.machineries.harro_machine || 'N/A'}</span></li>
                                <li><strong>Harrow Ownership Status:</strong> <span>${crop.machineries.harro_ownership_status || 'N/A'}</span></li>
                                <li><strong>Number of Harrowing:</strong> <span>${crop.machineries.no_of_harrowing || 'N/A'}</span></li>
                                <li><strong>Cost per Harrowing:</strong> <span>${crop.machineries.cost_per_harrowing || 'N/A'}</span></li>
                                <li><strong>Harrowing Cost Total:</strong> <span>${crop.machineries.harrowing_cost_total || 'N/A'}</span></li>
                                <li><strong>Harvest Machine:</strong> <span>${crop.machineries.harvest_machine || 'N/A'}</span></li>
                                <li><strong>Harvest Ownership Status:</strong> <span>${crop.machineries.harvest_ownership_status || 'N/A'}</span></li>
                                <li><strong>Number of Harvesting:</strong> <span>${crop.machineries.no_of_Harvesting || 'N/A'}</span></li>
                                <li><strong>Cost per Harvesting:</strong> <span>${crop.machineries.cost_per_Harvesting || 'N/A'}</span></li>
                                <li><strong>Harvesting Cost Total:</strong> <span>${crop.machineries.Harvesting_cost_total || 'N/A'}</span></li>
                                <li><strong>Postharvest Machine:</strong> <span>${crop.machineries.postharves_machine || 'N/A'}</span></li>
                                <li><strong>Postharvest Ownership Status:</strong> <span>${crop.machineries.postharvestCost || 'N/A'}</span></li>
                                <li><strong>Postharvest Cost:</strong> <span>${crop.machineries.total_cost_for_machineries || 'N/A'}</span></li>
                            </ul>
                        </div>
                        <div class="detail-row">
                            <h4>Variable Costs:</h4>
                            <ul class="list-unstyled">
                                <li><strong>Seed Name:</strong> <span>${crop.variables.seed_name || 'N/A'}</span></li>
                                        <li><strong>Unit:</strong> <span>${crop.variables.unit || 'N/A'}</span></li>
                                        <li><strong>Quantity:</strong> <span>${crop.variables.quantity || 'N/A'}</span></li>
                                        <li><strong>Unit Price Seed:</strong> <span>${crop.variables.unit_price_seed || 'N/A'}</span></li>
                                        <li><strong>Total Seed Cost:</strong> <span>${crop.variables.total_seed_cost || 'N/A'}</span></li>
                                        <li><strong>Number of Persons:</strong> <span>${crop.variables.no_of_person || 'N/A'}</span></li>
                                        <li><strong>Rate per Person:</strong> <span>${crop.variables.rate_per_person || 'N/A'}</span></li>
                                        <li><strong>Total Labor Cost:</strong> <span>${crop.variables.total_labor_cost || 'N/A'}</span></li>
                                        <li><strong>Name of Fertilizer:</strong> <span>${crop.variables.name_of_fertilizer || 'N/A'}</span></li>
                                        <li><strong>Number of Sacks:</strong> <span>${crop.variables.no_ofsacks || 'N/A'}</span></li>
                                        <li><strong>Unit Price per Sack:</strong> <span>${crop.variables.unitprice_per_sacks || 'N/A'}</span></li>
                                        <li><strong>Total Cost of Fertilizers:</strong> <span>${crop.variables.total_cost_fertilizers || 'N/A'}</span></li>
                                        <li><strong>Pesticides Name:</strong> <span>${crop.variables.pesticides_name || 'N/A'}</span></li>
                                        <li><strong>Number of Liters/Kgs:</strong> <span>${crop.variables.no_of_l_kg || 'N/A'}</span></li>
                                        <li><strong>Unit Price of Pesticides:</strong> <span>${crop.variables.unitprice_ofpesticides || 'N/A'}</span></li>
                                        <li><strong>Total Cost of Pesticides:</strong> <span>${crop.variables.total_cost_pesticides || 'N/A'}</span></li>
                                    
                                        <li><strong>Type of Vehicle:</strong> <span>${crop.variables.type_of_vehicle || 'N/A'}</span></li>
                                        <li><strong>Total DeliveryCost:</strong> <span>${crop.variables.Total_DeliveryCost || 'N/A'}</span></li>
                                        <li><strong>Total machinery fuel cost:</strong> <span>${crop.variables.total_machinery_fuel_cost || 'N/A'}</span></li>
                                        <li><strong>Total Variable Costs:</strong> <span>${crop.variables.total_variable_costs || 'N/A'}</span></li>
                            </ul>
                        </div>
                    </div>
                    <br>
                </div>
            `;
            // Append the crop info HTML to the modal
            $('#cropAccordionBody').append(cropHtml);
        });

        // Open the modal
        $('#confirmModal').modal('show');
    } else {
        alert("Please add at least one crop before proceeding.");
        location.reload();
        // Optionally, scroll to or focus on the crop addition section
        const cropAddSection = document.querySelector('#cropAddSection'); // Adjust the selector
        if (cropAddSection) {
            cropAddSection.scrollIntoView({ behavior: 'smooth' });
            // You could also add focus or highlight the section
        }
    }
   
}





// Call this function to show the confirmation modal when needed
openConfirmModal(dataobject);

/// Confirm and Save event
/// Confirm and Save event
$('#confirmSave').on('click', function () {
    const csrfToken = $('input[name="_token"]').attr('value');

    // Send the AJAX request
    $.ajax({
        url: '/admin-add-farm/{personalinfos}',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(dataobject), // Attach the prepared data
        headers: {
            'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
        },
        success: function (response) {
            console.log(response);
            if (response.success) {
                // Show success modal
                const successModal = new bootstrap.Modal(document.getElementById('successCropModal'), {
                    keyboard: false,
                });
                successModal.show();

                // Close the confirmation modal
                const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
                if (confirmModal) {
                    confirmModal.hide();
                }

                // Add event listener to reload the page when success modal is closed
                $('#successCropModal').on('hidden.bs.modal', function () {
                    location.reload(); // Reload the page
                });
            }
        },
        error: function (xhr) {
            console.error('Error:', xhr.responseJSON.error);

            // Display the error message in the error modal body
            $('#errorModalBody').text(xhr.responseJSON.error);

            // Show the error modal
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'), {
                keyboard: false,
            });
            errorModal.show();

            // Add event listener to reload the page when error modal is closed
            $('#errorModal').on('hidden.bs.modal', function () {
                location.reload(); // Reload the page
            });
        },
    });
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
var polygons = []; // Array to hold the saved polygons

// Load polygons from mapdata and parceldata and plot them on the map
function loadPolygons() {
    var mapdata = @json($mapdata); // Existing data from the view
    var parceldata = @json($parceldata); // Data from ParcellaryBoundaries

    function plotPolygon(parcel, isParcelData = false) {
        var polygon = new google.maps.Polygon({
            paths: parcel.coordinates.map(coord => new google.maps.LatLng(coord.lat, coord.lng)),
            strokeColor: parcel.strokecolor || '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: parcel.fillcolor || '#FF0000',
            fillOpacity: 0.02
        });
        polygon.setMap(map);
        polygons.push(polygon);

        google.maps.event.addListener(polygon, 'click', function () {
            var contentString;
            if (isParcelData) {
                contentString = 'Parcel Name: ' + parcel.parcel_name + '<br>' +
                                'ARPOwner Name: ' + parcel.arpowner_na + '<br>' +
                                'Agri-District: ' + parcel.agri_districts + '<br>' +
                                'Brgy. Name: ' + parcel.barangay_name + '<br>' +
                                'Title name: ' + parcel.tct_no + '<br>' +
                                'Property kind description: ' + parcel.pkind_desc + '<br>' +
                                'Property Used description: ' + parcel.puse_desc + '<br>' +
                                'Actual Used: ' + parcel.actual_used + '<br>' +
                                'Area: ' + parcel.area + ' sq. meters<br>' +
                                'Altitude: ' + parcel.altitude + ' meters<br>';
            } else {
                contentString = 'Polygon Name: ' + parcel.polygon_name + '<br>' +
                                'Area: ' + parcel.area + ' sq. meters<br>' +
                                'Altitude: ' + parcel.altitude + ' meters';
            }

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            infowindow.setPosition(parcel.coordinates[0]);
            infowindow.open(map);
        });
    }

    mapdata.forEach(function (parcel) {
        plotPolygon(parcel);
    });

    parceldata.forEach(function (parcel) {
        plotPolygon(parcel, true);
    });

    var bounds = new google.maps.LatLngBounds();
    mapdata.concat(parceldata).forEach(function (parcel) {
        parcel.coordinates.forEach(function (coord) {
            bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
        });
    });
    map.fitBounds(bounds);
}

function initMap() {
    var initialLocation = { lat: 6.9214, lng: 122.0790 };

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: initialLocation,
        mapTypeId: 'satellite'
    });

    map.addListener('click', function (event) {
        if (markers.length >= 1) {
            deleteMarkers();
        }

        selectedLatLng = event.latLng;
        addMarker(selectedLatLng);
        $('#modal_latitude').val(selectedLatLng.lat());
        $('#modal_longitude').val(selectedLatLng.lng());
    });

    function addMarker(location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true // Make the marker draggable
        });
        markers.push(marker);

        // Update latitude and longitude on marker drag end
        google.maps.event.addListener(marker, 'dragend', function (event) {
            $('#modal_latitude').val(event.latLng.lat());
            $('#modal_longitude').val(event.latLng.lng());
        });
    }

    function deleteMarkers() {
        markers.forEach(marker => {
            marker.setMap(null);
        });
        markers = [];
    }

    $('#modal_latitude, #modal_longitude').on('change', function () {
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

$(document).ready(function () {
    $('#gps_latitude_0, #gps_longitude_0').on('focus', function () {
        $('#mapModal').modal('show');
    });

    $('#mapModal').on('shown.bs.modal', function () {
        if (selectedLatLng) {
            map.setCenter(selectedLatLng);
        }
        google.maps.event.trigger(map, 'resize');
    });

    $('#mapModal').on('hidden.bs.modal', function () {
        deleteMarkers();
    });

    $('#saveLocation').on('click', function () {
        var lat = $('#modal_latitude').val();
        var lng = $('#modal_longitude').val();
        $('#gps_latitude_0').val(lat);
        $('#gps_longitude_0').val(lng);
        
        $('#mapModal').modal('hide');
    });
    
    loadPolygons(); // Load polygons when the map is initialized
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



$(document).ready(function() {
    // Function to fetch AgriDistricts
    function fetchAgriDistricts() {
        $.ajax({
            url: '/admin-add-farm/{personalinfos}', // Route for fetching AgriDistricts
            method: 'GET',
            data: { type: 'districts' }, // Request districts
            success: function(response) {
                console.log('Received AgriDistricts data:', response);

                if (response.error) {
                    console.error('Error fetching AgriDistricts:', response.error);
                    return;
                }

                if (typeof response === 'object' && Object.keys(response).length > 0) {
                    $('#districtSelect').empty().append('<option value="" disabled selected>Select AgriDistrict</option>');

                    $.each(response, function(id, district) {
                        $('#districtSelect').append(new Option(district, id));
                    });
                } else {
                    console.warn('No AgriDistrict data received or data is empty.');
                }
            },
            error: function(xhr) {
                console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
            }
        });
    }

    // Function to fetch Barangays based on selected AgriDistrict
    function fetchBarangays(districtId, selectElement) {
        $.ajax({
            url: '/admin-add-farm/{personalinfos}',
            method: 'GET',
            data: { type: 'barangays', district: districtId },
            success: function(response) {
                console.log('Received Barangays data:', response);

                if (response.error) {
                    console.error('Error fetching Barangays:', response.error);
                    return;
                }

                const $barangaySelect = $(selectElement).closest('.user-details').find('.barangaySelect');
                $barangaySelect.empty();
                $barangaySelect.append('<option value="" disabled selected>Select Barangay</option>');
                $barangaySelect.append('<option value="add">Add New Barangay...</option>');

                $.each(response, function(id, barangay) {
                    $barangaySelect.append(new Option(barangay, id));
                });
            },
            error: function(xhr) {
                console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
            }
        });
    }

    // Function to fetch Organizations based on selected AgriDistrict
    function fetchOrganizations(districtId, selectElement) {
        $.ajax({
            url: '/admin-add-farm/{personalinfos}',
            method: 'GET',
            data: { type: 'organizations', district: districtId },
            success: function(response) {
                console.log('Received Organizations data:', response);

                if (response.error) {
                    console.error('Error fetching Organizations:', response.error);
                    return;
                }

                const $organizationSelect = $(selectElement).closest('.user-details').find('.organizationSelect');
                $organizationSelect.empty();
                $organizationSelect.append('<option value="" disabled selected>Select Organization</option>');
                $organizationSelect.append('<option value="add">Add New Organization...</option>');

                $.each(response, function(id, organization) {
                    $organizationSelect.append(new Option(organization, id));
                });
            },
            error: function(xhr) {
                console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
            }
        });
    }

    // Fetch AgriDistricts on page load
    fetchAgriDistricts();

    // Bind change event to AgriDistrict dropdown
    $(document).on('change', '#districtSelect', function() {
        const districtId = $(this).val();
        if (districtId) {
            fetchBarangays(districtId, this); // Fetch barangays for the selected district
            fetchOrganizations(districtId, this); // Fetch organizations for the selected district
        } else {
            $(this).closest('.user-details').find('.barangaySelect, .organizationSelect').empty()
                .append('<option value="" disabled selected>Select Barangay</option>')
                .append('<option value="" disabled selected>Select Organization</option>');
        }
    });

    // Bind change event to Barangay dropdowns to add new barangay
    $(document).on('change', '.barangaySelect', function() {
        const barangaySelect = this;
        if (barangaySelect.value === "add") {
            const newBarangay = prompt("Please enter the name of the barangay:");
            if (newBarangay) {
                const existingOption = Array.from(barangaySelect.options).find(option => option.value === newBarangay);
                if (!existingOption) {
                    const newOption = document.createElement("option");
                    newOption.text = newBarangay;
                    newOption.value = newBarangay;
                    barangaySelect.appendChild(newOption);
                    barangaySelect.value = newBarangay;
                }
            }
        }
    });

    // Bind change event to Organization dropdowns to add new organization
    $(document).on('change', '.organizationSelect', function() {
        const organizationSelect = this;
        if (organizationSelect.value === "add") {
            const newOrganization = prompt("Please enter the name of the organization:");
            if (newOrganization) {
                const existingOption = Array.from(organizationSelect.options).find(option => option.value === newOrganization);
                if (!existingOption) {
                    const newOption = document.createElement("option");
                    newOption.text = newOrganization;
                    newOption.value = newOrganization;
                    organizationSelect.appendChild(newOption);
                    organizationSelect.value = newOrganization;
                }
            }
        }
    });
});






  </script>
  


    
    
    
    <script>
        // To show the modal
        $('#successModal').modal('show');
        
        // To close the modal programmatically
        $('#successModal').modal('hide');</script>
    
  <script src="{{ asset('js/farmer.js') }}"></script>
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
    document.getElementById('addCropButton').addEventListener('click', function() {
        var cropProfilesSection = document.getElementById('cropProfiles');
    
        // Scroll to the cropProfiles section
        cropProfilesSection.scrollIntoView({ behavior: 'smooth' });
    
        // Optional: Open the crop section if it's inside an accordion or collapsible
        // Assuming you are using Bootstrap accordion
        var collapseElement = document.getElementById('cropAccordion'); // Update with the actual ID
        if (collapseElement) {
            var bsCollapse = new bootstrap.Collapse(collapseElement, { toggle: true });
        }
    });
    </script>

<script>
    // Example for initializing jQuery UI Datepicker
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd" // Adjust format as needed
        });
    });

    // Example for showing validation errors
    function showDateOfBirthError(message) {
        $("#date_of_birth_error").text(message).show();
    }

    // Example for hiding validation errors
    function hideDateOfBirthError() {
        $("#date_of_birth_error").hide();
    }
</script>

<script>
    function goBack() {
        window.history.back(); // This will go back to the previous page in the browser history
    }
    document.getElementById('addNewOrganization').addEventListener('click', function() {
    // Get values of required fields
    const cropName = document.getElementById(`crop_name_${cropCounter}`).value;
    const cropVariety = document.getElementById(`crop_variety_${cropCounter}`).value;

    // Validate fields
    if (!cropName || cropName === "") {
        alert('Crop Name is required.');
        document.getElementById(`crop_name_${cropCounter}`).scrollIntoView({ behavior: 'smooth' });
        return; // Prevent further action
    }
    
    if (!cropVariety || cropVariety === "") {
        alert('Crop Variety is required.');
        document.getElementById(`crop_variety_${cropCounter}`).scrollIntoView({ behavior: 'smooth' });
        return; // Prevent further action
    }

    // Proceed with saving the organization and adding the crop
    // Your code to save the organization and crop goes here
});


    </script> 
  @endsection
