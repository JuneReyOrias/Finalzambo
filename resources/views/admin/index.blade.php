@extends('admin.dashb')

@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')
<style>

    /* General styling for the card */
.card {
    overflow: hidden;
}

.chart-container {
    height: 150px;
    width: 48%;
    min-width: 100px; /* Set a minimum width to prevent very small shrinking */
    margin-bottom: 15px; /* Add some spacing for mobile views */
}

/* Responsive for small devices (320px to 575px) */
@media (min-width: 320px) and (max-width: 575px) {
    .chart-container {
        width: 100%; /* Full width on small screens */
        height: 200px; /* Increase height for better visibility */
    }

    .d-flex.justify-content-between {
        flex-direction: column; /* Stack charts on top of each other */
    }

    /* Adjust title font size for better readability */
    .card-title {
        font-size: 16px; /* Slightly smaller font for small screens */
    }
}

/* Responsive for medium devices (576px to 767px) */
@media (min-width: 576px) and (max-width: 767px) {
    .chart-container {
        width: 100%; /* Full width for small devices */
        height: 180px; /* Adjust height */
    }
}

/* Responsive for tablets (768px to 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .chart-container {
        width: 48%; /* Side-by-side layout for tablets */
        height: 180px; /* Slightly increase height */
    }
}

/* Responsive for large devices (992px and above) */
@media (min-width: 992px) {
    .chart-container {
        width: 48%; /* Charts side by side */
        height: 150px; /* Keep height at a balanced size */
    }
}


/* piechart */
/* General styling for the bar chart */
#barChart {
    height: 400px;
    width: 100%;
    min-width: 100px;
}

/* Responsive for small devices (320px to 575px) */
@media (min-width: 320px) and (max-width: 575px) {
    #barChart {
        height: 300px; /* Adjust height for small screens */
        width: 100%; /* Full width on small devices */
    }

    .card-title {
        font-size: 16px; /* Smaller font size for the card title */
    }
}

/* Responsive for small to medium devices (576px to 767px) */
@media (min-width: 576px) and (max-width: 767px) {
    #barChart {
        height: 350px; /* Slightly increase height */
        width: 100%; /* Full width */
    }
}

/* Responsive for tablets (768px to 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    #barChart {
        height: 380px; /* Further adjust height for tablet screens */
        width: 100%; /* Full width for charts */
    }
}

/* Responsive for large devices (992px and above) */
@media (min-width: 992px) {
    #barChart {
        height: 400px; /* Full height for larger screens */
        width: 100%; /* Full width */
    }
}

/* responsivenesss */
.custom-card {
            height: 100px;
            /* Adjust height as needed */
            width: 80px;
            /* Adjust width as needed */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .custom-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            /* Adjust padding as needed */
            border: 1px solid transparent;
            /* Initial transparent border */
            border-image: linear-gradient(to right, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1));
            /* Gradient for border */
        }
        
        .custom-card h4 {
            margin-top: 20px;
            /* Adjust margin as needed */
        }
        
        .custom-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .small-title h6 {
            font-size: 0.75rem;
            /* Adjust font size as needed */
            color: #6c757d;
            /* Optional: Change color for better visibility */
        }
        
        .custom-width {
            width: 100px;
            /* Set the desired width */
        }
        
        .bg {
            background: #00aa00;
        }
        
        .backg {
            background: #55007f;
        }
        
        .bgma {
            background: #ff5500;
        }
        
        .flatpickr-clear-button {
            margin: 10px;
            padding: 5px 10px;
            border: none;
            background-color: #ff6f61;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .flatpickr-clear-button:hover {
            background-color: #e55b50;
        }
        /* General form and button styles */
        
        form {
            display: flex;
            flex-wrap: wrap;
        }
        
        form .form-control,
        form .btn {
            min-width: 150px;
            margin-bottom: 10px;
        }
        
        form select,
        form input,
        form button {
            width: 100%;
        }
        /* Small devices (320px to 575px) - Center the form */
        
        @media (min-width: 320px) and (max-width: 575px) {
            form {
                justify-content: center;
                /* Center the form elements */
            }
            form .form-control,
            form .btn {
                width: 100%;
                /* Full width on small devices */
                max-width: 300px;
                /* Limit max width to prevent over-stretching */
            }
        }
        /* Medium devices (576px to 767px) */
        
        @media (min-width: 576px) and (max-width: 767px) {
            form {
                justify-content: center;
                /* Center the form elements */
            }
            form .form-control,
            form .btn {
                width: 100%;
                /* Full width for better alignment */
            }
        }
        /* Large devices (768px to 991px) */
        
        @media (min-width: 768px) and (max-width: 991px) {
            form {
                justify-content: center;
                /* Center the form elements */
            }
            form .form-control,
            form .btn {
                width: auto;
                /* Use auto width to prevent stretching */
            }
        }
        /* Extra large devices (992px to 1199px) */
        
        @media (min-width: 992px) and (max-width: 1199px) {
            form {
                justify-content: center;
                /* Center the form elements */
            }
            form .form-control,
            form .btn {
                width: 150px;
                /* Maintain a fixed width for alignment */
            }
        }
        /* Extra extra large devices (1200px and above) */
        
        @media (min-width: 1200px) {
            form {
                justify-content: center;
                /* Center the form elements */
            }
            form .form-control,
            form .btn {
                width: 150px;
                /* Consistent width across large screens */
            }
        }
        /* Custom styling for the print and reset buttons */
        
        form button i {
            margin-right: 5px;
            /* Add space between icon and text */
        }
        /* Margin and padding adjustments */
        
        .d-flex.justify-content-between {
            gap: 15px;
            /* Adds spacing between elements */
        }   
        
        .apexcharts-legend {
            inset: auto 0px -5px;
    bottom: 12px;
    position: absolute;
    max-height: 192.917px;

        }    
  
        .pagination .page-item .page-link {
    border-radius: 50%; /* Make pagination numbers circular */
    margin: 0 5px;
    padding: 8px 12px;
    color: #007bff;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    color: white;
    border: none;
}

