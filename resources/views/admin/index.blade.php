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
                    <option value="{{ $crop }}">{{ $crop }}</option>
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
                    <option value="{{ $district }}">{{ $district }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-2">
            <label class="form-label" style="visibility: hidden;">Print Reports</label> <!-- Invisible label to match alignment -->
            <button id="printButton" class="btn btn-primary w-100">Print Reports</button>
        </div>
    </div>
    
    
    <div id="results" class="row g-2 mt-4">
        <!-- Total Farms Card -->
        <div class="col-md-2 stretch-card" onclick="openCostModal('Total Farms')">
            <div class="card custom-card bg text-white mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="text-center">
                            <h5 class="mb-2 text-white" id="totalFarms">0</h5>
                        </div>
                        <div class="small-title mt-2 text-center">
                            <h6 class="mb-0 text-white">Total Farms</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Total Area Planted Card -->
        <div class="col-md-2 stretch-card" onclick="openCostModal('Total Area Planted')">
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
    
        <!-- Total Area Yield Card -->
        <div class="col-md-2 stretch-card" onclick="openCostModal('Total Area Yield')">
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
    
        <!-- Total Cost Card -->
        <div class="col-md-2 stretch-card" onclick="openCostModal('Total Cost')">
            <div class="card custom-card bg-danger text-white mb-3">
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
    
        <!-- Yield per Area Planted Card -->
        <div class="col-md-2 stretch-card" onclick="openCostModal('Yield per Area Planted')">
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
        <div class="col-md-2 stretch-card" onclick="openCostModal('Average Cost per Area Planted')">
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
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="pieChart" width="500" height="400"></canvas>
                    </div>
                </div>
            </div>
    
            <!-- Second chart (Bar Chart) -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="barChart" width="500" height="500"></canvas>
                    </div>
                </div>
            </div>
    
            <!-- Third chart (Donut Chart) -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="donutChart" width="500" height="400"></canvas>
                    </div>
                </div>
            </div>
    
            <!-- Fourth chart (Line Chart) -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="lineChart" width="500" height="500"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        $(document).ready(function() {
            let pieChart;
            let barChart;
            let donutChart;
            let lineChart; // Initialize the line chart variable
    
            function formatNumber(number, decimals = 2) {
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }).format(number);
            }
    
            // Function to fetch data based on selected filters
            function fetchData() {
                // Get the filter values
                var cropName = $('#cropName').val();
                var dateFrom = $('#dateFrom').val();
                var dateTo = $('#dateTo').val();
                var district = $('#district').val();
    
                // Make an AJAX request
                $.ajax({
                    url: '/admin/dashboard',
                    method: 'GET',
                    data: {
                        crop_name: cropName,
                        dateFrom: dateFrom,
                        dateTo: dateTo,
                        district: district
                    },
                    success: function(data) {
                        // Update the results section with the response data
                        $('#totalFarms').text(formatNumber(data.totalFarms, 0)); // No decimals for total farms
                        $('#totalAreaPlanted').text(formatNumber(data.totalAreaPlanted)); // 2 decimals for area planted
                        $('#totalAreaYield').text(formatNumber(data.totalAreaYield)); // 2 decimals for yield
                        $('#totalCost').text(formatNumber(data.totalCost, 2)); // 2 decimals for cost
                        $('#yieldPerAreaPlanted').text(formatNumber(data.yieldPerAreaPlanted)); // 2 decimals for yield per area
                        $('#averageCostPerAreaPlanted').text(formatNumber(data.averageCostPerAreaPlanted)); // 2 decimals for cost per area
                        $('#totalRiceProduction').text(formatNumber(data.totalRiceProduction, 2)); // 2 decimals for rice production
    
                        // Update charts
                        updatePieChart(data.pieChartData);
                        updateBarChart(data.barChartData);
                        updateDonutChart(data.donutChartData);
                        updateLineChart(data.lineChartData); // Update the line chart with received data
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching data:', textStatus, errorThrown);
                    }
                });
            }
    
            // Trigger data fetch on change of dropdowns or date inputs
            $('#cropName, #district, #dateFrom, #dateTo').change(function() {
                fetchData();
            });
    
            // Initial fetch to display default data
            fetchData();
    
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
    
                pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: pieChartData.labels,
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
                                position: 'bottom', // Position legends at the bottom
                                labels: {
                                    boxWidth: 20, // Width of the color box in the legend
                                    font: {
                                        size: 14 // Font size for the legend labels
                                    }
                                }
                            },
                            title: {
                                display: true, // Display the title
                                text: 'Farmers Yield/District', // Title text
                                font: {
                                    size: 16 // Font size for the title
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

            // Define an array of colors for each district
            const colors = ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'];

            // Create a new chart instance
            barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: barChartData.labels,
                    datasets: barChartData.datasets.map((dataset, index) => ({
                        label: dataset.label,
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
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const dataset = tooltipItem.dataset;
                                    const count = dataset.data[tooltipItem.dataIndex];
                                    const varieties = dataset.varieties[tooltipItem.dataIndex]; // Get the varieties for this dataset
                                    return `${dataset.label}: ${count} (Varieties: ${varieties})`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Varieties per Crop and District', // Updated title
                        }
                    }
                }
            });
        }

          // Function to update the Donut Chart
