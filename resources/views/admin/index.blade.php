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


/* Ensure modal header is flex and items are centered */
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Space between title and buttons */
    flex-wrap: wrap; /* Allows wrapping of elements */
}

/* Style for modal title */
.modal-title {
    font-size: 1.25rem; /* Default font size for larger screens */
    margin: 0;
    flex: 1; /* Allow title to take up available space */
}

/* Style for buttons */
.modal-header .btn {
    margin-top: 0;
}

/* Adjustments for smaller screens */
@media (max-width: 320px) { /* For mobile phones */
    .modal-title {
        font-size:0.9rem; /* Slightly smaller font size */
        text-align: center; /* Center title text on small screens */
        margin-bottom: 0.5rem; /* Add space below title */
    }

    .modal-header {
        flex-direction: column; /* Stack items vertically on smaller screens */
        align-items: center; /* Center align items */
    }

    .modal-header .btn {
        margin-top: 0.5rem; /* Add space between buttons on small screens */
    }
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
                        {{-- @php
                        function formatCropName($name) {
                            // Convert to lowercase and replace underscores with spaces
                            $formattedName = strtolower($name);
                            $formattedName = str_replace('_', ' ', $formattedName);
                    
                            // Capitalize the first letter of each word
                            return ucwords($formattedName);
                        }
                    @endphp --}}
                    
                    @foreach ($crops as $crop)
                        <option value="{{ $crop }}" {{ $crop == $selectedCropName ? 'selected' : '' }}>
                            {{-- {{ formatCropName($crop) }} --}}
                        </option>
                    @endforeach
                    
                    
                    </select>
                </div>
    
                <!-- District Dropdown -->
                <div class="me-2 mb-2 mb-md-0" style="min-width: 150px;">
                    <select name="district" id="district" class="form-control w-100">
                        <option value="">All Districts</option>
                        {{-- @php
                        function formatdistrict($district) {
                            // Convert to lowercase and replace underscores with spaces
                            $formattedName = strtolower($district);
                            $formattedName = str_replace('_', ' ', $formattedName);
                    
                            // Capitalize the first letter of each word
                            return ucwords($formattedName);
                        }
                        @endphp --}}
                     @foreach ($districts as $district)
                     
                       
                   

                        <option value="{{ $district }}" {{ $district == $selectedDistrict ? 'selected' : '' }}>
                            {{-- {{ formatdistrict($district) }} --}}
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

<!-- Card for Total Number of Farmers -->
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

<!-- Modal for Farmers Per District -->
<div class="modal fade" id="farmersModal" tabindex="-1" role="dialog" aria-labelledby="farmersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
           <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="farmersModalLabel">Farmers Per District - {{ $selectedCropName }}</h5>
                    <div class="ms-auto d-flex align-items-center">
                        <!-- Eye Icon Button with Tooltip -->
                        <button type="button" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#farmerInfoModal" title="View Farmers Information">
                            <i class="fa fa-eye"> Farmers</i>
                        </button>
                        <!-- Close Button -->
                        <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>


            <div class="modal-body p-0">
                <!-- Pie Chart and Legends Section -->
                <div class="d-flex flex-column" style="height: 80vh; width: 70%;">
                    <!-- Pie Chart Container -->
                    <div id="pieChartContainer" style="flex: 1; height: 70%;"></div>
                
                    <!-- Legends Container -->
                    <div id="pieChartLegend" class="mt-3" style="width: 100%; max-height: 30%; overflow-y: auto; padding: 1rem;">
                        <!-- Legends will be generated and inserted here by the chart library -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="farmerInfoModal" tabindex="-1" role="dialog" aria-labelledby="farmerInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="farmerInfoModalLabel">Detailed Farmers Information</h5>
                <button type="button"class="btn-close btn-light border border-2 border-white shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-center align-items-center" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                <div class="accordion w-100" id="farmerAccordion">
                    <!-- Accordion Item 1 -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Farmers Table
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#farmerAccordion">
                            <div class="accordion-body bg-light d-flex flex-column justify-content-center align-items-center">
                                <div id="farmersTable" class="w-100 table-responsive">
                                    @include('agent.partials.farmers_table', ['paginatedFarmers' => $paginatedFarmers])
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
                    <!-- Additional Accordion Items can be added here -->
                </div>
            </div>
        </div>
    </div>
</div>











    
<!-- Card for Total Area Planted -->
<div class="col-md-2 stretch-card" onclick="openAreaModal('{{ $selectedCropName }}')">
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

<!-- Modal for Area Planted Details -->
<div class="modal fade" id="areaModal" tabindex="-1" role="dialog" aria-labelledby="areaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="areaModalLabel">Total Area Planted- {{ $selectedCropName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                <div class="d-flex flex-column" style="height: 67vh; width: 70%;">
                    <!-- Pie Chart Container -->
                    <div id="piecharts" style="flex: 1; height: 90%;"></div>
                
                    <!-- Legends Container -->
                    <div id="pieChartLegend" class="mt-3" style="width: 100%; max-height: 30%; overflow-y: auto; padding: 1rem;">
                        <!-- Legends will be generated and inserted here by the chart library -->
                    </div>
                </div>

                <!-- Add Pie Chart here -->
              
            </div>

            <!-- Modal Footer -->
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              
            </div> --}}
        </div>
    </div>