.pagination .page-item.disabled .page-link {
    color: #ced4da;
}

.pagination .page-link:hover {
    background-color: #f8f9fa;
}

  
</style>

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center grid-margin flex-wrap">
        <!-- Title -->
        <div>
            <h4 class="mb-3 mb-md-0" style="font-size: 19px;">Zambo-AgriMap Dashboard</h4>
        </div>
    </div>
    
    <div class="d-flex justify-content-between align-items-center grid-margin">
        <!-- Filter Form and Buttons -->
        <div class="d-flex align-items-center flex-wrap w-100">
            <form id="filterForm" method="GET" action="/admin/dashboard"  class="d-flex align-items-center flex-wrap w-100">
                <!-- Crop Dropdown -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <select name="crop_name" id="crop_name" class="form-control w-100">
                        <option value="">All Crops</option>
                        @php
                        function formatCropName($name) {
                            // Convert to lowercase and replace underscores with spaces
                            $formattedName = strtolower($name);
                            $formattedName = str_replace('_', ' ', $formattedName);
                    
                            // Capitalize the first letter of each word
                            return ucwords($formattedName);
                        }
                    @endphp
                    
                    @foreach ($crops as $crop)
                        <option value="{{ $crop }}" {{ $crop == $selectedCropName ? 'selected' : '' }}>
                            {{ formatCropName($crop) }}
                        </option>
                    @endforeach
                    
                    
                    </select>
                </div>
    
                <!-- District Dropdown -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <select name="district" id="district" class="form-control w-100">
                        <option value="">All Districts</option>
                        @php
                        function formatdistrict($district) {
                            // Convert to lowercase and replace underscores with spaces
                            $formattedName = strtolower($district);
                            $formattedName = str_replace('_', ' ', $formattedName);
                    
                            // Capitalize the first letter of each word
                            return ucwords($formattedName);
                        }
                        @endphp
                     @foreach ($districts as $district)
                     
                       
                   

                        <option value="{{ $district }}" {{ $district == $selectedDistrict ? 'selected' : '' }}>
                            {{ formatdistrict($district) }}
                        </option>
                    @endforeach
                    
                    </select>
                </div>
    
                <!-- Date Range From -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <input type="text" class="form-control w-100 @error('dateFrom') is-invalid @enderror" name="dateFrom" value="{{ $selectedDateFrom }}" placeholder="Harvest Date From" id="datepickerFrom">
                </div>
    
                <!-- Date Range To -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <input type="text" class="form-control w-100 @error('dateTo') is-invalid @enderror" name="dateTo" value="{{ $selectedDateTo }}" placeholder="Harvest Date To" id="datepickerTo">
                </div>
    
                <!-- Filter Button -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <button type="submit" class="btn btn-primary btn-icon-text w-100 hide-on-print">Filter</button>
                </div>
    
                <!-- Reset Filters Button -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <button type="button" class="btn btn-secondary btn-icon-text w-100 hide-on-print" onclick="resetFilters()" title="Reset Filters">
                        <i class="btn-icon-prepend" data-feather="refresh-cw"></i>
                    </button>
                </div>
    
                <!-- Print Button -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <button type="button" class="btn btn-primary btn-icon-text w-100 hide-on-print" onclick="printReport()">
                        <i class="btn-icon-prepend" data-feather="printer"></i>
                        Print
                    </button>
                </div>
            </form>
        </div>
    </div>
    

    
    
    
    
      
      

  <div class="row g-2">

