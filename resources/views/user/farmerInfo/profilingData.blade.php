@extends('user.user_dashboard')
@section('user') 


<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->



<div id="profileContent" class="emp-profile mt-5">
    <div class="card border-0 shadow rounded">
        <div class="card-body">

            <form method="post" enctype="multipart/form-data">
                @foreach ($gpsData as $data) <!-- Loop through the gpsData array -->
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <div class="profile-img">
                            {{-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt="Profile Image" class="img-fluid rounded-circle" /> --}}
                            {{-- <div class="file btn btn-primary mt-2">
                                Change Photo
                                <input type="file" name="file" />
                            </div> --}}

                            @if ($user->image)
                            <img src="/agentimages/{{$user->image}}" alt="Profile Image" class="img-fluid rounded-circle">
                          @else
                            <img src="/upload/profile.jpg" alt="Profile Image" class="img-fluid rounded-circle">
                          @endif
                        </div>
                        <div class="profile-head text-center mt-3"> <!-- Centered the profile head -->
                            <h5 class="mb-1">{{ $data['farmerName'] }}</h5>
                            <h5  class="h5 rofile-rating">Age: <span>{{ $data['age'] }}</span></p> <!-- Age -->
                            {{-- <h5 class="mb-1">Web Developer and Designer</h5>
                            <p class="profile-rating">RANKINGS : <span class="text-success">8/10</span></p> --}}
                        </div>
                    </div>
                </div>
                

                <!-- Card-style Collapsible Table -->
                <div class="mt-4 row">
                    <div class="col-md-6">
                        <h4>Farmer Info</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#experienceDetails" aria-expanded="false" aria-controls="experienceDetails">
                            Personal Information
                        </div>
                        <div class="collapse" id="experienceDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                    @foreach ($gpsData as $data)
                                     <!-- Farmer Personal Information -->
                                  <!-- Personal Information -->
                            <h6 class="mt-2 highlight">I. Personal Information</h6>
                            <p>
                                <strong>Mother's Maiden Name:</strong>
                                <span class="highlight-target">
                                    {{ !empty($data['mothers_maiden_name']) ? ucwords(strtolower($data['mothers_maiden_name'])) : 'N/A' }}
                                </span>
                            </p>
                            <p>
                                <strong>Place of Birth:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['place_of_birth'])) }}</span>
                            </p>
                            <p>
                                <strong>Sex:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['sex'])) }}</span>
                            </p>
                            <p>
                                <strong>Religion:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['religion'])) }}</span>
                            </p>
                            <p>
                                <strong>Highest Formal Education:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['highest_formal_education'])) }}</span>
                            </p>
                            <p>
                                <strong>Person with Disability:</strong>
                                <span class="highlight-target">{{ $data['person_with_disability'] ? 'Yes' : 'No' }}</span>
                            </p>
                            <p>
                                <strong>PWD ID Number:</strong>
                                <span class="highlight-target">{{ $data['pwd_id_no'] }}</span>
                            </p>

                            <!-- Family Information -->
                            <h6 class="mt-2 highlight">II. Family Information</h6>
                            <p>
                                <strong>Civil Status:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['civilStatus'])) }}</span>
                            </p>
                            <p>
                                <strong>Legal Spouse:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['name_legal_spouse'])) }}</span>
                            </p>
                            <p>
                                <strong>No. of Children:</strong>
                                <span class="highlight-target">{{ $data['no_of_children'] }}</span>
                            </p>

                            <!-- Address Information -->
                            <h6 class="mt-2 highlight">III. Address Information</h6>
                            <p>
                                <strong>Home Address:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['homeAddress'])) }}</span>
                            </p>
                            <p>
                                <strong>Street:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['street'])) }}</span>
                            </p>
                            <p>
                                <strong>Zip Code:</strong>
                                <span class="highlight-target">{{ $data['zip_code'] }}</span>
                            </p>

                            <!-- Identification Information -->
                            <h6 class="mt-2 highlight">IV. Identification Information</h6>
                            <p>
                                <strong>Government ID Number:</strong>
                                <span class="highlight-target">{{ $data['gov_id_no'] }}</span>
                            </p>
                            <p>
                                <strong>ID Type:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['id_type'])) }}</span>
                            </p>

                            <!-- Contact Information -->
                            <h6 class="mt-2 highlight">V. Contact Information</h6>
                            <p>
                                <strong>Contact Number:</strong>
                                <span class="highlight-target">{{ $data['contact_no'] }}</span>
                            </p>

                            <!-- Organization Information -->
                            <h6 class="mt-2 highlight">VI. Organization Information</h6>
                            <p>
                                <strong>Organization:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['orgName'])) }}</span>
                            </p>

                            <!-- Emergency Contact Information -->
                            <h6 class="mt-2 highlight">VII. Emergency Contact Information</h6>
                            <p>
                                <strong>Contact Person:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['name_contact_person'])) }}</span>
                            </p>
                            <p>
                                <strong>Contact Person Telephone:</strong>
                                <span class="highlight-target">{{ $data['cp_tel_no'] }}</span>
                            </p>
                    @endforeach <!-- End loop -->
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-4">Production</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#skillsDetails" aria-expanded="false" aria-controls="skillsDetails">
                            Production Details
                        </div>
                        <div class="collapse" id="skillsDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                   
                                    @foreach ($farmProfiles as $farmProfile)
                                    @foreach ($farmProfile->cropFarms as $cropFarm)
                                    <p>Crop Farm: {{ ucwords(strtolower($cropFarm->crop_name)) }}</p>
                                    @foreach ($cropFarm->lastProductionDatas as $lastProductionData)
                                   <!-- Production Information -->
                                    <h6 class="mt-2 highlight">I. Production Information</h6>
                                    <p>
                                        <strong>Seed Type Used:</strong>
                                        <span class="highlight-target">{{ $lastProductionData->seeds_typed_used }}</span>
                                    </p>
                                    <p>
                                        <strong>Cropping No.:</strong>
                                        <span class="highlight-target">{{ $lastProductionData->cropping_no }}</span>
                                    </p>
                                    <p>
                                        <strong>Seed Source:</strong>
                                        <span class="highlight-target">{{ $lastProductionData->seed_source }}</span>
                                    </p>
                                    <p>
                                        <strong>Unit:</strong>
                                        <span class="highlight-target">{{ $lastProductionData->unit }}</span>
                                    </p>

                                    <!-- Fertilizer and Pesticide Usage -->
                                    <h6 class="mt-2 highlight">II. Fertilizer and Pesticide Usage</h6>
                                    <p>
                                        <strong>No. of Fertilizer Used (in bags):</strong>
                                        <span class="highlight-target">{{ number_format($lastProductionData->no_of_fertilizer_used_in_bags, 2) }}</span>
                                    </p>
                                    <p>
                                        <strong>No. of Pesticides Used (in L/Kg):</strong>
                                        <span class="highlight-target">{{ number_format($lastProductionData->no_of_pesticides_used_in_l_per_kg, 2) }}</span>
                                    </p>
                                    <p>
                                        <strong>No. of Insecticides Used (in bags):</strong>
                                        <span class="highlight-target">{{ number_format($lastProductionData->no_of_insecticides_used_in_l, 2) }}</span>
                                    </p>

                                    <!-- Planting and Harvest Information -->
                                    <h6 class="mt-2 highlight">III. Planting and Harvest Information</h6>
                                    <p>
                                        <strong>Area Planted:</strong>
                                        <span class="highlight-target">{{ number_format($lastProductionData->area_planted, 2) }}</span>
                                    </p>
                                    <p>
                                        <strong>Date Planted:</strong>
                                        <span class="highlight-target">{{ \Carbon\Carbon::parse($lastProductionData->date_planted)->format('F d, Y') }}</span>
                                    </p>
                                    <p>
                                        <strong>Date Harvested:</strong>
                                        <span class="highlight-target">{{ \Carbon\Carbon::parse($lastProductionData->date_harvested)->format('F d, Y') }}</span>
                                    </p>

                                    <!-- Yield Information -->
                                    <h6 class="mt-2 highlight">IV. Yield Information</h6>
                                    <p>
                                        <strong>Yield (Tons/Kg):</strong>
                                        <span class="highlight-target">{{ number_format($lastProductionData->yield_tons_per_kg, 2) }}</span>
                                    </p>

                                    
                                    
                                   
                                @endforeach
                                    @endforeach
                                    @endforeach
                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side New Section -->
                    <div class="col-md-6">
                        <h4>Farm</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#projectsDetails" aria-expanded="false" aria-controls="projectsDetails">
                          Farm Profile Details
                        </div>
                        <div class="collapse" id="projectsDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                    @foreach ($gpsData as $data)
                                    <!-- Farmer Personal Information -->
                                    <!-- Farm Information -->
                                <h6 class="mt-2 highlight">I. Farm Information</h6>
                                <p>
                                    <strong>Tenurial Status:</strong>
                                    <span class="highlight-target">{{ ucwords(strtolower($data['tenurial_status'])) }}</span>
                                </p>
                                <p>
                                <strong>Farm Address:</strong>
                                <span class="highlight-target">
                                    {{ !empty($data['FarmAddress']) ? ucwords(strtolower($data['FarmAddress'])) : 'N/A' }}
                                </span>
                                </p>
                                <p>
                                <strong>No. of years as Farmer:</strong>
                                <span class="highlight-target">{{ number_format($data['NoYears'], 1) }}</span>
                                </p>
                                <p>
                                    <strong>Total Physical Area:</strong>
                                    <span class="highlight-target">{{ number_format($data['totalPhysicalArea'], 1) }}</span>
                                </p>
                                <p>
                                    <strong>Total Area Cultivated:</strong>
                                    <span class="highlight-target">{{ number_format($data['TotalCultivated'], 1) }}</span>
                                </p>
                                <p>
                                <strong>Area Prone To:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['area_prone_to'])) }}</span>
                                </p>
                                <p>
                                <strong>Ecosystem:</strong>
                                <span class="highlight-target">{{ ucwords(strtolower($data['ecosystem'])) }}</span>
                                </p>

                                <!-- Registration and Insurance Information -->
                                <h6 class="mt-2 highlight">II. Registration and Insurance Information</h6>
                                <p>
                                    <strong>RSBA Registered:</strong>
                                    <span class="highlight-target">{{ $data['rsba_registered'] ? 'Yes' : 'No' }}</span>
                                </p>
                                <p>
                                    <strong>PCIC Insured:</strong>
                                    <span class="highlight-target">{{ $data['pcic_insured'] ? 'Yes' : 'No' }}</span>
                                </p>
                                <p>
                                    <strong>Government Assisted:</strong>
                                    <span class="highlight-target">{{ $data['government_assisted'] ? 'Yes' : 'No' }}</span>
                                </p>
                                <p>
                                    <strong>Source Capital:</strong>
                                    <span class="highlight-target">{{ ucwords(strtolower($data['source_of_capital'])) }}</span>
                                </p>

                                <!-- Crop Information -->
                                <h6 class="mt-2 highlight">II. Crop Information</h6>
                                <p>
                                    <strong>Crop Name:</strong>
                                    <span class="highlight-target">{{ ucwords(strtolower($data['cropName'])) }}</span>
                                </p>
                                <p>
                                <strong>Crop Variety Planted:</strong>
                                <span class="highlight-target">
                                    {{ !empty($data['cropVariety']) ? ucwords(strtolower($data['cropVariety'])) : 'N/A' }}
                                </span>
                                </p>
                                <p>
                                <strong>No. of Cropping/Year:</strong>
                                <span class="highlight-target">{{ number_format($data['croppingperYear']) }}</span>
                                </p>
                                <p>
                                <strong>Planting Schedule (Wet Season):</strong>
                                <span class="highlight-target">{{ (($data['planting_schedule_wetseason'])) }}</span>
                                </p>
                                <p>
                                    <strong>Planting Schedule (Dry Season):</strong>
                                    <span class="highlight-target">{{ (($data['planting_schedule_dryseason'])) }}</span>
                                </p>

                                <!-- Production Information -->
                                <h6 class="mt-2 highlight">IV. Production Information</h6>
                                <p>
                                    <strong>Yield Kg/Tons:</strong>
                                    <span class="highlight-target">{{ number_format($data['Yield'], 2) }}</span>
                                </p>
                               
                                @endforeach <!-- End loop -->
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-4">Variable Cost</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#certificationsDetails" aria-expanded="false" aria-controls="certificationsDetails">
                            Variable Cost Details
                        </div>
                        <div class="collapse" id="certificationsDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6 mt-1 mb-3">
                                            @foreach ($farmProfiles as $farmProfile)
                                                @foreach ($farmProfile->cropFarms as $cropFarm)
                                                   
                                                    @foreach ($cropFarm->variableCosts as $variableCostsData)
                                                      <h6 class="mt-2 highlight">a. Seed</h6>
                                                    <p>
                                                        <strong>Seed Name:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->seed_name)) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Unit:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->unit)) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Quantity:</strong>
                                                        <span class="highlight-target">{{ $variableCostsData->quantity }}</span> <!-- Assuming you meant to display the number of hectares here -->
                                                    </p>
                                                    <p>
                                                        <strong>Unit price (Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->unit_price,2) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Total Cost (Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->total_seed_cost,2) }}</span>
                                                    </p>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </div>
                                    
                                        <!-- Right Column -->
                                        <div class="col-md-6  mt-1 mb-3">
                                            @foreach ($farmProfiles as $farmProfile)
                                                @foreach ($farmProfile->cropFarms as $cropFarm)
                                                   
                                    
                                                    @foreach ($cropFarm->variableCosts as $variableCostsData)
                                                      <h6 class="mt-2 highlight">b. Labor</h6>
                                                    <p>
                                                        <strong>No. of person:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->labor_no_of_person)) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Rate/Person:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->rate_per_person)) }}</span>
                                                    </p>
                                                  
                                                    <p>
                                                        <strong>Total Cost (Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->total_labor_cost,2) }}</span>
                                                    </p>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </div>
    
    
                                        <div class="col-md-6 mt-1">
                                            @foreach ($farmProfiles as $farmProfile)
                                                @foreach ($farmProfile->cropFarms as $cropFarm)
                                                  
                                                    @foreach ($cropFarm->variableCosts as $variableCostsData)
                                                      <h6 class="mt-2 highlight">c. Fertilizer</h6>
                                                    <p>
                                                        <strong>Fertilizer name:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->name_of_fertilizer)) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Type of Fertilizer:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->type_of_fertilizer)) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>No. of Sacks:</strong>
                                                        <span class="highlight-target">{{ $variableCostsData->no_of_sacks }}</span> <!-- Assuming you meant to display the number of hectares here -->
                                                    </p>
                                                    <p>
                                                        <strong>Cost/Sacks (Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->unit_price_per_sacks,2) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Total Cost (Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->total_cost_fertilizers,2) }}</span>
                                                    </p>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </div>
                                    
                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            @foreach ($farmProfiles as $farmProfile)
                                                @foreach ($farmProfile->cropFarms as $cropFarm)
                                                    
                                    
                                                    @foreach ($cropFarm->variableCosts as $variableCostsData)
                                                      <h6 class="mt-2 highlight">d. Pesticides</h6>
                                                    <p>
                                                        <strong>Pesticide name:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->pesticide_name)) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Type of Pesticide:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->type_of_pesticides)) }}</span>
                                                    </p>
                                                   
                                                    <p>
                                                        <strong> No. of l/kg:</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->no_of_l_kg,2) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Cost/Pesticides(Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->unit_price_of_pesticides,2) }}</span>
                                                    </p>
                                                    <p>
                                                        <strong>Total Cost (Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->total_cost_pesticides,2) }}</span>
                                                    </p>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </div>
                                   
                                        <div class="col-md-6 mt-1">
                                            @foreach ($farmProfiles as $farmProfile)
                                                @foreach ($farmProfile->cropFarms as $cropFarm)
                                                  
                                                    @foreach ($cropFarm->variableCosts as $variableCostsData)
                                                      <h6 class="mt-2 highlight">e. Transport</h6>
                                                    <p>
                                                        <strong>Vehicle name:</strong>
                                                        <span class="highlight-target">{{ ucwords(strtolower($variableCostsData->type_of_vehicle)) }}</span>
                                                    </p>
                                                  
                                                    <p>
                                                        <strong>Total Cost (Php):</strong>
                                                        <span class="highlight-target">{{ number_format($variableCostsData->total_transport_delivery_cost,2) }}</span>
                                                    </p>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </div>
                                        
                                            <!-- Right Column -->
                                            <div class="col-md-6 mt-2">
                                                @foreach ($farmProfiles as $farmProfile)
                                                    @foreach ($farmProfile->cropFarms as $cropFarm)
                                        
                                                        @foreach ($cropFarm->variableCosts as $variableCostsData)
                                                          <h6 class="mt-2 highlight">e. Total Variable Cost</h6>
                                                        
                                                        <p>
                                                            <strong>Total Fuel Cost (Php):</strong>
                                                                <span class="highlight-target">{{ number_format($variableCostsData->total_machinery_fuel_cost,2) }}</span>
                                                            </p>
                                        
                                                            <p>
                                                                <strong>Total Cost (Php):</strong>
                                                                    <span class="highlight-target">{{ number_format($variableCostsData->total_variable_cost,2) }}</span>
                                                                </p>
                                                        @endforeach
                                        
                                                    @endforeach
                                                @endforeach
                                            </div>
                                       
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 row">
                    <div class="col-md-6">
                        <h4>Fixed Cost</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#fixedCostDetails" aria-expanded="false" aria-controls="fixedCostDetails">
                            FixedCost Details
                        </div>
                        <div class="collapse" id="fixedCostDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                    @foreach ($farmProfiles as $farmProfile)
                                    @foreach ($farmProfile->cropFarms as $cropFarm)
                                    {{-- <p>Crop Farm: {{ ucwords(strtolower($cropFarm->crop_name)) }}</p> --}}
                                    @foreach ($cropFarm->fixedCosts as $fixedCostsData)
                                    <p>
                                        <strong>Particular:</strong>
                                        <span class="highlight-target">{{ $fixedCostsData->Particular }}</span>
                                    </p>
                                    <p>
                                        <strong>No. of Ha:</strong>
                                        <span class="highlight-target"> {{number_format($fixedCostsData->no_of_ha,2) }}</span>
                                    </p>
                                    <p>
                                        <strong>Cost per Ha:</strong>
                                        <span class="highlight-target">{{ number_format($fixedCostsData->cost_per_ha,2) }}</span>
                                    </p>
                                    <p>
                                        <strong>Total Fixed Cost:</strong>
                                        <span class="highlight-target">{{ number_format($fixedCostsData->total_fixed,2) }}</span>
                                    </p>
                                @endforeach
                                    @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-4">Yield/Crop</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#machineDetails" aria-expanded="false" aria-controls="machineDetails">
                            Production Yield/Crop Details
                        </div>
                        <div class="collapse" id="machineDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                    
                                   
                                        <!-- Placeholder for the Pie Chart -->
                                        {{-- <canvas id="cropPieChart" width="400" height="400"></canvas> --}}
                                        <div id="cropPieChart"></div>

                                  
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side New Section -->
                    <div class="col-md-6">
                        <h4>Machineries Cost</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#machineriesDetails" aria-expanded="false" aria-controls="machineriesDetails">
                            Machineries Cost Details
                        </div>
                        <div class="collapse" id="machineriesDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                  
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6 mt-1 mb-3">
                                        @foreach ($farmProfiles as $farmProfile)
                                            @foreach ($farmProfile->cropFarms as $cropFarm)
                                               
                                                @foreach ($cropFarm->machineries as $machineriesData)
                                                 <h6 class="mt-2 highlight">a. Plowing</h6>
                                                <p>
                                                    <strong>Machineries Used:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->plowing_machineries_used)) }}</span>
                                                </p>
                                                <p>
                                                    <strong>Ownership Status:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->plo_ownership_status)) }}</span>
                                                </p>
                                                <p>
                                                    <strong>No. of Plowing:</strong>
                                                    <span class="highlight-target">{{ $machineriesData->no_of_plowing }}</span> <!-- Assuming you meant to display the number of hectares here -->
                                                </p>
                                                <p>
                                                    <strong>Cost/Plowing (Php):</strong>
                                                    <span class="highlight-target">{{ number_format($machineriesData->plowing_cost,2) }}</span>
                                                </p>
                                                <p>
                                                    <strong>Total Cost (Php):</strong>
                                                    <span class="highlight-target">{{ number_format($machineriesData->plowing_cost_total,2) }}</span>
                                                </p>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                
                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        @foreach ($farmProfiles as $farmProfile)
                                            @foreach ($farmProfile->cropFarms as $cropFarm)
                                               
                                
                                                @foreach ($cropFarm->machineries as $machineriesData)
                                                 <h6 class="mt-2 highlight">b. Harrowing</h6>
                                                <p>
                                                    <strong>Machineries Used:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->harrowing_machineries_used)) }}</span>
                                                </p>
                                                <p>
                                                    <strong>Ownership Status:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->harro_ownership_status)) }}</span>
                                                </p>
                                                <p>
                                                    <strong>No. of Harrow:</strong>
                                                    <span class="highlight-target">{{ $machineriesData->no_of_harrowing }}</span> <!-- Assuming you meant to display the number of hectares here -->
                                                </p>
                                                <p>
                                                    <strong>Cost/Harrow (Php):</strong>
                                                    <span class="highlight-target">{{ number_format($machineriesData->harrowing_cost,2) }}</span>
                                                </p>
                                                <p>
                                                    <strong>Total Cost (Php):</strong>
                                                    <span class="highlight-target">{{ number_format($machineriesData->harrowing_cost_total,2) }}</span>
                                                </p>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>


                                    <div class="col-md-6 mt-1">
                                        @foreach ($farmProfiles as $farmProfile)
                                            @foreach ($farmProfile->cropFarms as $cropFarm)
                                              
                                                @foreach ($cropFarm->machineries as $machineriesData)
                                                 <h6 class="mt-2 highlight">c. Harvesting</h6>
                                                <p>
                                                    <strong>Machineries Used:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->harvesting_machineries_used)) }}</span>
                                                </p>
                                                <p>
                                                    <strong>Ownership Status:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->harvest_ownership_status)) }}</span>
                                                </p>
                                                {{-- <p>
                                                    <strong>No. of harvest:</strong>
                                                    <span class="highlight-target">{{ $machineriesData->no_of_harvesting }}</span> <!-- Assuming you meant to display the number of hectares here -->
                                                </p> --}}
                                                <p>
                                                    <strong>Cost/harvest (Php):</strong>
                                                    <span class="highlight-target">{{ number_format($machineriesData->harvesting_cost,2) }}</span>
                                                </p>
                                                <p>
                                                    <strong>Total Cost (Php):</strong>
                                                    <span class="highlight-target">{{ number_format($machineriesData->harvesting_cost_total,2) }}</span>
                                                </p>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                
                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        @foreach ($farmProfiles as $farmProfile)
                                            @foreach ($farmProfile->cropFarms as $cropFarm)
                                                
                                
                                                @foreach ($cropFarm->machineries as $machineriesData)
                                                 <h6 class="mt-2 highlight">d. PostHarvest</h6>
                                                <p>
                                                    <strong>Machineries Used:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->postharvest_machineries_used)) }}</span>
                                                </p>
                                                <p>
                                                    <strong>Ownership Status:</strong>
                                                    <span class="highlight-target">{{ ucwords(strtolower($machineriesData->postharv_ownership_status)) }}</span>
                                                </p>
                                               
                                                <p>
                                                    <strong>Total Cost (Php):</strong>
                                                    <span class="highlight-target">{{ number_format($machineriesData->post_harvest_cost_total,2) }}</span>
                                                </p>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                               
                                       
                                    
                                        <!-- Right Column -->
                                        <div class="col-md-6 mt-2">
                                            @foreach ($farmProfiles as $farmProfile)
                                                @foreach ($farmProfile->cropFarms as $cropFarm)
                                    
                                                    @foreach ($cropFarm->machineries as $machineriesData)
                                                        <p>
                                                            <h6>Total Cost For Machineries:</h6>
                                                            <span class="highlight-target">{{ ucwords(strtolower($machineriesData->total_cost_for_machineries)) }}</span>
                                                        </p>
                                    
                                                       
                                                    @endforeach
                                    
                                                @endforeach
                                            @endforeach
                                        </div>
                                   
                                    
                                </div>
                                
                                
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-4">Gross Income</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#GrossIncome" aria-expanded="false" aria-controls="GrossIncome">
                            Gross Income per Crops Details
                        </div>
                        <div class="collapse" id="GrossIncome">
                            <div class="card mt-2">
                                <div class="card-body">
                                   
                                        <!-- Placeholder for the Pie Chart -->
                                        <div id="grossIncomeChart"></div>

                                   
                                </div>
                            </div>
                        </div>
                        <h4 class="mt-4">Yield/Cropping</h4>
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#croppingDetails" aria-expanded="false" aria-controls="croppingDetails">
                            Yield/Cropping Details
                        </div>
                        <div class="collapse" id="croppingDetails">
                            <div class="card mt-2">
                                <div class="card-body">
                                    
                                    <div id="yieldChart"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                  

                        
                    </div>
                    </div>
                </div>
                @endforeach <!-- End loop -->
                <!-- Buttons for Download and Print -->
                <div class="row mt-4">
                    <div class="col-md-12 text-end">
                        {{-- <button type="button" class="btn btn-outline-primary me-2"id="downloadBtn">Download Profile</button> --}}
                        <button type="button" class="btn btn-outline-success" onclick="printProfile()">Print Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .collapse-header {
        cursor: pointer; /* Make header clickable */
        background-color: #f8f9fa; /* Background color for better visibility */
        padding: 10px; /* Padding for better spacing */
        border: 1px solid #dee2e6; /* Add border to match card styling */
        border-radius: 0.25rem; /* Rounded corners */
        margin-top: 10px; /* Margin for separation */
    }

    .collapse-header:hover {
        background-color: #e9ecef; /* Change background on hover */
    }

    .card-body {
        padding: 77px; /* Adjusted padding for the card body */
        border-radius: 0.25rem; /* Rounded corners */
    }

    .card {
        margin-top: 77px; /* Space between card and previous elements */
    }
    .highlight {
    background-color:#dee2e6; /* Change to your preferred highlight color */
    padding: 2px; /* Optional */
    border-radius: 4px; /* Optional */
    /* color: ffffff; Set text color to white */
}
</style>





