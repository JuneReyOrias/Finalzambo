@extends('admin.dashb')

@section('admin')
    @extends('layouts._footer-script')
    @extends('layouts._head')
    
    
    <style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
        
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
</style>
<div class="page-content">
    <div class="card-forms border rounded">

    
        <div class="card-forms border rounded">

            <div class="card-body">
              
              <div class="content">
                <form id="form"method="POST">
                    @csrf
        
                    <!-- Step 1: Personal Information -->
                    <div class="step active" id="step1"class="farm-info">
                        <h2>Step 1: Personal Information</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>a. Personal Info</h3>
                     <div class="user-details">
      
      <div class="input-box">
        <span class="details">First Name</span>
        <input type="text" class="form-control light-gray-placeholder @error('first_name') is-invalid @enderror" name="first_name" placeholder="First name"value="{{ old('first_name') }}" >
        @error('first_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>
      <div class="input-box">
        <span class="details">Middle Name</span>
        <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror" name="middle_name" placeholder="Middle name"value="{{ old('middle_name') }}" >
        @error('middle_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>
      <div class="input-box">
          <span class="details">Last Name</span>
          <input type="text" class="form-control light-gray-placeholder @error('last_name') is-invalid @enderror" name="last_name" placeholder="Lastname"value="{{ old('last_name') }}" >
          @error('last_name')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
        </div>
      <div class="input-box">
        <span class="details">Extension name</span>
        <select class="form-control light-gray-placeholder @error('extension_name') is-invalid @enderror"  name="extension_name"id="validationCustom01" aria-label="Floating label select e">
          <option selected disabled>Select</option>
          <option value="Sr." {{ old('extension_name') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
          <option value="Jr." {{ old('extension_name') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
          <option value="II" {{ old('extension_name') == 'II' ? 'selected' : '' }}>II</option>
          <option value="III." {{ old('extension_name') == 'III.' ? 'selected' : '' }}>III</option>
          <option value="N/A" {{ old('extension_name') == 'N/A' ? 'selected' : '' }}>N/A</option>
          <option value="others" {{ old('extension_name') == 'others' ? 'selected' : '' }}>others</option>
        </select>
      </div>
     
    
      
    </div>
                        <!-- Add other personal information fields -->
        
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                    <div class="step" id="step1.2"class="farm-info">
                        <h2>Step 1: Personal Information</h2><br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>b. Contact & Demographic Info</h3>
<div class="user-details">
    <div class="input-box">
    <span class="details">Country</span>
    <input type="text" class="form-control light-gray-placeholder @error('first_name') is-invalid @enderror" name="country" id="validationCustom01" value="Philippines" readonly >
    @error('first_name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
    <div class="input-box">
    <span class="details">Province</span>
    <input type="text" class="form-control light-gray-placeholder @error('last_name') is-invalid @enderror" name="province" id="validationCustom01" value="Zamboanga del sur" readonly >
    @error('last_name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
    <div class="input-box">
    <span class="details">City</span>
    <input type="text"name="email" class="form-control light-gray-placeholder @error('email') is-invalid @enderror" name="city" id="validationCustom01" value="Zamboanga City" readonly >
    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
    <div class="input-box">
    <span class="details">Agri-District</span>
    <select class="form-control light-gray-placeholder @error('agri_district') is-invalid @enderror"  name="agri_district"id="validationCustom01" aria-label="Floating label select e">
      <option selected disabled>Select Agri-District</option>
      <option value="ayala" {{ old('agri_district') == 'ayala' ? 'selected' : '' }}>Ayala Distict</option>
      <option value="tumaga" {{ old('agri_district') == 'tumaga' ? 'selected' : '' }}>Tumaga District</option>
      <option value="culianan" {{ old('agri_district') == 'culianan' ? 'selected' : '' }}>Culianan District</option>
      <option value="manicahan" {{ old('agri_district') == 'manicahan' ? 'selected' : '' }}>Manicahan District</option>
      <option value="curuan" {{ old('agri_district') == 'curuan' ? 'selected' : '' }}>Curuan District</option>
      <option value="vitali" {{ old('agri_district') == 'vitali' ? 'selected' : '' }}>Vitali District</option>
    </select>
    </div>
    <div class="input-box">
      <span class="details">Barangay</span>
      <select class="form-control light-gray-placeholder @error('barangay') is-invalid @enderror"  name="barangay"id="validationCustom01" aria-label="Floating label select e">
        <option selected disabled>Select </option>
        <option value="ayala" {{ old('barangay') == 'ayala' ? 'selected' : '' }}>Ayala Distict</option>
        <option value="tumaga" {{ old('barangay') == 'tumaga' ? 'selected' : '' }}>Tumaga District</option>
        <option value="culianan" {{ old('barangay') == 'culianan' ? 'selected' : '' }}>Culianan District</option>
        <option value="manicahan" {{ old('barangay') == 'manicahan' ? 'selected' : '' }}>Manicahan District</option>
        <option value="curuan" {{ old('barangay') == 'curuan' ? 'selected' : '' }}>Curuan District</option>
        <option value="vitali" {{ old('barangay') == 'vitali' ? 'selected' : '' }}>Vitali District</option>
      </select>
    </div>
    <div class="input-box">
        <span class="details">Street</span>
        <input type="text" name="street" id="street" class="form-control light-gray-placeholder @error('street') is-invalid @enderror" placeholder="Street" autocomplete="new-password" value="{{ old('street') }}" >
        @error('street')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="input-box">
        <span class="details">Zip Code</span>
        <select class="form-control light-gray-placeholder @error('zip_code') is-invalid @enderror"  name="zip_code"id="validationCustom01" aria-label="Floating label select e">
          <option selected disabled>Select</option>
          <option value="7000" {{ old('zip_code') == '7000' ? 'selected' : '' }}>7000</option>
        
        </select>
      </div>
    <div class="input-box">
    <span class="details">Contact No.</span>
    <input type="text" name="contact_no" id="contact_no" class="form-control light-gray-placeholder @error('contact_no') is-invalid @enderror" placeholder="Contact no." autocomplete="new-password" value="{{ old('contact_no') }}" >
    @error('contact_no')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
    <div class="input-box">
    <span class="details">Sex</span>
    <select class="form-control light-gray-placeholder" name="sex"id="validationCustom01" aria-label="Floating label select e">
      <option class="form-control light-gray-placeholder" selected disabled>Select sex</option>
      <option  class="form-control light-gray-placeholder" value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
      <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
      
    
    </select>
    </div>
    <div class="input-box">
      <span class="details">Religion</span>
      <select class="form-control light-gray-placeholder" name="religion"id="validationCustom01" aria-label="Floating label select e">
          <option selected disabled>Select</option>
          <option value="Roman Catholic" {{ old('religion') == 'Roman Catholic' ? 'selected' : '' }}>Roman Catholic</option>
          <option value="Iglesia Ni Cristo" {{ old('religion') == 'Iglesia Ni Cristo' ? 'selected' : '' }}>Iglesia Ni Cristo</option>
          <option value="Seventh-day Adventist" {{ old('religion') == 'Seventh-day Adventist' ? 'selected' : '' }}>Seventh-day Adventist</option>
          <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
          <option value="Born Again CHurch" {{ old('religion') == 'Born Again CHurch' ? 'selected' : '' }}>Born Again CHurch</option>
          <option value="N/A" {{ old('religion') == 'N/A' ? 'selected' : '' }}>N/A</option>
          <option value="other" {{ old('religion') == 'other' ? 'selected' : '' }}>other</option>
      </select>
    </div>
    <div class="input-box">
      <span class="details">Date of Birth</span>
      <input type="text" class="form-control light-gray-placeholder @error('contact_no') is-invalid @enderror"name="date_of_birth" id="datepicker" placeholder="Date of Birth"
      value="{{ old('date_of_birth') }}" data-input='true'> 
      @error('contact_no')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    <div class="input-box">
      <span class="details">Place of Birth</span>
      <select class="form-control light-gray-placeholder" name="role"id="validationCustom01" aria-label="Floating label select e">
        <option class="form-control light-gray-placeholder" selected disabled>Select</option>
        <option  class="form-control light-gray-placeholder" value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
        <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>agent</option>
        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>user</option>
      
      </select>
    </div>
    <div class="input-box">
      <span class="details">Civil Status</span>
      <select class="form-control light-gray-placeholder" name="role"id="validationCustom01" aria-label="Floating label select e">
        <option class="form-control light-gray-placeholder" selected disabled>Select role</option>
        <option  class="form-control light-gray-placeholder" value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
        <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>agent</option>
        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>user</option>
      
      </select>
    </div>
    <div class="input-box">
      <span class="details">No. of Children</span>
      <select class="form-control light-gray-placeholder" name="role"id="validationCustom01" aria-label="Floating label select e">
        <option class="form-control light-gray-placeholder" selected disabled>Select role</option>
        <option  class="form-control light-gray-placeholder" value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
        <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>agent</option>
        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>user</option>
      
      </select>
    </div>
    
    <div class="input-box">
      <span class="details">Mother's Maiden Name</span>
      <input type="text" name="mothers_maiden_name" id="mothers_maiden_name" class="form-control light-gray-placeholder @error('mothers_maiden_name') is-invalid @enderror" placeholder="Mother's Maiden Name" autocomplete="new-password" value="{{ old('mothers_maiden_name') }}" >
      @error('mothers_maiden_name')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    
    <div class="input-box">
      <span class="details">Highest Formal Education</span>
      <select class="form-control light-gray-placeholder" name="role"id="validationCustom01" aria-label="Floating label select e">
          <option value="No Formal Education" {{ old('highest_formal_education') == 'No Formal Education' ? 'selected' : '' }}>No Formal Education</option>
          <option value="Primary Education" {{ old('highest_formal_education') == 'Primary Education' ? 'selected' : '' }}>Primary Education</option>
          <option value="Secondary Education" {{ old('highest_formal_education') == 'Secondary Education' ? 'selected' : '' }}>Secondary Education</option>
          <option value="Vocational Training" {{ old('highest_formal_education') == 'Vocational Training' ? 'selected' : '' }}>Vocational Training</option>
          <option value="Bachelors Degree" {{ old('highest_formal_education') == 'Bachelors Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
          <option value="Masters Degree" {{ old('highest_formal_education') == 'Masters Degree' ? 'selected' : '' }}>Master's Degree</option>
          <option value="Doctorate" {{ old('highest_formal_education') == 'Doctorate' ? 'selected' : '' }}>Doctorate</option>
          <option value="Other" {{ old('highest_formal_education') == 'Other' ? 'selected' : '' }}>Other</option>
      
      </select>
    </div>
    
    <div class="input-box">
      <span class="details">Person with Disability</span>
      <select class="form-control light-gray-placeholder" name="sex"id="validationCustom01" aria-label="Floating label select e">
          <option selected disabled>Select</option>
          <option value="Yes" {{ old('person_with_disability') == 'Yes' ? 'selected' : '' }}>Yes</option>
          <option value="No" {{ old('person_with_disability') == 'No' ? 'selected' : '' }}>No</option>
          
      
      </select>
    </div>
    
    <div class="input-box"id="YesInputSelected" style="display: none;" >
      <span class="details">PWD ID No.</span>
      <input type="text" name="pwd_id_no" id="pwd_id_no" class="form-control light-gray-placeholder @error('pwd_id_no') is-invalid @enderror" placeholder="Mother's Maiden Name" autocomplete="new-password" value="{{ old('pwd_id_no') }}" >
      @error('pwd_id_no')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    
    
    <div class="input-box" id="NoInputSelected" style="display: none;">
      <span class="details">PWD ID No</span>
      <select class="form-control @error('pwd_id_no') is-invalid @enderror" name="pwd_id_no"id="selectFgroups"onchange="checkfarmGroup()" aria-label="Floating label select e">
          <option selected disabled>Select</option>
          <option value="N/A" {{ old('pwd_id_no') == 'N/A' ? 'selected' : '' }}>N/A</option>
          
          
        
        </select>
    </div>
    
    
    <div class="input-box">
      <span class="details">Government Issued ID</span>
      <select class="form-control @error('government_issued_id') is-invalid @enderror"  name="government_issued_id"id="selectGov"onchange="CheckGoverniD()" aria-label="Floating label select e">
          <option selected disabled>Select</option>
          <option value="Yes" {{ old('government_issued_id') == 'Yes' ? 'selected' : '' }}>Yes</option>
          <option value="No" {{ old('government_issued_id') == 'No' ? 'selected' : '' }}>No</option>
        
        </select>
    </div>
    
    <div class="input-box" id="iDtypeSelected" style="display: none;">
      <span class="details">Gov ID Type</span>
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
    <div class="input-box"  id="idNoInput" style="display: none;">
      <span class="details">Gov-ID no.</span>
      <input type="text" name="add_Idtype" id="add_Idtype" class="form-control light-gray-placeholder @error('add_Idtype') is-invalid @enderror" placeholder="gov. id no" autocomplete="new-password" value="{{ old('add_Idtype') }}" >
      @error('add_Idtype')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    
    <div class="input-box"  id="NoSelected" style="display: none;">
      <span class="details">Non-Gov ID</span>
      <input type="text" name="id_types" id="id_types" class="form-control light-gray-placeholder @error('id_types') is-invalid @enderror" placeholder="non-gov id" autocomplete="new-password" value="{{ old('id_types') }}" >
      @error('id_types')
      <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
    
    </div>
                        <!-- Add other personal information fields -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                    <div class="step farmer-info" id="step1.3">
                        <h2>Step 1: Personal Information</h2><br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                        <h3>c. Association Info</h3>
                          <div class="user-details">
<div class="input-box">
    <span class="details">Member of any Farmers Ass/Org/Coop</span>
    <select class="form-control @error('member_ofany_farmers_ass_org_coop') is-invalid @enderror" id="selectMember"onchange="checkMmbership()" name="member_ofany_farmers_ass_org_coop" aria-label="Floating label select e">
        <option selected disabled>Select</option>
        <option value="Yes" {{ old('member_ofany_farmers_ass_org_coop') == 'Yes' ? 'selected' : '' }}>Yes</option>
        <option value="No" {{ old('member_ofany_farmers_ass_org_coop') == 'No' ? 'selected' : '' }}>No</option>
      
      </select>
      @error('member_ofany_farmers_ass_org_coop')
      <div class="invalid-feedback">{{ $message }}</div>
  @enderror
  </div>
  <div class="input-box" id="YesFarmersGroup" style="display: none;font-size: 12px">
    <span class="details">Name of Farmers Ass/Org/Coop</span>
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
  <div class="input-box" id="NoFarmersGroup" style="display: none;font-size: 12px">
    <span class="details">Name of Farmers Ass/Org/Coop</span>
    <select class="form-control @error('nameof_farmers_ass_org_coop') is-invalid @enderror" name="nameof_farmers_ass_org_coop"id="selectFgroups"onchange="checkfarmGroup()" aria-label="Floating label select e">
        <option selected disabled>Select</option>
        <option value="N/A" {{ old('nameof_farmers_ass_org_coop') == 'N/A' ? 'selected' : '' }}>N/A</option>
        
        
      
      </select>
  </div>

  <div class="input-box" id="newFarmerGroupInput" style="display: none;">
    <span class="details">Add farmers org/assoc/Coop</span>
    <input type="text" class="form-control light-gray-placeholder @error('add_FarmersGroup') is-invalid @enderror" name="add_FarmersGroup" placeholder="Add farmers org/assoc/Coop"value="{{ old('add_FarmersGroup') }}" >
    @error('add_FarmersGroup')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
  </div>
<div class="input-box">
    <span class="details">Name of Contact Person</span>
    <input type="text" class="form-control light-gray-placeholder @error('name_contact_person') is-invalid @enderror" name="name_contact_person" placeholder="Enter your lastname"value="{{ old('name_contact_person') }}" >
    @error('name_contact_person')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
  </div>
  <div class="input-box">
    <span class="details">Celphone/Tel.no</span>
    <input type="text" class="form-control light-gray-placeholder @error('cp_tel_no') is-invalid @enderror" name="cp_tel_no" placeholder="Enter your lastname"value="{{ old('cp_tel_no') }}" >
    @error('cp_tel_no')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
  </div>
  <div class="input-box">
    <span class="details">Date of Interview</span>
    <input type="text" class="form-control light-gray-placeholder @error('contact_no') is-invalid @enderror"name="	date_interview" id="datepicker" placeholder="Date of interview"
    value="{{ old('date_of_birth') }}" data-input='true'> 
    @error('contact_no')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>



</div>
                       
                        <!-- Add other personal information fields -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                    <!-- Step 2: Farm Profile -->
                    <div class="step" id="step2" class="farm-info">
                        <h2>Step 2: Farm Profile</h2>
                        <div id="farmProfiles">
                            <!-- Sample Farm Profile -->
                            <div class="user-details">
                                <div class="input-box">
                                    <label for="tenurial_status_0">Tenurial Status:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][tenurial_status]" id="tenurial_status_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="rice_farm_address_0">Rice Farm Address:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][rice_farm_address]" id="rice_farm_address_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="no_of_years_as_farmers_0">Number of Years as Farmer:</label>
                                    <input type="number" class="form-control" name="farm_profiles[0][no_of_years_as_farmers]" id="no_of_years_as_farmers_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="gps_longitude_0">GPS Longitude:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][gps_longitude]" id="gps_longitude_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="gps_latitude_0">GPS Latitude:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][gps_latitude]" id="gps_latitude_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="total_physical_area_has_0">Total Physical Area (has):</label>
                                    <input type="number" class="form-control" name="farm_profiles[0][total_physical_area_has]" id="total_physical_area_has_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="rice_area_cultivated_has_0">Rice Area Cultivated (has):</label>
                                    <input type="number" class="form-control" name="farm_profiles[0][rice_area_cultivated_has]" id="rice_area_cultivated_has_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="land_title_no_0">Land Title No:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][land_title_no]" id="land_title_no_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="lot_no_0">Lot No:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][lot_no]" id="lot_no_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="area_prone_to_0">Area Prone To:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][area_prone_to]" id="area_prone_to_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="ecosystem_0">Ecosystem:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][ecosystem]" id="ecosystem_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="rsba_register_0">RSBA Register:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][rsba_register]" id="rsba_register_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="pcic_insured_0">PCIC Insured:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][pcic_insured]" id="pcic_insured_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="government_assisted_0">Government Assisted:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][government_assisted]" id="government_assisted_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="source_of_capital_0">Source of Capital:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][source_of_capital]" id="source_of_capital_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="remarks_recommendation_0">Remarks/Recommendation:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][remarks_recommendation]" id="remarks_recommendation_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="oca_district_office_0">OCA District Office:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][oca_district_office]" id="oca_district_office_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="name_technicians_0">Name of Technicians:</label>
                                    <input type="text" class="form-control" name="farm_profiles[0][name_technicians]" id="name_technicians_0" required>
                                </div>
                                <div class="input-box">
                                    <label for="date_interview_0">Date of Interview:</label>
                                    <input type="date" class="form-control" name="farm_profiles[0][date_interview]" id="date_interview_0" required>
                                </div>
                    
                                <div id="cropFarms_0">
                                    <div class="user-details">
                                        <div class="input-box">
                                            <label for="crop_type_0_0">Crop Type:</label>
                                            <input type="text" class="form-control" name="farm_profiles[0][crop_farms][0][crop_type]" id="crop_type_0_0" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="crop_area_0_0">Crop Area:</label>
                                            <input type="number" class="form-control" name="farm_profiles[0][crop_farms][0][crop_area]" id="crop_area_0_0" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="type_rice_variety_0_0">Rice Variety Type:</label>
                                            <input type="text" class="form-control" name="farm_profiles[0][crop_farms][0][type_rice_variety]" id="type_rice_variety_0_0" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="prefered_variety_0_0">Preferred Variety:</label>
                                            <input type="text" class="form-control" name="farm_profiles[0][crop_farms][0][prefered_variety]" id="prefered_variety_0_0" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="plant_schedule_wetseason_0_0">Plant Schedule (Wet Season):</label>
                                            <input type="text" class="form-control" name="farm_profiles[0][crop_farms][0][plant_schedule_wetseason]" id="plant_schedule_wetseason_0_0" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="plant_schedule_dryseason_0_0">Plant Schedule (Dry Season):</label>
                                            <input type="text" class="form-control" name="farm_profiles[0][crop_farms][0][plant_schedule_dryseason]" id="plant_schedule_dryseason_0_0" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="no_of_cropping_yr_0_0">Number of Cropping Years:</label>
                                            <input type="number" class="form-control" name="farm_profiles[0][crop_farms][0][no_of_cropping_yr]" id="no_of_cropping_yr_0_0" required>
                                        </div>
                                        <div class="input-box">
                                            <label for="yield_kg_ha_0_0">Yield (kg/ha):</label>
                                            <input type="number" class="form-control" name="farm_profiles[0][crop_farms][0][yield_kg_ha]" id="yield_kg_ha_0_0" required>
                                        </div>
                                        <!-- Add other fields as needed -->
                                        <button type="button" class="btn btn-danger" onclick="removeCropFarm(0, 0)">Remove Crop Farm</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="addCropFarm(0)">Add Another Crop Farm</button>
                                <button type="button" class="btn btn-danger mt-2" onclick="removeFarmProfile(0)">Remove Farm Profile</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addFarmProfile()">Add Another Farm Profile</button>
                        <button type="button" class="btn btn-primary mt-2" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary mt-2" onclick="nextStep()">Next</button>
                    </div>
                    
                    <!-- Step 3: Additional Steps -->
                    <div class="step" id="step3">
                        <h2>Step 3: Productions</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>a. Seed info and Usage details</h3>
                 <div class="user-details">
                        <div class="input-box">
                            <span class="details">Cropping no.</span>
                            <input type="text" class="form-control light-gray-placeholder @error('cropping_no') is-invalid @enderror" name="cropping_no" placeholder="First name"value="{{ old('cropping_no') }}" >
                            @error('cropping_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                          </div>
                    <div class="input-box">
                        <span class="details">Seeds Typed Variety</span>
                        <input type="text" class="form-control light-gray-placeholder @error('seeds_typed_variety') is-invalid @enderror" name="seeds_typed_variety" placeholder="First name"value="{{ old('seeds_typed_variety') }}" >
                        @error('seeds_typed_variety')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Seeds Used in Kg</span>
                        <input type="text" class="form-control light-gray-placeholder @error('seeds_used_in_kg') is-invalid @enderror" name="seeds_used_in_kg" placeholder="Middle name"value="{{ old('seeds_used_in_kg') }}" >
                        @error('seeds_used_in_kg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
      
      <div class="input-box">
        <span class="details">Seeds Source</span>
        <select class="form-control light-gray-placeholder @error('seed_source') is-invalid @enderror"   id="seed_source"onchange="checkSeedsrc()" name="seed_source" aria-label="Floating label select e">
            <option selected disabled>Select</option>
            <option value="Government Subsidy" {{ old('seed_source') == 'Government Subsidy' ? 'selected' : '' }}>Government Subsidy</option>
            <option value="Traders" {{ old('seed_source') == 'Traders' ? 'selected' : '' }}>Traders</option>
            <option value="Own" {{ old('seed_source') == 'Own' ? 'selected' : '' }}>Own</option>
            <option value="Add" {{ old('seed_source') == 'Add' ? 'selected' : '' }}>Add</option>
        </select>
      </div>
    
    <div class="input-box" id="SeedSrcInput" style="display: none;">
        <span class="details">Add prefer seed source</span>
        <input type="text" id="SourceCapitalInputField"  class="form-control light-gray-placeholder @error('seeds_used_in_kg') is-invalid @enderror" name="add_seedsource" placeholder=" Enter source of Capital" value="{{ old('add_seedsource') }}">
        @error('seeds_used_in_kg')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    <div class="input-box">
        <span class="details">No of Fertilizer used in Bags</span>
        <input type="number" class="form-control light-gray-placeholder @error('no_of_fertilizer_used_in_bags') is-invalid @enderror" name="no_of_fertilizer_used_in_bags" placeholder="Middle name"value="{{ old('no_of_fertilizer_used_in_bags') }}" >
        @error('no_of_fertilizer_used_in_bags')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
    
    <div class="input-box">
        <span class="details">No of pesticides used in L/kg</span>
        <input type="number" class="form-control light-gray-placeholder @error('no_of_fertilizer_used_in_bags') is-invalid @enderror" name="no_of_fertilizer_used_in_bags" placeholder="Middle name"value="{{ old('no_of_fertilizer_used_in_bags') }}" >
        @error('no_of_fertilizer_used_in_bags')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    <div class="input-box">
        <span class="details">No of Insecticides used in L</span>
        <input type="number" class="form-control light-gray-placeholder @error('no_of_insecticides_used_in_l') is-invalid @enderror" name="no_of_insecticides_used_in_l" placeholder="Middle name"value="{{ old('no_of_insecticides_used_in_l') }}" >
        @error('no_of_insecticides_used_in_l')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>
</div>
    
  
                        <!-- Add your content for Step 3 -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
        
                    <!-- Step 4: Additional Steps -->
                    <div class="step" id="step3.1">
                        <h2>Step 3: Productions</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>b. Crop Planting Details</h3>
                     <div class="user-details">
      
      <div class="input-box">
        <span class="details">Area Planted</span>
        <input type="text" class="form-control light-gray-placeholder @error('area_planted') is-invalid @enderror" name="area_planted" placeholder="area planted"value="{{ old('area_planted') }}" >
        @error('area_planted')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>
      <div class="input-box">
        <span class="details">Date Planted</span>
        <input type="text" class="form-control light-gray-placeholder @error('date_planted') is-invalid @enderror" name="date_planted"placeholder="date planted"
        value="{{ old('date_planted') }}" id="datepicker" data-input='true'>
        @error('date_planted')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>
      <div class="input-box">
          <span class="details">Date Harvested</span>
          <input type="text" class="form-control light-gray-placeholder @error('date_harvested') is-invalid @enderror" name="date_harvested" id="datepicker" placeholder="date harvested"
          value="{{ old('date_harvested') }}" data-input='true' >
          @error('date_harvested')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
        </div>
        <div class="input-box">
            <span class="details">Yield (tons/kg)</span>
            <input type="text" class="form-control light-gray-placeholder @error('yield_tons_per_kg') is-invalid @enderror" name="yield_tons_per_kg" placeholder="yield tons/kg"value="{{ old('yield_tons_per_kg') }}" >
            @error('yield_tons_per_kg')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>
          <div class="input-box">
            <span class="details">Unit Price of Palay per kg</span>
            <input type="text" class="form-control light-gray-placeholder @error('unit_price_palay_per_kg') is-invalid @enderror" name="unit_price_palay_per_kg" placeholder="Unit Price of Palay per kg"value="{{ old('unit_price_palay_per_kg') }}" >
            @error('unit_price_palay_per_kg')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>

          <div class="input-box">
            <span class="details">Unit price of Rice/kgs(PHP)</span>
            <input type="text" class="form-control light-gray-placeholder @error('unit_price_rice_per_kg') is-invalid @enderror" name="unit_price_rice_per_kg" placeholder="Unit Price of rice per kg"value="{{ old('unit_price_rice_per_kg') }}" >
            @error('unit_price_rice_per_kg')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>

          
          <div class="input-box">
            <span class="details">Type of Product</span>
            <input type="text" class="form-control light-gray-placeholder @error('type_of_product') is-invalid @enderror" name="type_of_product" placeholder="Unit Price of rice per kg"value="{{ old('type_of_product') }}" >
            @error('type_of_product')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>
      <div class="input-box">
        <span class="details">Sold To</span>
        <select class="form-control light-gray-placeholder @error('sold_to') is-invalid @enderror"  name="extension_name"id="validationCustom01" aria-label="Floating label select e">
          <option selected disabled>Select</option>
          <option value="Palay" {{ old('sold_to') == 'Palay' ? 'selected' : '' }}>Palay</option>
        <option value="Rice" {{ old('sold_to') == 'Rice' ? 'selected' : '' }}>Rice</option>
        </select>
      </div>
      <div class="input-box" id="PalayInput" style="display: none;">
        <span class="details">If palay milled where?</span>
        <input type="text" id="OthersInput" class="form-control light-gray-placeholder @error('type_of_product') is-invalid @enderror" id="sold_to"onchange="checkSoldTo()" name="sold_to" aria-label="Floating label select e" >
        @error('type_of_product')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>
   
    <div class="input-box">
      <span class="details">If palay milled where?</span>
      <select class="form-control light-gray-placeholder @error('if_palay_milled_where') is-invalid @enderror"  id="if_palay_milled_where"onchange="checkSoldTo()" name="if_palay_milled_where" aria-label="Floating label select e">
        <option selected disabled>Select</option>
        <option value="N/A" {{ old('sold_to') == 'N/A' ? 'selected' : '' }}>N/A</option>
      </select>
    </div>

    <div class="input-box">
        <span class="details">Gross Income (Palay)PHP</span>
        <input type="text" class="form-control light-gray-placeholder @error('gross_income_palay') is-invalid @enderror" name="gross_income_palay" placeholder="gross income palay"value="{{ old('gross_income_palay') }}" >
        @error('gross_income_palay')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>

      <div class="input-box">
        <span class="details">Gross Income (Rice)PHP</span>
        <input type="text" class="form-control light-gray-placeholder @error('gross_income_rice') is-invalid @enderror" name="gross_income_rice" placeholder="gross income rice"value="{{ old('gross_income_rice') }}" >
        @error('gross_income_rice')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>
    </div>
      
                        <!-- Add your content for Step 4 -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                            <!-- Step 4: Additional Steps -->
                            <div class="step" id="step4">
                                <h2>Step 4: Fixed Cost</h2>
                                <br>
                                <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                        <h3>Farmers Fixed Cost</h3>
                             <div class="user-details">
              
              
             
               
                  
        
                  
        
                  
              <div class="input-box">
                <span class="details">Particular (Fixed Cost)</span>
                <select class="form-control light-gray-placeholder @error('particular') is-invalid @enderror"  name="particular" id="selectParticular" onchange="checkParticular()" aria-label="label select e">
                    <option value="Land Rental Cost" {{ old('particular') == 'Land Rental' ? 'selected' : '' }}>Land Rental</option>
                  <option value="Land Ownership Cost" {{ old('particular') == 'Land Ownership Cost' ? 'selected' : '' }}>Land Ownership Cost</option>
                  <option value="Equipment Costs" {{ old('particular') == 'Equipment Costs' ? 'selected' : '' }}>Equipment Costs</option>
                  <option value="Infrastructure Costs" {{ old('particular') == 'Infrastructure Costs' ? 'selected' : '' }}>Infrastructure Costs</option>
                  <option value="Other" {{ old('particular') == 'Other' ? 'selected' : '' }}>Others</option>
              </select>
              </div>
              <div class="input-box" id="ParticularInput" style="display: none;">
                <span class="details">Others(Input here)</span>
                <input type="text"  id="ParticularInputField"class="form-control light-gray-placeholder @error('type_of_product') is-invalid @enderror" name="Add_Particular" placeholder=" Enter particular(fixed cost)" value="{{ old('Add_Particular') }}">
                @error('type_of_product')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
           
            
        
            <div class="input-box">
                <span class="details">No. of Has</span>
                <input type="text" class="form-control light-gray-placeholder @error('gross_income_palay') is-invalid @enderror" name="no_of_ha" id="no_of_ha" placeholder="Enter No. of Has" value="{{ old('no_of_ha') }}">
                @error('gross_income_palay')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
        
              <div class="input-box">
                <span class="details">Cost/Has(Has)PHP</span>
                <input type="text" class="form-control light-gray-placeholder @error('gross_income_rice') is-invalid @enderror"name="cost_per_ha" id="cost_per_ha" placeholder="Enter Cost/Has" value="{{ old('cost_per_ha') }}" >
                @error('gross_income_rice')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
              <div class="input-box">
                <span class="details">Total Amount PHP</span>
                <input type="text" class="form-control light-gray-placeholder @error('gross_income_rice') is-invalid @enderror" name="total_amount" id="total_amount" placeholder="Enter total amount" value="{{ old('total_amount') }}" >
                @error('gross_income_rice')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
            </div>
              
                                <!-- Add your content for Step 4 -->
                                <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                            </div>
                    <!-- Step 5: Additional Steps -->
                    <div class="step" id="step5">
                        <h2>Step 5: Machineries Used</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>a.Plowing Machineries </h3>
                     <div class="user-details">
      
                        <div class="input-box">
                            <span class="details">Plowing Machineries Used</span>
                            <select class="form-control light-gray-placeholder @error('harro_ownership_status') is-invalid @enderror"  name="harro_ownership_status" id="selectPlowing" onchange="checkPlowing()" aria-label="label select e">
                              <option selected disabled>Select</option>
                              <option value="Hand Tractor" {{ old('harro_ownership_status') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                              <option value="Four-Wheel Tractors" {{ old('harro_ownership_status') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                              <option value="Compact Tractors:" {{ old('harro_ownership_status') == 'Compact Tractors:' ? 'selected' : '' }}>Compact Tractors:</option>
                              <option value="Rice Transplanters" {{ old('harro_ownership_status') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                              <option value="Crawler Tractors" {{ old('harro_ownership_status') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                              <option value="OthersPlowing" {{ old('harro_ownership_status') == 'OthersPlowing' ? 'selected' : '' }}>Others</option>
                            </select>
                          </div>
                          <div class="input-box" id="PlowingStatusInput" style="display: none;">
                            <span class="details">Others(Input here)</span>
                            <input type="text"  id="PlowingStatusInputField" class="form-control light-gray-placeholder @error('type_of_product') is-invalid @enderror"  name="add_PlowingStatus" placeholder=" Enter ownership status" value="{{ old('add_PlowingStatus') }}">
                            @error('type_of_product')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                          </div>
                          <div class="input-box">
                            <span class="details">Ownership Status</span>
                            <select class="form-control light-gray-placeholder @error('plowing_machineries_used') is-invalid @enderror"  name="plo_ownership_status" id="selectPlowingStatus" onchange="checkPlowingStatus()" aria-label="label select e">
                              <option selected disabled>Select</option>
                              <option value="Own" {{ old('plo_ownership_status') == 'Own' ? 'selected' : '' }}>Own</option>
                              <option value="Rent" {{ old('plo_ownership_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                              <option value="Other" {{ old('plo_ownership_status') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                          </div>
      <div class="input-box" id="PlowingStatusInput" style="display: none;">
        <span class="details">Other(input here)</span>
        <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"id="PlowingStatusInputField" name="add_PlowingStatus" placeholder=" Enter ownership status" value="{{ old('add_PlowingStatus') }}" >
        @error('middle_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
      </div>
      <div class="input-box">
          <span class="details">No. of Plowing</span>
          <input type="text" class="form-control light-gray-placeholder @error('last_name') is-invalid @enderror"name="no_of_plowing" id="noPlowing" placeholder="Enter no. of plowing" value="{{ old('no_of_plowing') }}" >
          @error('last_name')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
        </div>
        <div class="input-box">
            <span class="details">Cost per Plowing</span>
            <input type="text" class="form-control light-gray-placeholder @error('plowing_cost') is-invalid @enderror"name="plowing_cost" id="plowingperCostInput" placeholder="Enter plowing per cost" value="{{ old('plowing_cost') }}">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>

          <div class="input-box">
            <span class="details">Total Plowing Cost</span>
            <input type="text" class="form-control light-gray-placeholder @error('last_name') is-invalid @enderror"name="plowing_cost" id="plowingCostInput" placeholder="Enter plowing cost" value="{{ old('plowing_cost') }}">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>
    
    </div>
    
      
                        <!-- Add your content for Step 5 -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>


                    <!-- Step 5: Additional Steps -->
                    <div class="step" id="step5.1">
                        <h2>Step 5: Machineries Used</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>b.Harrowing Machineries </h3>
                     <div class="user-details">
      
                        <div class="input-box">
                            <span class="details">Harrowing Machineries Used</span>
                            <select class="form-control light-gray-placeholder @error('harrowing_machineries_used') is-invalid @enderror"  name="harrowing_machineries_used" id="selectPlowing" onchange="checkPlowing()" aria-label="label select e">
                              <option selected disabled>Select</option>
                              <option value="Hand Tractor" {{ old('harrowing_machineries_used') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                              <option value="Four-Wheel Tractors" {{ old('harrowing_machineries_used') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                              <option value="Compact Tractors:" {{ old('harrowing_machineries_used') == 'Compact Tractors:' ? 'selected' : '' }}>Compact Tractors:</option>
                              <option value="Rice Transplanters" {{ old('harrowing_machineries_used') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                              <option value="Crawler Tractors" {{ old('harrowing_machineries_used') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                              <option value="OthersPlowing" {{ old('harrowing_machineries_used') == 'OthersPlowing' ? 'selected' : '' }}>Others</option>
                            </select>
                          </div>
                          <div class="input-box" id="HarrowingmachineriesInput" style="display: none;">
                            <span class="details">Others(Input here)</span>
                            <input type="text"  id="HarrowingmachineriesInputField" class="form-control light-gray-placeholder @error('type_of_product') is-invalid @enderror"  name="Add_HarrowingMachineries" placeholder=" Enter harrowing machineries used" value="{{ old('Add_HarrowingMachineries') }}">
                            @error('type_of_product')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                          </div>
                          <div class="input-box">
                            <span class="details">Ownership Status</span>
                            <select class="form-control light-gray-placeholder @error('harro_ownership_status') is-invalid @enderror"  name="plo_ownership_status" id="selectPlowingStatus" onchange="checkPlowingStatus()" aria-label="label select e">
                              <option selected disabled>Select</option>
                              <option value="Own" {{ old('plo_ownership_status') == 'Own' ? 'selected' : '' }}>Own</option>
                              <option value="Rent" {{ old('plo_ownership_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                              <option value="Other" {{ old('plo_ownership_status') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                          </div>
    
      <div class="input-box">
          <span class="details">No. of Harrowing</span>
          <input type="text" class="form-control light-gray-placeholder @error('last_name') is-invalid @enderror"name="no_of_harrowing" id="noHarrowing" placeholder="Enter no. of harrowing" value="{{ old('no_of_harrowing') }}" >
          @error('last_name')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
        </div>
        <div class="input-box">
            <span class="details">Cost per Harrowing</span>
            <input type="text" class="form-control light-gray-placeholder @error('plowing_cost') is-invalid @enderror"name="harrowing_cost" id="costPerHarrowingInput" placeholder="Enter no. of harrowing">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>

          <div class="input-box">
            <span class="details">Total Harrowing Cost</span>
            <input type="text" class="form-control light-gray-placeholder @error('harrowing_cost_total') is-invalid @enderror"name="harrowing_cost" id="harrowingCostInput" placeholder="Enter harrowing cost">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>
    
    </div>
    
      
                        <!-- Add your content for Step 5 -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
    

                    <div class="step" id="step5.2">
                        <h2>Step 5: Machineries Used</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>b.Harvesting Machineries </h3>
                     <div class="user-details">
      
                        <div class="input-box">
                            <span class="details">Harvesting Machineries Used</span>
                            <select class="form-control light-gray-placeholder @error('harrowing_machineries_used') is-invalid @enderror"  name="harrowing_machineries_used" id="selectPlowing" onchange="checkPlowing()" aria-label="label select e">
                              <option selected disabled>Select</option>
                              <option value="Hand Tractor" {{ old('harrowing_machineries_used') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                              <option value="Four-Wheel Tractors" {{ old('harrowing_machineries_used') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                              <option value="Compact Tractors:" {{ old('harrowing_machineries_used') == 'Compact Tractors:' ? 'selected' : '' }}>Compact Tractors:</option>
                              <option value="Rice Transplanters" {{ old('harrowing_machineries_used') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                              <option value="Crawler Tractors" {{ old('harrowing_machineries_used') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                              <option value="OthersPlowing" {{ old('harrowing_machineries_used') == 'OthersPlowing' ? 'selected' : '' }}>Others</option>
                            </select>
                          </div>
                          <div class="input-box" id="HarrowingmachineriesInput" style="display: none;">
                            <span class="details">Others(Input here)</span>
                            <input type="text"  id="HarrowingmachineriesInputField" class="form-control light-gray-placeholder @error('type_of_product') is-invalid @enderror"  name="Add_HarrowingMachineries" placeholder=" Enter harrowing machineries used" value="{{ old('Add_HarrowingMachineries') }}">
                            @error('type_of_product')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                          </div>
                          <div class="input-box">
                            <span class="details">Ownership Status</span>
                            <select class="form-control light-gray-placeholder @error('harro_ownership_status') is-invalid @enderror"  name="plo_ownership_status" id="selectPlowingStatus" onchange="checkPlowingStatus()" aria-label="label select e">
                              <option selected disabled>Select</option>
                              <option value="Own" {{ old('plo_ownership_status') == 'Own' ? 'selected' : '' }}>Own</option>
                              <option value="Rent" {{ old('plo_ownership_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                              <option value="Other" {{ old('plo_ownership_status') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                          </div>
    
      <div class="input-box">
          <span class="details">No. of Harvesting</span>
          <input type="text" class="form-control light-gray-placeholder @error('last_name') is-invalid @enderror"name="no_of_harrowing" id="noHarrowing" placeholder="Enter no. of harrowing" value="{{ old('no_of_harrowing') }}" >
          @error('last_name')
          <div class="invalid-feedback">{{ $message }}</div>
      @enderror
        </div>
        <div class="input-box">
            <span class="details">Cost per Harvesting</span>
            <input type="text" class="form-control light-gray-placeholder @error('plowing_cost') is-invalid @enderror"name="harrowing_cost" id="costPerHarrowingInput" placeholder="Enter no. of harrowing">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>

          <div class="input-box">
            <span class="details">Total Harvesting</span>
            <input type="text" class="form-control light-gray-placeholder @error('harrowing_cost_total') is-invalid @enderror"name="harrowing_cost" id="harrowingCostInput" placeholder="Enter harrowing cost">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
          </div>
    
    </div>
    
      
                        <!-- Add your content for Step 5 -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
        
                    <!-- Step 6: Additional Steps -->
                    <div class="step" id="step6">
                        <h2>Step 6: Variable Cost</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>a. Seeds</h3>
                     <div class="user-details">
          <div class="input-box" >
        <span class="details">Seed Variety</span>
        <select class="form-control light-gray-placeholder @error('seed_type') is-invalid @enderror"  name="seed_type" id="selectseedVariety" onchange="checkseedVariety()" aria-label="label select e">
          <option selected disabled>Select</option>
          <option value="Inbred Rice Seeds" {{ old('seed_type') == 'Inbred Rice Seeds' ? 'selected' : '' }}>Inbred Rice Seeds</option>
          <option value="Hybrid Rice Seeds" {{ old('seed_type') == 'Hybrid Rice Seeds' ? 'selected' : '' }}>Hybrid Rice Seeds</option>
          <option value="N/A" {{ old('seed_type') == 'N/A' ? 'selected' : '' }}>N/A</option>

          <option value="OtherseedVariety" {{ old('seed_type') == 'OtherseedVariety' ? 'selected' : '' }}>Others</option>
        </select>
      </div>

      <div class="input-box"id="OthersInput" style="display: none;">
        <span class="details">Others(input here)</span>
        <input type="text"  id="OthersInputField" class="form-control light-gray-placeholder" name="AddRiceVariety" placeholder=" Enter rice seed" variety value="{{ old('AddRiceVariety') }}">
      
      </div>
  {{-- inbred serlcet variety --}}
      <div class="input-box" id="seedInput" style="display: none;">
        <span class="details">Seed Name</span>
        <select class="form-control light-gray-placeholder @error('seed_name') is-invalid @enderror"  name="seed_name" id="selectseedName" onchange="checkseedName()" aria-label="label select e">
          <option selected disabled>Select</option>
          <option value="NSIC Rc222" {{ old('seed_name') == 'NSIC Rc222' ? 'selected' : '' }}>NSIC Rc222</option>
          <option value="NSIC Rc18" {{ old('seed_name') == 'NSIC Rc18' ? 'selected' : '' }}>NSIC Rc18</option>
         
          <option value="NSIC Rc160" {{ old('seed_name') == 'NSIC Rc160' ? 'selected' : '' }}>NSIC Rc160</option>
          <option value="PSB Rc82" {{ old('seed_name') == 'PSB Rc82' ? 'selected' : '' }}>PSB Rc82</option>
          <option value="OtherseedName" {{ old('seed_name') == 'OtherseedName' ? 'selected' : '' }}>Others</option>
        </select>
      </div>
     {{-- hybrid --}}
      <div class="input-box" id="seedInput" style="display: none;">
        <span class="details">Seed Name</span>
        <select class="form-control light-gray-placeholder @error('seed_name') is-invalid @enderror"  name="seed_name" id="selectseedVarie" onchange="checkseedVarie()" aria-label="label select e">
          <option selected disabled>Select</option>
          <option value="NSIC Rc298" {{ old('seed_name') == 'NSIC Rc298' ? 'selected' : '' }}>NSIC Rc298</option>
          <option value="NSIC RC 262H (MESTISO 38)" {{ old('seed_name') == 'NSIC RC 262H (MESTISO 38)' ? 'selected' : '' }}>NSIC RC 262H (MESTISO 38)</option>
          <option value="NSIC RC 408H (MESTISO 68)" {{ old('seed_name') == 'NSIC RC 408H (MESTISO 68)' ? 'selected' : '' }}>NSIC RC 408H (MESTISO 68)</option>
          <option value="OtherseedVarie" {{ old('seed_name') == 'OtherseedVarie' ? 'selected' : '' }}>Others</option>
        </select>
      </div>
      
      <div class="input-box" id="HybridNameInput" style="display: none;">
          <span class="details">Others(input here)</span>
          <input type="text" id="HybridNameInputField" class="form-control light-gray-placeholder"  name="add_newInbreed" placeholder=" Enter seed name" >
        
        </div>

        <div class="input-box" >
            <span class="details">Unit</span>
            <input type="text" id="HybridNameInputField" class="form-control light-gray-placeholder"  name="unit" id="validationCustom01" placeholder="Enter unit" value="{{ old('unit') }}" >
          
          </div>

          <div class="input-box" >
            <span class="details">Quantity </span>
            <input type="text"class="form-control light-gray-placeholder"   name="quantity" id="quantityInput" placeholder="Enter quantity" value="{{ old('quantity') }}"  >
          
          </div>

          <div class="input-box" >
            <span class="details">Unit Price(PHP)</span>
            <input type="text"class="form-control light-gray-placeholder"  name="unit_price" id="unitPriceInput" placeholder="Enter unit price" value="{{ old('unit_price') }}" >
          
          </div>
          <div class="input-box" >
            <span class="details">Total Seed Cost(PHP)</span>
            <input type="text"class="form-control light-gray-placeholder"  name="total_seed_cost" id="totalSeedCostInput" placeholder="Enter total seed cost" value="{{ old('total_seed_cost') }}">
          
          </div>
        </div>
        <br>
          <h3>b. Labor</h3><br>

          <div class="user-details">
          <div class="input-box" >
            <span class="details">No of Person</span>
            <input type="text"class="form-control light-gray-placeholder" name="no_of_person" id="quantityInput" placeholder="Enter no_of_person" value="{{ old('no_of_person') }}">
          
          </div>

          <div class="input-box" >
            <span class="details">Rate per Person</span>
            <input type="text"class="form-control light-gray-placeholder" name="rate_per_person" id="unitPriceInput" placeholder="Enter rate/person" value="{{ old('rate_per_person') }}" >
          
          </div>
          <div class="input-box" >
            <span class="details">Total Labor Cost</span>
            <input type="text"class="form-control light-gray-placeholder" name="total_labor_cost" id="totalLaborCostInput" placeholder="Enter total labor cost" value="{{ old('total_labor_cost') }}" >
          
          </div>
    </div>
    
      
                        <!-- Add your content for Step 6 -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
        
                    <!-- Step 7: Loan Information -->
                    <div class="step" id="step7">
                        <h2>Step6: Variable Cost</h2>
                        <br>
                        <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                <h3>c. Fertilizers </h3>
                     <div class="user-details">
          <div class="input-box" >
        <span class="details">Name Of Fertilizer</span>
        <select class="form-control light-gray-placeholder @error('seed_type') is-invalid @enderror"  name="name_of_fertilizer" id="selectpostharvest" onchange="checkpostharvest()" aria-label="label select e">
          <option selected disabled>Select</option>
          <option value="Nitrogen Fertilizers" {{ old('name_of_fertilizer') == 'Nitrogen Fertilizers' ? 'selected' : '' }}>Nitrogen Fertilizers</option>
          <option value="Phosphorus Fertilizers" {{ old('name_of_fertilizer') == 'Phosphorus Fertilizers' ? 'selected' : '' }}>Phosphorus Fertilizers</option>
          <option value="Potassium Fertilizers" {{ old('name_of_fertilizer') == 'Potassium Fertilizers' ? 'selected' : '' }}>Potassium Fertilizers</option>
          <option value="Compound Fertilizers" {{ old('name_of_fertilizer') == 'Compound Fertilizers' ? 'selected' : '' }}>Compound Fertilizers</option>
          <option value="Organic Fertilizers" {{ old('name_of_fertilizer') == 'Organic Fertilizers' ? 'selected' : '' }}>Organic Fertilizers</option>
          <option value="Slow-Release Fertilizers" {{ old('name_of_fertilizer') == 'Slow-Release Fertilizers' ? 'selected' : '' }}>Slow-Release Fertilizers</option>
          <option value="Micronutrient Fertilizers" {{ old('name_of_fertilizer') == 'Micronutrient Fertilizers' ? 'selected' : '' }}>Micronutrient Fertilizers</option>
          <option value="Liquid Fertilizers" {{ old('name_of_fertilizer') == 'Liquid Fertilizers' ? 'selected' : '' }}>Liquid Fertilizers</option>
          <option value="other" {{ old('name_of_fertilizer') == 'other' ? 'selected' : '' }}>other</option>
         
        </select>
      </div>

      <div class="input-box"id="additionalFertilizerField" style="display: none;">
        <span class="details">Other(input here)</span>
        <input type="text"  id="OthersInputField" class="form-control light-gray-placeholder" name="additionalFertilizer" id="additionalFertilizer"placeholder="Enter fertilizer name">
      
      </div>
  {{-- SELECT TYPE OF FERTILIZER --}}
      <div class="input-box" id="fertilizerInput" style="display: none;">
        <span class="details">Type of Fertilizer</span>
        <select class="form-control light-gray-placeholder @error('seed_name') is-invalid @enderror"  name="type_of_fertilizer" id="SelectFertilizer">
            <option selected disabled>Select</option>
            <!-- Options will be dynamically populated based on the selected fertilizer category -->
        </select>
      </div>
               
  
      
      <div class="input-box" id="preferFertilizerinput" style="display: none;">
          <span class="details">Others(input here)</span>
          <input type="text" id="preferFertilizerinput" class="form-control light-gray-placeholder" name="type_of_fertilizers" placeholder=" Enter type of fertilizer" value="{{ old('type_of_fertilizers') }}">
        
        </div>

        <div class="input-box" >
            <span class="details">No. of Sacks</span>
            <input type="text" id="HybridNameInputField" class="form-control light-gray-placeholder"  name="no_ofsacks" id="no_ofsacks" placeholder="Enter no of sacks" value="{{ old('no_ofsacks') }}" >
          
          </div>

          <div class="input-box" >
            <span class="details">Unit Price per sacks(PHP) </span>
            <input type="text"class="form-control light-gray-placeholder"   name="unitprice_per_sacks" id="unitprice_per_sacks" placeholder="Enter unit price/sacks" value="{{ old('unitprice_per_sacks') }}"  >
          
          </div>

          
          <div class="input-box" >
            <span class="details">Total Cost Fertilizers(PHP)</span>
            <input type="text"class="form-control light-gray-placeholder" name="total_cost_fertilizers" id="total_cost_fertilizers" placeholder="Enter total cost" value="{{ old('total_cost_fertilizers') }}" >
          
          </div>
        </div>
        <br>
          <h3>d. Pesticides</h3><br>

          <div class="user-details">

            <div class="input-box" >
                <span class="details">Pesticides Name</span>
                <select class="form-control light-gray-placeholder @error('seed_type') is-invalid @enderror" name="pesticides_name"id="selectPesticideName"onchange="checkIPesticideName()" aria-label="Floating label select e">
                    <option selected disabled>Select</option>
                    <option value="Glyphosate" {{ old('pesticides_name') == 'Glyphosate' ? 'selected' : '' }}>Glyphosate</option>
                      <option value="Malathion" {{ old('pesticides_name') == 'Malathion' ? 'selected' : '' }}>Malathion</option>
                      <option value="Diazinon" {{ old('pesticides_name') == 'Diazinon' ? 'selected' : '' }}>Diazinon</option>
                      <option value="Chlorpyrifos" {{ old('pesticides_name') == 'Chlorpyrifos' ? 'selected' : '' }}>Chlorpyrifos</option>
                      <option value="Lambda-cyhalothrin" {{ old('pesticides_name') == 'Lambda-cyhalothrin' ? 'selected' : '' }}>Lambda-cyhalothrin</option>
                      <option value="Imidacloprid" {{ old('pesticides_name') == 'Imidacloprid' ? 'selected' : '' }}>Imidacloprid</option>
                      <option value="Cypermethrin" {{ old('pesticides_name') == 'Cypermethrin' ? 'selected' : '' }}>Cypermethrin</option>
                      <option value="N/A" {{ old('pesticides_name') == 'N/A' ? 'selected' : '' }}>N/A</option>
                    <option value="OtherPestName" {{ old('pesticides_name') == 'OtherPestName' ? 'selected' : '' }}>Others</option>
    
                  
                  </select>
   
              </div>

          <div class="input-box" >
            <span class="details">Number of L or kg</span>
            <input type="text"class="form-control light-gray-placeholder"name="no_of_l_kg" id="no_of_l_kg" placeholder="Enter no of L or Kg" value="{{ old('no_of_l_kg') }}" >
          
          </div>

          <div class="input-box" >
            <span class="details">Unit Price of Pesticides(PHP)</span>
            <input type="text"class="form-control light-gray-placeholder"  name="unitprice_ofpesticides" id="unitprice_ofpesticides" placeholder="Enter unit price pesticides" value="{{ old('unitprice_ofpesticides') }}" >
          
          </div>
          <div class="input-box" >
            <span class="details">Total Cost Pesticides(PHP)</span>
            <input type="text"class="form-control light-gray-placeholder"  name="total_cost_pesticides" id="total_cost_pesticides" placeholder="Enter total cost" value="{{ old('total_cost_pesticides') }}">
          
          </div>
    </div>

    <h3>e. Transport & Variable Cost Total</h3><br>

    <div class="user-details">
    <div class="input-box" >
      <span class="details">Name of Vehicle</span>
      <input type="text"class="form-control light-gray-placeholder"name="type_of_vehicle" id="unitPriceInput" placeholder="Enter type of vehicle" value="{{ old('type_of_vehicle') }}">
    
    </div>

    <div class="input-box" >
      <span class="details">Total DeliveryCost(PHP)</span>
      <input type="text"class="form-control light-gray-placeholder" name="total_transport_per_deliverycost" id="totalLaborCostInput" placeholder="Enter total transport cost" value="{{ old('total_transport_per_deliverycost') }}" >
    
    </div>
    <div class="input-box" >
      <span class="details">Total Machineries Fuel Cost</span>
      <input type="text"class="form-control light-gray-placeholder" name="total_machinery_fuel_cost" id="total_machinery_fuel_cost" placeholder="Enter total fuel cost" value="{{ old('total_machinery_fuel_cost') }}" >
    
    </div>

    <div class="input-box" >
        <span class="details">Total Variable Cost</span>
        <input type="text"class="form-control light-gray-placeholder" name="total_variable_cost" id="total_variable_cost" placeholder="Enter total variable cost" value="{{ old('total_variable_cost') }}"  >
      
      </div>
</div>
                        <!-- Add other fields -->
                        <button type="button" class="btn btn-primary" onclick="previousStep()">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var formSteps = document.querySelectorAll(".form_step");
                var formNavButtons = document.querySelectorAll(".form_btns .btn_next, .form_btns .btn_back");
                var modalWrapper = document.querySelector(".modal_wrapper");
                var shadow = document.querySelector(".shadow");
                var currentStep = 0;
        
                function showStep(stepIndex) {
                    formSteps.forEach(function(step) {
                        step.style.display = "none";
                    });
                    formSteps[stepIndex].style.display = "block";
                    updateProgress(stepIndex);
                }
        
                function updateProgress(stepIndex) {
                    document.querySelectorAll(".progress").forEach(function(progress) {
                        progress.classList.remove("active");
                    });
                    document.querySelector(`.form_${stepIndex + 1}_progessbar`).classList.add("active");
                } 
        
                function initializeFormNavigation() {
                    showStep(currentStep);
                    formNavButtons.forEach(function(button) {
                        button.addEventListener("click", function() {
                            if (button.classList.contains("btn_next")) {
                                if (currentStep < formSteps.length - 1) {
                                    currentStep++;
                                    showStep(currentStep);
                                }
                            } else if (button.classList.contains("btn_back")) {
                                if (currentStep > 0) {
                                    currentStep--;
                                    showStep(currentStep);
                                }
                            }
                        });
                    });
                }
        
                var submitButton = document.querySelector(".form_15_btns .btn_next");
                submitButton.addEventListener("click", function() {
                    modalWrapper.style.display = "flex"; // Show modal
                });
        
                var modalCloseButton = document.querySelector(".btn_done");
                modalCloseButton.addEventListener("click", function() {
                    modalWrapper.style.display = "none"; // Close modal
                });
        
                shadow.addEventListener("click", function() {
                    modalWrapper.style.display = "none"; // Close modal on shadow click
                });
        
                initializeFormNavigation();
            });
        </script>
    </div>


<script>
// Assuming you have a form with the ID 'form'
const form = $('#form');

console.log(2)

// Bind the submit event to the form
form.on('submit', function(event) {
    event.preventDefault(); // Prevent the form from reloading the page
  

        // Gather farmer info from the form inputs
        // let farmerInfo = {
        //     'name': $('input[name="personal_in"]').val(),
          
      
        // };

        // Gather farm info from the form inputs
   // Gather farm info from the form inputs
let farmInfo = {
    'tenurial_status': $('input[name="tenurial_status"]').val(),
    'farmer_id': $('input[name="personal_informations_id"]').val()
};

console.log("sasa")
// Log the object to verify its contents
console.log(farmInfo);


            // Gather crop info from the form inputs
            let cropInfo = [];

$('.crop input[name="crop[]"]').each(function() {
    cropInfo.push({
        crop_name: $(this).val()
    });
});
// console.log("Farmer Info:", farmerInfo); // Display the gathered farmer info in the console
// console.log("Farm Info:", farmInfo); // Display the gathered farm info in the console
// console.log("Crops entered so far:", cropInfo); // Display the gathered crops in the console
// });

    let dataobject = {
        // 'farmer': farmerInfo, 
        'farm': farmInfo,
        'crops': cropInfo
    }
   // Log the entire data object to the console
   console.log("Data Object:", dataobject);

    const csrfToken = $('input[name="_token"]').attr('value');

    //   Send the AJAX request
    $.ajax({
        url: '/admin-view-Farmers-samplefolder',
        method: 'POST',
        contentType: 'application/json', // Set content type for JSON
        data: JSON.stringify(dataobject), // Attach the prepared data here
        headers: {
          'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
        },
        success: function(response) {

         
          console.log(response);



        },
        error: function(error) {
          console.error('Error:', error.responseJSON.message);
        }
    });
});




</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
{{--     
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
    </script> --}}
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
<script>
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

    function addFarmProfile() {
        const farmProfiles = document.getElementById('farmProfiles');
        const index = farmProfiles.children.length;

        const farmProfile = document.createElement('div');
        farmProfile.className = 'user-details';

        // Column layout for farm profile
        const farmProfileCol = document.createElement('div');
        farmProfileCol.className = 'input-box';

        const farmProfileContainer = document.createElement('div');
        farmProfileContainer.className = 'user-details';

        addInputField(farmProfileContainer, 'Farm Size:', 'number', `farm_profiles[${index}][farm_size]`, `farm_size_${index}`);
        addInputField(farmProfileContainer, 'Farm Location:', 'text', `farm_profiles[${index}][farm_location]`, `farm_location_${index}`);
        addInputField(farmProfileContainer, 'Rice Farm Address:', 'text', `farm_profiles[${index}][rice_farm_address]`, `rice_farm_address_${index}`);
        addInputField(farmProfileContainer, 'Number of Years as Farmer:', 'number', `farm_profiles[${index}][no_of_years_as_farmers]`, `no_of_years_as_farmers_${index}`);
        addInputField(farmProfileContainer, 'GPS Longitude:', 'text', `farm_profiles[${index}][gps_longitude]`, `gps_longitude_${index}`);
        addInputField(farmProfileContainer, 'GPS Latitude:', 'text', `farm_profiles[${index}][gps_latitude]`, `gps_latitude_${index}`);
        addInputField(farmProfileContainer, 'Total Physical Area (has):', 'number', `farm_profiles[${index}][total_physical_area_has]`, `total_physical_area_has_${index}`);
        addInputField(farmProfileContainer, 'Rice Area Cultivated (has):', 'number', `farm_profiles[${index}][rice_area_cultivated_has]`, `rice_area_cultivated_has_${index}`);
        addInputField(farmProfileContainer, 'Land Title No:', 'text', `farm_profiles[${index}][land_title_no]`, `land_title_no_${index}`);
        addInputField(farmProfileContainer, 'Lot No:', 'text', `farm_profiles[${index}][lot_no]`, `lot_no_${index}`);
        addInputField(farmProfileContainer, 'Area Prone To:', 'text', `farm_profiles[${index}][area_prone_to]`, `area_prone_to_${index}`);
        addInputField(farmProfileContainer, 'Ecosystem:', 'text', `farm_profiles[${index}][ecosystem]`, `ecosystem_${index}`);
        addInputField(farmProfileContainer, 'RSBA Register:', 'text', `farm_profiles[${index}][rsba_register]`, `rsba_register_${index}`);
        addInputField(farmProfileContainer, 'PCIC Insured:', 'text', `farm_profiles[${index}][pcic_insured]`, `pcic_insured_${index}`);
        addInputField(farmProfileContainer, 'Government Assisted:', 'text', `farm_profiles[${index}][government_assisted]`, `government_assisted_${index}`);
        addInputField(farmProfileContainer, 'Source of Capital:', 'text', `farm_profiles[${index}][source_of_capital]`, `source_of_capital_${index}`);
        addInputField(farmProfileContainer, 'Remarks/Recommendation:', 'text', `farm_profiles[${index}][remarks_recommendation]`, `remarks_recommendation_${index}`);
        addInputField(farmProfileContainer, 'OCA District Office:', 'text', `farm_profiles[${index}][oca_district_office]`, `oca_district_office_${index}`);
        addInputField(farmProfileContainer, 'Name of Technicians:', 'text', `farm_profiles[${index}][name_technicians]`, `name_technicians_${index}`);
        addInputField(farmProfileContainer, 'Date of Interview:', 'date', `farm_profiles[${index}][date_interview]`, `date_interview_${index}`);

        // Crop Farms Section
        const cropFarms = document.createElement('div');
        cropFarms.setAttribute('id', `cropFarms_${index}`);
        cropFarms.className = 'user-details';

        // Initial Crop Farm
        addCropFarmFields(cropFarms, index, 0);

        const addCropFarmButton = document.createElement('button');
        addCropFarmButton.setAttribute('type', 'button');
        addCropFarmButton.setAttribute('class', 'btn btn-secondary mt-2');
        addCropFarmButton.textContent = 'Add Another Crop Farm';
        addCropFarmButton.addEventListener('click', () => addCropFarm(index));
        cropFarms.appendChild(addCropFarmButton);

        const removeFarmProfileButton = document.createElement('button');
        removeFarmProfileButton.setAttribute('type', 'button');
        removeFarmProfileButton.setAttribute('class', 'btn btn-danger mt-2');
        removeFarmProfileButton.textContent = 'Remove Farm Profile';
        removeFarmProfileButton.addEventListener('click', () => removeFarmProfile(index));
        farmProfileCol.appendChild(removeFarmProfileButton);

        farmProfileCol.appendChild(farmProfileContainer);
        farmProfileCol.appendChild(cropFarms);
        farmProfiles.appendChild(farmProfileCol);
    }

    function addInputField(parent, labelText, type, name, id) {
        const col = document.createElement('div');
        col.className = 'input-box';

        const label = document.createElement('label');
        label.setAttribute('for', id);
        label.textContent = labelText;
        col.appendChild(label);

        const input = document.createElement('input');
        input.setAttribute('type', type);
        input.setAttribute('class', 'form-control');
        input.setAttribute('name', name);
        input.setAttribute('id', id);
        input.required = true;
        col.appendChild(input);

        parent.appendChild(col);
    }

    function addCropFarm(farmProfileIndex) {
        const cropFarms = document.getElementById(`cropFarms_${farmProfileIndex}`);
        const index = cropFarms.children.length;
        const cropFarm = document.createElement('div');
        cropFarm.className = 'user-details';

        addCropFarmFields(cropFarm, farmProfileIndex, index);

        const removeCropFarmButton = document.createElement('button');
        removeCropFarmButton.setAttribute('type', 'button');
        removeCropFarmButton.setAttribute('class', 'btn btn-danger mt-2');
        removeCropFarmButton.textContent = 'Remove Crop Farm';
        removeCropFarmButton.addEventListener('click', () => removeCropFarm(farmProfileIndex, index));
        cropFarm.appendChild(removeCropFarmButton);

        cropFarms.appendChild(cropFarm);
    }

    function addCropFarmFields(parent, farmProfileIndex, index) {
        addInputField(parent, 'Crop Type:', 'text', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][crop_type]`, `crop_type_${farmProfileIndex}_${index}`);
        addInputField(parent, 'Crop Area:', 'number', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][crop_area]`, `crop_area_${farmProfileIndex}_${index}`);
        addInputField(parent, 'Type Rice Variety:', 'text', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][type_rice_variety]`, `type_rice_variety_${farmProfileIndex}_${index}`);
        addInputField(parent, 'Preferred Variety:', 'text', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][prefered_variety]`, `prefered_variety_${farmProfileIndex}_${index}`);
        addInputField(parent, 'Plant Schedule (Wet Season):', 'text', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][plant_schedule_wetseason]`, `plant_schedule_wetseason_${farmProfileIndex}_${index}`);
        addInputField(parent, 'Plant Schedule (Dry Season):', 'text', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][plant_schedule_dryseason]`, `plant_schedule_dryseason_${farmProfileIndex}_${index}`);
        addInputField(parent, 'Number of Cropping Years:', 'number', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][no_of_cropping_yr]`, `no_of_cropping_yr_${farmProfileIndex}_${index}`);
        addInputField(parent, 'Yield (kg/ha):', 'number', `farm_profiles[${farmProfileIndex}][crop_farms][${index}][yield_kg_ha]`, `yield_kg_ha_${farmProfileIndex}_${index}`);
    }

    function removeFarmProfile(index) {
        const farmProfiles = document.getElementById('farmProfiles');
        farmProfiles.removeChild(farmProfiles.children[index]);
    }

    function removeCropFarm(farmProfileIndex, index) {
        const cropFarms = document.getElementById(`cropFarms_${farmProfileIndex}`);
        cropFarms.removeChild(cropFarms.children[index]);
    }

    showStep(currentStep);
</script>





@endsection
