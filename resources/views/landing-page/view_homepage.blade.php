@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')


<div class="page-content">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    
                    <h2>Homepage Setting</h2>
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
                        <label for="Seed">Homepage Title</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3 me-md-1">
                                    <h5 for="Seed" class="me-3">Create Homepage</h5>
                                </div>
                                @if(isset($isCropPage) && $isCropPage && $Page->isEmpty())
                                <div class="me-md-1">
                                    <a href="{{ route('landing-page.add_homepage') }}" title="Add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                            @endif
                            
                                {{-- <div class="me-md-1">
                                    <a href="{{ route('landing-page.add_homepage') }}" title="Add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>

                                </div>
                             --}}
                                {{-- <form id="farmProfileSearchForm" action="" method="GET" class="me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                            
                                <form id="showAllForm" action="" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="addBarangayModal" tabindex="-1" aria-labelledby="addBarangayModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBarangayModalLabel">Add Homepage</h5>
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
                                                            <span class="details">AgriDistrict</span>
                                                            <select class="form-control light-gray-placeholder @error('extension_name') is-invalid @enderror"  name="extension_name"id="validationCustom01" aria-label="Floating label select e">
                                                              <option selected disabled>Select</option>
                                                             
                                                              <option value="others" {{ old('extension_name') == 'others' ? 'selected' : '' }}>others</option>
                                                            </select>
                                                          </div>
                                                          <div class="input-box">
                                                            <span class="details">Barangay</span>
                                                            <select class="form-control light-gray-placeholder"  name="religion"id="selectReligion"onchange="checkReligion()" aria-label="Floating label select e">
                                                                <option selected disabled>Select</option>
                                                                <option value="Roman Catholic" {{ old('religion') == 'Roman Catholic' ? 'selected' : '' }}>Roman Catholic</option>
                                                                <option value="Iglesia Ni Cristo" {{ old('religion') == 'Iglesia Ni Cristo' ? 'selected' : '' }}>Iglesia Ni Cristo</option>
                                                                <option value="Seventh-day Adventist" {{ old('religion') == 'Seventh-day Adventist' ? 'selected' : '' }}>Seventh-day Adventist</option>
                                                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                                <option value="Born Again CHurch" {{ old('religion') == 'Born Again CHurch' ? 'selected' : '' }}>Born Again CHurch</option>
                                                                <option value="N/A" {{ old('religion') == 'N/A' ? 'selected' : '' }}>N/A</option>
                                                                <option value="other" {{ old('religion') == 'other' ? 'selected' : '' }}>other</option>
                                                            </select>
                                                          </div>
                                                        <div class="input-box" id="ReligionInputField" style="display: none;">
                                                          <span class="details">Add Barangay</span>
                                                          <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"  name="religion"id="selectReligion"onchange="checkReligion()" >
                                                          @error('middle_name')
                                                          <div class="invalid-feedback">{{ $message }}</div>
                                                      @enderror
                                                        </div>
                                                     
                                                       
                                                      
                                                        
                                                      </div>
                                                      <div class="form_1_btns">
                                                       
                                                        <a  href="{{route('admin.barangay.view_forms')}}"button class="btn btn-secondary btn_back mr-2">Back</button></a>
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                
                                            
                                                          
                                                            
                                                          </div>
                                                     
                                            
                                                     
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                            
                            
                               <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light" >
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($Page->count() > 0)
                                        @foreach($Page as $landpage)
                                            <tr class="table-light">
                                                 
                                                 <td>{{$landpage->id}}</td>
                                                 <td>{{$landpage->home_title }}</td>
                                                 <td>
                                                    @php
                                                        // Split the description into parts by line breaks or full stops
                                                        $paragraphs = preg_split('/\n|\.\s*/', $landpage->home_description);
                                                        // Limit to the first three paragraphs
                                                        $paragraphs = array_slice($paragraphs, 0, 6);
                                                    @endphp
                                                
                                                    @foreach($paragraphs as $paragraph)
                                                        @if(!empty($paragraph))
                                                            <p>{{ $paragraph }}.</p>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                

                                                 
                                                
                          
                                                <td>
                                                   
                                                     <a href="{{route('landing-page.edit_homepage',  $landpage->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                        
                                                     <form  action="{{ route('landing-page.delete', $landpage->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                    </form> 
                                                    
                                                </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="10">Homepage is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $Page->previousPageUrl() }}">Previous</a></li>
                                @foreach ($Page->getUrlRange(1,$Page->lastPage()) as $page => $url)
                                    <li class="{{ $page == $Page->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $Page->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>


                        <!-- Repeat the same structure for other tabs -->
                   
                        <input type="radio" name="tabs" id="feautures" checked="checked">
                        <label for="feautures">Feautures</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3 me-md-1">
                                    <h5 for="Seed" class="me-3">Create Homepage</h5>
                                </div>
                                @if(isset($isCropPage) && $isCropPage && $Page->isEmpty())
                                <div class="me-md-1">
                                    <a href="{{ route('landing-page.Features.add') }}" title="add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>

                                </div>
                                @endif
                            
                                {{-- <form id="farmProfileSearchForm" action="" method="GET" class="me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                            
                                <form id="showAllForm" action="" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="addBarangayModal" tabindex="-1" aria-labelledby="addBarangayModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBarangayModalLabel">Add Homepage</h5>
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
                                                            <span class="details">AgriDistrict</span>
                                                            <select class="form-control light-gray-placeholder @error('extension_name') is-invalid @enderror"  name="extension_name"id="validationCustom01" aria-label="Floating label select e">
                                                              <option selected disabled>Select</option>
                                                             
                                                              <option value="others" {{ old('extension_name') == 'others' ? 'selected' : '' }}>others</option>
                                                            </select>
                                                          </div>
                                                          <div class="input-box">
                                                            <span class="details">Barangay</span>
                                                            <select class="form-control light-gray-placeholder"  name="religion"id="selectReligion"onchange="checkReligion()" aria-label="Floating label select e">
                                                                <option selected disabled>Select</option>
                                                                <option value="Roman Catholic" {{ old('religion') == 'Roman Catholic' ? 'selected' : '' }}>Roman Catholic</option>
                                                                <option value="Iglesia Ni Cristo" {{ old('religion') == 'Iglesia Ni Cristo' ? 'selected' : '' }}>Iglesia Ni Cristo</option>
                                                                <option value="Seventh-day Adventist" {{ old('religion') == 'Seventh-day Adventist' ? 'selected' : '' }}>Seventh-day Adventist</option>
                                                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                                <option value="Born Again CHurch" {{ old('religion') == 'Born Again CHurch' ? 'selected' : '' }}>Born Again CHurch</option>
                                                                <option value="N/A" {{ old('religion') == 'N/A' ? 'selected' : '' }}>N/A</option>
                                                                <option value="other" {{ old('religion') == 'other' ? 'selected' : '' }}>other</option>
                                                            </select>
                                                          </div>
                                                        <div class="input-box" id="ReligionInputField" style="display: none;">
                                                          <span class="details">Add Barangay</span>
                                                          <input type="text" class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"  name="religion"id="selectReligion"onchange="checkReligion()" >
                                                          @error('middle_name')
                                                          <div class="invalid-feedback">{{ $message }}</div>
                                                      @enderror
                                                        </div>
                                                     
                                                       
                                                      
                                                        
                                                      </div>
                                                      <div class="form_1_btns">
                                                       
                                                        <a  href="{{route('admin.barangay.view_forms')}}"button class="btn btn-secondary btn_back mr-2">Back</button></a>
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                
                                            
                                                          
                                                            
                                                          </div>
                                                     
                                            
                                                     
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                            
                            
                               <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light" >
                                        <tr>
                                            <th>#</th>
                                           
                                            <th>feature header</th>
                                            <th>feature description</th>
                                            {{-- <th>agri features</th> --}}
                                           
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($Page->count() > 0)
                                        @foreach($Page as $landpage)
                                            <tr class="table-light">
                                                 
                                                 <td>{{$landpage->id}}</td>
                                                 
                                                <td>{{$landpage->feature_header }}</td>
                                                {{-- <td>{{$landpage->feature_description}}</td> --}}

{{-- 
                                                <td>
                                                    @php
                                                        // Split the textarea content by newlines
                                                        $paragraphs = preg_split('/\r\n|\r|\n/', $landpage->feature_description);
                                                        // Limit to the first three paragraphs
                                                        $paragraphs = array_slice($paragraphs, 0, 50);
                                                    @endphp
                                                
                                                    @foreach($paragraphs as $paragraph)
                                                        @if(!empty(trim($paragraph)))
                                                            <p>{{ $paragraph }}</p>
                                                        @endif
                                                    @endforeach
                                                </td> --}}
                                                <td>
                                                    @php
                                                        // Split the textarea content by newlines
                                                        $paragraphs = preg_split('/\r\n|\r|\n/', $landpage->agri_feature);
                                                        // Limit to the first three paragraphs
                                                        $paragraphs = array_slice($paragraphs, 0, 50);
                                                    @endphp
                                                
                                                    @foreach($paragraphs as $paragraph)
                                                        @if(!empty(trim($paragraph)))
                                                            <p>{{ $paragraph }}</p>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                
                                              
                        
                                                
                          
                                                <td>
                                                   
                                                     <a href="{{route('landing-page.Features.edit',  $landpage->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                        
                                                     <form  action="{{ route('landing-page.delete', $landpage->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                    </form> 
                                                    
                                                </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="10">Homepage is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $Page->previousPageUrl() }}">Previous</a></li>
                                @foreach ($Page->getUrlRange(1,$Page->lastPage()) as $page => $url)
                                    <li class="{{ $page == $Page->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $Page->nextPageUrl() }}">Next</a></li>
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
@endsection