</div>



<!-- Card for Total Area Yield -->
<div class="col-md-2 stretch-card" onclick="openYieldBarModal('{{ $selectedCropName }}')">
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

<!-- Modal for Area Yield Details -->
<div class="modal fade" id="yieldBarModal" tabindex="-1" role="dialog" aria-labelledby="yieldBarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="yieldBarModalLabel">Total Area Yield - {{ $selectedCropName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                <div class="d-flex flex-column" style="height: 67vh; width: 70%;">
                    <!-- Pie Chart Container -->
                    <div id="yieldBarChart" style="flex: 1; height: 90%;"></div>
                
                    <!-- Legends Container -->
                    <div id="yieldPieChartLegend" class="mt-3" style="width: 100%; max-height: 30%; overflow-y: auto; padding: 1rem;">
                        <!-- Legends will be generated and inserted here by the chart library -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card for Total Cost -->
<div class="col-md-2 stretch-card" >
    <div class="card custom-card bg-danger text-white mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="text-center">
                    <h5 class="mb-2 text-white">
                        <p style="font-size: 12px">Php</p>
                        {{ number_format($totalCost, 2) }}
                    </h5>
                </div>
                <div class="small-title mt-2 text-center">
                    <h6 class="mb-0 text-white">Total Cost</h6>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Modal for Total Cost Details -->
<div class="modal fade" id="costModal" tabindex="-1" role="dialog" aria-labelledby="costModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="costModalLabel">Total Cost - {{ $selectedCropName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                <div class="d-flex flex-column" style="height: 67vh; width: 70%;">
                    <!-- Pie Chart Container -->
                    <div id="costLine" style="flex: 1; height: 90%;"></div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Card for Average Yield/Area Planted -->
<div class="col-md-2 stretch-card" onclick="openCostModal('{{ $selectedCropName }}')">
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

<!-- Modal for Average Yield Details -->
{{-- <div class="modal fade" id="yieldsModal" tabindex="-1" role="dialog" aria-labelledby="yieldsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="yieldsModalLabel">Average Yield per Area - {{ $selectedCropName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                <div class="d-flex flex-column" style="height: 67vh; width: 70%;">
                    <!-- Line Chart Container -->
                    <div id="yieldLineCharts" style="flex: 1; height: 90%;"></div>
                </div>
            </div>

            <div class="text-center mt-3">
                <button class="btn btn-primary" onclick="printChart()">Print Chart</button>
                <button class="btn btn-success" onclick="saveAsPNG()">Save as PNG</button>
                <button class="btn btn-info" onclick="saveAsPDF()">Save as PDF</button>
            </div>
        </div>
    </div>
</div> --}}
<!-- Modal for Total Cost Details -->
<div class="modal fade" id="costModal" tabindex="-1" role="dialog" aria-labelledby="costModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="costModalLabel">Total Cost - {{ $selectedCropName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                <div class="d-flex flex-column" style="height: 67vh; width: 70%;">
                    <!-- Pie Chart Container -->
                    <div id="costLine" style="flex: 1; height: 90%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Card for Average Cost/Area Planted -->