<!-- HTML for Cards and Modal -->
<div class="col-md-2 stretch-card" onclick="openModal('{{ $selectedCropName }}')">
    <div class="card custom-card bg text-white mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="text-center">
                    <h5 class="mb-2 text-white">{{ number_format($totalFarms) }}</h5>
                </div>
                <div class="small-title mt-2 text-center">
                    <h6 class="mb-0 text-white">Total Number</h6>
                    <h6 class="mb-0 text-white">of Farmers</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Structure -->

<div class="modal fade" id="farmerDataModal" tabindex="-1" aria-labelledby="farmerDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="farmerDataModalLabel">Farmers Data and Analytics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="farmerDataAccordion">

                    <!-- Farmers Analytics Table Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFarmersAnalytics" style=" linear-gradient(to right, #e0f7fa, #b2ebf2);">
                                    <div class="card-body">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFarmersAnalytics" aria-expanded="true" aria-controls="collapseFarmersAnalytics">
                                <i class="fas fa-table"></i> Farmers Distribution
                            </button>
                        </h2>
                        <div id="collapseFarmersAnalytics" class="accordion-collapse collapse" aria-labelledby="headingFarmersAnalytics" data-bs-parent="#farmerDataAccordion">
                            <div class="accordion-body">
                                <div class="card border-0 rounded-3 shadow-sm" style="background: linear-gradient(to right, #e0f7fa, #b2ebf2);">
                                    <div class="card-body" style="height: 300px; overflow-y: auto;">
                                        <h5 class="mb-3" style="font-size: 1.15rem;">Analytics for {{ $totalFarms }}</h5>
                                        <table class="table table-hover" style="font-size: 0.875rem;">
                                            <thead>
                                                <tr>
                                                    <th>District</th>
                                                    <th class="text-end">Number of Farmers</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($distributionFrequency as $districtId => $frequency)
                                                    <tr>
                                                        <td>{{ $districts[$districtId] ?? 'Unknown' }}</td>
                                                        <td class="text-end">{{ number_format($frequency) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer bg-light text-center" style="font-size: 1rem;">
                                        <span class="text-muted">Farmers Distribution</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Farmers Information Section -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDetailedInfo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetailedInfo" aria-expanded="true" aria-controls="collapseDetailedInfo">
                                <i class="fas fa-info-circle"></i> Detailed Farmers Information
                            </button>
                        </h2>
                        <div id="collapseDetailedInfo" class="accordion-collapse collapse" aria-labelledby="headingDetailedInfo" data-bs-parent="#farmerDataAccordion">
                            <div class="accordion-body">
                                <div class="card border-0 rounded-3 shadow-sm" style="background: linear-gradient(to right, #b7b9b9, #eff5f6);">
                                    <div class="card-body" style="height: 300px; overflow-y: auto;">
                                        <h5 class="mb-3" style="font-size: 1.15rem;">Detailed Farmers Information</h5>
                                        <div id="farmersTable">
                                            @include('admin.partials.farmers_table', ['paginatedFarmers' => $paginatedFarmers])
                                        </div>
                                    </div>
                                    <div id="pagination" class="mt-3 text-center">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $paginatedFarmers->previousPageUrl() }}">Previous</a>
                                            </li>
                                            @foreach ($paginatedFarmers->getUrlRange(max(1, $paginatedFarmers->currentPage() - 1), min($paginatedFarmers->lastPage(), $paginatedFarmers->currentPage() + 1)) as $page => $url)
                                                <li class="page-item {{ $page == $paginatedFarmers->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $paginatedFarmers->nextPageUrl() }}">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- Pie Chart Section -->
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPieChart">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePieChart" aria-expanded="true" aria-controls="collapsePieChart">
                                <i class="fas fa-chart-pie"></i> Pie Chart
                            </button>
                        </h2>
                        <div id="collapsePieChart" class="accordion-collapse collapse" aria-labelledby="headingPieChart" data-bs-parent="#farmerDataAccordion">
                            <div class="accordion-body">
                                <div class="row justify-content-center mb-4">
                                    <div class="col-12">
                                        <div class="card border-0 rounded-3 shadow-sm" style="background: linear-gradient(to right, #f8cdda, #f4a2c1);">
                                            <div class="card-body p-0" style="height: 400px; width: 100%;">
                                                <div id="pieChartContainer" style="height: 100%; width: 100%;"></div>
                                            </div>
                                            <div class="card-footer bg-light text-center" style="font-size: 0.8rem;">
                                                <span class="text-muted">Pie Chart</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







    

    <div class="col-md-2 stretch-card">
        <div class="card custom-card backg text-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="text-center">
                        <h5 class="mb-2 text-white">{{ number_format($totalAreaPlanted, 2) }}</h5>
                    </div>
                    <div class="small-title mt-2 text-center">
                        <h6 class="mb-0 text-white">Total Area</h6>
                        <h6 class="mb-0 text-white">Planted</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 stretch-card">
        <div class="card custom-card bg-warning text-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="text-center">
                        <h5 class="mb-2 text-white">{{ number_format($totalAreaYield, 2) }}</h5>
                    </div>
                    <div class="small-title mt-2 text-center">
                        <h6 class="mb-0 text-white">Total Area</h6>
                        <h6 class="mb-0 text-white">Yield (Kg/Ha)</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 stretch-card">
        <div class="card custom-card bg-danger text-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="text-center">
                        <h5 class="mb-2 text-white"><p style="font-size: 12px">Php</p>{{ number_format($totalCost, 2) }}</h5>
                    </div>
                    <div class="small-title mt-2 text-center">
                        <h6 class="mb-0 text-white">Total Cost</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 stretch-card">
        <div class="card custom-card bgma text-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="text-center">
                        <h5 class="mb-2 text-white">{{ number_format($yieldPerAreaPlanted, 2) }}</h5>
                    </div>
                    <div class="small-title mt-2 text-center">
                        <h6 class="mb-0 text-white">Ave. Yield/Area</h6>
                        <h6 class="mb-0 text-white">Planted (Kg/Ha)</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 stretch-card">
        <div class="card custom-card bg-secondary text-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="text-center">
                        <h5 class="mb-2 text-white"><p style="font-size: 12px">Php</p>{{ number_format($averageCostPerAreaPlanted ,2) }}</h5>
                    </div>
                    <div class="small-title mt-2 text-center">
                        <h6 class="mb-0 text-white">Ave. Cost/</h6>
                        <h6 class="mb-0 text-white">Area Planted</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
  <!-- Left Side: Rice Production and Farmers Yields/Districts -->
<div class="col-lg-6 col-xl-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <!-- Card Title and Dropdown Filters -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0">Farmers Yields/Districts</h6>
                <!-- Dropdown Filters -->
                <div>
                    <!-- Add your dropdown filters here -->
                </div>
            </div>

            <!-- Pie Chart and Storage Chart Containers -->
            <div class="d-flex justify-content-between flex-wrap">
                <!-- Pie Chart Container -->
                <div id="pieChart" class="chart-container"></div>

                <!-- Storage Chart Container -->
                <div id="storageChart" class="chart-container"></div>
            </div>
        </div>
    </div>
</div>

    

    <!-- Right Side: Farmers Variety Planted/Districts -->
    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Farmers Variety Planted/Districts</h6>
                </div>
    
                    <!-- Bar Chart Container -->
                    <div id="barChart" style="height: 400px;"></div>
                    
            </div>
        </div>
    </div>
    
</div>






      </div>
    </div>
  </div> <!-- row -->

  <script>
    function openModal(cropName) {
        // Set up dynamic content if needed
        // Example: Use AJAX to load additional details for the selected crop
        $('#farmerDataModal').modal('show');
    }
</script>


  {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var pieChartData = @json($pieChartData);
        var barChartData = @json($barChartData);

        // Pie Chart
        var pieOptions = {
            chart: {
                type: 'pie',
                height: 400
            },
            series: pieChartData.series,
            labels: pieChartData.labels,
            colors: ['#FF4560', '#00E396', '#008FFB', '#FF9F00', '#FEB019'],
            title: {
                text: 'Yield per District'
            }
        };
        var pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);
        pieChart.render();

        // Bar Chart
        var barOptions = {
            chart: {
                type: 'bar',
                height: 400
            },
            series: barChartData,
            xaxis: {
                categories: ['Inbred', 'Hybrid', 'Not specified'],
                title: {
                    text: 'Type of Variety Planted'
                }
            },
            yaxis: {
                title: {
                    text: 'Count'
                }
            },
            title: {
                text: 'Type of Variety per District'
            }
        };
        var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
        barChart.render();
    });
