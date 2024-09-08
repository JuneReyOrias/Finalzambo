@extends('admin.dashb')
@section('admin')

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
                               

                                <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button>
                                
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                <a href="" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
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
                                    <h5 for="personainfo">Farmer: {{$farmData->personalinformation->first_name.' '.$farmData->personalinformation->last_name}}</h5>
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
                              
                                    <div class="input-group mb-3">

                                        <h5 for="personainfo">Farm: {{$farmData->tenurial_status}}</h5>
                                     
                                   
                                </div>
                           

                            </div>
                         
                                <div class="user-details">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
        
                                         </a>
                                      
                                            <div class="input-group mb-3">
        
                                                <h5 for="personainfo">Crop: {{ $productionData->first()->crop->crop_name ?? 'N/A' }}</h5>
                                             
                                           
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
                                           
                                            <th>cropping <p>no</p></th>
                                            <th>seed <p>type used</p></th>
                                            <th>seeds used <p>in kg</p></th>
                                            <th>seed_source</th>
                                            <th>no of fertilizer
                                            <p> used in bags</p></th>
                                            <th>no of pesticides <p> used in L/kg</p></th>
                                            <th>no of insecticides <p>used in L</p></th>
                                            <th>area planted</th>
                                            <th>date planted</th>
                                            <th>date_harvested</th>
                                            <th>yield <p>tons/kg</p></th>
                                            <th>unit price <p> palay/kg</p></th>
                                            <th>unit price <p>rice/kg</p></th>
                                            <th>type of <p>product</p></th>
                                            <th>sold to</th>
                                            <th>palay milled</th>
                                            <th>gross income <p>palay</p></th>
                                            <th>gross income <p> rice</p></th>
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
                                        @if ($lastproductdata->seed_source && strtolower($lastproductdata->seed_source) !== 'n/a')
                                            {{ $lastproductdata->seed_source }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->no_of_fertilizer_used_in_bags && strtolower($lastproductdata->no_of_fertilizer_used_in_bags) !== 'n/a')
                                            {{ number_format($lastproductdata->no_of_fertilizer_used_in_bags,2)}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->no_of_pesticides_used_in_l_per_kg && strtolower($lastproductdata->no_of_pesticides_used_in_l_per_kg) !== 'n/a')
                                            {{ number_format($lastproductdata->no_of_pesticides_used_in_l_per_kg,2)}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->no_of_insecticides_used_in_l && strtolower($lastproductdata->no_of_insecticides_used_in_l) !== 'n/a')
                                            {{ number_format($lastproductdata->no_of_insecticides_used_in_l,2)}}
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
                                        @if ($lastproductdata->unit_price_palay_per_kg && strtolower($lastproductdata->unit_price_palay_per_kg) !== 'n/a')
                                            {{ number_format($lastproductdata->unit_price_palay_per_kg,2)}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->unit_price_rice_per_kg && strtolower($lastproductdata->unit_price_rice_per_kg) !== 'n/a')
                                            {{ number_format($lastproductdata->unit_price_rice_per_kg,2)}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->type_of_product && strtolower($lastproductdata->type_of_product) !== 'n/a')
                                            {{ $lastproductdata->type_of_product}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->sold_to && strtolower($lastproductdata->sold_to) !== 'n/a')
                                            {{ $lastproductdata->sold_to}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->if_palay_milled_where && strtolower($lastproductdata->if_palay_milled_where) !== 'n/a')
                                            {{ $lastproductdata->if_palay_milled_where}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->gross_income_palay && strtolower($lastproductdata->gross_income_palay) !== 'n/a')
                                            {{ number_format($lastproductdata->gross_income_palay,2)}}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lastproductdata->gross_income_rice && strtolower($lastproductdata->gross_income_rice) !== 'n/a')
                                            {{ number_format($lastproductdata->gross_income_rice,2)}}
                                        @endif
                                    </td>

                       <td>
                        <a href="{{route('admin.farmersdata.production', $lastproductdata->id)}}" title="View production">
                            <button class="btn btn-success btn-sm">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                                                     
                        <a href="{{route('farm_profile.farm_edit', $lastproductdata->id)}}" title="view farm"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('agent.farmprofile.delete', $lastproductdata->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                           {{-- {{ csrf_field()}} --}}@csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                       </form>

                       </td>
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Production Data is empty</td>
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
                            
                        </div>


    

                    {{-- fixed cosat data --}}

                    <input type="radio" name="tabs" id="Fixed" checked="checked">
                        <label for="Fixed">Fixed Cost</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button>
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                <a href="" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
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
                                    <h5 for="personainfo">Farmer: {{$farmData->personalinformation->first_name.' '.$farmData->personalinformation->last_name}}</h5>
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
                              
                                    <div class="input-group mb-3">

                                        <h5 for="personainfo">Farm: {{$farmData->tenurial_status}}</h5>
                                     
                                   
                                </div>
                           

                            </div>
                            <div class="user-details">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
    
                                     </a>
                                  
                                        <div class="input-group mb-3">
    
                                            <h5 for="personainfo">Crop: {{ $productionData->first()->crop->crop_name ?? 'N/A' }}</h5>
                                         
                                       
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
                                      @if($FixedData->count() > 0)
                                    @foreach($FixedData as $fixedcost)      
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
                        <a href="{{route('admin.farmersdata.production', $fixedcost->id)}}" title="View production">
                            <button class="btn btn-success btn-sm">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                        <a href="{{route('fixed_cost.fixed_edit', $fixedcost->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('fixed_cost.delete', $fixedcost->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
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
                                <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button>
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                <a href="" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
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
                                    <h5 for="personainfo">Farmer: {{$farmData->personalinformation->first_name.' '.$farmData->personalinformation->last_name}}</h5>
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
                              
                                    <div class="input-group mb-3">

                                        <h5 for="personainfo">Farm: {{$farmData->tenurial_status}}</h5>
                                     
                                   
                                </div>
                           

                            </div>
                            <div class="user-details">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
    
                                     </a>
                                  
                                        <div class="input-group mb-3">
    
                                            <h5 for="personainfo">Crop: {{ $productionData->first()->crop->crop_name ?? 'N/A' }}</h5>
                                         
                                       
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
                                        
                                            <th>plowing <p>machineries used</p></th>
                                            <th>plowing <p>ownership</p> <p> status</p></th>
                                            <th>no of <p>plowing</p></th>
                                            <th>plowing <p>cost</p></th>
                                            <th>harrowing <p>machineries used</p></th>
                                            <th>harro <p>ownership</p> <p> status</p></th>
                                            <th>no of <p>harrowing</p></th>
                                            <th>harrowing <p>cost</p></th>
                                            <th>harvesting <p>machineries used</p></th>
                                            <th>harvest <p>ownership</p> <p> status</p></th>
                                            <th>harvest <p>cost</p></th>
                                            <th>postharvest <p>machineries used</p></th>
                                            <th>post harvest <p>ownership</p> <p> status </p></th>
                                            <th>post harvest <p>cost</p></th>
                                            <th>total cost <p>for machineries</p></th>
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
                                @if ($machineriesused->plowing_machineries_used && $machineriesused->plowing_machineries_used != 'N/A')
                                    {{ $machineriesused->plowing_machineries_used }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($machineriesused->plo_ownership_status && $machineriesused->plo_ownership_status != 'N/A')
                                    {{ $machineriesused->plo_ownership_status }}
                                @else
                                
                                @endif
                            </td>
                            <td>
                            @if ($machineriesused->no_of_plowing && $machineriesused->no_of_plowing != 'N/A')
                                {{ $machineriesused->no_of_plowing }}
                            @else
                      
                                    @endif
                                </td>
                                <td>
                                    @if ($machineriesused->plowing_cost && $machineriesused->plowing_cost != 'N/A')
                                        {{ number_format($machineriesused->plowing_cost,2) }}
                                    @else
                                    
                                    @endif
                                </td>

                                <td>
                                    @if ($machineriesused->harrowing_machineries_used && strtolower($machineriesused->harrowing_machineries_used) != 'n/a')
                                        {{ $machineriesused->harrowing_machineries_used }}
                                    @else
                                    
                                    @endif
                                </td>
                                <td>
                                @if ($machineriesused->harro_ownership_status && strtolower($machineriesused->harro_ownership_status) != 'n/a')
                                    {{ $machineriesused->harro_ownership_status }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($machineriesused->no_of_harrowing && strtolower($machineriesused->no_of_harrowing) != 'n/a')
                                    {{ $machineriesused->no_of_harrowing }}
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
                            @if ($machineriesused->harvesting_machineries_used && strtolower($machineriesused->harvesting_machineries_used) != 'n/a')
                                {{ $machineriesused->harvesting_machineries_used }}
                            @else
                            
                            @endif
                        </td>
                        <td>
                            @if ($machineriesused->harvest_ownership_status && strtolower($machineriesused->harvest_ownership_status) != 'n/a')
                                {{ $machineriesused->harvest_ownership_status }}
                            @else
                            
                            @endif
                        </td>
                        <td>
                        @if ($machineriesused->harvesting_cost && strtolower($machineriesused->harvesting_cost) != 'n/a')
                            {{ number_format($machineriesused->harvesting_cost,2) }}
                        @else
                            
                        @endif
                    </td>

                    <td>
                        @if ($machineriesused->postharvest_machineries_used && strtolower($machineriesused->postharvest_machineries_used) != 'n/a')
                            {{ $machineriesused->postharvest_machineries_used }}
                        @else
                        
                        @endif
                    </td>
                    <td>
                    @if ($machineriesused->postharv_ownership_status && strtolower($machineriesused->postharv_ownership_status) != 'n/a')
                        {{ $machineriesused->postharv_ownership_status }}
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
                          
                        <a href="{{route('machineries_used.machine_edit', $machineriesused->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> 
              
                        <form  action="{{ route('machineries_used.delete', $machineriesused->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                           {{-- {{ csrf_field()}} --}}@csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                            {{-- machineries data --}}
                        <input type="radio" name="tabs" id="variable" checked="checked">
                        <label for="variable">Variable Cost</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button>
                                
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                <a href="" title="Add farm">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </a>
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
                              
                                    <div class="input-group mb-3">

                                        <h5 for="personainfo">Farm: {{$farmData->tenurial_status}}</h5>
                                     
                                   
                                </div>
                           

                            </div>
                            <div class="user-details">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
    
                                     </a>
                                  
                                        <div class="input-group mb-3">
    
                                            <h5 for="personainfo">Crop: {{ $productionData->first()->crop->crop_name ?? 'N/A' }}</h5>
                                         
                                       
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
                                            <th>total machinery <p>/delivery cost</p> </th>
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
                                                    
                                                    <a href="{{route('variable_cost.var_update',  $vartotal->id)}}" title="Edit Student"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> 
                
                                                    <form  action="{{ route('variable_cost.delete', $vartotal->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                   @csrf
                                                       @method('DELETE')
                                                       <button type="submit" class="btn btn-danger btn-sm" title="Delete Student" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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


                </div>
            </div>
        </div>
    </div>
</div>
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

@endsection
