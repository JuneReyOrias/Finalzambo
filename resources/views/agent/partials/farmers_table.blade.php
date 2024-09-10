<!-- partials/farmers_table.blade.php -->
<table class="table table-bordered datatable" style="font-size: 0.875rem;">
    <thead>
        <tr>
            <th>District</th>
            <th>Full Name</th>
            <th>Organization</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($paginatedFarmers as $farmer)
            <tr class="table-light">
                <td>{{ $farmer['district'] }}</td>
                <td>{{ $farmer['first_name'].' '.$farmer['last_name'] }}</td>
                <td>{{ $farmer['organization'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- <!-- Pagination Controls -->
<div class="mt-3 pagination-container d-flex justify-content-center">
    <ul class="pagination">
        <li><a href="{{ $paginatedFarmers->previousPageUrl() }}">Previous</a></li>
        @foreach ($paginatedFarmers->getUrlRange(1,$paginatedFarmers->lastPage()) as $page => $url)
            <li class="{{ $page == $paginatedFarmers->currentPage() ? 'active' : '' }}">
                <a href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach
        <li><a href="{{ $paginatedFarmers->nextPageUrl() }}">Next</a></li>
    </ul>
</div> --}}