</script> --}}

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Parse JSON data from the backend
        var pieChartDatas = @json($pieChartDatas);
        var pieChartData = @json($pieChartData);
        var barChartData = @json($barChartData);
        var totalYieldProduction = @json($totalRiceProduction); // Fetch total yield production data
        var riceProductionValue = {{ number_format($totalRiceProduction, 2) }};
        var selectedCropName = "{{ $selectedCropName }}"; // Get selected crop name

        // Radial Bar Chart for Rice Production
        if (document.querySelector('#storageChart')) {
            var storageChartOptions = {
                chart: {
                    height: 260,
                    type: "radialBar"
                },
                series: [riceProductionValue],
                colors: ['#00E396'], // Replace with actual color or use colors.success
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 15,
                            size: "70%"
                        },
                        track: {
                            show: true,
                            background: '#E0E0E0', // Replace with actual color or use colors.light
                            strokeWidth: '100%',
                            opacity: 1,
                            margin: 5
                        },
                        dataLabels: {
                            showOn: "always",
                            name: {
                                offsetY: -11,
                                show: true,
                                color: '#00E396', // Replace with actual color or use colors.success
                                fontSize: "13px"
                            },
                            value: {
                                color: '#00E396', // Replace with actual color or use colors.success
                                fontSize: "30px",
                                show: true
                            }
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                stroke: {
                    lineCap: "round"
                },
                labels: [`${selectedCropName || "Production"} Production`], // Concatenate selected crop name with "Production"
                title: {
                    text: `${selectedCropName || "Crop"} Production`, // Dynamic title with selected crop name
                    align: 'center',
                    margin: 10,
                    offsetY: 0,
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold',
                        color: '#263238'
                    }
                }
            };
            
            var storageChart = new ApexCharts(document.querySelector("#storageChart"), storageChartOptions);
            storageChart.render();
        }

        // Pie Chart for Yield per District
        if (document.querySelector('#pieChart')) {
            var pieOptions = {
                chart: {
                    type: 'pie',
                    height: 400
                },
                series: pieChartData.series,
                labels: pieChartData.labels,
                colors: ['#00E396', '#FF4560', '#008FFB', '#FF9F00', '#FEB019'],
                title: {
                    text: 'Yield per District'
                }
            };
            var pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);
            pieChart.render();
        }

        // Bar Chart for Type of Variety per District
        if (document.querySelector('#barChart')) {
            var barOptions = {
                chart: {
                    type: 'bar',
                    height: 400
                },
                series: barChartData,
                xaxis: {
                    categories: ['Inbred', 'Hybrid', 'Not specified'],
                    title: {
                        text: 'Type of Variety Planted'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Count'
                    }
                },
                title: {
                    text: 'Type of Variety per District'
                }
            };
            var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
            barChart.render();
        }

        // Pie Chart for Yield Production per Crop
        if (document.querySelector('#yieldPieChart')) {
            var yieldPieOptions = {
                chart: {
                    type: 'pie',
                    height: 400
                },
                series: pieChartDatas.series,
                labels: pieChartDatas.labels,
                colors: ['#00E396', '#FF4560', '#008FFB', '#FF9F00', '#FEB019'],
                title: {
                    text: 'Yield Production per Crop'
                }
            };
            var yieldPieChart = new ApexCharts(document.querySelector("#yieldPieChart"), yieldPieOptions);
            yieldPieChart.render();
        }
    });
