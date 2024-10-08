@extends('agent.agent_Dashboard')
@section('agent') 


<div class="page-content">

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      
    </ol>
  </nav>
  <div class="progress mb-3">
    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">2 out of 6 Complete Complete</div>
      
             
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">

          @if (session('message'))
          <div class="alert alert-success" role="alert">
            {{ session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <script>
            document.addEventListener('DOMContentLoaded', function () {
                swal({
                    title: "Success!",
                    text: "{{ session('message') }}",
                    icon: "success",
                });
            });
        </script>
          @endif
         
          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      <h4 class="card-titles" style="display: flex;text-align: center; "><span></span>Rice Survey Form Zamboanga City</h4>
      <br>
          <h6 class="card-title"><span>II.</span>Farm Profile</h6>
      <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
       
          <form id="myForm" action{{url('AddFarmProfile')}} method="post"  >
            @csrf
           
              <div class="row mb-3">
                <h2 class="card-title"><span>a.</span>Farm Location and Tenure:</h2>
                <div >

                  <input type="hidden" name="users_id" value="{{ $userId }}">
                 
               
           </div>
                <div>
               
                  <input type="hidden" name="agri_districts_id"  value="{{$agri_districts_id}}">
                     
                   
                
               
                
              </div>
                <div class="col mb-4 mb-md-0">    
         
                  <label class="form-expand" for="personal_informations_id">Farmers Name:</label>
                  <select class="form-control placeholder-text" name="personal_informations_id" aria-label="personal_informations_id">
                        
                    <option value="{{ $profile->id }}">{{ $profile->first_name.' '. $profile->last_name}}</option>
              
            </select>
                </div>
                
                <div class="col-md-3 mb-3">
                  <label class="form-expand" for="agri_districts">Agri-District</label>
                  <select class="form-control @error('agri_districts') is-invalid @enderror" name="agri_districts" id="selectAgri" onchange="checkAgri()" aria-label="Floating label select e">
                      <option value="{{$agri_districts}}" {{$agri_districts == "ayala" ? 'selected' : ''}}>{{$agri_districts}}</option>
                   
                  </select>
               
                  @error('agri_districts')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
             
                {{-- <div class="col-md-3 mb-3">
                  <label class="form-expand" for="rice_farm_address">Rice Farm Address:</label>
                  <input type="text" class="form-control placeholder-text @error('rice_farm_address') is-invalid @enderror" name="rice_farm_address" id="rice_farm_address" placeholder="Enter Rice Farm Address"value="{{ old('rice_farm_address') }}" >
                  @error('rice_farm_address')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div> --}}
                <div class="col-md-3 mb-3" id="barangayInput" style="{{ in_array($agri_districts, ['ayala','vitali', 'culianan', 'tumaga', 'manicahan', 'curuan']) ? 'display: block;' : 'display: none;' }}">
                  <label class="form-expand" for="barangay">Rice Farm Address</label>
                  <select class="form-control placeholder-text @error('rice_farm_address') is-invalid @enderror" name="rice_farm_address" id="SelectBarangay">
                      <!-- Options will be dynamically populated based on the selected agri_district -->
                  </select>
                  @error('rice_farm_address')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              </div>

                <div class="col-md-3 mb-3">
                  
                  <label class="form-expand" for="tenurial_status">Tenurial Status:</label>
                  <select class="form-control placeholder-text @error('tenurial_status') is-invalid @enderror" name="tenurial_status" id="selectTenurialStatus" onchange="checkTenurial()" aria-label="label select e">
                    <option selected disabled>Select</option>
                    <option value="Owner" {{ old('tenurial_status') == 'Owner' ? 'selected' : '' }}>Owner</option>
                    <option value="Owner Tiller" {{ old('tenurial_status') == 'Owner Tiller' ? 'selected' : '' }}>Owner Tiller</option>
                    <option value="Tenant" {{ old('tenurial_status') == 'Tenant' ? 'selected' : '' }}>Tenant</option>
                    <option value="Tiller" {{ old('tenurial_status') == 'Tiller' ? 'selected' : '' }}>Tiller</option>
                    <option value="Lease" {{ old('tenurial_status') == 'Lease' ? 'selected' : '' }}>Lease</option>
                    <option value="Add" {{ old('tenurial_status') == 'Add' ? 'selected' : '' }}>Add</option>
                  </select>
                  
                  @error('tenurial_status')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                   {{-- add new tenurial status --}}
                  <div class="col-md-3 mb-3" id="NewTenurialInput" style="display: none;">
                    <label for="NewTenurialInput">Add New:</label>
                    <input type="text" id="NewTenurialInputField" class="form-control placeholder-text @error('add_newTenure') is-invalid @enderror" name="add_newTenure" placeholder=" Enter new tenurial status" value="{{ old('add_newTenure') }}">
                    @error('add_newTenure')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
            
                <div class="col-md-3 mb-3">
                  <label class="form-expand" for="no_of_years_as_farmers">No. of Years as Farmer:</label>
                  <select class="form-control placeholder-text @error('no_of_years_as_farmers') is-invalid @enderror" name="no_of_years_as_farmers" id="selectYears" onchange="checkYearF()" aria-label="label select e"value="{{ old('no_of_years_as_farmer') }}">
                    <option selected disabled>Select</option>
                    <option value="1" {{ old('no_of_years_as_farmers') == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('no_of_years_as_farmers') == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ old('no_of_years_as_farmers') == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ old('no_of_years_as_farmers') == '4' ? 'selected' : '' }}>4</option>
                    <option value="5" {{ old('no_of_years_as_farmers') == '5' ? 'selected' : '' }}>5</option>
                    <option value="Add" {{ old('no_of_years_as_farmers') == 'Add' ? 'selected' : '' }}>Add</option>
                  </select>
                  

                  @error('no_of_years_as_farmers')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
                {{-- add no, of years as farmers --}}
                <div class="col-md-3 mb-3" id="NoYearsInput" style="display: none;">
                  <label for="NoYearsInput">Add New here:</label>
                  <input type="text" id="NoYearsInputField" class="form-control placeholder-text @error('add_newFarmyears') is-invalid @enderror" name="add_newFarmyears" placeholder=" Enter no. of years as farmers" value="{{ old('add_newFarmyears') }}">
                  @error('add_newFarmyears')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>



                <div class="col-md-3 mb-3">
                  <label class="form-expand" for="gps_latitude">GPS_Latitude</label>
                  <input type="text" class="form-control placeholder-text  @error('gps_latitude') is-invalid @enderror" name="gps_latitude"  id="lat" placeholder="Enter  GPS_Latitude" value="{{ old('gps_latitude') }}" >
                  @error('gps_latitude')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
             
                <div class="col-md-3 mb-3">
                  <label class="form-expand" for="gps_longitude">GPS_longitude</label>
                  <input type="text" class="form-control placeholder-text  @error('gps_longitude') is-invalid @enderror" name="gps_longitude"  id="long" placeholder="Enter GPS_longitude" value="{{ old('gps_longitude') }}" >
                  @error('gps_longitude')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
                </div>
              </div>
              
           
  
            <div class="row mb-3">
              <h6 class="card-title"><span>b.</span>Land Informations and Environmental Factors:</h6>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="total_physical_area_has">Total Physical Area(has)</label>
                <input type="text" class="form-control placeholder-text @error('total_physical_area_has') is-invalid @enderror"name="total_physical_area_has" id="total_physical_area_has" placeholder="Enter Total Physical Area" value="{{ old('total_physical_area_has') }}" >
                @error('total_physical_area_has')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="rice_area_cultivated_has">Total Cultivated Area(has)</label>
                <input type="text" class="form-control placeholder-text @error('rice_area_cultivated_has') is-invalid @enderror" name="rice_area_cultivated_has"id="rice_area_cultivated_has" placeholder="Enter Total Cultivated Area" value="{{ old('rice_area_cultivated_has') }}" >
                @error('rice_area_cultivated_has')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="land_title_no">Land Title No.</label>
                <input type="text" class="form-control placeholder-text @error('land_title_no') is-invalid @enderror" name="land_title_no"id="land_title_no" placeholder="Enter Land Title No." value="{{ old('land_title_no') }}" >
                @error('land_title_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="lot_no">Lot No.:</label>
                <input type="text" class="form-control placeholder-text @error('lot_no') is-invalid @enderror" name="lot_no" id="lot_no" placeholder="Enter Lot No." value="{{ old('lot_no') }}" >
                @error('lot_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom01" >Area Prone to:
                </label>
                <select class="form-control placeholder-text @error('area_prone_to') is-invalid @enderror" id="selectedAreaprone"onchange="checkProne()" name="area_prone_to" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Flood" {{ old('area_prone_to') == 'Flood' ? 'selected' : '' }}>Flood</option>
                  <option value="Drought" {{ old('area_prone_to') == 'Drought' ? 'selected' : '' }}>Drought</option>
                  <option value="Saline" {{ old('area_prone_to') == 'Saline' ? 'selected' : '' }}>Saline</option>
                  <option value="N/A" {{ old('area_prone_to') == 'N/A' ? 'selected' : '' }}>N/A</option>
                  <option value="Add Prone" {{ old('area_prone_to') == 'Add Prone' ? 'selected' : '' }}>Add</option>
                </select>
                @error('area_prone_to')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
            {{-- add no, of years as farmers --}}
            <div class="col-md-3 mb-3" id="AreaProneInput" style="display: none;">
              <label for="AreaProneInput">Add New area Prone to:</label>
              <input type="text" id="AreaProneInputField" class="form-control placeholder-text @error('add_newProneYear') is-invalid @enderror" name="add_newProneYear" placeholder=" Enter area prone to" value="{{ old('add_newProneYear') }}">
              @error('add_newProneYear')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>



              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom01" >Ecosystem
                </label>
                <select class="form-control placeholder-text @error('ecosystem') is-invalid @enderror" id="selectedEcosystem"onchange="CheckEcosystem()" name="ecosystem" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Lowland Rain Fed" {{ old('ecosystem') == 'Lowland Rain Fed' ? 'selected' : '' }}>Lowland Rain Fed</option>
                  <option value="Lowland Irrigated" {{ old('ecosystem') == 'Lowland Irrigated' ? 'selected' : '' }}>Lowland Irrigated</option>
                  <option value="Add ecosystem" {{ old('ecosystem') == 'Add ecosystem' ? 'selected' : '' }}>Add</option>
                </select>
                @error('ecosystem')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              {{-- add new ecosystem --}}
              <div class="col-md-3 mb-3" id="EcosystemInput" style="display: none;">
                <label for="EcosystemInput">Add New Ecosystem:</label>
                <input type="text" id="EcosystemInputField" class="form-control placeholder-text @error('Add_Ecosystem') is-invalid @enderror" name="Add_Ecosystem" placeholder=" Enter area prone to" value="{{ old('Add_Ecosystem') }}">
                @error('Add_Ecosystem')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>



            </div>
            <div class="row mb-3">
              <h6 class="card-title"><span>C.</span>Crop and Planting Details:</h6>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="type_rice_variety" >Type of Rice Variety
                </label>
                <select class="form-control placeholder-text @error('type_rice_variety') is-invalid @enderror" id="selectrice_variety"onchange="checkVariety()" name="type_rice_variety" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Inbred" {{ old('type_rice_variety') == 'Inbred' ? 'selected' : '' }}>Inbred</option>
                  <option value="Hybrid" {{ old('type_rice_variety') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                  <option value="N/A" {{ old('type_rice_variety') == 'N/A' ? 'selected' : '' }}>N/A</option>
             
                </select>
                @error('type_rice_variety')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
                 {{-- addding preferred rice variety --}}
                 <div class="col-md-3 mb-3" id="PreferedVarietyInput" style="display: none;">
                  <label for="PreferedVarietyInput">Preferred variety:pls Specify:</label>
                  <input type="text" id="PreferedVarietyInputField" class="form-control placeholder-text @error('prefered_variety') is-invalid @enderror" name="prefered_variety" placeholder=" Enter prefer rice variety" value="{{ old('prefered_variety') }}">
                  @error('prefered_variety')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3" id="noneVariety" style="display: none;">
                  <label for="name_legal_spouse">Preferred variety:</label>
                  <select class="form-control @error('name_legal_spouse') is-invalid @enderror" name="none_preffer"id="selectFgroups"onchange="checkfarmGroup()" aria-label="Floating label select e">
                    <option selected disabled>Select</option>
                    <option value="N/A" {{ old('name_legal_spouse') == 'N/A' ? 'selected' : '' }}>N/A</option>
                    
                    
                  
                  </select>
              </div>
             
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="plant_schedule_wetseason">Planting sched(Wet Season):</label>
                <input class="form-control placeholder-text @error('plant_schedule_wetseason') is-invalid @enderror"
                       name="plant_schedule_wetseason" id="datepicker" placeholder="Planting schedule"
                       value="{{ old('plant_schedule_wetseason') }}" data-input='true'>
                @error('plant_schedule_wetseason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="plant_schedule_dryseason">Planting sched(Dry Season):</label>
              <input class="form-control placeholder-text @error('plant_schedule_dryseason') is-invalid @enderror"
                     name="plant_schedule_dryseason" id="datepicker" placeholder="Planting schedule"
                     value="{{ old('plant_schedule_dryseason') }}" data-input='true'>
              @error('plant_schedule_dryseason')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="no_of_cropping_yr">No. of Cropping/year:</label>
                <select class="form-control placeholder-text @error('no_of_cropping_yr') is-invalid @enderror" id="selectcropping_yr"onchange="checkNoCropping()" name="no_of_cropping_yr" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="1" {{ old('no_of_cropping_yr') == '1' ? 'selected' : '' }}>1</option>
                  <option value="2" {{ old('no_of_cropping_yr') == '2' ? 'selected' : '' }}>2</option>
                  <option value="Adds" {{ old('no_of_cropping_yr') == 'Adds' ? 'selected' : '' }}>Add</option>
                </select>
               
                @error('no_of_cropping_yr')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
               {{-- addding preferred rice variety --}}
               <div class="col-md-3 mb-3" id="CroppingInput" style="display: none;">
                <label for="CroppingInpu">Add No. of cropping/yr:</label>
                <input type="text" id="CroppingInputField" class="form-control placeholder-text @error('add_cropyear') is-invalid @enderror" name="add_cropyear" placeholder=" Enter prefer rice variety" value="{{ old('add_cropyear') }}">
                @error('add_cropyear')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom02">Yield (Kg/Ha):</label>
                <input type="text" class="form-control placeholder-text @error('yield_kg_ha') is-invalid @enderror" id="validationCustom02"name="yield_kg_ha" placeholder="Enter yield kg/ha"  value="{{ old('yield_kg_ha') }}" >
                @error('yield_kg_ha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
  
     
            </div>
            <div class="row mb-3">
              <h6 class="card-title"><span>d.</span>Insurance and Financial Information:</h6>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="rsba_register" >RSBA Registered
                </label>
                <select class="form-control placeholder-text @error('rsba_register') is-invalid @enderror" id="rsba_register" name="rsba_register" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Yes" {{ old('rsba_register') == 'Yes' ? 'selected' : '' }}>Yes</option>
                  <option value="No" {{ old('rsba_register') == 'No' ? 'selected' : '' }}>No</option>
            
                </select>
                @error('rsba_register')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="pcic_insured" >PCIC Insured</label>
                <select class="form-control placeholder-text @error('pcic_insured') is-invalid @enderror" id="pcic_insured" name="pcic_insured" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Yes" {{ old('pcic_insured') == 'Yes' ? 'selected' : '' }}>Yes</option>
                  <option value="No" {{ old('pcic_insured') == 'No' ? 'selected' : '' }}>No</option>
            
                </select>
                @error('pcic_insured')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="government_assisted" >Government Assisted</label>
                <select class="form-control placeholder-text @error('government_assisted') is-invalid @enderror" id="government_assisted" name="government_assisted" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Yes" {{ old('government_assisted') == 'Yes' ? 'selected' : '' }}>Yes</option>
                  <option value="No" {{ old('government_assisted') == 'No' ? 'selected' : '' }}>No</option>
            
                </select>
                @error('government_assisted')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="source_of_capital">Source of Capital:</label>
                <select class="form-control placeholder-text @error('source_of_capital') is-invalid @enderror" id="selectedsource_of_capital"onchange="checkSourceCapital()" name="source_of_capital" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Own" {{ old('source_of_capital') == 'Own' ? 'selected' : '' }}>Own</option>
                  <option value="Loan" {{ old('source_of_capital') == 'Loan' ? 'selected' : '' }}>Loan</option>
                  <option value="Financed" {{ old('source_of_capital') == 'Financed' ? 'selected' : '' }}>Financed</option>
                  <option value="Others" {{ old('source_of_capital') == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
                @error('source_of_capital')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
               {{-- addding new source capital --}}
               <div class="col-md-3 mb-3" id="SourceCapitalInput" style="display: none;">
                <label for="SourceCapitalInput">Add new Source of Capital:</label>
                <input type="text" id="SourceCapitalInputField" class="form-control placeholder-text @error('add_sourceCapital') is-invalid @enderror" name="add_sourceCapital" placeholder=" Enter source of Capital" value="{{ old('add_sourceCapital') }}">
                @error('add_sourceCapital')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom02">Remarks/Recommendation:</label>
                <input type="text" class="form-control placeholder-text @error('remarks_recommendation') is-invalid @enderror" id="validationCustom02"name="remarks_recommendation" placeholder="Enter Remarks"  value="{{ old('remarks_recommendation') }}" >
                @error('remarks_recommendation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom02">OCA District Office:</label>
                <input type="text" class="form-control placeholder-text @error('oca_district_office') is-invalid @enderror" id="validationCustom02"name="oca_district_office" value="{{$agri_districts}}" value="{{ old('oca_district_office') }}" readonly>
                @error('oca_district_office')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom02" style="font-size: 12px;">Name of Field Officers:</label>
                <input type="text" class="form-control placeholder-text @error('name_technicians') is-invalid @enderror" id="validationCustom02"name="name_technicians" placeholder="Enter name of Field Officer"  value="{{ old('name_technicians') }}" >
                @error('name_technicians')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom02" style="font-size: 12px;">Date Interview:</label>
                <input class="form-control placeholder-text @error('date_interview') is-invalid @enderror"
                       name="date_interview" id="datepicker" placeholder="Date Interview"
                       value="{{ old('date_interview') }}" data-input='true'>
                @error('date_interview')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="image" class="form-label" style="color: green;">UploadPhoto</label>
                <input type="file" class="custom-file-input" id="inputGroupFile01"
                aria-describedby="inputGroupFileAddon01">
            </div>
  
     
            </div>
            
  <div  class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button type="submit" class="btn btn-success me-md-2 btn-submit">Next</button>
  </div>
            </form>
          
            
          </div>
        </div>
      </div>
    </div>
   
    
  
    <div id="map" style="height: 400px; width: 100%;"></div>
  
  </div>

 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&libraries=drawing,geometry&callback=initMap"></script>
  <script type="text/javascript">
    var map;
    var drawingManager;
    var selectedShape;
    var markers = [];
  
    function initMap() {
      var initialLocation = {lat: 6.9214, lng: 122.0790};
  
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16.3,
        center: initialLocation,
        mapTypeId: 'terrain'
      });
  
      // Initialize the Drawing Manager
      drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControl: true,
        drawingControlOptions: {
          position: google.maps.ControlPosition.TOP_CENTER,
          drawingModes: ['polygon']
        },
        polygonOptions: {
          editable: true
        }
      });
      drawingManager.setMap(map);
  
      // Add event listener for the drawing manager
      google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
        if (event.type === google.maps.drawing.OverlayType.POLYGON) {
          if (selectedShape) {
            selectedShape.setMap(null);
          }
          selectedShape = event.overlay;
          var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
          document.getElementById('area').value = area.toFixed(2); // Calculate and set area
  
          // Get the altitude of the first point of the polygon
          var path = selectedShape.getPath().getArray();
          var latLng = path[0];
          getElevation(latLng);
        }
      });
  
      // This event listener will call addMarker() when the map is clicked.
      map.addListener('click', function(event) {
        if (markers.length >= 1) {
            deleteMarkers();
        }
  
        addMarker(event.latLng);
        document.getElementById('lat').value = event.latLng.lat();
        document.getElementById('long').value = event.latLng.lng();
  
        // Fetch the altitude for the clicked point
        getElevation(event.latLng);
      });
  
      // Event listener for latitude and longitude input fields
      $('#lat, #long').on('change', function() {
        var lat = parseFloat($('#lat').val());
        var lng = parseFloat($('#long').val());
        
        if (!isNaN(lat) && !isNaN(lng)) {
          var location = { lat: lat, lng: lng };
          map.setCenter(location);
          deleteMarkers();
          addMarker(location);
        }
      });
    }
  
    // Adds a marker to the map and push to the array.
    function addMarker(location) {
      var marker = new google.maps.Marker({
        position: location,
        map: map
      });
      markers.push(marker);
    }
  
    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
    }
  
    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
      setMapOnAll(null);
    }
  
    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
      clearMarkers();
      markers = [];
    }
  
    // Fetch and display the elevation of a location
    function getElevation(latLng) {
      var elevator = new google.maps.ElevationService();
      elevator.getElevationForLocations({'locations': [latLng]}, function(results, status) {
        if (status === 'OK') {
          if (results[0]) {
            var elevation = results[0].elevation;
            document.getElementById('altitude').value = elevation.toFixed(2);
          } else {
            document.getElementById('altitude').value = 'No data';
          }
        } else {
          document.getElementById('altitude').value = 'Error';
        }
      });
    }
  
    // jQuery event listener for form submission
    $(document).ready(function() {
      $(document).on('click', '.btn-submit', function(event) {
        var form = $(this).closest("form");
  
        event.preventDefault(); // Prevent the default button action
  
        swal({
            title: "Are you sure you want to submit this form?",
            text: "Please confirm your action.",
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "Yes, Continue!",
                    value: true,
                    visible: true,
                    className: "btn-success",
                    closeModal: false
                }
            },
            dangerMode: true,
        }).then((willSubmit) => {
            if (willSubmit) {
                // Display loading indicator
                swal({
                    title: "Processing...",
                    text: "Please wait.",
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    icon: "info",
                    timerProgressBar: true,
                });
  
                // Submit the form after a short delay to allow the loading indicator to be shown
                setTimeout(function() {
                    form.submit(); // Submit the form
                }, 500);
            }
        });
      });
    });
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

    // Function to populate barangays based on agri_district
