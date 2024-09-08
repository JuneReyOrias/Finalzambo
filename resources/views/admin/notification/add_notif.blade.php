@extends('admin.dashb')

@section('admin')
    @extends('layouts._footer-script')
    @extends('layouts._head')

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
        }/admin-view-polygon
        
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
    body {
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
    }
    .nav.nav-tabs .nav-item .nav-link.active {
    border-color: #172340 #172340 #0c1427;
    color:#ffff;
    /* background: #0c1427; */
}
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }
    .card-header {
        background-color:#11530c;
        color: #ffffff;
        border-radius: 10px 10px 0 0;
        width: 20%;
        padding: 15px;
    }
    .nav-tabs .nav-link {
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-weight: 600;
        color: #ffffff;
        background-color: transparent;
    }
    .nav-tabs .nav-link.active {
        background-color: #0056b3;
        color: #ffffff;
    }
    .tab-content {
        padding: 20px;
        background-color: #ffffff;
        border-radius: 0 0 10px 10px;
    }
    .form-control {
        border-radius: 5px;
        border-color: #ced4da;
        box-shadow: none;
    }
    .form-control:focus {
        border-color: #20c997;
        box-shadow: 0 0 0 0.2rem rgba(32, 201, 151, 0.25);
    }
    .btn-secondary {
        background-color: #343a40;
        border-color: #343a40;
    }
    .btn-secondary:hover {
        background-color: #23272b;
        border-color: #1d2124;
    }
    .btn-success {
        background-color: #20c997;
        border-color: #20c997;
    }
    .btn-success:hover {
        background-color: #1b9a76;
        border-color: #1b9a76;
    }
    .card-body p {
        color: #6c757d;
    }
    .card-body h3 {
        color: #333;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .grid-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Two equal columns */
    gap: 1rem; /* Adjust the gap between the input fields if needed */
}

.input-box {
    display: flex;
    flex-direction: column;
}
.user-details, .input-box {
    display: flex;
    gap: 1rem; /* Adjust this value to increase or decrease the space between input fields */
}

.flex-fill {
    flex: 1;
}
.input-box {
    flex: 1; /* Ensure inputs take up available space */
    min-width: 200px; /* Set a minimum width for better responsiveness */
}
.form-control {
    width: 100%; /* Ensure the input field takes up full width of its container */
    box-sizing: border-box; /* Include padding and border in the element’s total width and height */
    overflow: hidden; /* Hide any overflowing content */
    white-space: nowrap; /* Prevent text from wrapping to a new line */
    text-overflow: ellipsis; /* Add an ellipsis (...) if the text overflows */
}

.input-box {
    flex: 1; /* Ensure input boxes take up available space in flex container */
    min-width: 200px; /* Set a minimum width to handle longer text gracefully */
}

