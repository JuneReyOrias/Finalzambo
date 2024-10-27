<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
     Zambo<span>Agrimap</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      <li class="nav-item">
        <a href="{{route('user.user_dash')}}" class="nav-link">
          <img src="../assets/logo/layout.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style=",margin-left:12px;">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">Agri-Map</li>
     
    {{-- <li class="nav-item">
      <a href="{{route('map.arcmap')}}" class="nav-link"> 
          <i class="link-icon" data-feather="map"></i>
          <span class="link-title">ZamboAgriMap</span>
        </a>
      </li>  --}}
     
   
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#crop" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/wheat.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">

          <span class="link-title" style=" margin-left: 12px;"> Crop</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="crop">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{route('map.agrimap')}}" class="nav-link">All Crops</a>
            </li>
       
           
            
          </ul>
        </div>
      </li>
     
      {{-- <li class="nav-item nav-category">Components</li> --}}
      <li class="nav-item nav-category">Farmer Data</li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#farmersData" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/farmer.png" alt="farmersData Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title" style="margin-left: 12px;"> Farmers Info</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="farmersData">
          <ul class="nav sub-menu" style="padding-left: 70px;">
            {{-- <li class="nav-item">
              <a href="{{route('personalinfo.create')}}" class="nav-link">Farmers</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{route('user.farmerInfo.profilingData')}}" class="nav-link">Farmer Profile</a>
            </li>
            {{-- <li class="nav-item">
              <a href="" class="nav-link">Farmer </a>
            </li> --}}
          </ul>
        </div>
      </li>




    

      
 


  </div>
</nav>