function updateDonutChart(donutChartData, centerText) {
    if (!donutChartData || !donutChartData.labels || !donutChartData.datasets) {
        console.error('Invalid donut chart data:', donutChartData);
        return;
    }

    const ctx = document.getElementById('donutChart').getContext('2d');
    if (typeof donutChart !== 'undefined') {
        donutChart.destroy();
    }

    // Custom plugin to add text in the center
    const centerTextPlugin = {
        id: 'centerText',
        afterDatasetsDraw: function(chart) {
            const { width, height } = chart;
            const ctx = chart.ctx;
            const fontSize = (height /314).toFixed(2);

            ctx.restore();
            ctx.font = `${fontSize}em sans-serif`;
            ctx.textBaseline = 'middle';

            const text = centerText || 'Crops Production'; // Text for the center
            const textX = Math.round((width - ctx.measureText(text).width) / 2);
            const textY = height / 2;

            ctx.fillStyle = '#000'; // Set text color
            ctx.fillText(text, textX, textY);
            ctx.save();
        }
    };

    donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: donutChartData.labels,
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
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                        }
                    }
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
    
            // Print function
$('#printButton').click(function() {
    printReport();
});

function printReport() {
    const resultsContent = document.getElementById('results').innerHTML;
    const pieChartContent = document.getElementById('pieChart').toDataURL(); // Get chart image as data URL
    const barChartContent = document.getElementById('barChart').toDataURL();
    const donutChartContent = document.getElementById('donutChart').toDataURL();
    const lineChartContent = document.getElementById('lineChart').toDataURL();

    const farmerName = "John Doe"; // Replace with dynamic name if needed
    const signContent = "<img src='../assets/logo/logo.png' style='width: 100px;' alt='Signature'/>"; // Update path to the actual image

    const win = window.open('', '', 'height=600,width=800');
    win.document.write('<html><head><title>Report</title>');
    win.document.write('<style>body { font-family: Arial, sans-serif; text-align: center; } h1 { margin-bottom: 20px; } h2 { margin-top: 40px; } </style>');
    win.document.write('</head><body>');
    win.document.write('<div style="text-align: left; padding: 20px;">' + signContent + '</div>'); // Signature at top left
    win.document.write('<h1>Agrimap Report</h1>');
    win.document.write('<h2 style="margin-bottom: 40px;">Farmer: ' + farmerName + '</h2>'); // Farmer's name in the middle
    win.document.write('<div>' + resultsContent + '</div>');
    win.document.write('<h2>Charts</h2>');
    win.document.write('<h3>Pie Chart</h3><img src="' + pieChartContent + '" width="400"><br>');
    win.document.write('<h3>Bar Chart</h3><img src="' + barChartContent + '" width="400"><br>');
    win.document.write('<h3>Donut Chart</h3><img src="' + donutChartContent + '" width="400"><br>');
    win.document.write('<h3>Line Chart</h3><img src="' + lineChartContent + '" width="400"><br>');
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}

        });
    </script>
      
@endsection