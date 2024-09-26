@extends('admin.dashb')
@section('admin')
<div class="page-content">

  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
 
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
        

         
              @csrf
              <div class="row mb-4">
                <div>
                  <h4 class="mb-3 mb-md-0">Account Update</h4>
                </div>
                <div class="container">
                  <div class="title">Registration</div>
                  <div class="content">
                    <form  action{{url('updateAccounts')}} method="post" >
                      @csrf
                      <div class="user-details">
                       
                        <div class="input-box">
                          <span class="details">First Name</span>
                          <input type="text" class="form-control @error('first_name') is-invalid @enderror"value="{{$users->first_name}}"  name="first_name" placeholder="Enter your firstname"value="{{ old('first_name') }}" >
                          @error('first_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>
                        <div class="input-box">
                          <span class="details">Last Name</span>
                          <input type="text" class="form-control @error('last_name') is-invalid @enderror"value="{{$users->last_name}}"  name="last_name" placeholder="Enter your lastname"value="{{ old('last_name') }}" >
                          @error('last_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>
                        <div class="input-box">
                          <span class="details">email</span>
                          <input type="email"name="email" class="form-control @error('email') is-invalid @enderror"value="{{$users->email}}" placeholder="Enter your username" >
                          @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>
                        <div class="input-box">
                          <label class="details"for="district">Agri-District</label>
                          <select class="form-control @error('district') is-invalid @enderror"  name="district"id="validationCustom01" aria-label="Floating label select e">
                            <option value="{{$users->district}}">{{$users->district}}</option>
                            <option value="Ayala Distict" {{ old('district') == 'Ayala Distict' ? 'selected' : '' }}>Ayala Distict</option>
                            <option value="Tumaga District" {{ old('district') == 'Tumaga District' ? 'selected' : '' }}>Tumaga District</option>
                            <option value="Culianan District " {{ old('district') == 'Culianan District' ? 'selected' : '' }}>Culianan District</option>
                            <option value="Manicahan District" {{ old('district') == 'Manicahan District' ? 'selected' : '' }}>Manicahan District</option>
                            <option value="Curuan District" {{ old('district') == 'Curuan District' ? 'selected' : '' }}>Curuan District</option>
                            <option value="Vitali District" {{ old('district') == 'Vitali District' ? 'selected' : '' }}>Vitali District</option>
                          </select>
                        </div>
                        {{-- <div class="input-box">
                          <span class="details">Password</span>
                          <input type="text"name="password" class="form-control @error('password') is-invalid @enderror"value="{{$users->password}}" placeholder="Enter your password"id="password" autocomplete="current-password" value="{{ old('password') }}" >
                          @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div>

                        <div class="input-box">
                          <span class="details">Confirm Password</span>
                          <input type="text"  class="form-control @error('password') is-invalid @enderror"name="password" value="{{$users->password}}"id="password" autocomplete="current-password" placeholder=" Confirm  Password" value="{{ old('password') }}" >
                          @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                        </div> --}}
                        <div class="input-box">
                          <span class="details">Role</span>
                          <select class="form-select" name="role"id="validationCustom01" aria-label="Floating label select e">
                            <option value="{{$users->role}}">{{$users->role}}</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
                            <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>agent</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>user</option>
                          
                          </select>
                        </div>
                      </div>
                 
                      <div class="button">

                        <input type="submit" value="Update">
                       
                      </div>
                      <a  href="{{route('admin.create_account.display_users')}}"button  class="btn btn-success ">Back</button></a></p>
                    </form>
                  </div>
                
                </div>
          </div>
        </div>
      </div>
    </div>
  
   
  
  
  </div>
  
  @endsection