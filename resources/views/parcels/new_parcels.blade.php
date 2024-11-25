@extends('admin.dashb')

@section('admin')
    @extends('layouts._footer-script')
    @extends('layouts._head')
    
    <style>
   
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap');
       
        .input-box {
            display: flex;
            align-items: center;
        }
        .input-box .form-control {
            flex: 1;
        }
        .input-box .btn-outline-danger {
            margin-left: 10px;
            display: none; /* Hide by default, show only for new seeds */}
       
       
       
       
       
       
        .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
            background-color: transparent;
                 font-weight: 500;
                    transition: all 0.3s ease;
                      }
                                    
        .btn-outline-danger:hover {
            background-color: #dc3545;
               color: #fff;
                                  }
                                    
          .btn-outline-danger i {
               font-size: 1.2rem;
                                  }
        :root{
            --primary: #6b59d3;
            --fourth:#05a34a;
            --secondary: #bfc0c0;
            --third:#ffffffc5;
            --white: #fff;
            --text-clr: #5b6475;
            --header-clr: #25273d;
            --next-btn-hover: #8577d2;
            --back-btn-hover: #8b8c8c;
        }
        


        .select-container {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between select and button */
}

.btn-remove {
    padding: 6px 12px; /* Adjust padding for consistency */
}

.btn-remove .fa-trash {
    margin-right: 4px; /* Space between icon and text */
}


        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            outline: none;
            font-family: 'Open Sans', sans-serif;
        }
        
        body{
            background: var(--third);
            color: var(--text-clr);
            font-size: 16px;
            position: relative;
        }




        /* .card-body{
            width: 750px;
            max-width: 80%;
            background: var(--white);
            margin: 10px auto 0;
            padding: 50px;
            border-radius: 5px;
        } */
        
        .card-body .header{
            margin-bottom: 35px;
            display: flex;
            justify-content: center;
        }
        
        .card-body .header ul{
            display: flex;
        }
        
        .card-body .header ul li{
            margin-right: 50px;
            position: relative;
        }
        
        .card-body .header ul li:last-child{
            margin-right: 0;
        }
        
        .card-body .header ul li:before{
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 55px;
            width: 100%;
            height: 2px;
            background: var(--secondary);
        }
        
        .card-body .header ul li:last-child:before{
            display: none;
        }
        
        .card-body .header ul li div{
            padding: 5px;
            border-radius: 50%;
        }
        
        .card-body .header ul li p{
            width: 50px;
            height: 50px;
            background: var(--secondary);
            color: var(--white);
            text-align: center;
            line-height: 50px;
            border-radius: 50%;
        }
        
        .card-body .header ul li.active:before{
            background: var(--primary);
        }
        
        .card-body .header ul li.active p{
            background: var(--primary);
        }
        
        .card-body.form_wrap{
            margin-bottom: 35px;
        }
        
        .card-body .form_wrap h2{
            color: var(--header-clr);
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        
        .card-body .form_wrap .input_wrap{
            width: 350px;
            max-width: 100%;
            margin: 0 auto 20px;
        }
        
        .card-body .form_wrap .input_wrap:last-child{
            margin-bottom: 0;
        }
        
        .card-body .form_wrap .input_wrap label{
            display: block;
            margin-bottom: 5px;
        }
        .placeholder-multiform{
            border: 2px solid var(--secondary);
        }
        .card-body .form_wrap .input_wrap .form-control{
            border: 2px solid var(--secondary);
            border-radius: 3px;
            padding: 10px;
            display: block;
            height: auto;
            width: 100%;	
            font-size: 16px;
            transition: 0.5s ease;
        }
        
        .card-body .form_wrap .input_wrap .form-control:focus{
            border-color: var(--primary);
        }
        
        .card-body .btns_wrap{
            width: 350px;
            max-width: 100%;
            margin: 0 auto;
        }
        
        .card-body .btns_wrap .common_btns{
            display: flex;
            justify-content: space-between;
        }
        
        .card-body .btns_wrap .common_btns.form_1_btns{
            justify-content: flex-end;
        }
        
        .card-body .btns_wrap .common_btns button{
            border: 0;
            padding: 12px 15px;
            background: var(--fourth);
            color: var(--white);
            width: 135px;
            justify-content: center;
            display: flex;
            align-items: center;
            font-size: 16px;
            border-radius: 3px;
            transition: 0.5s ease;
            cursor: pointer;
        }
        
        .card-body .btns_wrap .common_btns button.btn_back{
            background: var(--secondary);
        }
        
        .card-body .btns_wrap .common_btns button.btn_next .icon{
            display: flex;
            margin-left: 10px;
        }
        
        .card-body .btns_wrap .common_btns button.btn_back .icon{
            display: flex;
            margin-right: 10px;
        }
        
        .card-body .btns_wrap .common_btns button.btn_next:hover,
        .card-body .btns_wrap .common_btns button.btn_done:hover{
            background: var (--next-btn-hover);
        }
        
        .card-body .btns_wrap .common_btns button.btn_back:hover{
            background: var (--back-btn-hover);
        }
        
        .modal_wrapper{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            visibility: hidden;
        }
        
        .modal_wrapper .shadow{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            opacity: 0;
            transition: 0.2s ease;
        }
        
        .modal_wrapper .success_wrap{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-800px);
            background: var(--white);
            padding: 50px;
            display: flex;
            align-items: center;
            border-radius: 5px;
            transition: 0.5s ease;
        }
        
        .modal_wrapper .success_wrap .modal_icon{
            margin-right: 20px;
            width: 30px;
            height: 50px;
            background: var(--primary);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
        }
        
        .modal_wrapper.active{
            visibility: visible;
        }
        
        .modal_wrapper.active .shadow{
            opacity: 1;
        }
        
        .modal_wrapper.active .success_wrap{
            transform: translate(-50%,-50%);
        }
        .light-gray-placeholder::placeholder {
        color: lightgray;
        font-size: 0.9rem;
    }



    
    </style>
  <style>
    .step {
        display: none;
    }
    .step.active {
        display: block;
    }
    .farm-profile, .crop-farm {
        margin-bottom: 20px;
    }
    .btn-modern {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 50px;
    border: none;
    text-align: left;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-modern:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 50px;
    border: none;
    text-align: end;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    color: white;
}