<style>
       
.emp-profile{
    padding: 3%;
    margin-top: 50%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    margin-top: 2rem;
    text-align: center;
}
.profile-img img{
    width: 20%;
    height: 50%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
@media print {
    body {
        margin: 0; /* Remove default body margin */
    }

    #profileContent {
        width: 100%; /* Use full width of the page */
    }

    /* Hide elements that shouldn't be in the PDF */
    .no-print {
        display: none; /* Add this class to elements you want to hide */
    }
    
    /* Adjust any specific styles for print here */
}
/* Prevent breaking of specific elements across pages */
#profileContent, .collapse-header, .card-body {
    page-break-inside: avoid;
}
/* Remove space above the profile */
#profileContent {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

/* Optional: Remove margin and padding from the body if needed */
body {
    margin: 0;
    padding: 0;
}

/* Collapse headers and card bodies */
.collapse-header {
    margin-top: 0 !important; /* Remove any top margin */
}

.card-body {
    margin-top: 0 !important; /* Remove any top margin */
    padding-top: 5px !important; /* Adjust padding for a more compact fit */
}
.chart-value-container {
    display: flex;
    flex-direction: column;
    align-items: center; /* Center align items */
    margin-top: 10px; /* Space between chart and values */
    font-family: Arial, sans-serif; /* Font styling */
}

