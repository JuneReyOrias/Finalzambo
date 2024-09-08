<ul class="pagination">
    <li><a href="{{ $paginatedFarmers->previousPageUrl() }}" data-page="{{ $paginatedFarmers->currentPage() - 1 }}" class="pagination-link">Previous</a></li>
    @foreach ($paginatedFarmers->getUrlRange(max(1, $paginatedFarmers->currentPage() - 1), min($paginatedFarmers->lastPage(), $paginatedFarmers->currentPage() + 1)) as $page => $url)
        <li class="{{ $page == $paginatedFarmers->currentPage() ? 'active' : '' }}">
            <a href="{{ $url }}" data-page="{{ $page }}" class="pagination-link">{{ $page }}</a>
        </li>
    @endforeach
    <li><a href="{{ $paginatedFarmers->nextPageUrl() }}" data-page="{{ $paginatedFarmers->currentPage() + 1 }}" class="pagination-link">Next</a></li>
</ul>