<div class="col-md-2 stretch-card" onclick="openAveCostModal('{{ $selectedCropName }}')">
    <div class="card custom-card bg-secondary text-white mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="text-center">
                    <h5 class="mb-2 text-white"><p style="font-size: 12px">Php</p>{{ number_format($averageCostPerAreaPlanted, 2) }}</h5>
                </div>
                <div class="small-title mt-2 text-center">
                    <h6 class="mb-0 text-white">Ave. Cost/</h6>
                    <h6 class="mb-0 text-white">Area Planted</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Average Cost Details -->
<div class="modal fade" id="avecostModal" tabindex="-1" role="dialog" aria-labelledby="avecostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="avecostModalLabel">Average Cost per Area - {{ $selectedCropName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-0">
                <div class="d-flex flex-column" style="height: 67vh; width: 70%;">
                    <!-- Bar Chart Container -->
                    <div id="costBarCharts" style="flex: 1; height: 90%;"></div>
                
                    <!-- Legends Container -->
                    <div id="costBarChartLegend" class="mt-3" style="width: 100%; max-height: 30%; overflow-y: auto; padding: 1rem;">
                        <!-- Legends can be generated and inserted here if needed -->
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="printChartButton" class="btn btn-primary">Print Chart</button>
                <button id="saveChartButton" class="btn btn-success">Save as PNG</button>
                <button id="savePDFButton" class="btn btn-danger">Save as PDF</button> <!-- New PDF button -->
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
    var colorPalette = ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'];

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
        horizontalAlign: 'center'
    },
    dataLabels: {
        style: {
            colors: ['black'] // Set label text color inside the pie chart to black
        },
        dropShadow: {
            enabled: false // Disable drop shadow if not required
        },
        formatter: function (val, opts) {
            return val.toFixed(2) + "%"; // Format percentage values
        }
    },
    tooltip: {
        enabled: true,
        theme: 'light', // Use 'dark' for dark background, here 'light' for white
        style: {
            fontSize: '12px',
            color: '#000', // Set tooltip text color to black
        },
        y: {
            formatter: function (val) {
                return val + ' tons'; // Customize tooltip content for yields
            }
        }
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
            categories: ['Inbred', 'Hybrid' ,   'No data'] // Ensure these categories match your data
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
        var colorScheme = ['#FF4560', '#008FFB', '#e3004d', '#FEB019', '#FF66C3', '#7E36A8'];

       // Initialize the pie chart
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
        horizontalAlign: 'center' // Center-align the legend
    },
    dataLabels: {
        style: {
            colors: ['black'] // Set the label text color inside the pie chart to black
        },
        dropShadow: {
            enabled: false // Disable drop shadow if you don't want it
        },
        formatter: function (val, opts) {
            return val.toFixed(2) + "%"; // Format percentage values
        }
    },
    plotOptions: {
        pie: {
            dataLabels: {
                style: {
                    colors: ['black'] // Set the color for floating labels (outside the pie chart)
                }
            }
        }
    },
    tooltip: {
        enabled: true,
        theme: 'dark', // Change this to 'light' for a white background if needed
        style: {
            fontSize: '14px',
            color: '#000', // Set tooltip text color to black
        },
        y: {
            formatter: function (val) {
                return val + ' farmers'; // Customize tooltip content if needed
            }
        }
    }
};



        var chart = new ApexCharts(document.querySelector("#pieChartContainer"), options);
        chart.render();

        // Open the modal
        var modal = new bootstrap.Modal(document.getElementById('farmersModal'));
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


<script>
    document.getElementById('viewFarmersInfoBtn').addEventListener('click', function() {
        var farmerInfoModal = new bootstrap.Modal(document.getElementById('farmerInfoModal'));
        farmerInfoModal.show();
    });
