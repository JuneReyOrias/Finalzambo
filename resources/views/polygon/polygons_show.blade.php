@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')


<div class="page-content">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    
                    <h2> Rice Boarders</h2>
                </div>
                <br>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                        <input type="radio" name="tabs" id="Seed" checked="checked">
                        <label for="Seed">Polygon</label>
                        <div class="tab">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3 me-md-1">
                                    <h5 for="Seed" class="me-3">a. Polygon Boundary</h5>
                                </div>
                                                        
                                <div class="me-md-1">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" title="add Polygon" data-bs-target="#mapModal">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                      </button>
                                
                                    {{-- <a href="{{ route('polygon.create') }}" class="btn btn-success">Add</a> --}}
                                </div>
                            <!-- Map Modal -->
                            <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" >
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="mapModalLabel">Polygon Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div id="map" style="height: 400px; width: 100%;"></div>
                                    <!-- Polygon Coordinates Section -->
                                    <div style="margin: 40px auto; width: 80%; max-width: 800px; display: flex; flex-wrap: wrap; gap: 20px;">
                            
                            
                                        
                                    
                                        <!-- Right Column -->
                                        <div style="display: flex; gap: 20px;">
                                            <div style="flex: 1; margin-bottom: 20px;">
                                                <h5 style="margin-bottom: 10px;">Polygon Name</h5>
                                                
                                                <select id="boarder-name" onchange="checkPolygonName()" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                    <option value="">Select</option>
                                                    <option value="Ayala">Ayala Boarder</option>
                                                    <option value="Tumaga">Tumaga Boarder</option>
                                                    <option value="Culianan">Culianan Boarder</option>
                                                    <option value="Manicahan">Manicahan Boarder</option>
                                                    <option value="Curuan">Curuan Boarder</option>
                                                    <option value="Vitali">Vitali Boarder</option>
                                                    <option value="Rice">Rice Boarder</option>
                                                    <option value="Corn">Corn Boarder</option>
                                                    <option value="Coconut">Coconut Boarder</option>
                                                 
                                                    <option value="Add prefer">Add prefer</option>
                                                </select>
                                                
                                                <button id="removePolygonButton" style="display: none; margin-top: 10px; padding: 10px; border: none; background-color: #FF5733; color: white; border-radius: 5px; cursor: pointer;" onclick="removeCustomPolygon()">Remove</button>
                                            </div>
                                            
                                            <!-- Area of the Polygon Section -->
                                         
                                        
                                            <!-- Polygon Fill Color Section -->
                                            <div style="flex: 1; margin-bottom: 20px;">
                                            <h5 style="margin-bottom: 10px;">Polygon Fill Color</h5>
                                            
                                            <select id="fill-color-select" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                <option value="">Select Fill Color</option>
                                                <option value="#000000">Black</option>
                                                <option value="#ff0000">Red</option>
                                                <option value="#00ff00">Green</option>
                                                <option value="#0000ff">Blue</option>
                                                <option value="#ffff00">Yellow</option>
                                                <option value="#ffffff">White</option>
                                                <option value="#ff00ff">Magenta</option>
                                                <option value="#00ffff">Cyan</option>
                                                <option value="custom-fill">Custom Color</option>
                                            </select>
                                        
                                            <!-- Custom fill color input -->
                                            {{-- <label for="custom-fill-color" id="custom-fill-color-label" style="display: none; margin-top: 10px;">Custom Fill Color:</label> --}}
                                            <input type="color" id="custom-fill-color" style="display: none; margin-top: 10px; width: 100%; padding: 10px;">
                                            </div>
                                        
                                            <!-- Polygon Stroke Color Section -->
                                            <div style="flex: 1; margin-bottom: 20px;">
                                            <h5 style="margin-bottom: 10px;">Stroke Color</h5>
                                        
                                            <select id="stroke-color-select" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                <option value="">Select Stroke Color</option>
                                                <option value="#00aa00">Ayala</option>
                                                <option value="#55007f">Tumaga</option>
                                                <option value="#ffff00">Culianan</option>
                                                <option value="#ff5500">Manicahan</option>
                                                <option value="#ff00ff">Curuan</option>
                                                <option value="#ff0000">Vitali</option>
                                                <option value="#FFBF00">Rice</option>
                                                <option value="#ffff33">Corn</option>
                                                <option value="#663300">Coconut</option>
                                                <option value="#0040ff">Residential</option>
                                                <option value="custom-stroke">Custom Color</option>
                                            </select>
                                        
                                            <!-- Custom stroke color input -->
                                            {{-- <label for="custom-stroke-color" id="custom-stroke-color-label" style="display: none; margin-top: 30px;">Custom Stroke Color:</label> --}}
                                            <input type="color" id="custom-stroke-color" style="display: none; margin-top: 10px; width: 100%; padding: 10px;">
                                            </div>
                                        
                                        </div>
                                        
                                    
                                    
                                                <!-- Left Column -->
                                                <div style="display: flex; gap: 20px;">
                                                    <!-- Section to display Altitude -->
                                                    <div style="flex: 1; margin-bottom: 20px;">
                                                        <h5>Area (in sq. m)</h5>
                                                    
                                                        <input type="text" id="area" placeholder="Area of the Polygon" readonly style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                        </div>
                                                   
                                                    <div style="flex: 1; margin-bottom: 20px;">
                                                        <div style="margin-bottom: 20px;">
                                                        <h5>Altitude  (in meters)</h5>
                                                        <input type="text" id="altitude" readonly style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                        </div>
                                                    </div>

                                                    <!-- Polygon Coordinates Section -->
                                                    <div style="flex: 1; margin-bottom: 20px;">
                                                    <div >
                                                        <h5 style="margin-bottom: 10px;">Polygon Coordinates</h5>
                                                        <textarea id="polygon-coordinates" rows="5" cols="50" readonly style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;"></textarea>
                                                    </div>
                                                    </div>
                                                
                                            
                                                
                                                </div>
                                    
                                    
                                    
                                        <!-- Save Button -->
                                        {{-- <div style="text-align: center; width: 100%;">
                                        <button id="save-polygon" class="btn btn-primary" style="padding: 10px 20px; border-radius: 5px;">Save Polygon</button>
                                        </div> --}}
                                    
                                    </div>
                                <!-- CSRF token for AJAX request -->
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                            </div>

                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button id="save-polygon" class="btn btn-primary">Save Polygon</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                                {{-- <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET" class="me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                            
                                <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            
                            
                               <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light" >
                                        <tr>
                                            <th>#</th>
                                            <th>Polygon Name</th>
                                            <th>Area</th>
                                            <th>Altitude</th>
                                            <th>color</th>
                                           
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($cropParcels->count() > 0)
                                        @foreach($cropParcels as $seed)
                                            <tr class="table-light">
                                                 
                                                 <td>{{$seed->id}}</td>
                                                 <td>{{$seed->polygon_name}}</td>
                                                 <td>{{$seed->area}}</td>
                                                <td>{{$seed->altitude}}</td>
                                             
                                                 <td>{{$seed->strokecolor }}</td>
                                                
                                               
                                                
                                                
                          
                                                <td>
                                                   
                                                     <a href="{{route('polygon.polygons_edit',  $seed->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                        
                                                     <form  action="{{ route('polygon.delete', $seed->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                    </form> 
                                                    
                                                </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Polygon Boarder is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $cropParcels->previousPageUrl() }}">Previous</a></li>
                                @foreach ($cropParcels->getUrlRange(1,$cropParcels->lastPage()) as $page => $url)
                                    <li class="{{ $page == $cropParcels->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $cropParcels->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>


                        {{-- Parcel --}}
                        <input type="radio" name="tabs" id="labors" checked="checked">
                        <label for="labors">Parcel</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3">
                                    <h5>b. Parcellary Boarder</h5>
                                </div>
                                <div class="me-md-1">
                                    <a href="{{ route('parcels.new_parcels') }}" class="btn btn-success"><i class="fa fa-plus" title="Add Parcel"  aria-hidden="true"></i></a>
                                </div>
                                {{-- <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                                            
                                              <th>#</th>
                                              <th>Parcel Name</th>
                                              <th>ARP OwnerName</th>
                                              
                                              <th>actual used</th>
                                            
                                              <th>Area</th>
                                              <th>Parcel Color</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @if($parcels->count() > 0)
                                      @foreach($parcels as $personalinformation)
                                          <tr class="table-light">
                                             
                                               <td>{{  $personalinformation->id }}</td>
                                              
                                              <td>{{  $personalinformation->parcel_name}}</td>
                                              <td>{{  $personalinformation->arpowner_na }}</td>
                                            
                                              <td>{{  $personalinformation->actual_used}}</td>
                                            
                                              <td>{{  $personalinformation->area }}</td>
                                              <td>{{  $personalinformation->strokecolor }}</td>
                                             
                                              <td>
                                                 
                                                   <a href="{{route('parcels.edit',  $personalinformation->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                      
                                                   <form  action="{{ route('parcels.delete',  $personalinformation->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                      {{ csrf_field()}}
                                                      <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                  </form>
                                                 
                                              </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="10">Farm Parcel  is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $parcels->previousPageUrl() }}">Previous</a></li>
                                @foreach ($parcels->getUrlRange(1,$parcels->lastPage()) as $page => $url)
                                    <li class="{{ $page == $parcels->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $parcels->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>

                                             {{-- district --}}
                                             <input type="radio" name="tabs" id="agridistrict" checked="checked">
                                             <label for="agridistrict">Agri-District</label>
                                             <div class="tab">
                                                 <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                     <div class="input-group mb-3">
                                                         <h5>c. Agri-District Marker</h5>
                                                     </div>
                                                    <div class="me-md-1">
                                                            <!-- Button trigger modal -->
                                                            <div class="me-md-1">
                                                                <a href="{{ route('agri_districts.display') }}" title="Add  Agri-District" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                            
                                                     {{-- <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                         <div class="input-group mb-3">
                                                             <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                                             <button class="btn btn-outline-success" type="submit">Search</button>
                                                         </div>
                                                     </form>
                                                     <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                         <button class="btn btn-outline-success" type="submit">All</button>
                                                     </form> --}}
                                                 </div>


                                             <!-- Modal -->
                            <div class="modal fade" id="addBarangayModal" tabindex="-1" aria-labelledby="addBarangayModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBarangayModalLabel">Add AgriDistrict</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="content">
                                            <form id="multi-step-form" action{{url('CornSave')}} method="post">
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
                                          <br>
                                          {{-- <h6 class="card-title"><span></span>Barangay</h6> --}}
                   
                                                   
                                                    <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                                        
                                                    <div class="user-details">
                                                        
                                                        <div class="input-box">
                                                            <span class="details">District name</span>
                                                            <select class="form-control light-gray-placeholder @error('name="district"') is-invalid @enderror"  name="district" id="validationCustom01" aria-label="Floating label select e">
                                                              <option selected disabled>Select</option>
                                                              <option value="ayala" {{ old('name="district"') == 'ayala' ? 'selected' : '' }}>Ayala</option>
                                                              <option value="tumaga" {{ old('name="district"') == 'tumaga' ? 'selected' : '' }}>Tumaga</option>
                                                              <option value="culianan" {{ old('name="district"') == 'culianan' ? 'selected' : '' }}>Culianan</option>
                                                              <option value="manicahan" {{ old('name="district"') == 'manicahan' ? 'selected' : '' }}>Manicahan</option>
                                                              <option value="curuan" {{ old('name="district"') == 'curuan' ? 'selected' : '' }}>Curuan</option>
                                                              <option value="vitali" {{ old('name="district"') == 'vitali' ? 'selected' : '' }}>Vitali</option>
                                                            </select>
                                                          </div>


                                                  
                                                        <div class="input-box">
                                                          <span class="details">Description</span>
                                                          <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"  name="description" placeholder="description" id="selectReligion"onchange="checkReligion()" >
                                                          @error('middle_name')
                                                          <div class="invalid-feedback">{{ $message }}</div>
                                                      @enderror
                                                        </div>

                                                        <div class="input-box">
                                                            <span class="details">Latitude</span>
                                                            <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror" name="latitude" id="lat" placeholder="Enter latitude" value="{{ old('latitude') }}" >
                                                            @error('middle_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                          </div>
                                                   
                                                          <div class="input-box">
                                                            <span class="details">Longitude</span>
                                                            <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror" name="longitude" id="long" placeholder="Enter longitude" value="{{ old('longitude') }}" >
                                                            @error('middle_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                          </div>
                                                         
                                                          <div class="input-box">
                                                            <span class="details">Altitude (meters)</span>
                                                            <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"name="altitude" id="altitude" placeholder="Altitude will be fetched" readonly>
                                                            @error('middle_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                          </div>
                                                         
                                                      
                                                        
                                                      </div>
                                                      <div class="form_1_btns">
                                                       
                                                       
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                <br>
                                                <div id="map" style="height: 400px; width: 100%;"></div>
                                                          
                                                            
                                                          </div>
                                                     
                                            
                                                     
                                            </div>
                                            </form>
                                        </div>
                                       
                                    </div>
                                  
                                    </div>
                                                 <div class="table-responsive">
                                                     <table class="table table-bordered datatable">
                                                         <!-- Table content here -->
                                                         <thead class="thead-light">
                                                             <tr >
                                                                 
                                                                   <th>#</th>
                                                                   <th>AgriDistrict Name</th>
                                                                   <th>Description</th>
                                                                   <th>Latitude</th>
                                                                   <th>Longitude</th>
                                                                   <th>Altitude</th>
                                                                   {{-- <th>Area</th>
                                                                   <th>Parcel Color</th> --}}
                                                            
                                                                   <th>Action</th>
                                                               </tr>
                                                           </thead>
                                                           <tbody>
                                                             @if($AgriDistrict->count() > 0)
                                                           @foreach($AgriDistrict as $personalinformation)
                                                               <tr class="table-light">
                                                                  
                                                                    <td>{{  $personalinformation->id }}</td>
                                                                   <td>{{  $personalinformation->district }}</td>
                                                                   <td>{{  $personalinformation->description}}</td>
                                                                   <td>{{  $personalinformation->latitude }}</td>
                                                                   <td>{{  $personalinformation->longitude }}</td>
                                                                   <td>{{  $personalinformation->altitude}}</td>
                                                                  
                                                                   <td>
                                                                      
                                                                                                                                 
                                                                         <a href="{{route('agri_districts.agri_edit', $personalinformation->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                                           

                                                                            <form  action="{{ route('agri_districts.agri_delete',  $personalinformation->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                                                {{ csrf_field()}}
                                                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                                       </form>
                                                                      
                                                                   </td>
                                                             </tr>
                                                             @endforeach
                                                             @else
                                                             <tr>
                                                                 <td class="text-center" colspan="5">AgriDistirict is empty</td>
                                                             </tr>
                                                             @endif
                                                         </tbody>
                                                     </table>
                                                 </div>
                                                  <!-- Pagination links -->
                                                  <ul class="pagination">
                                                     <li><a href="{{ $AgriDistrict->previousPageUrl() }}">Previous</a></li>
                                                     @foreach ($AgriDistrict->getUrlRange(1,$AgriDistrict->lastPage()) as $page => $url)
                                                         <li class="{{ $page == $AgriDistrict->currentPage() ? 'active' : '' }}">
                                                             <a href="{{ $url }}">{{ $page }}</a>
                                                         </li>
                                                     @endforeach
                                                     <li><a href="{{ $AgriDistrict->nextPageUrl() }}">Next</a></li>
                                                 </ul>
                                             </div>
                     

                                                         {{-- crop categroy look up table--}}
                                                         <input type="radio" name="tabs" id="cropCategory" checked="checked">
                                                         <label for="cropCategory">Crop</label>
                                                         <div class="tab">
                                                             <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                                 <div class="input-group mb-3">
                                                                     <h5>c. Crop Category</h5>
                                                                 </div>
                                                                <div class="me-md-1">
                                                                        <!-- Button trigger modal -->
                                                                        <div class="me-md-1">
                                                                            <a href="{{ route('crop_category.crop_create') }}" title="Add Category" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                        </div>
                                                                    </div>
                                        
                                                                 {{-- <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                     <div class="input-group mb-3">
                                                                         <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                                                         <button class="btn btn-outline-success" type="submit">Search</button>
                                                                     </div>
                                                                 </form>
                                                                 <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                     <button class="btn btn-outline-success" type="submit">All</button>
                                                                 </form> --}}
                                                             </div>
            
            
                             
                                                             <div class="table-responsive">
                                                                 <table class="table table-bordered datatable">
                                                                     <!-- Table content here -->
                                                                     <thead class="thead-light">
                                                                         <tr >
                                                                             
                                                                               <th>#</th>
                                                                               <th>Crop Name</th>
                                                                               {{-- <th>Crop type</th> --}}
                                                                          
                                                                        
                                                                               <th>Action</th>
                                                                           </tr>
                                                                       </thead>
                                                                       <tbody>
                                                                         @if($CropCat->count() > 0)
                                                                       @foreach($CropCat as $cropcategory)
                                                                           <tr class="table-light">
                                                                              
                                                                                <td>{{  $cropcategory->id }}</td>
                                                                               <td>{{  $cropcategory->crop_name }}</td>
                                                                               {{-- <td>{{  $cropcategory->type_of_variety}}</td> --}}
                                                                             
                                                                              
                                                                               <td>
                                                                                  
                                                                                                                                                <!-- Example link to open edit modal -->
                                                                                     <a href="{{route('crop_category.crop_edit', $cropcategory->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                                                       
            
                                                                                        <form  action="{{ route('crop_category.crop_destroy',  $cropcategory->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                                                            {{ csrf_field()}}
                                                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                                                   </form>
                                                                                  
                                                                               </td>
                                                                         </tr>
                                                                         @endforeach
                                                                         @else
                                                                         <tr>
                                                                             <td class="text-center" colspan="5">AgriDistirict is empty</td>
                                                                         </tr>
                                                                         @endif
                                                                     </tbody>
                                                                 </table>
                                                             </div>
                                                              <!-- Pagination links -->
                                                              <ul class="pagination">
                                                                 <li><a href="{{ $CropCat->previousPageUrl() }}">Previous</a></li>
                                                                 @foreach ($CropCat->getUrlRange(1,$CropCat->lastPage()) as $page => $url)
                                                                     <li class="{{ $page == $CropCat->currentPage() ? 'active' : '' }}">
                                                                         <a href="{{ $url }}">{{ $page }}</a>
                                                                     </li>
                                                                 @endforeach
                                                                 <li><a href="{{ $CropCat->nextPageUrl() }}">Next</a></li>
                                                             </ul>
                                                         </div>
                                                          {{-- crop variety look up table--}}
                                                          <input type="radio" name="tabs" id="cropVariety" checked="checked">
                                                          <label for="cropVariety">Crop Variety</label>
                                                          <div class="tab">
                                                              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                                  <div class="input-group mb-3">
                                                                      <h5>Add Crop Variety</h5>
                                                                  </div>
                                                                 <div class="me-md-1">
                                                                         <!-- Button trigger modal -->
                                                                         <div class="me-md-1">
                                                                             <a href="{{ route('admin.variety.add_variety') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                         </div>
                                                                     </div>
                                         
                                                                  {{-- <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                      <div class="input-group mb-3">
                                                                          <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                                                          <button class="btn btn-outline-success" type="submit">Search</button>
                                                                      </div>
                                                                  </form>
                                                                  <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                      <button class="btn btn-outline-success" type="submit">All</button>
                                                                  </form> --}}
                                                              </div>
             
             
                              
                                                              <div class="table-responsive">
                                                                  <table class="table table-bordered datatable">
                                                                      <!-- Table content here -->
                                                                      <thead class="thead-light">
                                                                          <tr >
                                                                              
                                                                                <th>#</th>
                                                                                <th>Crop Name</th>
                                                                                <th>Variety Name</th>
                                                                           
                                                                         
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                          @if($CropVariety->count() > 0)
                                                                        @foreach($CropVariety as $cropcategory)
                                                                            <tr class="table-light">
                                                                               
                                                                                 <td>{{  $cropcategory->id }}</td>
                                                                                <td>{{  $cropcategory->crop_name }}</td>
                                                                                <td>{{  $cropcategory->variety_name}}</td>
                                                                              
                                                                               
                                                                                <td>
                                                                                   
                                                                                                                                                 <!-- Example link to open edit modal -->
                                                                                      <a href="{{route('admin.variety.edit_variety', $cropcategory->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                                                        
             
                                                                                         <form  action="{{ route('admin.variety.delete',  $cropcategory->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                                                             {{ csrf_field()}}
                                                                                             <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                                                    </form>
                                                                                   
                                                                                </td>
                                                                          </tr>
                                                                          @endforeach
                                                                          @else
                                                                          <tr>
                                                                              <td class="text-center" colspan="5">Crop Variety is empty</td>
                                                                          </tr>
                                                                          @endif
                                                                      </tbody>
                                                                  </table>
                                                              </div>
                                                               <!-- Pagination links -->
                                                               <ul class="pagination">
                                                                  <li><a href="{{ $CropVariety->previousPageUrl() }}">Previous</a></li>
                                                                  @foreach ($CropVariety->getUrlRange(1,$CropVariety->lastPage()) as $page => $url)
                                                                      <li class="{{ $page == $CropVariety->currentPage() ? 'active' : '' }}">
                                                                          <a href="{{ $url }}">{{ $page }}</a>
                                                                      </li>
                                                                  @endforeach
                                                                  <li><a href="{{ $CropVariety->nextPageUrl() }}">Next</a></li>
                                                              </ul>
                                                          </div>
                        <!-- Repeat the same structure for other tabs -->



                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
  


  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




<!-- Include the Google Maps API with Drawing and Geometry libraries -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&libraries=drawing,geometry&callback=initMap"></script>
<script type="text/javascript">
    var map;
    var drawingManager;
    var selectedShape;

    // Initialize the map
    function initMap() {
        var initialLocation = { lat: 6.9214, lng: 122.0790 }; // Adjust to your desired initial map center

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: initialLocation,
            mapTypeId: 'satellite'
        });

        // Initialize the Drawing Manager
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: ['polygon']
            },
            polygonOptions: {
                editable: true,
                strokeWeight: 2
            }
        });
        drawingManager.setMap(map);

        // Add event listener to capture the drawn polygon
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
            if (event.type === google.maps.drawing.OverlayType.POLYGON) {
                if (selectedShape) {
                    selectedShape.setMap(null);
                }
                selectedShape = event.overlay;

                updatePolygonColors(); // Apply selected colors when the polygon is created

                // Calculate and set area
                var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
                document.getElementById('area').value = area.toFixed(2);

                // Get the coordinates of the polygon's vertices
                var path = selectedShape.getPath();
                var coordinatesText = '';
                path.forEach(function (latLng, index) {
                    var lat = latLng.lat();
                    var lng = latLng.lng();
                    coordinatesText += 'Vertex ' + (index + 1) + ': Latitude: ' + lat.toFixed(6) + ', Longitude: ' + lng.toFixed(6) + '\n';
                });

                // Display the coordinates in the textarea
                document.getElementById('polygon-coordinates').value = coordinatesText;

                // Get the elevation of the first vertex
                getElevation(path.getAt(0));

                // Listen for changes in polygon vertices
                google.maps.event.addListener(selectedShape.getPath(), 'set_at', function () {
                    updatePolygonColors();
                });

                google.maps.event.addListener(selectedShape.getPath(), 'insert_at', function () {
                    updatePolygonColors();
                });
            }
        });

        // Load existing polygons from the server
        loadPolygons();
    }

    // Function to get and display elevation
    function getElevation(latLng) {
        var elevator = new google.maps.ElevationService();
        elevator.getElevationForLocations({ 'locations': [latLng] }, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var elevation = results[0].elevation;
                    document.getElementById('altitude').value = elevation.toFixed(2);
                } else {
                    document.getElementById('altitude').value = 'No data';
                }
            } else {
                document.getElementById('altitude').value = 'Error';
            }
        });
    }

    // Load existing polygons
    function loadPolygons() {
        var mapdata = @json($mapdata); // Ensure that $mapdata is properly formatted as JSON in your Laravel controller.

        // Loop through the mapdata and add polygons to the map
        mapdata.forEach(function (parcel) {
            var polygon = new google.maps.Polygon({
                paths: parcel.coordinates.map(coord => new google.maps.LatLng(coord.lat, coord.lng)),
                strokeColor: parcel.strokecolor, // Use color from data or default to blue
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: parcel.fillcolor, // Use fill color from data or default to green
                fillOpacity: 0.02
            });
            polygon.setMap(map);

            // Bind a click event to show parcel details
            google.maps.event.addListener(polygon, 'click', function () {
                var contentString = 'Parcel ID: ' + parcel.id + '<br>' +
                                    'Area: ' + parcel.area + ' sq. meters<br>' +
                                    'Altitude: ' + parcel.altitude + ' meters';
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                infowindow.setPosition(parcel.coordinates[0]);
                infowindow.open(map);
            });
        });

        // Optionally, fit the map to the bounds of the polygons
        var bounds = new google.maps.LatLngBounds();
        mapdata.forEach(function (parcel) {
            parcel.coordinates.forEach(function (coord) {
                bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
            });
        });
        map.fitBounds(bounds);
    }

