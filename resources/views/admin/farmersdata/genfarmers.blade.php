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
                    
                    <h4>Farmers Data</h4>
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
                        <label for="personainfo">Personal Info</label>
                        <div class="tab">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3">
                                    <h5 for="personainfo">I.Personal Information</h5>
                                </div>
                                <a href="{{route("admin.farmersdata.samplefolder.farm_edit")}}" title="Add farm">
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
                                    <thead >
                                        <tr >
                    
                                            <th>#</th>
                                            <th class="custom-cell">Farmer Name</th>
                                            <th class="custom-cell">Sex</th>
                                            <th class="custom-cell">civil <p>status</p></th>
                                            <th class="custom-cell">Home Address</th>
                                           <th class="custom-cell">date of <p> birth</p></th>
                                           <th class="custom-cell">place of <p> birth</p></th>
                                           <th class="custom-cell">No. of<p> Children</p></th>
                                           <th class="custom-cell">contact no.</th>
                                           
                                          
                                          
                                       
                                        
                                       
                                         
                                           <th class="custom-cell">government <p>issued id</p></th>
                                          
                                           <th class="custom-cell">gov id no</th>
                                          
                                           <th class="custom-cell">name of farmers ass/org/coop</th>
                                          
                                        
                                           <th class="custom-cell">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($personalinfos->count() > 0)
                                    @foreach($personalinfos as $personalinformation)      
                                <tr class="table-light">
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td class="custom-cell">{{  $personalinformation->id }}</td>
                                    <td class="custom-cell">
                                    <?php
                                    // Define variables
                                    $first_name = $personalinformation->first_name;
                                    $middle_name = $personalinformation->middle_name;
                                    $last_name = $personalinformation->last_name;
                                    $extension_name = $personalinformation->extension_name;
                                
                                    // Construct the full name
                                    $full_name = $first_name;
                                
                                    // Check and append the middle name
                                    if (!empty($middle_name) && $middle_name !== 'N/A') {
                                        $full_name .= ' ' . $middle_name;
                                    }
                                
                                    $full_name .= ' ' . $last_name;
                                
                                    // Check if extension_name is not empty and not equal to "N/A"
                                    if (!empty($extension_name) && $extension_name !== 'N/A') {
                                        $full_name .= ' ' . $extension_name;
                                    }
                                
                                    // Output the full name
                                    echo htmlspecialchars($full_name);
                                    ?>

                                </td>
                                <td class="custom-cell">
                                  @if ($personalinformation->sex && $personalinformation->sex != 'N/A')
                                      {{ $personalinformation->sex }}
                                  @else
                                      
                                  @endif
                              </td>

                              <td class="custom-cell">
                                @if ($personalinformation->civil_status && strtolower($personalinformation->civil_status) != 'n/a')
                                    {{ $personalinformation->civil_status }}
                                @else
                                    
                                @endif
                            </td>
                                <td class="custom-cell">
                                    @if ($personalinformation->barangay || $personalinformation->agri_district || $personalinformation->city)
                                        {{ $personalinformation->barangay ?? 'N/A' }}, {{ $personalinformation->agri_district ?? 'N/A' }}, {{ $personalinformation->city ?? 'N/A' }}
                                    @elseif ($personalinformation->home_address)
                                        {{ $personalinformation->home_address }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                
                         
                            {{-- <td class="custom-cell">
                                @if ($personalinformation->religion && $personalinformation->religion != 'N/A')
                                    {{ $personalinformation->religion }}
                                @else
                                
                                @endif
                            </td> --}}
                            <td class="custom-cell">
                            @if ($personalinformation->date_of_birth && $personalinformation->date_of_birth != 'N/A')
                                {{ $personalinformation->date_of_birth }}
                            @else
                      
                                    @endif
                                </td>
                                <td class="custom-cell">
                                    @if ($personalinformation->place_of_birth && $personalinformation->place_of_birth != 'N/A')
                                        {{ $personalinformation->place_of_birth }}
                                    @else
                                    
                                    @endif
                                </td>
                                <td class="custom-cell">
                                  @if ($personalinformation->no_of_children && strtolower($personalinformation->no_of_children) != 'n/a')
                                      {{ $personalinformation->no_of_children }}
                                  @else
                                      
                                  @endif
                              </td>
                                <td class="custom-cell">
                                    @if ($personalinformation->contact_no && strtolower($personalinformation->contact_no) != 'n/a')
                                        {{ $personalinformation->contact_no }}
                                    @else
                                    
                                    @endif
                                </td>
                               
                            {{-- <td class="custom-cell">
                                @if ($personalinformation->name_legal_spouse && strtolower($personalinformation->name_legal_spouse) != 'n/a')
                                    {{ $personalinformation->name_legal_spouse }}
                                @else
                                
                                @endif
                            </td> --}}
                           
                        {{-- <td class="custom-cell">
                            @if ($personalinformation->mothers_maiden_name && strtolower($personalinformation->mothers_maiden_name) != 'n/a')
                                {{ $personalinformation->mothers_maiden_name }}
                            @else
                            
                            @endif
                        </td>
                        <td class="custom-cell">
                            @if ($personalinformation->highest_formal_education && strtolower($personalinformation->highest_formal_education) != 'n/a')
                                {{ $personalinformation->highest_formal_education }}
                            @else
                            
                            @endif
                        </td> --}}
                        {{-- <td class="custom-cell">
                        @if ($personalinformation->person_with_disability && strtolower($personalinformation->person_with_disability) != 'n/a')
                            {{ $personalinformation->person_with_disability }}
                        @else
                            
                        @endif
                    </td> --}}

                    <td class="custom-cell">
                        @if ($personalinformation->government_issued_id && strtolower($personalinformation->government_issued_id) != 'n/a')
                            {{ $personalinformation->government_issued_id }}
                        @else
                        
                        @endif
                    </td>
                    {{-- <td class="custom-cell">
                    @if ($personalinformation->government_issued_id && strtolower($personalinformation->government_issued_id) != 'n/a')
                        {{ $personalinformation->government_issued_id }}
                    @else
                        
                    @endif --}}
                    {{-- </td>
                    <td class="custom-cell">
                    @if ($personalinformation->id_type && strtolower($personalinformation->id_type) != 'n/a')
                        {{ $personalinformation->id_type }}
                    @else
                    
                    @endif
                    </td> --}}
                    <td class="custom-cell">
                    @if ($personalinformation->gov_id_no && strtolower($personalinformation->gov_id_no) != 'n/a')
                        {{ $personalinformation->gov_id_no }}
                    @else
                    
                    @endif
                    </td>
                    {{-- <td class="custom-cell">
                    @if ($personalinformation->member_ofany_farmers_ass_org_coop && strtolower($personalinformation->member_ofany_farmers_ass_org_coop) != 'n/a')
                        {{ $personalinformation->member_ofany_farmers_ass_org_coop }}
                    @else
                    
                    @endif
                    </td> --}}

                    <td class="custom-cell">
                    @if ($personalinformation->nameof_farmers_ass_org_coop && strtolower($personalinformation->nameof_farmers_ass_org_coop) != 'n/a')
                        {{ $personalinformation->nameof_farmers_ass_org_coop }}
                    @else
                    
                    @endif
                    </td>
{{-- 
                    <td class="custom-cell">
                    @if ($personalinformation->name_contact_person && strtolower($personalinformation->name_contact_person) != 'n/a')
                        {{ $personalinformation->name_contact_person }}
                    @else
                    
                    @endif
                    </td>
                    <td class="custom-cell">
                    @if ($personalinformation->cp_tel_no && strtolower($personalinformation->cp_tel_no) != 'n/a')
                        {{ $personalinformation->cp_tel_no }}
                    @else
                    
                    @endif
                    </td> --}}
                    <td class="custom-cell">
                      <a href="{{ route('admin.farmersdata.farm', $personalinformation->id) }}" title="View farm">
                          <button class="btn btn-success btn-sm">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                          </button>
                      </a>
                      <a href="{{ route('personalinfo.edit_info', $personalinformation->id) }}" title="View farmer">
                          <button class="btn btn-primary btn-sm">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </button>
                      </a>
                      <form action="{{ route('personalinfo.delete', $personalinformation->id) }}" method="post" accept-charset="UTF-8" style="display:inline">
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                          </button>
                      </form>
                  </td>
                  
                   </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Farmer info is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                
                                <!-- Pagination links -->
                                <ul class="pagination">
                                    <li><a href="{{ $personalinfos->previousPageUrl() }}">Previous</a></li>
                                    @foreach ($personalinfos->getUrlRange(max(1, $personalinfos->currentPage() - 1), min($personalinfos->lastPage(), $personalinfos->currentPage() + 1)) as $page => $url)
                                    <li class="{{ $page == $personalinfos->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                    <li><a href="{{ $personalinfos->nextPageUrl() }}">Next</a></li>
                                </ul>

                            </div>
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