</script>
<script>
    window.addEventListener('beforeunload', function (event) {
        navigator.sendBeacon('/logout');
    });
</script>
<script>
    function openAreaModal(cropName) {
        // Set the crop name in the modal title or use it for other logic
        document.getElementById('areaModalLabel').innerText = 'Area Details for ' + cropName;
        $('#areaModal').modal('show'); // Using jQuery to show the modal
    }
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare the district names and total areas as arrays for the chart
    var districtNames = @json($totalAreaPlantedByDistrict->pluck('district'));
    var totalAreas = @json($totalAreaPlantedByDistrict->pluck('total_area_planted')->map(function($area) {
    return round($area, 2); // Round each area to 2 decimal places
}));


    // Define the custom color scheme
    var colorScheme = ['#FF4560', '#008FFB', '#e3004d', '#FEB019', '#FF66C3', '#7E36A8'];

    // Render the pie chart using ApexCharts
    var options = {
        chart: {
            type: 'pie',
            height: 400
        },
        labels: districtNames,
        series: totalAreas,
        colors: colorScheme,  // Use the custom color scheme
        title: {
            text: 'Total Area Planted by District (ha)',
            align: 'center'
        },
        legend: {
            position: 'bottom', // Position the legend below the pie chart
            horizontalAlign: 'center' // Center-align the legend
        },
        dataLabels: {
            style: {
                colors: ['black'] // Set the label text color inside the pie chart to black
            },
            dropShadow: {
                enabled: false // Disable drop shadow if you don't want it
            },
            formatter: function (val, opts) {
                return val.toFixed(2) + "%"; // Format percentage values
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 300
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#piecharts"), options);
    chart.render();  // Render the chart
});

</script>




<script>
  // Function to open the yield modal and initialize the line chart dynamically
function openYieldModal(selectedCropName) {
    // Show the modal
    $('#yieldModal').modal('show');

    // Prepare the district names (these will serve as x-axis categories) and total areas (y-axis values)
    var districtNames = @json($totalAreaYieldPerDistricts->pluck('district'));
    var totalAreas = @json($totalAreaYieldPerDistricts->pluck('total_areaYIELD')->map(function($area) {
        return round($area, 2); // Round each area to 2 decimal places
    }));

    // Define the custom color scheme
    var colorScheme = ['#FF4560', '#008FFB', '#e3004d', '#FEB019', '#FF66C3', '#7E36A8'];

    // Initialize the line chart data
    const yieldLineChartData = {
        chart: {
            type: 'line',
            height: 400
        },
        series: [{
            name: 'Yield (ha)', // Series name
            data: totalAreas // The data points for the line graph (y-axis values)
        }],
        xaxis: {
            categories: districtNames, // X-axis categories (districts)
            title: {
                text: 'Districts'
            }
        },
        yaxis: {
            title: {
                text: 'Yield (ha)'
            },
            labels: {
                formatter: function (value) {
                    return value.toFixed(2); // Format y-axis labels to 2 decimal places
                }
            }
        },
        colors: colorScheme, // Use the custom color scheme
        title: {
            text: 'Yield  (ha)',
            align: 'center'
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center'
        },
        dataLabels: {
            enabled: false // Disable data labels to keep the chart clean
        },
        stroke: {
            curve: 'smooth' // Smooth line curve
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 300
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    // Check if chart already exists, if so, destroy it before re-rendering
    if (window.yieldLineChart) {
        window.yieldLineChart.destroy();
    }

    // Render the new line chart
    window.yieldLineChart = new ApexCharts(document.querySelector("#yieldPieChart"), yieldLineChartData);
    window.yieldLineChart.render();
}

// Event listener to handle modal open
$('#yieldModal').on('shown.bs.modal', function () {
    // You can add any dynamic data loading logic here if needed, like making an AJAX request for updated data
});



//     // JavaScript function to open the cost modal and initialize the chart
// function openCostModal(selectedCropName) {
//     // Show the modal
//     $('#costModal').modal('show');
    
//     // Initialize the cost pie chart
//     const costPieChartData = {
//         series: [ /* Data for the cost pie chart */ ],
//         chart: {
//             type: 'pie',
//             height: '100%'
//         },
//         labels: [ /* Labels for the cost pie chart */ ],
//         legend: {
//             show: true,
//             position: 'bottom'
//         }
//     };

//     const costPieChart = new ApexCharts(document.querySelector("#costPieChart"), costPieChartData);
//     costPieChart.render();

//     // Populate the legend (if needed)
//     // You can generate legend items based on your data here
// }

// // Event listener to handle cost modal opening
// $('#costModal').on('shown.bs.modal', function () {
//     // If you need to update the chart data every time the modal opens, you can add that logic here
// });
// Function to open the modal and initialize the bar chart
function openYieldBarModal() {
    // Show the modal
    $('#yieldBarModal').modal('show');

    // Once the modal is shown, initialize the chart
    $('#yieldBarModal').on('shown.bs.modal', function () {
        // Data for the bar chart (fetched from backend as JSON)
        var districtNames = @json($totalAreaYieldPerDistrictss->pluck('district'));
        var yieldPerAreaPlanted = @json($totalAreaYieldPerDistrictss->pluck('total_areaYIELD')->map(function($yield) {
            return round($yield, 2); // Round each yield to 2 decimal places
        }));

        // Define the bar chart options
        var options = {
            chart: {
                type: 'bar',
                height: 400
            },
            series: [{
                name: 'Yield per Area Planted',
                data: yieldPerAreaPlanted
            }],
            xaxis: {
                categories: districtNames,
                title: {
                    text: 'Districts'
                }
            },
            yaxis: {
                title: {
                    text: 'Yield per Area Planted (kg/ha)'
                }
            },
            colors: ['#008FFB'],
            title: {
                text: 'Yield per Area Planted by District',
                align: 'center'
            },
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#000']
                },
                formatter: function (val) {
                    return val.toFixed(2);
                }
            }
        };

        // Render the bar chart
        var chart = new ApexCharts(document.querySelector("#yieldBarChart"), options);
        chart.render();
    });

    // Optional: To clean up the chart when the modal is closed (if needed)
    $('#yieldBarModal').on('hidden.bs.modal', function () {
        document.querySelector("#yieldBarChart").innerHTML = ""; // Clear the chart
    });
}
 // Pass the PHP data to JavaScript
 var totalAreaYieldPerDistrictss = @json($totalAreaYieldPerDistrictss);
    
    // Prepare data for the chart
    var districtNames = totalAreaYieldPerDistrictss.map(item => item.district);
    var yieldPerAreaPlanted = totalAreaYieldPerDistrictss.map(item => item.yieldPerAreaPlanted);
    var totalAreaYIELD = totalAreaYieldPerDistrictss.map(item => item.total_areaYIELD);
    var totalAreaPLANTED = totalAreaYieldPerDistrictss.map(item => item.total_areaPLANTED);
    
    function openCostModal(selectedCropName) {
        // Show the modal
        $('#costModal').modal('show');

        // Once the modal is shown, initialize the chart
        $('#costModal').on('shown.bs.modal', function () {
            // Define the line chart options
            var options = {
                chart: {
                    type: 'line',
                    height: 400
                },
                series: [
                    {
                        name: 'Yield per Area Planted',
                        data: yieldPerAreaPlanted
                    },
                    {
                        name: 'Total Area Yield',
                        data: totalAreaYIELD
                    },
                    {
                        name: 'Total Area Planted',
                        data: totalAreaPLANTED
                    }
                ],
                xaxis: {
                    categories: districtNames,
                    title: {
                        text: 'Districts'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Values'
                    }
                },
                title: {
                    text: 'Yield and Area by District',
                    align: 'center'
                },
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toFixed(2); // Format labels
                    }
                }
            };

            // Render the line chart
            var chart = new ApexCharts(document.querySelector("#costLine"), options);
            chart.render();
        });

        // Optional: To clean up the chart when the modal is closed (if needed)
        $('#costModal').on('hidden.bs.modal', function () {
            document.querySelector("#costLine").innerHTML = ""; // Clear the chart
        });
    }

