@extends('admin.dashb')

@section('admin')
<div class="page-content">

  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    @if (session('message'))
      <div class="alert alert-success" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
  </div>

  <div class="d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="title mb-4 text-center">
        <h4>Account Update</h4>
      </div>

      <div class="content">
        <form action{{ url('Updatepasswords') }} method="post">
            @csrf
            <div class="user-details">
              <!-- New Password -->
              <div class="input-box mb-3">
                <span class="details">New Password</span>
                <input 
                  type="password" 
                  class="form-control @error('new_password') is-invalid @enderror" 
                  id="new_password" 
                  name="new_password" 
                  placeholder="Enter new password"
                  required>
                @error('new_password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <!-- Password Visibility Toggle -->
                <div class="form-check mt-2">
                  <input type="checkbox" class="form-check-input" id="toggleNewPasswordVisibility">
                  <label class="form-check-label" for="toggleNewPasswordVisibility">Show New Password</label>
                </div>
              </div>
          
              <!-- Confirm Password -->
              <div class="input-box mb-3">
                <span class="details">Confirm Password</span>
                <input 
                  type="password" 
                  class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                  id="new_password_confirmation" 
                  name="new_password_confirmation" 
                  placeholder="Confirm new password"
                  required>
                @error('new_password_confirmation')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <!-- Password Visibility Toggle -->
                <div class="form-check mt-2">
                  <input type="checkbox" class="form-check-input" id="toggleConfirmPasswordVisibility">
                  <label class="form-check-label" for="toggleConfirmPasswordVisibility">Show Confirm Password</label>
                </div>
              </div>
            </div>
          
            <div class="button mb-4">
              <input type="submit" class="btn btn-primary w-100" value="Update Password">
            </div>
          </form>
        <!-- Button to Update Password -->
        <div class="d-flex justify-content-between">
          <a href="{{ route('admin.create_account.edit_accounts',$users->id) }}" class="btn btn-success">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  // Password Matching Validation
  const newPasswordField = document.getElementById('new_password');
  const confirmPasswordField = document.getElementById('new_password_confirmation');

  confirmPasswordField.addEventListener('input', function() {
    const password = newPasswordField.value;
    const confirmPassword = confirmPasswordField.value;

    if (password !== confirmPassword) {
      confirmPasswordField.setCustomValidity("Passwords do not match");
    } else {
      confirmPasswordField.setCustomValidity('');
    }
  });

  // Password Visibility Toggles
  const toggleNewPasswordVisibility = document.getElementById('toggleNewPasswordVisibility');
  const toggleConfirmPasswordVisibility = document.getElementById('toggleConfirmPasswordVisibility');

  toggleNewPasswordVisibility.addEventListener('change', function() {
    newPasswordField.type = this.checked ? 'text' : 'password';
  });

  toggleConfirmPasswordVisibility.addEventListener('change', function() {
    confirmPasswordField.type = this.checked ? 'text' : 'password';
  });
</script>
<script>

// // Toggle visibility for new password
// document.getElementById('toggleNewPasswordVisibility').addEventListener('change', function () {
//     const newPasswordField = document.getElementById('new_password');
//     if (this.checked) {
//         newPasswordField.type = 'text'; // Show password
//     } else {
//         newPasswordField.type = 'password'; // Hide password
//     }
// });

// // Toggle visibility for confirm password
// document.getElementById('toggleConfirmPasswordVisibility').addEventListener('change', function () {
//     const confirmPasswordField = document.getElementById('new_password_confirmation');
//     if (this.checked) {
//         confirmPasswordField.type = 'text'; // Show password
//     } else {
//         confirmPasswordField.type = 'password'; // Hide password
//     }
// });



</script>
<style>

    /* Adjust the size of the checkbox */
.small-checkbox {
  width: 0.2rem; /* Smaller width */
  height: 1.2rem; /* Smaller height */
  margin-top: 0.2rem; /* Align vertically */
}

/* Adjust the font size of the label */
.small-checkbox-label {
  font-size: 0.85rem; /* Reduce font size */
  margin-left: 0.5rem; /* Add spacing between checkbox and label */
}

/* Optional: Ensure alignment within the container */
.small-checkbox-container {
  display: flex;
  align-items: center;
}
.user-details .input-box input {
         
            outline: none;
            font-size: 14px;
            border-radius: 5px;
            padding-left: 15px;
            border: 1px solid #ccc;
            border-bottom-width: 2px;
            transition: all 0.3s ease;
        }
</style>
@endsection  