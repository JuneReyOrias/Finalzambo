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
                                                    @if (session('message'))
                                                    <div class="alert alert-success" role="alert">
                                                      {{ session('message')}}
                                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                   
                                                    @endif
                                                <div class="content">
                                    <form action{{'productionUpdate'}} method="POST">
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
                                New Crop Production 
                                {{-- <button class="btn btn-secondary ml-auto" type="button" id="addCropButton">Add Crop</button> --}}
                            </button>
                        </h5>
                
                <!-- Button to Add New Crop Section (aligned to the right) -->
                {{-- <button class="btn btn-secondary ml-auto" type="button" id="addCropButton">Add Crop</button> --}}
            </div>
     
            <div id="collapseFarmProfile" class="collapse show" aria-labelledby="headingFarmProfile" data-parent="#accordionFarmProfile">
                <div class="card-body">
                        <div class="user-details">
                        <!-- Crop Fields -->
                          <input type="hidden" class="form-control users_id" placeholder="no of cropping/year" name="users_id" value="{{$userId}}" id="no_of_cropping_per_year">
                            
                    
                            <h3>a. Seed info and Usage details: </h3>
                            <div class="user-details">

                                <div class="input-box col-md-4">
                              
                                    <span class="details">Crop Name</span>
                                  <select class="form-control crops_farms_id" name="crops_farms_id" id="crop_name">
                                    <option value="{{$production->crops_farms_id}}">{{$production->cropFarm->crop_name}}</option>

                                  </select>
                              </div>
                         <!-- Production Fields -->
                         <div class="input-box col-md-4">
                             <label for="seeds_typed_used">Seed type Used:</label>
                             <input type="text" class="form-control light-gray-placeholder seed-type" name="seeds_typed_used" value="{{$production->seeds_typed_used}}" placeholder=" Enter Seed type used" id="seeds_typed_used" onkeypress="return blockSymbolsAndNumbers(event)">
                         </div>
                           <div class="input-box col-md-4">
                             <label for="seeds_used_in_kg">Seeds used in kg:</label>
                             <input type="number" class="form-control light-gray-placeholder seed-used" name="seeds_used_in_kg" value="{{$production->seeds_used_in_kg}}" placeholder=" Enter Seed used in kg" id="seeds_used_in_kg">
                             
                             </div>
                   <div class="input-box col-md-4">
                         <label for="seed_source">Seed Source:</label>
                         <div class="d-flex align-items-center">
                             <select class="form-control custom-select light-gray-placeholder seed-source placeholder-text @error('seed_source') is-invalid @enderror" id="seed_source" onchange="checkSeedSource()" name="seed_source" aria-label="Floating label select e">
                                 <option value="{{$production->seed_source}}">{{$production->seed_source}}</option>
                                 <option value="Government Subsidy" {{ old('seed_source') == 'Government Subsidy' ? 'selected' : '' }}>Government Subsidy</option>
                                 <option value="Traders" {{ old('seed_source') == 'Traders' ? 'selected' : '' }}>Traders</option>
                                 <option value="Own" {{ old('seed_source') == 'Own' ? 'selected' : '' }}>Own</option>
                                 <option value="Add" {{ old('seed_source') == 'Add' ? 'selected' : '' }}>Add</option>
                             </select>
                             <button type="button" id="removeSeedSourceButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeSeedSource()">
                                 <i class="fa fa-trash"></i>
                             </button>
                         </div>
                         @error('seed_source')
                         <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                     </div>

                          {{-- <div class="input-box col-md-4">
                             <label for="unit">Unit:</label>
                             <input type="text" class="form-control light-gray-placeholder unit" name="unit"placeholde="Enter unit" id="unit" onkeypress="return blockSymbolsAndNumbers(event)">
                         </div> --}}

                         <div class="input-box col-md-4">
                            <label for="unit">Unit:</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control custom-select light-gray-placeholder unit placeholder-text @error('unit') is-invalid @enderror" id="unit" name="unit" onchange="Unit()">
                                    <option value="{{$production->unit}}">{{$production->unit}}</option>
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
                             <label for="no_of_fertilizer_used_in_bags">no of fertilizer used in bags:</label>
                             <input type="number" class="form-control light-gray-placeholder fertilized-used"value="{{$production->no_of_fertilizer_used_in_bags}}" name="no_of_fertilizer_used_in_bags" placeholder=" Enter no of fertilizers used in bags" id="no_of_fertilizer_used_in_bags">
                         </div>
                          <div class="input-box col-md-4">
                             <label for="no_of_pesticides_used_in_l_per_kg">no of pesticides used in L/KG:</label>
                             <input type="number" class="form-control light-gray-placeholder pesticides-used" value="{{$production->no_of_pesticides_used_in_l_per_kg}}" name="no_of_pesticides_used_in_l_per_kg" placeholder="no of cropping/year" id="no_of_pesticides_used_in_l_per_kg">
                         </div>
                         <div class="input-box col-md-4">
                             <label for="no_of_insecticides_used_in_l">no of insecticides used in L/KG:</label>
                             <input type="number" class="form-control light-gray-placeholder insecticides-used" value="{{$production->no_of_insecticides_used_in_l}}" name="no_of_insecticides_used_in_l" placeholder="no of cropping/year" id="no_of_insecticides_used_in_l">
                         </div>
                         
                            
                     </div>

                     <h3>b. Crop Planting Details</h3>
                         <div class="user-details">
                             <div class="input-box col-md-4">
                             <label for="area_planted">Area Planted:</label>
                             <input type="number" class="form-control light-gray-placeholder area-planted" value="{{$production->area_planted}}" name="area_planted" paceholder="Area Planted" >
                         </div>

                          <div class="input-box col-md-4">
                             <label for="date_planted">Date Planted:</label>
                             <input type="text" class="form-control light-gray-placeholder date-planted" value="{{$production->date_planted}}" name="date_planted" paceholder="Date Planted"  id="datepicker">
                         </div>
                     <div class="input-box col-md-4">
                             <label for="date_planted">Date Harvested:</label>
                             <input type="text" class="form-control light-gray-placeholder date-harvested" value="{{$production->date_harvested}}" name="date_harvested" paceholder="Date harvested"  id="datepicker">
                         </div>
                          <div class="input-box col-md-4">
                             <label for="yield_tons_per_kg">Yield Kg/Tons:</label>
                             <input type="number" class="form-control light-gray-placeholder yield-kg" value="{{$production->yield_tons_per_kg}}" name="yield_tons_per_kg" placeholder="Yield Kg/Tons" id="yield_tons_per_kg">
                         </div>
                          
