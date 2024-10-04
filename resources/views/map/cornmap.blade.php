@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')
<style>
  .link-hover-effect {
      transition: color 0.3s ease, text-decoration 0.3s ease;
  }

  .link-hover-effect:hover {
      color: #032807; /* Change to your desired hover color */
      text-decoration: underline; /* Adds an underline on hover */
  }
</style>
<div class="page-content">
    {{-- <div class="d-flex justify-content-between mb-3">
        <form action="" method="GET" class="d-flex">
            <input type="text" name="query" placeholder="Search" class="form-control me-2">
            <button type="submit" class="btn btn-success">Search</button>
        </form>
    
        <form id="showAllForm" action="" method="GET">
            <button class="btn btn-outline-success" type="submit">All</button>
        </form>
    </div>

  --}}
    <div style="position: relative;">
      <div id="map" style="height: 450px; width: 100%;"></div>
      
      <!-- Floating Search Inputs -->
      <div class="d-flex" style="position: absolute; bottom: 10px; left: 10px; z-index: 1000;">
          <input type="text" id="latitude" placeholder="Enter Latitude" class="form-control me-2" style="width: 100px;">
          <input type="text" id="longitude" placeholder="Enter Longitude" class="form-control me-2" style="width: 100px;">
          <button id="panButton" class="btn btn-primary" title="Pan to specified location">
            <i class="fas fa-search"></i>
        </button>
      </div>
  </div>
  <!-- District Info Modal -->
  <div class="modal fade" id="districtInfoModal" tabindex="-1" aria-labelledby="districtInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="districtInfoModalLabel">District Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="districtInfoBody">
                <div class="mb-3">
                    <p><strong>District Name:</strong> <span id="districtName"></span></p>
                    <p><strong>Description:</strong> <span id="districtAdditionalInfo"></span></p>
                </div>
                <hr>
                <h6>Related Information:</h6><br>
             
              
              <div class="d-flex flex-wrap mb-3">
                  <a href="#" id="farmersInfoLink" class="text-decoration-none me-3 link-hover-effect" data-district-id="">Farmers Info</a>
                  <a href="#" id="cropsVarietyLink" class="text-decoration-none me-3 link-hover-effect" data-district-id="">Crops Variety</a>
                  <a href="#" id="Production" class="text-decoration-none me-3 link-hover-effect" data-district-id="">Production</a>
                  <a href="#" id="FarmerOrganization" class="text-decoration-none link-hover-effect" data-district-id="">Farmers Org</a>
              </div>
              
               

                <div id="imageCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carouselImages">
                       
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="infoModalLabel">Farmer Information</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="districtInfoBody">
              <div class="mb-3">
                <p id="modalFarmerName"></p>
                <p id="modalDistrictName"></p>
                <p id="modalCropName"></p>
              </div>
              <hr>
              <h6>Related Information:</h6><br>
           
            
            {{-- <div class="d-flex flex-wrap mb-3">
                <a href="#" id="farmersInfoLink" class="text-decoration-none me-3 link-hover-effect" data-district-id="">Farmers Info</a>
                <a href="#" id="cropsVarietyLink" class="text-decoration-none me-3 link-hover-effect" data-district-id="">Crops Variety</a>
                <a href="#" id="Production" class="text-decoration-none me-3 link-hover-effect" data-district-id="">Production</a>
                <a href="#" id="FarmerOrganization" class="text-decoration-none link-hover-effect" data-district-id="">Farmers Org</a>
            </div>
            
              --}}

              <div id="imageCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
                  <div class="carousel-inner" id="carouselImages">
                     
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                  </button>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>
<!-- Modal Structure -->
{{-- <div id="infoModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Farmer Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalFarmerName"></p>
        <p id="modalDistrictName"></p>
        <p id="modalCropName"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> --}}


  {{-- <!-- Optional Search Form for Other Queries -->
  <div class="d-flex justify-content-between mb-3">
      <form action="" method="GET" class="d-flex flex-grow-1 me-2">
          <input type="text" name="query" placeholder="Search" class="form-control me-2">
          <button type="submit" class="btn btn-success">Search</button>
      </form>
  
      <form id="showAllForm" action="" method="GET">
          <button class="btn btn-outline-success" type="submit">All</button>
      </form>
  </div>
   --}}
  <style>
      /* Responsive adjustments for floating search inputs */
      @media (max-width: 768px) {
          .d-flex {
              flex-direction: column;
              margin-top: 50px;
              align-items: flex-end; /* Aligns items to the right on smaller screens */
          }
          #latitude, #longitude {

              width: 90%; /* Make input fields responsive */
              margin-bottom: 5px; /* Adds space between input fields on small screens */
          }
      }
      
      @media (min-width: 769px) {
          #latitude, #longitude {
              width: 100px; /* Fixed width on larger screens */
          }
      }
  </style>
  
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&callback=initMap" ></script>
 
