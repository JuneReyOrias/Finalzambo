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

<div class="page-content">

    
    <div class="card-forms border rounded">

    
        <div class="card-forms border rounded">

            <div class="card-body">
              
            {{-- <div class="header">
                <ul>
                    <li class="active form_1_progessbar">
                        <div>
                            <p>A</p>
                        </div>
                    </li>
                    <li class="form_2_progessbar">
                        <div>
                            <p>B</p>
                        </div>
                    </li>
                    <li class="form_3_progessbar">
                        <div>
                            <p>C</p>
                        </div>
                    </li>
                </ul>
            </div> --}}
            <div class="content">
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
            <form id="multi-step-form" action{{url('store')}} method="post">
                @csrf
                <div >

                    <input type="hidden" name="users_id" value="{{ $userId}}">
                   
                 
             </div>
             <div class="input-box">
               
                <input type="hidden" class="form-control light-gray-placeholder @error('first_name') is-invalid @enderror" name="country" id="validationCustom01" value="corn" readonly >
                @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
              </div>
         
                <!-- Step 1 -->
                <div id="step-1" class="form_1">
                    {{-- <h4 class="card-titles" style="display: flex;text-align: center; "><span></span>Rice Survey Form Zamboanga City</h4> --}}
    

         
                    <h3>Crops</h3><br>
                    <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
        
                    <div class="user-details">
                        
                      
                      
                        <div class="input-box">
                          <span class="details">Crop Name</span>
                          <select class="form-control light-gray-placeholder" name="crop_name" id="selectcrop" onchange="checkcropname()" aria-label="Floating label select e">
                              <option selected disabled>Select</option>
                              <option value="Rice" {{ old('crop_name') == 'Rice' ? 'selected' : '' }}>Rice</option>
                              <option value="Corn" {{ old('crop_name') == 'Corn' ? 'selected' : '' }}>Corn</option>
                              <option value="Coconut" {{ old('crop_name') == 'Coconut' ? 'selected' : '' }}>Coconut</option>
                              <option value="Add" {{ old('crop_name') == 'Add' ? 'selected' : '' }}>Add</option>
                          </select>
                      </div>
                      
                      <div class="input-box" id="addCropInput" style="display: none;">
                          <span class="details">Add Crop</span>
                          <input type="text" class="form-control light-gray-placeholder @error('barangay_name') is-invalid @enderror" name="new_crop_name" id="newCropName">
                          {{-- <button type="button" class="btn btn-primary" onclick="addNewCrop()">Add Crop</button> --}}
                          @error('barangay_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                      
                       
                        {{-- <div class="input-box">
                          <span class="details">Crop Variety</span>
                          <input type="text" class="form-control light-gray-placeholder @error('type_of_variety') is-invalid @enderror"  name="type_of_variety"placeholder="Enter crop variety" value="{{ old('type_of_variety') }}" >
                          @error('type_of_variety')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>
                      --}}
                        
                      </div>
                      <div class="form_1_btns">
                       
                        <a  href="{{route('polygon.polygons_show')}}"button  class="btn btn-success me-md-2">Back</button></a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>

            
                          
                            
                          </div>
                     
            
                          <div class="form_3_btns" style="display: none;">

                            <button type="button" class="btn btn-secondary btn_back mr-2">Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
            </form>
                </div>
            </div>
            {{-- <div class="btns_wrap">
                <div class="common_btns form_1_btns">
                    <button type="button" class="btn_next">Next <span class="icon"><ion-icon name="arrow-forward-sharp"></ion-icon></span></button>
                </div>
                <div class="common_btns form_2_btns" style="display: none;">
                    <button type="button" class="btn_back"><span class="icon"><ion-icon name="arrow-back-sharp"></ion-icon></span>Back</button>
                    <button type="button" class="btn_next">Next <span class="icon"><ion-icon name="arrow-forward-sharp"></ion-icon></span></button>
                </div>
                <div class="common_btns form_3_btns" style="display: none;">
                    <button type="button" class="btn_back"><span class="icon"><ion-icon name="arrow-back-sharp"></ion-icon></span>Back</button>
                    <button type="submit" class="btn btn-success me-md-2 btn-submit">Done</button>
                </div>
            </div> --}}
        </div>
    </div>
   <script>
    function checkcropname() {
    var selectcrop = document.getElementById("selectcrop");
    var addCropInput = document.getElementById("addCropInput");

    if (selectcrop.value === "Add") {
        addCropInput.style.display = "block";
    } else {
        addCropInput.style.display = "none";
    }
}

function addNewCrop() {
    var newCropName = document.getElementById("newCropName").value;
    var selectcrop = document.getElementById("selectcrop");

    // Create a new option element
    var newOption = document.createElement("option");
    newOption.value = newCropName;
    newOption.text = newCropName;

    // Add the new option to the select element
    selectcrop.add(newOption);

    // Select the new option
    selectcrop.value = newCropName;

    // Hide the input box
    document.getElementById("addCropInput").style.display = "none";
}

   </script>
@endsection