</div>
                        </div>

                        <!-- Other fields here -->
                         </div>
                        
                               
                            <!-- Add Fixed Cost Section -->
                            {{-- <div class="card">
                                <div class="card-header" id="headingFixedCost" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                                    <h5 class="mb-0" style="margin: 0;">
                                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseFixedCost" aria-expanded="false" aria-controls="collapseFixedCost">
                                            Add Fixed Cost
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseFixedCost" class="collapse" aria-labelledby="headingFixedCost" data-parent="#accordionCropDetails">
                                    <div class="card-body">
                                           <h3>Fixed Cost</h3>
                                             <div class="user-details">
                                        <!-- Fixed Cost Fields -->
                                       <div class="input-box col-md-4">
                                        <label for="particular">Particular:</label>
                                        <div class="d-flex align-items-center">
                                            <select class="form-control custom-select light-gray-placeholder particular @error('particular') is-invalid @enderror" 
                                                    name="particular]" 
                                                 id="particular" 
                                                    onchange="checkParticular()" 
                                                    aria-label="label select e">
                                                <option selected value="Land Rental Cost" {{ old('particular') == 'Land Rental Cost' ? 'selected' : '' }}>Land Rental Cost</option>
                                                <option value="Land Ownership Cost" {{ old('particular') == 'Land Ownership Cost' ? 'selected' : '' }}>Land Ownership Cost</option>
                                                <option value="Equipment Costs" {{ old('particular') == 'Equipment Costs' ? 'selected' : '' }}>Equipment Costs</option>
                                                <option value="Infrastructure Costs" {{ old('particular') == 'Infrastructure Costs' ? 'selected' : '' }}>Infrastructure Costs</option>
                                                <option value="Other" {{ old('particular') == 'Other' ? 'selected' : '' }}>Others</option>
                                            </select>
                                            <button type="button" id="removeParticularButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeParticular()">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        @error('particular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                     
                                         
                                          
                                      
                                    <div class="input-box col-md-4">
                                        <label for="no_of_ha">No. of Has</label>
                                        <input type="number" class="form-control light-gray-placeholder no-has @error('gross_income_palay') is-invalid @enderror"
                                            name="no_of_ha" id="no_of_ha" placeholder="Enter No. of Has" value="{{ old('no_of_ha') }}">
                                        @error('gross_income_palay')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-box col-md-4">
                                        <label for="cost_per_ha">Cost/Has (PHP)</label>
                                        <input type="number" class="form-control light-gray-placeholder cost-has @error('gross_income_rice') is-invalid @enderror"
                                            name="cost_per_ha" id="cost_per_ha"placeholder="Enter Cost/Has" value="{{ old('cost_per_ha') }}">
                                        @error('gross_income_rice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="input-box col-md-4">
                                        <label for="total_amount">Total Amount PHP</label>
                                        <input type="number" class="form-control light-gray-placeholder total-amount @error('gross_income_rice') is-invalid @enderror"
                                            name="total_amount" id="total_amount" placeholder="Enter total amount"  value="{{ old('total_amount') }}">
                                        @error('gross_income_rice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

;
                                   
                                  </div>

                                    </div>
                                </div>
                            </div> --}}
                            <!-- Add Machineries Section -->
                            {{-- <div class="card">
                                <div class="card-header" id="headingMachineries" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                                    <h5 class="mb-0" style="margin: 0;">
                                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseMachineries" aria-expanded="false" aria-controls="collapseMachineries">
                                            Add Machineries
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseMachineries" class="collapse" aria-labelledby="headingMachineries" data-parent="#accordionCropDetails">
                                    <div class="card-body">
                                           <h3>a. Plowing  </h3>
                                        <!-- Machineries Fields -->
                                       <div class="user-details">
      
                                                 <div class="input-box col-md-4">
                                                <span class="details">Plowing Machineries Used</span>
                                                <div class="d-flex align-items-center">
                                                <select class="form-control custom-select light-gray-placeholder plowing-machine @error('harro_ownership_status') is-invalid @enderror" 
                                                            name="harro_ownership_status" 
                                                            id="selectPlowing" 
                                                            onchange="checkPlowing()" 
                                                            aria-label="label select e">
                                                        <option selected disabled>Select</option>
                                                        <option value="Hand Tractor" {{ old('plowing-machine') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                                        <option value="Four-Wheel Tractors" {{ old('plowing-machine') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                                        <option value="Compact Tractors" {{ old('plowing-machine') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                                        <option value="Rice Transplanters" {{ old('plowing-machine') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                                        <option value="Crawler Tractors" {{ old('plowing-machine') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                                        <option value="OthersPlowing" {{ old('plowing-machine') == 'OthersPlowing' ? 'selected' : '' }}>Others(optional)</option>
                                                    </select>
                                                    <button type="button" id="removePlowingButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePlowing()">
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
                                                        name="plo_ownership_status" 
                                                        id="selectPlowingStatus" 
                                                        onchange="checkPlowingStatus()" 
                                                        aria-label="label select e">
                                                    <option selected disabled>Select</option>
                                                    <option  value="Own" {{ old('plo_ownership_status') == 'Own' ? 'selected' : '' }}>Own</option>
                                                    <option value="Rent" {{ old('plo_ownership_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                                    <option value="Other" {{ old('plo_ownership_status') == 'Other' ? 'selected' : '' }}>Other(Optional)</option>
                                                </select>
                                                <button type="button" id="removePlowingStatusButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePlowingStatus()">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            @error('plowing_machineries_used')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                       
                                        <div class="input-box col-md-4">
                                            <span class="details">No. of Plowing</span>
                                            <input type="number" class="form-control light-gray-placeholder no_of_plowing @error('no_of_plowing') is-invalid @enderror" name="no_of_plowing" id="noPlowing" placeholder="Enter no. of plowing" value="{{ old('no_of_plowing') }}">
                                            @error('no_of_plowing')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="input-box col-md-4">
                                            <span class="details">Cost per Plowing</span>
                                            <input type="number" class="form-control light-gray-placeholder cost_per_plowing @error('plowing_cost') is-invalid @enderror" name="plowing_cost" id="plowingperCostInput" placeholder="Enter plowing per cost" value="{{ old('plowing_cost') }}">
                                            @error('plowing_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="input-box col-md-4">
                                            <span class="details">Total Plowing Cost</span>
                                            <input type="number" class="form-control light-gray-placeholder plowing_cost @error('plowing_cost') is-invalid @enderror" name="plowing_cost" id="plowingCostInput" placeholder="Total plowing cost" value="{{ old('plowing_cost') }}" readonly>
                                            @error('plowing_cost')
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
                                        name="harrowing_machineries_used" 
                                        id="selectHarrowing" 
                                        onchange="checkHarrowing()" 
                                        aria-label="label select e">
                                    <option selected disabled>Select</option>
                                    <option value="Hand Tractor" {{ old('harrowing_machineries_used') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                    <option value="Four-Wheel Tractors" {{ old('harrowing_machineries_used') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                    <option value="Compact Tractors" {{ old('harrowing_machineries_used') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                    <option value="Rice Transplanters" {{ old('harrowing_machineries_used') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                    <option value="Crawler Tractors" {{ old('harrowing_machineries_used') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                    <option value="OthersHarrowing" {{ old('harrowing_machineries_used') == 'OthersHarrowing' ? 'selected' : '' }}>Others</option>
                                </select>
                                <button type="button" id="removeHarrowingButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeHarrowing()">
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
                                            name="harro_ownership_status" 
                                            id="selectOwnershipStatus" 
                                            onchange="checkOwnershipStatus()" 
                                            aria-label="label select e">
                                        <option selected disabled>Select</option>
                                        <option value="Own" {{ old('harro_ownership_status') == 'Own' ? 'selected' : '' }}>Own</option>
                                        <option value="Rent" {{ old('harro_ownership_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="Other" {{ old('harro_ownership_status') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removeOwnershipStatusButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeOwnershipStatus()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('harro_ownership_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

       
                            <div class="input-box col-md-4">
                                <span class="details">No. of Harrowing</span>
                                <input type="number" class="form-control light-gray-placeholder no_of_harrowing @error('no_of_harrowing') is-invalid @enderror" name="no_of_harrowing" id="noHarrowing" placeholder="Enter no. of harrowing" value="{{ old('no_of_harrowing') }}">
                                @error('no_of_harrowing')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Cost per Harrowing</span>
                                <input type="number" class="form-control light-gray-placeholder cost_per_harrowing @error('harrowing_cost') is-invalid @enderror" name="harrowing_cost" id="costPerHarrowingInput" placeholder="Enter cost per harrowing" value="{{ old('harrowing_cost') }}">
                                @error('harrowing_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Total Harrowing Cost</span>
                                <input type="number" class="form-control light-gray-placeholder harrowing_cost_total @error('harrowing_cost_total') is-invalid @enderror" name="harrowing_cost_total" id="totalHarrowingCostInput" placeholder="Total harrowing cost" value="{{ old('harrowing_cost_total') }}" readonly>
                                @error('harrowing_cost_total')
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
                                            name="Harvesting_machineries_used" 
                                            id="selectHarvestingMachine" 
                                            onchange="checkHarvestingMachine()" 
                                            aria-label="label select e">
                                        <option selected disabled>Select</option>
                                        <option value="Hand Tractor" {{ old('Harvesting_machineries_used') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                        <option value="Four-Wheel Tractors" {{ old('Harvesting_machineries_used') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                        <option value="Compact Tractors" {{ old('Harvesting_machineries_used') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                        <option value="Rice Transplanters" {{ old('Harvesting_machineries_used') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                        <option value="Crawler Tractors" {{ old('Harvesting_machineries_used') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                        <option value="Others" {{ old('Harvesting_machineries_used') == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    <button type="button" id="removeHarvestingMachineButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeHarvestingMachine()">
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
                                            name="harro_ownership_status" 
                                            id="selectHarvestOwnership" 
                                            onchange="checkHarvestOwnership()" 
                                            aria-label="label select e">
                                        <option selected disabled>Select</option>
                                        <option value="Own" {{ old('harro_ownership_status') == 'Own' ? 'selected' : '' }}>Own</option>
                                        <option value="Rent" {{ old('harro_ownership_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="Other" {{ old('harro_ownership_status') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removeHarvestOwnershipButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeHarvestOwnership()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @error('harro_ownership_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="input-box col-md-4">
                                <span class="details">No. of Harvesting</span>
                                <input type="number" class="form-control light-gray-placeholder no_of_Harvesting @error('no_of_Harvesting') is-invalid @enderror" name="no_of_Harvesting" id="noHarvesting" placeholder="Enter no. of Harvesting" value="{{ old('no_of_Harvesting') }}">
                                @error('no_of_Harvesting')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Cost per Harvesting</span>
                                <input type="number" class="form-control light-gray-placeholder cost_per_Harvesting @error('Harvesting_cost') is-invalid @enderror" name="Harvesting_cost" id="costPerHarvestingInput" placeholder="Enter cost per Harvesting" value="{{ old('Harvesting_cost') }}">
                                @error('Harvesting_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Total Harvesting Cost</span>
                                <input type="number" class="form-control light-gray-placeholder Harvesting_cost_total @error('Harvesting_cost_total') is-invalid @enderror" name="Harvesting_cost_total" id="totalHarvestingCostInput" placeholder="Total Harvesting cost" value="{{ old('Harvesting_cost_total') }}" readonly>
                                @error('Harvesting_cost_total')
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
                                            name="postharvest_machineries_used" 
                                            id="selectPostHarvestMachine" 
                                            onchange="checkPostHarvestMachine()" 
                                            aria-label="label select e">
                                        <option selected disabled>Select</option>
                                        <option value="Hand Tractor" {{ old('postharvest_machineries_used') == 'Hand Tractor' ? 'selected' : '' }}>Hand Tractor</option>
                                        <option value="Four-Wheel Tractors" {{ old('postharvest_machineries_used') == 'Four-Wheel Tractors' ? 'selected' : '' }}>Four-Wheel Tractors</option>
                                        <option value="Compact Tractors" {{ old('postharvest_machineries_used') == 'Compact Tractors' ? 'selected' : '' }}>Compact Tractors</option>
                                        <option value="Rice Transplanters" {{ old('postharvest_machineries_used') == 'Rice Transplanters' ? 'selected' : '' }}>Rice Transplanters</option>
                                        <option value="Crawler Tractors" {{ old('postharvest_machineries_used') == 'Crawler Tractors' ? 'selected' : '' }}>Crawler Tractors</option>
                                        <option value="OthersPostHarvest" {{ old('postharvest_machineries_used') == 'OthersPostHarvest' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    <button type="button" id="removePostHarvestMachineButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePostHarvestMachine()">
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
                                            name="postharvest_machineries_used" 
                                            id="selectPostHarvestMachineries" 
                                            onchange="checkPostHarvestMachineries()" 
                                            aria-label="label select e">
                                            <option selected disabled>Select</option>
                                        <option value="Own" {{ old('postharvest_machineries_used') == 'Own' ? 'selected' : '' }}>Own</option>
                                        <option value="Rent" {{ old('postharvest_machineries_used') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                        <option value="Other" {{ old('postharvest_machineries_used') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removePostHarvestMachineryButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePostHarvestMachinery()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>

       
                            
                        <div class="input-box col-md-4">
                            <span class="details">PostHarvest Cost: </span>
                            <input type="number" class="form-control light-gray-placeholder postharvestCost @error('last_name') is-invalid @enderror"name="'post_harvest_cost" id="postHarvestCostInput" placeholder="Enter no. of postharvest cost" value="{{ old('no_of_harrowing') }}" >
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>
                     
   
             <div class="input-box col-md-4">
               <span class="details">Total Cost for Machineries</span>
               <input type="number" class="form-control light-gray-placeholder total_cost_for_machineries @error('total_cost_for_machineries') is-invalid @enderror"name="total_cost_for_machineriest" id="totalCostInput"  placeholder="Enter total expenses" value="{{ old('total_cost_for_machineries') }}">
               @error('last_name')
               <div class="invalid-feedback">{{ $message }}</div>
           @enderror
             </div>
       
       </div>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- Add Variable Cost Section -->
                            {{-- <div class="card">
                                <div class="card-header" id="headingVariableCost" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                                    <h5 class="mb-0" style="margin: 0;">
                                        <button class="btn btn-modern collapsed" type="button" data-toggle="collapse" data-target="#collapseVariableCost" aria-expanded="false" aria-controls="collapseVariableCost">
                                            Add Variable Cost
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseVariableCost" class="collapse" aria-labelledby="headingVariableCost" data-parent="#accordionCropDetails">
                                    <div class="card-body">
                                        <!-- Variable Cost Fields -->
                                       <h3>a. Seed Cost </h3><br> --}}

                                        {{-- <div class="user-details">
                                           
                                        <div class="input-box col-md-4">
                                            <label for="seed_name">Seed name:</label>
                                            <div class="d-flex align-items-center">
                                                <select class="form-control seed_name" id="seed_name" onchange="checkSeedName()">
                                                    <option value="" disabled selected>Select seed</option>
                                                    <option value="add">Add (optional)</option>
                                                </select>
                                                <button type="button" id="seed_remove" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeSeed()">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                                    
                                          <div class="input-box col-md-4" >
                                              <span class="details">Unit</span>
                                              <input type="text" class="form-control light-gray-placeholder unit"  name="unit" id="validationCustom01" placeholder="Enter unit" value="{{ old('unit') }}" onkeypress="return blockSymbolsAndNumbers(event)">
                                            
                                            </div>
                                  
                                            <div class="input-box col-md-4">
                                                <span class="details">Quantity</span>
                                                <input type="number" class="form-control light-gray-placeholder quantity" name="quantity" id="quantityInput" placeholder="Enter quantity" value="{{ old('quantity') }}">
                                            </div>
                                            
                                            <div class="input-box col-md-4">
                                                <span class="details">Unit Price (PHP)</span>
                                                <input type="number" class="form-control light-gray-placeholder unit_price_seed" name="unit_price" id="unitPriceInput" placeholder="Enter unit price" value="{{ old('unit_price') }}">
                                            </div>
                                            
                                            <div class="input-box col-md-4">
                                                <span class="details">Total Seed Cost (PHP)</span>
                                                <input type="number" class="form-control light-gray-placeholder total_seed_cost" name="total_seed_cost" id="totalSeedCostInput" placeholder="Enter total seed cost" value="{{ old('total_seed_cost') }}" readonly>
                                            </div>
                                            
                                          </div>
                                          <br>
                                            <h3>b. Labor</h3><br>
                                  
                                            <div class="user-details">
                                                <div class="input-box col-md-4">
                                                    <span class="details">No of Person</span>
                                                    <input type="number" class="form-control light-gray-placeholder no_of_person" name="no_of_person" id="noOfPersonInput" placeholder="Enter no. of persons" value="{{ old('no_of_person') }}">
                                                </div>
                                                
                                                <div class="input-box col-md-4">
                                                    <span class="details">Rate per Person</span>
                                                    <input type="number" class="form-control light-gray-placeholder rate_per_person" name="rate_per_person" id="ratePerPersonInput" placeholder="Enter rate/person" value="{{ old('rate_per_person') }}">
                                                </div>
                                                
                                                <div class="input-box col-md-4">
                                                    <span class="details">Total Labor Cost (PHP)</span>
                                                    <input type="number" class="form-control light-gray-placeholder total_labor_cost" name="total_labor_cost" id="totalLaborCostInput" placeholder="Enter total labor cost" value="{{ old('total_labor_cost') }}" readonly>
                                                </div>
                                      </div>

                              <h3>c. Fertilizers </h3>
                                   <div class="user-details">
                             <div class="input-box col-md-4">
                                <span class="details">Name Of Fertilizer</span>
                                <div class="d-flex align-items-center">
                                    <select class="form-control custom-select light-gray-placeholder name_of_fertilizer @error('name_of_fertilizer') is-invalid @enderror" 
                                            name="name_of_fertilizer" 
                                            id="selectNameOfFertilizer" 
                                            onchange="checkNameOfFertilizer()" 
                                            aria-label="label select e">
                                        <option selected disabled>Select</option>
                                        <option value="Nitrogen Fertilizers" {{ old('name_of_fertilizer') == 'Nitrogen Fertilizers' ? 'selected' : '' }}>Nitrogen Fertilizers</option>
                                        <option value="Phosphorus Fertilizers" {{ old('name_of_fertilizer') == 'Phosphorus Fertilizers' ? 'selected' : '' }}>Phosphorus Fertilizers</option>
                                        <option value="Potassium Fertilizers" {{ old('name_of_fertilizer') == 'Potassium Fertilizers' ? 'selected' : '' }}>Potassium Fertilizers</option>
                                        <option value="Compound Fertilizers" {{ old('name_of_fertilizer') == 'Compound Fertilizers' ? 'selected' : '' }}>Compound Fertilizers</option>
                                        <option value="Organic Fertilizers" {{ old('name_of_fertilizer') == 'Organic Fertilizers' ? 'selected' : '' }}>Organic Fertilizers</option>
                                        <option value="Slow-Release Fertilizers" {{ old('name_of_fertilizer') == 'Slow-Release Fertilizers' ? 'selected' : '' }}>Slow-Release Fertilizers</option>
                                        <option value="Micronutrient Fertilizers" {{ old('name_of_fertilizer') == 'Micronutrient Fertilizers' ? 'selected' : '' }}>Micronutrient Fertilizers</option>
                                        <option value="Liquid Fertilizers" {{ old('name_of_fertilizer') == 'Liquid Fertilizers' ? 'selected' : '' }}>Liquid Fertilizers</option>
                                        <option value="other" {{ old('name_of_fertilizer') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <button type="button" id="removeNameOfFertilizerButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeNameOfFertilizer()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                                        
             
              
                            <div class="input-box col-md-4">
                                <span class="details">No. of Sacks</span>
                                <input type="number" id="noOfSacksInput" class="form-control light-gray-placeholder no_ofsacks" name="no_ofsacks" placeholder="Enter no of sacks" value="{{ old('no_ofsacks') }}">
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Unit Price per Sack (PHP)</span>
                                <input type="number" class="form-control light-gray-placeholder unitprice_per_sacks" name="unitprice_per_sacks" id="unitPricePerSacksInput" placeholder="Enter unit price/sack" value="{{ old('unitprice_per_sacks') }}">
                            </div>
                            
                            <div class="input-box col-md-4">
                                <span class="details">Total Cost Fertilizers (PHP)</span>
                                <input type="number" class="form-control light-gray-placeholder total_cost_fertilizers" name="total_cost_fertilizers" id="totalCostFertilizersInput" placeholder="Enter total cost" value="{{ old('total_cost_fertilizers') }}" readonly>
                            </div>
                            
                      </div>
                      <br>
                        <h3>d. Pesticides</h3><br>
              
                        <div class="user-details">
              
                         <div class="input-box col-md-4">
                            <span class="details">Pesticides Name</span>
                            <div class="d-flex align-items-center">
                                <select class="form-control custom-select light-gray-placeholder pesticides_name @error('pesticides_name') is-invalid @enderror" 
                                        name="pesticides_name" 
                                        id="selectPesticideName" 
                                        onchange="checkPesticideName()" 
                                        aria-label="Floating label select e">
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
                                <button type="button" id="removePesticideNameButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removePesticideName()">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>

              
                        <div class="input-box col-md-4">
                            <span class="details">Number of L or Kg</span>
                            <input type="number" class="form-control light-gray-placeholder no_of_l_kg" name="no_of_l_kg" id="noOfLKgInput" placeholder="Enter no of L or Kg" value="{{ old('no_of_l_kg') }}">
                        </div>
                        
                        <div class="input-box col-md-4">
                            <span class="details">Unit Price of Pesticides (PHP)</span>
                            <input type="number" class="form-control light-gray-placeholder unitprice_ofpesticides" name="unitprice_ofpesticides" id="unitPricePesticidesInput" placeholder="Enter unit price of pesticides" value="{{ old('unitprice_ofpesticides') }}">
                        </div>
                        
                        <div class="input-box col-md-4">
                            <span class="details">Total Cost Pesticides (PHP)</span>
                            <input type="number" class="form-control light-gray-placeholder total_cost_pesticides" name="total_cost_pesticides" id="totalCostPesticidesInput" placeholder="Enter total cost" value="{{ old('total_cost_pesticides') }}" readonly>
                        </div>
                        
                        
                  </div>
              
                  <h3>e. Transport & Variable Cost Total</h3><br>
              
                  <div class="user-details">
                  <div class="input-box col-md-4" >
                    <span class="details">Name of Vehicle</span>
                    <input type="text"class="form-control light-gray-placeholder type_of_vehicle" name="type_of_vehicle" id="unitPriceInput" placeholder="Enter type of vehicle" value="{{ old('type_of_vehicle') }}" onkeypress="return blockSymbolsAndNumbers(event)">
                  
                  </div>
              
                  <div class="input-box col-md-4">
                    <span class="details">Total Delivery Cost (PHP)</span>
                    <input type="number" class="form-control light-gray-placeholder total_transport_per_deliverycost" name="total_transport_per_deliverycost" id="totalDeliveryCostInput" placeholder="Enter total transport cost" value="{{ old('total_transport_per_deliverycost') }}">
                </div>
                  <div class="input-box col-md-4">
                    <span class="details">Total Machineries Fuel Cost (PHP)</span>
                    <input type="number" class="form-control light-gray-placeholder total_machinery_fuel_cost" name="total_machinery_fuel_cost" id="totalMachineryFuelCostInput" placeholder="Enter total fuel cost" value="{{ old('total_machinery_fuel_cost') }}">
                </div>
                
                  <div class="input-box col-md-4">
                    <span class="details">Total Variable Cost (PHP)</span>
                    <input type="number" class="form-control light-gray-placeholder total_variable_costs" name="total_variable_cost" id="totalVariableCostInput" placeholder="Enter total variable cost" value="{{ old('total_variable_cost') }}" readonly>
                </div>
              </div>

                                    </div>
                                </div>
                            </div> --}}
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
          <a href="{{route('admin.farmersdata.samplefolder.farm_edit')}}" class="btn btn-success">Famer Survey Form</a>
            <!-- Link to proceed to another page -->
            <a href="{{route('admin.farmersdata.genfarmers')}}" class="btn btn-success">Proceed to Farmer Info</a>
        </div>
      </div>
    </div>
  </div>
  
  

  
  {{-- <!-- Success Modal -->
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Success message will be displayed here -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="proceedToNextStep()">Proceed</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="errorModalBody">
                <!-- Error message will be displayed here -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


  
  
   --}}


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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let cropCounter = 0;
    let availableNumbers = [];
    let cropsInfo = [];
  

    function fetchCropNames() {
    $.ajax({
        url: '/admin-view-Farmers-survey-form',
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
        url: '/admin-view-Farmers-survey-form',
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


// Function to fetch crop varieties based on selected crop name
// function fetchCropSeeds(varietyId, selectElement) {
//     $.ajax({
//         url: '/admin-view-Farmers-survey-form',
//         method: 'GET',
//         data: { type: 'seedname', variety_name: varietyId },
//         success: function(response) {
//             if (response.error) {
//                 console.error('Error fetching crop seeds:', response.error);
//                 return;
//             }

//             // Console log the fetched seed data
//             console.log('Fetched seed data:', response);

//             const $seedSelect = $(selectElement).closest('.crop-section').find('.seed_name');
//             $seedSelect.empty();
//             $seedSelect.append('<option value="" disabled selected>Select Seed</option>');
            
//             // Add fetched seed options
//             $.each(response, function(id, seed) {
//                 $seedSelect.append(new Option(seed, id));
//             });

          
//         },
//         error: function(xhr) {
//             console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
//         }
//     });
// }



// // Bind change event to variety name dropdowns
// $(document).on('change', '.crop_variety', function() {
//     const varietyId = $(this).val();
//     if (varietyId) {
//         fetchCropSeeds(varietyId, this);
//     } else {
//         // Clear the seed dropdown if no variety is selected
//         $(this).closest('.crop-section').find('.seed_name').empty().append('<option value="" disabled selected>Select Seed</option>');
//           // Prompt for new seed name
//           var newSeedName = prompt("Please enter a new seed name:");
//             if (newSeedName) {
//                 var newSeedId = 'new_' + Date.now(); // Generate a unique ID for the new option
//                 $seedSelect.append(new Option(newSeedName, newSeedId));
//             }
//     }
// });
function fetchCropSeeds(varietyId, selectElement) {
    $.ajax({
        url: '/admin-view-Farmers-survey-form',
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
         flatpickr(`#datepicker`, {
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
                <input type="text" class="form-control light-gray-placeholder measurement"  name="crop_profiles[${}][sales][${saleCounter}][measurement]" id="measurement_${saleCounter}" placeholder="Enter measurement">
            </div>
            <div class="input-box col-md-3">
                <label for="unit_price_per_kg_${saleCounter}">Unit Price/kg:</label>
                <input type="text" class="form-control light-gray-placeholder unit_price_sold"  name="crop_profiles[${}][sales][${saleCounter}][unit_price]" id="unit_price_per_kg_${saleCounter}" placeholder="Enter unit price">
            </div>
            <div class="input-box col-md-3">
                <label for="quantity_${saleCounter}">Quantity:</label>
                <input type="text" class="form-control light-gray-placeholder quantity"  name="crop_profiles[${}][sales][${saleCounter}][quantity]" id="quantity_${saleCounter}" placeholder="Enter quantity">
            </div>
            <div class="input-box col-md-3">
                <label for="gross_income_${saleCounter}">Gross Income:</label>
                <input type="text" class="form-control light-gray-placeholder gross_income" name="crop_profiles[${}][sales][${saleCounter}][gross_income]" id="gross_income_${saleCounter}" placeholder="Enter gross income">
            </div>
            <div class="remove-button-container">
                <button type="button" class="btn btn-danger remove-sale-btn" onclick="removeSale(${}, ${saleCounter})">Remove Sale</button>
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
                        let soldTo = getValue('.sold_to', entry);
                        let measurement = getValue('.measurement', entry);
                        let unit_price_sold = getValue('.unit_price_sold', entry);
                        let quantity = getValue('.quantity', entry);
                        let grossIncometotal = getValue('.gross_income', entry);
                        
                        // Store sale data in the salesData array
                        if (soldTo || measurement || unit_price_sold || grossIncometotal) { // Only push if any field has a value
                            salesData.push({
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

    
//     const cropSections = document.querySelectorAll('#cropProfiles .crop-section','#salesSection .sale-entry');
        
//         // Initialize an array to store crop data
//         let cropInfo = [];
        

//     let cropName = getValue('.crop_name');
//     let cropVariety = getValue('.crop_variety');
//     let PreferredVariety = getValue('.preferred_variety');
//     let drySeason = getValue('.dry_season');
//     let wetSeason = getValue('.wet_season');
//     let noCroppingYear = getValue('.no_crop_year');
//     let YieldkgHa = getValue('.yield_kg_ha');
//     let farmid = getValue('.farm_id');
//     // Production
//     let seedType = getValue('.seed-type');
//     let seedUsed = getValue('.seed-used');
//     let seedSource = getValue('.seed-source');
//     let Unit = getValue('.unit');
//     let fertilizedUsed = getValue('.fertilized-used');
//     let pesticidesUsed = getValue('.pesticides-used');
//     let insecticidesUsed = getValue('.insecticides-used');
//     let areaplanted = getValue('.area-planted');
//     let Dateplanted = getValue('.date-planted');
//     let Dateharvested= getValue('.date-harvested');
//     let Yieldkg = getValue('.yield-kg');

//     // Fixed cost
//     let particular = getValue('.particular');
//     let no_of_Has = getValue('.no-has');
//     let costPer_has = getValue('.cost-has');
//     let TotalFixed = getValue('.total-amount');

//     // Machineries
//     let PlowingMachine = getValue('.plowing-machine');
//     let plow_status = getValue('.plow_status');
//     let no_of_plowing = getValue('.no_of_plowing');
//     let cost_per_plowing = getValue('.cost_per_plowing');
//     let plowing_cost = getValue('.plowing_cost');
//     let harro_machine = getValue('.harro_machine');
//     let harro_ownership_status = getValue('.harro_ownership_status');
//     let no_of_harrowing = getValue('.no_of_harrowing');
//     let cost_per_harrowing = getValue('.cost_per_harrowing');
//     let harrowing_cost_total = getValue('.harrowing_cost_total');
//     let harvest_machine = getValue('.harvest_machine');
//     let harvest_ownership_status = getValue('.harvest_ownership_status');
//     let no_of_Harvesting = getValue('.no_of_Harvesting');
//     let cost_per_Harvesting = getValue('.cost_per_Harvesting');
//     let Harvesting_cost_total = getValue('.Harvesting_cost_total');
//     let postharv_ownership_status = getValue('.postharv_ownership_status');
//     let postharves_machine = getValue('.postharves_machine');
//     let postharvestCost = getValue('.postharvestCost');
//     let total_cost_for_machineries = getValue('.total_cost_for_machineries');

//     // Variables cost
//     let var_seed_variety = getValue('.seed_name');
//     let seed_name = getValue('.seed_name');
//     let unit = getValue('.unit');
//     let quantity = getValue('.quantity');
//     let unit_price_seed = getValue('.unit_price_seed');
//     let total_seed_cost = getValue('.total_seed_cost');
//     let no_of_person = getValue('.no_of_person');
//     let rate_per_person = getValue('.rate_per_person');
//     let total_labor_cost = getValue('.total_labor_cost');
//     let name_of_fertilizer = getValue('.name_of_fertilizer');
//     let no_ofsacks = getValue('.no_ofsacks');
//     let unitprice_per_sacks = getValue('.unitprice_per_sacks');
//     let total_cost_fertilizers = getValue('.total_cost_fertilizers');
//     let pesticides_name = getValue('.pesticides_name');
//     let no_of_l_kg = getValue('.no_of_l_kg');
//     let unitprice_ofpesticides = getValue('.unitprice_ofpesticides');
//     let total_cost_pesticides = getValue('.total_cost_pesticides');
//     let type_of_vehicle = getValue('.type_of_vehicle');
//     let Total_DeliveryCost = getValue('.Total_DeliveryCost');
//     let total_machinery_fuel_cost = getValue('.total_machinery_fuel_cost');
//     let total_variable_costs = getValue('.total_variable_costs');

//     // Check if any field has value to avoid empty entries
//     let salesData = [];

//     let saleEntries = section.querySelectorAll('.sale-entry');
//     saleEntries.forEach((entry) => {
//         let saleId = entry.id.split('_')[2]; // Adjust based on your ID format

//         let soldTo = getValue('.sold_to');
//         let measurement = getValue('.measurement');
//         let unit_price_sold = getValue('.unit_price_sold');
//         let grossIncometotal = getValue('.gross_income');
        
//         // Store sale data
//         salesData.push({
//             saleId: saleId,
//             soldTo: soldTo,
//             measurement: measurement,
//             unit_price: unit_price_sold,
//             quantity: quantity,
//             grossIncome: grossIncometotal
//         });
//     });

//     cropInfo.push({
//         id: cropId,
//         crop_name: cropName,
//         variety: {
//             type_variety: cropVariety,
//             preferred: PreferredVariety,
//             wet_season: wetSeason,
//             dry_season: drySeason,
//             no_cropping_year: noCroppingYear,
//             yield_kg_ha: YieldkgHa,
//             farmId:farmid
//         },
//         production: {
//             seedtype: seedType,
//             seedUsed: seedUsed,
//             seedSource: seedSource,
//             unit: Unit,
//             fertilizedUsed: fertilizedUsed,
//             pesticidesUsed: pesticidesUsed,
//             insecticide: insecticidesUsed,
//             areaPlanted: areaplanted,
//             datePlanted: Dateplanted,
//             Dateharvested:Dateharvested,
//             yieldkg: Yieldkg
//         },
//         sales: salesData,
//         fixedCost: {
//             particular: particular,
//             no_of_has: no_of_Has,
//             costperHas: costPer_has,
//             TotalFixed: TotalFixed
//         },
//         machineries: {
//             PlowingMachine: PlowingMachine,
//             plow_status: plow_status,
//             no_of_plowing: no_of_plowing,
//             cost_per_plowing: cost_per_plowing,
//             plowing_cost: plowing_cost,
//             harro_machine: harro_machine,
//             harro_ownership_status: harro_ownership_status,
//             no_of_harrowing: no_of_harrowing,
//             cost_per_harrowing: cost_per_harrowing,
//             harrowing_cost_total: harrowing_cost_total,
//             harvest_machine: harvest_machine,
//             harvest_ownership_status: harvest_ownership_status,
//             no_of_Harvesting: no_of_Harvesting,
//             cost_per_Harvesting: cost_per_Harvesting,
//             Harvesting_cost_total: Harvesting_cost_total,
//             postharv_ownership_status: postharv_ownership_status,
//             postharves_machine: postharves_machine,
//             postharvestCost: postharvestCost,
//             total_cost_for_machineries: total_cost_for_machineries
//         },
//         variables: {
//             seed_name: seed_name,
//             unit: unit,
//             quantity: quantity,
//             unit_price_seed: unit_price_seed,
//             total_seed_cost: total_seed_cost,
//             no_of_person: no_of_person,
//             rate_per_person: rate_per_person,
//             total_labor_cost: total_labor_cost,
//             name_of_fertilizer: name_of_fertilizer,
//             no_ofsacks: no_ofsacks,
//             unitprice_per_sacks: unitprice_per_sacks,
//             total_cost_fertilizers: total_cost_fertilizers,
//             pesticides_name: pesticides_name,
//             no_of_l_kg: no_of_l_kg,
//             unitprice_ofpesticides: unitprice_ofpesticides,
//             total_cost_pesticides: total_cost_pesticides,
//             type_of_vehicle: type_of_vehicle,
//             Total_DeliveryCost: Total_DeliveryCost,
//             total_machinery_fuel_cost: total_machinery_fuel_cost,
//             total_variable_costs: total_variable_costs
//         }
//     });
// });

// console.log(cropInfo);


     
//   // Create the final data object
let dataobject = {
    'fixedcost':fixedcost,
    'machineries':machineries,
    'variables':variables,
    'salesData': salesData,
    'productions': production,
};

// Log the entire data object to the console for debugging
console.log("Data Object:", dataobject);

const csrfToken = $('input[name="_token"]').attr('value');

    // Send the AJAX request
    $.ajax({
        url: '/agent-add-farmer-production/{cropData}',
        method: 'POST',
        contentType: 'application/json', // Set content type for JSON
        data: JSON.stringify(dataobject), // Attach the prepared data here
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
        },
        success: function(response) {

            console.log(response);

            if(response.success) {
                console.log(response);
                console.log(response.success);
            }
        },
        error: function(error) {
            console.error('Error:', error.responseJSON.message);
        }
    }); 
}); 

// // Function to open confirmation modal with data preview
// function openConfirmModal(data) {
//     // Check and populate the modal with the farmer's details
//     $('#farmerFirstname').text(data.farmer?.first_name || 'N/A');
//     $('#farmerLastname').text(data.farmer?.last_name || 'N/A');
//     $('#farmerMiddleName').text(data.farmer?.middle_name || 'N/A');
//     $('#farmerExtensionName').text(data.farmer?.extension_name || 'N/A');
//     $('#farmerCountry').text(data.farmer?.country || 'N/A');
//     $('#farmerProvince').text(data.farmer?.province || 'N/A');
//     $('#farmerCity').text(data.farmer?.city || 'N/A');
//     $('#farmerAgriDistrict').text(data.farmer?.agri_district || 'N/A');
//     $('#farmerBarangay').text(data.farmer?.barangay || 'N/A');
//     $('#farmerStreet').text(data.farmer?.street || 'N/A');
//     $('#farmerZipCode').text(data.farmer?.zip_code || 'N/A');
//     $('#farmerContactNo').text(data.farmer?.contact_no || 'N/A');
//     $('#farmerSex').text(data.farmer?.sex || 'N/A');
//     $('#farmerReligion').text(data.farmer?.religion || 'N/A');
//     $('#farmerDateOfBirth').text(data.farmer?.date_of_birth || 'N/A');
//     $('#farmerPlaceOfBirth').text(data.farmer?.place_of_birth || 'N/A');
//     $('#farmerCivilStatus').text(data.farmer?.civil_status || 'N/A');
//     $('#farmerNameLegalSpouse').text(data.farmer?.name_legal_spouse || 'N/A');
//     $('#farmerNoOfChildren').text(data.farmer?.no_of_children || 'N/A');
//     $('#farmerMothersMaidenName').text(data.farmer?.mothers_maiden_name || 'N/A');
//     $('#farmerHighestFormalEducation').text(data.farmer?.highest_formal_education || 'N/A');
//     $('#farmerPersonWithDisability').text(data.farmer?.person_with_disability || 'N/A');
//     $('#farmerYespwdIdNo').text(data.farmer?.YEspwd_id_no || 'N/A');
//     $('#farmerNopwdIdNo').text(data.farmer?.Nopwd_id_no || 'N/A');
//     $('#farmerGovernmentIssuedId').text(data.farmer?.government_issued_id || 'N/A');
//     $('#farmerIdType').text(data.farmer?.id_type || 'N/A');
//     $('#farmerAddIdType').text(data.farmer?.add_Idtype || 'N/A');
//     $('#farmerNonGovIdTypes').text(data.farmer?.non_gov_id_types || 'N/A');
//     $('#farmerMemberOfAnyFarmers').text(data.farmer?.member_ofany_farmers || 'N/A');
//     $('#farmerNameOfFarmers').text(data.farmer?.nameof_farmers || 'N/A');
//     $('#farmerNoFarmersGroup').text(data.farmer?.NoFarmersGroup || 'N/A');
//     $('#farmerAddFarmersGroup').text(data.farmer?.add_FarmersGroup || 'N/A');
//     $('#farmerNameContactPerson').text(data.farmer?.name_contact_person || 'N/A');
//     $('#farmerCpTelNo').text(data.farmer?.cp_tel_no || 'N/A');
//     $('#farmerDateOfInterview').text(data.farmer?.date_of_interview || 'N/A');

//     // Check and populate the modal with the farm's details
//     $('#farmTenurialStatus').text(data.farm?.tenurial_status || 'N/A');
//     $('#farmAddress').text(data.farm?.farm_address || 'N/A');
//     $('#farmYearsAsFarmer').text(data.farm?.no_of_years_as_farmers || 'N/A');
//     $('#farmGpsLongitude').text(data.farm?.gps_longitude || 'N/A');
//     $('#farmGpsLatitude').text(data.farm?.gps_latitude || 'N/A');
//     $('#farmTotalPhysicalArea').text(data.farm?.total_physical_area_has || 'N/A');
//     $('#farmTotalAreaCultivated').text(data.farm?.total_area_cultivated_has || 'N/A');
//     $('#farmLandTitleNo').text(data.farm?.land_title_no || 'N/A');
//     $('#farmLotNo').text(data.farm?.lot_no || 'N/A');
//     $('#farmAreaProneTo').text(data.farm?.area_prone_to || 'N/A');
//     $('#farmEcosystem').text(data.farm?.ecosystem || 'N/A');
//     $('#farmRsbaRegister').text(data.farm?.rsba_register || 'N/A');
//     $('#farmPcicInsured').text(data.farm?.pcic_insured || 'N/A');
//     $('#farmGovernmentAssisted').text(data.farm?.government_assisted || 'N/A');
//     $('#farmSourceOfCapital').text(data.farm?.source_of_capital || 'N/A');
//     $('#farmRemarks').text(data.farm?.remarks || 'N/A');
//     $('#farmOcaDistrictOffice').text(data.farm?.oca_district_office || 'N/A');
//     $('#farmNameTechnicians').text(data.farm?.name_technicians || 'N/A');
//     $('#farmDateInterview').text(data.farm?.date_interview || 'N/A');

//     // Clear previous crop info from the modal
//     $('#cropAccordionBody').empty();

// // Loop through the crops and populate individual crop details in list format
// data.crops.forEach(function(crop, index) {
//     let cropHtml = `
//       <div class="crop-info">
//     <h3>Crop ${index + 1}</h3><br>
//     <div class="detail-grid">
//         <div class="detail-row">
//             <h4>Crop Information:</h4><br>
//             <ul class="list-unstyled">
                
//                 <li><strong>Crop Name:</strong> <span>${crop.crop_name || 'N/A'}</span></li>
//                 <li><strong>Crop Variety:</strong> <span>${crop.variety.type_variety || 'N/A'}</span></li>
//                 <li><strong>farm iD:</strong> <span>${crop.variety.farmId || 'N/A'}</span></li>
//                 <li><strong>Preferred Variety:</strong> <span>${crop.variety.preferred || 'N/A'}</span></li>
//                 <li><strong>Wet Season:</strong> <span>${crop.variety.wet_season || 'N/A'}</span></li>
//                 <li><strong>Dry Season:</strong> <span>${crop.variety.dry_season || 'N/A'}</span></li>
//                 <li><strong>Number of Cropping Years:</strong> <span>${crop.variety.no_cropping_year || 'N/A'}</span></li>
//                 <li><strong>Yield (kg/ha):</strong> <span>${crop.variety.yield_kg_ha || 'N/A'}</span></li>
//             </ul>
//         </div>

//         <div class="detail-row">
//             <h4>Production Details:</h4>
//             <ul class="list-unstyled">
//                 <li><strong>Seed Type:</strong> <span>${crop.production.seedtype || 'N/A'}</span></li>
//                 <li><strong>Seed Used:</strong> <span>${crop.production.seedUsed || 'N/A'}</span></li>
//                 <li><strong>Seed Source:</strong> <span>${crop.production.seedSource || 'N/A'}</span></li>
//                 <li><strong>Unit:</strong> <span>${crop.production.unit || 'N/A'}</span></li>
//                 <li><strong>Fertilizer Used:</strong> <span>${crop.production.fertilizedUsed || 'N/A'}</span></li>
//                 <li><strong>Pesticides Used:</strong> <span>${crop.production.pesticidesUsed || 'N/A'}</span></li>
//                 <li><strong>Insecticides Used:</strong> <span>${crop.production.insecticide || 'N/A'}</span></li>
//                 <li><strong>Area Planted:</strong> <span>${crop.production.areaPlanted || 'N/A'}</span></li>
//                 <li><strong>Date Planted:</strong> <span>${crop.production.datePlanted || 'N/A'}</span></li>
//                 <li><strong>Date Harvested:</strong> <span>${crop.production.Dateharvested || 'N/A'}</span></li>
//                 <li><strong>Yield (kg):</strong> <span>${crop.production.yieldkg || 'N/A'}</span></li>
//             </ul>
//         </div>

//         <div class="detail-row">
//             <h4>Fixed Costs:</h4>
//             <ul class="list-unstyled">
//                 <li><strong>Particular:</strong> <span>${crop.fixedCost.particular || 'N/A'}</span></li>
//                 <li><strong>Number of Hectares:</strong> <span>${crop.fixedCost.no_of_has || 'N/A'}</span></li>
//                 <li><strong>Cost per Hectare:</strong> <span>${crop.fixedCost.costperHas || 'N/A'}</span></li>
//                 <li><strong>Total Fixed Cost:</strong> <span>${crop.fixedCost.TotalFixed || 'N/A'}</span></li>
//             </ul>
//         </div>

//         <div class="detail-row">
//             <h4>Machineries:</h4>
//             <ul class="list-unstyled">
//                 <li><strong>Plowing Machine:</strong> <span>${crop.machineries.PlowingMachine || 'N/A'}</span></li>
//                 <li><strong>Plow Status:</strong> <span>${crop.machineries.plow_status || 'N/A'}</span></li>
//                 <li><strong>Number of Plowing:</strong> <span>${crop.machineries.no_of_plowing || 'N/A'}</span></li>
//                 <li><strong>Cost per Plowing:</strong> <span>${crop.machineries.cost_per_plowing || 'N/A'}</span></li>
//                 <li><strong>Plowing Cost:</strong> <span>${crop.machineries.plowing_cost || 'N/A'}</span></li>
//                 <li><strong>Harrow Machine:</strong> <span>${crop.machineries.harro_machine || 'N/A'}</span></li>
//                 <li><strong>Harrow Ownership Status:</strong> <span>${crop.machineries.harro_ownership_status || 'N/A'}</span></li>
//                 <li><strong>Number of Harrowing:</strong> <span>${crop.machineries.no_of_harrowing || 'N/A'}</span></li>
//                 <li><strong>Cost per Harrowing:</strong> <span>${crop.machineries.cost_per_harrowing || 'N/A'}</span></li>
//                 <li><strong>Harrowing Cost Total:</strong> <span>${crop.machineries.harrowing_cost_total || 'N/A'}</span></li>
//                 <li><strong>Harvest Machine:</strong> <span>${crop.machineries.harvest_machine || 'N/A'}</span></li>
//                 <li><strong>Harvest Ownership Status:</strong> <span>${crop.machineries.harvest_ownership_status || 'N/A'}</span></li>
//                 <li><strong>Number of Harvesting:</strong> <span>${crop.machineries.no_of_Harvesting || 'N/A'}</span></li>
//                 <li><strong>Cost per Harvesting:</strong> <span>${crop.machineries.cost_per_Harvesting || 'N/A'}</span></li>
//                 <li><strong>Harvesting Cost Total:</strong> <span>${crop.machineries.Harvesting_cost_total || 'N/A'}</span></li>
//                 <li><strong>Postharvest Machine:</strong> <span>${crop.machineries.postharves_machine || 'N/A'}</span></li>
//                 <li><strong>Postharvest Ownership Status:</strong> <span>${crop.machineries.postharvestCost || 'N/A'}</span></li>
//                 <li><strong>Postharvest Cost:</strong> <span>${crop.machineries.total_cost_for_machineries || 'N/A'}</span></li>
//             </ul>
//         </div>

//         <div class="detail-row">
//             <h4>Variable Costs:</h4>
//             <ul class="list-unstyled">
//                 <li><strong>Seed Name:</strong> <span>${crop.variables.seed_name || 'N/A'}</span></li>
//                 <li><strong>Unit:</strong> <span>${crop.variables.unit || 'N/A'}</span></li>
//                 <li><strong>Quantity:</strong> <span>${crop.variables.quantity || 'N/A'}</span></li>
//                 <li><strong>Unit Price Seed:</strong> <span>${crop.variables.unit_price_seed || 'N/A'}</span></li>
//                 <li><strong>Total Seed Cost:</strong> <span>${crop.variables.total_seed_cost || 'N/A'}</span></li>
//                 <li><strong>Number of Persons:</strong> <span>${crop.variables.no_of_person || 'N/A'}</span></li>
//                 <li><strong>Rate per Person:</strong> <span>${crop.variables.rate_per_person || 'N/A'}</span></li>
//                 <li><strong>Total Labor Cost:</strong> <span>${crop.variables.total_labor_cost || 'N/A'}</span></li>
//                 <li><strong>Name of Fertilizer:</strong> <span>${crop.variables.name_of_fertilizer || 'N/A'}</span></li>
//                 <li><strong>Number of Sacks:</strong> <span>${crop.variables.no_ofsacks || 'N/A'}</span></li>
//                 <li><strong>Unit Price per Sack:</strong> <span>${crop.variables.unit_price_per_sack || 'N/A'}</span></li>
//                 <li><strong>Total Cost of Fertilizers:</strong> <span>${crop.variables.total_cost_fertilizers || 'N/A'}</span></li>
//                 <li><strong>Pesticides Name:</strong> <span>${crop.variables.pesticides_name || 'N/A'}</span></li>
//                 <li><strong>Number of Liters/Kgs:</strong> <span>${crop.variables.no_of_liters || 'N/A'}</span></li>
//                 <li><strong>Unit Price of Pesticides:</strong> <span>${crop.variables.unit_price_of_pesticides || 'N/A'}</span></li>
//                 <li><strong>Total Cost of Pesticides:</strong> <span>${crop.variables.total_cost_of_pesticides || 'N/A'}</span></li>
//                 <li><strong>Insecticides Name:</strong> <span>${crop.variables.insecticides_name || 'N/A'}</span></li>
//                 <li><strong>Number of Liters/Kgs:</strong> <span>${crop.variables.no_of_liters_insecticides || 'N/A'}</span></li>
//                 <li><strong>Unit Price of Insecticides:</strong> <span>${crop.variables.unit_price_of_insecticides || 'N/A'}</span></li>
//                 <li><strong>Total Cost of Insecticides:</strong> <span>${crop.variables.total_cost_insecticides || 'N/A'}</span></li>
//                 <li><strong>Total Variable Costs:</strong> <span>${crop.variables.total_variable_cost || 'N/A'}</span></li>
//             </ul>
//         </div>
//     </div>
//  <br>
// </div>

//     `;

//     // Append the crop info HTML to the modal
//     $('#cropAccordionBody').append(cropHtml);
// });

//     $('#confirmModal').modal('show');
// }



// // // Call this function to show the confirmation modal when needed
// openConfirmModal(dataobject);

// /// Confirm and Save event
// $('#confirmSave').on('click', function() {
//     const csrfToken = $('input[name="_token"]').attr('value');

//     // Send the AJAX request
//     $.ajax({
//         url: '/agent-add-farmer-production/{cropData}',
//         method: 'POST',
//         contentType: 'application/json',
//         data: JSON.stringify(dataobject), // Attach the prepared data
//         headers: {
//             'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
//         },
//         success: function(response) {
//             console.log(response);
//             if (response.success) {
//                 var successModal = new bootstrap.Modal(document.getElementById('successModal'), {
//                         keyboard: false

//                     });
//                     successModal.show(); // Show success modal
                    
//                     // Close the confirmation modal after successful save
//                     var confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
//                     if (confirmModal) {
//                         confirmModal.hide();
//                     }
//                 }
//         },
//         error: function(xhr) {
//             console.error('Error:', xhr.responseJSON.error);

//             // Display the error message in the modal body
//             $('#errorModalBody').text(xhr.responseJSON.error);


//     // Show the modal
//     $('#errorModal').modal('show');
// }


//     });
// });
// });



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






// Function to populate organizations based on agri_district
// function populateOrganizations(agriDistrict) {
//     var organizationSelect = document.getElementById("SelectOrganization");

//     // Clear previous options
//     organizationSelect.innerHTML = '';

//     // AJAX call to get organizations
//     $.ajax({
//         url: '/admin-view-Farmers-survey-form',
//         method: 'GET',
//         data: { district: agriDistrict, type: 'organizations' },
//         success: function(response) {
//             console.log('Organizations Response:', response);

//             if (response.length > 0) {
//                 response.forEach(function(organization) {
//                     var option = document.createElement("option");
//                     option.text = organization.organization_name;
//                     option.value = organization.organization_name;
//                     organizationSelect.appendChild(option);
//                 });
//             } else {
//                 var noOption = document.createElement("option");
//                 noOption.text = "No organizations found";
//                 noOption.disabled = true;
//                 organizationSelect.appendChild(noOption);
//             }

//             // Option to add new organization
//             var addNewOption = document.createElement("option");
//             addNewOption.text = "Add New Organization";
//             addNewOption.value = "addNew";
//             organizationSelect.appendChild(addNewOption);
//         },
//         error: function(xhr, status, error) {
//             console.log("Error fetching organizations:", error);
//         }
//     });
// }

// // Function to handle the organization selection
// function handleOrganizationSelection() {
//     var organizationSelect = document.getElementById("SelectOrganization");
//     var selectedOption = organizationSelect.value;

//     if (selectedOption === "addNew") {
//         var newOrganization = prompt("Enter new organization name:");
//         if (newOrganization !== null && newOrganization !== "") {
//             // Add the new organization to the dropdown
//             var option = document.createElement("option");
//             option.text = newOrganization;
//             option.value = newOrganization;
//             organizationSelect.insertBefore(option, organizationSelect.lastChild); // Add option before the last option ("Add New Organization")
//             // Select the newly added organization
//             organizationSelect.value = newOrganization;
//         }
//     }
// }




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
    let saleCounter = 0;
    let saleAvailableNumbersMap = [];  // Track available sale numbers
    
    // Function to add a sale
    function addSale() {
        let currentSaleCounter;
    
        // Check if there are available numbers to reuse
        if (saleAvailableNumbersMap.length > 0) {
            // Use the lowest available sale number
            currentSaleCounter = saleAvailableNumbersMap.shift();
        } else {
            // Increment sale counter if no available numbers
            currentSaleCounter = saleCounter++;
        }
    
        // Add sale entry dynamically
        const salesSection = document.getElementById('salesSection');
        const newSaleEntry = `
            <div class="user-details sale-entry" id="saleEntry_${currentSaleCounter}">
                <div class="input-box col-md-3">
                    <label for="sold_to_${currentSaleCounter}">Sold To:</label>
                    <input type="text" class="form-control light-gray-placeholder sold_to" name="crop_profiles[0][sales][${currentSaleCounter}][sold_to]" id="sold_to_${currentSaleCounter}" placeholder="Enter sold to">
                </div>
                <div class="input-box col-md-3">
                    <label for="measurement_${currentSaleCounter}">Measurement/unit:</label>
                    <input type="text" class="form-control light-gray-placeholder measurement" name="crop_profiles[0][sales][${currentSaleCounter}][measurement]" id="measurement_${currentSaleCounter}" placeholder="Enter measurement">
                </div>
                <div class="input-box col-md-3">
                    <label for="unit_price_per_kg_${currentSaleCounter}">Unit Price/kg:</label>
                    <input type="number" class="form-control light-gray-placeholder unit_price_sold" name="crop_profiles[0][sales][${currentSaleCounter}][unit_price]" id="unit_price_per_kg_${currentSaleCounter}" placeholder="Enter unit price">
                </div>
                <div class="input-box col-md-3">
                    <label for="quantity_${currentSaleCounter}">Quantity:</label>
                    <input type="number" class="form-control light-gray-placeholder quantity" name="crop_profiles[0][sales][${currentSaleCounter}][quantity]" id="quantity_${currentSaleCounter}" placeholder="Enter quantity">
                </div>
                <div class="input-box col-md-3">
                    <label for="gross_income_${currentSaleCounter}">Gross Income:</label>
                    <input type="number" class="form-control light-gray-placeholder gross_income" name="crop_profiles[0][sales][${currentSaleCounter}][gross_income]" id="gross_income_${currentSaleCounter}" placeholder="Enter gross income">
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
    
            // Add the sale number back to available numbers for reuse
            saleAvailableNumbersMap.push(saleCounter);
    
            // Update visibility of remove buttons
            updateRemoveButtonVisibility();
        }
    }
    
    // Update visibility of the remove sale button
    function updateRemoveButtonVisibility() {
        const salesSection = document.getElementById('salesSection');
        const saleEntries = salesSection.querySelectorAll('.sale-entry');
    
        saleEntries.forEach(entry => {
            const removeButton = entry.querySelector('.remove-sale-btn');
            if (saleEntries.length <= 1) {
                removeButton.classList.add('hidden');
            } else {
                removeButton.classList.remove('hidden');
            }
        });
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

</script>
  @endsection
