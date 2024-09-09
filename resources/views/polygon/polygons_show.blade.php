@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')


<div class="page-content">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    
                    <h2> Rice Boarders</h2>
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
                        <input type="radio" name="tabs" id="Seed" checked="checked">
                        <label for="Seed">Polygon</label>
                        <div class="tab">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3 me-md-1">
                                    <h5 for="Seed" class="me-3">a. Polygon Boundary</h5>
                                </div>
                                                        
                                <div class="me-md-1">
                                    <a href="{{ route('polygon.create') }}" class="btn btn-success">Add</a>
                                </div>
                            
                                <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET" class="me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                            
                                <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form>
                            </div>
                            
                            
                               <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light" >
                                        <tr>
                                            <th>#</th>
                                            <th>agri-district</th>
                                            <th>Polygon name</th>
                                            <th>color</th>
                                            <th>point 1 lat</th>
                                            <th>point 1 lng</th>
                                            <th>pontt 2 lat</th>
                                            <th>point 2 lng</th>
                                            <th>pontt 3 lat</th>
                                            <th>point 3 lng</th>
                                            <th>pontt 4 lat</th>
                                            <th>point 4 lng</th>
                                            <th>point 5 lat</th>
                                            <th>point 5 lng</th>
                                            <th>pontt 6 lat</th>
                                            <th>point 6 lng</th>
                                            <th>pontt 7 lat</th>
                                            <th>point 7 lng</th>
                                            <th>pontt 8 lat</th>
                                            <th>point 8 lng</th>
                                            <th>area</th>
                                            <th>perimeter</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($polygons->count() > 0)
                                        @foreach($polygons as $seed)
                                            <tr class="table-light">
                                                 
                                                 <td>{{$seed->id}}</td>
                                                 <td>{{$seed->agri_districts}}</td>
                                                 <td>{{$seed->poly_name }}</td>
                                                 <td>{{$seed->strokecolor }}</td>
                                                 <td>{{$seed->verone_latitude }}</td>
                                                <td>{{$seed->verone_longitude}}</td>
                                                <td>{{$seed->vertwo_latitude }}</td>
                                                <td>{{$seed->vertwo_longitude}}</td>
                                                <td>{{$seed->verthree_latitude }}</td>
                                                <td>{{$seed->verthree_longitude }}</td>
                        
                                                <td>{{$seed->vertfour_latitude }}</td>
                                                <td>{{$seed->vertfour_longitude}}</td>
                                                <td>{{$seed->verfive_latitude }}</td>
                                                <td>{{$seed->verfive_longitude}}</td>
                                                <td>{{$seed->versix_latitude }}</td>
                                                <td>{{$seed->versix_longitude}}</td>
                                                <td>{{$seed->verseven_latitude }}</td>
                                                <td>{{$seed->verseven_longitude}}</td>
                                                <td>{{$seed->vereight_latitude }}</td>
                                                <td>{{$seed->verteight_longitude}}</td>
                                                <td>{{$seed->area}}</td>
                                                <td>{{$seed->perimeter}}</td>
                                                
                                                
                          
                                                <td>
                                                   
                                                     <a href="{{route('polygon.polygons_edit',  $seed->id)}}" title="Edit Student"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> 
                                        
                                                     <form  action="{{ route('polygon.delete', $seed->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Student" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                                <li><a href="{{ $polygons->previousPageUrl() }}">Previous</a></li>
                                @foreach ($polygons->getUrlRange(1,$polygons->lastPage()) as $page => $url)
                                    <li class="{{ $page == $polygons->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $polygons->nextPageUrl() }}">Next</a></li>
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
                                    <a href="{{ route('parcels.new_parcels') }}" class="btn btn-success">Add</a>
                                </div>
                                <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr >
                                            
                                              <th>#</th>
                                              <th>Parcel Name</th>
                                              <th>ARP OwnerName</th>
                                              <th>Agri-District</th>
                                              <th>brgyName</th>
                                              <th>land title no</th>
                                              <th>Lot no.</th>
                                              <th>pkind desc</th>
                                              <th>pused desc</th>
                                              <th>actual used</th>
                                              <th>Longitude</th>
                                              <th>Latitude</th>
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
                                              <td>{{  $personalinformation->agri_districts }}</td>
                                              <td>{{  $personalinformation->barangay_name }}</td>
                                              <td>{{  $personalinformation->tct_no}}</td>
                                              <td>{{  $personalinformation->lot_no }}</td>
                                              <td>{{  $personalinformation->pkind_desc }}</td>
                                              <td>{{  $personalinformation->puse_desc }}</td>
                                              <td>{{  $personalinformation->actual_used}}</td>
                                              <td>{{  $personalinformation->latitude }}</td>
                                              <td>{{  $personalinformation->longitude }}</td>
                                              <td>{{  $personalinformation->area }}</td>
                                              <td>{{  $personalinformation->parcolor }}</td>
                                             
                                              <td>
                                                 
                                                   <a href="{{route('parcels.edit',  $personalinformation->id)}}" title="Edit Student"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> 
                                      
                                                   <form  action="{{ route('parcels.delete',  $personalinformation->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                      {{ csrf_field()}}
                                                      <button type="submit" class="btn btn-danger btn-sm" title="Delete Student" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                                                                <a href="{{ route('agri_districts.display') }}" class="btn btn-success">Add</a>
                                                            </div>
                                                        </div>
                            
                                                     <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                         <div class="input-group mb-3">
                                                             <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                                             <button class="btn btn-outline-success" type="submit">Search</button>
                                                         </div>
                                                     </form>
                                                     <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                         <button class="btn btn-outline-success" type="submit">All</button>
                                                     </form>
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
                                                                      
                                                                                                                                    <!-- Example link to open edit modal -->
                                                                                                                                    <a href="{{route('agri_districts.agri_edit', $personalinformation->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> 
                                                           

                                                                            <form  action="{{ route('agri_districts.agri_delete',  $personalinformation->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                                                {{ csrf_field()}}
                                                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Student" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
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
                                                                            <a href="{{ route('crop_category.crop_create') }}" class="btn btn-success">Add</a>
                                                                        </div>
                                                                    </div>
                                        
                                                                 <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                     <div class="input-group mb-3">
                                                                         <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                                                         <button class="btn btn-outline-success" type="submit">Search</button>
                                                                     </div>
                                                                 </form>
                                                                 <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                     <button class="btn btn-outline-success" type="submit">All</button>
                                                                 </form>
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
                                                                             <a href="{{ route('admin.variety.add_variety') }}" class="btn btn-success">Add</a>
                                                                         </div>
                                                                     </div>
                                         
                                                                  <form id="farmProfileSearchForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                      <div class="input-group mb-3">
                                                                          <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                                                          <button class="btn btn-outline-success" type="submit">Search</button>
                                                                      </div>
                                                                  </form>
                                                                  <form id="showAllForm" action="{{ route('polygon.polygons_show') }}" method="GET">
                                                                      <button class="btn btn-outline-success" type="submit">All</button>
                                                                  </form>
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

  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&libraries=drawing,geometry&callback=initMap"></script>