.chart-value-container div {
    margin: 2px 0; /* Space between individual values */
    font-size: 14px; /* Font size for the values */
}

</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Ensure you have Bootstrap JavaScript and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script> --}}
<script>

// document.getElementById('downloadBtn').addEventListener('click', function () {
//     const element = document.getElementById('profileContent');

//     // Ensure all collapsible sections are expanded
//     const collapseHeaders = document.querySelectorAll('.collapse-header');
//     collapseHeaders.forEach(header => {
//         if (!header.classList.contains('open')) {  // Ensure they open if closed
//             header.click();
//         }
//     });

//     // Function to check if all images are loaded
//     const waitForImages = () => {
//         return new Promise((resolve) => {
//             const images = element.getElementsByTagName('img');
//             let loadedImages = 0;

//             if (images.length === 0) {
//                 resolve(); // No images, resolve immediately
//             }

//             for (let img of images) {
//                 if (img.complete) {
//                     loadedImages++;
//                 } else {
//                     img.onload = () => {
//                         loadedImages++;
//                         if (loadedImages === images.length) {
//                             resolve();
//                         }
//                     };
//                 }
//             }

//             if (loadedImages === images.length) {
//                 resolve(); // All images already loaded
//             }
//         });
//     };

//     // Wait for collapsibles to expand and images to load, then download the PDF
//     waitForImages().then(() => {
//         const options = {
//             margin: 0.5, // Reduced margin
//             filename: 'profile.pdf',
//             image: { type: 'jpeg', quality: 0.98 },
//             html2canvas: { 
//                 scale: 1.2, // Adjust scale for better fit
//                 useCORS: true, // Handle cross-origin images
//                 windowWidth: document.documentElement.scrollWidth // Capture full width
//             },
//             jsPDF: { 
//                 unit: 'in', 
//                 format: 'letter', 
//                 orientation: 'portrait'  // Fit more content vertically
//             },
//             pagebreak: { 
//                 mode: ['avoid-all', 'css', 'legacy'] // Manage page breaks properly
//             }
//         };

