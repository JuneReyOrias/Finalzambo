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
        <form action{{ url('updateAccounts') }} method="post">
          @csrf
          <div class="user-details">
            <div class="input-box mb-3">
              <span class="details">First Name</span>
              <input type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ $users->first_name }}" name="first_name" placeholder="Enter your first name">
              @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box mb-3">
              <span class="details">Last Name</span>
              <input type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ $users->last_name }}" name="last_name" placeholder="Enter your last name">
              @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box mb-3">
              <span class="details">Email</span>
              <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $users->email }}" name="email" placeholder="Enter your email">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="input-box mb-3">
              <label class="details" for="district">Agri-District</label>
              <select class="form-control @error('district') is-invalid @enderror" name="district">
                <option value="{{ $users->district }}">{{ $users->district }}</option>
                <option value="ayala District" {{ old('district') == 'Ayala District' ? 'selected' : '' }}>Ayala District</option>
                <option value="Tumaga District" {{ old('district') == 'Tumaga District' ? 'selected' : '' }}>Tumaga District</option>
                <option value="Culianan District" {{ old('district') == 'Culianan District' ? 'selected' : '' }}>Culianan District</option>
                <option value="Manicahan District" {{ old('district') == 'Manicahan District' ? 'selected' : '' }}>Manicahan District</option>
                <option value="Curuan District" {{ old('district') == 'Curuan District' ? 'selected' : '' }}>Curuan District</option>
                <option value="Vitali District" {{ old('district') == 'Vitali District' ? 'selected' : '' }}>Vitali District</option>
              </select>
            </div>

            <div class="input-box mb-3">
              <span class="details">Role</span>
              <select class="form-select" name="role">
                <option value="{{ $users->role }}">{{ $users->role }}</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
              </select>
            </div>
          </div>

          <div class="button mb-4">
            <input type="submit" class="btn btn-primary w-100" value="Update Account">
          </div>
        </form>

        <!-- Button to Update Password -->
        <div class="d-flex justify-content-between">
          <a href="{{ route('admin.create_account.display_users') }}" class="btn btn-success">Back</a>
          <a href="{{ route('admin.create_account.update_password', $users->id) }}" class="btn btn-warning">Update Password</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Update Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.create_account.update_password', $users->id) }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Enter current password">
            @error('current_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Enter new password">
            @error('new_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password">
            @error('new_password_confirmation')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

>

@endsection
