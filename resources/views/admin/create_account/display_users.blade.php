@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')


<div class="page-content">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    
                    <h2> Accounts</h2>
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
                        <input type="radio" name="tabs" id="admin" checked="checked">
                        <label for="admin">Admin</label>
                        <div class="tab">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3 me-md-1">
                                    <h5 for="Seed" class="me-3">a. Admin</h5>
                                </div>
                                                        
                                <div class="me-md-1">
                                    <a href="{{ route('admin.create_account.new_accounts') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
{{--                             
                                <form id="farmProfileSearchForm" action="{{ route('admin.create_account.display_users') }}" method="GET" class="me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                            
                                <form id="showAllForm" action="{{ route('admin.create_account.display_users') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            
                            
                               <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light" >
                                        <tr>
                                            <th>#</th>
                                            <th>FullName</th>
                                            <th>Email</th>
                                            <th>Agri-district</th>
                                     
                                            <th>role</th>
                                            <th>Created</th>
                                          
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($users->count() > 0)
                                    @foreach($users->where('role','admin') as $user)
                                        <tr class="table-light">
                                           
                                             <td>{{ $user->id }}</td>
                                             <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                             <td>{{ $user->email }}</td>
                                             <td>{{ ucwords($user->district) }}</td>
                                       

                                            <td>{{ $user->role }}</td>
                                            
                                            <td>{{ $user->created_at}}</td>
                                            
                                            <td>
                                               
                                                 <a href="{{route('admin.create_account.edit_accounts', $user->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a> 
                                               
                                                
                                                 <form  action="{{ route('admin.create_account.delete', $user->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    {{-- {{ csrf_field()}} --}}@csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Admin Account is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $users->previousPageUrl() }}">Previous</a></li>
                                @foreach ($users->getUrlRange(1,$users->lastPage()) as $page => $url)
                                    <li class="{{ $page == $users->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $users->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>


                        {{-- labor --}}
                        <input type="radio" name="tabs" id="Agent" checked="checked">
                        <label for="Agent">Agent</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3">
                                    <h5>b. Agent</h5>
                                </div>
                                <div class="me-md-1">
                                    <a href="{{ route('admin.create_account.new_accounts') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                                {{-- <form id="farmProfileSearchForm" action="{{ route('admin.create_account.display_users') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.create_account.display_users') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>FullName</th>
                                            <th>Email</th>
                                            <th>Agri-district</th>
                                            
                                            <th>role</th>
                                            <th>Created</th>
                                            <th>Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($users->count() > 0)
                                    @foreach($users->where('role','agent') as $user)
                                        <tr class="table-light">
                                           
                                             <td>{{ $user->id }}</td>
                                             <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                             <td>{{ $user->email }}</td>
                                             <td>{{ ucwords($user->district) }}</td>
                                           
                                            <td>{{ $user->role }}</td>
                                            
                                            <td>{{ $user->created_at}}</td>
                                            <td>{{ $user->updated_at}}</td>
                                            <td>
                                               
                                                 <a href="{{route('admin.create_account.edit_accounts', $user->id)}}" title="Edit"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a> 
                                    
                                                 <form  action="{{ route('admin.create_account.delete', $user->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    {{-- {{ csrf_field()}} --}}@csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Agent Account is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $users->previousPageUrl() }}">Previous</a></li>
                                @foreach ($users->getUrlRange(1,$users->lastPage()) as $page => $url)
                                    <li class="{{ $page == $users->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $users->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>

                     

                        {{-- labor --}}
                        <input type="radio" name="tabs" id="labors" checked="checked">
                        <label for="labors">User</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3">
                                    <h5>c. Users</h5>
                                </div>
                                <div class="me-md-1">
                                    <a href="{{ route('admin.create_account.new_accounts') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                                {{-- <form id="farmProfileSearchForm" action="{{ route('admin.create_account.display_users') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                        <button class="btn btn-outline-success" type="submit">Search</button>
                                    </div>
                                </form>
                                <form id="showAllForm" action="{{ route('admin.create_account.display_users') }}" method="GET">
                                    <button class="btn btn-outline-success" type="submit">All</button>
                                </form> --}}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>FullName</th>
                                            <th>Email</th>
                                            <th>Agri-district</th>
                                            
                                            <th>role</th>
                                            <th>Created</th>
                                            <th>Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @if($users->count() > 0)
                                    @foreach($users->where('role','user') as $user)
                                        <tr class="table-light">
                                           
                                             <td>{{ $user->id }}</td>
                                             <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                             <td>{{ $user->email }}</td>
                                             <td>{{ ucwords($user->district) }}</td>
                                           
                                            <td>{{ $user->role }}</td>
                                            
                                            <td>{{ $user->created_at}}</td>
                                            <td>{{ $user->updated_at}}</td>
                                            <td>
                                               
                                                 <a href="{{route('admin.create_account.edit_accounts', $user->id)}}" title="Edit "><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a> 
                                    
                                                 <form  action="{{ route('admin.create_account.delete', $user->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                                                    {{-- {{ csrf_field()}} --}}@csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="5">Polygon Cost is empty</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                             <!-- Pagination links -->
                             <ul class="pagination">
                                <li><a href="{{ $users->previousPageUrl() }}">Previous</a></li>
                                @foreach ($users->getUrlRange(1,$users->lastPage()) as $page => $url)
                                    <li class="{{ $page == $users->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li><a href="{{ $users->nextPageUrl() }}">Next</a></li>
                            </ul>
                        </div>
                        <!-- Repeat the same structure for other tabs -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically loaded here -->
                <div id="editUserFormContainer">
                    Loading...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="farmerArchiveModal" tabindex="-1" aria-labelledby="farmerArchiveModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white" id="farmerArchiveModal">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-body" id="archives-modal-body">
                <form id="changePasswordForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="new_password" class="form-label">{{ $user->id }}</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordNew">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-danger" id="password_error" style="display: none;">Passwords do not match!</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePasswordBtn" data-id="{{ $user->id }}">Save changes</button>
            </div>
        </div>
    </div>
</div>


<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Add the script to toggle the password visibility -->
<script>
    // Toggle password visibility for 'New Password' and 'Confirm Password'
    document.getElementById('togglePasswordNew').addEventListener('click', function () {
        const passwordField = document.getElementById('new_password');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
        const passwordField = document.getElementById('confirm_password');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    // AJAX request for password change
    $('#savePasswordBtn').on('click', function () {
        const userId = $(this).data('id');
    const newPassword = $('#new_password').val(); // Get the new password value
    const confirmPassword = $('#confirm_password').val(); // Get the confirm password value
 

    // Log values for debugging
    console.log('User ID:', userId);
    console.log('New Password:', newPassword);
    console.log('Confirm Password:', confirmPassword);

    // Validate passwords
    if (newPassword !== confirmPassword) {
        $('#password_error').text('Passwords do not match!').show(); // Display error message
        return;
    }

    // Hide any previous error messages
    $('#password_error').hide();

    // Send AJAX request to update password
    $.ajax({
        url: '/updatePassword', // Laravel route for password update
        type: 'POST',
        data: {
            user_id: userId,
            new_password: newPassword,
            confirm_password: confirmPassword,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
        },
        success: function (response) {
            console.log('Server Response:', response);

            if (response.success) {
                alert('Password updated successfully!');
                $('#farmerArchiveModal').modal('hide'); // Close the modal
            } else {
                alert(response.message || 'Failed to update password.');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('AJAX error:', textStatus, errorThrown);
            alert('An error occurred while saving the password.');
        }
    });
});


$(document).on('click', '.edit-user-btn', function() {
    const userId = $(this).data('id');
    // const url = `{{ route('admin.create_account.edit_accounts', ':id') }}`.replace(':id', userId);

    // Make an AJAX call to fetch the data
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            // Populate the modal body with the fetched data
            $('#editUserFormContainer').html(response);
            // Show the modal
            $('#editUserModal').modal('show');
        },
        error: function() {
            alert('Failed to fetch user details.');
        }
    });
});

</script>


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
