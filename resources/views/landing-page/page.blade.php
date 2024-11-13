
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zambo AgriMap</title>
   
     
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    
  
 
 
 
  
    <link rel="shortcut icon" href="../assets/logo/logo.png" />


    <!-- ===== All CSS files ===== -->
    <link rel="stylesheet" href="landing_page/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="landing_page/assets/css/animate.css" />
    <link rel="stylesheet" href="landing_page/assets/css/lineicons.css" />
    <link rel="stylesheet" href="landing_page/assets/css/ud-styles.css" />
    <link rel="stylesheet" href="landing_page/assets/css/homepage.css" />
  </head>
  <body>
    <!-- ====== Header Start ====== -->
    <header class="ud-header">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg">
                <div class="ud-hero-brands-wrapper wow fadeInUp " data-wow-delay=".3s">
                    <img src="landing_page/assets/images/logo/logo-main.png" alt="header-logo" style="width: 60px; height:60px;border-radius: 50%; position: absolute; top: 5px; left: 2%; transform: translateX(-50%);" />
                </div>
              <button class="navbar-toggler">
                <span class="toggler-icon"> </span>
                <span class="toggler-icon"> </span>
                <span class="toggler-icon"> </span>
                
              </button>
              {{-- @if($errors->any())
              <ul class="alert alert-warning">
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
              </ul>
              @endif --}}
              <div class="navbar-collapse">
                <ul id="nav" class="navbar-nav mx-auto">
                  <li class="nav-item">
                    <a class="ud-menu-scroll " href="#home">Home</a>
                  </li>

                  <li class="nav-item">
                    <a class="ud-menu-scroll" href="#about">About</a>
                  </li>
           
                
                  <li class="nav-item">
                    <a class="ud-menu-scroll" href="#contact">Contact</a>
                    
                  </li>
                  <li class="nav-item">
                    <a  href="{{route('login')}}" href="javascript:void(0)">Log in</a>
              
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{route('register')}}" href="javascript:void(0)" >Register</a>
              
                  </li> --}}
                </ul>
              </div>

              <div class="navbar-btn d-none d-sm-inline-block">
              
              </div>
            </div>

           </div>
      </div>

    </header>

    <!-- ====== Header End ====== -->

    <!-- ====== Hero Start ====== -->
  
    
    <section class="ud-hero" id="home">
      <div class="container">
      
<div class="row">
  <div class="col-lg-12">
    <div class="ud-hero-content wow fadeInUp" data-wow-delay=".2s">
        
        <!-- Logo -->
        <div class="ud-hero-brands-wrapper wow fadeInUp" data-wow-delay=".3s">
            <img src="../assets/logo/agriculture.jpg" alt="header-logo" style="width: 60px; height:60px;border-radius: 50%; position: absolute; top: -20px; left: 50%; transform: translateX(-50%);" />
        </div>
                <!-- Logo Carousel Overlay -->
                {{-- <div id="logoCarousel" class="carousel slide" data-bs-ride="carousel" style="position: absolute; top: -60px; left: 50%; transform: translateX(-50%); width: 60px; height: 60px; border-radius: 50%; overflow: hidden;">
                  <div class="carousel-inner">
                      <div class="carousel-item active">
                          <img src="../assets/logo/agriculture.jpg" alt="logo-1" class="d-block w-100" style="height: 60px; border-radius: 50%;" />
                      </div>
                      <div class="carousel-item">
                          <img src="../assets/logo/Citylogo.jpg" alt="logo-2" class="d-block w-100" style="height: 60px; border-radius: 50%;" />
                      </div>
                      <div class="carousel-item">
                          <img src="landing_page/assets/images/footer/brands/Picture1.png" alt="logo-3" class="d-block w-100" style="height: 60px; border-radius: 50%;" />
                      </div>
                      <div class="carousel-item">
                          <img src="landing_page/assets/images/footer/brands/cs-logo.png" alt="logo-4" class="d-block w-100" style="height: 60px; border-radius: 50%;" />
                      </div>
                  </div>
              </div>
       --}}
        <!-- Heading with Modal Trigger -->
        {{-- <h1 class="ud-hero-title" data-toggle="modal" data-target="#infoModal" style="cursor: pointer;">
            Zambo AgriMap or Geo mapping
        </h1> --}}
        <h1 class="ud-hero-title" id="agriMapTitle" data-toggle="modal" data-target="#infoModal" style="cursor: pointer;">
          <!-- Title will be injected here -->
        </h1>
        <!-- Description Paragraph (hidden initially) -->
        <p class="ud-hero-desc" style="display:none;">
            Zambo AgriMap is an innovative geo-mapping tool designed specifically for Zamboanga City. It provides detailed
            agricultural data and spatial information, enabling stakeholders to make informed decisions about land use, crop
            planning, and resource allocation.
        </p>
    </div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="infoModalLabel">About Zambo AgriMap</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" id="modalBody">
         
          </div>
          {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div> --}}
      </div>
  </div>
</div>
   