</script> --}}
<!-- Blade Template with JavaScript -->

<script>
    function resetFilters() {
        window.location.href = '{{ route("admin.dashb") }}'; // Redirect to the dashboard route with no filters applied
    }
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Parse JSON data from the backend
    var pieChartData = @json($pieChartData);
    var barChartData = @json($barChartData);
    var totalRiceProduction = @json($totalRiceProduction); // Fetch total yield production data
    var riceProductionValue = {{ number_format($totalRiceProduction, 2) }};
    var selectedCropName = @json($selectedCropName); // Get selected crop name
    var pieChartDatas = @json($pieChartDatas);
    var minDate = "{{ $minDate }}";
    var maxDate = "{{ $maxDate }}";

    // Define a color palette for consistency
    var colorPalette = ['#ff0000', '#55007f', '#ffff00', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'];

  // Function to format crop names
function formatCropName(name) {
    // Convert to lowercase and replace underscores with spaces
    var formattedName = name.toLowerCase().replace(/_/g, ' ');

    // Capitalize the first letter of each word
    return formattedName.replace(/\b\w/g, function(char) { return char.toUpperCase(); });
}

// Radial Bar Chart for Rice Production
if (document.querySelector('#storageChart')) {
    var selectedCropName = @json($selectedCropName); // Pass the selected crop name from Blade

    // Format the selected crop name
    var formattedCropName = formatCropName(selectedCropName);

    var storageChartOptions = {
        chart: {
            height: 260,
            type: "radialBar"
        },
        series: [riceProductionValue],
        colors: ['#00E396'],
        plotOptions: {
            radialBar: {
                hollow: {
                    margin: 15,
                    size: "70%"
                },
                track: {
                    background: '#f2f2f2',
                    strokeWidth: '100%'
                },
                dataLabels: {
                    show: true,
                    name: {
                        offsetY: -10,
                        color: '#888',
                        fontSize: '15px'
                    },
                    value: {
                        color: '#333',
                        fontSize: '22px',
                        fontWeight: 'bold',
                        formatter: function (value) {
                            return value + ' tons';
                        }
                    }
                }
            }
        },
        fill: {
            type: 'solid'
        },
        stroke: {
            lineCap: 'round'
        },
        labels: ['Total ' + (formattedCropName === 'All Crops' ? 'Rice' : formattedCropName) + ' Production'] // Dynamically set the label based on the selected crop
    };

    var storageChart = new ApexCharts(document.querySelector("#storageChart"), storageChartOptions);
    storageChart.render();
}
// Function to format labels
function formatLabel(label) {
    return label.replace(/_/g, ' ') // Replace underscores with spaces
                .toLowerCase()     // Convert to lower case
                .replace(/\b\w/g, function (char) { // Capitalize the first letter of each word
                    return char.toUpperCase();
                });
}

// Format the labels
var formattedLabels = pieChartData.labels.map(formatLabel);

// Update pieChartData with formatted labels
pieChartData.labels = formattedLabels;
    // Pie Chart for Yield per District
    if (document.querySelector('#pieChart')) {
        var pieChartOptions = {
            series: pieChartData.series,
            chart: {
                type: 'pie',
                height: 320
            },
            labels: pieChartData.labels,
            colors: colorPalette,
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                floating: false,
                offsetY: 10
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var pieChart = new ApexCharts(document.querySelector("#pieChart"), pieChartOptions);
        pieChart.render();
    }

// Bar Chart for Type Variety Counts per District
if (document.querySelector('#barChart')) {
    var barChartOptions = {
        series: <?php echo json_encode($barChartData); ?>,
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            }
        },
        dataLabels: {
            enabled: false
        },
        colors: colorPalette,
        xaxis: {
            categories: ['Inbred', 'Hybrid', 'Not specified'] // Ensure these categories match your data
        },
        yaxis: {
            title: {
                text: 'Count'
            }
        },
        fill: {
            opacity: 1
        }
    };
    var barChart = new ApexCharts(document.querySelector("#barChart"), barChartOptions);
    barChart.render();
}


    // Pie Chart for Total Rice Production per District
    if (document.querySelector('#pieChartDatas')) {
        var pieChartDatasOptions = {
            series: pieChartDatas.series,
            chart: {
                type: 'pie',
                height: 320
            },
            labels: pieChartDatas.labels,
            colors: colorPalette,
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                floating: false,
                offsetY: 10
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 240
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var pieChartDatasChart = new ApexCharts(document.querySelector("#pieChartDatas"), pieChartDatasOptions);
        pieChartDatasChart.render();
    }
});

