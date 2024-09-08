<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>Admin- AgriMap</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

  <!-- End fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- core:css -->	
<!-- core:css -->
<link rel="stylesheet" href="../assets/vendors/core/core.css">
<!-- endinject -->
<!-- Include Bootstrap CSS -->
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"> --}}

<!-- Plugin css for this page -->
<link rel="stylesheet" href="../assets/vendors/flatpickr/flatpickr.min.css">
<!-- End plugin css for this page -->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}


<!-- inject:css -->
<link rel="stylesheet" href="../assets/fonts/feather-font/css/iconfont.css">
<link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
{{-- <link rel="stylesheet" href="../assets/vendors/font-awesome/css/flag-icon.min.css"> --}}
<!-- endinject -->

<!-- Layout styles -->  
<link rel="stylesheet" href="../assets/css/demo2/style.css">
<!-- End layout styles -->
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="shortcut icon" href="../assets/logo/logo.png" />
{{-- <link rel="shortcut icon" href="https://www.flaticon.com/free-icons/agriculture" /> --}}


</head>
<body>
	<div class="main-wrapper">

		<!-- partial:partials/_sidebar.html -->
	   @include('admin.body.sidebar')
   
		<!-- partial -->
        {{-- <nav class="settings-sidebar">
            <div class="sidebar-body">
             
              </a>
              <div class="theme-wrapper">
                
                </a>
              </div>
            </div>
          </nav> --}}
	
		<div class="page-wrapper">
					
			<!-- partial:partials/_navbar.html -->
		@include('admin.body.header')
			<!-- partial -->

            @yield('admin')
			
			<!-- partial:partials/_footer.html -->
		{{-- @include('admin.body.footer') --}}
			<!-- partial -->
		
		</div>
	</div>

	<!-- core:js -->
	<script src="../assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
  <script src="../assets/vendors/flatpickr/flatpickr.min.js"></script>
  
  <script src="../assets/vendors/apexcharts/apexcharts.min.js"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="../assets/vendors/feather-icons/feather.min.js"></script>
	
	<script src="../assets/js/template.js"></script>
	<!-- endinject -->
<!-- Include jQuery (optional but recommended for Bootstrap 5 collapse) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS -->
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script> --}}

<script>
    $(document).ready(function() {
      $('#croprice .collapse').on('shown.bs.collapse', function () {
      $(this).prev('.nav-link').addClass('active');
      }).on('hidden.bs.collapse', function () {
      $(this).prev('.nav-link').removeClass('active');
      });
    
      $('#croprice').on('shown.bs.collapse', function () {
      // Prevent adding active class to the "Rice" link
      $('a[href="#croprice"]').removeClass('active');
      });
    });
    </script>

