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
                                <div class="input-group mb-3">
                                    <h5> View Admin Account</h5>
                                </div>
                                <div class="me-md-1">
                                    <a href="{{ route('admin.create_account.new_accounts') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                                <form action="">
                                       
                                        
                                    <div class="input-group mb-3">
                                        {{-- <select id="date-interview-dropdown" class="form-select">
                                            <option value="">All Farmers</option>
                                            <option value="new">New (Last 6 months)</option>
                                            <option value="old">Old (More than 6 months)</option>
                                        </select> --}}
                                        <select class="form-select" id="admin-district-dropdown">
                                            <option value="">All Districts</option>
                                        </select>
                                        <input type="text"  class="form-control" id="admin-search-input" placeholder="Search">
                                    </div>
                                </form>
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
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="admin-info-list">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <!-- AJAX data will be inserted here -->
                                    </tbody>
                                </table>


                                <!-- Pagination links -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <ul id="admin-pagination-links" class="pagination mb-0">
                                        <!-- AJAX pagination links will be inserted here -->
                                    </ul>
                                </div>
                            </div>
                            
                        </div>

                        <input type="radio" name="tabs" id="agent" checked="checked">
                        <label for="agent">Agent</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3">
                                    <h5>View Agent/Field Officer </h5>
                                </div>
                                <div class="me-md-1">
                                    <a href="{{ route('admin.create_account.new_accounts') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                                <form action="">
                                       
                                        
                                    <div class="input-group mb-3">
                                        {{-- <select id="date-interview-dropdown" class="form-select">
                                            <option value="">All Farmers</option>
                                            <option value="new">New (Last 6 months)</option>
                                            <option value="old">Old (More than 6 months)</option>
                                        </select> --}}
                                        <select class="form-select" id="agent-district-dropdown">
                                            <option value="">All Districts</option>
                                        </select>
                                        <input type="text"  class="form-control" id="agent-search-input" placeholder="Search">
                                    </div>
                                </form>
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
                                    <tbody id="agent-info-list">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <!-- AJAX data will be inserted here -->
                                    </tbody>
                                </table>


                                <!-- Pagination links -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <ul id="agent-pagination-links" class="pagination mb-0">
                                        <!-- AJAX pagination links will be inserted here -->
                                    </ul>
                                </div>
                            </div>
                            
                        </div>

                       <input type="radio" name="tabs" id="labors" checked="checked">
                        <label for="labors">User</label>
                        <div class="tab">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3">
                                    <h5>Users/Farmer</h5>
                                </div>
                                <div class="me-md-1">
                                    <a href="{{ route('admin.create_account.new_accounts') }}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </div>
                                <form action="">
                                       
                                        
                                    <div class="input-group mb-3">
                                        {{-- <select id="date-interview-dropdown" class="form-select">
                                            <option value="">All Farmers</option>
                                            <option value="new">New (Last 6 months)</option>
                                            <option value="old">Old (More than 6 months)</option>
                                        </select> --}}
                                        <select class="form-select" id="district-dropdown">
                                            <option value="">All Districts</option>
                                        </select>
                                        <input type="text"  class="form-control" id="search-input" placeholder="Search">
                                    </div>
                                </form>
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
                                    <tbody id="personal-info-list">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <!-- AJAX data will be inserted here -->
                                    </tbody>
                                </table>


                                <!-- Pagination links -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <ul id="pagination-links" class="pagination mb-0">
                                        <!-- AJAX pagination links will be inserted here -->
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <!-- Repeat the same structure for other tabs -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>






<meta name="csrf-token" content="{{ csrf_token() }}">
<script>