//         html2pdf().from(element).set(options).save();
//     });
// });




// Function to print the profile
// Function to print the profile
function printProfile() {
    // Get the profile content
    const printContents = document.querySelector('.emp-profile').innerHTML;
    
    // Optionally, highlight specific elements within the profile
    const profileElement = document.querySelector('.emp-profile');
    const elementsToHighlight = profileElement.querySelectorAll('.highlight-target'); // Adjust the selector as needed

    // Add highlight class
    elementsToHighlight.forEach(element => {
        element.classList.add('.highlight-target');
    });

    // Save the original content
    const originalContents = document.body.innerHTML;

    // Set the body content to the profile content
    document.body.innerHTML = printContents;

    // Print the content
    window.print();

    // Restore the original content
    document.body.innerHTML = originalContents;

    // // Reload the page to restore any dynamic elements
    window.location.reload();
}



</script>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
// $(document).ready(function() {
//     const userId = {{ auth()->user()->id }}; // Get the authenticated user ID dynamically

//     // Perform the AJAX request to fetch the crop data when the page loads
//     $.ajax({
//         url: `/user-farmer-Profiling`, // Update with your actual route URL
//         method: 'GET',
//         success: function(response) {
//             // Check if data is returned successfully
//             if (response && response.formattedData) {
//                 const cropData = response.formattedData;

