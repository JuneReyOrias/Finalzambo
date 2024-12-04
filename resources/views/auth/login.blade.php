<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  

	<title>AgriMap Login </title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('../../../assets/vendors/core/core.css')}}">
	<!-- endinject -->
 <!--====== Favicon Icon ======-->
    {{-- <link
      rel="shortcut icon"
      href="landing_page/assets/images/favicon.svg"
      type="image/svg"
    /> --}}

    <!-- ===== All CSS files ===== -->
    <link rel="stylesheet" href="landing_page/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="landing_page/assets/css/animate.css" />
    <link rel="stylesheet" href="landing_page/assets/css/lineicons.css" />
    <link rel="stylesheet" href="landing_page/assets/css/ud-styles.css" />
	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{asset('../../../assets/fonts/feather-font/css/iconfont.css')}}">
	<link rel="stylesheet" href="{{asset('../../../assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="{{asset('./../../assets/css/demo2/style.css')}}">
  <!-- End layout styles -->

  <link rel="shortcut icon" href="{{asset('assets/logo/logo.png')}}" />
</head>
<body>
    
<style>

.Login-register {
            margin-bottom: 0.5rem;
            color: #fff;
        }
</style>
{{-- <div class="main-wrapper" style=" background-image: url(https://watchmendailyjournal.com/wp-content/uploads/2023/04/da.jpg);">

		
         
						


  </div> --}}
  <div class="main-wrapper"  style=" background-image: url(upload/rice.jpg);">
		<div class="page-wrapper full-pages">
			<div class="page-content d-flex align-items-center justify-content-center">

				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto">
						<div class="card-register">
              
							<div class="row">
                <div class="col-md-4 pe-md-0">
                  <div class="auth-side-wrapper"  style=" background-image: url(upload/rice.jpg);">

                  </div>
                </div>
                <div class="col-md-8 ps-md-0">
                  <div class="auth-form-wrapper px-4 py-5">
                    <a href="" class="noble-ui-logo logo-light d-block mb-2">Web<span>Agrimap</span></a>
                    <h5 class="text-muteds fw-normal mb-4">Welcome back! Log in to your account.</h5>

                   <form class="forms-sample " method="post" action="{{ route('login') }}">
                      @csrf
                    <div class="mb-3">
                        <label for="login" class="Login-register">Email address</label>
                        <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                      </div>
                      <div class="mb-3">
                        <label for="password" class="Login-register">Password</label>
                        <input id="password" class="form-control"
                        type="password"
                        name="password"
                        required autocomplete="current-password">
                        <div class="form-check mb-3">
                          <input type="checkbox" class="form-check-input"id="togglePasswordVisibilityCheckbox">
                          <label class="form-check-label" for="togglePasswordVisibilityCheckbox">Show Password</label>
                        </div>

                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                      </div>
                    
                      <div>
                       <!-- <a href="../../dashboard.html" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Login</a>-->
                       <button type="submit" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                          Login
                        </button>
                      </div>
                      <a href="{{route('admin.create_account.farmer.new_farmer')}}" class="d-block mt-3 text-muteds">Create Account? Sign up</a>
                    </form>
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
  <script>
    document.getElementById("togglePasswordVisibilityCheckbox").addEventListener("change", function () {
        var passwordInput = document.getElementById("password");

        if (this.checked) {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
</script>


	<!-- core:js -->
	<script src="{{asset('../../../assets/vendors/core/core.js')}}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="{{asset('../../../assets/vendors/feather-icons/feather.min.js')}}"></script>
	<script src="{{asset('../../../assets/js/template.js')}}"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<!-- End custom js for this page -->

</body>
</html>