<script type="text/javascript">
  var map;
  var markers = []; // Array to store all farm markers
  var districtData = {}; // Store markers by district
  var currentDistrict = null; // To track currently displayed district
  var polygons = []; // Array to hold the saved polygons

  // Marker icons for different crops
  var markerIcons = {
      'Rice': "{{ asset('assets/images/corn.png') }}", // Custom logo for rice
      'Corn': "{{ asset('assets/images/corn.png') }}", // Custom logo for corn
      'default': "{{ asset('assets/logo/rice.png') }}" // Default logo for other crops
  };

  function toTitleCase(str) {
      return str
          .toLowerCase() // Convert the entire string to lowercase
          .split(' ') // Split the string into words
          .map(word => {
              // Capitalize the first letter of each word, except for certain articles
              if (word.length > 2) {
                  return word.charAt(0).toUpperCase() + word.slice(1);
              } else {
                  return word; // Return the word as is for short words (like "the", "a", etc.)
              }
          })
          .join(' '); // Join the words back into a string
  }

  function initMap() {
      // Default GPS coordinates
      var initialLocation = { lat: 6.9214, lng: 122.0790 }; // Default center

      // Create the map
      map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: initialLocation,
          mapTypeId: 'satellite'
      });

      // Load initial markers, districts, and polygons
      loadInitialData();
  }

  // Function to load initial data using AJAX
  function loadInitialData() {
      console.log('Starting to load initial map data...'); // Indicate start of loading

      $.ajax({
          url: '/admin-view-corn-map', // Your API endpoint
          method: 'GET',
          success: function(data) {
              console.log('Map data loaded successfully:', data); // Log the received data

              var gpsData = data.gpsData; // GPS coordinates for markers
              var districtsData = data.districtsData; // District markers
              var polygonsData = data.polygons; // Polygons

              // Loop through the GPS data to add markers for farm profiles
              gpsData.forEach(function(location) {
                  var position = { lat: parseFloat(location.gpsLatitude), lng: parseFloat(location.gpsLongitude) };
                  var districtName = location.districtName; // Assume districtName is available in location
                  
                  console.log('Adding marker for location:', location); // Log each location being added
                  addMarker(position, location.cropName, location.farmerName, districtName); // Add farm profile marker
              });

              console.log('Total GPS markers added:', gpsData.length); // Log total number of markers added

              // Loop through districts data to add district markers
              districtsData.forEach(function(district) {
                  var position = { lat: parseFloat(district.gpsLatitude), lng: parseFloat(district.gpsLongitude) };
                  
                  console.log('Adding district marker:', district); // Log each district being added
                  addDistrictMarker(position, district.districtName, district.description, district.id); // Pass district ID
              });

              console.log('Total district markers added:', districtsData.length); // Log total number of district markers added

              // Loop through polygons data to draw polygons on the map
              polygonsData.forEach(function(polygonData) {
                  console.log('Drawing polygon with coordinates:', polygonData.coordinates); // Log polygon coordinates
                  drawPolygon(polygonData.coordinates, polygonData); // Assuming polygonData contains options
              });

              console.log('Total polygons drawn:', polygonsData.length); // Log total number of polygons drawn
          },
          error: function(error) {
              console.error('Error loading map data:', error); // Log error message
          }
      });
  }

  // Function to add marker to the map with customized icon and farmer's name on hover