{{-- 
<div class=" wow fadeInUp carousel slide" data-wow-delay=".25s" data-bs-ride="carousel">

    <div class="carousel-inner">
      <!-- First Carousel Item -->
      <div class="carousel-item active">
        <img src="landing_page/assets/images/hero/agrimap.png" alt="hero-image" class="d-block w-100" style="border-radius: 10%;">
      </div>
      <!-- Additional Carousel Items -->
      <div class="carousel-item">
        <img src="../assets/logo/agriculture.jpg" alt="shape" class="d-block w-100 shape shape-1" style="border-radius: 10%; width:100%">
      </div>
      <div class="carousel-item">
        <img src="landing_page/assets/images/hero/agrimap.png" alt="shape" class="d-block w-100 shape shape-2" style="border-radius: 10%;">
      </div>
    </div>
    
    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>

  
  <img
    src="landing_page/assets/images/hero/dotted-shape.svg"
    alt="shape"
    class="shape shape-1"
  />
  <img
    src="landing_page/assets/images/hero/dotted-shape.svg"
    alt="shape"
    class="shape shape-2"
  />
</div> --}}


        <div class="row mt-5">
          <div class="col-lg-12">
              <div class="tabs-container">
                <div class="container">
                  <ul class="nav nav-tabs justify-content-center" id="productionTabs" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" id="all-crops-tab" data-bs-toggle="tab" href="#all-crops" role="tab" aria-controls="all-crops" aria-selected="true">All Crops</a>
                      </li>
                      {{-- <li class="nav-item">
                          <a class="nav-link" id="agri-districts-tab" data-bs-toggle="tab" href="#agri-districts" role="tab" aria-controls="agri-districts" aria-selected="false">Agri Districts</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="grpas-tab" data-bs-toggle="tab" href="#grpas" role="tab" aria-controls="grpas" aria-selected="false">GRPAS</a>
                      </li> --}}
                      <li class="nav-item">
                          <a class="nav-link" id="farmers-tab" data-bs-toggle="tab" href="#farmers" role="tab" aria-controls="farmers" aria-selected="false">Farmers</a>
                      </li>
                  </ul>
              </div>
              
      
                  <div class="tab-content" id="productionTabsContent">
                      <!-- All Crops Tab Pane -->
                      <div class="tab-pane fade show active" id="all-crops" role="tabpanel" aria-labelledby="all-crops-tab">
                      <!-- Crop Name Dropdown -->

                            <div class="data-analytics-section text-center my-4 mb-2">
                              <h3 class="text-white">All Crops Production</h3>
                              <p class="mb-4">View the aggregated production data across all crops.</p>
                              <!-- Other content goes here -->
                            <!-- Crop Name Dropdown -->
                            {{-- <div class="row justify-content-left mb-3">
                              <div class="col-md-2"> <!-- Adjust column width for crop dropdown -->
                                  <select id="cropName" class="form-select form-select-sm"> <!-- Use form-select-sm for a smaller dropdown -->
                                      <option value="">All Crops</option>
                                      @foreach ($crops as $crop)
                                          <option value="{{ $crop }}">{{ ucwords(strtolower($crop)) }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              
                              <div class="col-md-2"> <!-- Adjust column width for district dropdown -->
                                 
                                  <select id="district" class="form-select form-select-sm">
                                      <option value="">All Districts</option>
                                      @foreach ($districts as $district)
                                          <option value="{{ $district }}">{{ ucwords(strtolower($district)) }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                           --}}
                           <div class="row justify-content-left mb-3">
                            <div class="col-md-2"> <!-- Adjust column width for crop dropdown -->
                                <select id="cropName" class="form-select form-select-sm"> <!-- Use form-select-sm for a smaller dropdown -->
                                    <option value="">All Crops</option>
                                    @foreach ($crops as $crop)
                                        <option value="{{ $crop }}">{{ ucwords(strtolower($crop)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-2"> <!-- Adjust column width for district dropdown -->
                                <select id="district" class="form-select form-select-sm">
                                    <option value="">All Districts</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district }}">{{ ucwords(strtolower($district)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- <div class="col-md-4"> <!-- Optional: You can add more filters like date range here -->
                                <input type="date" id="dateFrom" class="form-control form-control-sm" placeholder="Date From">
                                <input type="date" id="dateTo" class="form-control form-control-sm" placeholder="Date To">
                            </div> --}}
                        </div>
                        
                     
                        <div class="row no-gutters">

                          <!-- Card 1 -->
                          <div class="col-md-2">
                              <div class="card mb-4 card-style">
                                  <div class="card-body">
                               
                                      <h5 class="card-text" id="totalFarms"></h5>
                                      <div class="card-title-box" title="Total Farms">
                                        <p class="card-title" title="Total Farms">Total Farms</p>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      
                          <!-- Card 2 -->
                          <div class="col-md-2">
                              <div class="card mb-4 card-style">
                                  <div class="card-body">
                                     
                                      <h5 class="card-text" id="totalAreaPlanted"></h5>
                                      <div class="card-title-box" title="The Total Area Planted">
                                      <p class="card-title" title="The Total Area Planted">Total Area Planted</p>
                                  </div>
                                </div>
                              </div>
                          </div>
                      
                          <!-- Card 3 -->
                          <div class="col-md-2">
                              <div class="card mb-4 card-style">
                                  <div class="card-body">
                                     
                                      <h5 class="card-text" id="totalAreaYield"></h5>
                                      <div class="card-title-box" title="The Total Yield per area planted">
                                      <p class="card-title" title="The Total Yield per area planted">Total Yield/Area</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      
                          <!-- Card 4 -->
                          <div class="col-md-2">
                              <div class="card mb-4 card-style">
                                  <div class="card-body">
                                    
                                      <h5 class="card-text" id="totalCost"></h5>
                                      <div class="card-title-box" title="The Total Cost">
                                      <p class="card-title" title="The Total Cost">Total Cost</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      
                          <!-- Card 5 -->
                          <div class="col-md-2">
                              <div class="card mb-4 card-style">
                                  <div class="card-body">
                                 
                                      <h5 class="card-text" id="yieldPerAreaPlanted"></h5>
                                      <div class="card-title-box" title="The Yield per area planted">
                                      <p class="card-title" title="The Yield per area planted">Yield/Area Planted</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      
                          <!-- Card 6 -->
                          <div class="col-md-2">
                              <div class="card mb-4 card-style">
                                  <div class="card-body">
                                      
                                      <h5 class="card-text" id="averageCostPerAreaPlanted"></h5>
                                      <div class="card-title-box" title="The average cost per area planted">
                                      <p class="card-title" title="The average cost per area planted">Average Cost/Area</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      
                      </div>
                      
                              <div class="row">
                                
                                  <!-- Card 5 -->
                                  <div class="col-md-3">
                                      <div class="card mb-4">
                                          <div class="card-body">
                                            <div class="card-title-box" title="Farmer Yield per District">
                                              <p class="card-title" title="Farmer Yield per District">Yield/District </p>
                                            </div>
                                              <canvas id="pieChart" width="150px" height="150px"></canvas>
                                      
                                          </div>
                                      </div>
                                  </div>
                                  <!-- Card 6 -->
                                  <div class="col-md-3">
                                      <div class="card mb-4">
                                          <div class="card-body">
                                            <div class="card-title-box" title="Farmers Crop Production">
                                              <p class="card-title" title="Farmers Crop Production"> Production</p>
                                            </div>
                                              <canvas id="donutChart" width="150px" height="150px"></canvas>
                                           
                                          </div>
                                      </div>
                                  </div>
                                  <!-- Card 7 -->
                                  <div class="col-md-3">
                                      <div class="card mb-4">
                                          <div class="card-body">
                                            <div class="card-title-box" title="Tenurial Status Distribution">
                                              <p class="card-title" title="Tenurial Status Distribution">Farm Tenurial  </p>
                                            </div>
                                             <canvas id="radialChart"></canvas>

                                         
                                          </div>
                                      </div>
                                  </div>
                                  <!-- Card 8 -->
                                  <div class="col-md-3">
                                      <div class="card mb-4">
                                          <div class="card-body">
                                            <div class="card-title-box"  title="No. of Crop Varieties per District ">
                                              <p class="card-title" title="No. of Crop Varieties per District "> Varieties/District </p>
                                            </div>
                                              <canvas id="barChart" width="150px" height="150px"></canvas>
                                              
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
      
                      <!-- Agri Districts Tab Pane -->
                      {{-- <div class="tab-pane fade" id="agri-districts" role="tabpanel" aria-labelledby="agri-districts-tab">
                          <div class="data-analytics-section text-center my-4 mb-3">
                              <h3 class="text-white">Production by Agri Districts</h3>
                              <p class="mb-4" >Analyze production data by specific agricultural districts.</p>
                              <div class="table-responsive">
                                  <table class="table table-striped table-bordered">
                                      <thead>
                                          <tr>
                                              <th>District</th>
                                              <th>Crop Name</th>
                                              <th>Production (tons)</th>
                                              <th>Yield per Hectare (kg/ha)</th>
                                              <th>Area Planted (ha)</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <th>District 1</th>
                                              <td>Rice</td>
                                              <td>300</td>
                                              <td>2100</td>
                                              <td>150</td>
                                          </tr>
                                          <tr>
                                              <th>District 2</th>
                                              <td>Corn</td>
                                              <td>200</td>
                                              <td>1400</td>
                                              <td>100</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div> --}}
      
                      <!-- GRPAS Tab Pane -->
                      {{-- <div class="tab-pane fade" id="grpas" role="tabpanel" aria-labelledby="grpas-tab">
                          <div class="data-analytics-section text-center my-4 mb-2">
                              <h3 class="text-white">GRPAS Data Analysis</h3>
                              <p class="mb-4">Explore production statistics per GRPAS classification.</p>
                              <div class="table-responsive">
                                  <table class="table table-striped table-bordered">
                                      <thead>
                                          <tr>
                                              <th>GRPAS Category</th>
                                              <th>Crop Name</th>
                                              <th>Production (tons)</th>
                                              <th>Yield per Hectare (kg/ha)</th>
                                              <th>Area Planted (ha)</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <th>High Yield</th>
                                              <td>Rice</td>
                                              <td>500</td>
                                              <td>2200</td>
                                              <td>230</td>
                                          </tr>
                                          <tr>
                                              <th>Moderate Yield</th>
                                              <td>Corn</td>
                                              <td>320</td>
                                              <td>1500</td>
                                              <td>210</td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div> --}}
      
                      <!-- Farmers Tab Pane -->
                      <div class="tab-pane fade" id="farmers" role="tabpanel" aria-labelledby="farmers-tab">
                          <div class="data-analytics-section text-center my-4 mb-3">
                              <h3 class="text-white">Rice Farmers Zamboanga City</h3>
                              <p class="mb-4">Details about farmers involved in crop production.</p>
                              <div class="row">
                                <!-- Card 1 -->
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                          <div class="card-title-box" title="Total Yield per Cropping">
                                            <p class="card-title" title="Total Yield per Cropping">Yield/Cropping</p>
                                        </div>
                                         
                                            {{-- <p class="card-text">Production: 450 tons</p>
                                            <canvas id="grossIncomePieChart" width="400" height="200"></canvas> --}}
                                            <canvas id="croppingDoughnutChart" width="185" height="185"></canvas>
                                            

                                          
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 2 -->
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                         
                                            <div class="card-title-box" title="Total Farmers Gross Income">
                                              <p class="card-title" title="Total Yield per Cropping">Gross Income</p>
                                          </div>
                                          
                                            <canvas id="grossIncomePieChart" width="185" height="185"></canvas>
                                          
                                     
                                    </div>
                                </div>
                              </div>
                                <!-- Card 3 -->
                               
                                <!-- Card 4 -->
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                           
                                            <div class="card-title-box" title="Total Machinery Costs perCropping">
                                              <p class="card-title" title="Total Yield per Cropping">Machineries Cost</p>
                                          </div>
                                            <div id="machineryCostPieChart" style="height: 110px; max-width:145px; margin: 0 auto;"></div> <!-- Ensure height is sufficient -->

                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="card mb-4">
                                      <div class="card-body">
                                        
                                          <div class="card-title-box" title="Total Variable Cost per Cropping">
                                            <p class="card-title" title="Total Yield per Cropping">Variable Cost</p>
                                        </div>
                                          <div id="variableCostPieChart" style="height: 110px; max-width:145px; margin: 0 auto;"></div>
                                      </div>
                                  </div>
                              </div>
                                {{-- <!-- Card 5 -->
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                          <h5 class="card-title">Gender</h5>
                                          <canvas id="genderChart" width="180" height="180"></canvas>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 6 -->
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Barley</h5>
                                            <p class="card-text">Production: 220 tons</p>
                                            <p class="card-text">Yield per Hectare: 1900 kg/ha</p>
                                            <p class="card-text">Area Planted: 130 ha</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 7 -->
                                <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Potato</h5>
                                            <p class="card-text">Production: 340 tons</p>
                                            <p class="card-text">Yield per Hectare: 2100 kg/ha</p>
                                            <p class="card-text">Area Planted: 160 ha</p>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- Card 8 -->
                                {{-- <div class="col-md-3">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Tomato</h5>
                                            <p class="card-text">Production: 400 tons</p>
                                            <p class="card-text">Yield per Hectare: 2200 kg/ha</p>
                                            <p class="card-text">Area Planted: 180 ha</p>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      
      </div>
    </section>
    
    <!-- ====== Hero End ====== -->

    <!-- ====== Features Start ====== --> 
    <section id="features" class="ud-features">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="ud-section-title">
              <span>Features</span>
              
              <h2 id="agriMapFeature"  data-toggle="modal" data-target="#feautureModal" style="cursor: pointer;"></h2>
              
            </div>
            <div class="modal fade" id="feautureModal" tabindex="-1" role="dialog" aria-labelledby="feautureModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="feautureModalLabel">About Zambo AgriMap Feauture</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body" id="agriMapdescriptionFeature">
                     
                      </div>
                      {{-- <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div> --}}
                  </div>
              </div>
            </div>
               
          </div>
        </div>
        <div id="featuresContainer"></div>
        <!-- Used Feature Modal Structure -->
<div class="modal fade" id="UsedFEAUTUREMODAL" tabindex="-1" role="dialog" aria-labelledby="UsedFEAUTUREMODALLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="UsedFEAUTUREMODALLabel">Feature Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body" id="modalBodyUsedFeature">
              <!-- Dynamic content will be injected here -->
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

              <!-- boostrap company model -->
        <div class="modal fade" id="company-modal" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content" style="background-image: url(https://watchmendailyjournal.com/wp-content/uploads/2023/04/da.jpg);">
              <div class="modal-header">
                <h4 class="modal-title" id="CompanyModal"></h4>
              </div>
              <div class="modal-body">
                @if($errors->any())
                <ul class="alert alert-warning">
                  @foreach ($errors->all() as $error)
                  <li>{{$error}}</li>
                  @endforeach
                </ul>
                @endif
           
        </div>
      </div>
      <!-- end bootstrap model -->
      
    </body>
  
    </html>         
                 
          </div>
        </div>
      </div>
    </section>
    <!-- ====== Features End ====== -->

    <!-- ====== About Start ====== -->
    <section id="about" class="ud-about">
      <div class="container">
        <div class="ud-about-wrapper wow fadeInUp" data-wow-delay=".2s">
          <div class="ud-about-content-wrapper">
            <div class="ud-about-content">
              <span class="tag">About Us</span>
              <h2 id="agriMapWelcomeTitle"></h2>
              <p id="modalDescription">
               
              <h2 id="agriMapMission"></h2>
              <p id="agriMapdescriptionMission">
               
              </p>
             
              <h2 id="agriMapVision"></h2>
              <p id="agriMapdescriptionVision">
              
              </p>
              {{-- <a href="javascript:void(0)" class="ud-main-btn">Learn More</a> --}}
            </div>
          </div>
          <div class="ud-about-image">
            <img src="landing_page/assets/images/about/about-image.svg" alt="about-image" />
          </div>
        </div>
      </div>
    </section>
    <!-- ====== About End ====== -->

  
    <!-- ====== Contact Start ====== -->
    <section id="contact" class="ud-contact">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-8 col-lg-7">
            <div class="ud-contact-content-wrapper">
              <div class="ud-contact-title">
                <span>CONTACT US</span>
                <h2>
                  Let’s talk about <br />
                  Love to hear from you!
                </h2>
              </div>
              <div class="ud-contact-info-wrapper">
                <div class="ud-single-info">
                  <div class="ud-info-icon">
                    <i class="lni lni-map-marker"></i>
                  </div>
                  <div class="ud-info-meta">
                    <h5>Our Location</h5>
                    <p>Normal Road, Western Mindanao State University, 
                      CCS at campus B ,Zamboanga City, Philippines </p>
                  </div>
                </div>
                <div class="ud-single-info">
                  <div class="ud-info-icon">
                    <i class="lni lni-envelope"></i>
                  </div>
                  <div class="ud-info-meta">
                    <h5>How Can We Help?</h5>
                    <p>agrimapzambo@gmail.com</p>
                    <p>contact#:09925280948</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    <!-- ====== Contact End ====== -->

    <!-- ====== Footer Start ====== -->
    <footer class="ud-footer wow fadeInUp" data-wow-delay=".15s">
      <div class="shape shape-1">
        <img src="landing_page/assets/images/footer/shape-1.svg" alt="shape" />
      </div>
      <div class="shape shape-2">
        <img src="landing_page/assets/images/footer/shape-2.svg" alt="shape" />
      </div>
      <div class="shape shape-3">
        <img src="landing_page/assets/images/footer/shape-3.svg" alt="shape" />
      </div>
      <div class="ud-footer-widgets">
        <div class="container">
          <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6">
              <div class="ud-widget">
                {{-- <a href="index.html" class="ud-footer-logo">
                  <img src="landing_page/assets/images/logo/logo.png" alt="logo" />
                </a> --}}
                <div class="ud-hero-brands-wrapper wow fadeInUp " data-wow-delay=".3s">
                  <img src="landing_page/assets/images/logo/logo-main.png" alt="header-logo" style="width: 60px; height:60px;border-radius: 50%; position: absolute; top: -20px; left: 20%; transform: translateX(-50%);" />
              </div>
                <p class="ud-widget-desc">
                  Zambo AgriMap is an innovative geo-mapping tool
                  designed specifically for Zamboanga City. 
                </p>
                <ul class="ud-widget-socials">
                  <li>
                    <a href="">
                      <i class="lni lni-facebook-filled"></i>
                    </a>
                  </li>
                  <li>
                    <a href="">
                      <i class="lni lni-twitter-filled"></i>
                    </a>
                  </li>
                  <li>
                    <a href="">
                      <i class="lni lni-instagram-filled"></i>
                    </a>
                  </li>
                  {{-- <li>
                    <a href="https://twitter.com/MusharofChy">
                      <i class="lni lni-linkedin-original"></i>
                    </a>
                  </li> --}}
                </ul>
              </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
              <div class="ud-widget">
                <h5 class="ud-widget-title">About Us</h5>
                <ul class="ud-widget-links">
                  <li>
                    <a href="#home">Home</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Features</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">About</a>
                  </li>
                  {{-- <li>
                    <a href="javascript:void(0)">Testimonial</a>
                  </li> --}}
                </ul>
              </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6">
              <div class="ud-widget">
                <h5 class="ud-widget-title">Features</h5>
                <ul class="ud-widget-links">
                  <li>
                    <a href="javascript:void(0)">How it works</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Privacy policy</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Terms of service</a>
                  </li>
                  {{-- <li>
                    <a href="javascript:void(0)">Refund policy</a>
                  </li> --}}
                </ul>
              </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6">
              <div class="ud-widget">
                <h5 class="ud-widget-title">Government Sector</h5>
                <ul class="ud-widget-links">
                  <li>
                    <a
                      href="https://lineicons.com/"
                      rel="nofollow noopner"
                      target="_blank"
                      >add Link
                    </a>
                  </li>
                  <li>
                    <a
                      href="https://ecommercehtml.com/"
                      rel="nofollow noopner"
                      target="_blank"
                      >Add Link</a
                    >
                  </li>
                  <li>
                    <a
                      href="https://ayroui.com/"
                      rel="nofollow noopner"
                      target="_blank"
                      >Add Link</a
                    >
                  </li>
              
                </ul>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-8 col-sm-10">
              <div class="ud-widget">
                <h5 class="ud-widget-title">Partners</h5>
                <ul class="ud-widget-brands">
                  <li>
                    <a
                      href="http://wmsu.edu.ph/"
                      rel="WMSU"
                      target="_blank"
                    >
                      <img 
                         src="landing_page/assets/images/footer/brands/Picture1.png"
                        alt="WMSU" 
                      />
                    </a>
                  </li>
                  <li>
                    <a
                      href=""
                      rel="nofollow noopner"
                      target="_blank"
                    >
                      <img
                        src="landing_page/assets/images/footer/brands/cs-logo.png"
                        alt="CCS"
                      />
                    </a>
                  </li>
                  <li>
                    <a
                      href=""
                      rel="nofollow noopner"
                      target="_blank"
                    >
                      <img
                        src="landing_page/assets/images/footer/brands/agri-logo.png"
                        alt="graygrids"
                      />
                    </a>
                  </li>
                  <li>
                    <a
                      href=""
                      rel="nofollow noopner"
                      target="_blank"
                    >
                      <img
                        src="../assets/logo/Citylogo.jpg" style="border-radius: 50%;"
                        alt="lineicons"
                      />
                    </a>
                  </li>
                  <li>
                    {{-- <a
                      href="https://uideck.com/"
                      rel="nofollow noopner"
                      target="_blank"
                    >
                      <img
                        src="landing_page/assets/images/footer/brands/uideck.svg"
                        alt="uideck"
                      />
                    </a> --}}
                  </li>
                  <li>
                    {{-- <a
                      href="https://tailwindtemplates.co/"
                      rel="nofollow noopner"
                      target="_blank"
                    >
                      <img
                        src="landing_page/assets/images/footer/brands/tailwindtemplates.svg"
                        alt="tailwindtemplates"
                      />
                    </a> --}}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ud-footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <ul class="ud-footer-bottom-left">
                {{-- <li>
                  <a href="javascript:void(0)">Privacy policy</a>
                </li>
                <li>
                  <a href="javascript:void(0)">Support policy</a>
                </li>
                <li>
                  <a href="javascript:void(0)">Terms of service</a>
                </li> --}}
              </ul>
            </div>
            {{-- <div class="col-md-4">
              <p class="ud-footer-bottom-right">
               Developed by
                <a href="https://uideck.com" rel="nofollow">OJR</a>
              </p>
            </div> --}}
          </div>
        </div>
      </div>
    </footer>
    <!-- ====== Footer End ====== -->

    <!-- ====== Back To Top Start ====== -->
    <a href="javascript:void(0)" class="back-to-top">
      <i class="lni lni-chevron-up"> </i>
    </a>
    <!-- ====== Back To Top End ====== -->

    <!-- ====== All Javascript Files ====== -->
    <script src="landing_page/assets/js/bootstrap.bundle.min.js"></script>
    <script src="landing_page/assets/js/wow.min.js"></script>
    <script src="landing_page/assets/js/main.js"></script>
    <script src="landing_page/assets/js/auth.js"></script>
    <script src="landing_page/assets/js/signup.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script>
      // ==== for menu scroll
      const pageLink = document.querySelectorAll(".ud-menu-scroll");

      pageLink.forEach((elem) => {
        elem.addEventListener("click", (e) => {
          e.preventDefault();
          document.querySelector(elem.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
            offsetTop: 1 - 60,
          });
        });
      });

      // section menu active
      function onScroll(event) {
        const sections = document.querySelectorAll(".ud-menu-scroll");
        const scrollPos =
          window.pageYOffset ||
          document.documentElement.scrollTop ||
          document.body.scrollTop;

        for (let i = 0; i < sections.length; i++) {
          const currLink = sections[i];
          const val = currLink.getAttribute("href");
          const refElement = document.querySelector(val);
          const scrollTopMinus = scrollPos + 73;
          if (
            refElement.offsetTop <= scrollTopMinus &&
            refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
          ) {
            document
              .querySelector(".ud-menu-scroll")
              .classList.remove("active");
            currLink.classList.add("active");
          } else {
            currLink.classList.remove("active");
          }
        }
      }

      window.document.addEventListener("scroll", onScroll);
    </script>

<script>
$(document).ready(function() {
    // Set a timeout to close the modal after 0.02 seconds (20 milliseconds)
    $('#infoModal').on('shown.bs.modal', function () {
        setTimeout(function () {
            $('#infoModal').modal('hide');
        }, 10); // 20 milliseconds
    });
});
  </script>
    @include('modal.login')
    @include('modal.register')


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
   
   $(document).ready(function() {
    // Fetch landing page data when the document is ready
    $.ajax({
        url: '/landing-page-data', // The route to fetch the data
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data); // Log the response data to see its structure

            // Inject the title into the h1 element
            $('#agriMapTitle').text(data.home_title);
            $('#modalBody').text(data.home_description);
            $('#agriMapFeature').text(data.feature_header);
            $('#agriMapdescriptionFeature').text(data.feature_description);

            // When the modal is shown, populate the modal body with content
            $('#infoModal').on('show.bs.modal', function () {
                $(this).find('.modal-body').html(data.home_description);
            });

         // Clear the container and loop over each feature
$('#featuresContainer').empty(); // Clear existing content if needed
let featureHtml = ''; // Initialize an empty string to accumulate feature HTML

data.features.forEach(function(feature) {
    // Construct the feature HTML
    featureHtml += `
        <div class="col-xl-3 col-lg-3 col-sm-6">
            <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
                <div class="ud-feature-icon">
                    <!-- Display the image icon instead of using the <i> tag -->
                    <img src="${feature.icon}" alt="Feature Icon" class="feature-icon">
                </div>
                <div class="ud-feature-content">
                    <h3 class="ud-feature-title">${feature.agri_features}</h3>
                    <p>${feature.agri_description}</p>
                    <a href="javascript:void(0)" class="ud-feature-link" 
                    //    data-description="${feature.agri_description}" 
                       data-toggle="modal" 
                       data-target="#UsedFEAUTUREMODAL">Learn More</a>
                </div>
            </div>
        </div>
    `;
});

// Append all features at once, wrapped in a row
$('#featuresContainer').append(`<div class="row">${featureHtml}</div>`);

            // When the UsedFEAUTUREMODAL is shown, populate the modal body with the feature description
            $('#UsedFEAUTUREMODAL').on('show.bs.modal', function (event) {
                // Get the link that triggered the modal
                var link = $(event.relatedTarget); // Button that triggered the modal
                var description = link.data('description'); // Extract info from data-* attributes

                // Update the modal's content
                $(this).find('.modal-body','#modalBodyUsedFeature').html(description);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching landing page data:', error);
        }
    });
});



// fetch contact us

$(document).ready(function() {
    // Fetch landing page data when the document is ready
    $.ajax({
        url: '/Contact-Us', // The route to fetch the data
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data); // Log the response data to see its structure

            // Inject the title into the h1 element
            $('#agriMapTitle').text(data.home_title);
            $('#modalBody').text(data.home_description);
            $('#agriMapFeature').text(data.feature_header);
            $('#agriMapdescriptionFeature').text(data.feature_description);

            // When the modal is shown, populate the modal body with content
            $('#infoModal').on('show.bs.modal', function () {
                $(this).find('.modal-body').html(data.home_description);
            });

            // // Clear the container and loop over each feature
            // $('#featuresContainer').empty(); // Clear existing content if needed
            // let featureHtml = ''; // Initialize an empty string to accumulate feature HTML

            // data.features.forEach(function(feature) {
            //     // Use a more descriptive variable for the feature description
            
            //     featureHtml += `
            //         <div class="col-xl-3 col-lg-3 col-sm-6">
            //             <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
            //                 <div class="ud-feature-icon">
            //                     <i class="${feature.icon}"></i>
            //                 </div>
            //                 <div class="ud-feature-content">
            //                     <h3 class="ud-feature-title">${feature.agri_features}</h3>
            //                     <p>${feature.agri_description}</p>
            //                     <a href="javascript:void(0)" class="ud-feature-link" 
            //                        data-description="${feature.agri_description}" 
            //                        data-toggle="modal" 
            //                        data-target="#UsedFEAUTUREMODAL">Learn More</a>
            //                 </div>
            //             </div>
            //         </div>
            //     `;
            // });

            // // Append all features at once, wrapped in a row
            // $('#featuresContainer').append(`<div class="row">${featureHtml}</div>`);

            // // When the UsedFEAUTUREMODAL is shown, populate the modal body with the feature description
            // $('#UsedFEAUTUREMODAL').on('show.bs.modal', function (event) {
            //     // Get the link that triggered the modal
            //     var link = $(event.relatedTarget); // Button that triggered the modal
            //     var description = link.data('description'); // Extract info from data-* attributes

            //     // Update the modal's content
            //     $(this).find('.modal-body','#modalBodyUsedFeature').html(description);
            // });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching landing page data:', error);
        }
    });
});



// fetch About us

$(document).ready(function() {
    // Fetch landing page data when the document is ready
    $.ajax({
        url: '/About-Us', // The route to fetch the data
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data); // Log the response data to see its structure

            // Inject the title into the h1 element
            $('#agriMapWelcomeTitle').text(data.welcome_title);
            $('#modalDescription').text(data.welcome_description);
            $('#agriMapMission').text(data.mission_header);
            $('#agriMapdescriptionMission').text(data.mission_description);
            $('#agriMapVision').text(data.vision);
            $('#agriMapdescriptionVision').text(data.vision_description);

            // When the modal is shown, populate the modal body with content
            $('#infoModal').on('show.bs.modal', function () {
                $(this).find('.modal-body').html(data.home_description);
            });
          
            
            // // Clear the container and loop over each feature
            // $('#featuresContainer').empty(); // Clear existing content if needed
            // let featureHtml = ''; // Initialize an empty string to accumulate feature HTML

            // data.features.forEach(function(feature) {
            //     // Use a more descriptive variable for the feature description
            
            //     featureHtml += `
            //         <div class="col-xl-3 col-lg-3 col-sm-6">
            //             <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
            //                 <div class="ud-feature-icon">
            //                     <i class="${feature.icon}"></i>
            //                 </div>
            //                 <div class="ud-feature-content">
            //                     <h3 class="ud-feature-title">${feature.agri_features}</h3>
            //                     <p>${feature.agri_description}</p>
            //                     <a href="javascript:void(0)" class="ud-feature-link" 
            //                        data-description="${feature.agri_description}" 
            //                        data-toggle="modal" 
            //                        data-target="#UsedFEAUTUREMODAL">Learn More</a>
            //                 </div>
            //             </div>
            //         </div>
            //     `;
            // });

            // // Append all features at once, wrapped in a row
            // $('#featuresContainer').append(`<div class="row">${featureHtml}</div>`);

            // // When the UsedFEAUTUREMODAL is shown, populate the modal body with the feature description
            // $('#UsedFEAUTUREMODAL').on('show.bs.modal', function (event) {
            //     // Get the link that triggered the modal
            //     var link = $(event.relatedTarget); // Button that triggered the modal
            //     var description = link.data('description'); // Extract info from data-* attributes

            //     // Update the modal's content
            //     $(this).find('.modal-body','#modalBodyUsedFeature').html(description);
            // });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching landing page data:', error);
        }
    });
});

      </script>
    <script>
      $(document).ready(function () {
      // Initialize chart variables
      let pieChart, barChart, donutChart, lineChart , radialChart;
      ;
      
      // Function to format numbers with commas
      function formatNumber(number, decimals = 2) {
          return new Intl.NumberFormat('en-US', {
              minimumFractionDigits: decimals,
              maximumFractionDigits: decimals
          }).format(number);
      }
      
      // Function to fetch data based on selected filters for charts
      function fetchData() {
          var cropName = $('#cropName').val();
          var dateFrom = $('#dateFrom').val();
          var dateTo = $('#dateTo').val();
          var district = $('#district').val();
      
          // AJAX request for dashboard data
          $.ajax({
              url: '/',
              method: 'GET',
              data: {
                  crop_name: cropName,
                  dateFrom: dateFrom,
                  dateTo: dateTo,
                  district: district
              },
              success: function (data) {
                  // Update metrics
                  $('#totalFarms').text(formatNumber(data.totalFarms, 0));
                  $('#totalAreaPlanted').text(formatNumber(data.totalAreaPlanted || 0));
                  $('#totalAreaYield').text(formatNumber(data.totalAreaYield || 0));
                  $('#totalCost').text(formatNumber(data.totalCost || 0, 2));
                  $('#yieldPerAreaPlanted').text(formatNumber(data.yieldPerAreaPlanted || 0));
                  $('#averageCostPerAreaPlanted').text(formatNumber(data.averageCostPerAreaPlanted || 0));
                  $('#totalRiceProduction').text(formatNumber(data.totalRiceProduction || 0, 2));
                  // Check if distributionFrequency exists in the response
                  // if (data.distributionFrequency) {
                  //           updatePieCharts(data.distributionFrequency);
                  //       }
                  //   },
                  // Check for chart data and update charts
                  if (data.pieChartData) {
                      updatePieChart(data.pieChartData);
                  }
                  
                  if (data.barChartData) {
                      updateBarChart(data.barChartData);
                  }
                  if (data.donutChartData) {
                      updateDonutChart(data.donutChartData);
                  }
                  if (data.radialChartData) {
                      updateRadialChart(data.radialChartData, 'Tenurial Status Distribution');
                  }

                  // Populate farmers' data
                  // populateFarmers(data.farmers.data); // Assuming data.farmers is the paginated farmers array
              },
              error: function (jqXHR, textStatus, errorThrown) {
                  console.error('Error fetching data:', textStatus, errorThrown);
                  alert('Error fetching data. Please try again.');
              }
          });
      }
      
      // Function to populate farmers' data in the table
      
      
      
      
       
      
          // Example: Fetch data on filter change (dropdown change or date range change)
          $('#cropName, #district, #dateFrom, #dateTo').change(function () {
              fetchData();
          });
      
          // // Handle pagination links click event
          // $(document).on('click', '.pagination a', function (e) {
          //     e.preventDefault();
          //     var page = $(this).attr('href').split('page=')[1];
          //     console.log('Clicked page number: ', page);
          //     fetchFarmersData(page);
          // });
      
          // Initial fetch to display default data
          fetchData();
      
     

        
function updateRadialChart(radialChartData, chartTitle) {
    if (!radialChartData || !radialChartData.labels || !radialChartData.datasets) {
        console.error('Invalid radial chart data:', radialChartData);
        return;
    }

    const ctx = document.getElementById('radialChart').getContext('2d'); // Get the context for the chart

    // If a chart instance already exists, destroy it
    if (radialChart) {
        radialChart.destroy();
    }

    // Calculate the total count
    const totalCount = radialChartData.datasets.reduce((total, dataset) => {
        return total + dataset.data.reduce((sum, value) => sum + value, 0);
    }, 0);

    // Create a new radial chart instance
    radialChart = new Chart(ctx, {
        type: 'doughnut', // Change to 'pie' if you prefer a pie chart
        data: {
            labels: radialChartData.labels, // Use labels from data
            datasets: radialChartData.datasets.map((dataset) => ({
                label: dataset.label, // Label for the dataset
                data: dataset.data, // Data for the dataset
                backgroundColor: dataset.backgroundColor, // Background colors for the segments
                hoverOffset: 4 // Optional hover effect
            }))
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: ` Total: ${totalCount}`, // Include total in the title
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const datasetLabel = tooltipItem.dataset.label || '';
                            const dataValue = tooltipItem.raw;
                            return `${datasetLabel}: ${dataValue}`;
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'bottom', // Position of the legend
                    labels: {
                        boxWidth: 10, // Size of the box next to each legend label
                        padding: 8, // Padding between legend items
                        font: {
                            size: 12 // Font size for legend labels
                        }
                    }
                }
            }
        }
    });
}
          
                  // Function to update the Pie Chart
             // Function to update the Pie Chart
             function updatePieChart(pieChartData) {
    // Validate the pie chart data structure
    if (!pieChartData || !pieChartData.labels || !pieChartData.datasets) {
        console.error('Invalid pie chart data:', pieChartData);
        return;
    }

    // Calculate total yield across all districts, format to two decimal places, and add commas
    const totalYield = pieChartData.datasets[0].data
        .reduce((acc, value) => acc + value, 0)
        .toFixed(2)  // Format to two decimal places
        .toLocaleString();

    const ctx = document.getElementById('pieChart').getContext('2d');

    // Destroy the existing chart instance if it exists
    if (typeof pieChart !== 'undefined') {
        pieChart.destroy();
    }

    // Function to capitalize each word in a string
    function capitalizeWords(str) {
        return str.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Create a new pie chart
    pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: pieChartData.labels.map(label => capitalizeWords(label)), // Capitalize labels
            datasets: [{
                data: pieChartData.datasets[0].data,
                backgroundColor: pieChartData.datasets[0].backgroundColor,
                hoverBackgroundColor: pieChartData.datasets[0].hoverBackgroundColor
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 9,
                        padding: 4,
                        font: {
                            size: 10
                        }
                    },
                    maxWidth: 400,
                },
                title: {
                    display: true,
                    text: `Total Yield: ${totalYield} kg`, // Corrected template literal
                    font: {
                        size: 12
                    },
                    padding: {
                        top: 3,
                        bottom: 3
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const districtName = capitalizeWords(pieChartData.labels[tooltipItem.dataIndex]);
                            return `${districtName}: ${tooltipItem.raw} kg`; // Using template literal for tooltip
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 2,
                    bottom: 2
                }
            }
        }
    });
}