</style>
<div class="page-content">

    
    <div class="card-forms border rounded">

    
        <div class="card-forms border rounded">

            <div class="card-body">
              
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="true">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="agents-tab" data-toggle="tab" href="#agents" role="tab" aria-controls="agents" aria-selected="false">Agents</a>
                        </li>
                    </ul>
                </div>
            
                <div class="tab-content" id="myTabContent">
                    <!-- Users Tab Content -->
                    <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <h3>User Information</h3>
                        <p class="text-success">Provide clear and concise responses for users.</p>
                        <form method="POST" action{{ url('Messagestore') }}>
                            @csrf
                        
                                
                                <input type="hidden" name="sender_id" value="{{ $userId }}">
                            
                            <div class="user-details d-flex">
                                
                                <div class="input-box flex-fill">
                                    <label for="user_id">Users</label>
                                    <select class="form-control" name="receiver_id" id="user_id">
                                        <option selected disabled>Select User</option>
                                        <!-- Populate options dynamically -->
                                        @foreach ($regularUsers as $user)
                                            <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-box flex-fill">
                                    <label for="user_message">Message for User</label>
                                    <input type="text" class="form-control" placeholder="message" name="message" id="user_message">
                                </div>
                            </div>
                            
                            
                            <div class="form-group mt-4">
                                <a href="{{ route('admin.notification.view_notif') }}" class="btn btn-secondary mr-2">Back</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                            <!-- No closing form tag here; keep it open to include both forms -->
                        </form>
                    </div>
                
                    <!-- Agents Tab Content -->
                    <div class="tab-pane fade" id="agents" role="tabpanel" aria-labelledby="agents-tab">
                        <h3>Agent Information</h3>
                        <p class="text-success">Provide clear and concise responses for agents.</p>
                        <form method="POST" action{{ url('Messagestore') }}>
                            @csrf
                            <input type="hidden" name="user_type" value="agent">
                            <div class="user-details d-flex">
                                <div class="input-box flex-fill">
                                    <label for="agent_sender_id">Sender ID</label>
                                    <input type="hidden" name="sender_id" value="{{ $userId }}">
                                </div>
                                <div class="input-box flex-fill">
                                    <label for="agent_id">Agent</label>
                                    <select class="form-control" name="receiver_id" id="agent_id">
                                        <option selected disabled>Select Agent</option>
                                        <!-- Populate options dynamically -->
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->first_name . ' ' . $agent->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-box flex-fill">
                                    <label for="agent_message">Message for Agent</label>
                                    <input type="text" class="form-control" name="message" placeholder="message" id="agent_message">
                                </div>
                            </div>
                            <!-- No closing form tag here; keep it open to include both forms -->
                            <div class="form-group mt-4">
                                <a href="{{ route('admin.notification.view_notif') }}" class="btn btn-secondary mr-2">Back</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                    
                   
                </div>
                
        </div>
    </div>
        <div class="modal_wrapper">
            <div class="shadow"></div>
            <div class="success_wrap">
                <span class="modal_icon"><ion-icon name="checkmark-sharp"></ion-icon></span>
                <p>You have successfully completed the process.</p>
            </div>
        </div>
        
        <script>
            var form_1 = document.querySelector(".form_1");
            var form_2 = document.querySelector(".form_2");
            var form_3 = document.querySelector(".form_3");
            
            var form_1_btns = document.querySelector(".form_1_btns");
            var form_2_btns = document.querySelector(".form_2_btns");
            var form_3_btns = document.querySelector(".form_3_btns");
            
            var form_1_next_btn = document.querySelector(".form_1_btns .btn_next");
            var form_2_back_btn = document.querySelector(".form_2_btns .btn_back");
            var form_2_next_btn = document.querySelector(".form_2_btns .btn_next");
            var form_3_back_btn = document.querySelector(".form_3_btns .btn_back");
            
            var form_2_progessbar = document.querySelector(".form_2_progessbar");
            var form_3_progessbar = document.querySelector(".form_3_progessbar");
            
            var btn_done = document.querySelector(".btn_done");
            var modal_wrapper = document.querySelector(".modal_wrapper");
            var shadow = document.querySelector(".shadow");
            
            form_1_next_btn.addEventListener("click", function(){
                form_1.style.display = "none";
                form_2.style.display = "block";
                form_1_btns.style.display = "none";
                form_2_btns.style.display = "flex";
                form_2_progessbar.classList.add("active");
            });
            
            form_2_back_btn.addEventListener("click", function(){
                form_1.style.display = "block";
                form_2.style.display = "none";
                form_1_btns.style.display = "flex";
                form_2_btns.style.display = "none";
                form_2_progessbar.classList.remove("active");
            });
            
            form_2_next_btn.addEventListener("click", function(){
                form_2.style.display = "none";
                form_3.style.display = "block";
                form_3_btns.style.display = "flex";
                form_2_btns.style.display = "none";
                form_3_progessbar.classList.add("active");
            });
            
            form_3_back_btn.addEventListener("click", function(){
                form_2.style.display = "block";
                form_3.style.display = "none";
                form_3_btns.style.display = "none";
                form_2_btns.style.display = "flex";
                form_3_progessbar.classList.remove("active");
            });
            
            btn_done.addEventListener("click", function(){
                modal_wrapper.classList.add("active");
            });
            
            shadow.addEventListener("click", function(){
                modal_wrapper.classList.remove("active");
            });
        </script>
    </div>




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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.next-btn').click(function() {
            var currentStep = $(this).closest('.form-step');
            var nextStep = currentStep.next('.form-step');
            currentStep.hide();
            nextStep.show();
        });

        $('.prev-btn').click(function() {
            var currentStep = $(this).closest('.form-step');
            var prevStep = currentStep.prev('.form-step');
            currentStep.hide();
            prevStep.show();
        });
    });

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
</script>

<script>
    $(document).ready(function() {
        var currentStep = 1; // Track current step

        // Function to update progress bar
        function updateProgressBar(step) {
            $('.header ul li').removeClass('active');
            for (var i = 1; i <= step; i++) {
                $('.form_' + i + '_progressbar').addClass('active');
            }
        }

        // Next button click handler
        $('.next-btn').click(function() {
            var currentStepDiv = $('#step-' + currentStep);
            var nextStepDiv = $('#step-' + (currentStep + 1));

            if (nextStepDiv.length > 0) {
                currentStepDiv.hide();
                nextStepDiv.show();
                currentStep++;
                updateProgressBar(currentStep);
            }
        });

        // Previous button click handler
        $('.prev-btn').click(function() {
            var currentStepDiv = $('#step-' + currentStep);
            var prevStepDiv = $('#step-' + (currentStep - 1));

            if (prevStepDiv.length > 0) {
                currentStepDiv.hide();
                prevStepDiv.show();
                currentStep--;
                updateProgressBar(currentStep);
            }
        });
    });
</script>
@endsection
