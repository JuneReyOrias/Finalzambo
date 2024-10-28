@extends('user.user_dashboard')

@section('user')

<style>

.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
</style>
<section style="background-color: #eee;">
  <div class="container-profile py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0" style="margin-top: 2rem;">
            <li class="breadcrumb-item active" aria-current="page"></li>
          </ol>
          <h6 class="agent-profile text-center" style="font-size: 20px;">
            Profile
          </h6>
        </nav>
      </div>
    </div>
    @if (session()->has('message'))
    <div class="alert alert-success" id="success-alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      {{ session()->get('message') }}
    </div>
    @endif
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <!-- Display user image or default profile -->
            @if ($user->image)
              <img src="/agentimages/{{$user->image}}" name="image" id="showImage" alt="profile" class="rounded-circle img-fluid" style="width: 150px; height: 140px;">
            @else
              <img src="/upload/profile.jpg" name="image" id="showImage" alt="default avatar" class="rounded-circle img-fluid" style="width: 150px; height: 140px;">
            @endif
          
            <!-- Form for image upload -->
            <form action{{ url('Userupdate') }}  method="POST" enctype="multipart/form-data">
              @csrf
             
          
          <!-- Hidden file input -->
          <input type="file" id="inputGroupFile01" name="image" style="display: none;" onchange="previewImage(event)" />

          <!-- Edit button triggers file input -->
          <div class="file btn btn-primary mt-2 w-100" style="max-width: 150px;" onclick="document.getElementById('inputGroupFile01').click();">
            Edit
          </div>
          
              <!-- Submit button -->
              <div class="d-flex justify-content-center mb-2">
                <button type="submit" class="btn btn-primary mt-2">Save Image</button>
              </div>
            </form>
          
            <!-- User Information -->
            <h5 class="my-3">{{ $user->first_name . ' ' . $user->last_name }}</h5>
            <p class="my-3">{{ $user->email }}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <form action{{ url('Userupdate') }} method="post" enctype="multipart/form-data">
              @csrf
              <div class="row mb-3">
                <div class="col-sm-3">
                  <label class="mb-0">Full Name</label>
                </div>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" autocomplete="off" value="{{$user->first_name.' '.$user->last_name}}"@readonly(true)>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Email</p>
                </div>
                <div class="col-sm-9">
                  <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="{{$user->email}}" readonly>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Agri-District</p>
                </div>
                <div class="col-sm-9">
                  <input type="text" class="form-control"name="district" id="district" autocomplete="off" value="{{$user->district}}"@readonly(true)>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Role</p>
                </div>
                <div class="col-sm-9">
                  <input type="text" class="form-control"name="role" id="role" autocomplete="off" value="{{$user->role}}" readonly>
                </div>
              </div>
              <hr>
{{--   
              <div class="row mb-3">
                <div class="col-sm-3">
                  <label class="mb-0" for="image">Image</label>
                </div>
                <div class="col-sm-9">
                  <input type="file" class="form-control"  id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="image">
                </div>
              </div> --}}
              {{-- <hr>
              <div class="row mb-3">
                <div class="col-sm-3">
                  <label class="mb-0">Image</label>
                </div>
                <div class="col-sm-9"> --}}
                  {{-- <img class="rounded-circle" name="image" id="showImage" src="/agentimages/{{$user->image}}" alt="profile"> --}}
             {{-- Image preview section --}}
                {{-- @if ($user->image)
                <img src="/agentimages/{{$user->image}}" name="image" id="showImage" alt="profile" class="rounded-circle img-fluid" style="width: 150px; height: 140px;">
                @else
                <img src="/upload/profile.jpg" name="image" id="showImage" alt="default avatar" class="rounded-circle img-fluid" style="width: 150px; height: 140px;">
                @endif --}}

                {{-- File input for uploading image --}}
                {{-- <input type="file" name="image" id="imageInput" class="form-control" onchange="previewImage(event)"> --}}

{{--               
                </div>
              </div> --}}
              <hr>
              <button type="submit" class="btn btn-primary me-2">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#inputGroupFile01').change(function(e){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#showImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(e.target.files[0]);
    });
  });
</script>
@endsection
