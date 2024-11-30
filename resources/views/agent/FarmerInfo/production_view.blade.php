@extends('agent.agent_Dashboard')

@section('agent')
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

                    
                    <h4>Production Data</h4>
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
                       
                
                        <label for="personainfo">Production</label>
                        
                        <div class="tab">
                        
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{-- <a href="" title="Back">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </a> --}}

                                {{-- <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button> --}}
                            
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                {{-- @if(isset($cropData) && $productionData->isEmpty()) --}}
                                <a href="{{ route('agent.FarmerInfo.product.new_data', $cropData->id) }}" title="Add Crop Production">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
                            {{-- @endif --}}
                            
                       
                            </div>
                              
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back"></a>
                                 <div class="input-group mb-3">
                                    @if($personalInfos->isNotEmpty())
                                        @foreach($personalInfos as $personalInfo)
                                            <h5 for="personainfo">
                                                Farmer: {{ $personalInfo->first_name . ' ' . $personalInfo->last_name }}
                                            </h5>
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No personal information available.</h5>
                                    @endif
                                </div>
                                
                                   
                              
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">

                                 </a>
                              
                                  <!-- Check if farm profile exists -->
                        <div class="input-group mb-3">
                            @if($farmProfile)
                                <h5>Farm: {{ $farmProfile->tenurial_status ?? 'N/A' }}</h5>
                            @else
                                <h5>No farm information available.</h5>
                            @endif
                        </div>
                                            

                            </div>
                         
                                <div class="user-details">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
        
                                         </a>
                                      
                                 <!-- Check if crop data exists -->
                                 <div class="input-group mb-3">
                                    @if($productionData->isNotEmpty())
                                        <h5>Crop Name: </h5>
                                
                                        @php
                                            // Array to store displayed crop names
                                            $displayedCrops = [];
                                        @endphp
                                
                                        @foreach($productionData as $production)
                                            @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                                <h5>  {{ $production->crop->crop_name }}</h5>
                                                <!-- Add more crop-related data here if necessary -->
                                
                                                @php
                                                    // Add the crop name to the displayedCrops array to avoid duplication
                                                    $displayedCrops[] = $production->crop->crop_name;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @else
                                        <h5>No crop data available.</h5>
                                    @endif
                                </div>
                                

                                   
        
                                    </div>
                                </div>
                       
                            
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                            <th>#</th>
                                           
                                            <th>cropping <p>no</p></th>
                                            <th>seed <p>type used</p></th>
                                            <th>seeds used <p>in kg</p></th>
                                     
                                        
                                            <th>area <p>planted</p></th>
                                            <th>date <p>planted</p></th>
                                            <th>date <p>harvested</p></th>
                                            <th>Yield</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($productionData->count() > 0)
                                    @foreach($productionData as $lastproductdata)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $lastproductdata->id }}</td>
                                   

                                    <td>
                                        @if ($lastproductdata->cropping_no && strtolower($lastproductdata->cropping_no) !== 'n/a')
                                            {{ $lastproductdata->cropping_no }}
                                        @endif
                                    </td>
                                    
                                    
                                     
                                      <td>
                                        @if ($lastproductdata->seeds_typed_used && strtolower($lastproductdata->seeds_typed_used) !== 'n/a')
                                            {{ $lastproductdata->seeds_typed_used }}
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if ($lastproductdata->seeds_used_in_kg && strtolower($lastproductdata->seeds_used_in_kg) !== 'n/a')
                                            {{ number_format($lastproductdata->seeds_used_in_kg,2)}}
                                        @endif
                                    </td>
                                
                                    
                                    <td>
                                        @if ($lastproductdata->area_planted && strtolower($lastproductdata->area_planted) !== 'n/a')
                                            {{ $lastproductdata->area_planted}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->date_planted && strtolower($lastproductdata->date_planted) !== 'n/a')
                                            {{ $lastproductdata->date_planted}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->date_harvested && strtolower($lastproductdata->date_harvested) !== 'n/a')
                                            {{ $lastproductdata->date_harvested}}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($lastproductdata->yield_tons_per_kg && strtolower($lastproductdata->yield_tons_per_kg) !== 'n/a')
                                            {{ number_format($lastproductdata->yield_tons_per_kg,2)}}
                                        @endif
                                    </td>
                                   

                       <td>
                       
                   
                        <a href="javascript:void(0);" class="viewProductionBtn" data-bs-toggle="modal" data-bs-target="#productionModal" data-id="{{ $lastproductdata->id }}">
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="javascript:void(0);" class="viewProductionArchive" data-bs-toggle="modal" title="View Production Archive Data" data-bs-target="#ArchiveProduction" data-id="{{$lastproductdata->id }}">
                            <button class="btn btn-warning btn-sm" style="border-color: #54d572;">
                                <img src="../assets/logo/history.png" alt="Crop Icon" style="width: 20px; height: 20px;" class="me-1">
                                <i class="fas fa-rice" aria-hidden="true"></i>
                            </button>
                        </a>                                        
                        <a href="{{route('agent.FarmerInfo.product.edit', $lastproductdata->id)}}" title="view farm"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('agent.FarmerInfo.product.delete', $lastproductdata->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                           {{-- {{ csrf_field()}} --}}@csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                       </form>

                       </td>
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="9">Production Data is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                
                                <!-- Pagination links -->
                                {{-- <ul class="pagination">
                                    <li><a href="{{ $farmData->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($farmData->getUrlRange(max(1, $farmData->currentPage() - 1), min($farmData->lastPage(), $farmData->currentPage() + 1)) as $page => $url)
                                    <li class="{{ $page == $farmData->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                    <li><a href="{{ $farmData->nextPageUrl() }}">Next</a></li>
                                </ul> --}}

                            </div>
                            <!-- Pagination links -->
                            <div class="button-container mt-3 d-flex justify-content-between">
                                <a href="{{ route('agent.FarmerInfo.crops_view', $cropData->farm_profiles_id) }}" button type="button" class="btn btn-primary" onclick="goBack()">Back</button></a>
                              
                            </div>
                            
                            
                        </div>


    

                    {{-- fixed cosat data --}}

                    <input type="radio" name="tabs" id="Fixed" checked="checked">
                        <label for="Fixed">Fixed Cost</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{-- <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button> --}}
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                @if(isset($cropData) && $fixedData->isEmpty())
                                <a href="{{ route('agent.FarmerInfo.fixed.add_view',$cropData->id) }}" title="Add Crop Production">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
                            @endif
                                {{-- <a href="{{route('agent.FarmerInfo.fixed.add_view',$cropData->id)}}" title="Add Fixed Cost">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a> --}}
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                              
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
                                    
                                      
                                  
                                 </a>
                                 <div class="input-group mb-3">
                                    @if($personalInfos->isNotEmpty())
                                        @foreach($personalInfos as $personalInfo)
                                            <h5 for="personainfo">
                                                Farmer: {{ $personalInfo->first_name . ' ' . $personalInfo->last_name }}
                                            </h5>
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No personal information available.</h5>
                                    @endif
                                </div>
                              
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">

                                 </a>
                              
                                    <!-- Check if farm profile exists -->
                                <div class="input-group mb-3">
                                    @if($farmProfile)
                                        <h5>Farm: {{ $farmProfile->tenurial_status ?? 'N/A' }}</h5>
                                    @else
                                        <h5>No farm information available.</h5>
                                    @endif
                                </div>
                           

                            </div>
                            <div class="user-details">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
    
                                     </a>
                                      <!-- Check if crop data exists -->
                                      <div class="input-group mb-3">
                                        @if($productionData->isNotEmpty())
                                            <h5>Crop Name: </h5>
                                    
                                            @php
                                                // Array to store displayed crop names
                                                $displayedCrops = [];
                                            @endphp
                                    
                                            @foreach($productionData as $production)
                                                @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                                    <h5>  {{ $production->crop->crop_name }}</h5>
                                                    <!-- Add more crop-related data here if necessary -->
                                    
                                                    @php
                                                        // Add the crop name to the displayedCrops array to avoid duplication
                                                        $displayedCrops[] = $production->crop->crop_name;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @else
                                            <h5>No crop data available.</h5>
                                        @endif
                                    </div>
                               
    
                                </div
                              >
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                             <th>#</th>
                                         
                                            <th>particular</th>
                                            <th>no_of_ha</th>
                                            <th>cost_per_ha</th>
                                            <th>total_amount</th>
                                        
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($fixedData->count() > 0)
                                    @foreach($fixedData as $fixedcost)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $fixedcost->id }}</td>
                               
                            <td>
                                @if ($fixedcost->particular && $fixedcost->particular != 'N/A')
                                    {{ $fixedcost->particular }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($fixedcost->no_of_ha && $fixedcost->no_of_ha != 'N/A')
                                    {{ $fixedcost->no_of_ha }}
                                @else
                                
                                @endif
                            </td>
                           
                                <td>
                                    @if ($fixedcost->cost_per_ha && strtolower($fixedcost->cost_per_ha) != 'n/a')
                                        {{ number_format($fixedcost->cost_per_ha,2) }}
                                    @else
                                    
                                    @endif
                                </td>
                                <td>
                                    @if ($fixedcost->total_amount && strtolower($fixedcost->total_amount) != 'n/a')
                                        {{ number_format($fixedcost->total_amount,2) }}
                                    @else
                                    
                                    @endif
                                </td>


                       <td>
                        <!-- Button trigger modal -->
                    <!-- Link with data-id attribute to store the fixed cost ID -->
                            <a href="javascript:void(0);" class="viewFixedCostBtn" data-bs-toggle="modal" data-bs-target="#fixedcostModal" data-id="{{ $fixedcost->id }}">
                                <button class="btn btn-success btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </a>

                        <a href="{{route('agent.FarmerInfo.fixed.edit_view', $fixedcost->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('agent.FarmerInfo.fixed.delete', $fixedcost->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                       @csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                       </form>
                          
                       </td>
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Fixed Cost Data is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{-- <!-- Pagination links -->
                                <ul class="pagination">
                                    <li><a href="{{ $fixedcosts->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($fixedcosts->getUrlRange(max(1, $fixedcosts->currentPage() - 1), min($fixedcosts->lastPage(), $fixedcosts->currentPage() + 1)) as $page => $url)
                                    <li class="{{ $page == $fixedcosts->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                    <li><a href="{{ $fixedcosts->nextPageUrl() }}">Next</a></li>
                                </ul> --}}
                            </div>
  
                        </div> {{-- end fixed cost --}}

                        
                         {{-- machineries data --}}
                        <input type="radio" name="tabs" id="machine" checked="checked">
                        <label for="machine">Machineries Cost</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                               
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                {{-- @if(isset($cropData) && $machineriesData->isEmpty())
                                <a href="{{ route('agent.FarmerInfo.fixed.add_view',$cropData->id) }}" title="Add Crop Production">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
                            @endif --}}
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                              
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
                                    
                                      
                                  
                                 </a>
                                 <div class="input-group mb-3">
                                    @if($personalInfos->isNotEmpty())
                                        @foreach($personalInfos as $personalInfo)
                                            <h5 for="personainfo">
                                                Farmer: {{ $personalInfo->first_name . ' ' . $personalInfo->last_name }}
                                            </h5>
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No personal information available.</h5>
                                    @endif
                                </div>
                                   
                              
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">

                                 </a>
                              
                                           <!-- Check if farm profile exists -->
                                            <div class="input-group mb-3">
                                                @if($farmProfile)
                                                    <h5>Farm: {{ $farmProfile->tenurial_status ?? 'N/A' }}</h5>
                                                @else
                                                    <h5>No farm information available.</h5>
                                                @endif
                                            </div>
                           

                            </div>
                            <div class="user-details">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
    
                                     </a>
                                  
                                      <!-- Check if crop data exists -->
                                      <div class="input-group mb-3">
                                        @if($productionData->isNotEmpty())
                                            <h5>Crop Name: </h5>
                                    
                                            @php
                                                // Array to store displayed crop names
                                                $displayedCrops = [];
                                            @endphp
                                    
                                            @foreach($productionData as $production)
                                                @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                                    <h5>  {{ $production->crop->crop_name }}</h5>
                                                    <!-- Add more crop-related data here if necessary -->
                                    
                                                    @php
                                                        // Add the crop name to the displayedCrops array to avoid duplication
                                                        $displayedCrops[] = $production->crop->crop_name;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @else
                                            <h5>No crop data available.</h5>
                                        @endif
                                    </div>
    
                                </div
                              >
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                            <th>#</th>
                                        
                                            
                                            <th>plowing <p>cost</p></th>
                                           
                                            <th>harrowing <p>cost</p></th>
                                            
                                            <th>harvest <p>cost</p></th>
                                        
                                            <th>post harvest <p>cost</p></th>
                                            <th>total cost <p> machineries</p></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($machineriesData->count() > 0)
                                    @foreach($machineriesData as $machineriesused)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $machineriesused->id }}</td>
                                   
                               
                            
                                <td>
                                    @if ($machineriesused->plowing_cost && $machineriesused->plowing_cost != 'N/A')
                                        {{ number_format($machineriesused->plowing_cost,2) }}
                                    @else
                                    
                                    @endif
                                </td>

                              
                            <td>
                            @if ($machineriesused->harrowing_cost && strtolower($machineriesused->harrowing_cost) != 'n/a')
                                {{ number_format($machineriesused->harrowing_cost,2) }}
                            @else
                                
                            @endif
                        </td>
                       
                        <td>
                        @if ($machineriesused->harrowing_cost_total && strtolower($machineriesused->harrowing_cost_total) != 'n/a')
                            {{ number_format($machineriesused->harrowing_cost_total,2) }}
                        @else
                            
                        @endif
                    </td>

                  
                    
                    <td>
                    @if ($machineriesused->post_harvest_cost && strtolower($machineriesused->post_harvest_cost) != 'n/a')
                        {{ number_format($machineriesused->post_harvest_cost,2) }}
                    @else
                    
                    @endif
                    </td>
                    <td>
                    @if ($machineriesused->total_cost_for_machineries && strtolower($machineriesused->total_cost_for_machineries) != 'n/a')
                        {{ number_format($machineriesused->total_cost_for_machineries,2) }}
                    @else
                    
                    @endif
                    </td>
                    

                 

                   
                       <td>
                        <a href="javascript:void(0);" class="viewMachineCostBtn" data-bs-toggle="modal" data-bs-target="#MachineModal" data-id="{{ $machineriesused->id}}">
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="{{route('agent.FarmerInfo.machineries.edit_view', $machineriesused->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
              
                        <form  action="{{ route('agent.FarmerInfo.machineries.delete', $machineriesused->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                           {{-- {{ csrf_field()}} --}}@csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> </button>
                       </form> 
                          
                       </td>
                   </tr>               @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5">Machineries cost Data is empty</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{-- <!-- Pagination links -->
                            <ul class="pagination">
                                <li><a href="{{ $fixedcosts->previousPageUrl() }}">Previous</a></li>
                                @foreach ($fixedcosts->getUrlRange(max(1, $fixedcosts->currentPage() - 1), min($fixedcosts->lastPage(), $fixedcosts->currentPage() + 1)) as $page => $url)
                                <li class="{{ $page == $fixedcosts->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                                <li><a href="{{ $fixedcosts->nextPageUrl() }}">Next</a></li>
                            </ul> --}}
                        </div>
                        </div>

                            {{-- variable cost --}}
                        
                        <input type="radio" name="tabs" id="variable" checked="checked">
                        <label for="variable">Variable Cost</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{-- <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button> --}}
                                
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                {{-- <a href="" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a> --}}
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                              
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
                                    
                                      
                                  
                                 </a>
                                 <div class="input-group mb-3">
                                    @if($personalInfos->isNotEmpty())
                                        @foreach($personalInfos as $personalInfo)
                                            <h5 for="personainfo">
                                                Farmer: {{ $personalInfo->first_name . ' ' . $personalInfo->last_name }}
                                            </h5>
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No personal information available.</h5>
                                    @endif
                                </div>
                                
                              
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">

                                 </a>
                              
                                   <!-- Check if farm profile exists -->
                                            <div class="input-group mb-3">
                                                @if($farmProfile)
                                                    <h5>Farm: {{ $farmProfile->tenurial_status ?? 'N/A' }}</h5>
                                                @else
                                                    <h5>No farm information available.</h5>
                                                @endif
                                            </div>
                           

                            </div>
                            <div class="user-details">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
    
                                     </a>
                                  
                                          <!-- Check if crop data exists -->
                                          <div class="input-group mb-3">
                                            @if($productionData->isNotEmpty())
                                                <h5>Crop Name: </h5>
                                        
                                                @php
                                                    // Array to store displayed crop names
                                                    $displayedCrops = [];
                                                @endphp
                                        
                                                @foreach($productionData as $production)
                                                    @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                                        <h5>  {{ $production->crop->crop_name }}</h5>
                                                        <!-- Add more crop-related data here if necessary -->
                                        
                                                        @php
                                                            // Add the crop name to the displayedCrops array to avoid duplication
                                                            $displayedCrops[] = $production->crop->crop_name;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @else
                                                <h5>No crop data available.</h5>
                                            @endif
                                        </div>
    
                                </div
                              >
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                                                
                                            <th>#</th>
                                        
                                            <th>seed cost</th>
                                            <th>labor <p>cost</p></th>
                                            <th>fertilizer<p>cost</p></th>
                                            <th>pesticides<p>cost</p></th>
                                            <th>transport<p>cost</p></th>
                                            <th>total machinery <p> cost</p> </th>
                                            <th>total variable <p> cost</p></th>
                                           
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($variableData->count() > 0)
                                    @foreach($variableData as $vartotal)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $vartotal->id }}</td>
        
                                      <td>
                                        @if (!is_null($vartotal->total_seed_cost) && $vartotal->total_seed_cost && strtolower($vartotal->total_seed_cost) != 'n/a')
                                            {{ number_format($vartotal->total_seed_cost, 2) }}
                                        @else
                                           
                                             
                                           
                                          
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($vartotal->total_labor_cost) &&$vartotal->total_labor_cost && strtolower($vartotal->total_labor_cost) != 'n/a')
                                            {{ number_format($vartotal->total_labor_cost, 2) }}
                                        @else
                                           
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($vartotal->total_cost_fertilizers) &&$vartotal->total_cost_fertilizers && strtolower($vartotal->total_cost_fertilizers) != 'n/a')
                                            {{ number_format($vartotal->total_cost_fertilizers, 2) }}
                                        @else
                                          
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($vartotal->total_cost_pesticides) && $vartotal->total_cost_pesticides && strtolower($vartotal->total_cost_pesticides) != 'n/a')
                                            {{ number_format($vartotal->total_cost_pesticides, 2) }}
                                        @else
                                          
                                               
                                          
                                        @endif
                                    </td>
                                    <td>
                                        @if (!is_null($vartotal->total_transport_delivery_cost) &&$vartotal->total_transport_delivery_cost && strtolower($vartotal->total_transport_delivery_cost) != 'n/a')
                                            {{ number_format($vartotal->total_transport_delivery_cost, 2) }}
                                        @else
                                            
                                        @endif
                                    </td>
                                    
                                                        <td>
                                                            @if ($vartotal->total_machinery_fuel_cost && strtolower($vartotal->total_machinery_fuel_cost) != 'n/a')
                                                                {{ number_format($vartotal->total_machinery_fuel_cost,2) }}
                                                            @else
                                                            
                                                            @endif
                                                            </td>
                                                            <td>
                                                                @if ($vartotal->total_variable_cost && strtolower($vartotal->total_variable_cost) != 'n/a')
                                                                    {{ number_format($vartotal->total_variable_cost,2) }}
                                                             @else
                                                                
                                                         @endif
                                                    </td>
 
                                                <td>
                                                    <a href="javascript:void(0);" class="viewVariableCostBtn" data-bs-toggle="modal" data-bs-target="#VariableModal" data-id="{{ $vartotal->id}}">
                                                        <button class="btn btn-success btn-sm">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{route('agent.FarmerInfo.variable.edit',  $vartotal->id)}}" title="Edit Student"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                                                    <form  action="{{ route('agent.FarmerInfo.variable.delete', $vartotal->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                   @csrf
                                                       @method('DELETE')
                                                       <button type="submit" class="btn btn-danger btn-sm" title="Delete Student" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                   </form> 
                                                    
                                                </td>
                                            </tr>               @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="5">Variable cost Data is empty</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{-- <!-- Pagination links -->
                            <ul class="pagination">
                                <li><a href="{{ $fixedcosts->previousPageUrl() }}">Previous</a></li>
                                @foreach ($fixedcosts->getUrlRange(max(1, $fixedcosts->currentPage() - 1), min($fixedcosts->lastPage(), $fixedcosts->currentPage() + 1)) as $page => $url)
                                <li class="{{ $page == $fixedcosts->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                                <li><a href="{{ $fixedcosts->nextPageUrl() }}">Next</a></li>
                            </ul> --}}
                        </div>
                        </div>


                        <input type="radio" name="tabs" id="Production" checked="checked">
                        <label for="Production">Sold</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{-- <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button> --}}
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                <a href="{{route('agent.FarmerInfo.Solds.add',$cropData->id)}}" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
{{--                                 @if(isset($cropData) && $productionData->isEmpty())
                                <a href="{{ route('agent.FarmerInfo.product.new_data', $cropData->id) }}" title="Add Crop Production">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                              
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
                                    
                                      
                                  
                                 </a>
                                 <div class="input-group mb-3">
                                    @if($personalInfos->isNotEmpty())
                                        @foreach($personalInfos as $personalInfo)
                                            <h5 for="personainfo">
                                                Farmer: {{ $personalInfo->first_name . ' ' . $personalInfo->last_name }}
                                            </h5>
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No personal information available.</h5>
                                    @endif
                                </div>
                              
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.farmersdata.genfarmers') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">

                                 </a>
                              
                                         <!-- Check if farm profile exists -->
                                            <div class="input-group mb-3">
                                                @if($farmProfile)
                                                    <h5>Farm: {{ $farmProfile->tenurial_status ?? 'N/A' }}</h5>
                                                @else
                                                    <h5>No farm information available.</h5>
                                                @endif
                                            </div>
                           

                            </div>
                            <div class="user-details">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
    
                                     </a>
                                  
                                   <!-- Check if crop data exists -->
                                   <div class="input-group mb-3">
                                    @if($productionData->isNotEmpty())
                                        <h5>Crop Name: </h5>
                                
                                        @php
                                            // Array to store displayed crop names
                                            $displayedCrops = [];
                                        @endphp
                                
                                        @foreach($productionData as $production)
                                            @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                                <h5>  {{ $production->crop->crop_name }}</h5>
                                                <!-- Add more crop-related data here if necessary -->
                                
                                                @php
                                                    // Add the crop name to the displayedCrops array to avoid duplication
                                                    $displayedCrops[] = $production->crop->crop_name;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @else
                                        <h5>No crop data available.</h5>
                                    @endif
                                </div>
                                
                               
    
                                </div
                              >
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                             <th>#</th>
                                         
                                            <th>Sold TO</th>
                                            <th>Measurement</th>
                                            <th>Unit Price/kg</th>
                                         
                                            <th>Quantity</th>
                                            <th>Gross Income</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($productionSold->count() > 0)
                                    @foreach($productionSold as $productsolds)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $productsolds->id }}</td>
                               
                            <td>
                                @if ($productsolds->sold_to && $productsolds->sold_to != 'N/A')
                                    {{ $productsolds->sold_to }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($productsolds->measurement && $productsolds->measurement != 'N/A')
                                    {{ $productsolds->measurement }}
                                @else
                                
                                @endif
                            </td>
                           
                                <td>
                                    @if ($productsolds->unit_price_rice_per_kg && strtolower($productsolds->unit_price_rice_per_kg) != 'n/a')
                                        {{ number_format($productsolds->unit_price_rice_per_kg,2) }}
                                    @else
                                    
                                    @endif
                                </td>
                                <td>
                                    @if ($productsolds->quantity && strtolower($productsolds->quantity) != 'n/a')
                                        {{ number_format($productsolds->quantity,2) }}
                                    @else
                                    
                                    @endif
                                </td>

                                <td>
                                    @if ($productsolds->gross_income && strtolower($productsolds->gross_income) != 'n/a')
                                        {{ number_format($productsolds->gross_income,2) }}
                                    @else
                                    
                                    @endif
                                </td>

                       <td>
                        <a href="javascript:void(0);" class="viewSoldsCostBtn" data-bs-toggle="modal" data-bs-target="#SoldsModal" data-id="{{ $productsolds->id}}">
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="{{route('agent.FarmerInfo.Solds.edit', $productsolds->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('agent.FarmerInfo.Solds.delete', $productsolds->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                       @csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                       </form>
                          
                       </td>
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Production Sold Data is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{-- <!-- Pagination links -->
                                <ul class="pagination">
                                    <li><a href="{{ $fixedcosts->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($fixedcosts->getUrlRange(max(1, $fixedcosts->currentPage() - 1), min($fixedcosts->lastPage(), $fixedcosts->currentPage() + 1)) as $page => $url)
                                    <li class="{{ $page == $fixedcosts->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                    <li><a href="{{ $fixedcosts->nextPageUrl() }}">Next</a></li>
                                </ul> --}}
                            </div>
  
                        </div> {{-- end fixed cost --}}


                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal of Production archive --}}
