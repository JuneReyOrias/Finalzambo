<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand">
    Admin<span>Agrimap</span>
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
        <a href="{{route('admin.dashb')}}" class="nav-link">
          <img src="../assets/logo/layout.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style=",margin-left:12px;">Dashboard</span>
        </a>
      </li>
      <li class="nav-item nav-category">Agri-Map</li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#crop" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/wheat.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title" style="margin-left: 12px;"> CROP</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="crop">
          <ul class="nav sub-menu" style="padding-left: 70px;">
            {{-- <li class="nav-item">
              <a href="{{route('map.arcmap')}}" class="nav-link">Rice</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{route('map.cornmap')}}" class="nav-link">All Crops</a>
            </li>
            {{-- <li class="nav-item">
              <a href="{{route('map.coconutmap')}}" class="nav-link">Coconut</a>
            </li> --}}
          </ul>
        </div>
      </li>
      <li class="nav-item nav-category">Farmers Data</li>
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
              <a href="{{route('admin.farmersdata.genfarmers')}}" class="nav-link">Farmers</a>
            </li>
           
          </ul>
        </div>
      </li>

     
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#Forms" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/farm.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;"> Forms</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="Forms">
          <ul class="nav sub-menu"  style="padding-left: 70px;">

            {{-- <li class="nav-item">
              <a href="{{route('admin.corn.forms.corn_form')}}" class="nav-link">Survey Form</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{route('admin.farmersdata.samplefolder.farm_edit')}}" class="nav-link">Survey Form</a>
            </li>


           
          </ul>
        </div>
      </li>
      
      {{-- <li class="nav-item nav-category">Components</li> --}}
      <li class="nav-item nav-category">Crops</li>
   
     
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#Farmer" role="button" aria-expanded="false" aria-controls="uiComponents">
          <img src="../assets/logo/rice.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;"> Farmer Crops </span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="Farmer">
          <ul class="nav sub-menu"  style="padding-left: 70px;">

            {{-- <li class="nav-item">
              <a href="{{route('admin.corn.forms.corn_form')}}" class="nav-link">Survey Form</a>
            </li> --}}
            <li class="nav-item">
              <a href="{{route('admin.cropsreport.all_crops')}}" class="nav-link">Crops</a>
            </li>


           
          </ul>
        </div>
      </li>
      
      <li class="nav-item nav-category">Setting</li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#icons" role="button" aria-expanded="false" aria-controls="icons">
          <img src="../assets/logo/pin.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;">POLYGON</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="icons">
          <ul class="nav sub-menu"style="padding-left:70px;">
            <li class="nav-item">
              <a href="{{route('polygon.polygons_show')}}" class="nav-link">Crop Setting</a>
            </li>
          
          </ul>
        </div>
      </li>


     

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#brangay" role="button" aria-expanded="false" aria-controls="brangay">
          <img src="../assets/logo/barangay.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;">Barangay</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="brangay">
          <ul class="nav sub-menu"style="padding-left:70px;">
            <li class="nav-item">
              <a href="{{route('admin.barangay.view_forms')}}" class="nav-link">Add Barangay</a>
            </li>
         
           
          </ul>
        </div>
      </li>

   
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#farmerorg" role="button" aria-expanded="false" aria-controls="farmerorg">
          <img src="../assets/logo/group.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;">Farmer Org</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="farmerorg">
          <ul class="nav sub-menu"style="padding-left:70px;">
            <li class="nav-item">
              <a href="{{route('admin.farmerOrg.view_orgs')}}" class="nav-link">Add org</a>
            </li>

            {{-- <li class="nav-item">
              <a href="{{route('categorize.index')}}" class="nav-link">Category</a>
            </li>
            --}}
           
          </ul>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#homepage" role="button" aria-expanded="false" aria-controls="homepage">
          <img src="../assets/logo/homepage.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;">Homepage</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="homepage">
          <ul class="nav sub-menu"style="padding-left:70px;">
            <li class="nav-item">
              <a href="{{route('landing-page.view_homepage')}}" class="nav-link">Homepage Tools</a>
            </li>
         
           
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#Notification" role="button" aria-expanded="false" aria-controls="Notification">
          <img src="../assets/logo/notifsetting.png" alt="Crop Icon" style="width: 20px; height: 20px; color: white;">
          <span class="link-title"style="margin-left:12px;">Notification</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="Notification">
          <ul class="nav sub-menu"style="padding-left:70px;">
            <li class="nav-item">
              <a href="{{route('admin.notification.view_notif')}}" class="nav-link">Notification Tools</a>
            </li>
         
           
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" role="button" aria-expanded="false" aria-controls="general-pages">
          <i class="link-icon" data-feather="users"></i>
          <span class="link-title">ACCOUNTS</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="general-pages">
          <ul class="nav sub-menu"style="padding-left:70px;">
            <li class="nav-item">
              <a href="{{route('admin.create_account.display_users')}}" class="nav-link">Users</a>
            </li>
            {{-- <li class="nav-item">
              <a href="pages/general/faq.html" class="nav-link">Faq</a>
            </li>
            <li class="nav-item">
              <a href="pages/general/invoice.html" class="nav-link">Invoice</a>
            </li>
            <li class="nav-item">
              <a href="pages/general/profile.html" class="nav-link">Profile</a>
            </li>
            <li class="nav-item">
              <a href="pages/general/pricing.html" class="nav-link">Pricing</a>
            </li>
            <li class="nav-item">
              <a href="pages/general/timeline.html" class="nav-link">Timeline</a>
            </li>
          </ul>
        </div>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#authPages" role="button" aria-expanded="false" aria-controls="authPages">
          <i class="link-icon" data-feather="unlock"></i>
          <span class="link-title">Authentication</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="authPages">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="admin_login" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
              <a href="pages/auth/register.html" class="nav-link">Register</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#errorPages" role="button" aria-expanded="false" aria-controls="errorPages">
          <i class="link-icon" data-feather="cloud-off"></i>
          <span class="link-title">Error</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse" id="errorPages">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="pages/error/404.html" class="nav-link">404</a>
            </li>
            <li class="nav-item">
              <a href="pages/error/500.html" class="nav-link">500</a>
            </li>
          </ul>
        </div>
      </li> --}}
      <!--<li class="nav-item nav-category">Docs</li>
      <li class="nav-item">
        <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
          <i class="link-icon" data-feather="hash"></i>
          <span class="link-title">Documentation</span>
        </a>
      </li>-->
    </ul>
  </div>
</nav>
