<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>Admin- AgriMap</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

  <!-- End fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
  <link rel="stylesgeet" href="https://rawgit.com/creativetimofficial/material-kit/master/assets/css/material-kit.css">

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

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}
<!-- Layout styles -->  
<link rel="stylesheet" href="../assets/css/demo2/style.css">
{{-- <link rel="stylesheet" href="../assets/fonts/feather-font/css/iconfont.css"> --}}
{{-- <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css"> --}}
<!-- End layout styles -->
{{-- <link rel="stylesheet" href="../assets/css/style.css"> --}}
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


</body>
</html>    