.card-header {
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-modern, .btn-secondary {
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 30px;
    }

    .card-header {
        padding: 8px 15px;
    }
}

@media (max-width: 576px) {
    .btn-modern, .btn-secondary {
        padding: 8px 10px;
        font-size: 12px;
        border-radius: 20px;
    }

    .card-header {
        padding: 5px 10px;
    }
}


/* 
    .btn-modern {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 50px;
    border: none;
    text-align: center;
    width: 30%;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-modern:hover {
    background-color: #62b300;
    color: white;
    transform: translateY(-2px);
}

.card-header {
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.btn-modern {
    text-decoration: none;
}


/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-modern {
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 30px;
    }

    .card-header {
        padding: 8px 15px;
    }
}

@media (max-width: 576px) {
    .btn-modern {
        padding: 8px 10px;
        font-size: 10px;
        border-radius: 20px;
      
    }

    .card-header {
        padding: 5px 10px;
    }
}
@media (max-width: 376px) {
    .btn-modern {
        padding: 8px 10px;
        font-size: 10px;
        border-radius: 10px;
     
      
    }

    .card-header {
        padding: 5px 10px;
    }
} */
</style>


                                    <div class="page-content">
                                        <div class="card-forms border rounded">

                                        
                                            <div class="card-forms border rounded">

                                                <div class="card-body">
                                                
                                                <div class="content">
                                    <form   method="POST">
                                        @csrf
                                     
            


                            

