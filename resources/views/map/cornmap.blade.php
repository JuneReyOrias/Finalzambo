@extends('admin.dashb')
@section('admin')
    @extends('layouts._footer-script')
    @extends('layouts._head')


    <style>
        .link-hover-effect {
            transition: color 0.3s ease, text-decoration 0.3s ease;
        }

        .link-hover-effect:hover {
            color: #032807;
            /* Change to your desired hover color */
            text-decoration: underline;
            /* Adds an underline on hover */
        }


        .modal-content {
            border-radius: 10px;
            /* Rounded corners */
            background-color: #f9f9f9;
            /* Light background color */
        }

        .modal-header {
            background-color: #dde9f6;
            /* Bootstrap primary color */
            color: white;
            /* White text for the header */
            border-top-left-radius: 10px;
            /* Rounded corners */
            border-top-right-radius: 10px;
            /* Rounded corners */
        }

        .modal-title {
            font-size: 1.25rem;
            /* Slightly larger title font size */
        }

        .modal-body p {
            margin: 0.5rem 0;
            /* Add spacing between paragraphs */
            font-size: 0.95rem;
            /* Adjust paragraph font size */
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
            /* Subtle border for footer */
        }

        /* Responsive adjustments for floating search inputs */
        @media (max-width: 768px) {
            .d-flex {
                flex-direction: column;
                margin-top: 50px;
                align-items: flex-end;
                /* Aligns items to the right on smaller screens */
            }

            #latitude,
            #longitude {

                width: 90%;
                /* Make input fields responsive */
                margin-bottom: 5px;
                /* Adds space between input fields on small screens */
            }
        }

        @media (min-width: 769px) {

            #latitude,
            #longitude {
                width: 100px;
                /* Fixed width on larger screens */
            }
        }
    </style>
    <div class="page-content">


        <div style="position: relative;">
            <div id="map" style="height: 700px; width: 100%;"></div>
            <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content border-0 shadow-sm">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="infoModalLabel">Farmer Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="districtInfoBody">
                            <div class="mb-3">
                                <p id="modalFarmerName" class="fw-bold"></p>
                                <p id="modaltenure"></p>
                                <p id="modalAge"></p>
                                <p id="modalCropName"></p>
                                <p id="modalCropVariety"></p>
                                <p id="modalFarmAddress"></p>
                                <p id="modalYearsFarmer"></p>
                                <p id="modalOrganization"></p>
                                <p id="modalLandTitle"></p>
                                <p id="modalPhysicalArea"></p>
                                <p id="modalCultivated"></p>
                                <p id="modalcopping"></p>
                                <p id="modalYield"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- New Update Map Legend --}}
            <div class="legend"
                style="position: absolute; top: 175px; left: 20px; z-index: 1000; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                <h2 style="font-size: 10px; margin-bottom: 10px;">Legend</h2>

                <!-- Color Circles Section -->
                <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 5px;">
                    <div class="color-circle"
                        style="width: 10px; height: 10px; background-color: #00aa00; border-radius: 50%; margin-right: 10px;"
                        onmouseover="showName(this)" onmouseout="hideName(this)">
                    </div>
                    <span class="legend-name" style="font-size: 10px; display: none;">Ayala Boarder</span>
                </div>

                <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 5px;">
                    <div class="color-circle"
                        style="width: 10px; height: 10px; background-color: #55007f; border-radius: 50%; margin-right: 10px;"
                        onmouseover="showName(this)" onmouseout="hideName(this)">
                    </div>
                    <span class="legend-name" style="font-size: 10px; display: none;">Tumaga Boarder</span>
                </div>
                <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 5px;">
                    <div class="color-circle"
                        style="width: 10px; height: 10px; background-color: #ffff00; border-radius: 50%; margin-right: 10px;"
                        onmouseover="showName(this)" onmouseout="hideName(this)"></div>
                    <span class="legend-name" style="font-size: 10px; display: none;"> Culianan Boarder</span>
                </div>

                <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 5px;">
                    <div class="color-circle"
                        style="width: 10px; height: 10px; background-color: #ff5500; border-radius: 50%; margin-right: 10px;"
                        onmouseover="showName(this)" onmouseout="hideName(this)"></div>
                    <span class="legend-name" style="font-size: 10px; display: none;">Manicahan Boarder</span>
                </div>

                <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 5px;">
                    <div class="color-circle"
                        style="width: 10px; height: 10px; background-color: #ff00ff; border-radius: 50%; margin-right: 10px;"
                        onmouseover="showName(this)" onmouseout="hideName(this)"></div>
                    <span class="legend-name" style="font-size: 10px; display: none;">Curuan Boarder</span>
                </div>
                <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 5px;">
                    <div class="color-circle"
                        style="width: 10px; height: 10px; background-color: #ff0000; border-radius: 50%; margin-right: 10px;"
                        onmouseover="showName(this)" onmouseout="hideName(this)"></div>
                    <span class="legend-name" style="font-size: 10px; display: none;">Vitali Boarder</span>
                </div>


                <!-- Icon Section -->
                <h3 style="font-size: 12px; margin-top: 15px;">Icons</h3>
                <div class="icon-section">
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <img src="../assets/logo/rice.png" alt="Rice Icon"
                            style="width: 16px; height: 16px; margin-right: 10px;" onmouseover="showName(this)"
                            onmouseout="hideName(this)">
                        <span class="legend-name" style="font-size: 10px; display: none;">Rice</span>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <img src="../assets/logo/corn.png" alt="Corn Icon"
                            style="width: 16px; height: 16px; margin-right: 10px;" onmouseover="showName(this)"
                            onmouseout="hideName(this)">
                        <span class="legend-name" style="font-size: 10px; display: none;">Corn</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <img src="../assets/logo/coconut.png" alt="History Icon"
                            style="width: 16px; height: 16px; margin-right: 10px;" onmouseover="showName(this)"
                            onmouseout="hideName(this)">
                        <span class="legend-name" style="font-size: 10px; display: none;">Coconut</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <img src="../assets/logo/crops.png" alt="History Icon"
                            style="width: 16px; height: 16px; margin-right: 10px;" onmouseover="showName(this)"
                            onmouseout="hideName(this)">
                        <span class="legend-name" style="font-size: 10px; display: none;">Other Crops</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <img src="../assets/images/district.png" alt="History Icon"
                            style="width: 16px; height: 16px; margin-right: 10px;" onmouseover="showName(this)"
                            onmouseout="hideName(this)">
                        <span class="legend-name" style="font-size: 10px; display: none;">Agri-Districts</span>
                    </div>

                </div>
            </div>

            <script>
                function showName(element) {
                    let nameSpan = element.nextElementSibling;
                    nameSpan.style.display = "inline-block";
                }

                function hideName(element) {
                    let nameSpan = element.nextElementSibling;
                    nameSpan.style.display = "none";
                }
            </script>

            <!-- Instruction Modal  -->
            <div class="modal fade" id="instructionModal" tabindex="-1" aria-labelledby="instructionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="instructionModalLabel">How to Use the Map</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <p>📌 <strong>Click on a district</strong> on the map to view more details.</p>
                                <p>🎨 <strong>Use the legend</strong> to understand the color-coded districts.</p>
                                <p>🔍 <strong>Before searching for a farmer</strong>, select a district on the map.</p>
                                <p>📷 <strong>Browse through images</strong> related to each district in the carousel.</p>
                            </div>
                            <hr>
                            {{-- <h6>Need More Help?</h6>
                <p>Visit the <a href="#">help section</a> or contact support.</p> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="closeModal">Got
                                It!</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript for instruction modal -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const instructionModal = new bootstrap.Modal(document.getElementById("instructionModal"));

                    // Show modal automatically when the page loads
                    instructionModal.show();

                    // Close modal when "Got It!" button is clicked
                    document.getElementById("closeModal").addEventListener("click", function() {
                        instructionModal.hide();
                    });
                });
            </script>
            <!-- end sction for  instruction modal -->

            <!-- Floating Search Inputs -->
            <div class="controls"
                style="position: absolute; bottom: 20px; left: 20px; z-index: 1000; background: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 5px;">
                <h2 style="font-size: 16px;">Search for a Farmer</h2>

                <select id="districtDropdown" class="form-control mb-2">
                    <option value="" disabled selected>Select District</option>
                    <!-- Districts will be populated here -->
                </select>

                <select id="farmerNameDropdown" class="form-control mb-2">
                    <option value="" disabled selected>Select Farmer Name</option>
                    <!-- Farmer names will be populated here -->
                </select>

                <button id="searchFarmerButton" class="btn btn-primary mb-2" title="Search Farmer">
                    <i class="fas fa-search"></i>
                </button>

                <button id="panButton" class="btn btn-primary mb-2" title="Hide Farmer">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>

        </div>

        <!-- District Info Modal -->
        <div class="modal fade" id="districtInfoModal" tabindex="-1" aria-labelledby="districtInfoModalLabel"
            aria-hidden="true">
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
                        {{-- <h6>Related Information:</h6>
             
              
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
                </div> --}}
                    </div>
                    {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> --}}
                </div>
            </div>
        </div>



    </div>