<div class="modal fade" id="ArchiveProduction" tabindex="-1" aria-labelledby="ArchiveProduction" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white" id="ArchiveProduction">Production Archive Data History</h5>
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
                                   <th>Production Id</th>
                                   <th scope="col">Seed typed used(kg)</th>
                                 
                                   <th scope="col">Seed used(kg)</th>
                                   <th scope="col">Seed Source</th>
                                   <th scope="col">Unit</th>
                                   <th scope="col">No. of Fertilizer used(bags)</th>
                                   <th scope="col">No. of Pesticides used(L/Kg)</th>
                                   <th scope="col">No. of Insecticides used(L)</th>
        

                                   <th scope="col">Area Planted(ha)</th>
                                   <th scope="col">Date Planted</th>
                                   <th scope="col">Date Harvested</th>
                                   <th scope="col">Yield(tons/kg)</th>
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

<div class="modal fade" id="SoldsModal" tabindex="-1" aria-labelledby="SoldsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="SoldsModalLabel">Production Sold Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Farmer Details -->
        
                 
                
            

                <!-- Production Data -->
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">Production Solds Details</h6>
                    
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a. Solds Info
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Sold to:</strong> <span id="sold_to"></span></li>
                                        <li><strong>Measurement</strong> <span id="measurement"></span></li>
                                        <li><strong>Unit Price/kg(Php):</strong> <span id="unit_price_rice_per_kg"></span></li>
                                        <li><strong>Quantity:</strong> <span id="quantity"></span></li>
                                        <li><strong>Gross income:</strong> <span id="gross_income"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Harrowing Accordion -->
                     
                    
                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
{{-- varaible cost --}}
<div class="modal fade" id="VariableModal" tabindex="-1" aria-labelledby="VariableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="VariableModalLabel">VariableCost Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Farmer Details -->
        
                 
                        <!-- Farmer Picture and Info -->
                        {{-- <div class="col-md-3 text-center">
                            <img src="{{ $personalInfos->isNotEmpty() ? $personalInfos->first()->profile_picture : 'default-profile.png' }}" 
                                 alt="Farmer Picture" 
                                 class="img-fluid rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div> --}}
                        {{-- <div class="col-md-9">
                            <!-- Farmer Information -->
                            <h5>Farmer: {{ $personalInfos->isNotEmpty() ? $personalInfos->first()->first_name . ' ' . $personalInfos->first()->last_name : 'N/A' }}</h5>
                            
                            <!-- Farm Profile Information -->
                            <h6>Farm: {{ $farmProfile ? $farmProfile->tenurial_status ?? 'N/A' : 'No farm information available.' }}</h6>
                            <div class="input-group mb-3">
                                @if($productionData->isNotEmpty())
                                    <h5>Crop Name: </h5>
                            
                                    @php
                                        // Array to store displayed crop names
                                        $displayedCrops = [];
                                    @endphp
                            
                                    @foreach($productionData as $production)
                                        @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                            <h5>  {{ $production->crop->crop_name }}</h5>
                                            <!-- Add more crop-related data here if necessary -->
                            
                                            @php
                                                // Add the crop name to the displayedCrops array to avoid duplication
                                                $displayedCrops[] = $production->crop->crop_name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @else
                                    <h5>No crop data available.</h5>
                                @endif
                            </div>
                        </div> --}}
                  
            

                <!-- Production Data -->
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">Variable Cost Details</h6>
                    
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a. Seeds Info
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Seed name:</strong> <span id="seed_name"></span></li>
                                        <li><strong>Unit:</strong> <span id="unit"></span></li>
                                        <li><strong>Quantity:</strong> <span id="quantity"></span></li>
                                        <li><strong>Unit Price(Php):</strong> <span id="unit_price"></span></li>
                                        <li><strong>Total Seeds Cost:</strong> <span id="total_seed_cost"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Harrowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="harrowingHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#harrowingCollapse" aria-expanded="false" aria-controls="harrowingCollapse">
                                    b. Labor Info
                                </button>
                            </h2>
                            <div id="harrowingCollapse" class="accordion-collapse collapse" aria-labelledby="harrowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>No of person:</strong> <span id="labor_no_of_person"></span></li>
                                        <li><strong>Rate/person:</strong> <span id="rate_per_person"></span></li>
                                        <li><strong>Total labor Cost:</strong> <span id="total_labor_cost"></span></li>
                                     
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Harvesting Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="harvestingHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#harvestingCollapse" aria-expanded="false" aria-controls="harvestingCollapse">
                                    c. Fertilizers Info
                                </button>
                            </h2>
                            <div id="harvestingCollapse" class="accordion-collapse collapse" aria-labelledby="harvestingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Fertilizer Name:</strong> <span id="name_of_fertilizer"></span></li>
                                        <li><strong>No. of Sacks:</strong> <span id="no_of_sacks"></span></li>
                                        <li><strong>Unit Price per Sack (PHP):</strong> <span id="unit_price_per_sacks"></span></li>
                                        <li><strong>Total Cost Fertilizers (PHP):</strong> <span id="total_cost_fertilizers"></span></li>
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Post-Harvest Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="postHarvestHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#postHarvestCollapse" aria-expanded="false" aria-controls="postHarvestCollapse">
                                    d. Pesticides
                                </button>
                            </h2>
                            <div id="postHarvestCollapse" class="accordion-collapse collapse" aria-labelledby="postHarvestHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Pesticides Name:</strong> <span id="pesticide_name"></span></li>
                                        <li><strong>Number of L or Kg:</strong> <span id="no_of_l_kg"></span></li>
                                        <li><strong>Unit Price of Pesticides (PHP):</strong> <span id="unit_price_of_pesticides"></span></li>
                                     
                                        <li><strong>Total Cost Pesticides (PHP):</strong> <span id="total_cost_pesticides"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Transports and total Variables --}}

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="transportHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#transportCollapse" aria-expanded="false" aria-controls="transportCollapse">
                                    e. Transport and Total Variable
                                </button>
                            </h2>
                            <div id="transportCollapse" class="accordion-collapse collapse" aria-labelledby="transportHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Name of Vehicle:</strong> <span id="name_of_vehicle"></span></li>
                                        <li><strong>Total Delivery Cost (PHP):</strong> <span id="total_transport_delivery_cost"></span></li>
                                        <li><strong>Total Machineries Fuel Cost (PHP):</strong> <span id="total_machinery_fuel_cost"></span></li>
                                     
                                        <li><strong>Total Variable Cost (PHP):</strong> <span id="total_variable_cost"></span></li>
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




