<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web"> --}}

	<title>Register Page </title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('../../../assets/vendors/core/core.css')}}">
	<!-- endinject -->

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
                    <a href="#" class="noble-ui-logo logo-light d-block mb-2">Web<span>AgriMap</span></a>
                    <h5 class="text-muteds fw-normal mb-4">Create your Account.</h5>
                    <form class="forms-sample " method="post" action="{{ route('register') }}">
                        @csrf
                         <!-- Row with two columns for FullName and Email address -->
                      <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="exampleInputUsername1" class="Login-register-label">FirstName</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="exampleInputUsername1" name="first_name" autocomplete="first_name" placeholder="FirstName" value="{{ old('first_name') }}">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                          <label for="exampleInputUsername1" class="Login-register-label">LastName</label>
                          <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleInputUsername1" name="last_name" autocomplete="last_name" placeholder="LastName" value="{{ old('last_name') }}">
                          @error('last_name')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>

                                    </div>
                                      <div class="row mb-3">
                                        <div class="col-md-6">
                                          <label for="userEmail" class="Login-register-label">Email address</label>
                                             <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" placeholder="Email" value="{{ old('email') }}">
                                              @error('email')
                                                 <div class="invalid-feedback">{{ $message }}</div>
                                             @enderror
                                                 </div>
                                        <div class="col-md-6">
                                          <label for="agri_district" class="Login-register-label">Agri District</label>
                                          <select class="form-control  @error('district') is-invalid @enderror"  name="district"id="validationCustom01" aria-label="Floating label select e">
                                            <option selected disabled>Select Agri-District</option>
                                               <option value="ayala" {{ old('district') == 'ayala' ? 'selected' : '' }}>Ayala Distict</option>
                                                 <option value="tumaga" {{ old('district') == 'tumaga' ? 'selected' : '' }}>Tumaga District</option>
                                                   <option value="culianan" {{ old('district') == 'culianan' ? 'selected' : '' }}>Culianan District</option>
                                                     <option value="Manicahan District" {{ old('district') == 'manicahan' ? 'selected' : '' }}>Manicahan District</option>
                                                       <option value="curuan" {{ old('district') == 'curuan' ? 'selected' : '' }}>Curuan District</option>
                                                         <option value="vitali" {{ old('district') == 'vitali' ? 'selected' : '' }}>Vitali District</option>
                                                            </select>
                                                                 @error('district')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                      @enderror
                                                               </div>
                                                              {{-- <div class="col-md-6">
                                                            <label for="userEmail" class="Login-register-label">Email address</label>
                                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" placeholder="Email" value="{{ old('email') }}">
                                                      @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                  @enderror
                                                </div> --}}
                                            </div>
      
                                              <!-- Row with two columns for password -->
                      <div class="row mb-3">
                        <div class="col-md-6">
                         
                            <label for="password" class="Login-register-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" autocomplete="current-password" placeholder="Password" value="{{ old('password') }}"> 
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input"id="togglePasswordVisibilityCheckbox">
                                  <label class="form-check-label" for="togglePasswordVisibilityCheckbox">Show Password</label>
                                       </div>
                                         @error('password')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                          </div>
                                           <div class="col-md-6">
                                            <label for="confirm_password" class="Login-register-label">confirm Password</label>
                                              <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" autocomplete="current-confirm_password" placeholder="Password" value="{{ old('confirm_password') }}">
                                              {{-- <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input"id="togglePasswordVisibilityCheckbox">
                                                <label class="form-check-label" for="togglePasswordVisibilityCheckbox">Show Password</label>
                                              </div> --}}
                                                  @error('confirm_password')
                                                  <div class="invalid-feedback">{{ $message }}</div>
                                              @enderror
                                                        </div>

                                                        {{-- <div class="col-md-6">
                                                          <label for="agri_district" class="Login-register-label">Role</label>
                                                          <select class="form-control  @error('agri_district') is-invalid @enderror"  name="role"id="validationCustom01" aria-label="Floating label select e">
                                                            <option selected disabled>Select Agri-District</option>
                                                               <option value="admin" {{ old('agri_district') == 'admin' ? 'selected' : '' }}>admin </option>
                                                                 <option value="agent" {{ old('agri_district') == 'agent' ? 'selected' : '' }}>agent District</option>
                                                                 
                                                                            </select>
                                                                                 @error('agri_district')
                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                      @enderror
                                                                               </div> --}}

                                                        <div>
                                                          <button type="submit"  class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                              Sign up
                                                            </button>
                                                            <a href={{url('login')}} button type="submit"  class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                              Log in
                                                            </button></a>
                                                            <a href={{url('/')}} button type="submit"  class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                              Home
                                                            </button></a>
                                                        </div>
                                                        
                                                          </div>
                     
                     
                  
                    
                   
                  
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
 <script>
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');
  
    confirmPasswordField.addEventListener('input', function() {
      const password = passwordField.value;
      const confirmPassword = confirmPasswordField.value;
  
      if (password !== confirmPassword) {
        confirmPasswordField.setCustomValidity("Passwords do not match");
      } else {
        confirmPasswordField.setCustomValidity('');
      }
    });
  
    // Ensure validation is run on page load
    confirmPasswordField.reportValidity();
  </script>

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