</script>




<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function addClearButton(instance) {
        // Check if the clear button already exists
        if (instance.calendarContainer.querySelector('.flatpickr-clear-button')) {
            return;
        }
        
        // Create a clear button
        const clearButton = document.createElement('button');
        clearButton.textContent = 'Clear';
        clearButton.className = 'flatpickr-clear-button';
        clearButton.style.margin = '5px'; // Style the button
        clearButton.onclick = function() {
            instance.clear();
            instance.close();
        };
    
        // Append the clear button to the calendar container
        const calendarContainer = instance.calendarContainer;
        calendarContainer.appendChild(clearButton);
    }

    // Initialize Flatpickr with custom clear button
    flatpickr("#datepickerFrom", {
        dateFormat: "Y-m-d", // Date format (YYYY-MM-DD)
        onOpen: function(selectedDates, dateStr, instance) {
            // Add clear button when calendar opens
            addClearButton(instance);
        }
    });

    flatpickr("#datepickerTo", {
        dateFormat: "Y-m-d", // Date format (YYYY-MM-DD)
        onOpen: function(selectedDates, dateStr, instance) {
            // Add clear button when calendar opens
            addClearButton(instance);
        }
    });
});

</script>

<script>
    function printReport() {
        // Apply print styles
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = '{{ asset('css/print.css') }}';
        document.head.appendChild(link);
    
        // Get current date
        var currentDate = new Date();
        var formattedDate = currentDate.toLocaleDateString();
        var formattedTime = currentDate.toLocaleTimeString();
    
        // Create a new element to hold the title and the current date
        const titleElement = document.createElement('div');
        titleElement.textContent = 'Farmers Data Report';
        titleElement.style.fontWeight = 'bold'; // Adjust styling as needed
    
        const currentDateElement = document.createElement('div');
        currentDateElement.textContent = 'Printed on: ' + formattedDate + ' ' + formattedTime;
        currentDateElement.style.marginBottom = '20px'; // Adjust styling as needed
    
        // Insert the title and the current date elements into the document body
        document.body.insertBefore(titleElement, document.body.firstChild);
        document.body.insertBefore(currentDateElement, titleElement.nextSibling);
    
        // Hide the navbar
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            navbar.style.display = 'none';
        }
    
        // Hide other elements not to be printed
        const elementsToHide = document.querySelectorAll('.exclude-from-print');
        elementsToHide.forEach(element => {
            element.style.display = 'none';
        });
        document.querySelectorAll('.hide-on-print').forEach(button => {
            button.style.display = 'none';
        });
    
        // Insert space after "Average Cost per Area Planted"
        insertSpaceForPrinting();
    
        // Print only the page content
        window.print();
    
        // Show the navbar after printing
        if (navbar) {
            navbar.style.display = '';
        }
    
        // Show the hidden elements after printing
        elementsToHide.forEach(element => {
            element.style.display = '';
        });
        document.querySelectorAll('.hide-on-print').forEach(button => {
            button.style.display = 'block';
        });
    
        // Remove the title and the current date elements after printing
        titleElement.remove();
        currentDateElement.remove();
    }
    
    // Function to insert a space after "Average Cost per Area Planted" when printing
    function insertSpaceForPrinting() {
        const averageCostSection = document.getElementById('average-cost-section'); // Adjust the ID accordingly
        if (averageCostSection) {
            const spaceDiv = document.createElement('div');
            spaceDiv.style.marginBottom = '1000px'; // Adjust the margin as needed
            averageCostSection.parentNode.insertBefore(spaceDiv, averageCostSection.nextSibling);
        }
    }
  </script>
  
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Bootstrap JS -->
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdn.jsdelivr.net/npm/@sgratzl/chartjs-chart-geo@latest"></script>



  <!-- Include Bootstrap Bundle with Popper -->
  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
  <!-- Include Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>
  


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <script>
    // Function to format labels
    function formatLabel(label) {
        return label.replace(/_/g, ' ') // Replace underscores with spaces
                    .toLowerCase()     // Convert to lower case
                    .replace(/\b\w/g, function (char) { // Capitalize the first letter of each word
                        return char.toUpperCase();
                    });
    }

    // Function to open the modal and initialize the pie chart
    function openModal(cropName) {
        // Sample data for pie chart
        var distributionFrequency = @json($distributionFrequency);
        var districts = @json($districts);

        // Prepare data for the pie chart
        var chartData = [];
        for (var districtId in distributionFrequency) {
            if (distributionFrequency.hasOwnProperty(districtId)) {
                chartData.push({
                    name: districts[districtId] || 'Unknown',
                    y: distributionFrequency[districtId]
                });
            }
        }

        // Format the labels
        var formattedLabels = chartData.map(item => formatLabel(item.name));

        // Define a color scheme
        var colorScheme = ['#FF4560', '#008FFB', '#00E396', '#FEB019', '#FF66C3', '#7E36A8'];

        // Initialize the pie chart
        var options = {
            chart: {
                type: 'pie'
            },
            series: chartData.map(item => item.y),
            labels: formattedLabels, // Use formatted labels
            colors: colorScheme.slice(0, chartData.length), // Use a subset of colors based on the number of segments
            title: {
                text: 'Number of Farmers per District'
            },
            legend: {
                position: 'bottom', // Position the legend below the pie chart
                horizontalAlign: 'center', // Center-align the legend
                floating: false, // Make sure the legend is not floating
                offsetY: 10 // Adjust the vertical offset if needed
            }
        };

        var chart = new ApexCharts(document.querySelector("#pieChartContainer"), options);
        chart.render();

        // Open the modal
        var modal = new bootstrap.Modal(document.getElementById('farmerDataModal'));
        modal.show();
    }