<!-- Step 1: Farm Profile -->
<div class="step active farm-info" id="step2">
    <!-- Farm Profile and Crop Accordion -->
    <div class="accordion farm-info" id="accordionFarmProfile">
        <!-- Farm Profile Section -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" id="headingFarmProfile" style="background-color: #f8f9fa; border: none; padding: 10px 20px;">
                <h5 class="mb-0" style="margin: 0;">
                    <button class="btn btn-modern" type="button" data-toggle="collapse" data-target="#collapseFarmProfile" aria-expanded="true" aria-controls="collapseFarmProfile">
                            Add Parcel
                    </button>
                </h5>
                
                <!-- Button to Add New Crop Section (aligned to the right) -->
                {{-- <button class="btn btn-secondary ml-auto" type="button" id="addCropButton">Add Crop</button>
            --}}
           
            </div>
            
            <div id="collapseFarmProfile" class="collapse show" aria-labelledby="headingFarmProfile" data-parent="#accordionFarmProfile">
                <div class="card-body">
                    <p class="text-success">Provide clear and concise responses to each section, ensuring accuracy and relevance. If certain information is not applicable, write N/A.</p><br>
                    <div id="farmProfiles"></div>
                    <h3>Polygon Info</h3>
                    {{-- <input type="hidden" class="form-control light-gray-placeholder" value="{{$userId}}"name="users_id" placeholder="Enter longitude" id="modal_longitude">
                 --}}
                        <div id="farmProfiles">
                        <div class="user-details">
                          
                            <div class="input-box col-md-4">
                                <span class="details">Parcel Name:</span>
                                <input type="text" class="form-control light-gray-placeholder parcel_name"name="parcel_name" placeholder="Enter parcel name" id="boarder-name" onkeypress="return blockSymbolsAndNumbers(event)">
                            </div>
                              <div class="input-box col-md-4">
                                  <span class="details">ARP OwnerName:</span>
                                  <input type="text" class="form-control light-gray-placeholder arpowner_na"name="arpowner_na" placeholder="Enter ARP OwnerName" id="arpowner_na" onkeypress="return blockSymbolsAndNumbers(event)">
                              </div>
                              <!-- AgriDistrict Dropdown -->
                                <div class="input-box col-md-4">
                                  <label for="districtSelect">Select AgriDistrict:</label>
                                  <select id="districtSelect" class="form-control" name="agri_districts">
                                      <option value="" disabled selected>Select AgriDistrict</option>
                                  </select>
                                </div>
  
                                <!-- Barangay Dropdown -->
                                <div class="input-box col-md-4">
                                  <label for="barangaySelect">Select Barangay:</label>
                                  <select class="form-control barangaySelect" id="barangaySelect" name="barangay_name">
                                      <option value="" disabled selected>Select Barangay</option>
                                      <option value="add">Add New Barangay...</option>
                                  </select>
                                </div>
  
                        
                              <div class="input-box col-md-4">
                                <span class="details">Land Title no.:</span>
                                <input type="text" class="form-control light-gray-placeholder tct_no"name="tct_no" placeholder="Enter Land Title no." id="landTitle" >
                            </div>
  
                            <div class="input-box col-md-4">
                              <span class="details">Lot no:</span>
                              <input type="text" class="form-control light-gray-placeholder lot_no"name="lot_no" placeholder="Enter Lot no" id="lotNo" >
                          </div>
  
                          <div class="input-box col-md-4">
                            <span class="details">PKind Description:</span>
                            <input type="text" class="form-control light-gray-placeholder pkind_desc"name="pkind_desc" placeholder="Enter PKind Description" id="pkind_desc" onkeypress="return blockSymbolsAndNumbers(event)">
                        </div>
  
                        <div class="input-box col-md-4">
                          <span class="details">PUsed Description:</span>
                          <input type="text" class="form-control light-gray-placeholder puse_desc"name="puse_desc" placeholder="Enter PUsed Description" id="puse_desc" onkeypress="return blockSymbolsAndNumbers(event)">
                      </div>
  
                      <div class="input-box col-md-4">
                        <span class="details">Actual Used:</span>
                        <input type="text" class="form-control light-gray-placeholder actual_used"name="actual_used" placeholder="Enter Actual Used" id="actual_used" onkeypress="return blockSymbolsAndNumbers(event)">
                    </div>
  
                 
                 
                  <div class="input-box col-md-4">
                    <span class="details">Fill Color:</span>
                    <div class="d-flex align-items-center">
                        <select class="form-control custom-select" name="fillcolor" id="fill-color-select" aria-label="Fill color select">
                          <option value="">Select</option>
                          <option value="#000000">Black</option>
                            <option value="#ff0000">Red</option>
                            <option value="#00ff00">Green</option>
                            <option value="#0000ff">Blue</option>
                            <option value="#ffff00">Yellow</option>
                            <option value="#ffffff">White</option>
                            <option value="#ff00ff">Magenta</option>
                            <option value="#00ffff">Cyan</option>
                            <option value="custom-fill">Custom Color</option>
                        </select>
                        <input type="color" id="custom-fill-color" name="custom_fill_color" style="display: none; margin-left: 10px;">
                    </div>
                </div>
                
                <div class="input-box col-md-4">
                    <span class="details">Parcel Color:</span>
                    <div class="d-flex align-items-center">
                        <select class="form-control custom-select" name="strokecolor" id="stroke-color-select" aria-label="Stroke color select">
                            <option value="">Select</option>
                      
                            <option value="#FFBF00">Rice: #FFBF00</option>
                            <option value="#ffff33">Corn: #ffff33</option>
                            <option value="#663300">Coconut: #663300</option>
                            <option value="#009900">Banana: #009900</option>
                            <option value="#0040ff">Residential:#0040ff</option>
                            <option value="custom-stroke">Custom Color</option>
                        </select>
                        <input type="color" id="custom-stroke-color" name="custom_stroke_color" style="display: none; margin-left: 10px;">
                    </div>
                </div>
                
                <div class="input-box col-md-4">
                    <span class="details">Area:</span>
                    <input type="text" class="form-control light-gray-placeholder" name="area" id="area" placeholder="Area" readonly>
                </div>
                
                <div class="input-box col-md-4">
                    <span class="details">Altitude:</span>
                    <input type="text" class="form-control light-gray-placeholder"  name="altitude" id="altitude" placeholder="Altitude" readonly>
                </div>
                
                <div class="input-box col-md-4">
                    <span class="details">Polygon Coordinates:</span>
                    <textarea id="polygon-coordinates" rows="5" cols="50" class="form-control light-gray-placeholder" name="coordinates" placeholder="Polygon Coordinates" readonly></textarea>
                </div>
                              
                          
                <div id="map" style="height: 550px; width: 100%;margin-botton:20px;"></div>     
    
                         
                <button id="remove-polygon"class="btn btn-success" type="button">Remove Polygon</button>
        
                          </div>
                        
                      </div>
                  </div>
              </div>
          </div>

        <!-- Buttons outside the accordions -->
            <div class="button-container mt-3 d-flex justify-content-between">
                <a href="{{ route('polygon.polygons_show') }}" button type="button" class="btn btn-primary" onclick="goBack()">Back</button></a>
                <button id="save-polygon" class="btn btn-success">Save</button>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
                                    </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>                 