// Function to generate legends
function generateCostLegends(categories, costs) {
    const legendContainer = document.getElementById('costPieChartLegend');
    legendContainer.innerHTML = ''; // Clear previous legends

    categories.forEach((category, index) => {
        const legendItem = document.createElement('div');
        legendItem.classList.add('legend-item');
        legendItem.innerHTML = `<span style="background-color: ${ApexCharts.exec("chartColors")[index]}"></span> ${category}: Php ${costs[index].toFixed(2)}`;
        legendContainer.appendChild(legendItem);
    });
}

// Function to open the Yield modal and initialize the line chart
function openYieldsModal(selectedCropName) {
    // Show the modal
    $('#yieldsModal').modal('show');

    // Static data for the line chart (Replace this with your actual data)
    const yieldData = {
        categories: ['Ayala', 'Tumaga', 'Culianan', 'Manicahan', 'Curuan', 'Vitali'], // Updated categories for districts
        series: [{
            name: 'Average Yield (Kg/Ha)',
            data: [1500, 1600, 1800, 2000, 2200, 2400] // Replace with actual yield data corresponding to each district
        }]
    };

    const yieldLineChartOptions = {
        chart: {
            type: 'line',
            height: '100%',
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: true
        },
        series: yieldData.series,
        xaxis: {
            categories: yieldData.categories
        },
        title: {
            text: `Average Yield of ${selectedCropName}`,
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: 'bold'
            }
        },
        stroke: {
            curve: 'smooth' // Makes the line smooth
        },
        markers: {
            size: 5 // Marker size on the line
        }
    };

    // Create and render the line chart
    const yieldLineChart = new ApexCharts(document.querySelector("#yieldLineCharts"), yieldLineChartOptions);
    yieldLineChart.render();
}

