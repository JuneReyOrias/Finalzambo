@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')


<div class="page-content">
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    
                    <h2>Farmer Org/Coop/Assoc</h2>
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
                        <label for="Seed">Farmer Org/Coop/Assoc</label>
                        <div class="tab">
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <div class="input-group mb-3 me-md-1">
                                    <h5 for="Seed" class="me-3">a. Add Farmer Org/Coop/Assoc</h5>
                                </div>
                            
                                <div class="me-md-1">
                                    <a href="{{ route('admin.farmerOrg.add_form') }}" title="Add" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true">Add</i></a>
                                </div>
                            
                                <form id="farmProfileSearchForm" action="" method="GET" class="me-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search" id="searchInput">
                                      
                                    </div>
                                </form>
                            
                               
                            </div>
                            
                           
                      
                            
                               <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <!-- Table content here -->
                                    <thead class="thead-light" >
                                        <tr>
                                            <th>#</th>
                                            <th>agri-district</th>
                                            <th>Farmer Org/Coop/Assoc Name</th>
                                     
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                      <tbody id="FarmerOrg-info-list">
                                            <!-- AJAX data will be inserted here -->
                                        </tbody>
                                </table>
                            </div>
                             <div class="d-flex justify-content-between align-items-center mt-3">
                <ul id="pagination-links" class="pagination mb-0">
                    <!-- AJAX pagination links -->
                </ul>
            </div>
                        </div>


                        <!-- Repeat the same structure for other tabs -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for fetching organization data with live search --}}
<script>
$(document).ready(function () {
    let sortOrder = 'asc';
    let sortColumn = 'id';
    let  FarmerOrgPage = 1;

    function getPageRange(currentPage) {
        const startPage = Math.floor((currentPage - 1) / 3) * 3 + 1;
        const endPage = startPage + 2;
        return { startPage, endPage };
    }

    function fetchBarangayData() {
        const filters = {
            FarmerOrg_search: $('#searchInput').val(),
            sort_order: sortOrder,
            sort_column: sortColumn,
            FarmerOrg_page: FarmerOrgPage
        };

        $.ajax({
            url: '/admin-view-farmer-org',
            type: 'GET',
            data: filters,
            success: function (response) {
                $('#FarmerOrg-info-list').empty();
                $('#pagination-links').empty();

                function toTitleCase(str) {
                        return str.toLowerCase().split(' ').map(word => 
                            word.charAt(0).toUpperCase() + word.slice(1)
                        ).join(' ');
                    }
                response.FarmerOrg.data.forEach(info => {
                    $('#FarmerOrg-info-list').append(`
                        <tr>
                            <td>${info.id}</td>
                             <td>${info.district ? toTitleCase(info.district) : 'N/A'}</td>
                              <td>${info.organization_name ? toTitleCase(info.organization_name) : 'N/A'}</td>
                            <td>
                                <a href="/admin-edit-farmer-org/${info.id}">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></button>
                                </a>
                                <form action="/admin-delete-farmer-org/${info.id}" method="post" style="display:inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `);
                });

                createPagination('#pagination-links', response.FarmerOrg.current_page, response.FarmerOrg.last_page, 'data-barangay-page');
            }
        });
    }

    function createPagination(container, current, last, attr) {
        const { startPage, endPage } = getPageRange(current);
        const $container = $(container).empty();

        $container.append(`<li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a href="#" class="page-link" ${attr}="${current - 1}">&laquo;</a>
        </li>`);

        for (let i = startPage; i <= endPage && i <= last; i++) {
            const active = (i === current) ? 'active' : '';
            $container.append(`<li class="page-item ${active}">
                <a href="#" class="page-link" ${attr}="${i}">${i}</a>
            </li>`);
        }

        $container.append(`<li class="page-item ${current === last ? 'disabled' : ''}">
            <a href="#" class="page-link" ${attr}="${current + 1}">&raquo;</a>
        </li>`);
    }

    // Pagination click handler
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        const $link = $(this);
        if ($link.attr('data-barangay-page')) {
            barangayPage = parseInt($link.attr('data-barangay-page'));
            fetchBarangayData();
        }
    });

    // Live search while typing with debounce
    let searchTimer;
    $('#searchInput').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            barangayPage = 1;
            fetchBarangayData();
        }, 500); // 500ms delay
    });

    // Show all button click handler
    $('#showAllForm').on('submit', function (e) {
        e.preventDefault();
        $('#searchInput').val('');
        barangayPage = 1;
        fetchBarangayData();
    });

    // Initial load
    fetchBarangayData();
});
</script>

@endsection