</script>

    
<script>
    $(document).ready(function () {
        // Initialize date pickers
        $("#dateFrom").datepicker({ dateFormat: "yy-mm-dd" });
        $("#dateTo").datepicker({ dateFormat: "yy-mm-dd" });
    
        // Form submission handling
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            
            let cropName = $('#cropName').val();
            let district = $('#district').val();
            let dateFrom = $('#dateFrom').val();
            let dateTo = $('#dateTo').val();
    
            $.ajax({
                url: '/admin/dashboard', // Adjust the route if needed
                method: 'GET',
                data: {
                    crop_name: cropName,
                    district: district,
                    dateFrom: dateFrom,
                    dateTo: dateTo
                },
                success: function (response) {
                    // Update chart data based on the response
                    updatePieChart(response.pieChartData);
                    updateBarChart(response.barChartData);
    
                    // Update other fields
                    $('#totalFarms').text(response.totalFarms);
                    $('#totalAreaPlanted').text(response.totalAreaPlanted);
                    $('#totalAreaYield').text(response.totalAreaYield);
                    $('#totalCost').text(response.totalCost);
                    $('#yieldPerAreaPlanted').text(response.yieldPerAreaPlanted);
                    $('#averageCostPerAreaPlanted').text(response.averageCostPerAreaPlanted);
                    $('#totalRiceProduction').text(response.totalRiceProduction);
    
                    // Update filters
                    updateFilters(response.crops, response.districts);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                    alert('An error occurred while fetching data. Please try again.');
                }
            });
        });
    
        function updatePieChart(data) {
            let options = {
                chart: {
                    type: 'pie'
                },
                labels: data.labels,
                series: data.series
            };
            let chart = new ApexCharts(document.querySelector("#pieChart"), options);
            chart.render();
        }
    
        function updateBarChart(data) {
            let options = {
                chart: {
                    type: 'bar'
                },
                series: data
            };
            let chart = new ApexCharts(document.querySelector("#barChart"), options);
            chart.render();
        }
    
        function updateFilters(crops, districts) {
            let cropSelect = $('#cropName');
            let districtSelect = $('#district');
    
            cropSelect.empty();
            districtSelect.empty();
    
            cropSelect.append(new Option('All Crops', ''));
            crops.forEach(crop => {
                cropSelect.append(new Option(crop, crop));
            });
    
            districtSelect.append(new Option('All Districts', ''));
            districts.forEach(district => {
                districtSelect.append(new Option(district, district));
            });
        }
    });
    </script>


    
    <script>