</form>
</div>
<!-- Include the Google Maps API with Drawing and Geometry libraries -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&libraries=drawing,geometry&callback=initMap"></script>

<script type="text/javascript">
    var map;
    var drawingManager;
    var selectedShape;

    function initMap() {
        var initialLocation = { lat: 6.9214, lng: 122.0790 }; // Adjust to your desired initial map center

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: initialLocation,
            mapTypeId: 'satellite'
        });

        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: ['polygon']
            },
            polygonOptions: {
                editable: true,
                strokeWeight: 2
            }
        });
        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
            if (event.type === google.maps.drawing.OverlayType.POLYGON) {
                if (selectedShape) {
                    selectedShape.setMap(null);
                }
                selectedShape = event.overlay;

                updatePolygonColors();

                var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
                document.getElementById('area').value = area.toFixed(2);

                var path = selectedShape.getPath();
                var coordinatesText = '';
                path.forEach(function (latLng, index) {
                    var lat = latLng.lat();
                    var lng = latLng.lng();
                    coordinatesText += 'Vertex ' + (index + 1) + ': Latitude: ' + lat.toFixed(6) + ', Longitude: ' + lng.toFixed(6) + '\n';
                });
                document.getElementById('polygon-coordinates').value = coordinatesText;

                getElevation(path.getAt(0));

                google.maps.event.addListener(selectedShape.getPath(), 'set_at', updatePolygonColors);
                google.maps.event.addListener(selectedShape.getPath(), 'insert_at', updatePolygonColors);
            }
        });

        loadPolygons();
    }

    document.getElementById('remove-polygon').addEventListener('click', function () {
        if (selectedShape) {
            selectedShape.setMap(null);
            selectedShape = null;
            document.getElementById('area').value = '';
            document.getElementById('altitude').value = '';
            document.getElementById('polygon-coordinates').value = '';
            alert("Polygon removed successfully!");
        } else {
            alert("No polygon selected to remove.");
        }
    });

    function getElevation(latLng) {
        var elevator = new google.maps.ElevationService();
        elevator.getElevationForLocations({ 'locations': [latLng] }, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    var elevation = results[0].elevation;
                    document.getElementById('altitude').value = elevation.toFixed(2);
                } else {
                    document.getElementById('altitude').value = 'No data';
                }
            } else {
                document.getElementById('altitude').value = 'Error';
            }
        });
    }

    // function loadPolygons() {
    //     var mapdata = @json($mapdata);

    //     mapdata.forEach(function (parcel) {
    //         var polygon = new google.maps.Polygon({
    //             paths: parcel.coordinates.map(coord => new google.maps.LatLng(coord.lat, coord.lng)),
    //             strokeColor: parcel.strokecolor,
    //             strokeOpacity: 0.8,
    //             strokeWeight: 2,
    //             fillColor: parcel.fillcolor,
    //             fillOpacity: 0.02
    //         });
    //         polygon.setMap(map);

    //         google.maps.event.addListener(polygon, 'click', function () {
    //             var contentString = 'Polygon Name: ' + parcel.polygon_name + '<br>' +
    //                                 'Area: ' + parcel.area + ' sq. meters<br>' +
    //                                 'Altitude: ' + parcel.altitude + ' meters';
    //             var infowindow = new google.maps.InfoWindow({
    //                 content: contentString
    //             });
    //             infowindow.setPosition(parcel.coordinates[0]);
    //             infowindow.open(map);
    //         });
    //     });

    //     var bounds = new google.maps.LatLngBounds();
    //     mapdata.forEach(function (parcel) {
    //         parcel.coordinates.forEach(function (coord) {
    //             bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
    //         });
    //     });
    //     map.fitBounds(bounds);
    // }
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

        google.maps.event.addListener(polygon, 'click', function () {
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
                                'Altitude: ' + parcel.altitude + ' meters<br>' 
                                ;
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
    mapdata.forEach(function (parcel) {
        plotPolygon(parcel);
    });

    // Plot polygons from `parceldata` with `isParcelData` flag set to true
    parceldata.forEach(function (parcel) {
        plotPolygon(parcel, true);
    });

    // Extend map bounds based on all parcels' coordinates
    var bounds = new google.maps.LatLngBounds();
    mapdata.concat(parceldata).forEach(function (parcel) {
        parcel.coordinates.forEach(function (coord) {
            bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
        });
    });
    map.fitBounds(bounds);
}

//     document.getElementById('save-polygon').addEventListener('click', function () {
//     // Check if a shape is selected
//     if (!selectedShape) {
//         alert("Please draw a polygon first.");
//         return;
//     }

//     var path = selectedShape.getPath();
//     var coordinates = [];
    
//     // Extract coordinates from the polygon path
//     path.forEach(function (latLng) {
//         coordinates.push({
//             lat: latLng.lat(),
//             lng: latLng.lng()
//         });
//     });

//     // Fetch values from form fields
//     var polygonName = document.getElementById('boarder-name').value;
//     var area = document.getElementById('area').value;
//     var altitude = document.getElementById('altitude').value;
//     var arpowner_na = document.getElementById('arpowner_na').value;
//     var districtSelect = document.getElementById('districtSelect').value;
//     var barangaySelect = document.getElementById('barangaySelect').value;
//     var landTitle = document.getElementById('landTitle').value;
//     var lotNo = document.getElementById('lotNo').value;
//     var pkind_desc = document.getElementById('pkind_desc').value;
//     var puse_desc = document.getElementById('puse_desc').value;
//     var actual_used = document.getElementById('actual_used').value;

//     // Check if required fields are empty
//     // if (!polygonName || !area || !districtSelect || !barangaySelect) {
//     //     alert("Please fill out all required fields.");
//     //     return;
//     // }

//     // Debugging log for form values
//     console.log("Polygon Name:", polygonName);
//     console.log("Area:", area);
//     console.log("Altitude:", altitude);
//     console.log("ARP Owner:", arpowner_na);
//     console.log("District:", districtSelect);
//     console.log("Barangay:", barangaySelect);
//     console.log("Land Title:", landTitle);
//     console.log("Lot No:", lotNo);
//     console.log("Kind Description:", pkind_desc);
//     console.log("Use Description:", puse_desc);
//     console.log("Actual Use:", actual_used);

//     var fillColor = getSelectedFillColor(); // Custom function to get fill color
//     var strokeColor = getSelectedStrokeColor(); // Custom function to get stroke color

//     // Prepare AJAX request
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', '/admin-add-parcel', true);
//     xhr.setRequestHeader('Content-Type', 'application/json');
//     xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4) {
//             if (xhr.status === 200) {
//                 alert("Polygon saved successfully.");
//                 // location.reload();
//             } else {
//                 // Add additional error information for better debugging
//                 console.error("Error status:", xhr.status);
//                 console.error("Error response:", xhr.responseText);
//                 alert("Failed to save polygon. Please check the console for more details.");
//             }
//         }
//     };

//     // Send the JSON data to the server
//     xhr.send(JSON.stringify({
//         coordinates: coordinates,
//         polygon_name: polygonName,
//         area: area,
//         altitude: altitude,
//         arpowner_na: arpowner_na,
//         districtSelect: districtSelect,
//         barangaySelect: barangaySelect,
//         landTitle: landTitle,
//         lotNo: lotNo,
//         pkind_desc: pkind_desc,
//         puse_desc: puse_desc,
//         actual_used: actual_used,
//         fillcolor: fillColor,
//         strokecolor: strokeColor
//     }));
// });
document.getElementById('save-polygon').addEventListener('click', function () {
    // Check if a shape is selected
    if (!selectedShape) {
        alert("Please draw a polygon first.");
        return;
    }

    var path = selectedShape.getPath();
    var coordinates = [];

    // Extract coordinates from the polygon path
    path.forEach(function (latLng) {
        coordinates.push({
            lat: latLng.lat(),
            lng: latLng.lng()
        });
    });

    // Fetch values from form fields
    var polygonName = document.getElementById('boarder-name').value;
    var area = document.getElementById('area').value;
    var altitude = document.getElementById('altitude').value;
    var arpowner_na = document.getElementById('arpowner_na').value;
    var districtSelect = document.getElementById('districtSelect').value;
    var barangaySelect = document.getElementById('barangaySelect').value;
    var landTitle = document.getElementById('landTitle').value;
    var lotNo = document.getElementById('lotNo').value;
    var pkind_desc = document.getElementById('pkind_desc').value;
    var puse_desc = document.getElementById('puse_desc').value;
    var actual_used = document.getElementById('actual_used').value;

    // Validation for required fields
    if (!polygonName) {
        alert("Please enter a name for the polygon.");
        return;
    }
    if (!arpowner_na) {
        alert("Please enter the ARP owner name.");
        return;
    }
    if (!districtSelect) {
        alert("Please select a district.");
        return;
    }
    if (!barangaySelect) {
        alert("Please select a barangay.");
        return;
    }
    if (!actual_used) {
        alert("Please enter the actual use of the land.");
        return;
    }

    // Debugging log for form values
    console.log("Polygon Name:", polygonName);
    console.log("Area:", area);
    console.log("Altitude:", altitude);
    console.log("ARP Owner:", arpowner_na);
    console.log("District:", districtSelect);
    console.log("Barangay:", barangaySelect);
    console.log("Land Title:", landTitle);
    console.log("Lot No:", lotNo);
    console.log("Kind Description:", pkind_desc);
    console.log("Use Description:", puse_desc);
    console.log("Actual Use:", actual_used);

    var fillColor = getSelectedFillColor(); // Custom function to get fill color
    var strokeColor = getSelectedStrokeColor(); // Custom function to get stroke color

    // Prepare AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin-add-parcel', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert("Polygon saved successfully.");
                // location.reload();
            } else {
                // Add additional error information for better debugging
                console.error("Error status:", xhr.status);
                console.error("Error response:", xhr.responseText);
                alert("Failed to save polygon. Please check the console for more details.");
            }
        }
    };

    // Send the JSON data to the server
    xhr.send(JSON.stringify({
        coordinates: coordinates,
        polygon_name: polygonName,
        area: area,
        altitude: altitude,
        arpowner_na: arpowner_na,
        districtSelect: districtSelect,
        barangaySelect: barangaySelect,
        landTitle: landTitle,
        lotNo: lotNo,
        pkind_desc: pkind_desc,
        puse_desc: puse_desc,
        actual_used: actual_used,
        fillcolor: fillColor,
        strokecolor: strokeColor
    }));
});


    function getSelectedFillColor() {
        var fillColorSelect = document.getElementById('fill-color-select').value;
        if (fillColorSelect === 'custom-fill') {
            return document.getElementById('custom-fill-color').value;
        }
        return fillColorSelect;
    }

    function getSelectedStrokeColor() {
        var strokeColorSelect = document.getElementById('stroke-color-select').value;
        if (strokeColorSelect === 'custom-stroke') {
            return document.getElementById('custom-stroke-color').value;
        }
        return strokeColorSelect;
    }

    // Event listener for showing/hiding custom color inputs for fill color
    document.getElementById('fill-color-select').addEventListener('change', function () {
        var fillColorSelect = document.getElementById('fill-color-select').value;
        var customFillInput = document.getElementById('custom-fill-color');
        if (fillColorSelect === 'custom-fill') {
            customFillInput.style.display = 'block';  // Show custom color input
        } else {
            customFillInput.style.display = 'none';   // Hide custom color input
        }
    });

    // Event listener for showing/hiding custom color inputs for stroke color
    document.getElementById('stroke-color-select').addEventListener('change', function () {
        var strokeColorSelect = document.getElementById('stroke-color-select').value;
        var customStrokeInput = document.getElementById('custom-stroke-color');
        if (strokeColorSelect === 'custom-stroke') {
            customStrokeInput.style.display = 'block';  // Show custom color input
        } else {
            customStrokeInput.style.display = 'none';   // Hide custom color input
        }
    });

    function updatePolygonColors() {
        var fillColor = getSelectedFillColor();
        var strokeColor = getSelectedStrokeColor();
        selectedShape.setOptions({
            fillColor: fillColor,
            strokeColor: strokeColor
        });
    }