{{-- machineries --}}
<div class="modal fade" id="MachineModal" tabindex="-1" aria-labelledby="MachineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="MachineModalLabel">MachineriCost Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Farmer Details -->
        
                 
                        <!-- Farmer Picture and Info -->
                        {{-- <div class="col-md-3 text-center">
                            <img src="{{ $personalInfos->isNotEmpty() ? $personalInfos->first()->profile_picture : 'default-profile.png' }}" 
                                 alt="Farmer Picture" 
                                 class="img-fluid rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div> --}}
                        {{-- <div class="col-md-9">
                            <!-- Farmer Information -->
                            <h5>Farmer: {{ $personalInfos->isNotEmpty() ? $personalInfos->first()->first_name . ' ' . $personalInfos->first()->last_name : 'N/A' }}</h5>
                            
                            <!-- Farm Profile Information -->
                            <h6>Farm: {{ $farmProfile ? $farmProfile->tenurial_status ?? 'N/A' : 'No farm information available.' }}</h6>
                            <div class="input-group mb-3">
                                @if($productionData->isNotEmpty())
                                    <h5>Crop Name: </h5>
                            
                                    @php
                                        // Array to store displayed crop names
                                        $displayedCrops = [];
                                    @endphp
                            
                                    @foreach($productionData as $production)
                                        @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                            <h5>  {{ $production->crop->crop_name }}</h5>
                                            <!-- Add more crop-related data here if necessary -->
                            
                                            @php
                                                // Add the crop name to the displayedCrops array to avoid duplication
                                                $displayedCrops[] = $production->crop->crop_name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @else
                                    <h5>No crop data available.</h5>
                                @endif
                            </div>
                        </div> --}}
                  
            

                <!-- Production Data -->
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">MAchineries Details</h6>
                    
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a. Plowing
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Machineries Used:</strong> <span id="plowingmachine"></span></li>
                                        <li><strong>Ownership:</strong> <span id="plo_ownership_status"></span></li>
                                        <li><strong>No of Plowing:</strong> <span id="no_of_plowing"></span></li>
                                        <li><strong>Cost/Plowing:</strong> <span id="cost_per_plowing"></span></li>
                                        <li><strong>Total Plowing Cost:</strong> <span id="plowing_cost"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Harrowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="harrowingHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#harrowingCollapse" aria-expanded="false" aria-controls="harrowingCollapse">
                                    b. Harrowing
                                </button>
                            </h2>
                            <div id="harrowingCollapse" class="accordion-collapse collapse" aria-labelledby="harrowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Machineries Used:</strong> <span id="harrowing_machineries_used"></span></li>
                                        <li><strong>Ownership:</strong> <span id="harro_ownership_status"></span></li>
                                        <li><strong>No of Harrowing:</strong> <span id="no_of_harrowing"></span></li>
                                        <li><strong>Cost/Harrowing:</strong> <span id="harrowing_cost"></span></li>
                                        <li><strong>Total Harrowing Cost:</strong> <span id="harrowing_cost_total"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Harvesting Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="harvestingHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#harvestingCollapse" aria-expanded="false" aria-controls="harvestingCollapse">
                                    c. Harvesting
                                </button>
                            </h2>
                            <div id="harvestingCollapse" class="accordion-collapse collapse" aria-labelledby="harvestingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Machineries Used:</strong> <span id="harvesting_machineries_used"></span></li>
                                        <li><strong>Ownership:</strong> <span id="harvest_ownership_status"></span></li>
                                        <li><strong>No of Harvest:</strong> <span id="no_of_harvesting"></span></li>
                                        <li><strong>Cost/Harvest:</strong> <span id="cost_per_harvesting"></span></li>
                                        <li><strong>Total Harvest Cost:</strong> <span id="harvesting_cost_total"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Post-Harvest Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="postHarvestHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#postHarvestCollapse" aria-expanded="false" aria-controls="postHarvestCollapse">
                                    d. Post Harvest
                                </button>
                            </h2>
                            <div id="postHarvestCollapse" class="accordion-collapse collapse" aria-labelledby="postHarvestHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Machineries Used:</strong> <span id="postharvest_machineries_used"></span></li>
                                        <li><strong>Ownership:</strong> <span id="postharv_ownership_status"></span></li>
                                        <li><strong>PostHarvest Cost:</strong> <span id="post_harvest_cost"></span></li>
                                     
                                        <li><strong>Total Cost for Machineries:</strong> <span id="total_cost_for_machineries"></span></li>
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

{{-- fixedCost --}}
<div class="modal fade" id="fixedcostModal" tabindex="-1" aria-labelledby="fixedcostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="fixedcostModalLabel">FixedCost Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Farmer Details -->
        
                 
{{--                      
                        <div class="col-md-9">
                            <!-- Farmer Information -->
                            <h5>Farmer: {{ $personalInfos->isNotEmpty() ? $personalInfos->first()->first_name . ' ' . $personalInfos->first()->last_name : 'N/A' }}</h5>
                            
                            <!-- Farm Profile Information -->
                            <h6>Farm: {{ $farmProfile ? $farmProfile->tenurial_status ?? 'N/A' : 'No farm information available.' }}</h6>
                            <div class="input-group mb-3">
                                @if($productionData->isNotEmpty())
                                    <h5>Crop Name: </h5>
                            
                                    @php
                                        // Array to store displayed crop names
                                        $displayedCrops = [];
                                    @endphp
                            
                                    @foreach($productionData as $production)
                                        @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                            <h5>  {{ $production->crop->crop_name }}</h5>
                                            <!-- Add more crop-related data here if necessary -->
                            
                                            @php
                                                // Add the crop name to the displayedCrops array to avoid duplication
                                                $displayedCrops[] = $production->crop->crop_name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @else
                                    <h5>No crop data available.</h5>
                                @endif
                            </div>
                       
                        </div> --}}
                  
            

                <!-- Production Data -->
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">Fixed Cost Details</h6>
                    
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a. FixedCost Info
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Particular:</strong> <span id="particular"></span></li>
                                        <li><strong>No of Has:</strong> <span id="no_of_ha"></span></li>
                                        <li><strong>Cost/Has:</strong> <span id="cost_per_ha"></span></li>
                                        <li><strong>Total FixedCost:</strong> <span id="total_amount"></span></li>
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


{{-- production --}}
<div class="modal fade" id="productionModal" tabindex="-1" aria-labelledby="productionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="productionModalLabel">Production Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Farmer Details -->
        
                 
                        <!-- Farmer Picture and Info -->
                        {{-- <div class="col-md-3 text-center">
                            <img src="{{ $personalInfos->isNotEmpty() ? $personalInfos->first()->profile_picture : 'default-profile.png' }}" 
                                 alt="Farmer Picture" 
                                 class="img-fluid rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div> --}}
                        {{-- <div class="col-md-9">
                            <!-- Farmer Information -->
                            <h5>Farmer: {{ $personalInfos->isNotEmpty() ? $personalInfos->first()->first_name . ' ' . $personalInfos->first()->last_name : 'N/A' }}</h5>
                            
                            <!-- Farm Profile Information -->
                            <h6>Farm: {{ $farmProfile ? $farmProfile->tenurial_status ?? 'N/A' : 'No farm information available.' }}</h6>
                            <div class="input-group mb-3">
                                @if($productionData->isNotEmpty())
                                    <h5>Crop Name: </h5>
                            
                                    @php
                                        // Array to store displayed crop names
                                        $displayedCrops = [];
                                    @endphp
                            
                                    @foreach($productionData as $production)
                                        @if($production->crop && !in_array($production->crop->crop_name, $displayedCrops)) <!-- Check if crop data exists and is not already displayed -->
                                            <h5>  {{ $production->crop->crop_name }}</h5>
                                            <!-- Add more crop-related data here if necessary -->
                            
                                            @php
                                                // Add the crop name to the displayedCrops array to avoid duplication
                                                $displayedCrops[] = $production->crop->crop_name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @else
                                    <h5>No crop data available.</h5>
                                @endif
                            </div>
                       
                        </div> --}}
                  
            

                <!-- Production Data -->
            
               
                <div class="container mt-4">
                    <h6 class="fw-bold mb-3">Production Details</h6>
                    
                    </ul><div class="accordion" id="machineryAccordion">
                        <!-- Plowing Accordion -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="plowingHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#plowingCollapse" aria-expanded="true" aria-controls="plowingCollapse">
                                    a.  Production Info
                                </button>
                            </h2>
                            <div id="plowingCollapse" class="accordion-collapse collapse show" aria-labelledby="plowingHeading" data-bs-parent="#machineryAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled farmer-details">
                                        <li><strong>Seed Type Used:</strong> <span id="seeds_typed_used"></span></li>
                                        <li><strong>Seeds Used (kg):</strong> <span id="seeds_used_in_kg"></span></li>
                                        <li><strong>Seed Source:</strong> <span id="seed_source"></span></li>
                                        <li><strong>Unit:</strong> <span id="unit"></span></li>
                                        <li><strong>No of Fertilizer Used (bags):</strong> <span id="no_of_fertilizer_used_in_bags"></span></li>
                                        <li><strong>No of Pesticides Used (L/kg):</strong> <span id="no_of_pesticides_used_in_l_per_kg"></span></li>
                                        <li><strong>No of Insecticides Used (L):</strong> <span id="no_of_insecticides_used_in_l"></span></li>
                                        <li><strong>Area Planted:</strong> <span id="area_planted"></span></li>
                                        <li><strong>Date Planted:</strong> <span id="date_planted"></span></li>
                                        <li><strong>Date Harvested:</strong> <span id="date_harvested"></span></li>
                                        <li><strong>Yield (Kg/Tons):</strong> <span id="yield_tons_per_kg"></span></li>
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
  </script>
   <script>
    function goBack() {
        window.history.back(); // This will go back to the previous page in the browser history
    }
    </script>  
<script>

// Function to fetch and display Fixed Cost data
$(document).on('click', '.viewProductionBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    productionCostData(id); // Fetch data and show the modal
});

function productionCostData(id) {
    $.ajax({
        url: '/agent-edit-farmer-production/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'production' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#seeds_typed_used').text(response.seeds_typed_used || 'N/A');
                $('#seeds_used_in_kg').text(response.seeds_used_in_kg ? parseFloat(response.seeds_used_in_kg).toFixed(2) : 'N/A');
                $('#seed_source').text(response.seed_source || 'N/A');
                $('#no_of_fertilizer_used_in_bags').text(response.no_of_fertilizer_used_in_bags ? parseFloat(response.no_of_fertilizer_used_in_bags).toFixed(2) : 'N/A');
                $('#no_of_pesticides_used_in_l_per_kg').text(response.no_of_pesticides_used_in_l_per_kg ? parseFloat(response.no_of_pesticides_used_in_l_per_kg).toFixed(2) : 'N/A');
               
                $('#area_planted').text(response.area_planted ? parseFloat(response.area_planted).toFixed(2) : 'N/A');
               
                $('#date_planted').text(response.date_planted || 'N/A');
                $('#date_harvested').text(response.date_harvested || 'N/A');
               
                $('#no_of_insecticides_used_in_l').text(response.no_of_insecticides_used_in_l ? parseFloat(response.no_of_insecticides_used_in_l).toFixed(2) : 'N/A');
                $('#yield_tons_per_kg').text(response.yield_tons_per_kg ? parseFloat(response.yield_tons_per_kg).toFixed(2) : 'N/A');
               
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}


// Function to fetch and display Fixed Cost data
$(document).on('click', '.viewFixedCostBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    fetchFixedCostData(id); // Fetch data and show the modal
});

function fetchFixedCostData(id) {
    $.ajax({
        url: '/agent-edit-farmer-fixed-cost/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'fixedData' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#particular').text(response.particular || 'N/A');
                $('#no_of_ha').text(response.no_of_ha ? parseFloat(response.no_of_ha).toFixed(2) : 'N/A');
           
                $('#cost_per_ha').text(response.cost_per_ha ? parseFloat(response.cost_per_ha).toFixed(2) : 'N/A');
                $('#total_amount').text(response.total_amount ? parseFloat(response.total_amount).toFixed(2) : 'N/A');
               
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}


// Function to fetch and display Fixed Cost data
$(document).on('click', '.viewMachineCostBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    MachineCostData(id); // Fetch data and show the modal
});

$(document).on('click', '.viewMachineCostBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    MachineCostData(id); // Fetch data and show the modal
});

function MachineCostData(id) {
    $.ajax({
        url: '/agent-edit-farmer-machineries-cost/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'machineriesData' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#plowingmachine').text(response.plowing_machineries_used || 'N/A');
                $('#plo_ownership_status').text(response.plo_ownership_status || 'N/A');
                $('#no_of_plowing').text(response.no_of_plowing || 'N/A');
                $('#cost_per_plowing').text(response.cost_per_plowing ? parseFloat(response.cost_per_plowing).toFixed(2) : 'N/A');
                $('#plowing_cost').text(response.plowing_cost ? parseFloat(response.plowing_cost).toFixed(2) : 'N/A');

                $('#harrowing_machineries_used').text(response.harrowing_machineries_used || 'N/A');
                $('#harro_ownership_status').text(response.harro_ownership_status || 'N/A');
                $('#no_of_harrowing').text(response.no_of_harrowing || 'N/A');
                $('#harrowing_cost').text(response.harrowing_cost ? parseFloat(response.harrowing_cost).toFixed(2) : 'N/A');
                $('#harrowing_cost_total').text(response.harrowing_cost_total ? parseFloat(response.harrowing_cost_total).toFixed(2) : 'N/A');
            
                $('#harvesting_machineries_used').text(response.harvesting_machineries_used || 'N/A');
                $('#harvest_ownership_status').text(response.harvest_ownership_status || 'N/A');
                $('#no_of_harvesting').text(response.no_of_harvesting || 'N/A');
                $('#cost_per_harvesting').text(response.cost_per_harvesting ? parseFloat(response.cost_per_harvesting).toFixed(2) : 'N/A');
                $('#harvesting_cost_total').text(response.harvesting_cost_total ? parseFloat(response.harvesting_cost_total).toFixed(2) : 'N/A');
           
                $('#postharvest_machineries_used').text(response.postharvest_machineries_used || 'N/A');
                $('#postharv_ownership_status').text(response.postharv_ownership_status || 'N/A');
               
                $('#post_harvest_cost').text(response.post_harvest_cost ? parseFloat(response.post_harvest_cost).toFixed(2) : 'N/A');
                $('#total_cost_for_machineries').text(response.total_cost_for_machineries ? parseFloat(response.total_cost_for_machineries).toFixed(2) : 'N/A');
           
           
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}



// Function to fetch and display Variable cost Cost data
$(document).on('click', '.viewVariableCostBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    VariableCostData(id); // Fetch data and show the modal
});

$(document).on('click', '.viewVariableCostBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    VariableCostData(id); // Fetch data and show the modal
});

function VariableCostData(id) {
    $.ajax({
        url: '/agent-edit-farmer-variable-cost/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'variablesData' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#seed_name').text(response.seed_name || 'N/A');
                $('#unit').text(response.unit || 'N/A');
                $('#quantity').text(response.quantity || 'N/A');
                $('#unit_price').text(response.unit_price ? parseFloat(response.unit_price).toFixed(2) : 'N/A');
                $('#total_seed_cost').text(response.total_seed_cost ? parseFloat(response.total_seed_cost).toFixed(2) : 'N/A');

                $('#labor_no_of_person').text(response.labor_no_of_person || 'N/A');
                $('#rate_per_person').text(response.rate_per_person ? parseFloat(response.rate_per_person).toFixed(2) : 'N/A');
                $('#total_labor_cost').text(response.total_labor_cost ? parseFloat(response.total_labor_cost).toFixed(2) : 'N/A');
            
                $('#name_of_fertilizer').text(response.name_of_fertilizer || 'N/A');
                $('#no_of_sacks').text(response.no_of_sacks || 'N/A');
                $('#unit_price_per_sacks').text(response.unit_price_per_sacks ? parseFloat(response.unit_price_per_sacks).toFixed(2) : 'N/A');
                $('#total_cost_fertilizers').text(response.total_cost_fertilizers ? parseFloat(response.total_cost_fertilizers).toFixed(2) : 'N/A');
           
                $('#pesticide_name').text(response.pesticide_name || 'N/A');
                $('#no_of_l_kg').text(response.no_of_l_kg ? parseFloat(response.no_of_l_kg).toFixed(2) : 'N/A');
                $('#unit_price_of_pesticides').text(response.unit_price_of_pesticides ? parseFloat(response.unit_price_of_pesticides).toFixed(2) : 'N/A');
                $('#total_cost_pesticides').text(response.total_cost_pesticides ? parseFloat(response.total_cost_pesticides).toFixed(2) : 'N/A');
           
                $('#name_of_vehicle').text(response.name_of_vehicle || 'N/A');
                $('#total_transport_delivery_cost').text(response.total_transport_delivery_cost ? parseFloat(response.total_transport_delivery_cost).toFixed(2) : 'N/A');
                $('#total_machinery_fuel_cost').text(response.total_machinery_fuel_cost ? parseFloat(response.total_machinery_fuel_cost).toFixed(2) : 'N/A');
                $('#total_variable_cost').text(response.total_variable_cost ? parseFloat(response.total_variable_cost).toFixed(2) : 'N/A');
           
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}


// Function to fetch and display Variable cost Cost data
$(document).on('click', '.viewSoldsCostBtn', function() {
    var id = $(this).data('id'); // Get the ID from the data attribute
    SoldsCostData(id); // Fetch data and show the modal
});



function SoldsCostData(id) {
    $.ajax({
        url: '/agent-edit-farmer-Production-sold/' + id, // Adjust the URL to match your route
        type: 'GET',
        dataType: 'json',
        data: { type: 'ProductionSolds' }, // Send type parameter for AJAX request
        success: function(response) {
            if (response.error) {
                alert(response.error); // Display error message if provided
            } else {
                // Populate the modal with the fetched data
                $('#sold_to').text(response.sold_to || 'N/A');
                $('#measurement').text(response.measurement || 'N/A');
                $('#unit_price_rice_per_kg').text(response.unit_price_rice_per_kg ? parseFloat(response.unit_price_rice_per_kg).toFixed(2) : 'N/A');
                $('#quantity').text(response.quantity ? parseFloat(response.quantity).toFixed(2) : 'N/A');
                $('#gross_income').text(response.gross_income ? parseFloat(response.gross_income).toFixed(2) : 'N/A');

               
            }
        },
        error: function(xhr) {
            console.error('Error fetching data:', xhr.responseText);
            alert('An error occurred: ' + xhr.statusText); // Provide user-friendly error message
        }
    });
}

// Handle click event for viewing farm archive
$(document).on('click', '.viewProductionArchive', function () {
    var id = $(this).data('id'); // Get the ID from the data attribute
    ArchiveDataProduction(id); // Fetch data and show the modal
});
// Function to fetch archive data
function ArchiveDataProduction(id) {
    $.ajax({
        url: `/agent-edit-farmer-production/${id}`, // URL to fetch data
        type: 'GET',
        dataType: 'json',
        data: { type: 'archives' }, // Requesting specifically for archives
        success: function (response) {
            console.log("Response:", response); // Debugging the response

            // Handle case when no archives are available
            if (response.message) {
                alert(response.message); // Display message to the user
                $('#archiveHistory').empty(); // Clear the table content
                return; // Stop further processing
            }

            // Assuming `response` contains the array of archive data
            const archives = response;

            // Clear the table body
            $('#archiveHistory').empty();

            // Loop through each archive and create table rows
            archives.forEach(function (archive) {
                console.log("Processing Archive:", archive); // Debugging each archive entry

                // Format the updated date
                const dateUpdated = archive.created_at
                    ? new Date(archive.created_at).toLocaleDateString() 
                    : 'N/A';

                // Create a table row with archive data
                const archiveRow = `
                    <tr>
                        <th class="fixed-side">${dateUpdated}</th>
                        <td>${archive.last_production_datas_id || 'N/A'}</td>
                       
                        <td>${archive.seeds_typed_used || 'N/A'}</td>
                        <td>${archive.seeds_used_in_kg || 'N/A'}</td>
                        <td>${archive.seed_source || 'N/A'}</td>
                        <td>${archive.unit || 'N/A'}</td>
                         <td>${archive.no_of_fertilizer_used_in_bags || 'N/A'}</td>
                        <td>${archive.no_of_pesticides_used_in_l_per_kg || 'N/A'}</td>
                        <td>${archive.no_of_insecticides_used_in_l || 'N/A'}</td>
                        <td>${archive.area_planted || 'N/A'}</td>

                               <td>${archive.date_planted || 'N/A'}</td>
                        <td>${archive.date_harvested || 'N/A'}</td>
                        <td>${archive.yield_tons_per_kg || 'N/A'}</td>
                       
                       
                    </tr>
                `;

                // Append the row to the table body
                $('#archiveHistory').append(archiveRow);
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', xhr.responseText); // Log detailed error
            if (xhr.status === 404) {
                alert('Production not found or no archives available.');
            } else {
                alert(`An error occurred: ${xhr.statusText}`); // Display error message
            }
            $('#archiveHistory').empty(); // Clear the table in case of error
        }
    });
}


</script>

</script>
{{--  --}}
<style>

    .custom-cell {
        font-size: 14px;
        width: 150px; /* Adjust the width as needed */
        padding: 8px; /* Adjust the padding as needed */
    
    }
    
    
    
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
    
@endsection