//                 // Function to capitalize the first letter of a string
//                 const capitalizeFirstLetter = (label) => {
//                     return label.charAt(0).toUpperCase() + label.slice(1).toLowerCase();
//                 };

//                 // Format crop labels to have capitalized first letters
//                 const formattedLabels = cropData.labels.map(capitalizeFirstLetter);

//                 // Ensure previous chart is cleared if it exists
//                 const ctx = document.getElementById("cropPieChart").getContext("2d");
//                 const existingChart = Chart.getChart("cropPieChart"); // Get existing chart instance

//                 if (existingChart) {
//                     existingChart.destroy(); // Destroy existing chart if present
//                 }

//                 // Create a new pie chart with the fetched data
//                 const chartOptions = {
//                     type: 'pie',
//                     data: {
//                         labels: formattedLabels, // Use formatted labels
//                         datasets: [{
//                             label: 'Production Yield Per Crop',
//                             data: cropData.data, // Series data (yield per crop)
//                             backgroundColor: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'],
//                             borderColor: '#fff',
//                             borderWidth: 1
//                         }]
//                     },
//                     options: {
//                         responsive: true,
//                         plugins: {
//                             legend: {
//                                 position: 'bottom',
//                                 labels: {
//                                     usePointStyle: true, // Use point style for circular labels
//                                     pointStyle: 'circle' // Make labels circular
//                                 }
//                             },
//                             tooltip: {
//                                 callbacks: {
//                                     label: function(tooltipItem) {
//                                         return `${tooltipItem.label}: ${tooltipItem.raw.toFixed(2)} kg`; // Display yield in tons
//                                     }
//                                 },
//                                 // Custom tooltip styling to make it circular
//                                 // backgroundColor: 'rgba(255, 255, 255, 0.9)',
//                                 borderColor: '#ddd',
//                                 borderWidth: 1,
//                                 borderRadius: 10
//                             }
//                         }
//                     }
//                 };

