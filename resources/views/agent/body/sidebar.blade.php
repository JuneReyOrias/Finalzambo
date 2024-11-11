<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
     Agent<span>AgriMap</span>
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
        <a href="{{route('agent.agent_index')}}" class="nav-link">
          <img src="../assets/logo/layout.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style=",margin-left:12px;">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">Agri-Map</li>
     
   
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#crop" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/wheat.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">

          <span class="link-title" style=" margin-left: 12px;"> Crop</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="crop">
          <ul class="nav sub-menu">
            {{-- <li class="nav-item">
              <a href="{{route('map.gmap')}}" class="nav-link">Rice</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{route('agent.agri.cornmap')}}" class="nav-link">All Crops</a>
            </li>
            {{-- <li class="nav-item">
              <a href="{{route('agent.agri.coconutmap')}}" class="nav-link">Coconut</a>
            </li>
            --}}
            
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category">Farmers Data</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#farmersData" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/wheat.png" alt="farmersData Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title" style="margin-left: 12px;"> Farmers Info</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="farmersData">
          <ul class="nav sub-menu" style="padding-left: 70px;">
            {{-- <li class="nav-item">
              <a href="{{route('personalinfo.create')}}" class="nav-link">Farmers</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{route('agent.FarmerInfo.farmers_view')}}" class="nav-link">Farmers</a>
            </li>
           
          </ul>
        </div>
      </li>
   <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#Forms" role="button" aria-expanded="false" aria-controls="uiComponents">
            <img src="../assets/logo/online-survey.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
            <span class="link-title"style="margin-left:12px;"> Forms</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse" id="Forms">
            <ul class="nav sub-menu"  style="padding-left: 70px;">

           
              <li class="nav-item">
                <a href="{{route('agent.SurveyForm.new_farmer')}}" class="nav-link">Survey Form</a>
              </li>
   <li class="nav-item">
                <a href="{{route('agent.mutipleFile.import_excelFile')}}" class="nav-link">Excel Import</a>
              </li>

             
            </ul>
          </div>
        </li>
      {{-- <li class="nav-item nav-category">Components</li> --}}
      {{-- <li class="nav-item nav-category">Crops</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#Farmer" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/rice.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;"> Farmer Crops </span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="Farmer">
          <ul class="nav sub-menu"  style="padding-left: 70px;">

       
            <li class="nav-item">
              <a href="{{route('agent.CropReport.all_crops')}}" class="nav-link">Crops</a>
            </li>


           
          </ul>
        </div>
      </li> --}}
    {{--  livestock  --}}
   
</nav>