$(document).ready(function () {
    let sortOrder = 'asc';
    let sortColumn = 'id';

    function getPageRange(currentPage) {
        const startPage = Math.floor((currentPage - 1) / 3) * 3 + 1;
        const endPage = startPage + 2;
        return { startPage, endPage };
    }

    function fetchFarmersData(filters = {}, page = 1) {
        filters.page = page;
        filters.sort_order = sortOrder;
        filters.sort_column = sortColumn;


      
            const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
    
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
        });
    };
        $.ajax({
            url: '/view-accounts',
            type: 'GET',
            data: filters,
            success: function (response) {
                $('#personal-info-list').html('');
                $('#agent-list').html('');
                $('#pagination-links').html('');

                // Populate personal information
                response.users.data
    .filter(info => info.role === 'user') // Filter by role
    .forEach(info => {
                    $('#personal-info-list').append(`
                        <tr class="new-row">
                            <td class="custom-cell">${info.id}</td>
                            <td class="custom-cell">${info.first_name} ${info.middle_name || ''} ${info.last_name} ${info.extension_name || ''}</td>
                         
                            <td class="custom-cell">${info.email || 'N/A'}</td>
                            <td class="custom-cell">${info.district || 'N/A'}</td>
                            <td class="custom-cell">${info.role || 'N/A'}</td>
                             <td class="custom-cell">${formatDate(info.created_at)}</td>
                            <td class="custom-cell">
                               
                                 <a href="/edit-accounts/${info.id}" title="Edit farmer">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    </a>
                                    <form action="/delete-accounts/${info.id}" method="post" style="display:inline">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </form>
                            </td>
                        </tr>
                    `);
                });



                // Populate districts dropdown
                function toProperCase(text) {
                    return text.replace(/\b\w/g, char => char.toUpperCase());
                }
                response.districts.forEach(district => {
    if (district.district) {
        // Ensure value is escaped to prevent issues with special characters
        let districtValue = escapeHtml(district.district);
        let districtText = toProperCase(district.district);

        // Check if the option already exists in the dropdown
        if (!$(`#district-dropdown option[value="${districtValue}"]`).length) {
            // Append the new option only if it doesn't exist
            $('#district-dropdown').append(`
                <option value="${districtValue}">${districtText}</option>
            `);
        } else {
            // Option already exists; update its text if necessary
            let option = $(`#district-dropdown option[value="${districtValue}"]`);
            if (option.text() !== districtText) {
                option.text(districtText);
            }
        }
    }
});

// Utility function to escape HTML special characters
function escapeHtml(str) {
    return str.replace(/[&<>"']/g, function (match) {
        const escape = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return escape[match];
    });
}



                // Update total rice production
                $('#total-rice-production').text(response.totalRiceProduction);

                // Generate pagination links
                if (response.users.links) {
                    const totalPages = response.users.last_page;
                    const { startPage, endPage } = getPageRange(page);

                    for (let i = startPage; i <= endPage && i <= totalPages; i++) {
                        const isActive = (i === page) ? 'active' : '';
                        $('#pagination-links').append(`
                            <li class="page-item ${isActive}">
                                <a href="#" class="page-link" data-page="${i}">${i}</a>
                            </li>
                        `);
                    }

                    $('#pagination-links').prepend(`
                        <li class="page-item ${page === 1 ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${page - 1}"><i class="fas fa-chevron-left"></i></a>
                        </li>
                    `);

                    $('#pagination-links').append(`
                        <li class="page-item ${page === totalPages ? 'disabled' : ''}">
                            <a href="#" class="page-link" data-page="${page + 1}"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    `);
                }
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Fetch data initially
    fetchFarmersData();

    // Handle filters change
    $('#district-dropdown, #search-input, #date-interview-dropdown').on('change keyup', function () {
        const filters = {
            district: $('#district-dropdown').val(),
            search: $('#search-input').val(),
            date_interview: $('#date-interview-dropdown').val()
        };
        fetchFarmersData(filters);
    });

    // Handle pagination link clicks
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            const filters = {
                district: $('#district-dropdown').val(),
                search: $('#search-input').val()
            };
            fetchFarmersData(filters, page);
        }
    });

    // Handle column sorting
    $('#sortable-table th').on('click', function () {
        const column = $(this).data('column');
        if (column) {
            sortColumn = column;
            sortOrder = (sortOrder === 'asc') ? 'desc' : 'asc';
            const filters = {
                district: $('#district-dropdown').val(),
                search: $('#search-input').val()
            };
            fetchFarmersData(filters);
        }
    });
});



     </script>
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
{{-- Ajax pass of data in to the table of agent --}}
<script>

    $(document).ready(function () {
        let sortOrder = 'asc';
        let sortColumn = 'id';
    
        function getPageRange(currentPage) {
            const startPage = Math.floor((currentPage - 1) / 3) * 3 + 1;
            const endPage = startPage + 2;
            return { startPage, endPage };
        }
    
        function fetchFarmersData(filters = {}, page = 1) {
            filters.page = page;
            filters.sort_order = sortOrder;
            filters.sort_column = sortColumn;
            const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
    
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
        });
    };
    
            $.ajax({
                url: '/view-accounts',
                type: 'GET',
                data: filters,
                success: function (response) {
                    $('#agent-info-list').html('');
                    $('#agent-list').html('');
                    $('#agent-pagination-links').html('');
                  
                    // Populate personal information
                    response.users.data
        .filter(info => info.role === 'agent') // Filter by role
        .forEach(info => {
                        $('#agent-info-list').append(`
                            <tr class="new-row">
                                <td class="custom-cell">${info.id}</td>
                                <td class="custom-cell">${info.first_name} ${info.middle_name || ''} ${info.last_name} ${info.extension_name || ''}</td>
                             
                                <td class="custom-cell">${info.email || 'N/A'}</td>
                                <td class="custom-cell">${info.district || 'N/A'}</td>

                                <td class="custom-cell">${info.role || 'N/A'}</td>
                                 <td class="custom-cell">${formatDate(info.created_at)}</td>
                                <td class="custom-cell">
                                   
                                     
                                  <a href="/edit-accounts/${info.id}" title="Edit farmer">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    </a>
                                    <form action="/delete-accounts/${info.id}" method="post" style="display:inline">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                    });
    
    
                    // Populate districts dropdown
                    function toProperCase(text) {
                        return text.replace(/\b\w/g, char => char.toUpperCase());
                    }
                    response.districts.forEach(district => {
        if (district.district) {
            // Ensure value is escaped to prevent issues with special characters
            let districtValue = escapeHtml(district.district);
            let districtText = toProperCase(district.district);
    
            // Check if the option already exists in the dropdown
            if (!$(`#agent-district-dropdown option[value="${districtValue}"]`).length) {
                // Append the new option only if it doesn't exist
                $('#agent-district-dropdown').append(`
                    <option value="${districtValue}">${districtText}</option>
                `);
            } else {
                // Option already exists; update its text if necessary
                let option = $(`#agent-district-dropdown option[value="${districtValue}"]`);
                if (option.text() !== districtText) {
                    option.text(districtText);
                }
            }
        }
    });
    
    // Utility function to escape HTML special characters
    function escapeHtml(str) {
        return str.replace(/[&<>"']/g, function (match) {
            const escape = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return escape[match];
        });
    }
    
    
    
                    // Update total rice production
                    $('#total-rice-production').text(response.totalRiceProduction);
    
                    // Generate pagination links
                    if (response.users.links) {
                        const totalPages = response.users.last_page;
                        const { startPage, endPage } = getPageRange(page);
    
                        for (let i = startPage; i <= endPage && i <= totalPages; i++) {
                            const isActive = (i === page) ? 'active' : '';
                            $('#agent-pagination-links').append(`
                                <li class="page-item ${isActive}">
                                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                                </li>
                            `);
                        }
    
                        $('#agent-pagination-links').prepend(`
                            <li class="page-item ${page === 1 ? 'disabled' : ''}">
                                <a href="#" class="page-link" data-page="${page - 1}"><i class="fas fa-chevron-left"></i></a>
                            </li>
                        `);
    
                        $('#agent-pagination-links').append(`
                            <li class="page-item ${page === totalPages ? 'disabled' : ''}">
                                <a href="#" class="page-link" data-page="${page + 1}"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        `);
                    }
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    
        // Fetch data initially
        fetchFarmersData();
    
        // Handle filters change
        $('#agent-district-dropdown, #agent-search-input, #date-interview-dropdown').on('change keyup', function () {
            const filters = {
                district: $('#agent-district-dropdown').val(),
                search: $('#agent-search-input').val(),
                date_interview: $('#date-interview-dropdown').val()
            };
            fetchFarmersData(filters);
        });
    
        // Handle pagination link clicks
        $(document).on('click', '.page-link', function (e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page) {
                const filters = {
                    district: $('#district-dropdown').val(),
                    search: $('#search-input').val()
                };
                fetchFarmersData(filters, page);
            }
        });
    
        // Handle column sorting
        $('#sortable-table th').on('click', function () {
            const column = $(this).data('column');
            if (column) {
                sortColumn = column;
                sortOrder = (sortOrder === 'asc') ? 'desc' : 'asc';
                const filters = {
                    district: $('#district-dropdown').val(),
                    search: $('#search-input').val()
                };
                fetchFarmersData(filters);
            }
        });
    });
    
    
    
         </script>
{{-- ajax passing of data into the admin table --}}
<script>

    $(document).ready(function () {
        let sortOrder = 'asc';
        let sortColumn = 'id';
    
        function getPageRange(currentPage) {
            const startPage = Math.floor((currentPage - 1) / 3) * 3 + 1;
            const endPage = startPage + 2;
            return { startPage, endPage };
        }
        const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
    
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
        });
    };
    
    // Example usage
    
        function fetchFarmersData(filters = {}, page = 1) {
            filters.page = page;
            filters.sort_order = sortOrder;
            filters.sort_column = sortColumn;
    
            $.ajax({
                url: '/view-accounts',
                type: 'GET',
                data: filters,
                success: function (response) {
                    $('#admin-info-list').html('');
                    $('#agent-list').html('');
                    $('#admin-pagination-links').html('');
                   
             
                    // Populate personal information
                    response.users.data
        .filter(info => info.role === 'admin') // Filter by role
        .forEach(info => {
                        $('#admin-info-list').append(`
                            <tr class="new-row">
                                <td class="custom-cell">${info.id}</td>
                                <td class="custom-cell">${info.first_name} ${info.middle_name || ''} ${info.last_name} ${info.extension_name || ''}</td>
                             
                                <td class="custom-cell">${info.email || 'N/A'}</td>
                                <td class="custom-cell">${info.district || 'N/A'}</td>
                                <td class="custom-cell">${info.role || 'N/A'}</td>
                                         <td class="custom-cell">${formatDate(info.created_at)}</td>
                                                    
                                <td class="custom-cell">
                                   
                                    <a href="/edit-accounts/${info.id}" title="Edit farmer">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    </a>
                                    <form action="/delete-accounts/${info.id}" method="post" style="display:inline">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                    });
    
    
             
                    // Populate districts dropdown
                    function toProperCase(text) {
                        return text.replace(/\b\w/g, char => char.toUpperCase());
                    }
                    response.districts.forEach(district => {
        if (district.district) {
            // Ensure value is escaped to prevent issues with special characters
            let districtValue = escapeHtml(district.district);
            let districtText = toProperCase(district.district);
    
            // Check if the option already exists in the dropdown
            if (!$(`#admin-district-dropdown option[value="${districtValue}"]`).length) {
                // Append the new option only if it doesn't exist
                $('#admin-district-dropdown ').append(`
                    <option value="${districtValue}">${districtText}</option>
                `);
            } else {
                // Option already exists; update its text if necessary
                let option = $(`#admin-district-dropdown  option[value="${districtValue}"]`);
                if (option.text() !== districtText) {
                    option.text(districtText);
                }
            }
        }
    });
    
    // Utility function to escape HTML special characters
    function escapeHtml(str) {
        return str.replace(/[&<>"']/g, function (match) {
            const escape = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return escape[match];
        });
    }
    
    
    
                    // Update total rice production
                    $('#total-rice-production').text(response.totalRiceProduction);
    
                    // Generate pagination links
                    if (response.users.links) {
                        const totalPages = response.users.last_page;
                        const { startPage, endPage } = getPageRange(page);
    
                        for (let i = startPage; i <= endPage && i <= totalPages; i++) {
                            const isActive = (i === page) ? 'active' : '';
                            $('#admin-pagination-links').append(`
                                <li class="page-item ${isActive}">
                                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                                </li>
                            `);
                        }
    
                        $('#admin-pagination-links').prepend(`
                            <li class="page-item ${page === 1 ? 'disabled' : ''}">
                                <a href="#" class="page-link" data-page="${page - 1}"><i class="fas fa-chevron-left"></i></a>
                            </li>
                        `);
    
                        $('#admin-pagination-links').append(`
                            <li class="page-item ${page === totalPages ? 'disabled' : ''}">
                                <a href="#" class="page-link" data-page="${page + 1}"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        `);
                    }
    
    
                    
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    
        // Fetch data initially
        fetchFarmersData();
    
        // Handle filters change
        $('#admin-district-dropdown , #admin-search-input, #date-interview-dropdown').on('change keyup', function () {
            const filters = {
                district: $('#admin-district-dropdown ').val(),
                search: $('#admin-search-input').val(),
                date_interview: $('#date-interview-dropdown').val()
            };
            fetchFarmersData(filters);
        });
    
        // Handle pagination link clicks
        $(document).on('click', '.page-link', function (e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page) {
                const filters = {
                    district: $('#district-dropdown').val(),
                    search: $('#search-input').val()
                };
                fetchFarmersData(filters, page);
            }
        });
    
        // Handle column sorting
        $('#sortable-table th').on('click', function () {
            const column = $(this).data('column');
            if (column) {
                sortColumn = column;
                sortOrder = (sortOrder === 'asc') ? 'desc' : 'asc';
                const filters = {
                    district: $('#district-dropdown').val(),
                    search: $('#search-input').val()
                };
                fetchFarmersData(filters);
            }
        });
    });
    
    
    
         </script>
  

@endsection
