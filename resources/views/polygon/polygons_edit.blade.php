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
                        Update Polygon
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
                          
                            <div id="map" style="height: 550px; width: 100%;margin-botton:20px;"></div>
                             <input type="hidden" class="form-control light-gray-placeholder users_id" name="users_id" value="{{$polygon->users_id}}">
                            <br>
                             <div class="input-box col-md-4">
                              <span class="details">Polygon Name:</span>
                              <select class="form-control custom-select light-gray-placeholder placeholder-text boarder-name @error('boarder-name') is-invalid @enderror" name="polygon_name" id="boarder-name" onchange="checkPolygonName()"aria-label="label select e">
                                <option value="{{$polygon->polygon_name}}">{{$polygon->polygon_name}}</option>
                                <option value="Ayala Boarder">Ayala Boarder</option>
                                <option value="Tumaga Boarder">Tumaga Boarder</option>
                                <option value="Culianan Boarder">Culianan Boarder</option>
                                <option value="Manicahan Boarder">Manicahan Boarder</option>
                                <option value="Curuan Boarder">Curuan Boarder</option>
                                <option value="Vitali Boarder">Vitali Boarder</option>
                                <option value="Rice Boarder">Rice Boarder</option>
                                <option value="Corn Boarder">Corn Boarder</option>
                                <option value="Coconut Boarder">Coconut Boarder</option>
                               
                                <option value="Add prefer">Add prefer</option>
                            </select>
                            <button type="button" id="removePolygonButton" class="btn btn-outline-danger ms-2" style="display: none;" onclick="removeCustomPolygon()">
                                <i class="fa fa-trash"></i>
                            </button>
                          </div>
                          <div class="input-box col-md-4">
                            <span class="details">Fill Color:</span>
                            <div class="d-flex align-items-center">
                                <select class="form-control custom-select" name="fillcolor" id="fill-color-select" aria-label="Fill color select">
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
                                    <option value="{{$polygon->strokecolor}}">{{$polygon->strokecolor}}</option>
                                    <option value="#00aa00">Ayala</option>
                                    <option value="#55007f">Tumaga</option>
                                    <option value="#ffff00">Culianan</option>
                                    <option value="#ff5500">Manicahan</option>
                                    <option value="#ff00ff">Curuan</option>
                                    <option value="#ff0000">Vitali</option>
                                    <option value="#FFBF00">Rice: #FFBF00</option>
                                    <option value="#ffff33">Corn: #ffff33</option>
                                    <option value="#663300">Coconut: #663300</option>
                                    <option value="#009900">Banana: #009900</option>
                                    <option value="custom-stroke">Custom Color</option>
                                </select>
                                <input type="color" id="custom-stroke-color" name="custom_stroke_color" style="display: none; margin-left: 10px;">
                            </div>
                        </div>
                        
                        <div class="input-box col-md-4">
                            <span class="details">Area:</span>
                            <input type="text" class="form-control light-gray-placeholder" value="{{ $polygon->area }}" name="area" id="area" placeholder="Area" readonly>
                        </div>
                        
                        <div class="input-box col-md-4">
                            <span class="details">Altitude:</span>
                            <input type="text" class="form-control light-gray-placeholder" value="{{ $polygon->altitude }}" name="altitude" id="altitude" placeholder="Altitude" readonly>
                        </div>
                        
                        <div class="input-box col-md-4">
                            <span class="details">Polygon Coordinates:</span>
                            <textarea id="polygon-coordinates" rows="5" cols="50" class="form-control light-gray-placeholder" name="coordinates" placeholder="Polygon Coordinates" readonly>{{ $polygon->coordinates }}</textarea>
                        </div>
                        
                        
                        
                            
                        
                         
                       
                          
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
        <div id="cropProfiles" class="cropsect">
            <!-- Dynamic Crop Fields Will Be Added Here -->
        </div>

        <!-- Buttons outside the accordions -->
            <div class="button-container mt-3 d-flex justify-content-between">
                <a href="{{ route('polygon.polygons_show') }}" button type="button" class="btn btn-primary" onclick="goBack()">Back</button></a>
                <button id="save-polygon" type="submit" class="btn btn-success" id="submitButton">Save</button>
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
var newPolygon;

