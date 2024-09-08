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

                    
                    <h4>Crop Data</h4>
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
                       
                
                        <label for="personainfo">Crop</label>
                        
                        <div class="tab">
                        
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn" onclick="goBack()" title="Back">
                                    <i class="fa fa-arrow-left text-primary" aria-hidden="true"></i>
                                </button>
                                 <div class="input-group mb-3">
                                    <h5 for="personainfo"></h5>
                                </div>
                                   
                                <a href="{{ route('admin.farmersdata.cropsdata.add_crop',$farmData->id)}}" title="Add farm">
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
                            <form method="GET" action="{{ route('admin.farmersdata.crop',$farmData->id) }}">
                                <div class="user-details">
      
                                    <div class="input-box">
                                        <select lass="form-control light-gray-placeholder" name="crop_name" id="selectCrop" onchange="this.form.submit()">
                                            
                                            <option value="All" {{ request('crop_name') == 'All' ? 'selected' : '' }}>Crop Name</option>
                                            @foreach($cropData->pluck('crop_name')->unique() as $cropName)
                                           
                                                <option value="{{ $cropName }}" {{ request('crop_name') == $cropName ? 'selected' : '' }}>
                                                    {{ $cropName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                            <th>#</th>
                                            <th>type of <p>variety planted</p></th>
                                            <th>Planting Schedule <p>wet season</p></th>
                                            <th>Planting Schedule <p>dry season</p></th>
                                            <th>No. of cropping <p>per year</p></th>
                                            <th>yield_kg_ha</th>
                                       
                                           
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($cropData->count() > 0)
                                    @foreach($cropData as $cropData)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $cropData->id }}</td>
                                    
                                   
                                    <td>
                                        @if ($cropData->type_of_variety_planted && strtolower($cropData->type_of_variety_planted) != 'n/a')
                                            {{ $cropData->type_of_variety_planted }}
                                        @elseif ($cropData->preferred_variety && strtolower($cropData->preferred_variety) != 'n/a')
                                            {{ $cropData->preferred_variety }}
                                        @else
                                            <!-- Optionally, you can add a placeholder like 'N/A' here if both values are null or 'n/a' -->
                                        @endif
                                    </td>
                                    
                                        <td>
                                        @if ($cropData->planting_schedule_wetseason && strtolower($cropData->planting_schedule_wetseason) != 'n/a')
                                            {{ $cropData->planting_schedule_wetseason }}
                                        @else
                                        
                                        @endif
                                        </td>
                                        <td>
                                        @if ($cropData->planting_schedule_dryseason && strtolower($cropData->planting_schedule_dryseason) != 'n/a')
                                            {{ $cropData->planting_schedule_dryseason }}
                                        @else
                                        
                                        @endif
                                        </td>
                    
                                        <td>
                                        @if ($cropData->no_of_cropping_per_year && strtolower($cropData->no_of_cropping_per_year) != 'n/a')
                                            {{ $cropData->no_of_cropping_per_year }}
                                        @else
                                        
                                        @endif
                                        </td>
                    
                                        <td>
                                        @if ($cropData->yield_kg_ha && strtolower($cropData->yield_kg_ha) != 'n/a')
                                            {{ $cropData->yield_kg_ha }}
                                        @else
                                        
                                        @endif
                                        </td>
                                       
                     
                    
                       <td>
                        <a href="{{route('admin.farmersdata.production', $cropData->id)}}" title="View production">
                            <button class="btn btn-success btn-sm">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                                                     
                        <a href="{{route('admin.farmersdata.cropsdata.edit_crops', $cropData->id)}}" title="view farm"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('admin.farmersdata.cropsdata.delete', $cropData->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                           {{-- {{ csrf_field()}} --}}@csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                       </form>

                       </td>
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Farm Profile Data is empty</td>
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