{{-- Load the Google Maps JavaScript API asynchronously and defer execution --}}
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&callback=initMap"></script>

    <script 
    type="text/javascript">
        let gpsData = [];
        var map;
        var markers = []; // Array to store all farm markers
        var districtData = {}; // Store markers by district
        var currentDistrict = null; // To track currently displayed district
        var polygons = []; // Array to hold the saved polygons


        // Marker icons for different crops
        var markerIcons = {
            'Rice': "{{ asset('assets/logo/rice.png') }}", // Custom logo for rice
            'Corn': "{{ asset('assets/logo/corn.png') }}", // Custom logo for corn
            'Coconut': "{{ asset('assets/logo/coconut.png') }}", // Custom logo for corn
            'default': "{{ asset('assets/logo/crops.png') }}" // Default logo for other crops
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
            var initialLocation = {
                lat: 6.9214,
                lng: 122.0790
            }; // Default center

            // Create the map
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: initialLocation,
                mapTypeId: 'satellite'
            });

            // Load initial markers, districts, and polygons
            loadInitialData();
            loadPolygons();
        }

        // Function to load initial data using AJAX
        function loadInitialData() {
            // console.log('Starting to load initial map data...'); // Indicate start of loading

            $.ajax({
                url: '/admin-view-all-crops-map', // Your API endpoint
                method: 'GET',
                success: function(data) {
                    // console.log('Map data loaded successfully:', data); // Log the received data

                    var gpsData = data.gpsData; // GPS coordinates for markers
                    var districtsData = data.districtsData; // District markers


                    function populateDistrictDropdown() {
                        var districtDropdown = document.getElementById('districtDropdown');
                        districtDropdown.innerHTML = ''; // Clear existing options

                        // Add default option
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = 'Select District';
                        defaultOption.disabled = true;
                        defaultOption.selected = true;
                        districtDropdown.appendChild(defaultOption);

                        // Check if gpsData is defined and not empty
                        if (!gpsData || gpsData.length === 0) {
                            console.log('gpsData is empty or not defined');
                            return;
                        }

                        // Extract unique districts from gpsData
                        var districts = [...new Set(gpsData.map(farm => farm.district).filter(district =>
                            district != null && district.trim() !== ''))];

                        // Log the districts array to debug
                        console.log(districts);

                        if (districts.length === 0) {
                            console.log('No districts found');
                            return;
                        }

                        // Populate the dropdown
                        districts.forEach(function(district) {
                            var option = document.createElement('option');
                            option.value = district;
                            option.textContent = district;
                            districtDropdown.appendChild(option);
                        });
                    }




                    function populateFarmerDropdown(district) {
                        var farmerNameDropdown = document.getElementById('farmerNameDropdown');
                        farmerNameDropdown.innerHTML = ''; // Clear existing options

                        // Add default option
                        var defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = 'Select Farmer Name';
                        defaultOption.disabled = true;
                        defaultOption.selected = true;
                        farmerNameDropdown.appendChild(defaultOption);

                        gpsData.forEach(function(farm) {
                            // Filter by selected district and ensure GPS data is available
                            if (farm.district === district && farm.gpsLatitude && farm.gpsLongitude) {
                                var option = document.createElement('option');
                                option.value = farm.farmerName;
                                option.textContent = farm.farmerName; // Display farmer's name
                                option.setAttribute('data-lat', farm.gpsLatitude);
                                option.setAttribute('data-lng', farm.gpsLongitude);
                                farmerNameDropdown.appendChild(option);
                            }
                        });
                    }

                    // Initialize district dropdown on page load
                    document.addEventListener('DOMContentLoaded', function() {
                        populateDistrictDropdown();
                    });

                    // Add event listener for district selection
                    document.getElementById('districtDropdown').addEventListener('change', function() {
                        var selectedDistrict = this.value;
                        if (selectedDistrict) {
                            populateFarmerDropdown(selectedDistrict);
                        } else {
                            document.getElementById('farmerNameDropdown').innerHTML =
                            ''; // Clear farmers if no district is selected
                        }
                    });




                    function addAllFarmerMarkers() {
                        gpsData.forEach(function(location) {
                            if (location.gpsLatitude && location
                                .gpsLongitude) { // Only add markers with valid GPS data
                                var position = {
                                    lat: parseFloat(location.gpsLatitude),
                                    lng: parseFloat(location.gpsLongitude)
                                };
                                addMarker(position, location.cropName, location.farmerName, location
                                    .districtName,
                                    location.cropVariety, location.FarmAddress, location.NoYears,
                                    location.age,
                                    location.orgName, location.landtitleNo, location
                                    .totalPhysicalArea,
                                    location.TotalCultivated, location.tenurial_status, location
                                    .croppingperYear, location.Yield);
                            }
                        });
                    }

                    // Call the functions to populate the dropdown and add all markers
                    populateDistrictDropdown();
                    populateFarmerDropdown();
                    addAllFarmerMarkers();
                    // console.log('Total GPS markers added:', gpsData.length); // Log total number of markers added

                    // Loop through districts data to add district markers
                    districtsData.forEach(function(district) {
                        var position = {
                            lat: parseFloat(district.gpsLatitude),
                            lng: parseFloat(district.gpsLongitude)
                        };

                        console.log('Adding district marker:',
                        district); // Log each district being added
                        addDistrictMarker(position, district.districtName, district.description,
                            district.id); // Pass district ID
                    });

                    console.log('Total district markers added:', districtsData
                    .length); // Log total number of district markers added

                    // // Loop through polygons data to draw polygons on the map
                    // polygonsData.forEach(function(polygonData) {
                    //     // console.log('Drawing polygon with coordinates:', polygonData.coordinates); // Log polygon coordinates
                    //     drawPolygon(polygonData.coordinates, polygonData); // Assuming polygonData contains options
                    // });

                    // console.log('Total polygons drawn:', polygonsData.length); // Log total number of polygons drawn
                },
                error: function(error) {
                    console.error('Error loading map data:', error); // Log error message
                }
            });
        }

        // Function to add marker to the map with customized icon and farmer's name on hover
        function addMarker(location, cropName, farmerName, districtName, cropVariety, FarmAddress, NoYears, age,
            orgName, landtitleNo, totalPhysicalArea, TotalCultivated, tenurial_status, croppingperYear, Yield, ) {
            var icon = {
                url: markerIcons[cropName] || markerIcons['default'],
                scaledSize: new google.maps.Size(20, 30)
            };

            var marker = new google.maps.Marker({
                position: location,
                map: null, // Initially hidden
                icon: icon,
                title: `${farmerName} - ${cropName}`
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
                document.getElementById('modaltenure').innerText = "Tenurial Status: " + toTitleCase(
                    tenurial_status);
                document.getElementById('modalAge').innerText = "Age: " + age;
                document.getElementById('modalCropName').innerText = "Crop: " + toTitleCase(cropName);
                document.getElementById('modalCropVariety').innerText = "Crop Variety: " + toTitleCase(cropVariety);
                document.getElementById('modalFarmAddress').innerText = "Farm Address: " + FarmAddress;
                document.getElementById('modalYearsFarmer').innerText = "Years as Farmer: " + NoYears;
                // document.getElementById('modalCiviStatus').innerText = "Civil Status: " +  civilStatus;
                document.getElementById('modalOrganization').innerText = "Organization: " + toTitleCase(orgName);
                // Check if landtitleNo has a value, if not, set it to an empty string
                document.getElementById('modalLandTitle').innerText = "Land Title no.: " + (landtitleNo ?
                    landtitleNo : '');

                document.getElementById('modalPhysicalArea').innerText = "Total Physical Area: " + (
                    totalPhysicalArea ? totalPhysicalArea : '');
                document.getElementById('modalCultivated').innerText = "Total Cultivated Area: " + (
                    TotalCultivated ? TotalCultivated : '');

                document.getElementById('modalcopping').innerText = "Cropping/Year: " + (croppingperYear ?
                    croppingperYear : '');
                document.getElementById('modalYield').innerText = "Yield: " + (Yield ? new Intl.NumberFormat(
                    'en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(Yield) : '');





                // Show the modal
                $('#infoModal').modal('show'); // Using jQuery to show the modal
            });
        }

        // Event listener for searching a farmer by name
        document.getElementById('searchFarmerButton').addEventListener('click', function() {
            var farmerNameDropdown = document.getElementById('farmerNameDropdown');
            var selectedOption = farmerNameDropdown.options[farmerNameDropdown.selectedIndex];

            // Get latitude and longitude from the selected option
            const lat = parseFloat(selectedOption.getAttribute('data-lat'));
            const lng = parseFloat(selectedOption.getAttribute('data-lng'));

            if (selectedOption.value) {
                const farmPosition = {
                    lat: lat,
                    lng: lng
                };
                alert(`Found ${selectedOption.value} at coordinates: ${lat}, ${lng}`);

                // Log the found farmer details
                console.log('Farmer found:', selectedOption.value); // Log the details of the found farmer

                // Pan to the found farm's location
                map.panTo(farmPosition);
                map.setZoom(90); // Adjust zoom level
            } else {
                alert("Please select a farmer from the dropdown.");

                // Log that no farmer was selected
                console.log('No farmer selected.'); // Log the unsuccessful search
            }
        });

        function clearMarkers() {
            markers.forEach(function(marker) {
                marker.setMap(null); // Remove markers from the map
            });
        }

        // Event listener for panning to the location
        document.getElementById('panButton').addEventListener('click', function() {

            // // Clear all markers from the map
            clearMarkers();

            // Pan to the new location

        });

        // Add functionality to hide all markers
        document.getElementById('hideMarkersButton').addEventListener('click', function() {
            markers.forEach(function(marker) {
                marker.setMap(null); // Hide the marker
            });

            // Clear the markers array if needed
            markers = [];
            console.log('All markers hidden.'); // Log the action
        });


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
                document.getElementById('districtName').innerText = toTitleCase(districtName) +
                ' District'; // Set the district name
                document.getElementById('districtAdditionalInfo').innerText =
                description; // Set additional information

                // Clear any previous images from the carousel
                //   document.getElementById('carouselImages').innerHTML = '';

                //   // Set district ID for links
                //   document.getElementById('farmersInfoLink').setAttribute('data-district-id', districtId); // Set appropriate ID
                //   document.getElementById('cropsVarietyLink').setAttribute('data-district-id', districtId); // Set appropriate ID
                //   document.getElementById('Production').setAttribute('data-district-id', districtId); // Set appropriate ID
                //   document.getElementById('FarmerOrganization').setAttribute('data-district-id', districtId); // Set appropriate ID

                // Show the modal
                var districtInfoModal = new bootstrap.Modal(document.getElementById('districtInfoModal'));
                districtInfoModal.show(); // Show the modal

                showDistrictMarkers(districtName); // Show or hide farm markers for this district
            });
        }

        // Function to draw polygon on the map
        // function drawPolygon(coordinates, options) {
        //     // Convert the coordinates to the format expected by Google Maps
        //     var path = coordinates.map(function(coord) {
        //         return { lat: coord.lat, lng: coord.lng };
        //     });

        //     var polygon = new google.maps.Polygon({
        //         paths: path,
        //         strokeColor: options.strokeColor || '#FF0000', // Default stroke color
        //         strokeOpacity: options.strokeOpacity || 0.8, // Default stroke opacity
        //         strokeWeight: options.strokeWeight || 2, // Default stroke weight
        //         fillColor: options.fillColor || '#fffff', // Default fill color
        //         fillOpacity: options.fillOpacity || 0.1 // Default fill opacity
        //     });

        //     polygon.setMap(map); // Add the polygon to the map
        //     polygons.push(polygon); // Store in the polygons array
        // }

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

        // Load existing polygons
        //    function loadPolygons() {
        //         var mapdata = @json($mapdata); // Ensure that $mapdata is properly formatted as JSON in your Laravel controller.

        //         // Loop through the mapdata and add polygons to the map
        //         mapdata.forEach(function(parcel) {
        //           console.log("Stroke Color:", parcel.strokecolor);
        //           console.log("Fill Color:", parcel.fillColor); // Assuming you also have a fillcolor property

        //     var polygon = new google.maps.Polygon({
        //         paths: parcel.coordinates.map(coord => new google.maps.LatLng(coord.lat, coord.lng)),
        //         strokeColor: parcel.strokecolor , // Use color from data or default to blue
        //         strokeOpacity: 0.8,
        //         strokeWeight: 2,
        //         // fillColor: parcel.fillColor, // Use fill color from data or default to green
        //         fillOpacity: 0.02
        //     });
        //             polygon.setMap(map); // Add the polygon to the map

        //             // Bind a click event to show parcel details
        //             google.maps.event.addListener(polygon, 'click', function() {
        //                 var contentString = 'Parcel ID: ' + parcel.id + '<br>' +
        //                                     'Area: ' + parcel.area + ' sq. meters<br>' +
        //                                     'Altitude: ' + parcel.altitude + ' meters';
        //                 var infowindow = new google.maps.InfoWindow({
        //                     content: contentString
        //                 });
        //                 infowindow.setPosition(parcel.coordinates[0]); // Position it at the first coordinate
        //                 infowindow.open(map);
        //             });
        //         });

        //         // Optionally, fit the map to the bounds of the polygons
        //         var bounds = new google.maps.LatLngBounds();
        //         mapdata.forEach(function(parcel) {
        //             parcel.coordinates.forEach(function(coord) {
        //                 bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
        //             });
        //         });
        //         map.fitBounds(bounds);
        //     }


        function loadPolygons() {
            var mapdata = @json($mapdata); // Existing data from the view
            var parceldata = @json($parceldata); // Data from ParcellaryBoundaries

            // Function to plot a polygon on the map with different info windows
            function plotPolygon(parcel, isParcelData = false) {
                var polygon = new google.maps.Polygon({
                    paths: parcel.coordinates.map(coord => new google.maps.LatLng(coord.lat, coord.lng)),
                    strokeColor: parcel.strokecolor || '#FF0000', // Default stroke color if missing
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: parcel.fillcolor || '#FF0000', // Default fill color if missing
                    fillOpacity: 0.02
                });
                polygon.setMap(map);

                google.maps.event.addListener(polygon, 'click', function() {
                    var contentString;

                    // Different info window content for `mapdata` and `parceldata`
                    if (isParcelData) {
                        contentString = 'Parcel Name: ' + parcel.parcel_name + '<br>' +
                            'ARPOwner Name: ' + parcel.arpowner_na + '<br>' +
                            'Agri-District: ' + parcel.agri_districts + ' sq. meters<br>' +
                            'Brgy. Name: ' + parcel.barangay_name + ' sq. meters<br>' +
                            'Title name: ' + parcel.tct_no + '<br>' +
                            'Property kind description: ' + parcel.pkind_desc + '<br>' +
                            'Property Used description: ' + parcel.puse_desc + '<br>' +
                            'Actual Used: ' + parcel.actual_used + '<br>' +
                            'Area: ' + parcel.area + ' sq. meters<br>' +
                            'Altitude: ' + parcel.altitude + ' meters<br>';
                    } else {
                        contentString = 'Polygon Name: ' + parcel.polygon_name + '<br>' +
                            'Area: ' + parcel.area + ' sq. meters<br>' +
                            'Altitude: ' + parcel.altitude + ' meters';
                    }

                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    infowindow.setPosition(parcel.coordinates[0]); // Set at first coordinate
                    infowindow.open(map);
                });
            }

            // Plot polygons from `mapdata`
            mapdata.forEach(function(parcel) {
                plotPolygon(parcel);
            });

            // Plot polygons from `parceldata` with `isParcelData` flag set to true
            parceldata.forEach(function(parcel) {
                plotPolygon(parcel, true);
            });

            // Extend map bounds based on all parcels' coordinates
            var bounds = new google.maps.LatLngBounds();
            mapdata.concat(parceldata).forEach(function(parcel) {
                parcel.coordinates.forEach(function(coord) {
                    bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
                });
            });
            map.fitBounds(bounds);
        }
    </script>
@endsection