//                 // Initialize the chart using Chart.js
//                 const chart = new Chart(ctx, chartOptions);
//             } else {
//                 console.error('No data returned from the server.');
//             }
//         },
//         error: function(error) {
//             console.error('Error fetching data:', error);
//         }
//     });
// });
$(document).ready(function() {
    const userId = {{ auth()->user()->id }}; // Get the authenticated user ID dynamically

    // Perform the AJAX request to fetch the crop data when the page loads
    $.ajax({
        url: `/user-farmer-Profiling`, // Update with your actual route URL
        method: 'GET',
        success: function(response) {
            // Check if data is returned successfully
            if (response && response.formattedData) {
                const cropData = response.formattedData;

                // Function to capitalize the first letter of a string
                const capitalizeFirstLetter = (label) => {
                    return label.charAt(0).toUpperCase() + label.slice(1).toLowerCase();
                };

                // Format crop labels to have capitalized first letters
                const formattedLabels = cropData.labels.map(capitalizeFirstLetter);

                // Prepare the chart options for ApexCharts
                const options = {
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    series: cropData.data, // Series data (yield per crop)
                    labels: formattedLabels, // Use formatted labels
                    colors: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return `${value.toFixed(2)} kg`; // Display yield in kg
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            const index = opts.seriesIndex; // Get index of the current slice
                            const actualValue = cropData.data[index]; // Get the actual value for this slice
                            return `${formattedLabels[index]}: ${actualValue.toFixed(2)} kg`; // Display yield in kg directly
                        },
                        dropShadow: {
                            enabled: true,
                            top: 1,
                            left: 1,
                            blur: 1,
                            opacity: 0.45
                        }
                    }
                };

                // Initialize the chart using ApexCharts
                const chart = new ApexCharts(document.querySelector("#cropPieChart"), options);
                chart.render();
            } else {
                console.error('No data returned from the server.');
            }
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
});


// $(document).ready(function() {
//     const userId = {{ auth()->user()->id }}; // Get the authenticated user ID dynamically

//     // Function to capitalize the first letter of a string
//     const capitalizeFirstLetter = (label) => {
//         return label.charAt(0).toUpperCase() + label.slice(1).toLowerCase();
//     };

//     // Perform the AJAX request to fetch the gross income data
//     $.ajax({
//         url: `/user-farmer-Profiling`, // Update with your actual route URL
//         method: 'GET',
//         success: function(response) {
//             // Check if data is returned successfully
//             if (response && response.formattedIncomeData) {
//                 const incomeData = response.formattedIncomeData;

//                 // Capitalize the first letter of each label
//                 const capitalizedLabels = incomeData.labels.map(label => capitalizeFirstLetter(label));

//                 // Ensure previous chart is cleared if it exists
//                 const ctx = document.getElementById("grossIncomeChart").getContext("2d");
//                 const existingChart = Chart.getChart("grossIncomeChart"); // Get existing chart instance

//                 if (existingChart) {
//                     existingChart.destroy(); // Destroy existing chart if present
//                 }

//                 // Create a new line chart with the fetched data
//                 const chartOptions = {
//                     type: 'line',
//                     data: {
//                         labels: capitalizedLabels, // Use capitalized labels
//                         datasets: [{
//                             label:capitalizedLabels , // Capitalized dataset label
//                             data: incomeData.data, // Series data (gross income per crop)
//                             borderColor: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'], // Line color
//                             backgroundColor: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'], // Area color
//                             borderWidth: 2,
//                             fill: true // Fill the area under the line
                           
//                         }]
//                     },
//                     options: {
//                         responsive: true,
//                         plugins: {
//                             legend: {
//                                 display: true,
//                                 position: 'bottom',
//                                 labels: {
//                                     usePointStyle: true, // Use point style for circular labels
//                                     pointStyle: 'circle' // Make labels circular
//                                 }
//                             },
//                             tooltip: {
//                                 callbacks: {
//                                     label: function(tooltipItem) {
//                                         return `${tooltipItem.label}: Php${tooltipItem.raw.toFixed(2)}`; // Format display
//                                     }
//                                 }
                                
//                             }
//                         },
//                         scales: {
//                             y: {
//                                 beginAtZero: true,
//                                 title: {
//                                     display: true,
//                                     text: 'Gross Income (Php)',
//                                 }
//                             },
//                             x: {
//                                 title: {
//                                     display: true,
//                                     text: 'Crops',
//                                 }
//                             }
//                         }
//                     }
//                 };

//                 // Initialize the chart using Chart.js
//                 const chart = new Chart(ctx, chartOptions);
//             } else {
//                 console.error('No data returned from the server.');
//             }
//         },
//         error: function(error) {
//             console.error('Error fetching data:', error);
//         }
//     });
// });
$(document).ready(function() {
    const userId = {{ auth()->user()->id }}; // Get the authenticated user ID dynamically

    // Function to capitalize the first letter of a string
    const capitalizeFirstLetter = (label) => {
        return label.charAt(0).toUpperCase() + label.slice(1).toLowerCase();
    };

    // Perform the AJAX request to fetch the gross income data
    $.ajax({
        url: `/user-farmer-Profiling`, // Update with your actual route URL
        method: 'GET',
        success: function(response) {
            // Check if data is returned successfully
            if (response && response.formattedIncomeData) {
                const incomeData = response.formattedIncomeData;

                // Capitalize the first letter of each label
                const capitalizedLabels = incomeData.labels.map(label => capitalizeFirstLetter(label));

                // Prepare the chart options for ApexCharts
                const options = {
                    chart: {
                        type: 'line',
                        height: 350,
                        zoom: {
                            enabled: false
                        }
                    },
                    series: [{
                        name: 'Gross Income',
                        data: incomeData.data // Series data (gross income per crop)
                    }],
                    xaxis: {
                        categories: capitalizedLabels, // Use capitalized labels for X-axis
                        title: {
                            text: 'Crops'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Gross Income (Php)'
                        },
                        min: 0 // Start Y-axis at 0
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return `Php ${value.toFixed(2)}`; // Format tooltip display
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    markers: {
                        size: 5,
                        hover: {
                            size: 8 // Size of markers on hover
                        }
                    },
                    colors: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'] // Line colors
                };

                // Initialize the chart using ApexCharts
                const chart = new ApexCharts(document.querySelector("#grossIncomeChart"), options);
                chart.render();
            } else {
                console.error('No data returned from the server.');
            }
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
});


// $(document).ready(function() {
//     // Fetch the data using jQuery AJAX
//     $.ajax({
//         url: '/user-farmer-Profiling', // Update with your actual route
//         method: 'GET',
//         dataType: 'json',
//         success: function(data) {
//             const ctx = document.getElementById('yieldChart').getContext('2d');

//             const yieldChart = new Chart(ctx, {
//                 type: 'bar',
//                 data: {
//                     labels: data.labels, // Cropping numbers
//                     datasets: [{
//                         label: 'Total Yield (Tons)',
//                         data: data.yields, // Yield data in tons
//                         backgroundColor: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'],
//                         borderColor: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'],
//                         borderWidth: 1
//                     }]
//                 },
//                 options: {
//                     scales: {
//                         y: {
//                             beginAtZero: true,
//                             title: {
//                                 display: true,
//                                 text: 'Yield (Tons)'
//                             }
//                         },
//                         x: {
//                             title: {
//                                 display: true,
//                                 text: 'Cropping Number'
//                             }
//                         }
//                     },
//                     plugins: {
//                         legend: {
//                             display: true,
//                             position: 'bottom', // Set legend position to bottom
//                             labels: {
//                                     usePointStyle: true, // Use point style for circular labels
//                                     pointStyle: 'circle' // Make labels circular
//                                 }
//                         }
//                     }
//                 }
//             });
//         },
//         error: function(xhr, status, error) {
//             console.error('Error fetching data:', error);
//         }
//     });
// });
$(document).ready(function() {
    // Fetch the data using jQuery AJAX
    $.ajax({
        url: '/user-farmer-Profiling', // Update with your actual route
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Prepare options for the ApexCharts bar chart
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Total Yield (Tons)',
                    data: data.yields // Yield data in tons
                }],
                xaxis: {
                    categories: data.labels, // Cropping numbers
                    title: {
                        text: 'Cropping Number'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Yield (Tons)'
                    },
                    min: 0 // Start y-axis from 0
                },
                legend: {
                    position: 'bottom',
                    markers: {
                        shape: 'circle', // Make labels circular
                    }
                },
                colors: ['#009e2e', '#FFCE56', '#e3004d', '#4BC0C0', '#9966FF', '#FF9F40', '#ff0000'], // Specify your colors
            };

            // Create the chart
            var yieldChart = new ApexCharts(document.querySelector("#yieldChart"), options);
            yieldChart.render();
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
});


</script>

@endsection