<script type="text/javascript">
  var map;
  var markers = [];

  function initMap() {
    var initialLocation = {lat: 6.9214, lng: 122.0790};

    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16.3,
      center: initialLocation,
      mapTypeId: 'terrain'
    });

    // This event listener will call addMarker() when the map is clicked.
    map.addListener('click', function(event) {
      if (markers.length >= 1) {
          deleteMarkers();
      }

      addMarker(event.latLng);
      document.getElementById('lat').value = event.latLng.lat();
      document.getElementById('long').value = event.latLng.lng();

      // Fetch the altitude for the clicked point
      getElevation(event.latLng);
    });

    // Event listener for latitude and longitude input fields
    $('#lat, #long').on('change', function() {
      var lat = parseFloat($('#lat').val());
      var lng = parseFloat($('#long').val());
      
      if (!isNaN(lat) && !isNaN(lng)) {
        var location = { lat: lat, lng: lng };
        map.setCenter(location);
        deleteMarkers();
        addMarker(location);
      }
    });
  }

  // Adds a marker to the map and push to the array.
  function addMarker(location) {
    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
    markers.push(marker);
  }

  // Sets the map on all markers in the array.
  function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }

  // Removes the markers from the map, but keeps them in the array.
  function clearMarkers() {
    setMapOnAll(null);
  }

  // Deletes all markers in the array by removing references to them.
  function deleteMarkers() {
    clearMarkers();
    markers = [];
  }

  // Fetch and display the elevation of a location
  function getElevation(latLng) {
    var elevator = new google.maps.ElevationService();
    elevator.getElevationForLocations({'locations': [latLng]}, function(results, status) {
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

  // jQuery event listener for form submission
  $(document).ready(function() {
    $(document).on('click', '.btn-submit', function(event) {
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
                  className: "btn-success",
                  closeModal: false
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
</script>


<script>
    // Function to handle opening edit modal and populating data
    function editAgriDistrict(agriDistrictId) {
        // Fetch data or set values dynamically based on agriDistrictId
        var agriDistrict = {}; // Example: Replace with actual data fetching logic

        // Set modal form action dynamically
        var form = document.getElementById('editAgriDistrictForm');
        form.action = '//admin-view-polygon/' + agriDistrictId; // Adjust based on your route

        // Set modal input fields based on fetched data
        document.getElementById('agriDistrictId').value = agriDistrictId;
        document.getElementById('districtName').value = agriDistrict.district_name;

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('editAgriDistrictModal'), {});
        modal.show();
    }
</script>
@endsection