function populateBarangays(agriDistrict) {
      var barangaySelect = document.getElementById("SelectBarangay");

      // Clear previous options 
      barangaySelect.innerHTML = '';

      // Populate barangays based on selected district
      var barangays = [];
      switch (agriDistrict) {
          case 'ayala':
              barangays = ["Barangay 1", "Barangay 2"];
              break;
          case 'vitali':
              barangays = ["Taloptap", "Tindalo","Camino Nuevo,", "Tamion","Bataan","Tuktubo","Mialim","Lower Tigbao, Tictapul","Mangusu","Inner Mangusu","Bincul,Mangusu","Sinalikway,Mangusu","Upper Mangusu","Dungcaan,Mangusu", "Tamaraan, Mangusu","Licomo"];
              break;
          case 'culianan':
              barangays = ["Barangay Culianan 1", "Barangay Culianan 2"];
              break;
          case 'tumaga':
              barangays = ["Boalan", "Guiwan","Cabatangan"];
              break;
          case 'manicahan':
              barangays = ["Barangay Manicahan 1", "Barangay Manicahan 2"];
              break;
          case 'curuan':
              barangays = ["Presa", "Quiniput","Buevista",""];
              break;
          default:
              break;
      }

      // Populate dropdown with barangays
      barangays.forEach(function(barangay) {
          var option = document.createElement("option");
          option.text = barangay;
          option.value = barangay;
          barangaySelect.appendChild(option); // Append option to select element
      });

      // Add an option to add new barangay
      var addNewOption = document.createElement("option");
      addNewOption.text = "Add New Barangay";
      addNewOption.value = "addNew";
      barangaySelect.appendChild(addNewOption);
  }

  // Function to handle the barangay selection
  function handleBarangaySelection() {
      var barangaySelect = document.getElementById("SelectBarangay");
      var selectedOption = barangaySelect.value;

      if (selectedOption === "addNew") {
          var newBarangay = prompt("Enter new barangay name:");
          if (newBarangay !== null && newBarangay !== "") {
              // Add the new barangay to the dropdown
              var option = document.createElement("option");
              option.text = newBarangay;
              option.value = newBarangay;
              barangaySelect.insertBefore(option, barangaySelect.lastChild); // Add option before the last option ("Add New Barangay")
              // Select the newly added barangay
              barangaySelect.value = newBarangay;
          }
      }
  }

  // Function to check agri_district and display barangay input accordingly
  function checkAgri() {
      var agriDistrict = document.getElementById("selectAgri").value;
      var barangayInput = document.getElementById("barangayInput");

      if (['ayala', 'vitali', 'culianan', 'tumaga', 'manicahan', 'curuan'].includes(agriDistrict)) {
          barangayInput.style.display = "block"; // Show barangay input
          populateBarangays(agriDistrict); // Populate barangays based on selected district
      } else {
          barangayInput.style.display = "none"; // Hide barangay input
      }
  }

  // Call the checkAgri function when the page loads
  window.onload = checkAgri;

  // Call the checkAgri function when the agri_district selection changes
  document.getElementById("selectAgri").addEventListener("change", checkAgri);

  // Call the handleBarangaySelection function when a barangay is selected
  document.getElementById("SelectBarangay").addEventListener("change", handleBarangaySelection);

  // add new tenurial status
  function checkTenurial() {
      var selecttenurial_status = document.getElementById("selecttenurial_status");
      var NewTenurailInput = document.getElementById("NewTenurailInput");
      if (selecttenurial_status.value === "Add") {
         NewTenurailInput.style.display = "block";
      } else {
         NewTenurailInput.style.display = "none";
      }
  }
  </script>
  <script>
    function checkTenurial() {
      var select = document.getElementById("selectTenurialStatus");
      var option = select.options[select.selectedIndex].value;
  
      if (option === 'Add') {
        document.getElementById("NewTenurialInput").style.display = "block";
      } else {
        document.getElementById("NewTenurialInput").style.display = "none";
      }
    }
  
    // Add new tenurial status to the select element
    document.getElementById("NewTenurialInputField").addEventListener("change", function() {
      var newTenure = this.value.trim();
      if (newTenure !== '') {
        var select = document.getElementById("selectTenurialStatus");
        var option = document.createElement("option");
        option.text = newTenure;
        option.value = newTenure;
        select.add(option);
      }
    });
    // selecting no.of years as farmers
    function checkYearF() {
      var select = document.getElementById("selectYears");
      var option = select.options[select.selectedIndex].value;
  
      if (option === 'Add') {
        document.getElementById("NoYearsInput").style.display = "block";
      } else {
        document.getElementById("NoYearsInput").style.display = "none";
      }
    }
  
    // Add new tenurial status to the select element
    document.getElementById("NoYearsInputField").addEventListener("change", function() {
      var newTenure = this.value.trim();
      if (newTenure !== '') {
        var select = document.getElementById("selectYears");
        var option = document.createElement("option");
        option.text = newTenure;
        option.value = newTenure;
        select.add(option);
      }
    });

    // selectied add from the area prone
    function checkProne() {
      var select = document.getElementById("selectedAreaprone");
      var option = select.options[select.selectedIndex].value;
  
      if (option === 'Add Prone') {
        document.getElementById("AreaProneInput").style.display = "block";
      } else {
        document.getElementById("AreaProneInput").style.display = "none";
      }
    }
  
    // Add new tenurial status to the select element
    document.getElementById("AreaProneInputField").addEventListener("change", function() {
      var newTenure = this.value.trim();
      if (newTenure !== '') {
        var select = document.getElementById("selectedAreaprone");
        var option = document.createElement("option");
        option.text = newTenure;
        option.value = newTenure;
        select.add(option);
      }
    });
    // selection ecosystem
    function CheckEcosystem() {
      var select = document.getElementById("selectedEcosystem");
      var option = select.options[select.selectedIndex].value;
  
      if (option === 'Add ecosystem') {
        document.getElementById("EcosystemInput").style.display = "block";
      } else {
        document.getElementById("EcosystemInput").style.display = "none";
      }
      
    }
  
    // Add new tenurial status to the select element
    document.getElementById("EcosystemInputField").addEventListener("change", function() {
      var newTenure = this.value.trim();
      if (newTenure !== '') {
        var select = document.getElementById("selectedEcosystem");
        var option = document.createElement("option");
        option.text = newTenure;
        option.value = newTenure;
        select.add(option);
      }
    });

    // selection of rice variety
    function checkVariety() {
      var select = document.getElementById("selectrice_variety");
      var option = select.options[select.selectedIndex].value;
  
      if (option === 'N/A') {
        document.getElementById("PreferedVarietyInput").style.display = "block";
      } else {
        document.getElementById("PreferedVarietyInput").style.display = "none";
      }
      
    }
    function checkVariety() {
        var selectElement = document.getElementById("selectrice_variety");
        var addPreferredVarietyDiv = document.getElementById("Add_preferred_variety");

        if (selectElement.value === "Inbred" || selectElement.value === "Hybrid") {
            addPreferredVarietyDiv.style.display = "block";
        } else {
            addPreferredVarietyDiv.style.display = "none";
        }
    }
    // Add new tenurial status to the select element
    document.getElementById("PreferedVarietyInputField").addEventListener("change", function() {
      var newTenure = this.value.trim();
      if (newTenure !== '') {
        var select = document.getElementById("selectrice_variety");
        var option = document.createElement("option");
        option.text = newTenure;
        option.value = newTenure;
        select.add(option);
      }
    });
    // selection of adding new source of capital
    function checkSourceCapital() {
      var select = document.getElementById("selectedsource_of_capital");
      var option = select.options[select.selectedIndex].value;
  
      if (option === 'Others') {
        document.getElementById("SourceCapitalInput").style.display = "block";
      } else {
        document.getElementById("SourceCapitalInput").style.display = "none";
      }
      
    }
  
    // Add new tenurial status to the select element
    document.getElementById("SourceCapitalInputField").addEventListener("change", function() {
      var newTenure = this.value.trim();
      if (newTenure !== '') {
        var select = document.getElementById("selectedsource_of_capital");
        var option = document.createElement("option");
        option.text = newTenure;
        option.value = newTenure;
        select.add(option);
      }
    });
    // selection of adding no. of cropping per year
    function checkNoCropping() {
      var select = document.getElementById("selectcropping_yr");
      var option = select.options[select.selectedIndex].value;
  
      if (option === 'Adds') {
        document.getElementById("CroppingInput").style.display = "block";
      } else {
        document.getElementById("CroppingInput").style.display = "none";
      }
      
    }
  
    // Add new tenurial status to the select element
    document.getElementById("CroppingInputField").addEventListener("change", function() {
      var newTenure = this.value.trim();
      if (newTenure !== '') {
        var select = document.getElementById("selectcropping_yr");
        var option = document.createElement("option");
        option.text = newTenure;
        option.value = newTenure;
        select.add(option);
      }
    });
  </script>



  @endsection