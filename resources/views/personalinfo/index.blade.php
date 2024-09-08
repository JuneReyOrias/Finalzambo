@extends('admin.dashb')
@section('admin')
@extends('layouts._footer-script')
@extends('layouts._head')
<div class="page-content">

  <nav class="page-breadcrumb">

  </nav>
  <div class="progress mb-3">
    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">1 out of 6 Complete</div>

  </div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card-forms border rounded">

        <div class="card-body">
          
          @if (session('message'))
          <div class="alert alert-success" role="alert">
            {{ session('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
             
          @endif
         
          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
          <h4 class="card-titles" style="display: flex;text-align: center; "><span></span>Rice Survey Form Zamboanga City</h4>
          <br>
          <h6 class="card-title"><span>I.</span>Personal Informations</h6>
<br><br>
          <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
        
          <form id="surveyForm" action{{url('store')}} method="post">
            @csrf
       
            <div >

             <input type="hidden" name="users_id" value="{{ $userId}}">
            
          
      </div>
            <div class="row mb-3">
              <h6 class="card-title"><span>a.</span>Personal Info:</h6>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom01">First name</label>
                <input type="text" class="form-control placeholder-text @error('first_name') is-invalid @enderror" name="first_name" id="validationCustom01" placeholder="First name" value="{{ old('first_name') }}">
                @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom02">Middle name</label>
                <input type="text" class="form-control placeholder-text @error('middle_name') is-invalid @enderror" name="middle_name" id="validationCustom02" placeholder="Middle name"value="{{ old('middle_name') }}" >
                @error('middle_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="validationCustom01">Last name</label>
                <input type="text" class="form-control placeholder-text @error('last_name') is-invalid @enderror" name="last_name" id="validationCustom01" placeholder="Last name" value="{{ old('last_name') }}" >
                @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-expand" for="selectExtendName">Extension name</label>
                <select class="form-control @error('extension_name') is-invalid @enderror" name="extension_name"id="selectExtendName"onchange="checkExtendN()" aria-label="Floating label select e" >
                  <option selected disabled>Select</option>
                  <option value="Sr." {{ old('extension_name') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                  <option value="Jr." {{ old('extension_name') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                  <option value="II" {{ old('extension_name') == 'II' ? 'selected' : '' }}>II</option>
                  <option value="III." {{ old('extension_name') == 'III.' ? 'selected' : '' }}>III</option>
                  <option value="N/A" {{ old('extension_name') == 'N/A' ? 'selected' : '' }}>N/A</option>
                  <option value="others" {{ old('extension_name') == 'others' ? 'selected' : '' }}>others</option>
                </select>
                
                @error('extension_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
                                  {{-- add new form --}}
                                  <div class="col-md-3 mb-3" id="OthersInputField" style="display: none;">
                                    <label for="OthersInputField">Enter Extend Name:</label>
                                    <input type="text" id="OthersInputField" name="add_extName" class="form-control @error('add_extName') is-invalid @enderror" placeholder="Enter extension name" value="{{ old('pwd_id_no') }}">
                                    @error('add_extName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                  </div>
                             
                                  {{-- add new form --}}
            </div>
            
         

          <div class="row mb-3">
            <h6 class="card-title"><span>b.</span>Contact & Demographic Information:</h6>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="country">Country</label>
              <input type="text" class="form-control placeholder-text @error('country') is-invalid @enderror"name="country" id="validationCustom01" value="Philippines" readonly>
              @error('country')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="province">Province</label>
              <input type="text" class="form-control placeholder-text @error('province') is-invalid @enderror"name="province" id="validationCustom01" value="Zamboanga del sur" readonly>
              @error('province')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="city">City</label>
              <input type="text" class="form-control placeholder-text @error('city') is-invalid @enderror" name="city" id="validationCustom01" value="Zamboanga City" readonly>
              @error('city')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            {{-- <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom01">Agri-District</label>
              <input type="text" class="form-control placeholder-text @error('province') is-invalid @enderror"name="city" id="validationCustom01" value="{{$agri_district}}" readonly>
              @error('province')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div> --}}
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="agri_district">Agri-District</label>
              <select class="form-control @error('agri_district') is-invalid @enderror" name="agri_district" id="selectAgri" onchange="checkAgri()" aria-label="Floating label select e">
                  <option value="{{$agri_district}}" {{$agri_district == "ayala" ? 'selected' : ''}}>{{$agri_district}}</option>
               
              </select>
           
              @error('agri_district')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          
          {{-- <div class="col-md-3 mb-3" id="barangayInput" style="{{ in_array($agri_district, ['ayala','vitali', 'culianan', 'tumaga', 'manicahan', 'curuan']) ? 'display: block;' : 'display: none;' }}">
            <label class="form-expand" for="SelectBarangay">Barangay</label>
            <select class="form-control" name="barangay" id="SelectBarangay">
                <!-- Options will be dynamically populated based on the selected agri_district -->
            </select>
        </div> --}}
        
        <div class="col-md-3 mb-3" id="barangayInput" style="{{ in_array($agri_district, ['ayala','vitali', 'culianan', 'tumaga', 'manicahan', 'curuan']) ? 'display: block;' : 'display: none;' }}">
          <label class="form-expand" for="barangay">Barangay</label>
          <select class="form-control" name="barangay" id="SelectBarangay">
              <!-- Options will be dynamically populated based on the selected agri_district -->
          </select>
      </div>
          
          
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Contact No.</label>
              <input type="text" class="form-control placeholder-text @error('contact_no') is-invalid @enderror" name="contact_no"id="validationCustom02" placeholder="Contact No." value="{{ old('contact_no') }}" >
              @error('contact_no')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom01">Sex:</label>
            
              <select class="form-control @error('sex') is-invalid @enderror" name="sex"id="validationCustom01" aria-label="Floating label select e" >
                <option selected disabled>Select</option>
                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
              </select>
              @error('sex')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Religion:</label>
              <select class="form-control @error('religion') is-invalid @enderror" name="religion"id="selectReligion"onchange="checkReligion()" aria-label="Floating label select e" >
                <option selected disabled>Select</option>
                <option value="Roman Catholic" {{ old('religion') == 'Roman Catholic' ? 'selected' : '' }}>Roman Catholic</option>
                <option value="Iglesia Ni Cristo" {{ old('religion') == 'Iglesia Ni Cristo' ? 'selected' : '' }}>Iglesia Ni Cristo</option>
                <option value="Seventh-day Adventist" {{ old('religion') == 'Seventh-day Adventist' ? 'selected' : '' }}>Seventh-day Adventist</option>
                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option value="Born Again CHurch" {{ old('religion') == 'Born Again CHurch' ? 'selected' : '' }}>Born Again CHurch</option>
                <option value="N/A" {{ old('religion') == 'N/A' ? 'selected' : '' }}>N/A</option>
                <option value="other" {{ old('religion') == 'other' ? 'selected' : '' }}>other</option>
              </select>
               
          
              @error('religion')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          
            </div>
             {{-- add new form --}}
                  <div class="col-md-3 mb-3" id="ReligionInputField" style="display: none;">
                    <label for="ReligionInputField">Enter your Religion:</label>
                    <input type="text" id="ReligionInputField" name="add_Religion" class="form-control @error('add_Religion') is-invalid @enderror" placeholder="Enter religion" value="{{ old('pwd_id_no') }}">
                      @error('add_Religion')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                             
               {{-- add new form --}}
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="date_of_birth">Date of Birth</label>
              <input class="form-control placeholder-text @error('date_of_birth') is-invalid @enderror"
                     name="date_of_birth" id="datepicker" placeholder="Date of Birth"
                     value="{{ old('date_of_birth') }}" data-input='true'>
              @error('date_of_birth')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          
          
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Place of Birth</label>
              <select class="form-control @error('place_of_birth') is-invalid @enderror" name="place_of_birth"id="selectplacebrth"onchange="checkPlaceBirth()" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="Zamboanga City" {{ old('place_of_birth') == 'Zamboanga City' ? 'selected' : '' }}>Zamboanga City</option>
                <option value="Basilan Province" {{ old('place_of_birth') == 'Basilan Province' ? 'selected' : '' }}>Basilan Province</option>
                <option value="Vitali,ZC" {{ old('place_of_birth') == 'Vitali,ZC' ? 'selected' : '' }}>Vitali,ZC</option>
                <option value="Limaong,ZC" {{ old('place_of_birth') == 'Limaong,ZC' ? 'selected' : '' }}>Limaong,ZC</option>
                <option value="Cotabato" {{ old('place_of_birth') == 'Cotabato' ? 'selected' : '' }}>Cotabato</option>
                <option value="South Cotabato" {{ old('place_of_birth') == 'South Cotabato' ? 'selected' : '' }}>South Cotabato</option>
                <option value="Bunguiao, Zc" {{ old('place_of_birth') == 'Bunguiao, Zc' ? 'selected' : '' }}>Bunguiao, ZC</option>
                <option value="Manicahan,Zc" {{ old('place_of_birth') == 'Manicahan,Zc' ? 'selected' : '' }}>Manicahan, ZC</option>
                <option value="Negros Occidental" {{ old('place_of_birth') == 'Negros Occidental' ? 'selected' : '' }}>Negros Occidental</option>
                <option value="Mercedes, ZC" {{ old('place_of_birth') == 'Mercedes, ZC' ? 'selected' : '' }}>Mercedes, ZC</option>
                <option value="Curuan, ZC" {{ old('place_of_birth') == 'Curuan, ZC' ? 'selected' : '' }}>Curuan, ZC</option>
                <option value="Boalan, Zc" {{ old('place_of_birth') == 'Boalan, Zc' ? 'selected' : '' }}>Boalan, ZC</option>
                <option value="Guiwan, Zc" {{ old('place_of_birth') == 'Guiwan, Zc' ? 'selected' : '' }}>Guiwan, ZC</option>
                <option value="Cabatangan, Zc" {{ old('place_of_birth') == 'Cabatangan, Zc' ? 'selected' : '' }}>Cabatangan, ZC</option>
                <option value="Tugbungan, Zc" {{ old('place_of_birth') == 'Tugbungan, Zc' ? 'selected' : '' }}>Tugbungan, ZC</option>
                <option value="Talabaan, Zc" {{ old('place_of_birth') == 'Talabaan, Zc' ? 'selected' : '' }}>Talabaan, ZC</option>
                <option value="Culianan, Zc" {{ old('place_of_birth') == 'Culianan, Zc' ? 'selected' : '' }}>Culianan, ZC</option>
                <option value="Ayala, Zc" {{ old('place_of_birth') == 'Ayala, Zc' ? 'selected' : '' }}>Ayala, ZC</option>
                <option value="Add Place of Birth" {{ old('place_of_birth') == 'Add Place of Birth' ? 'selected' : '' }}>Add new</option>
              </select>
              
              @error('place_of_birth')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
                    {{-- add new form --}}
                    <div class="col-md-3 mb-3" id="AddBirthInput" style="display: none;">
                      <label for="AddBirthInput">Add Place of Birth:</label>
                      <input type="text" id="AddBirthInput" name="add_PlaceBirth" class="form-control @error('add_PlaceBirth') is-invalid @enderror" placeholder="Enter name of spouse" value="{{ old('add_PlaceBirth') }}">
                      @error('add_PlaceBirth')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                    </div>




            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom01">Civil Status:</label>
            
              <select class="form-control @error('civil_status') is-invalid @enderror" name="civil_status"id="selectCivil"onchange="checkCivil()" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                <option value="Maried" {{ old('civil_status') == 'Maried' ? 'selected' : '' }}>Maried</option>
                <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                <option value="Widow" {{ old('civil_status') == 'Widow' ? 'selected' : '' }}>Widow</option>
               
              </select>
              @error('civil_status')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
                    {{-- add new form --}}
                    <div class="col-md-3 mb-3" id="MariedInputSelected" style="display: none;">
                      <label for="MariedInputSelected">Name of Spouse:</label>
                      <input type="text" id="MariedInputSelected" name="name_legal_spouse" class="form-control @error('name_legal_spouse') is-invalid @enderror" placeholder="Enter name of spouse" value="{{ old('name_legal_spouse') }}">
                      @error('name_legal_spouse')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                    </div>
                  <div class="col-md-3 mb-3" id="SinWidDevInput" style="display: none;">
                    <label for="name_legal_spouse">Name of Spouse:</label>
                    <select class="form-control @error('name_legal_spouse') is-invalid @enderror" name="name_legal_spouse"id="selectFgroups"onchange="checkfarmGroup()" aria-label="Floating label select e">
                      <option selected disabled>Select</option>
                      <option value="N/A" {{ old('name_legal_spouse') == 'N/A' ? 'selected' : '' }}>N/A</option>
                      
                      
                    
                    </select>
                </div>

                    {{-- add new form --}}




{{-- 
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Name of Spouse:</label>
              <input type="text" class="form-control placeholder-text @error('name_legal_spouse') is-invalid @enderror"name="name_legal_spouse" id="validationCustom02" placeholder="Name of Spouse"  value="{{ old('name_legal_spouse') }}">
              @error('name_legal_spouse')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div> --}}

            <div class="col-md-3 mb-3">
              <label class="form-expand" for="no_of_children">No. of Children</label>
              <select class="form-control  @error('no_of_children') is-invalid @enderror"name="no_of_children"id="childrenSelect"onchange="checkChildren()" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="1" {{ old('no_of_children') == '1' ? 'selected' : '' }}>1</option>
                <option value="2" {{ old('no_of_children') == '2' ? 'selected' : '' }}>2</option>
                <option value="3" {{ old('no_of_children') == '3' ? 'selected' : '' }}>3</option>
                <option value="4" {{ old('no_of_children') == '4' ? 'selected' : '' }}>4</option>
                <option value="5" {{ old('no_of_children') == '5' ? 'selected' : '' }}>5</option>
                <option value="N/A" {{ old('no_of_children') == 'N/A' ? 'selected' : '' }}>N/A</option>
                <option value="Add" {{ old('no_of_children') == 'Add' ? 'selected' : '' }}>Add</option>

              </select>
              @error('no_of_children')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            {{-- add new form --}}
            <div class="col-md-3 mb-3" id="otherchilderInputContainer" style="display: none;">
              <label for="add_noChildren">add no. of children:</label>
              <input type="text" id="otherchilderInputContainer" name="add_noChildren" class="form-control" placeholder="enter no. of children">
          </div>

            {{-- add new form --}}

            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Mother's Maiden Name</label>
              <input type="text" class="form-control placeholder-text @error('mothers_maiden_name') is-invalid @enderror"name="mothers_maiden_name" id="validationCustom02" placeholder="Mother's Maiden Name"  value="{{ old('mothers_maiden_name') }}">
              @error('mothers_maiden_name')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom01">Highest Formal Education:</label>
            
              <select class="form-control  @error('highest_formal_education') is-invalid @enderror" name="highest_formal_education"id="selectEduc"onchange="checkFormalEduc()" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="No Formal Education" {{ old('highest_formal_education') == 'No Formal Education' ? 'selected' : '' }}>No Formal Education</option>
                <option value="Primary Education" {{ old('highest_formal_education') == 'Primary Education' ? 'selected' : '' }}>Primary Education</option>
                <option value="Secondary Education" {{ old('highest_formal_education') == 'Secondary Education' ? 'selected' : '' }}>Secondary Education</option>
                <option value="Vocational Training" {{ old('highest_formal_education') == 'Vocational Training' ? 'selected' : '' }}>Vocational Training</option>
                <option value="Bachelors Degree" {{ old('highest_formal_education') == 'Bachelors Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
                <option value="Masters Degree" {{ old('highest_formal_education') == 'Masters Degree' ? 'selected' : '' }}>Master's Degree</option>
                <option value="Doctorate" {{ old('highest_formal_education') == 'Doctorate' ? 'selected' : '' }}>Doctorate</option>
                <option value="Other" {{ old('highest_formal_education') == 'Other' ? 'selected' : '' }}>Other</option>
               
                
              </select>
              @error('highest_formal_education')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror

            </div>

                {{-- add new form --}}
                <div class="col-md-3 mb-3" id="otherformInputContainer" style="display: none;">
                  <label for="add_formEduc">Other input here:</label>
                  <input type="text" id="otherformInputContainer" name="add_formEduc" class="form-control" placeholder="enter highest formal education">
              </div>
    
                {{-- add new form --}}
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Person with Disability:</label>
              <select class="form-control  @error('person_with_disability') is-invalid @enderror" name="person_with_disability"id="selectPWD"onchange="checkPWD()" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="Yes" {{ old('person_with_disability') == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ old('person_with_disability') == 'No' ? 'selected' : '' }}>No</option>
                
              
              </select>
              @error('person_with_disability')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
{{--             
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">PWD ID No.</label>
              <input type="text" class="form-control placeholder-text @error('pwd_id_no') is-invalid @enderror"name="pwd_id_no" id="validationCustom02" placeholder="PWD ID No." value="{{ old('pwd_id_no') }}"  >
              @error('pwd_id_no')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div> --}}
                    {{-- add new form --}}
                    <div class="col-md-3 mb-3" id="YesInputSelected" style="display: none;">
                      <label for="pwd_id_no">PWD ID No.:</label>
                      <input type="text" id="YesInputSelected" name="pwd_id_no" class="form-control @error('pwd_id_no') is-invalid @enderror" placeholder="Enter pwdID no." value="{{ old('pwd_id_no') }}">
                      @error('pwd_id_no')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                    </div>
                  <div class="col-md-3 mb-3" id="NoInputSelected" style="display: none;">
                    <label for="add_empty">PWD ID No:</label>
                    <select class="form-control @error('pwd_id_no') is-invalid @enderror" name="pwd_id_no"id="selectFgroups"onchange="checkfarmGroup()" aria-label="Floating label select e">
                      <option selected disabled>Select</option>
                      <option value="N/A" {{ old('pwd_id_no') == 'N/A' ? 'selected' : '' }}>N/A</option>
                      
                      










                      
                    
















                    
                    </select>
                </div>

                    {{-- add new form --}}
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Government Issued ID</label>
              <select class="form-control @error('government_issued_id') is-invalid @enderror"  name="government_issued_id"id="selectGov"onchange="CheckGoverniD()" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="Yes" {{ old('government_issued_id') == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ old('government_issued_id') == 'No' ? 'selected' : '' }}>No</option>
              
              </select>
              @error('government_issued_id')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>

            {{-- add new form --}}
            <div class="col-md-3 mb-3" id="iDtypeSelected" style="display: none;">
              <label for="YesInputSelected">Gov ID Type:</label>
              <select class="form-control @error('id_type') is-invalid @enderror" name="id_type"id="selectIDType"onchange="checkIDtype()" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="Driver License" {{ old('id_type') == 'Driver License' ? 'selected' : '' }}>Driver License</option>
                  <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                  <option value="Postal ID" {{ old('id_type') == 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                  <option value="Phylsys ID" {{ old('id_type') == 'Phylsys ID' ? 'selected' : '' }}>Phylsys ID</option>
                  <option value="PRC ID" {{ old('id_type') == 'PRC ID' ? 'selected' : '' }}>PRC ID</option>
                  <option value="Brgy. ID" {{ old('id_type') == 'Brgy. ID' ? 'selected' : '' }}>Brgy. ID</option>
                  <option value="Voters ID" {{ old('id_type') == 'Voters ID' ? 'selected' : '' }}>Voters ID</option>
                  <option value="Senior ID" {{ old('id_type') == 'Senior ID' ? 'selected' : '' }}>Senior ID</option>
                  <option value="PhilHealth ID" {{ old('id_type') == 'PhilHealth ID' ? 'selected' : '' }}>PhilHealth ID</option>
                  <option value="Tin ID" {{ old('id_type') == 'Tin ID' ? 'selected' : '' }}>Tin ID</option>
                  <option value="BIR ID" {{ old('id_type') == 'BIR ID' ? 'selected' : '' }}>BIR ID</option>
                  <option value="N/A" {{ old('id_type') == 'N/A' ? 'selected' : '' }}>N/A</option>
                  <option value="add Id Type" {{ old('id_type') == 'add Id Type' ? 'selected' : '' }}>Other ID Type</option>
                {{-- <option value="add Id Type" {{ old('id_type') == 'add Id Type' ? 'selected' : '' }}>Other ID Type</option> --}}

              
              </select>
          @error('id_type')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            <div class="col-md-3 mb-3" id="NoSelected" style="display: none;">
            <label for="NoSelected">Non-Gov ID:</label>
            <input type="text" id="NoSelected" name="id_types" class="form-control" placeholder="enter non-gov id" readonly>
            </div>

         
            {{-- add gov id type input id no. --}}
            <div class="col-md-3 mb-3" id="idNoInput" style="display: none;">
              <label for="idNoInput">ID No.:</label>
              <input type="text" id="idNoInput" class="form-control placeholder-text @error('gov_id_no') is-invalid @enderror"name="gov_id_no" id="validationCustom02" placeholder=" Enter ID No."  value="{{ old('gov_id_no') }}">
              @error('gov_id_no')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          </div>
          <div class="col-md-3 mb-3" id="OthersInput" style="display: none;">
            <label for="OthersInput">Gov-ID Type:</label>
            <input type="text" id="OthersInput" class="form-control placeholder-text @error('gov_id_no') is-invalid @enderror"name="add_Idtype" id="validationCustom02" placeholder="Enter gov-id type"  value="{{ old('gov_id_no') }}">
            @error('gov_id_no')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        </div>
        <div class="col-md-3 mb-3" id="OtherIDInput" style="display: none;">
          <label for="OtherIDInput">ID no.:</label>
          <input type="text" id="OtherIDInput" class="form-control placeholder-text @error('gov_id_no') is-invalid @enderror"name="add_Idtype" id="validationCustom02" placeholder="Enter gov-id type"  value="{{ old('gov_id_no') }}">
          @error('gov_id_no')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      </div>
            {{-- end  add new form --}}



          
       

          <div class="row mb-3">
            <h6 class="card-title"><span>C.</span>Association Information:</h6>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom01" style="font-size: 10px;">Member of any Farmers Ass/Org/Coop
              </label>
              <select class="form-control @error('member_ofany_farmers_ass_org_coop') is-invalid @enderror" id="selectMember"onchange="checkMmbership()" name="member_ofany_farmers_ass_org_coop" aria-label="Floating label select e">
                <option selected disabled>Select</option>
                <option value="Yes" {{ old('member_ofany_farmers_ass_org_coop') == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ old('member_ofany_farmers_ass_org_coop') == 'No' ? 'selected' : '' }}>No</option>
              
              </select>
              @error('member_ofany_farmers_ass_org_coop')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
              {{--  farmers name of org/associations/cooperative--}}

              <div class="col-md-3 mb-3" id="YesFarmersGroup" style="display: none;font-size: 12px">
                <label for="YesInputSelected">Name of Farmers Ass/Org/Coop:</label>
                <select class="form-control @error('nameof_farmers_ass_org_coop') is-invalid @enderror" name="nameof_farmers_ass_org_coop"id="selectFarmgroups"onchange="checkFarmerGrp()" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="Bagong Pag Asa Buenavista Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Bagong Pag Asa Buenavista Farmers Association' ? 'selected' : '' }}>Bagong Pag Asa Buenavista Farmers Association</option>
                  <option value="Bataan Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Bataan Farmers Association' ? 'selected' : '' }}>Bataan Farmers Association</option>
                  <option value="Bincul Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Bincul Farmers Association' ? 'selected' : '' }}>Bincul Farmers Association</option>
                  <option value="Boalan Irrigators Association" {{ old('nameof_farmers_ass_org_coop') == 'Boalan Irrigators Association' ? 'selected' : '' }}>Boalan Irrigators Association</option>
                  <option value="Buenavista Farmers Swisa" {{ old('nameof_farmers_ass_org_coop') == 'Buenavista Farmers Swisa' ? 'selected' : '' }}>Buenavista Farmers Swisa</option>
                  <option value="Cabaluay Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Cabaluay Farmers Association' ? 'selected' : '' }}>Cabaluay Farmers Association</option>
                  <option value="Camino Nuevo Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Camino Nuevo Farmers Association' ? 'selected' : '' }}>Camino Nuevo Farmers Association</option>
                  <option value="Dabuy Farmers Owners Irrigators" {{ old('nameof_farmers_ass_org_coop') == 'Dabuy Farmers Owners Irrigators' ? 'selected' : '' }}>Dabuy Farmers Owners Irrigators</option>
                  <option value="Dumalon River Irrigators Assciation" {{ old('nameof_farmers_ass_org_coop') == 'Dumalon River Irrigators Assciation' ? 'selected' : '' }}>Dumalon River Irrigators Assciation</option>
                  <option value="Guisao Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Guisao Farmers Association' ? 'selected' : '' }}>Guisao Farmers Association</option>
                  <option value="Guisao/Cabaluay Farmers Irrigators Assoc. Inc." {{ old('nameof_farmers_ass_org_coop') == 'Guisao/Cabaluay Farmers Irrigators Assoc. Inc.' ? 'selected' : '' }}>Guisao/Cabaluay Farmers Irrigators Assoc. Inc.</option>
                  <option value="Guiwan Farmers  Association" {{ old('nameof_farmers_ass_org_coop') == 'Guiwan Farmers  Association' ? 'selected' : '' }}>Guiwan Farmers  Association</option>
                  <option value="Hybrid Rice & Vegetables Farmers Association Inc." {{ old('nameof_farmers_ass_org_coop') == 'Hybrid Rice & Vegetables Farmers Association Inc.' ? 'selected' : '' }}>Hybrid Rice & Vegetables Farmers Association Inc.</option>
                  <option value="Inner Mangusu & FishFolks Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Inner Mangusu & FishFolks Farmers Association' ? 'selected' : '' }}>Inner Mangusu & FishFolks Farmers Association</option>
                  <option value="Licomo Inner Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Licomo Inner Farmers Association' ? 'selected' : '' }}>Licomo Inner Farmers Association</option>
                  <option value="Lower Mangusu Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Lower Mangusu Farmers Association' ? 'selected' : '' }}>Lower Mangusu Farmers Association</option>
                  <option value="Lower Quiniput Irrigated Association" {{ old('nameof_farmers_ass_org_coop') == 'Lower Quiniput Irrigated Association' ? 'selected' : '' }}>Lower Quiniput Irrigated Association</option>
                  <option value="Lower Tigbao Tictapuk Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Lower Tigbao Tictapuk Farmers Association' ? 'selected' : '' }}>Lower Tigbao Tictapuk Farmers Association</option>
                  <option value="Lukmadalum Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Lukmadalum Farmers Association' ? 'selected' : '' }}>Lukmadalum Farmers Association</option>
                  <option value="Lunday II Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Licomo Inner Farmers Association' ? 'selected' : '' }}>Licomo Inner Farmers Association</option>
                  <option value="Mabutad Rice Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Mabutad Rice Farmers Association' ? 'selected' : '' }}>Mabutad Rice Farmers Association</option>
                  <option value="Mangusu Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Mangusu Farmers Association' ? 'selected' : '' }}>Mangusu Farmers Association</option>
                  <option value="Manicahan Busug Tadtanan Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Manicahan Busug Tadtanan Farmers Association' ? 'selected' : '' }}>Manicahan Busug Tadtanan Farmers Association</option>
                  <option value="Masaba Quiniput Irrigated Association" {{ old('nameof_farmers_ass_org_coop') == 'Masaba Quiniput Irrigated Association' ? 'selected' : '' }}>Masaba Quiniput Irrigated Association</option>
                  <option value="MCCT-IA" {{ old('nameof_farmers_ass_org_coop') == 'MCCT-IA' ? 'selected' : '' }}>MCCT-IA</option>
                  <option value="Mercedes Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Mercedes Farmers Association' ? 'selected' : '' }}>Mercedes Farmers Association</option>
                  <option value="Mialim Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Mialim Farmers Association' ? 'selected' : '' }}>Mialim Farmers Association</option>
                  <option value="Pamucutan CamaCoop Talisayan Irrigators Association" {{ old('nameof_farmers_ass_org_coop') == 'Pamucutan CamaCoop Talisayan Irrigators Association' ? 'selected' : '' }}>Pamucutan CamaCoop Talisayan Irrigators Association</option>
                  <option value="PasoMaria Farmers Irrigators Association" {{ old('nameof_farmers_ass_org_coop') == 'PasoMaria Farmers Irrigators Association' ? 'selected' : '' }}>PasoMaria Farmers Irrigators Association</option>
                  <option value="Pasonanca Irrigators Association" {{ old('nameof_farmers_ass_org_coop') == 'Pasonanca Irrigators Association' ? 'selected' : '' }}>Pasonanca Irrigators Association</option>
                  <option value="Presa Curuan Irrigation Association" {{ old('nameof_farmers_ass_org_coop') == 'Presa Curuan Irrigation Association' ? 'selected' : '' }}>Presa Curuan Irrigation Association</option>
                  <option value="Proper Mangusu Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Proper Mangusu Farmers Association' ? 'selected' : '' }}>Proper Mangusu Farmers Association</option>
                  <option value="San Isidro Bolong Association" {{ old('nameof_farmers_ass_org_coop') == 'San Isidro Bolong Association' ? 'selected' : '' }}>San Isidro Bolong Association</option>
                  <option value="San Isidro Hybrid Inbrid Rice & Vegetable Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'San Isidro Hybrid Inbrid Rice & Vegetable Farmers Association' ? 'selected' : '' }}>San Isidro Hybrid Inbrid Rice & Vegetable Farmers Association</option>
                  <option value="Sibutat Curuan Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Sibutat Curuan Farmers Association' ? 'selected' : '' }}>Sibutat Curuan Farmers Association</option>
                  <option value="Sibutat Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Sibutat Farmers Association' ? 'selected' : '' }}>Sibutat Farmers Association</option>
                  <option value="Suguinan & Compania Bunguiao Irrigators Association" {{ old('nameof_farmers_ass_org_coop') == 'Suguinan & Compania Bunguiao Irrigators Association' ? 'selected' : '' }}>Suguinan & Compania Bunguiao Irrigators Association</option>
                  <option value="Tagasilay Lowland Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Tagasilay Lowland Farmers Association' ? 'selected' : '' }}>Tagasilay Lowland Farmers Association</option>
                  <option value="Talabaan Rice Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Talabaan Rice Farmers Association' ? 'selected' : '' }}>Talabaan Rice Farmers Association</option>
                  <option value="Taloptap Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Taloptap Farmers Association' ? 'selected' : '' }}>Taloptap Farmers Association</option>
                  <option value="Tamaraan  Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Tamaraan  Farmers Association' ? 'selected' : '' }}>Tamaraan  Farmers Association</option>
                  <option value="Tamion Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Tamion Farmers Association' ? 'selected' : '' }}>Tamion Farmers Association</option>
                  <option value="Tigbao Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Tigbao Farmers Association' ? 'selected' : '' }}>Tigbao Farmers Association</option>
                  <option value="Tindalo Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Tindalo Farmers Association' ? 'selected' : '' }}>Tindalo Farmers Association</option>
                  <option value="Toctobo Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'Toctobo Farmers Association' ? 'selected' : '' }}>Toctobo Farmers Association</option>
                  <option value="UC Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'UC Farmers Association' ? 'selected' : '' }}>UC Farmers Association</option>
                  <option value="UNILE Christian Farmers Association" {{ old('nameof_farmers_ass_org_coop') == 'UNILE Christian Farmers Association' ? 'selected' : '' }}>UNILE Christian Farmers Association</option>
                  <option value="Upper and Lower Quiniput Farmers Irrigation Association" {{ old('nameof_farmers_ass_org_coop') == 'Upper and Lower Quiniput Farmers Irrigation Association' ? 'selected' : '' }}>Upper and Lower Quiniput Farmers Irrigation Association</option>
                  <option value="add" {{ old('id_type') == 'add' ? 'selected' : '' }}>Add</option>
                 

                
                </select>
              @error('nameof_farmers_ass_org_coop')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              </div>

                  {{-- when  No selected this selection will appear --}}
              <div class="col-md-3 mb-3" id="NoFarmersGroup" style="display: none;font-size: 12px">
                <label for="YesInputSelected">Name of Farmers Ass/Org/Coop:</label>
                <select class="form-control @error('nameof_farmers_ass_org_coop') is-invalid @enderror" name="nameof_farmers_ass_org_coop"id="selectFgroups"onchange="checkfarmGroup()" aria-label="Floating label select e">
                  <option selected disabled>Select</option>
                  <option value="N/A" {{ old('nameof_farmers_ass_org_coop') == 'N/A' ? 'selected' : '' }}>N/A</option>
                  
                  
                
                </select>
              @error('nameof_farmers_ass_org_coop')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              </div>

              {{-- adding new name of farmers assoc,coop, org --}}
              <div class="col-md-3 mb-3" id="newFarmerGroupInput" style="display: none;">
                <label for="newFarmerGroupInput">Add New Here:</label>
                <input type="text" id="newFarmerGroupInput" class="form-control placeholder-text @error('add_FarmersGroup"') is-invalid @enderror"name="add_FarmersGroup" id="validationCustom02" placeholder="Enter farmers org/assoc/coop"  value="{{ old('add_FarmersGroup"') }}">
                @error('add_FarmersGroup"')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
             {{-- adding new name of farmers assoc,coop, org --}}
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom01">Name of Contact Person</label>
              <input type="text" class="form-control placeholder-text @error('name_contact_person') is-invalid @enderror" id="validationCustom01"name="name_contact_person"  placeholder="Name of Contact Person"  value="{{ old('name_contact_person') }}">
              @error('name_contact_person')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-expand" for="validationCustom02">Celphone/Tel.no</label>
              <input type="text" class="form-control placeholder-text @error('cp_tel_no') is-invalid @enderror" id="validationCustom02"name="cp_tel_no" placeholder="Celphone/Tel.no"  value="{{ old('cp_tel_no') }}" >
              @error('cp_tel_no')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
            </div>

            {{-- <div class="col-md-3 mb-3">
              <label class="form-label form-expand" style="color: green;">Upload Photo</label>
              <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01"name="image" accept=".png, .jpeg, .jpg">
          </div> --}}
          
   
          </div>
          
<div  class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button type="submit" class="btn btn-success me-md-2 btn-submit">Next</button>
</div>
          </form>
        
          
        </div>
      </div>
    </div>
  </div>
 
  



</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<script type="text/javascript">
  $(document).ready(function() {
      $(document).on('click', '.btn-submit', function(event){
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
                      className: "btn-success", // Add the success class to the button
                      closeModal: false // Prevent dialog from closing on confirmation
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

  // Function to handle successful form submission
  function handleFormSubmissionSuccess() {
      swal({
          title: "Personal Informations completed successfully!",
          text: "Thank you for your submission.",
          icon: "success",
      });
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
<script>
  // selecting add to no. of children
  function checkChildren() {
        var childrenSelect = document.getElementById("childrenSelect");
        var otherchilderInputContainer = document.getElementById("otherchilderInputContainer");
        if (childrenSelect.value === "Add") {
            otherchilderInputContainer.style.display = "block";
        } else {
            otherchilderInputContainer.style.display = "none";
        }
    }

// selecting a highest formal edu
function checkFormalEduc() {
        var selectEduc = document.getElementById("selectEduc");
        var otherformInputContainer = document.getElementById("otherformInputContainer");
        if (selectEduc.value === "Other") {
           otherformInputContainer.style.display = "block";
        } else {
           otherformInputContainer.style.display = "none";
        }
    }

    // ad  new farmers name of Org, Coop, Assoc
    function checkFarmerGrp() {
        var selectFarmgroups = document.getElementById("selectFarmgroups");
        var newFarmerGroupInput = document.getElementById("newFarmerGroupInput");
        if (selectFarmgroups.value === "add") {
           newFarmerGroupInput.style.display = "block";
        } else {
           newFarmerGroupInput.style.display = "none";
        }
    }
    


// selected a place of birth
function checkPlaceBirth() {
        var selectplacebrth = document.getElementById("selectplacebrth");
        var AddBirthInput = document.getElementById("AddBirthInput");
        if (selectplacebrth.value === "Add Place of Birth") {
           AddBirthInput.style.display = "block";
        } else {
           AddBirthInput.style.display = "none";
        }
    }

    // check the pwde when users click yes will  open new input box to add the pwd id no.
    function checkPWD() {
    var selectPWD = document.getElementById("selectPWD");
    var YesInputSelected = document.getElementById("YesInputSelected");
    var NoInputSelected = document.getElementById("NoInputSelected");

    if (selectPWD.value === "Yes") {
        YesInputSelected.style.display = "block";
        NoInputSelected.style.display = "none";
    } else if (selectPWD.value === "No") {
        NoInputSelected.style.display = "block";
        YesInputSelected.style.display = "none";
    } else {
        YesInputSelected.style.display = "none";
        NoInputSelected.style.display = "none";
    }
}
// check  mebership yes or no selections
function checkMmbership() {
    var selectMember = document.getElementById("selectMember");
    var YesFarmersGroup = document.getElementById("YesFarmersGroup");
    var NoFarmersGroup = document.getElementById("NoFarmersGroup");

    if (selectMember.value === "Yes") {
        YesFarmersGroup.style.display = "block";
        NoFarmersGroup.style.display = "none";
    } else if (selectMember.value === "No") {
        NoFarmersGroup.style.display = "block";
        YesFarmersGroup.style.display = "none";
    } else {
        YesFarmersGroup.style.display = "none";
        NoFarmersGroup.style.display = "none";
    }
}

// check the seleced government id
function CheckGoverniD() {
    var selectGov = document.getElementById("selectGov");
    var iDtypeSelected = document.getElementById("iDtypeSelected");
    var NoSelected = document.getElementById("NoSelected");

    if (selectGov.value === "Yes") {
        iDtypeSelected.style.display = "block";
        NoSelected.style.display = "none";
    } else if (selectGov.value === "No") {
        NoSelected.style.display = "block";
        iDtypeSelected.style.display = "none";
    } else {
        iDtypeSelected.style.display = "none";
        NoSelected.style.display = "none";
    }
}
// check selected GOV ID TYPE then input n/a
function checkIDtype() {
    var selectIDType = document.getElementById("selectIDType");
    var idNoInput = document.getElementById("idNoInput");
    var OthersInput = document.getElementById("OthersInput");
    var OtherIDInput = document.getElementById("OtherIDInput");

    if (selectIDType.value === "Driver License" || selectIDType.value === "Passport" || selectIDType.value === "Postal ID" || selectIDType.value === "Phylsys ID" || selectIDType.value === "PRC ID" || selectIDType.value === "Brgy. ID" || selectIDType.value === "Voters ID" || selectIDType.value === "Senior ID" || selectIDType.value === "PhilHealth ID" || selectIDType.value === "Tin ID" || selectIDType.value === "BIR ID") {
        idNoInput.style.display = "block";
        OthersInput.style.display = "none";
        OtherIDInput.style.display = "none";
    } else if (selectIDType.value === "add Id Type") {
        OthersInput.style.display = "block";
        OtherIDInput.style.display = "block";
        idNoInput.style.display = "none";
    } else {
        idNoInput.style.display = "none";
        OthersInput.style.display = "none";
        OtherIDInput.style.display = "none";
    }
}






// check selected in  civil status if  ist is single, married, widow ordivorced
function checkCivil() {
    var selectCivil = document.getElementById("selectCivil");
    var MariedInputSelected = document.getElementById("MariedInputSelected");
    var SinWidDevInput = document.getElementById("SinWidDevInput");

    if (selectCivil.value === "Maried") {
        MariedInputSelected.style.display = "block";
        SinWidDevInput.style.display = "none";
    } else if (selectCivil.value === "Single" || selectCivil.value === "Widow" || selectCivil.value === "Divorced") {
        SinWidDevInput.style.display = "block";
        MariedInputSelected.style.display = "none";
    } else {
        MariedInputSelected.style.display = "none";
        SinWidDevInput.style.display = "none";
    }
}




// adding new extend name when the users click  others 
function checkExtendN() {
        var selectExtendName = document.getElementById("selectExtendName");
        var OthersInputField = document.getElementById("OthersInputField");
        if (selectExtendName.value === "others") {
           OthersInputField.style.display = "block";
        } else {
           OthersInputField.style.display = "none";
        }
    }

    // adding new extend name when the users clicl  others 
function checkReligion() {
        var selectReligion = document.getElementById("selectReligion");
        var ReligionInputField = document.getElementById("ReligionInputField");
        if (selectReligion.value === "other") {
           ReligionInputField.style.display = "block";
        } else {
           ReligionInputField.style.display = "none";
        }
    }




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
                barangays = ["Taloptap", "Tindalo","Camino Nuevo,", "Tamion","Bataan","Tuktubo","Mialim","Lower Tigbao, Tictapul","Manguso","Inner Manguso","Bincul,Manguso","Sinalikway,Manguso","Upper Manguso","Dungcaan,Manguso", "Tamaraan, Manguso","Licomo"];
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
                barangays = ["Barangay Curuan 1", "Barangay Curuan 2"];
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














</script>


@endsection