function initMap() {
    var initialLocation = { lat: 6.9214, lng: 122.0790 };

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
            draggable: true,
            strokeWeight: 2,
            fillColor: '#00FF00', // Default fill color
            strokeColor: '#0000FF' // Default stroke color
        }
    });
    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
        if (event.type === google.maps.drawing.OverlayType.POLYGON) {
            if (selectedShape) {
                selectedShape.setMap(null);
            }
            selectedShape = event.overlay;
            setSelectedShape(selectedShape);

            updatePolygonArea();
            updatePolygonCoordinates();
            getElevation(selectedShape.getPath().getAt(0));

            addVertexListeners(selectedShape);
            updatePolygonColors(); // Update colors when polygon is created
        }
    });

    loadPolygons();
}

function getElevation(latLng) {
    var elevator = new google.maps.ElevationService();
    elevator.getElevationForLocations({ 'locations': [latLng] }, function (results, status) {
        if (status === 'OK' && results[0]) {
            var elevation = results[0].elevation;
            document.getElementById('altitude').value = elevation.toFixed(2);
        } else {
            document.getElementById('altitude').value = 'No data';
        }
    });
}

function loadPolygons() {
    var mapdata = @json($mapdata);

    mapdata.forEach(function (parcel) {
        var polygon = new google.maps.Polygon({
            paths: parcel.coordinates.map(coord => new google.maps.LatLng(coord.lat, coord.lng)),
            strokeColor: parcel.strokecolor || '#0000FF',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: parcel.fillcolor || '#00FF00',
            fillOpacity: 0.35,
            editable: true,
            draggable: true
        });
        polygon.setMap(map);

        google.maps.event.addListener(polygon, 'click', function () {
            setSelectedShape(polygon);

            // Get current colors
            var currentFillColor = polygon.get('fillColor');
            var currentStrokeColor = polygon.get('strokeColor');


            // Create input elements for color selection
            var contentString = `
                Parcel ID: ${parcel.polygon_name}<br>
                Area: ${parcel.area} sq. meters<br>
                Altitude: ${parcel.altitude} meters<br>
                Fill Color: <input type="color" id="fill-color-input" value="${currentFillColor}"><br>
                Stroke Color: <input type="color" id="stroke-color-input" value="${currentStrokeColor}">
            `;

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            infowindow.setPosition(parcel.coordinates[0]);
            infowindow.open(map);

            // Add event listeners for immediate color change
            google.maps.event.addListenerOnce(infowindow, 'domready', function () {
                document.getElementById('fill-color-input').addEventListener('input', function () {
                    var newFillColor = this.value;
                    polygon.setOptions({ fillColor: newFillColor });
                });

                document.getElementById('stroke-color-input').addEventListener('input', function () {
                    var newStrokeColor = this.value;
                    polygon.setOptions({ strokeColor: newStrokeColor });
                });
            });
        });

        addVertexListeners(polygon);
    });

    var bounds = new google.maps.LatLngBounds();
    mapdata.forEach(function (parcel) {
        parcel.coordinates.forEach(function (coord) {
            bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
        });
    });
    map.fitBounds(bounds);
}


function setSelectedShape(shape) {
    if (selectedShape) {
        selectedShape.setEditable(false);
        selectedShape.setDraggable(false);
    }
    selectedShape = shape;
    shape.setEditable(true);
    shape.setDraggable(true);
}

function updatePolygonArea() {
    if (selectedShape) {
        var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
        document.getElementById('area').value = area.toFixed(2);
    }
}

function updatePolygonCoordinates() {
    if (selectedShape) {
        var path = selectedShape.getPath();
        var coordinatesText = '';
        path.forEach(function (latLng, index) {
            coordinatesText += 'Vertex ' + (index + 1) + ': Latitude: ' + latLng.lat().toFixed(6) + ', Longitude: ' + latLng.lng().toFixed(6) + '\n';
        });
        document.getElementById('polygon-coordinates').value = coordinatesText;
    }
}

function addVertexListeners(polygon) {
    google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
        createNewPolygon();
    });

    google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
        createNewPolygon();
    });

    google.maps.event.addListener(polygon, 'click', function (event) {
        var path = polygon.getPath();
        path.insertAt(path.getLength(), event.latLng);
        createNewPolygon();
    });
}

