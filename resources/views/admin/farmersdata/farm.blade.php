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

                    
                    <h4>Farm Data</h4>
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
                       
                
                        <label for="personainfo">Farm</label>
                        
                        <div class="tab">
                        
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{route('admin.farmersdata.genfarmers')}}" title="back">
                                    
                                         <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                  
                                 </a>
                                 <div class="input-group mb-3">
                                    <!-- Check if $farmData is not empty -->
                                    @if($farmData->isNotEmpty())
                                        @foreach($farmData as $farm)
                                            <!-- Check if personalInformation relation is loaded -->
                                            @if($farm->personalInformation)
                                                <h5 for="personainfo">
                                                    Farmer: {{ $farm->personalInformation->first_name . ' ' . $farm->personalInformation->last_name }}
                                                </h5>
                                            @else
                                                <h5 for="personainfo">Farmer information not available.</h5>
                                            @endif
                                        @endforeach
                                    @else
                                        <h5 for="personainfo">No farm data available.</h5>
                                    @endif
                                </div>
                                <a href="{{route('farm_profile.farm_index',$personalinfos->id)}}" title="Add farm">
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
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                    
                                            <th>#</th>
                                         
                                            <th>Agri-District</th>
                                            <th>tenurial status</th>
                                            <th>farm address</th>
                                            <th>years as farmer</th>
                                            <th>gps longitude</th>
                                            <th>gps latitude</th>
                                            <th>total physical area </th>
                                            <th>total_area_cultivated</th>
                                        
                                            <th>area_prone_to</th>
                                            <th>ecosystem</th>
                                            
                                            
                                            <th>date_interview</th>
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($farmData->count() > 0)
                                    @foreach($farmData as $farmprofile)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{  $farmprofile->id }}</td>
                                    
                            <td>
                                @if ($farmprofile->agriDistrict->district && $farmprofile->agriDistrict->district != 'N/A')
                                    {{ $farmprofile->agriDistrict->district }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($farmprofile->tenurial_status && $farmprofile->tenurial_status != 'N/A')
                                    {{ $farmprofile->tenurial_status }}
                                @else
                                
                                @endif
                            </td>
                            <td>
                            @if ($farmprofile->farm_address && $farmprofile->farm_address != 'N/A')
                                {{ $farmprofile->farm_address }}
                            @else
                      
                                    @endif
                                </td>
                                <td>
                                    @if ($farmprofile->no_of_years_as_farmers && $farmprofile->no_of_years_as_farmers != 'N/A')
                                        {{ $farmprofile->no_of_years_as_farmers }}
                                    @else
                                    
                                    @endif
                                </td>

                                <td>
                                    @if ($farmprofile->gps_longitude && strtolower($farmprofile->gps_longitude) != 'n/a')
                                        {{ $farmprofile->gps_longitude }}
                                    @else
                                    
                                    @endif
                                </td>
                                <td>
                                @if ($farmprofile->gps_latitude && strtolower($farmprofile->gps_latitude) != 'n/a')
                                    {{ $farmprofile->gps_latitude }}
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($farmprofile->total_physical_area && strtolower($farmprofile->total_physical_area) != 'n/a')
                                    {{ number_format($farmprofile->total_physical_area,2) }}
                                @else
                                
                                @endif
                            </td>
                            <td>
                                @if ($farmprofile->total_area_cultivated && strtolower($farmprofile->total_area_cultivated) != 'n/a')
                                    {{ number_format($farmprofile->total_area_cultivated,2) }}
                                @else
                                
                                @endif
                            </td>
                        {{-- <td>
                            @if ($farmprofile->land_title_no && strtolower($farmprofile->land_title_no) != 'n/a')
                                {{ $farmprofile->land_title_no }}
                            @else
                            
                            @endif
                        </td>
                        <td>
                            @if ($farmprofile->lot_no && strtolower($farmprofile->lot_no) != 'n/a')
                                {{ $farmprofile->lot_no }}
                            @else
                            
                            @endif
                        </td> --}}
                        <td>
                        @if ($farmprofile->area_prone_to && strtolower($farmprofile->area_prone_to) != 'n/a')
                            {{ $farmprofile->area_prone_to }}
                        @else
                            
                        @endif
                    </td>

                    <td>
                        @if ($farmprofile->ecosystem && strtolower($farmprofile->ecosystem) != 'n/a')
                            {{ $farmprofile->ecosystem }}
                        @else
                        
                        @endif
                    </td>
                  
                    <td>{{ $farmprofile->date_interview}}</td>
                    
                       <td>
                        <a href="{{route('admin.farmersdata.crop', $farmprofile->id)}}" title="View Crop">
                            <button class="btn btn-success btn-sm">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </a>
                                                     
                        <a href="{{route('farm_profile.farm_edit', $farmprofile->id)}}" title="view farm"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                
                        <form  action="{{ route('agent.farmprofile.delete', $farmprofile->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
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
@endsection