function addMarker(location, cropName, farmerName, districtName) {
    var icon = {
        url: markerIcons[cropName] || markerIcons['default'],
        scaledSize: new google.maps.Size(20, 30)
    };

    var marker = new google.maps.Marker({
        position: location,
        map: null, // Initially hidden
        icon: icon,
        title: farmerName
    });

    // Store the marker in the districtData under the appropriate district name
    if (districtName) {
        if (!districtData[districtName]) {
            districtData[districtName] = []; // Initialize if not exists
        }
        districtData[districtName].push(marker); // Add to the respective district's array
    }

    // Push marker into the markers array for later reference
    markers.push(marker);

    // Add click event listener to the marker to open the modal
    google.maps.event.addListener(marker, 'click', function() {
        // Populate modal with farmer's name, district name, and crop name
        document.getElementById('modalFarmerName').innerText = "Farmer: " + toTitleCase(farmerName);

        document.getElementById('modalCropName').innerText = "Crop: " +  toTitleCase(cropName);

        // Show the modal
        $('#infoModal').modal('show'); // Using jQuery to show the modal
    });
}

  // Function to add district marker
  function addDistrictMarker(location, districtName, description, districtId) {
      var icon = {
          url: "{{ asset('assets/images/district.png') }}", // Add your district icon path here
          scaledSize: new google.maps.Size(20, 30)
      };

      var marker = new google.maps.Marker({
          position: location,
          map: map,
          icon: icon,
          title: districtName
      });

      // Add click event listener to district marker
      google.maps.event.addListener(marker, 'click', function() {
          // Populate modal with district information
          document.getElementById('districtName').innerText = toTitleCase(districtName) + ' District'; // Set the district name
          document.getElementById('districtAdditionalInfo').innerText = description; // Set additional information

          // Clear any previous images from the carousel
          document.getElementById('carouselImages').innerHTML = '';

          // Set district ID for links
          document.getElementById('farmersInfoLink').setAttribute('data-district-id', districtId); // Set appropriate ID
          document.getElementById('cropsVarietyLink').setAttribute('data-district-id', districtId); // Set appropriate ID
          document.getElementById('Production').setAttribute('data-district-id', districtId); // Set appropriate ID
          document.getElementById('FarmerOrganization').setAttribute('data-district-id', districtId); // Set appropriate ID

          // Show the modal
          var districtInfoModal = new bootstrap.Modal(document.getElementById('districtInfoModal'));
          districtInfoModal.show(); // Show the modal

          showDistrictMarkers(districtName); // Show or hide farm markers for this district
      });
  }

  // Function to draw polygon on the map
  function drawPolygon(coordinates, options) {
      // Convert the coordinates to the format expected by Google Maps
      var path = coordinates.map(function(coord) {
          return { lat: coord.lat, lng: coord.lng };
      });

      var polygon = new google.maps.Polygon({
          paths: path,
          strokeColor: options.strokeColor || '#FF0000', // Default stroke color
          strokeOpacity: options.strokeOpacity || 0.8, // Default stroke opacity
          strokeWeight: options.strokeWeight || 2, // Default stroke weight
          fillColor: options.fillColor || '#fffff', // Default fill color
          fillOpacity: options.fillOpacity || 0.1 // Default fill opacity
      });
      
      polygon.setMap(map); // Add the polygon to the map
      polygons.push(polygon); // Store in the polygons array
  }

  // Function to show markers for a specific district and hide others
  function showDistrictMarkers(districtName) {
      // Hide all markers first
      markers.forEach(function(marker) {
          marker.setMap(map); // Set all markers to be visible on the map
      });

      // Show only markers belonging to the selected district
      if (districtData[districtName]) {
          districtData[districtName].forEach(function(marker) {
              marker.setMap(map); // Show marker on map
          });
      }
  }

  // Function to clear markers from the map but keep them in the array
  function clearMarkers() {
      markers.forEach(function(marker) {
          marker.setMap(null); // Remove markers from the map
      });
  }

// Event listener for panning to the location
document.getElementById('panButton').addEventListener('click', function() {
    var lat = parseFloat(document.getElementById('latitude').value);
    var lng = parseFloat(document.getElementById('longitude').value);

    if (!isNaN(lat) && !isNaN(lng)) {
        var newLocation = { lat: lat, lng: lng };
        
        // // Clear all markers from the map
        // clearMarkers();
        
        // Pan to the new location
        map.panTo(newLocation); // Pan to the new location
        map.setZoom(90); // Optionally reset zoom level
    } else {
        alert("Please enter valid latitude and longitude.");
    }
});


  // Event listeners for district-related buttons
  $('#farmersInfoLink').on('click', function() {
      var districtId = $(this).data('district-id');
      // Load farmers info logic here
      alert('Farmers Info for District ID: ' + districtId);
  });

  $('#cropsVarietyLink').on('click', function() {
      var districtId = $(this).data('district-id');
      // Load crop varieties logic here
      alert('Crop Varieties for District ID: ' + districtId);
  });

  $('#Production').on('click', function() {
      var districtId = $(this).data('district-id');
      // Load production data logic here
      alert('Production data for District ID: ' + districtId);
  });

  $('#FarmerOrganization').on('click', function() {
      var districtId = $(this).data('district-id');
      // Load farmer organization logic here
      alert('Farmer Organization for District ID: ' + districtId);
  });
</script>


@endsection
