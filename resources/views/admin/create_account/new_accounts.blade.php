@extends('admin.dashb')
@section('admin')
<div class="page-content">

  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
 

        

         
              @csrf
              <div class="row mb-4">
                <div>
                  <h4 class="mb-3 mb-md-0">Create New Account</h4>
                </div>
                <div class="container">
                  @if (session('message'))
                  <div class="alert alert-success" role="alert">
                    {{ session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                     
                  @endif
                 
                  @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      {{ session('error') }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endif
                  <div class="title">Registration</div>
                  <div class="content">
                    <form method="post" action{{url('NewUsers') }}>
                      @csrf
                      <div class="user-details">
                        <div class="input-box">
                          <span class="details">First Name</span>
                          <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Enter your firstname"value="{{ old('first_name') }}" >
                          @error('first_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>
                        <div class="input-box">
                          <span class="details">Last Name</span>
                          <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Enter your lastname"value="{{ old('last_name') }}" >
                          @error('last_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>
                        <div class="input-box">
                          <span class="details">email</span>
                          <input type="text"name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your username" >
                          @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>
                        <div class="input-box">
                          <span class="details">Agri-District</span>
                          <select class="form-control @error('agri_district') is-invalid @enderror"  name="agri_district"id="validationCustom01" aria-label="Floating label select e">
                            <option selected disabled>Select Agri-District</option>
                            <option value="ayala" {{ old('agri_district') == 'ayala' ? 'selected' : '' }}>Ayala Distict</option>
                            <option value="tumaga" {{ old('agri_district') == 'tumaga' ? 'selected' : '' }}>Tumaga District</option>
                            <option value="culianan" {{ old('agri_district') == 'culianan' ? 'selected' : '' }}>Culianan District</option>
                            <option value="manicahan" {{ old('agri_district') == 'manicahan' ? 'selected' : '' }}>Manicahan District</option>
                            <option value="curuan" {{ old('agri_district') == 'curuan' ? 'selected' : '' }}>Curuan District</option>
                            <option value="vitali" {{ old('agri_district') == 'vitali' ? 'selected' : '' }}>Vitali District</option>
                          </select>
                        </div>
                        <div class="input-box">
                          <span class="details">Password</span>
                          <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" autocomplete="new-password" value="{{ old('password') }}" >
                          @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>

                        <div class="input-box">
                          <span class="details">Confirm Password</span>
                          <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm your password" autocomplete="new-password" value="{{ old('confirm_password') }}" >
                          @error('confirm_password')
                          <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="input-box">
                          <span class="details">Role</span>
                          <select class="form-select" name="role"id="validationCustom01" aria-label="Floating label select e">
                            <option selected disabled>Select role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
                            <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>agent</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>user</option>
                          
                          </select>
                        </div>
                       
                      </div>
                      <button type="submit"  class="btn btn-outline-success">
                        Sign up
                      </button>

                    </form>
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
  @endsection