function createNewPolygon() {
    if (selectedShape) {
        var updatedCoordinates = selectedShape.getPath().getArray().map(function (latLng) {
            return { lat: latLng.lat(), lng: latLng.lng() };
        });

        if (newPolygon) {
            newPolygon.setMap(null);
        }

        newPolygon = new google.maps.Polygon({
            paths: updatedCoordinates,
            strokeColor: getSelectedStrokeColor(), // Use selected stroke color
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: getSelectedFillColor(), // Use selected fill color
            fillOpacity: 0.35,
            editable: true,
            draggable: true
        });
        newPolygon.setMap(map);

        updatePolygonArea();
        updatePolygonCoordinates();
    }
}


document.getElementById('save-polygon').addEventListener('click', function (event) {
    // Prevent default form submission behavior
    event.preventDefault();

    var coordinates = [];

    // Check if a shape has been drawn or selected
    if (selectedShape && selectedShape.getPath() && selectedShape.getPath().getLength() > 0) {
        // Get the path of the polygon (the coordinates)
        var path = selectedShape.getPath();

        // Loop through each coordinate and store in the array
        path.forEach(function (latLng) {
            coordinates.push({ lat: latLng.lat(), lng: latLng.lng() });
        });

        // Log coordinates for debugging
        console.log('Polygon Coordinates:', coordinates);

        // Convert coordinates to a readable format for the textarea
        var coordinatesString = coordinates.map(function(coord) {
            return `Lat: ${coord.lat}, Lng: ${coord.lng}`;
        }).join('\n');

        // Set the coordinates in the textarea
        document.getElementById('polygon-coordinates').value = coordinatesString;

    } else {
        // No valid polygon selected or drawn
        alert("No polygon selected. Please draw or select a polygon.");
        return; // Stop further execution
    }

    // Get other form data
    var area = document.getElementById('area').value;
    var altitude = document.getElementById('altitude').value;
    var polygonName = document.getElementById('boarder-name').value;
    var strokeColor = getSelectedStrokeColor();

    console.log(polygonName); // For debugging

    // Create an XMLHttpRequest to send the data
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true); // Add your endpoint URL here
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert("Polygon saved successfully!");
                location.reload(); // Reload the page after successful save
            } else {
                alert("Error saving polygon: " + xhr.statusText); // Handle error
            }
        }
    };

    // Create the data object to be sent
    var data = JSON.stringify({
        coordinates: coordinates,
        area: area,
        altitude: altitude,
        polygonName: polygonName,
        strokecolor: strokeColor
    });

    // Send the data to the server
    xhr.send(data);
});

// Function to update polygon fill and stroke colors based on the selected options
function updatePolygonColors() {
    if (selectedShape) {
        var fillColor = getSelectedFillColor();
        var strokeColor = getSelectedStrokeColor();

        selectedShape.setOptions({
            fillColor: fillColor,
            strokeColor: strokeColor
        });
    }
}

// Helper function to get the selected fill color
function getSelectedFillColor() {
    var fillColorSelect = document.getElementById('fill-color-select').value;
    if (fillColorSelect === 'custom-fill') {
        return document.getElementById('custom-fill-color').value;
    }
    return fillColorSelect;
}

// Helper function to get the selected stroke color
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
    if (fillColorSelect === 'custom-fill') {
        document.getElementById('custom-fill-color').style.display = 'inline';
        document.getElementById('custom-fill-color-label').style.display = 'inline';
    } else {
        document.getElementById('custom-fill-color').style.display = 'none';
        document.getElementById('custom-fill-color-label').style.display = 'none';
    }
    updatePolygonColors(); // Update colors when fill color is changed
});

// Event listener for showing/hiding custom color inputs for stroke color
document.getElementById('stroke-color-select').addEventListener('change', function () {
    var strokeColorSelect = document.getElementById('stroke-color-select').value;
    if (strokeColorSelect === 'custom-stroke') {
        document.getElementById('custom-stroke-color').style.display = 'inline';
        document.getElementById('custom-stroke-color-label').style.display = 'inline';
    } else {
        document.getElementById('custom-stroke-color').style.display = 'none';
        document.getElementById('custom-stroke-color-label').style.display = 'none';
    }
    updatePolygonColors(); // Update colors when stroke color is changed
});

</script>
<script src="{{ asset('js/modal_map.js') }}"></script>
  @endsection