// Function to print the chart
function printChart() {
    const chartElement = document.querySelector("#yieldLineCharts");
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`<html><head><title>Print Chart</title></head><body>${chartElement.outerHTML}</body></html>`);
    printWindow.document.close();
    printWindow.print();
}

// Function to save chart as PNG
function saveAsPNG() {
    const chartElement = document.querySelector("#yieldLineCharts");
    html2canvas(chartElement).then(function(canvas) {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'chart.png';
        link.click();
    });
}

// Function to save chart as PDF
function saveAsPDF() {
    const chartElement = document.querySelector("#yieldLineCharts");
    html2canvas(chartElement).then(function(canvas) {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF();
        const imgWidth = 190;
        const pageHeight = pdf.internal.pageSize.height;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        let heightLeft = imgHeight;

        let position = 0;

        pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }
        
        pdf.save('chart.pdf');
    });
}








// // JavaScript function to open the cost modal and initialize the static bar chart
// function openAveCostModal(selectedCropName) {
//     // Show the modal
//     $('#avecostModal').modal('show');

//     // Static data for the bar chart
//     const costData = {
//         categories: ['Fertilizer', 'Labor', 'Seeds', 'Pesticides','Seeds', 'Pesticides'], // Categories for the X-axis
//         series: [{
//             name: 'Average Cost (Php)',
//             data: [1500, 3000, 2000, 2500,2000, 2500] // Static cost values
//         }]
//     };

//     // Color scheme array
//     var colorScheme = ['#FF4560', '#008FFB', '#e3004d', '#FEB019', '#FF66C3', '#7E36A8'];

//     const costBarChartOptions = {
//         chart: {
//             type: 'bar',
//             height: '100%',
//             toolbar: {
//                 show: false
//             }
//         },
//         plotOptions: {
//             bar: {
//                 horizontal: false,
//                 endingShape: 'rounded',
//                 columnWidth: '55%'
//             },
//         },
//         dataLabels: {
//             enabled: true
//         },
//         series: costData.series,
//         xaxis: {
//             categories: costData.categories
//         },
//         title: {
//             text: `Average Cost of ${selectedCropName}`,
//             align: 'center',
//             style: {
//                 fontSize: '20px',
//                 fontWeight: 'bold'
//             }
//         },
//         colors: colorScheme // Use the color scheme array here
//     };