// Save polygon data via AJAX
document.getElementById('save-polygon').addEventListener('click', function () {
    if (!selectedShape) {
        alert("Please draw a polygon first.");
        return;
    }

    // Get polygon coordinates
    var path = selectedShape.getPath();
    var coordinates = [];
    path.forEach(function (latLng) {
        coordinates.push({
            lat: latLng.lat(),
            lng: latLng.lng()
        });
    });

    // Get area and altitude
    
    var polygonName = document.getElementById('boarder-name').value;
    var area = document.getElementById('area').value;
    var altitude = document.getElementById('altitude').value;

    // Get fill and stroke colors
    var fillColor = getSelectedFillColor();
    var strokeColor = getSelectedStrokeColor();

    // AJAX request to save the polygon data
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin-view-polygon', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert("Polygon saved successfully!");
                window.location.reload(); // Reload the page after successful save
            } else {
                alert("Error saving polygon. Please try again.");
            }
        }
    };
    var data = JSON.stringify({
        coordinates: coordinates,
       polygonName :polygonName ,
        area: area,
        altitude: altitude,
        fillcolor: fillColor,
        strokecolor: strokeColor
    });
    xhr.send(data);
});

    // Function to update polygon fill and stroke colors based on the selected options
    function updatePolygonColors() {
        if (selectedShape) {
            var fillColor = getSelectedFillColor();
            var strokeColor = getSelectedStrokeColor();

            selectedShape.setOptions({
                fillColor: fillColor,
                strokeColor: strokeColor
            });
        }
    }

    // Helper function to get the selected fill color
    function getSelectedFillColor() {
        var fillColorSelect = document.getElementById('fill-color-select').value;
        if (fillColorSelect === 'custom-fill') {
            return document.getElementById('custom-fill-color').value;
        }
        return fillColorSelect;
    }

    // Helper function to get the selected stroke color
    function getSelectedStrokeColor() {
        var strokeColorSelect = document.getElementById('stroke-color-select').value;
        if (strokeColorSelect === 'custom-stroke') {
            return document.getElementById('custom-stroke-color').value;
        }
        return strokeColorSelect;
    }

    // Event listener for showing/hiding custom color inputs for fill color
    document.getElementById('fill-color-select').addEventListener('change', function () {
        var fillColorSelect = document.getElementById('fill-color-select').value;
        if (fillColorSelect === 'custom-fill') {
            document.getElementById('custom-fill-color').style.display = 'inline';
            document.getElementById('custom-fill-color-label').style.display = 'inline';
        } else {
            document.getElementById('custom-fill-color').style.display = 'none';
            document.getElementById('custom-fill-color-label').style.display = 'none';
        }
        updatePolygonColors();
    });

    // Event listener for showing/hiding custom color inputs for stroke color
    document.getElementById('stroke-color-select').addEventListener('change', function () {
        var strokeColorSelect = document.getElementById('stroke-color-select').value;
        if (strokeColorSelect === 'custom-stroke') {
            document.getElementById('custom-stroke-color').style.display = 'inline';
            document.getElementById('custom-stroke-color-label').style.display = 'inline';
        } else {
            document.getElementById('custom-stroke-color').style.display = 'none';
            document.getElementById('custom-stroke-color-label').style.display = 'none';
        }
        updatePolygonColors();
    });
</script>



<script src="{{ asset('js/modal_map.js') }}"></script>
@endsection
