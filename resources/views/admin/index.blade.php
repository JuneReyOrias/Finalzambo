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
        .bgnew {
            background: #ff0000;
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

/* #results {
    display: flex;
    flex-wrap: nowrap;
    justify-content: center;
} */


/* Media Queries for smaller devices */









.custom-card:hover {
    transform: scale(1.05); /* Slightly enlarge the card on hover */
}

.card-title {
    font-size: 10px; /* Adjust title font size */
}

.card-text {
    font-size: 0.5rem; /* Adjust value font size */
}


.card {
    border: 1px solid #007bff; /* Customize border color */
    border-radius: 15px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1); /* Initial card shadow */
    transition: transform 0.2s, box-shadow 0.2s; /* Smooth transition for hover effects */
}

.card:hover {
    transform: scale(1.05); /* Slightly enlarge the card on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Increase shadow on hover */
}

.card-body {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

canvas {
    max-width: 100%;
    height: auto;
}


</style>

<div class="page-content">
  
        <!-- Title -->
        <div>
            <h4 class="mb-3 mb-md-0" style="font-size: 19px;">Zambo-AgriMap Dashboard</h4>
        </div>
   
    <div class="row g-2 align-items-center">
        <!-- Crop Name Dropdown -->
        <div class="col-md-3">
            <label for="cropName" class="form-label">Select Crop</label>
            <select id="cropName" class="form-select">
                <option value="">All Crops</option>
                @foreach ($crops as $crop)
                    <option value="{{ $crop }}">{{ ucwords(strtolower($crop)) }}</option>
                @endforeach
            </select>
            
        </div>
    
        <!-- Date From Input -->
        <div class="col-md-2">
            <label for="dateFrom" class="form-label">Date From</label>
            <input type="date" id="dateFrom" class="form-control">
        </div>
    
        <!-- Date To Input -->
        <div class="col-md-2">
            <label for="dateTo" class="form-label">Date To</label>
            <input type="date" id="dateTo" class="form-control">
        </div>
    
        <!-- District Dropdown -->
        <div class="col-md-3">
            <label for="district" class="form-label">Select District</label>
            <select id="district" class="form-select">
                <option value="">All Districts</option>
                @foreach ($districts as $district)
                    <option value="{{ $district }}">{{ ucwords(strtolower($district)) }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-2">
            <label class="form-label" style="visibility: hidden;">Print Reports</label> <!-- Invisible label to match alignment -->
            <button id="printButton" class="btn btn-primary w-100">Print Reports</button>
        </div>
    </div>
    
    
    <div id="results" class="row g-2 mt-4">
     <!-- Total Farmers Card -->
     <div class="col-md-2 stretch-card" onclick="openFarmersModal()">
        <div class="card custom-card bg text-white mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="text-center">
                        <h5 class="mb-2 text-white" id="totalFarms">0</h5>
                    </div>
                    <div class="small-title mt-2 text-center">
                        <h6 class="mb-0 text-white">Total Farmers</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for Farmers List -->
<div class="modal fade" id="farmersModal" tabindex="-1" role="dialog" aria-labelledby="farmersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
           <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="farmersModalLabel">Farmers Per District </h5>
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
                    {{-- <div id="farmsPieChartContainer" style="flex: 1; height: 70%;"></div> --}}
                    <canvas id="FarmPERDISTRICTS" width="200" height="200"></canvas>
                    {{-- <canvas id="barChart" width="110px" height="110px"></canvas> --}}
                    <!-- Legends Container -->
                    <div id="pieChartLegend" class="mt-3" style="width: 100%; max-height: 30%; overflow-y: auto; padding: 1rem;">
                        <!-- Legends will be generated and inserted here by the chart library -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- The Modal Structure -->

<div class="modal fade" id="farmerInfoModal" tabindex="-1" role="dialog" aria-labelledby="farmerInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="farmerInfoModalLabel">Detailed Farmers Information</h5>
                <button type="button" class="btn-close btn-light border border-2 border-white shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-center align-items-center" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                <div class="accordion w-100" id="farmerAccordion">
                    <!-- Accordion Item for Farmers Table -->
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Farmers Table
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#farmerAccordion">
                            <div class="accordion-body bg-light d-flex flex-column justify-content-center align-items-center">
                                <div id="farmersTable" class="w-100 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Organization</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody id="farmersTableBody">
                                            <!-- Farmers data will be dynamically populated here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div id="paginationContainer" class="mt-3">
                                    <!-- Pagination links will be dynamically populated here -->
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





<!-- Total Area Planted Card -->
<div class="col-md-2 stretch-card" onclick="openAreaPlantedModal('Total Area Planted')">
    <div class="card custom-card backg text-white mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="text-center">
                    <h5 class="mb-2 text-white" id="totalAreaPlanted">0</h5>
                </div>
                <div class="small-title mt-2 text-center">
                    <h6 class="mb-0 text-white">Total Area Planted (ha)</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Total Area Planted Modal -->
<div class="modal fade" id="areaPlantedModal" tabindex="-1" role="dialog" aria-labelledby="areaPlantedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="areaPlantedModalLabel">Total Area Planted</h5>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-0">
                <!-- Chart Container -->
                <div class="d-flex flex-column align-items-center" style="height: 80vh; width: 100%;">
                    <canvas id="districtsPieChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

    
<!-- Total Area Yield Card -->
<div class="col-md-2 stretch-card" data-bs-toggle="modal" data-bs-target="#totalAreaYieldModal">
    <div class="card custom-card bgnew text-white mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="text-center">
                    <h5 class="mb-2 text-white" id="totalAreaYield">0</h5>
                </div>
                <div class="small-title mt-2 text-center">
                    <h6 class="mb-0 text-white">Total Area Yield (kg)</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="totalAreaYieldModal" tabindex="-1" aria-labelledby="totalAreaYieldModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="totalAreaYieldModalLabel">Total Area Yield Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <canvas id="barChart" width="110px" height="110px"></canvas>
                {{-- <canvas id="pieChart" width="110px" height="110px"></canvas> --}}
                {{-- <p>The total area yield for all crops in all districts is 0 kg.</p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Total Cost Card -->
<div class="col-md-2 stretch-card">
    <div class="card custom-card bg-danger text-white mb-3" id="totalCostCard">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <div class="text-center">
                    <h5 class="mb-2 text-white" id="totalCost">0</h5>
                </div>
                <div class="small-title mt-2 text-center">
                    <h6 class="mb-0 text-white">Total Cost (PHP)</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Total Cost Modal -->

<div class="modal fade" id="totalCostModal" tabindex="-1" aria-labelledby="totalCostModalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="totalCostModalModalLabel">Total Cost Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <canvas id="barChart" width="110px" height="110px"></canvas> --}}
                {{-- <canvas id="pieChart" width="110px" height="110px"></canvas> --}}
                {{-- <p>The total area yield for all crops in all districts is 0 kg.</p> --}}
                <p>Total Cost: <span id="modalTotalCost">0</span> PHP</p>
                <canvas id="TotalCost" width="400" height="200"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



    
        <!-- Yield per Area Planted Card -->
        <div class="col-md-2 stretch-card" >
            <div class="card custom-card backg text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="text-center">
                            <h5 class="mb-2 text-white" id="yieldPerAreaPlanted">0</h5>
                        </div>
                        <div class="small-title mt-2 text-center">
                            <h6 class="mb-0 text-white">Yield per Area Planted (kg/ha)</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Average Cost per Area Planted Card -->
        <div class="col-md-2 stretch-card" >
            <div class="card custom-card bgma text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="text-center">
                            <h5 class="mb-2 text-white" id="averageCostPerAreaPlanted">0</h5>
                        </div>
                        <div class="small-title mt-2 text-center">
                            <h6 class="mb-0 text-white">Ave. Cost/Area (PHP/ha)</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

      
    </div>
    
    
    
    
 
        <div class="row g-2 align-items-center">
            <!-- First chart (Pie Chart) -->
            {{-- <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="pieChart" width="50px" height="50px"></canvas>
                    </div>
                </div>
            </div>
     --}}
            <!-- Second chart (Bar Chart) -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="pieChart" width="50px" height="50px"></canvas>
                    </div>
                </div>
            </div>
    
            <!-- Third chart (Donut Chart) -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="donutChart" width="50px" height="50px"></canvas>
                    </div>
                </div>
            </div>
    
            <!-- Fourth chart (Line Chart) -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="lineChart" width="50px" height="50px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
{{--  
    
    <canvas id="variableCostChart"></canvas>
    
    <select id="yearFilter"></select>
    <div id="selectedYear"></div>
    <button id="updateChart">Update Chart</button>
     --}}
    <!-- Farmers Table -->
    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Organization</th>
                <th>Contact Number</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody id="farmersTableBody">
            <!-- Farmers data will be dynamically populated here -->
        </tbody>
    </table>
    
    <!-- Pagination Links -->
    <div id="paginationContainer">
        <!-- Pagination links will be dynamically populated here -->
    </div>
    </div> --}}
    {{-- <canvas id="variableCostPieChart" width="400" height="400"></canvas> --}}


</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- jQuery (already included, likely) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            const ctx = document.getElementById('variableCostChart').getContext('2d');
            const variableCostChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // Will be populated with timestamps
                    datasets: [{
                        label: 'Total Variable Cost',
                        data: [], // Will be populated with total variable costs
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Function to fetch and update chart data based on the selected crop, date range, and district
            function fetchDataAndUpdateChart(cropName, dateFrom, dateTo, district) {
                $.ajax({
                    url: '/admin/dashboard',
                    method: 'GET',
                    data: { crop_name: cropName, dateFrom: dateFrom, dateTo: dateTo, district: district },
                    success: function(response) {
                        // Update the total variable cost display
                        const totalVariableCost = response.totalVariableCosts.reduce((sum, cost) => sum + cost, 0);
                        $('#totalVariableCost').text(totalVariableCost.toFixed(2));

                        // Update the chart data with timestamps and total variable costs
                        variableCostChart.data.labels = response.timestamps; // Update labels with created_at timestamps
                        variableCostChart.data.datasets[0].data = response.totalVariableCosts; // Update data with total variable costs
                        variableCostChart.update(); // Re-render the chart
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            }

            // Trigger data fetch when the button is clicked
            $('#updateChart').on('click', function() {
                const selectedDateFrom = $('#dateFrom').val();
                const selectedDateTo = $('#dateTo').val();
                const selectedCropName = $('#cropSelector').val();
                const selectedDistrict = $('#districtSelector').val();
                fetchDataAndUpdateChart(selectedCropName, selectedDateFrom, selectedDateTo, selectedDistrict);
            });
        });
    </script>

    <script>
$(document).ready(function () {
// Initialize chart variables
let pieChart, barChart, donutChart, lineChart;

// Function to format numbers with commas
function formatNumber(number, decimals = 2) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    }).format(number);
}

// Function to fetch data based on selected filters for charts
function fetchData() {
    var cropName = $('#cropName').val();
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    var district = $('#district').val();

    // AJAX request for dashboard data
    $.ajax({
        url: '/admin/dashboard',
        method: 'GET',
        data: {
            crop_name: cropName,
            dateFrom: dateFrom,
            dateTo: dateTo,
            district: district
        },
        success: function (data) {
            // Update metrics
            $('#totalFarms').text(formatNumber(data.totalFarms, 0));
            $('#totalAreaPlanted').text(formatNumber(data.totalAreaPlanted || 0));
            $('#totalAreaYield').text(formatNumber(data.totalAreaYield || 0));
            $('#totalCost').text(formatNumber(data.totalCost || 0, 2));
            $('#yieldPerAreaPlanted').text(formatNumber(data.yieldPerAreaPlanted || 0));
            $('#averageCostPerAreaPlanted').text(formatNumber(data.averageCostPerAreaPlanted || 0));
            $('#totalRiceProduction').text(formatNumber(data.totalRiceProduction || 0, 2));
   
            // Check for chart data and update charts
            if (data.pieChartData) {
                updatePieChart(data.pieChartData);
            }
            if (data.barChartData) {
                updateBarChart(data.barChartData);
            }
            if (data.donutChartData) {
                updateDonutChart(data.donutChartData);
            }
            if (data.lineChartData) {
                updateLineChart(data.lineChartData);
            }

            // Populate farmers' data
            // populateFarmers(data.farmers.data); // Assuming data.farmers is the paginated farmers array
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error fetching data:', textStatus, errorThrown);
            alert('Error fetching data. Please try again.');
        }
    });
}

// Function to populate farmers' data in the table




 

    // Example: Fetch data on filter change (dropdown change or date range change)
    $('#cropName, #district, #dateFrom, #dateTo').change(function () {
        fetchData();
    });

    // // Handle pagination links click event
    // $(document).on('click', '.pagination a', function (e) {
    //     e.preventDefault();
    //     var page = $(this).attr('href').split('page=')[1];
    //     console.log('Clicked page number: ', page);
    //     fetchFarmersData(page);
    // });

    // Initial fetch to display default data
    fetchData();


    
            // Function to update the Pie Chart
       // Function to update the Pie Chart
       function updatePieChart(pieChartData) {
    if (!pieChartData || !pieChartData.labels || !pieChartData.datasets) {
        console.error('Invalid pie chart data:', pieChartData);
        return;
    }

    const ctx = document.getElementById('pieChart').getContext('2d');
    if (typeof pieChart !== 'undefined') {
        pieChart.destroy();
    }

    // Function to capitalize each word in a string
    function capitalizeWords(str) {
        return str.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: pieChartData.labels.map(label => capitalizeWords(label)), // Apply capitalization to labels
            datasets: [{
                data: pieChartData.datasets[0].data,
                backgroundColor: pieChartData.datasets[0].backgroundColor,
                hoverBackgroundColor: pieChartData.datasets[0].hoverBackgroundColor
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 9,
                        padding: 4,
                        font: {
                            size: 10
                        }
                    },
                    maxWidth: 400,
                },
                title: {
                    display: true,
                    text: 'Farmers Yield/District',
                    font: {
                        size: 11
                    },
                    padding: {
                        top: 3,
                        bottom: 3
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const districtName = capitalizeWords(pieChartData.labels[tooltipItem.dataIndex]);
                            return districtName + ': ' + tooltipItem.raw + ' kg';
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 2,
                    bottom: 2
                }
            }
        }
    });
}

function updateBarChart(barChartData) {
    // Check if barChartData is valid
    if (!barChartData || !barChartData.labels || !barChartData.datasets) {
        console.error('Invalid bar chart data:', barChartData);
        return;
    }

    // Log the bar chart data to the console for debugging
    console.log('Bar Chart Data:', barChartData);

    const ctx = document.getElementById('barChart').getContext('2d');

    // Destroy the existing chart if it exists
    if (typeof barChart !== 'undefined') {
        barChart.destroy();
    }

    // Function to capitalize each word in a string
    function capitalizeWords(str) {
        return str.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Define an array of colors for each district
    const colors = ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'];

    // Create a new chart instance
    barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: barChartData.labels.map(label => capitalizeWords(label)), // Apply capitalization to labels
            datasets: barChartData.datasets.map((dataset, index) => ({
                label: capitalizeWords(dataset.label), // Capitalize dataset labels
                data: dataset.data,
                backgroundColor: colors[index % colors.length], // Assign colors based on index
                borderColor: colors[index % colors.length], // Use the same color for border
                borderWidth: 1,
                varieties: dataset.varieties // Include varieties for tooltip display
            }))
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom', // Align legend at the bottom
                    labels: {
                        font: {
                            size: 12, // Adjust font size if needed
                        },
                        boxWidth: 20 // Adjust the size of the color box in the legend
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const dataset = tooltipItem.dataset;
                            const count = dataset.data[tooltipItem.dataIndex];
                            const varieties = dataset.varieties[tooltipItem.dataIndex]; // Get the varieties for this dataset
                            const districtName = capitalizeWords(barChartData.labels[tooltipItem.dataIndex]); // Capitalize district names
                            return `${dataset.label}: ${count} (Varieties: ${varieties}) - District: ${districtName}`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Number of Varieties per Crop and District', // Updated title
                    font: {
                        size: 16, // Title font size
                        weight: 'bold' // Title font weight
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                }
            }
        }
    });
}


