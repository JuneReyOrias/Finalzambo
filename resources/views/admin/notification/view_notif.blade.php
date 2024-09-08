@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')


<div class="page-content">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    
                    <h2>Notification Setting</h2>
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
                        <label for="Seed">Notification Setting</label>
                        <div class="tab">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3 me-md-1">
                                    <h5 for="Seed" class="me-3">Notification</h5>
                                </div>
                            
                                <div class="me-md-1">
                                    <a href="{{ route('admin.notification.add_notif') }}" class="btn btn-success">Add</a>

                                </div>
                            
                                <form id="farmProfileSearchForm" action="" method="GET" class="me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                            
                                <form id="showAllForm" action="" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form>
                            </div>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="addBarangayModal" tabindex="-1" aria-labelledby="addBarangayModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBarangayModalLabel">Add Barangay</h5>
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
                                            <th>sender</th>
                                            <th>Reciever</th>
                                            <th>Message</th>
                                     
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @if($polygons->count() > 0) --}}
                                        @foreach($notif as $message)
                                            <tr class="table-light">
                                                 
                                                 <td>{{$message->id}}</td>
                                                 <td>{{$message->sender_id }}</td>
                                                 <td>{{$message->receiver_id }}</td>
                                                 <td>{{$message->message }}</td>
                                                <td>
                                                   
                                                     <a href="{{route('admin.notification.edit_notif',  $message->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> 
                                        
                                                     <form  action="{{ route('admin.notification.delete', $message->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Student" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                                    </form> 
                                                    
                                                </td>
                                        </tr>
                                        @endforeach
                                       
                                        {{-- <tr>
                                            <td class="text-center" colspan="5">Notification is empty</td>
                                        </tr> --}}
                                     
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $notif->previousPageUrl() }}">Previous</a></li>
                                @foreach ($notif->getUrlRange(1,$notif->lastPage()) as $page => $url)
                                    <li class="{{ $page == $notif->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $notif->nextPageUrl() }}">Next</a></li>
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