<script>
  $(document).ready(function() {
    $('#chicken .collapse').on('shown.bs.collapse', function () {
    $(this).prev('.nav-link').addClass('active');
    }).on('hidden.bs.collapse', function () {
    $(this).prev('.nav-link').removeClass('active');
    });
  
    $('#chicken').on('shown.bs.collapse', function () {
    // Prevent adding active class to the "Rice" link
    $('a[href="#chicken"]').removeClass('active');
    });
  });
  </script>

  

	<!-- Custom js for this page -->
    {{-- <script src="../assets/js/dashboard-light.js"></script> --}}
	<script>
		$(function() {
		   'use strict'
	   
	   
	   
		   var colors = {
			   primary: "#6571ff",
			   secondary: "#7987a1",
			   success: "#05a34a",
			   info: "#66d1d1",
			   warning: "#fbbc06",
			   danger: "#ff3366",
			   light: "#e9ecef",
			   dark: "#060c17",
			   muted: "#7987a1",
			   gridBorder: "rgba(77, 138, 240, .15)",
			   bodyColor: "#000",
			   cardBg: "#fff"
		   }
	   
		   var fontFamily = "'Roboto', Helvetica, sans-serif"
	   
		   var revenueChartData = [
			   49.33,
			   48.79,
			   50.61,
			   53.31,
			   54.78,
			   53.84,
			   54.68,
			   56.74,
			   56.99,
			   56.14,
			   56.56,
			   60.35,
			   58.74,
			   61.44,
			   61.11,
			   58.57,
			   54.72,
			   52.07,
			   51.09,
			   47.48,
			   48.57,
			   48.99,
			   53.58,
			   50.28,
			   46.24,
			   48.61,
			   51.75,
			   51.34,
			   50.21,
			   54.65,
			   52.44,
			   53.06,
			   57.07,
			   52.97,
			   48.72,
			   52.69,
			   53.59,
			   58.52,
			   55.10,
			   58.05,
			   61.35,
			   57.74,
			   60.27,
			   61.00,
			   57.78,
			   56.80,
			   58.90,
			   62.45,
			   58.75,
			   58.40,
			   56.74,
			   52.76,
			   52.30,
			   50.56,
			   55.40,
			   50.49,
			   52.49,
			   48.79,
			   47.46,
			   43.31,
			   38.96,
			   34.73,
			   31.03,
			   32.63,
			   36.89,
			   35.89,
			   32.74,
			   33.20,
			   30.82,
			   28.64,
			   28.44,
			   27.73,
			   27.75,
			   25.96,
			   24.38,
			   21.95,
			   22.08,
			   23.54,
			   27.30,
			   30.27,
			   27.25,
			   29.92,
			   25.14,
			   23.09,
			   23.79,
			   23.46,
			   27.99,
			   23.21,
			   23.91,
			   19.21,
			   15.13,
			   15.08,
			   11.00,
			   9.20,
			   7.47,
			   11.64,
			   15.76,
			   13.99,
			   12.59,
			   13.53,
			   15.01,
			   13.95,
			   13.23,
			   18.10,
			   20.63,
			   21.06,
			   25.37,
			   25.32,
			   20.94,
			   18.75,
			   15.38,
			   14.56,
			   17.94,
			   15.96,
			   16.35,
			   14.16,
			   12.10,
			   14.84,
			   17.24,
			   17.79,
			   14.03,
			   18.65,
			   18.46,
			   22.68,
			   25.08,
			   28.18,
			   28.03,
			   24.11,
			   24.28,
			   28.23,
			   26.24,
			   29.33,
			   26.07,
			   23.92,
			   28.82,
			   25.14,
			   21.79,
			   23.05,
			   20.71,
			   29.72,
			   30.21,
			   32.56,
			   31.46,
			   33.69,
			   30.05,
			   34.20,
			   36.93,
			   35.50,
			   34.78,
			   36.97
		   ];
	   
		   var revenueChartCategories = [
			   "Jan 01 2022", "Jan 02 2022", "jan 03 2022", "Jan 04 2022", "Jan 05 2022", "Jan 06 2022", "Jan 07 2022", "Jan 08 2022", "Jan 09 2022", "Jan 10 2022", "Jan 11 2022", "Jan 12 2022", "Jan 13 2022", "Jan 14 2022", "Jan 15 2022", "Jan 16 2022", "Jan 17 2022", "Jan 18 2022", "Jan 19 2022", "Jan 20 2022", "Jan 21 2022", "Jan 22 2022", "Jan 23 2022", "Jan 24 2022", "Jan 25 2022", "Jan 26 2022", "Jan 27 2022", "Jan 28 2022", "Jan 29 2022", "Jan 30 2022", "Jan 31 2022",
			   "Feb 01 2022", "Feb 02 2022", "Feb 03 2022", "Feb 04 2022", "Feb 05 2022", "Feb 06 2022", "Feb 07 2022", "Feb 08 2022", "Feb 09 2022", "Feb 10 2022", "Feb 11 2022", "Feb 12 2022", "Feb 13 2022", "Feb 14 2022", "Feb 15 2022", "Feb 16 2022", "Feb 17 2022", "Feb 18 2022", "Feb 19 2022", "Feb 20 2022", "Feb 21 2022", "Feb 22 2022", "Feb 23 2022", "Feb 24 2022", "Feb 25 2022", "Feb 26 2022", "Feb 27 2022", "Feb 28 2022",
			   "Mar 01 2022", "Mar 02 2022", "Mar 03 2022", "Mar 04 2022", "Mar 05 2022", "Mar 06 2022", "Mar 07 2022", "Mar 08 2022", "Mar 09 2022", "Mar 10 2022", "Mar 11 2022", "Mar 12 2022", "Mar 13 2022", "Mar 14 2022", "Mar 15 2022", "Mar 16 2022", "Mar 17 2022", "Mar 18 2022", "Mar 19 2022", "Mar 20 2022", "Mar 21 2022", "Mar 22 2022", "Mar 23 2022", "Mar 24 2022", "Mar 25 2022", "Mar 26 2022", "Mar 27 2022", "Mar 28 2022", "Mar 29 2022", "Mar 30 2022", "Mar 31 2022",
			   "Apr 01 2022", "Apr 02 2022", "Apr 03 2022", "Apr 04 2022", "Apr 05 2022", "Apr 06 2022", "Apr 07 2022", "Apr 08 2022", "Apr 09 2022", "Apr 10 2022", "Apr 11 2022", "Apr 12 2022", "Apr 13 2022", "Apr 14 2022", "Apr 15 2022", "Apr 16 2022", "Apr 17 2022", "Apr 18 2022", "Apr 19 2022", "Apr 20 2022", "Apr 21 2022", "Apr 22 2022", "Apr 23 2022", "Apr 24 2022", "Apr 25 2022", "Apr 26 2022", "Apr 27 2022", "Apr 28 2022", "Apr 29 2022", "Apr 30 2022",
			   "May 01 2022", "May 02 2022", "May 03 2022", "May 04 2022", "May 05 2022", "May 06 2022", "May 07 2022", "May 08 2022", "May 09 2022", "May 10 2022", "May 11 2022", "May 12 2022", "May 13 2022", "May 14 2022", "May 15 2022", "May 16 2022", "May 17 2022", "May 18 2022", "May 19 2022", "May 20 2022", "May 21 2022", "May 22 2022", "May 23 2022", "May 24 2022", "May 25 2022", "May 26 2022", "May 27 2022", "May 28 2022", "May 29 2022", "May 30 2022",
		   ]
	   
	   
	   
	   
	   
		   // Date Picker
		   if ($('#dashboardDate').length) {
			   flatpickr("#dashboardDate", {
				   wrap: true,
				   dateFormat: "d-M-Y",
				   defaultDate: "today",
			   });
		   }
		   // Date Picker - END
	   
	   
	   
	   
	   
		   // New Customers Chart
		   if ($('#customersChart').length) {
			   var options1 = {
				   chart: {
					   type: "line",
					   height: 60,
					   sparkline: {
						   enabled: !0
					   }
				   },
				   series: [{
					   name: '',
					   data: [3844, 3855, 3841, 3867, 3822, 3843, 3821, 3841, 3856, 3827, 3843]
				   }],
				   xaxis: {
					   type: 'datetime',
					   categories: ["Jan 01 2022", "Jan 02 2022", "Jan 03 2022", "Jan 04 2022", "Jan 05 2022", "Jan 06 2022", "Jan 07 2022", "Jan 08 2022", "Jan 09 2022", "Jan 10 2022", "Jan 11 2022", ],
				   },
				   stroke: {
					   width: 2,
					   curve: "smooth"
				   },
				   markers: {
					   size: 0
				   },
				   colors: [colors.primary],
			   };
			   new ApexCharts(document.querySelector("#customersChart"), options1).render();
		   }
		   // New Customers Chart - END
	   
	   
	   
		  
		   // Orders Chart
		   if ($('#ordersChart').length) {
			   var options2 = {
				   chart: {
					   type: "bar",
					   height: 60,
					   sparkline: {
						   enabled: !0
					   }
				   },
				   plotOptions: {
					   bar: {
						   borderRadius: 2,
						   columnWidth: "60%"
					   }
				   },
				   colors: [colors.primary],
				   series: [{
					   name: '',
					   data: [36, 77, 52, 90, 74, 35, 55, 23, 47, 10, 63]
				   }],
				   xaxis: {
					   type: 'datetime',
					   categories: ["Jan 01 2022", "Jan 02 2022", "Jan 03 2022", "Jan 04 2022", "Jan 05 2022", "Jan 06 2022", "Jan 07 2022", "Jan 08 2022", "Jan 09 2022", "Jan 10 2022", "Jan 11 2022", ],
				   },
			   };
			   new ApexCharts(document.querySelector("#ordersChart"), options2).render();
		   }
		   // Orders Chart - END
	   
	   
	   
	   
		   // Growth Chart
		   if ($('#growthChart').length) {
			   var options3 = {
				   chart: {
					   type: "line",
					   height: 60,
					   sparkline: {
						   enabled: !0
					   }
				   },
				   series: [{
					   name: '',
					   data: [41, 45, 44, 46, 52, 54, 43, 74, 82, 82, 89]
				   }],
				   xaxis: {
					   type: 'datetime',
					   categories: ["Jan 01 2022", "Jan 02 2022", "Jan 03 2022", "Jan 04 2022", "Jan 05 2022", "Jan 06 2022", "Jan 07 2022", "Jan 08 2022", "Jan 09 2022", "Jan 10 2022", "Jan 11 2022", ],
				   },
				   stroke: {
					   width: 2,
					   curve: "smooth"
				   },
				   markers: {
					   size: 0
				   },
				   colors: [colors.primary],
			   };
			   new ApexCharts(document.querySelector("#growthChart"), options3).render();
		   }
		   // Growth Chart - END
	   
	   
	   
	   
	   
		   // Revenue Chart
		   if ($('#revenueChart').length) {
			   var lineChartOptions = {
				   chart: {
					   type: "line",
					   height: '400',
					   parentHeightOffset: 0,
					   foreColor: colors.bodyColor,
					   background: colors.cardBg,
					   toolbar: {
						   show: false
					   },
				   },
				   theme: {
					   mode: 'light'
				   },
				   tooltip: {
					   theme: 'light'
				   },
				   colors: [colors.primary, colors.danger, colors.warning],
				   grid: {
					   padding: {
						   bottom: -4,
					   },
					   borderColor: colors.gridBorder,
					   xaxis: {
						   lines: {
							   show: true
						   }
					   }
				   },
				   series: [{
					   name: "Revenue",
					   data: revenueChartData
				   }, ],
				   xaxis: {
					   type: "datetime",
					   categories: revenueChartCategories,
					   lines: {
						   show: true
					   },
					   axisBorder: {
						   color: colors.gridBorder,
					   },
					   axisTicks: {
						   color: colors.gridBorder,
					   },
					   crosshairs: {
						   stroke: {
							   color: colors.secondary,
						   },
					   },
				   },
				   yaxis: {
					   title: {
						   text: 'Revenue ( $1000 x )',
						   style: {
							   size: 9,
							   color: colors.muted
						   }
					   },
					   tickAmount: 4,
					   tooltip: {
						   enabled: true
					   },
					   crosshairs: {
						   stroke: {
							   color: colors.secondary,
						   },
					   },
				   },
				   markers: {
					   size: 0,
				   },
				   stroke: {
					   width: 2,
					   curve: "straight",
				   },
			   };
			   var apexLineChart = new ApexCharts(document.querySelector("#revenueChart"), lineChartOptions);
			   apexLineChart.render();
		   }
		   // Revenue Chart - END
	   
	   
	   
	   
	   
		   // Revenue Chart - RTL
		   if ($('#revenueChartRTL').length) {
			   var lineChartOptions = {
				   chart: {
					   type: "line",
					   height: '400',
					   parentHeightOffset: 0,
					   foreColor: colors.bodyColor,
					   background: colors.cardBg,
					   toolbar: {
						   show: false
					   },
				   },
				   theme: {
					   mode: 'light'
				   },
				   tooltip: {
					   theme: 'light'
				   },
				   colors: [colors.primary, colors.danger, colors.warning],
				   grid: {
					   padding: {
						   bottom: -4,
					   },
					   borderColor: colors.gridBorder,
					   xaxis: {
						   lines: {
							   show: true
						   }
					   }
				   },
				   series: [{
					   name: "Revenue",
					   data: revenueChartData
				   }, ],
				   xaxis: {
					   type: "datetime",
					   categories: revenueChartCategories,
					   lines: {
						   show: true
					   },
					   axisBorder: {
						   color: colors.gridBorder,
					   },
					   axisTicks: {
						   color: colors.gridBorder,
					   },
					   crosshairs: {
						   stroke: {
							   color: colors.secondary,
						   },
					   },
				   },
				   yaxis: {
					   opposite: true,
					   title: {
						   text: 'Revenue ( $1000 x )',
						   offsetX: -130,
						   style: {
							   size: 9,
							   color: colors.muted
						   }
					   },
					   labels: {
						   align: 'left',
						   offsetX: -20,
					   },
					   tickAmount: 4,
					   tooltip: {
						   enabled: true
					   },
					   crosshairs: {
						   stroke: {
							   color: colors.secondary,
						   },
					   },
				   },
				   markers: {
					   size: 0,
				   },
				   stroke: {
					   width: 2,
					   curve: "straight",
				   },
			   };
			   var apexLineChart = new ApexCharts(document.querySelector("#revenueChartRTL"), lineChartOptions);
			   apexLineChart.render();
		   }
		   // Revenue Chart - RTL - END
	   
	   
	   
	   
	   
		 
		   // Monthly Sales Chart - END
	   
	   
	   
	   
		   // Monthly Sales Chart - RTL
		   if ($('#monthlySalesChartRTL').length) {
			   var options = {
				   chart: {
					   type: 'bar',
					   height: '318',
					   parentHeightOffset: 0,
					   foreColor: colors.bodyColor,
					   background: colors.cardBg,
					   toolbar: {
						   show: false
					   },
				   },
				   theme: {
					   mode: 'light'
				   },
				   tooltip: {
					   theme: 'light'
				   },
				   colors: [colors.primary],
				   fill: {
					   opacity: .9
				   },
				   grid: {
					   padding: {
						   bottom: -4
					   },
					   borderColor: colors.gridBorder,
					   xaxis: {
						   lines: {
							   show: true
						   }
					   }
				   },
				   series: [{
					   name: 'Sales',
					   data: [152, 109, 93, 113, 126, 161, 188, 143, 102, 113, 116, 124]
				   }],
				   xaxis: {
					   type: 'datetime',
					   categories: ['01/01/2022', '02/01/2022', '03/01/2022', '04/01/2022', '05/01/2022', '06/01/2022', '07/01/2022', '08/01/2022', '09/01/2022', '10/01/2022', '11/01/2022', '12/01/2022'],
					   axisBorder: {
						   color: colors.gridBorder,
					   },
					   axisTicks: {
						   color: colors.gridBorder,
					   },
				   },
				   yaxis: {
					   opposite: true,
					   title: {
						   text: 'Number of Sales',
						   offsetX: -100,
						   style: {
							   size: 9,
							   color: colors.muted
						   }
					   },
					   labels: {
						   align: 'left',
						   offsetX: -20,
					   },
				   },
				   legend: {
					   show: true,
					   position: "top",
					   horizontalAlign: 'center',
					   fontFamily: fontFamily,
					   itemMargin: {
						   horizontal: 8,
						   vertical: 0
					   },
				   },
				   stroke: {
					   width: 0
				   },
				   dataLabels: {
					   enabled: true,
					   style: {
						   fontSize: '10px',
						   fontFamily: fontFamily,
					   },
					   offsetY: -27
				   },
				   plotOptions: {
					   bar: {
						   columnWidth: "50%",
						   borderRadius: 4,
						   dataLabels: {
							   position: 'top',
							   orientation: 'vertical',
						   }
					   },
				   },
			   }
	   
			   var apexBarChart = new ApexCharts(document.querySelector("#monthlySalesChartRTL"), options);
			   apexBarChart.render();
		   }
		   // Monthly Sales Chart - RTL - END

		   // Cloud Storage Chart - END
	   
	   
	   });
	   </script>
	<!-- End custom js for this page -->


</body>
</html>    