$(document).ready(function () {
    // Handle pagination links click event
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        
        // Get the page number from the URL
        var page = $(this).attr('href').split('page=')[1];
        
        console.log('Clicked page number: ', page); // Log the page number

        // Fetch paginated data for the selected page
        fetchFarmersData(page);
    });

    // Function to fetch farmers data via AJAX
    function fetchFarmersData(page) {
        var districtFilter = $('#districtFilter').val(); // Optional filter for district
        
        console.log('Fetching farmers data for page: ', page); // Log before making the AJAX call

        $.ajax({
            url: '/admin/dashboard?page=' + page,  // Adjust route to use a query string for the page number
            type: 'GET',
            data: { 
                district: districtFilter, // Pass the district filter if applicable
                // Add other filters like crop, etc.
            },
            success: function (response) {
                console.log('AJAX success response: ', response); // Log the successful response

                // Update the farmers table with new data
                $('#farmersTable').html(response.farmers);

                // Update pagination links
                $('.pagination').html(response.pagination);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching paginated data: ', error); // Log error
                console.error('Error details: ', xhr.responseText); // Log the response text
            }
        });
    }
});

    </script>
    
<!-- Custom JavaScript for Accordion Behavior -->

<!-- Custom JavaScript for Accordion Behavior -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const accordionButtons = document.querySelectorAll('#farmerDataAccordion .accordion-button');

        accordionButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-bs-target');
                const targetCollapse = document.querySelector(targetId);
                
                if (targetCollapse) {
                    const isCollapsed = targetCollapse.classList.contains('collapse');
                    
                    // Toggle the child section
                    if (isCollapsed) {
                        const bsCollapse = new bootstrap.Collapse(targetCollapse, { toggle: true });
                    } else {
                        const bsCollapse = new bootstrap.Collapse(targetCollapse, { toggle: false });
                    }
                    
                    // Toggle the parent section
                    const parentAccordion = targetCollapse.closest('.accordion-item').querySelector('.accordion-button');
                    if (parentAccordion) {
                        const parentTargetId = parentAccordion.getAttribute('data-bs-target');
                        const parentCollapse = document.querySelector(parentTargetId);
                        
                        if (parentCollapse) {
                            const isParentCollapsed = parentCollapse.classList.contains('collapse');
                            
                            if (isParentCollapsed) {
                                const bsCollapseParent = new bootstrap.Collapse(parentCollapse, { toggle: true });
                            } else {
                                const bsCollapseParent = new bootstrap.Collapse(parentCollapse, { toggle: false });
                            }
                        }
                    }
                }
            });
        });
    });
</script>

@endsection