function updateBarChart(barChartData) {
    // Check if barChartData is valid
    if (!barChartData || !barChartData.labels || !barChartData.datasets) {
        console.error('Invalid bar chart data:', barChartData);
        return;
    }

    // Log the bar chart data to the console for debugging
    console.log('Bar Chart Data:', barChartData);

    const ctx = document.getElementById('barChart').getContext('2d');

    // Destroy the existing chart if it exists
    if (typeof barChart !== 'undefined') {
        barChart.destroy();
    }

    // Function to capitalize each word in a string
    function capitalizeWords(str) {
        return str.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Define an array of colors for each district
    const colors = ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'];

    // Calculate the total count across all datasets
    const totalCount = barChartData.datasets.reduce((acc, dataset) => {
        return acc + dataset.data.reduce((sum, value) => sum + value, 0);
    }, 0);

    // Create a new chart instance
    barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: barChartData.labels.map(label => capitalizeWords(label)), // Apply capitalization to labels
            datasets: barChartData.datasets.map((dataset, index) => ({
                label: capitalizeWords(dataset.label), // Capitalize dataset labels
                data: dataset.data,
                backgroundColor: colors[index % colors.length], // Assign colors based on index
                borderColor: colors[index % colors.length], // Use the same color for border
                borderWidth: 1,
                varieties: dataset.varieties // Include varieties for tooltip display
            }))
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom', // Align legend at the bottom
                    labels: {
                        font: {
                            size: 12, // Adjust font size if needed
                        },
                        boxWidth: 7 // Adjust the size of the color box in the legend
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const dataset = tooltipItem.dataset;
                            const count = dataset.data[tooltipItem.dataIndex];
                            const varieties = dataset.varieties[tooltipItem.dataIndex]; // Get the varieties for this dataset
                            const districtName = capitalizeWords(barChartData.labels[tooltipItem.dataIndex]); // Capitalize district names
                            return `${dataset.label}: ${count} (Varieties: ${varieties}) - District: ${districtName}`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: `Total: ${totalCount}`, // Include total count in title
                    font: {
                        size: 12, // Title font size
                        weight: 'bold' // Title font weight
                    },
                    padding: {
                        top: 2,
                        bottom: 2
                    }
                }
            }
        }
    });
}

      
function updateDonutChart(donutChartData, centerText, chartTitle) {
    if (!donutChartData || !donutChartData.labels || !donutChartData.datasets) {
        console.error('Invalid donut chart data:', donutChartData);
        return;
    }

    const ctx = document.getElementById('donutChart').getContext('2d');
    if (typeof donutChart !== 'undefined') {
        donutChart.destroy();
    }

    // Function to convert text to title case (capitalize initial letters)
    function capitalizeWords(str) {
        return str.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Calculate total production
    const totalProduction = donutChartData.datasets[0].data.reduce((acc, value) => acc + value, 0);

    // Custom plugin to add text in the center
    const centerTextPlugin = {
        id: 'centerText',
        afterDatasetsDraw: function(chart) {
            const { width, height } = chart;
            const ctx = chart.ctx;
            const fontSize = (height / 314).toFixed(2);

            ctx.restore();
            ctx.font = `${fontSize}em sans-serif`;
            ctx.textBaseline = 'middle';

            // Add center text
            const textX = Math.round((width - ctx.measureText(centerText || totalProduction.toFixed(2) + ' %').width) / 2);
            const textY = height / 2;

            ctx.fillStyle = '#000'; // Set text color
         

            ctx.save();
        }
    };

    donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: donutChartData.labels.map(label => capitalizeWords(label)), // Capitalize labels
            datasets: [{
                label: 'Crops Production',
                data: donutChartData.datasets[0].data,
                backgroundColor: donutChartData.datasets[0].backgroundColor,
                hoverBackgroundColor: donutChartData.datasets[0].hoverBackgroundColor
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10, // Size of the box next to each legend label
                        padding: 4, // Padding between legend items
                        font: {
                            size: 10 // Font size for legend labels
                        }
                    }
                },
                title: {
                    display: true,
                    text: `${chartTitle || ''} Total ${totalProduction.toFixed(2)} tons`,
                   
                    font: {
                        size: 12,
                        weight: 'bold'
                    },
                    padding: {
                        top: 1,
                        bottom: 1
                    }
                },

                
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const cropName = capitalizeWords(donutChartData.labels[tooltipItem.dataIndex]);
                            return cropName + ': ' + tooltipItem.raw + '%';
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 2,
                    bottom: 2
                }
            }
        },
        plugins: [centerTextPlugin] // Include the custom plugin for center text
    });
}