</script>  

<script>

$(document).ready(function() {
    // Function to fetch AgriDistricts
    function fetchAgriDistricts() {
        $.ajax({
            url: '/admin-add-parcel', // Replace with your route for fetching AgriDistricts
            method: 'GET',
            data: { type: 'districts' }, // Request districts
            success: function(response) {
                console.log('Received AgriDistricts data:', response);
                
                if (response.error) {
                    console.error('Error fetching AgriDistricts:', response.error);
                    return;
                }

                // Check if response is an object and has entries
                if (typeof response === 'object' && Object.keys(response).length > 0) {
                    $('#districtSelect').empty().append('<option value="" disabled selected>Select AgriDistrict</option>');
                    
                    // Populate districts in the dropdown
                    $.each(response, function(id, district) {
                        $('#districtSelect').append(new Option(district, id));
                    });
                } else {
                    console.warn('No AgriDistrict data received or data is empty.');
                }
            },
            error: function(xhr) {
                console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
            }
        });
    }

    // Function to fetch Barangays based on selected AgriDistrict
    function fetchBarangays(districtId, selectElement) {
        $.ajax({
            url: '/admin-add-parcel', // Replace with your route for fetching Barangays
            method: 'GET',
            data: { type: 'barangays', district: districtId },
            success: function(response) {
                console.log('Received Barangays data:', response);

                if (response.error) {
                    console.error('Error fetching Barangays:', response.error);
                    return;
                }

                const $barangaySelect = $(selectElement).closest('.user-details').find('.barangaySelect');
                $barangaySelect.empty();
                $barangaySelect.append('<option value="" disabled selected>Select Barangay</option>');
                $barangaySelect.append('<option value="add">Add New Barangay...</option>'); // Option to add new barangay

                // Populate barangays in the dropdown
                $.each(response, function(id, barangay) {
                    $barangaySelect.append(new Option(barangay, id));
                });
            },
            error: function(xhr) {
                console.error('AJAX request failed. Status:', xhr.status, 'Response:', xhr.responseText);
            }
        });
    }

    // Fetch AgriDistricts on page load
    fetchAgriDistricts();

    // Bind change event to AgriDistrict dropdown
    $(document).on('change', '#districtSelect', function() {
        const districtId = $(this).val();
        if (districtId) {
            fetchBarangays(districtId, this); // Fetch barangays for the selected district
        } else {
            // Clear the barangay dropdown if no district is selected
            $(this).closest('.user-details').find('.barangaySelect')
                .empty().append('<option value="" disabled selected>Select Barangay</option><option value="add">Add New Barangay...</option>');
        }
    });

    // Bind change event to Barangay dropdowns to add new barangay
    $(document).on('change', '.barangaySelect', function() {
        const barangaySelect = this;

        // If "Add New Barangay..." is selected
        if (barangaySelect.value === "add") {
            const newBarangay = prompt("Please enter the name of the barangay:");

            if (newBarangay) {
                // Check if the barangay already exists in the dropdown
                const existingOption = Array.from(barangaySelect.options).find(option => option.value === newBarangay);

                if (!existingOption) {
                    // Add the new barangay to the dropdown
                    const newOption = document.createElement("option");
                    newOption.text = newBarangay;
                    newOption.value = newBarangay;
                    barangaySelect.appendChild(newOption);

                    // Select the newly added barangay
                    barangaySelect.value = newBarangay;
                }
            }
        }
    });
});



</script>
<script src="{{ asset('js/farmer.js') }}"></script>
@endsection