//     // Create and render the bar chart
//     const costBarChart = new ApexCharts(document.querySelector("#costBarCharts"), costBarChartOptions);
//     costBarChart.render();
// }

// JavaScript function to open the cost modal and initialize the static bar chart
// JavaScript function to open the cost modal and initialize the static bar chart
function openAveCostModal(selectedCropName) {
    // Show the modal
    $('#avecostModal').modal('show');

    // Static data for the bar chart
    const costData = {
        categories: ['Fertilizer', 'Labor', 'Seeds', 'Pesticides'], // Categories for the X-axis
        series: [{
            name: 'Average Cost (Php)',
            data: [
                { x: 'Fertilizer', y: 1500, fillColor: '#FF4560' },
                { x: 'Labor', y: 3000, fillColor: '#008FFB' },
                { x: 'Seeds', y: 2000, fillColor: '#e3004d' },
                { x: 'Pesticides', y: 2500, fillColor: '#FEB019' },
                { x: 'ALLa', y: 2000, fillColor: '#FF66C3' },
                { x: 'Mas', y: 2500, fillColor: '#7E36A8' }
            ]
        }]
    };

    const costBarChartOptions = {
        chart: {
            type: 'bar',
            height: '100%',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                endingShape: 'rounded',
                columnWidth: '55%'
            }
        },
        dataLabels: {
            enabled: true
        },
        series: costData.series,
        xaxis: {
            categories: costData.categories
        },
        title: {
            text: `Average Cost of ${selectedCropName}`,
            align: 'center',
            style: {
                fontSize: '20px',
                fontWeight: 'bold'
            }
        },
        colors: costData.series[0].data.map(point => point.fillColor)
    };

    // Create and render the bar chart
    const costBarChart = new ApexCharts(document.querySelector("#costBarCharts"), costBarChartOptions);
    costBarChart.render();

    // Add event listeners for buttons
    document.getElementById("printChartButton").onclick = function () {
        printChart(costBarChart);
    };
    
    document.getElementById("saveChartButton").onclick = function () {
        saveChartAsPNG(costBarChart);
    };

    document.getElementById("savePDFButton").onclick = function () {
        saveChartAsPDF(costBarChart);
    };
}

// Function to print the chart
function printChart(chart) {
    // Create a new window for printing
    const printWindow = window.open('', '', 'height=500,width=800');
    printWindow.document.write('<html><head><title>Print Chart</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">'); // Include ApexCharts styles
    printWindow.document.write('</head><body >');
    printWindow.document.write('<h1>Chart</h1>');
    
    // Append the SVG of the chart
    printWindow.document.write(chart.container.innerHTML);
    printWindow.document.write('</body></html>');
    
    printWindow.document.close(); // Close the document for writing
    printWindow.print(); // Print the window
}

// Function to save the chart as PNG
function saveChartAsPNG(chart) {
    chart.dataURI().then(({ imgURI }) => {
        const link = document.createElement('a');
        link.href = imgURI; // Set the URI to the image
        link.download = 'chart.png'; // Set the file name
        link.click(); // Programmatically click the link to trigger download
    });
}

// Function to save the chart as PDF
function saveChartAsPDF(chart) {
    // Create a new canvas
    html2canvas(document.querySelector("#costBarCharts")).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('landscape');
        const imgWidth = 190; // Image width
        const pageHeight = pdf.internal.pageSize.height; // Page height
        const imgHeight = (canvas.height * imgWidth) / canvas.width; // Image height
        let heightLeft = imgHeight;

        let position = 0;

        // Add the image to the PDF
        pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        // If there's still space, add another page
        while (heightLeft >= 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        // Save the PDF
        pdf.save('chart.pdf');
    });
}

</script>
    
@endsection