// Function to update the Line Chart
// Function to update the Line Chart
// function updateLineChart(lineChartData, chartTitle) {
//     if (!lineChartData || !lineChartData.labels || !lineChartData.datasets) {
//         console.error('Invalid line chart data:', lineChartData);
//         return;
//     }

//     const ctx = document.getElementById('lineChart').getContext('2d');
//     if (typeof lineChart !== 'undefined') {
//         lineChart.destroy();
//     }

//     // Calculate total production across all datasets
//     const totalProduction = lineChartData.datasets.reduce((total, dataset) => {
//         return total + dataset.data.reduce((sum, value) => sum + value, 0);
//     }, 0);

//     lineChart = new Chart(ctx, {
//         type: 'line',
//         data: {
//             labels: lineChartData.labels,
//             datasets: lineChartData.datasets.map((dataset) => ({
//                 label: dataset.label,
//                 data: dataset.data,
//                 borderColor: dataset.borderColor || ['ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
//                 backgroundColor: dataset.backgroundColor || ['ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
//                 fill: true
//             }))
//         },
//         options: {
//             responsive: true,
//             scales: {
//                 y: {
//                     beginAtZero: true
//                 }
//             },
//             plugins: {
//                 title: {
//                     display: true,
//                     // Set title to include total production
//                     text: `${chartTitle || ''} Total ${totalProduction.toFixed(2)}`,
//                     font: {
//                         size: 12,
//                         weight: 'bold'
//                     }
//                 },
//                 tooltip: {
//                     callbacks: {
//                         label: function(tooltipItem) {
//                             const datasetLabel = tooltipItem.dataset.label || '';
//                             const dataValue = tooltipItem.raw;
//                             return `${datasetLabel}: ${dataValue}`;
//                         }
//                     }
//                 },
//                 legend: {
//                     display: true,
//                     position: 'bottom', // Set the legend position to bottom
//                     labels: {
//                         boxWidth: 7, // Size of the box next to each legend label
//                         padding: 4, // Padding between legend items
//                         font: {
//                             size: 10 // Font size for legend labels
//                         }
//                     }
//                 }
//             }
//         }
//     });
// }



          
                  $(document).ready(function () {
          $('#printButton').click(function () {
              printReport();
          });
      });
      function printReport() {
          // Get content of the charts
          const pieChartContent = document.getElementById('pieChart').toDataURL(); // Get chart image as data URL
          const barChartContent = document.getElementById('barChart').toDataURL();
          const donutChartContent = document.getElementById('donutChart').toDataURL();
          const lineChartContent = document.getElementById('lineChart').toDataURL();
      
          // Dynamic data (Farmer name, Signature)
          const farmerName = "John Doe"; // Replace with dynamic data
          const signContent = "<img src='../assets/logo/Citylogo.jpg' style='width: 100px;' alt='Signature'/>"; // Update path to the actual image
          const CityLogoContent = "<img src='../assets/logo/agriculture.jpg' style='width: 100px;' alt='Signature'/>"; // Update path to the actual image
          const totalFarms = document.getElementById('totalFarms').innerText; // Fetch total farms value dynamically
          const totalAreaPlanted = document.getElementById('totalAreaPlanted').innerText; // Fetch total area planted value dynamically
          const totalAreaYield = document.getElementById('totalAreaYield').innerText; // Fetch total area yield value dynamically
          const totalCost = document.getElementById('totalCost').innerText; // Fetch total cost value dynamically
          const yieldPerAreaPlanted = document.getElementById('yieldPerAreaPlanted').innerText; // Fetch yield per area planted value dynamically
          const averageCostPerAreaPlanted = document.getElementById('averageCostPerAreaPlanted').innerText; // Fetch average cost per area planted value dynamically
      
          // Open a new window for the printable report
          const win = window.open('', '', 'height=900,width=1200');
          
          // Write HTML and styles to the new window
          win.document.write('<html><head><title>Agrimap Report</title>');
          win.document.write(`
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      margin: 0;
                      padding: 0;
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      text-align: center;
                      background-color: #f4f4f4;
                      color: black; /* Set default font color to black */
                  }
                  .report-container {
                      max-width: 800px;
                      margin: 20px auto;
                      background: white;
                      padding: 20px;
                      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                      border-radius: 8px;
      
                  }
                     h2 {
                      text-align: center;
                      margin-top: 2px;
                      margin-bottom: 110px;
                      font-size:15px;
                  }
                  h1 {
                      text-align: center;
                      margin-top: 20px;
                      margin-bottom: 3px;
                      font-size:15px;
                  }
                  .results-container {
                      margin-bottom: 40px;
                      display: flex;
                      justify-content: center;
                      
                      flex-wrap: wrap; /* Allows cards to wrap in case of narrow screens */
                  }
                  .card.custom-card {
                      color: black; /* Default color for card text */
                      width: 200px;
                      border-radius: 8px;
                      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
                      margin: 10px;
                  }
                  .card-body {
                      padding: 20px;
                      text-align: center;
                  }
                  .chart-container {
                      margin-bottom: 50px;
                      page-break-after: auto;
                  }
                  .signature {
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      padding: 20px 0;
                  }
                  .signature img {
                      height: 100px;
                  }
                  .signature h3 {
                      margin: 0;
                  }
                  .chart-image {
                      margin: 10px auto;
                      display: block;
                      width: 400px;
                  }
                 
              </style>
          `);
          win.document.write('</head><body>');
      
          // Centering content in a card-like structure
          win.document.write('<div class="report-container">');
          
      // Signature and header
      win.document.write(`
          <div class="signature" style="display: flex; justify-content: space-between; align-items: center;">
      
              ${signContent}
              <div style="text-align: center; margin-top: 20px;">
              <h1>Office of City Agriculture</h1>
              <h2>Zamboanga City</h2>
          </div>
              <h3 style="margin: 0;"> ${CityLogoContent}</h3>
          </div>
      `);
      // </div>
      //         <h3 style="margin: 0;">Date: ${new Date().toLocaleDateString()}</h3>
      //     </div>
      // // Centering the Report Title and Farmer's Name
      // win.document.write(`
      //     <div style="text-align: center; margin-top: 20px;">
      //         <h1>Agrimap Report</h1>
      //         <h2>Farmer: ${farmerName}</h2>
      //     </div>
      // `);
      
          
          // Results section with cards
          win.document.write(`
              <div class="results-container">
                  <!-- Total Farms Card -->
                  <div class="col-md-2 stretch-card">
                      <div class="card custom-card bg">
                          <div class="card-body">
                              <div class="d-flex justify-content-center align-items-center flex-column">
                                  <div class="text-center">
                                      <h5 class="mb-2" id="printTotalFarms">${totalFarms}</h5>
                                  </div>
                                  <div class="small-title mt-2 text-center">
                                      <h6 class="mb-0">Total Farms</h6>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
      
                  <!-- Total Area Planted Card -->
                  <div class="col-md-2 stretch-card">
                      <div class="card custom-card bgma">
                          <div class="card-body">
                              <div class="d-flex justify-content-center align-items-center flex-column">
                                  <div class="text-center">
                                      <h5 class="mb-2" id="printTotalAreaPlanted">${totalAreaPlanted}</h5>
                                  </div>
                                  <div class="small-title mt-2 text-center">
                                      <h6 class="mb-0">Total Area Planted (ha)</h6>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
      
                  <!-- Total Area Yield Card -->
                  <div class="col-md-2 stretch-card">
                      <div class="card custom-card backg">
                          <div class="card-body">
                              <div class="d-flex justify-content-center align-items-center flex-column">
                                  <div class="text-center">
                                      <h5 class="mb-2" id="printTotalAreaYield">${totalAreaYield}</h5>
                                  </div>
                                  <div class="small-title mt-2 text-center">
                                      <h6 class="mb-0">Total Area Yield (kg)</h6>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
      
                  <!-- Total Cost Card -->
                  <div class="col-md-2 stretch-card">
                      <div class="card custom-card bgnew">
                          <div class="card-body">
                              <div class="d-flex justify-content-center align-items-center flex-column">
                                  <div class="text-center">
                                      <h5 class="mb-2" id="printTotalCost">${totalCost}</h5>
                                  </div>
                                  <div class="small-title mt-2 text-center">
                                      <h6 class="mb-0">Total Cost (PHP)</h6>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
      
                  <!-- Yield per Area Planted Card -->
                  <div class="col-md-2 stretch-card">
                      <div class="card custom-card">
                          <div class="card-body">
                              <div class="d-flex justify-content-center align-items-center flex-column">
                                  <div class="text-center">
                                      <h5 class="mb-2" id="printYieldPerAreaPlanted">${yieldPerAreaPlanted}</h5>
                                  </div>
                                  <div class="small-title mt-2 text-center">
                                      <h6 class="mb-0">Yield per Area Planted (kg/ha)</h6>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
      
                  <!-- Average Cost per Area Planted Card -->
                  <div class="col-md-2 stretch-card">
                      <div class="card custom-card bgma">
                          <div class="card-body">
                              <div class="d-flex justify-content-center align-items-center flex-column">
                                  <div class="text-center">
                                      <h5 class="mb-2" id="printAverageCostPerAreaPlanted">${averageCostPerAreaPlanted}</h5>
                                  </div>
                                  <div class="small-title mt-2 text-center">
                                      <h6 class="mb-0">Ave. Cost/Area (PHP/ha)</h6>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          `);
      
          // Charts section
          win.document.write('<h2></h2>');
      
          // Pie Chart
          win.document.write(`
              <div class="chart-container">
                
                  <img src="${pieChartContent}" class="chart-image">
              </div>
          `);
      
          // Bar Chart
          win.document.write(`
              <div class="chart-container">
                  
                  <img src="${barChartContent}" class="chart-image">
              </div>
          `);
      
          // Donut Chart
          win.document.write(`
              <div class="chart-container">
            
                  <img src="${donutChartContent}" class="chart-image">
              </div>
          `);
      
          // Line Chart
          win.document.write(`
              <div class="chart-container">
                 
                  <img src="${lineChartContent}" class="chart-image">
              </div>
          `);
      
          win.document.write('</div>'); // End of report-container
          win.document.write('</body></html>');
          win.document.close();
          win.print();
      }
      
              });
      
      
              function openFarmersModal() {
              // Logic to fetch and display farmers data in the modal
              $('#farmersModal').modal('show');
          }
      
      
      
      
      
     

 
      
      
      
          </script>
          <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script>

          </script>
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

       <script>
     
     $(document).ready(function() {
    // Initialize empty pie chart with ApexCharts
    let chartOptions = {
        chart: {
            type: 'pie',
            height: 400
        },
        series: [],  // Series data (farm counts) will be populated dynamically
        labels: [],  // Labels (district names) will be populated dynamically
        title: {
            text: "Farm Distribution per District",
            align: 'center'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 300
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    // Render chart initially with no data
    let chart = new ApexCharts(document.querySelector("#myPieChart"), chartOptions);
    chart.render();

    // Function to update the chart with AJAX response data
    function updatePieChart(farmsPerDistrictData) {
        // Prepare the series and labels arrays
        let seriesData = farmsPerDistrictData.map(data => data.farm_count);
        let labelsData = farmsPerDistrictData.map(data => data.district);

        // Update the chart with new data
        chart.updateOptions({
            series: seriesData,
            labels: labelsData
        });
    }

    // Function to fetch and update farm distribution data
    function fetchFarmsPerDistrictData(cropName = null, dateFrom = null, dateTo = null, district = null) {
        $.ajax({
            url: "/", // Update with your route
            method: 'GET',
            dataType: 'json',
            data: {
                crop_name: cropName,
                dateFrom: dateFrom,
                dateTo: dateTo,
                district: district
            },
            success: function(response) {
                if (response.farmsPerDistrictData) {
                    updatePieChart(response.farmsPerDistrictData);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Event listeners for filter changes
    $('#cropName, #district, #dateFrom, #dateTo').on('change', function() {
        const cropName = $('#cropName').val();
        const dateFrom = $('#dateFrom').val();
        const dateTo = $('#dateTo').val();
        const district = $('#district').val();
        fetchFarmsPerDistrictData(cropName, dateFrom, dateTo, district);
    });

    // Initial fetch on page load
    fetchFarmsPerDistrictData();
});

     </script>
          
<script>
$(document).ready(function () {
    $.ajax({
        url: 'farmer-profile-data',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Update Pie chart for Rice Gross Income
            updateGrossIncomePieChart(response.grossIncome.labels, response.grossIncome.data);

            // Update Doughnut chart for Rice Cropping Data
            updateCroppingDoughnutChart(response.croppingData.labels, response.croppingData.yields);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});

// Function to update the Gross Income Pie Chart for Rice
function updateGrossIncomePieChart(labels, data) {
    const ctx = document.getElementById('grossIncomePieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rice Gross Income(Php)',
                data: data,
                backgroundColor:[ '#009e2e', '#FFCE56','#e3004d', '#4BC0C0', '#9966FF', '#FF9F40','#ff0000'],
                borderColor: [ '#009e2e', '#FFCE56','#e3004d', '#4BC0C0', '#9966FF', '#FF9F40','#ff0000'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10, // Size of the box next to each legend label
                        padding: 4, // Padding between legend items
                        font: {
                            size: 10 // Font size for legend labels
                        }
                    }
                }
            }
        }
    });
}

// Function to update the Cropping Data Doughnut Chart for Rice
function updateCroppingDoughnutChart(labels, yields) {
    const ctx = document.getElementById('croppingDoughnutChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rice Yield (tons)',
                data: yields,
                backgroundColor: ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
                borderColor: ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10, // Size of the box next to each legend label
                        padding: 4, // Padding between legend items
                        font: {
                            size: 10 // Font size for legend labels
                        }
                    }
                }
            }
        }
    });
}