function updateDonutChart(donutChartData, centerText, chartTitle) {
    if (!donutChartData || !donutChartData.labels || !donutChartData.datasets) {
        console.error('Invalid donut chart data:', donutChartData);
        return;
    }

    const ctx = document.getElementById('donutChart').getContext('2d');
    if (typeof donutChart !== 'undefined') {
        donutChart.destroy();
    }

    // Function to convert text to title case (capitalize initial letters)
    function capitalizeWords(str) {
        return str.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Custom plugin to add text in the center
    const centerTextPlugin = {
        id: 'centerText',
        afterDatasetsDraw: function(chart) {
            const { width, height } = chart;
            const ctx = chart.ctx;
            const fontSize = (height / 314).toFixed(2);

            ctx.restore();
            ctx.font = `${fontSize}em sans-serif`;
            ctx.textBaseline = 'middle';

            // Add center text
            const textX = Math.round((width - ctx.measureText(centerText).width) / 2);
            const textY = height / 2;

            ctx.fillStyle = '#000'; // Set text color
     
            ctx.save();
        }
    };

    donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: donutChartData.labels.map(label => capitalizeWords(label)), // Capitalize labels
            datasets: [{
                label: 'Crops Production',
                data: donutChartData.datasets[0].data,
                backgroundColor: donutChartData.datasets[0].backgroundColor,
                hoverBackgroundColor: donutChartData.datasets[0].hoverBackgroundColor
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10, // Size of the box next to each legend label
                        padding: 4, // Padding between legend items
                        font: {
                            size: 10 // Font size for legend labels
                        }
                    }
                },
                title: {
                    display: true,
                    text: chartTitle || 'Crops Production',
                    font: {
                        size: 11,
                        weight: 'bold'
                    },
                    padding: {
                        top: 1,
                        bottom: 1
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const cropName = capitalizeWords(donutChartData.labels[tooltipItem.dataIndex]);
                            return cropName + ': ' + tooltipItem.raw + '%';
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 2,
                    bottom: 2
                }
            }
        },
        plugins: [centerTextPlugin] // Include the custom plugin for center text
    });
}




            // Function to update the Line Chart
            function updateLineChart(lineChartData) {
                if (!lineChartData || !lineChartData.labels || !lineChartData.datasets) {
                    console.error('Invalid line chart data:', lineChartData);
                    return;
                }
    
                const ctx = document.getElementById('lineChart').getContext('2d');
                if (typeof lineChart !== 'undefined') {
                    lineChart.destroy();
                }
    
                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: lineChartData.labels,
                        datasets: lineChartData.datasets.map((dataset, index) => ({
                            label: dataset.label,
                            data: dataset.data,
                            borderColor: dataset.borderColor || 'rgba(75, 192, 192, 1)',
                            backgroundColor: dataset.backgroundColor || 'rgba(75, 192, 192, 0.2)',
                            fill: true
                        }))
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
    
            $(document).ready(function () {
    $('#printButton').click(function () {
        printReport();
    });
});
function printReport() {
    // Get content of the charts
    const pieChartContent = document.getElementById('pieChart').toDataURL(); // Get chart image as data URL
    const barChartContent = document.getElementById('barChart').toDataURL();
    const donutChartContent = document.getElementById('donutChart').toDataURL();
    const lineChartContent = document.getElementById('lineChart').toDataURL();

    // Dynamic data (Farmer name, Signature)
    const farmerName = "John Doe"; // Replace with dynamic data
    const signContent = "<img src='../assets/logo/Citylogo.jpg' style='width: 100px;' alt='Signature'/>"; // Update path to the actual image
    const CityLogoContent = "<img src='../assets/logo/agriculture.jpg' style='width: 100px;' alt='Signature'/>"; // Update path to the actual image
    const totalFarms = document.getElementById('totalFarms').innerText; // Fetch total farms value dynamically
    const totalAreaPlanted = document.getElementById('totalAreaPlanted').innerText; // Fetch total area planted value dynamically
    const totalAreaYield = document.getElementById('totalAreaYield').innerText; // Fetch total area yield value dynamically
    const totalCost = document.getElementById('totalCost').innerText; // Fetch total cost value dynamically
    const yieldPerAreaPlanted = document.getElementById('yieldPerAreaPlanted').innerText; // Fetch yield per area planted value dynamically
    const averageCostPerAreaPlanted = document.getElementById('averageCostPerAreaPlanted').innerText; // Fetch average cost per area planted value dynamically

    // Open a new window for the printable report
    const win = window.open('', '', 'height=900,width=1200');
    
    // Write HTML and styles to the new window
    win.document.write('<html><head><title>Agrimap Report</title>');
    win.document.write(`
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                background-color: #f4f4f4;
                color: black; /* Set default font color to black */
            }
            .report-container {
                max-width: 800px;
                margin: 20px auto;
                background: white;
                padding: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;

            }
               h2 {
                text-align: center;
                margin-top: 2px;
                margin-bottom: 110px;
                font-size:15px;
            }
            h1 {
                text-align: center;
                margin-top: 20px;
                margin-bottom: 3px;
                font-size:15px;
            }
            .results-container {
                margin-bottom: 40px;
                display: flex;
                justify-content: center;
                
                flex-wrap: wrap; /* Allows cards to wrap in case of narrow screens */
            }
            .card.custom-card {
                color: black; /* Default color for card text */
                width: 200px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
                margin: 10px;
            }
            .card-body {
                padding: 20px;
                text-align: center;
            }
            .chart-container {
                margin-bottom: 50px;
                page-break-after: auto;
            }
            .signature {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 0;
            }
            .signature img {
                height: 100px;
            }
            .signature h3 {
                margin: 0;
            }
            .chart-image {
                margin: 10px auto;
                display: block;
                width: 400px;
            }
           
        </style>
    `);
    win.document.write('</head><body>');

    // Centering content in a card-like structure
    win.document.write('<div class="report-container">');
    
// Signature and header
win.document.write(`
    <div class="signature" style="display: flex; justify-content: space-between; align-items: center;">

        ${signContent}
        <div style="text-align: center; margin-top: 20px;">
        <h1>Office of City Agriculture</h1>
        <h2>Zamboanga City</h2>
    </div>
        <h3 style="margin: 0;"> ${CityLogoContent}</h3>
    </div>
`);
// </div>
//         <h3 style="margin: 0;">Date: ${new Date().toLocaleDateString()}</h3>
//     </div>
// // Centering the Report Title and Farmer's Name
// win.document.write(`
//     <div style="text-align: center; margin-top: 20px;">
//         <h1>Agrimap Report</h1>
//         <h2>Farmer: ${farmerName}</h2>
//     </div>
// `);

    
    // Results section with cards
    win.document.write(`
        <div class="results-container">
            <!-- Total Farms Card -->
            <div class="col-md-2 stretch-card">
                <div class="card custom-card bg">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="text-center">
                                <h5 class="mb-2" id="printTotalFarms">${totalFarms}</h5>
                            </div>
                            <div class="small-title mt-2 text-center">
                                <h6 class="mb-0">Total Farms</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Area Planted Card -->
            <div class="col-md-2 stretch-card">
                <div class="card custom-card bgma">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="text-center">
                                <h5 class="mb-2" id="printTotalAreaPlanted">${totalAreaPlanted}</h5>
                            </div>
                            <div class="small-title mt-2 text-center">
                                <h6 class="mb-0">Total Area Planted (ha)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Area Yield Card -->
            <div class="col-md-2 stretch-card">
                <div class="card custom-card backg">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="text-center">
                                <h5 class="mb-2" id="printTotalAreaYield">${totalAreaYield}</h5>
                            </div>
                            <div class="small-title mt-2 text-center">
                                <h6 class="mb-0">Total Area Yield (kg)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Cost Card -->
            <div class="col-md-2 stretch-card">
                <div class="card custom-card bgnew">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="text-center">
                                <h5 class="mb-2" id="printTotalCost">${totalCost}</h5>
                            </div>
                            <div class="small-title mt-2 text-center">
                                <h6 class="mb-0">Total Cost (PHP)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yield per Area Planted Card -->
            <div class="col-md-2 stretch-card">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="text-center">
                                <h5 class="mb-2" id="printYieldPerAreaPlanted">${yieldPerAreaPlanted}</h5>
                            </div>
                            <div class="small-title mt-2 text-center">
                                <h6 class="mb-0">Yield per Area Planted (kg/ha)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Cost per Area Planted Card -->
            <div class="col-md-2 stretch-card">
                <div class="card custom-card bgma">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="text-center">
                                <h5 class="mb-2" id="printAverageCostPerAreaPlanted">${averageCostPerAreaPlanted}</h5>
                            </div>
                            <div class="small-title mt-2 text-center">
                                <h6 class="mb-0">Ave. Cost/Area (PHP/ha)</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);

    // Charts section
    win.document.write('<h2></h2>');

    // Pie Chart
    win.document.write(`
        <div class="chart-container">
          
            <img src="${pieChartContent}" class="chart-image">
        </div>
    `);

    // Bar Chart
    win.document.write(`
        <div class="chart-container">
            
            <img src="${barChartContent}" class="chart-image">
        </div>
    `);

    // Donut Chart
    win.document.write(`
        <div class="chart-container">
      
            <img src="${donutChartContent}" class="chart-image">
        </div>
    `);

    // Line Chart
    win.document.write(`
        <div class="chart-container">
           
            <img src="${lineChartContent}" class="chart-image">
        </div>
    `);

    win.document.write('</div>'); // End of report-container
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}

        });


        function openFarmersModal() {
        // Logic to fetch and display farmers data in the modal
        $('#farmersModal').modal('show');
    }









    </script>

<script>
function openAreaPlantedModal(title) {
    $('#areaPlantedModal').modal('show');

    // You can also set the modal title if needed
    $('#areaPlantedModalLabel').text(title);

    // Initialize the chart when the modal opens
    initializeAreaPlantedChart();
}

let areaPlantedChart;

function initializeAreaPlantedChart() {
    if (areaPlantedChart) {
        areaPlantedChart.destroy(); // Destroy previous instance if it exists
    }

    // Example data, replace with your actual data fetching logic
    const data = {
        labels: ['District 1', 'District 2', 'District 3'], // Example labels
        datasets: [{
            label: 'Area Planted (ha)',
            data: [5, 10, 15], // Example data
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    const ctx = document.getElementById('areaPlantedChart').getContext('2d');
    areaPlantedChart = new Chart(ctx, {
        type: 'bar', // Change to 'pie' if needed
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
}

// Optional: Add event listener for modal close to reset or clean up
$('#areaPlantedModal').on('hidden.bs.modal', function () {
    if (areaPlantedChart) {
        areaPlantedChart.destroy(); // Clean up on close
    }
});
</script>


<script>
    $(document).ready(function() {
    $('#viewFarmersBtn').on('click', function() {
        // Get the selected district from your UI
        const selectedDistrict = $('#districtSelect').val();

        if (!selectedDistrict) {
            alert('Please select a district to view farmers.');
            return; // Stop if no district is selected
        }

        // Make the AJAX request to the Laravel route
        $.ajax({
            url: '/admin/dashboard', // Update this with the correct route
            method: 'GET',
            data: { district: selectedDistrict }, // Send the selected district
            success: function(data) {
                console.log(data); // Log the response to see the structure
                
                // Check if data is returned successfully
                if (data) {
                    // Populate the farmers table body
                    let farmersTableBody = $('#farmersTableBody');
                    let paginationContainer = $('#pagination');
                    
                    farmersTableBody.empty(); // Clear previous data
                    paginationContainer.empty(); // Clear previous pagination

                    // Populate the table with paginated data
                    data.farmers.data.forEach(function(farmer) {
                        // Join crop names into a single string
                        const cropNames = farmer.crops.length > 0 ? farmer.crops.join(', ') : 'N/A'; // Handle no crops
                        farmersTableBody.append(`
                            <tr>
                                <td>${farmer.first_name}</td>
                                <td>${farmer.last_name}</td>
                                <td>${farmer.organization}</td>
                                <td>${farmer.district}</td>
                                <td>${cropNames}</td> <!-- Display Crop Names -->
                            </tr>
                        `);
                    });

                    // Handle pagination links
                    if (data.farmers.last_page > 1) {
                        for (let i = 1; i <= data.farmers.last_page; i++) {
                            paginationContainer.append(`
                                <button class="btn btn-outline-primary mx-1 pagination-btn" data-page="${i}">${i}</button>
                            `);
                        }
                    }

                    // Attach click handler for pagination buttons
                    $('.pagination-btn').on('click', function() {
                        let page = $(this).data('page');
                        $.ajax({
                            url: '/admin/dashboard', // Update this with the correct route
                            method: 'GET',
                            data: { district: selectedDistrict, page: page },
                            success: function(newData) {
                                farmersTableBody.empty(); // Clear previous data
                                newData.farmers.data.forEach(function(farmer) {
                                    const cropNames = farmer.crops.length > 0 ? farmer.crops.join(', ') : 'N/A'; // Handle no crops
                                    farmersTableBody.append(`
                                        <tr>
                                            <td>${farmer.first_name}</td>
                                            <td>${farmer.last_name}</td>
                                            <td>${farmer.organization}</td>
                                            <td>${farmer.district}</td>
                                            <td>${cropNames}</td> <!-- Display Crop Names -->
                                        </tr>
                                    `);
                                });
                            },
                            error: function() {
                                // Handle error
                                alert('Failed to fetch farmer data for the selected page.');
                            }
                        });
                    });

                    // Show the modal
                    $('#farmerInfoModal').modal('show');

                    // Display districts if needed (optional)
                    let districtsSelect = $('#districtsSelect'); // Update with your districts dropdown selector
                    districtsSelect.empty(); // Clear existing options
                    data.districts.forEach(function(district) {
                        districtsSelect.append(`<option value="${district.id}">${district.district}</option>`);
                    });
                }
            },
            error: function() {
                // Handle error
                alert('Failed to fetch farmer data.');
            }
        });
    });
});

</script>



<script>
$(document).ready(function () {
    // Event listener for opening the modal
    $('#farmerInfoModal').on('show.bs.modal', function () {
        fetchFarmers(); // Fetch farmers data when the modal is shown
    });

    // Function to fetch farmers data
    function fetchFarmers(page = 1) {
        $.ajax({
            url: '/admin/dashboard', // Replace with your actual API endpoint
            method: 'GET',
            data: {
                page: page // Pass the page number to fetch
            },
            success: function (data) {
                // Update the farmers table and pagination links
                $('#farmersTableBody').html(data.farmersTable); // Update table body
                $('#paginationContainer').html(data.paginationLinks); // Update pagination
            },
            error: function (error) {
                console.error('Error fetching farmers:', error);
                alert('An error occurred while fetching farmers data. Please try again.');
            }
        });
    }

    // Function to handle pagination button clicks
    $(document).on('click', '.page-link', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        const page = $(this).data('page'); // Get the page number from data attribute
        fetchFarmers(page); // Fetch farmers for the clicked page
    });
});
$(document).ready(function() {
    // Function to fetch and display the pie chart
    function fetchAndDisplayChart() {
        $.ajax({
            url: '/admin/dashboard', // Adjust to your Laravel route
            method: 'GET', // or 'POST' depending on your route method
            dataType: 'json',
            success: function(response) {
                // Prepare data for the pie chart
                const districtNames = response.totalAreaPlantedByDistrict.map(d => d.district);
                const totalAreas = response.totalAreaPlantedByDistrict.map(d => d.total_area_planted);

                // Create the pie chart
                const ctx = document.getElementById('districtsPieChart').getContext('2d');
                const pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: districtNames,
                        datasets: [{
                            label: 'Total Area Planted by District',
                            data: totalAreas,
                            backgroundColor: ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
                            borderColor: ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' hectares';
                                    }
                                }
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
                // Optionally handle errors here
            }
        });
    }

    // Call the function on page load
    fetchAndDisplayChart();
});


$(document).ready(function() {
    // Fetch and display farm distribution
    fetchFarmDistribution();

    function fetchFarmDistribution(selectedDistrict = null) {
        $.ajax({
            url: '/admin/dashboard', // Adjust to your Laravel route
            method: 'GET',
            data: {
                selected_district: selectedDistrict
              
            },
            dataType: 'json',
            success: function(response) {
                // Check if distributionFrequency exists in the response
                if (response.distributionFrequency) {
                    // Handle the distribution frequency for the pie chart
                    const labels = Object.keys(response.distributionFrequency);
                    const dataValues = Object.values(response.distributionFrequency);

                    // Create the pie chart
                    renderPieChart(labels, dataValues);
                } else {
                    console.error('No distribution frequency found in response:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error, xhr.responseText); // Improved error handling
            }
        });
    }

    function renderPieChart(labels, dataValues) {
        const ctx = document.getElementById('FarmPERDISTRICTS').getContext('2d');

        // Destroy previous chart instance if it exists
        if (window.farmPerDistrictChart) {
            window.farmPerDistrictChart.destroy();
        }

        window.farmPerDistrictChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Farms by District',
                    data: dataValues,
                    backgroundColor: ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
                    borderColor: ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' farms';
                            }
                        }
                    }
                }
            }
        });
    }
});



    // This function will be called when the modal opens

</script>



<script>
// $(document).ready(function() {
//     // Event listener for modal show
//     $('#totalCostModal').on('show.bs.modal', function() {
//         console.log('Total Cost Modal is about to be shown. Fetching data...'); // Log when the modal is opened
//         fetchTotalCostsByDistrict(); // Call the function to fetch total costs
//     });

//     function fetchTotalCostsByDistrict() {
//         $.ajax({
//             url: '/admin/dashboard', // Adjust to your Laravel route
//             method: 'GET',
//             dataType: 'json',
//             success: function(data) {
//                 console.log('Data fetched successfully:', data); // Log the data received from the server
                
//                 // Check if data exists
//                 if (data.length > 0) {
//                     // Prepare data for the pie chart
//                     const labels = data.map(item => item.district_name);
//                     const totalCosts = data.map(item => item.total_cost);
                    
//                     // Update total cost card
//                     const totalCostSum = totalCosts.reduce((a, b) => a + b, 0); // Calculate total cost
//                     $('#totalCost').text(totalCostSum); // Display total cost in the modal

//                     // Create the pie chart
//                     renderPieChart(labels, totalCosts);
//                 } else {
//                     console.error('No data available for total costs.');
//                     $('#totalCost').text(0); // Update total cost card to 0 if no data
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error('AJAX Error:', status, error, xhr.responseText); // Improved error handling
//             }
//         });
//     }

//     function renderPieChart(labels, dataValues) {
//         const ctx = document.getElementById('pieChartTotalCost').getContext('2d');

//         // Destroy previous chart instance if it exists
//         if (window.pieChart) {
//             window.pieChart.destroy();
//             console.log('Previous pie chart instance destroyed.'); // Log the destruction of the previous chart
//         }

//         window.pieChart = new Chart(ctx, {
//             type: 'pie',
//             data: {
//                 labels: labels,
//                 datasets: [{
//                     label: 'Total Variable Cost by District',
//                     data: dataValues,
//                     backgroundColor: [
//                         'rgba(255, 99, 132, 0.6)',
//                         'rgba(54, 162, 235, 0.6)',
//                         'rgba(255, 206, 86, 0.6)',
//                         'rgba(75, 192, 192, 0.6)',
//                         'rgba(153, 102, 255, 0.6)',
//                         'rgba(255, 159, 64, 0.6)'
//                     ],
//                     borderColor: 'rgba(0, 0, 0, 1)',
//                     borderWidth: 1
//                 }]
//             },
//             options: {
//                 responsive: true,
//                 plugins: {
//                     legend: {
//                         position: 'top',
//                     },
//                     title: {
//                         display: true,
//                         text: 'Total Variable Cost by District'
//                     }
//                 }
//             }
//         });
//         console.log('Pie chart created successfully.'); // Log the successful creation of the pie chart
//     }
// });
$(document).ready(function () {
    // Function to format numbers with commas
    function formatNumber(number, decimals = 2) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        }).format(number);
    }

    // Function to fetch total cost data based on crop name and district
    function fetchTotalCost(cropName, district) {
        $.ajax({
            url: '/admin/dashboard', // Update with your actual endpoint
            method: 'GET',
            data: {
                crop_name: cropName,
                district: district
            },
            success: function (data) {
                // Populate the modal with fetched data
                $('#modalTotalCost').text(formatNumber(data.totalCost || 0, 2));
                $('#modalCostDetails').text(data.details || 'No additional details available.');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching total cost data:', textStatus, errorThrown);
                $('#modalCostDetails').text('Error loading details. Please try again.');
            }
        });
    }

    // Event listener for the Total Cost card
    $('#totalCostCard').on('click', function () {
        var cropName = $('#cropName').val(); // Get the selected crop name
        var district = $('#district').val(); // Get the selected district

        // Fetch the total cost data based on selected crop name and district
        fetchTotalCost(cropName, district); 

        $('#totalCostModal').modal('show'); // Show the modal
    });

    // Existing fetchData function...
});




    </script>
    
    <script>

$(document).ready(function() {
    // Declare lineChart variable outside of the function
    let lineChart; // Declare lineChart to keep track of the Chart.js instance

    // Function to fetch data based on selected filters
    function fetchData() {
        const selectedCropName = $('#cropName').val(); // Get selected crop name
        const selectedDistrict = $('#district').val(); // Get selected district
        const selectedDateFrom = $('#dateFrom').val(); // Get selected date from
        const selectedDateTo = $('#dateTo').val(); // Get selected date to

        $.ajax({
            url: '/admin/dashboard', // URL of the API endpoint
            type: 'GET',
            dataType: 'json',
            data: {
                crop_name: selectedCropName,
                district: selectedDistrict,
                date_from: selectedDateFrom,
                date_to: selectedDateTo
            },
            success: function(response) {
                // Ensure the response has the expected data
                if (response.years && response.totalCosts) {
                    const years = response.years; // Get the years array from the response
                    const totalCosts = response.totalCosts; // Get the total costs array from the response

                    // Get the canvas context for the chart
                    const ctx = document.getElementById('TotalCost').getContext('2d'); // Fixed line

                    // Destroy the previous chart instance if it exists
                    if (lineChart) {
                        lineChart.destroy();
                    }

                    // Create a new chart instance
                    lineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: years, // X-axis labels (years)
                            datasets: [{
                                label: 'Total Variable Cost',
                                data: totalCosts, // Y-axis data (total costs)
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total Cost'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Year'
                                    }
                                }
                            }
                        }
                    });
                } else {
                    console.error('Unexpected response format:', response);
                }
            },
            error: function(xhr, status, error) {
                // Improved error logging
                console.error('AJAX Error:', status, error);
                console.error('Response:', xhr.responseText);
                alert('An error occurred while loading data. Please try again later.'); // Alert the user
            }
        });
    }

    // Call fetchData on page load
    fetchData();

    // Event listeners for dropdown and date input changes
    $('#cropName, #district, #dateFrom, #dateTo').on('change', function() {
        fetchData(); // Fetch new data when a filter changes
    });
});


        </script>
        




@endsection