</script>

<script>
    $(document).ready(function() {
            $.ajax({
                url: '/farmer-profile-data',
                method: 'GET',
                success: function(data) {
                  console.log('Fetched Gender Distribution Data:', data);
                    const ctx = document.getElementById('genderChart').getContext('2d');
                    const genderChart = new Chart(ctx, {
                        type: 'bar', // Set chart type to 'bar'
                        data: {
                            labels: ['Male', 'Female'],
                            datasets: [{
                                label: 'Gender Distribution',
                                data: [data.male, data.female],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.6)', // Color for Male
                                    'rgba(255, 99, 132, 0.6)'  // Color for Female
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)', // Border color for Male
                                    'rgba(255, 99, 132, 1)'  // Border color for Female
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true // Start y-axis from zero
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Farmers Gender Distribution '
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });


</script>

<script>

$(document).ready(function() {
    $.ajax({
        url: '/farmer-profile-data',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            renderMachineryCostChart(response.labels, response.series);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching machinery cost data:', error);
        }
    });
});

function renderMachineryCostChart(labels, series) {
    // Calculate total series amount
    const totalSeries = series.reduce((total, value) => total + value, 0);
      // Define custom colors for each segment
      var colors = ['#008FFB','#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'];

    var options = {
        chart: {
            type: 'donut',
            height: 350,
        },
        series: series,
        labels: labels,
        colors: colors, // Add the colors array here
        title: {
    text: '',
    align: 'center',
    style: {
        fontSize: '9px', // Adjust font size as needed
      
        color: '#333' // Optional: change font color
    }
},

        dataLabels: {
            enabled: true,
            formatter: function (val) {
                // Format the value to show the actual cost
                return val.toFixed(2) + "%";
            }
        },
        tooltip: {
          style: {
                fontSize: '12px', // Tooltip font size
                fontFamily: 'Helvetica, Arial, sans-serif', // Tooltip font family
            },
            y: {
                formatter: function(value) {
                    return "Total: PHP " + value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            marker: {
                show: true // Show marker on tooltip
            },
            theme: 'dark', // Set the tooltip theme to dark
            // Customize tooltip container style
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                return '<div style="background: black; color: white; padding: 10px; border-radius: 5px;">' +
                       '<strong>Total: PHP ' + series[seriesIndex].toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</strong>' +
                       '</div>';
            }
        },
        legend: {
            position: 'top', // Position the legend below the chart
            horizontalAlign: 'center', // Center align the legend
            floating: false, // Keep it fixed in place, not floating
        },
        stroke: {
            show: true, // Show stroke for the chart
            width: 1, // Width of the stroke
            colors: ['#fff'] // Color of the stroke
        }
    };

    var chart = new ApexCharts(document.querySelector("#machineryCostPieChart"), options);
    chart.render();
}

$(document).ready(function() {
    $.ajax({
        url: '/farmer-profile-data',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            renderVariableCostChart(response.variableCostLabels, response.variableCostSeries);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching variable cost data:', error);
        }
    });
});

function renderVariableCostChart(labels, series) {
   // Define custom colors for each segment
   var colors = ['#e3004d','#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'];
    var options = {
        chart: {
            type: 'pie', // Use 'pie' for a pie chart
            height: 350,
        },
        series: series,
        labels: labels,
        colors: colors, // Add the colors array here
        title: {
            text: '',
            align: 'center',
            style: {
                fontSize: '10px' // Adjust font size as needed
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toFixed(2) + "%"; // Format as percentage if needed
            }
        },
        tooltip: {
            style: {
                fontSize: '12px', // Tooltip font size
                fontFamily: 'Helvetica, Arial, sans-serif', // Tooltip font family
            },
            y: {
                formatter: function(value) {
                    return "Total: PHP " + value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            },
            marker: {
                show: true // Show marker on tooltip
            },
            theme: 'dark', // Set the tooltip theme to dark
            // Customize tooltip container style
            custom: function({ series, seriesIndex, dataPointIndex, w }) {
                return '<div style="background: black; color: white; padding: 10px; border-radius: 5px;">' +
                       '<strong>Total: PHP ' + series[seriesIndex].toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</strong>' +
                       '</div>';
            }
        },
        legend: {
            position: 'top' // Position the legend below the chart
        },
    };

    var chart = new ApexCharts(document.querySelector("#variableCostPieChart"), options);
    chart.render();
}


</script>
  </body>
</html>
