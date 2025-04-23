@extends('admin.dashb')
@section('admin')

    @extends('layouts._footer-script')
    @extends('layouts._head')


    <div class="page-content">
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">

            <h2> Crop and Polygon Setting</h2>
        </div>
        <br>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('message'))
            <div class="alert alert-success" id="success-alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                {{ session()->get('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Your card content here -->
        <div class="tabs">
            <input type="radio" name="tabs" id="Seed" checked="checked">
            <label for="Seed">Polygon</label>
      
            <div class="tab">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="input-group mb-3 me-md-1">
                        <h5 for="Seed" class="me-3">a. Polygon Boundary</h5>
                    </div>

                    <div class="me-md-1">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" title="add Polygon"
                            data-bs-target="#mapModal">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
               
                      
                    </div>
                    {{-- Search engine for polygon --}}
                    <form action="">
                                      
                        <!-- POLYGON SEARCH -->
                    <input type="text" id="search-polygon" placeholder="Search Polygon..." class="form-control mb-2">

                  
                </form>
                    <!-- Map Modal -->
                    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mapModalLabel">Polygon Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div id="map" style="height: 200px; width: 80%;"></div>
                                    <!-- Polygon Coordinates Section -->
                                    <div
                                        style="margin: 40px auto; width: 80%; max-width: 800px; display: flex; flex-wrap: wrap; gap: 20px;">




                                        <!-- Right Column -->
                                        <div style="display: flex; gap: 20px;">
                                            <div style="flex: 1; margin-bottom: 20px;">
                                                <h5 style="margin-bottom: 10px;">Polygon Name</h5>

                                                <select id="boarder-name" onchange="checkPolygonName()"
                                                    style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                    <option value="">Select</option>
                                                    <option value="Ayala">Ayala Boarder</option>
                                                    <option value="Tumaga">Tumaga Boarder</option>
                                                    <option value="Culianan">Culianan Boarder</option>
                                                    <option value="Manicahan">Manicahan Boarder</option>
                                                    <option value="Curuan">Curuan Boarder</option>
                                                    <option value="Vitali">Vitali Boarder</option>
                                                    <option value="Rice">Rice Boarder</option>
                                                    <option value="Corn">Corn Boarder</option>
                                                    <option value="Coconut">Coconut Boarder</option>

                                                    <option value="Add prefer">Add prefer</option>
                                                </select>

                                                <button id="removePolygonButton"
                                                    style="display: none; margin-top: 10px; padding: 10px; border: none; background-color: #FF5733; color: white; border-radius: 5px; cursor: pointer;"
                                                    onclick="removeCustomPolygon()">Remove</button>
                                            </div>

                                            <!-- Area of the Polygon Section -->


                                            <!-- Polygon Fill Color Section -->
                                            <div style="flex: 1; margin-bottom: 20px;">
                                                <h5 style="margin-bottom: 10px;">Polygon Fill Color</h5>

                                                <select id="fill-color-select"
                                                    style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                    <option value="">Select Fill Color</option>
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

                                                <!-- Custom fill color input -->
                                                {{-- <label for="custom-fill-color" id="custom-fill-color-label" style="display: none; margin-top: 10px;">Custom Fill Color:</label> --}}
                                                <input type="color" id="custom-fill-color"
                                                    style="display: none; margin-top: 10px; width: 100%; padding: 10px;">
                                            </div>

                                            <!-- Polygon Stroke Color Section -->
                                            <div style="flex: 1; margin-bottom: 20px;">
                                                <h5 style="margin-bottom: 10px;">Stroke Color</h5>

                                                <select id="stroke-color-select"
                                                    style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                    <option value="">Select Stroke Color</option>
                                                    <option value="#00aa00">Ayala</option>
                                                    <option value="#55007f">Tumaga</option>
                                                    <option value="#ffff00">Culianan</option>
                                                    <option value="#ff5500">Manicahan</option>
                                                    <option value="#ff00ff">Curuan</option>
                                                    <option value="#ff0000">Vitali</option>
                                                    <option value="#FFBF00">Rice</option>
                                                    <option value="#ffff33">Corn</option>
                                                    <option value="#663300">Coconut</option>
                                                    <option value="#0040ff">Residential</option>
                                                    <option value="custom-stroke">Custom Color</option>
                                                </select>

                                                <!-- Custom stroke color input -->
                                                {{-- <label for="custom-stroke-color" id="custom-stroke-color-label" style="display: none; margin-top: 30px;">Custom Stroke Color:</label> --}}
                                                <input type="color" id="custom-stroke-color"
                                                    style="display: none; margin-top: 10px; width: 100%; padding: 10px;">
                                            </div>

                                        </div>



                                        <!-- Left Column -->
                                        <div style="display: flex; gap: 20px;">
                                            <!-- Section to display Altitude -->
                                            <div style="flex: 1; margin-bottom: 20px;">
                                                <h5>Area (in sq. m)</h5>

                                                <input type="text" id="area" placeholder="Area of the Polygon"
                                                    readonly
                                                    style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                            </div>

                                            <div style="flex: 1; margin-bottom: 20px;">
                                                <div style="margin-bottom: 20px;">
                                                    <h5>Altitude (in meters)</h5>
                                                    <input type="text" id="altitude" readonly
                                                        style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                                                </div>
                                            </div>

                                            <!-- Polygon Coordinates Section -->
                                            <div style="flex: 1; margin-bottom: 20px;">
                                                <div>
                                                    <h5 style="margin-bottom: 10px;">Polygon Coordinates</h5>
                                                    <textarea id="polygon-coordinates" rows="5" cols="50" readonly
                                                        style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;"></textarea>
                                                </div>
                                            </div>



                                        </div>



                                        <!-- Save Button -->
                                        {{-- <div style="text-align: center; width: 100%;">
                                        <button id="save-polygon" class="btn btn-primary" style="padding: 10px 20px; border-radius: 5px;">Save Polygon</button>
                                        </div> --}}

                                    </div>
                                    <!-- CSRF token for AJAX request -->
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button id="save-polygon" class="btn btn-primary">Save Polygon</button>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <!-- Table content here -->
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Polygon Name</th>
                                <th>Area</th>
                                <th>Altitude</th>
                                <th>color</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="polygon-info-list">
                            <!-- AJAX data will be inserted here -->
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <ul id="pagination-links" class="pagination mb-0">
                            <!-- AJAX pagination links will be inserted here -->
                        </ul>
                    </div>
                </div>
           
            </div>


            {{-- Parcel --}}
            <input type="radio" name="tabs" id="labors" checked="checked">
            <label for="labors">Parcel</label>
            <div class="tab">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="input-group mb-3">
                        <h5>b. Parcellary Boarder</h5>
                    </div>
                    <div class="me-md-1">
                        <a href="{{ route('parcels.new_parcels') }}" class="btn btn-success"><i class="fa fa-plus"
                                title="Add Parcel" aria-hidden="true"></i></a>
                    </div>
                   {{-- Search engine for polygon --}}
                   <form action="">
                                      
                    <!-- PARCEL SEARCH -->
                <input type="text" id="search-parcel" placeholder="Search Parcel..." class="form-control mb-2">

              
            </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <!-- Table content here -->
                        <thead class="thead-light">
                            <tr>

                                <th>#</th>
                                <th>Parcel Name</th>
                                <th>ARP OwnerName</th>

                                <th>actual used</th>

                                <th>Area</th>
                                <th>Parcel Color</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="parcel-boundaries-list">
                           
                        </tbody>
                    </table>
                </div>
                <!-- Pagination links -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <ul id="parcel-pagination-links" class="pagination mb-0">
                        <!-- AJAX pagination links will be inserted here -->
                    </ul>
                </div>
            </div>

            {{-- district --}}
            <input type="radio" name="tabs" id="agridistrict" checked="checked">
            <label for="agridistrict">Agri-District</label>
            <div class="tab">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="input-group mb-3">
                        <h5>c. Agri-District Marker</h5>
                    </div>
                    <div class="me-md-1">
                        <!-- Button trigger modal -->
                        <div class="me-md-1">
                            <a href="{{ route('agri_districts.display') }}" title="Add  Agri-District"
                                class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <form action="">
                                      
                        <!-- AGRI DISTRICT SEARCH -->
                                 <input type="text" id="search-agri" placeholder="Search Agri District..." class="form-control mb-2">

                     </form>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="addBarangayModal" tabindex="-1" aria-labelledby="addBarangayModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addBarangayModalLabel">Add AgriDistrict</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="content">

                                    <form action="">
                                      
                                   <!-- AGRI DISTRICT SEARCH -->
                                            <input type="text" id="search-agri" placeholder="Search Agri District..." class="form-control mb-2">

                    
                                  
                                </form>

                                    <form id="multi-step-form" action{{ url('CornSave') }} method="post">
                                        @csrf
                                        <div>

                                            {{-- <input type="hidden" name="users_id" value="{{ $userId }}"> --}}


                                        </div>
                                        <div class="input-box">

                                            <input type="hidden"
                                                class="form-control light-gray-placeholder @error('first_name') is-invalid @enderror"
                                                name="country" id="validationCustom01" value="corn" readonly>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Step 1 -->
                                        <div id="step-1" class="form_1">
                                            {{-- <h4 class="card-titles" style="display: flex;text-align: center; "><span></span>Rice Survey Form Zamboanga City</h4> --}}
                                            <br>
                                            {{-- <h6 class="card-title"><span></span>Barangay</h6> --}}


                                            <p class="text-success">Provide clear and concise responses to each section,
                                                ensuring accuracy and relevance. If certain information is not applicable,
                                                write N/A.</p><br>

                                            <div class="user-details">

                                                <div class="input-box">
                                                    <span class="details">District name</span>
                                                    <select
                                                        class="form-control light-gray-placeholder @error('name="district"') is-invalid @enderror"
                                                        name="district" id="validationCustom01"
                                                        aria-label="Floating label select e">
                                                        <option selected disabled>Select</option>
                                                        <option value="ayala"
                                                            {{ old('name="district"') == 'ayala' ? 'selected' : '' }}>Ayala
                                                        </option>
                                                        <option value="tumaga"
                                                            {{ old('name="district"') == 'tumaga' ? 'selected' : '' }}>
                                                            Tumaga</option>
                                                        <option value="culianan"
                                                            {{ old('name="district"') == 'culianan' ? 'selected' : '' }}>
                                                            Culianan</option>
                                                        <option value="manicahan"
                                                            {{ old('name="district"') == 'manicahan' ? 'selected' : '' }}>
                                                            Manicahan</option>
                                                        <option value="curuan"
                                                            {{ old('name="district"') == 'curuan' ? 'selected' : '' }}>
                                                            Curuan</option>
                                                        <option value="vitali"
                                                            {{ old('name="district"') == 'vitali' ? 'selected' : '' }}>
                                                            Vitali</option>
                                                    </select>
                                                </div>



                                                <div class="input-box">
                                                    <span class="details">Description</span>
                                                    <input type="text"
                                                        class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"
                                                        name="description" placeholder="description"
                                                        id="selectReligion"onchange="checkReligion()">
                                                    @error('middle_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">Latitude</span>
                                                    <input type="text"
                                                        class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"
                                                        name="latitude" id="lat" placeholder="Enter latitude"
                                                        value="{{ old('latitude') }}">
                                                    @error('middle_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">Longitude</span>
                                                    <input type="text"
                                                        class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"
                                                        name="longitude" id="long" placeholder="Enter longitude"
                                                        value="{{ old('longitude') }}">
                                                    @error('middle_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="input-box">
                                                    <span class="details">Altitude (meters)</span>
                                                    <input type="text"
                                                        class="form-control light-gray-placeholder @error('middle_name') is-invalid @enderror"name="altitude"
                                                        id="altitude" placeholder="Altitude will be fetched" readonly>
                                                    @error('middle_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>



                                            </div>
                                            <div class="form_1_btns">


                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="map" style="height: 400px; width: 100%;"></div>


                                </div>



                            </div>
                            </form>
                        </div>

                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <!-- Table content here -->
                        <thead class="thead-light">
                            <tr>

                                <th>#</th>
                                <th>AgriDistrict Name</th>
                                <th>Description</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Altitude</th>
                                {{-- <th>Area</th>
                                                                   <th>Parcel Color</th> --}}

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="agri-districts-list">
                           
                        </tbody>
                    </table>
                </div>
                <!-- Pagination links -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <ul id="agri-pagination-links" class="pagination mb-0">
                        <!-- AJAX pagination links will be inserted here -->
                    </ul>
                </div>
            </div>


            {{-- crop categroy look up table --}}
            <input type="radio" name="tabs" id="cropCategory" checked="checked">
            <label for="cropCategory">Crop</label>
            <div class="tab">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="input-group mb-3">
                        <h5>c. Crop Category</h5>
                    </div>
                    <div class="me-md-1">
                        <!-- Button trigger modal -->
                        <div class="me-md-1">
                            <a href="{{ route('crop_category.crop_create') }}" title="Add Category"
                                class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                            <form action="">
                                      
                                  
                                           <!-- CROP CATEGORY SEARCH -->
                            <input type="text" id="search-crop-category" placeholder="Search Crop Category..." class="form-control mb-2">

                                </form>
                   
                </div>



                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <!-- Table content here -->
                        <thead class="thead-light">
                            <tr>

                                <th>#</th>
                                <th>Crop Name</th>
                                {{-- <th>Crop type</th> --}}


                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="crop-category-list">
                           
                        </tbody>
                    </table>
                </div>
                <!-- Pagination links -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <ul id="crop-category-pagination-links" class="pagination mb-0">
                        <!-- AJAX pagination links will be inserted here -->
                    </ul>
                </div>
            </div>
            {{-- crop variety look up table --}}
            <input type="radio" name="tabs" id="cropVariety" checked="checked">
            <label for="cropVariety">Crop Variety</label>
            <div class="tab">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="input-group mb-3">
                        <h5>Add Crop Variety</h5>
                    </div>
                    <div class="me-md-1">
                        <!-- Button trigger modal -->
                        <div class="me-md-1">
                            <a href="{{ route('admin.variety.add_variety') }}" class="btn btn-success"><i
                                    class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <form action="">
                                            
                        <!-- CROP VARIETY SEARCH -->
                    <input type="text" id="search-crop-variety" placeholder="Search Crop Variety..." class="form-control mb-2">

             </form>
                  
                </div>



                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <!-- Table content here -->
                        <thead class="thead-light">
                            <tr>

                                <th>#</th>
                                <th>Crop Name</th>
                                <th>Variety Name</th>


                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="crop-variety-list">
                           
                        </tbody>
                    </table>
                </div>
                <!-- Pagination links -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <ul id="crop-variety-pagination-links" class="pagination mb-0">
                        <!-- AJAX pagination links will be inserted here -->
                    </ul>
                </div>
            </div>
            <!-- Repeat the same structure for other tabs -->



        </div>

    </div>
    </div>
    </div>
    </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




    <!-- Include the Google Maps API with Drawing and Geometry libraries -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&libraries=drawing,geometry&callback=initMap">
    </script>
    <script type="text/javascript">
        var map;
        var drawingManager;
        var selectedShape;

        // Initialize the map
        function initMap() {
            var initialLocation = {
                lat: 6.9214,
                lng: 122.0790
            }; // Adjust to your desired initial map center

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: initialLocation,
                mapTypeId: 'satellite'
            });

            // Initialize the Drawing Manager
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

            // Add event listener to capture the drawn polygon
            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                if (event.type === google.maps.drawing.OverlayType.POLYGON) {
                    if (selectedShape) {
                        selectedShape.setMap(null);
                    }
                    selectedShape = event.overlay;

                    updatePolygonColors(); // Apply selected colors when the polygon is created

                    // Calculate and set area
                    var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
                    document.getElementById('area').value = area.toFixed(2);

                    // Get the coordinates of the polygon's vertices
                    var path = selectedShape.getPath();
                    var coordinatesText = '';
                    path.forEach(function(latLng, index) {
                        var lat = latLng.lat();
                        var lng = latLng.lng();
                        coordinatesText += 'Vertex ' + (index + 1) + ': Latitude: ' + lat.toFixed(6) +
                            ', Longitude: ' + lng.toFixed(6) + '\n';
                    });

                    // Display the coordinates in the textarea
                    document.getElementById('polygon-coordinates').value = coordinatesText;

                    // Get the elevation of the first vertex
                    getElevation(path.getAt(0));

                    // Listen for changes in polygon vertices
                    google.maps.event.addListener(selectedShape.getPath(), 'set_at', function() {
                        updatePolygonColors();
                    });

                    google.maps.event.addListener(selectedShape.getPath(), 'insert_at', function() {
                        updatePolygonColors();
                    });
                }
            });

            // Load existing polygons from the server
            loadPolygons();
        }

        // Function to get and display elevation
        function getElevation(latLng) {
            var elevator = new google.maps.ElevationService();
            elevator.getElevationForLocations({
                'locations': [latLng]
            }, function(results, status) {
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

        // Load existing polygons
        function loadPolygons() {
            var mapdata =
            @json($mapdata); // Ensure that $mapdata is properly formatted as JSON in your Laravel controller.

            // Loop through the mapdata and add polygons to the map
            mapdata.forEach(function(parcel) {
                var polygon = new google.maps.Polygon({
                    paths: parcel.coordinates.map(coord => new google.maps.LatLng(coord.lat, coord.lng)),
                    strokeColor: parcel.strokecolor, // Use color from data or default to blue
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: parcel.fillcolor, // Use fill color from data or default to green
                    fillOpacity: 0.02
                });
                polygon.setMap(map);

                // Bind a click event to show parcel details
                google.maps.event.addListener(polygon, 'click', function() {
                    var contentString = 'Parcel ID: ' + parcel.id + '<br>' +
                        'Area: ' + parcel.area + ' sq. meters<br>' +
                        'Altitude: ' + parcel.altitude + ' meters';
                    var infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    infowindow.setPosition(parcel.coordinates[0]);
                    infowindow.open(map);
                });
            });

            // Optionally, fit the map to the bounds of the polygons
            var bounds = new google.maps.LatLngBounds();
            mapdata.forEach(function(parcel) {
                parcel.coordinates.forEach(function(coord) {
                    bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
                });
            });
            map.fitBounds(bounds);
        }

        // Save polygon data via AJAX
        document.getElementById('save-polygon').addEventListener('click', function() {
            if (!selectedShape) {
                alert("Please draw a polygon first.");
                return;
            }

            // Get polygon coordinates
            var path = selectedShape.getPath();
            var coordinates = [];
            path.forEach(function(latLng) {
                coordinates.push({
                    lat: latLng.lat(),
                    lng: latLng.lng()
                });
            });

            // Get area and altitude

            var polygonName = document.getElementById('boarder-name').value;
            var area = document.getElementById('area').value;
            var altitude = document.getElementById('altitude').value;

            // Get fill and stroke colors
            var fillColor = getSelectedFillColor();
            var strokeColor = getSelectedStrokeColor();

            // AJAX request to save the polygon data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin-view-polygon', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute(
                'content'));
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Polygon saved successfully!");
                        window.location.reload(); // Reload the page after successful save
                    } else {
                        alert("Error saving polygon. Please try again.");
                    }
                }
            };
            var data = JSON.stringify({
                coordinates: coordinates,
                polygonName: polygonName,
                area: area,
                altitude: altitude,
                fillcolor: fillColor,
                strokecolor: strokeColor
            });
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
        document.getElementById('fill-color-select').addEventListener('change', function() {
            var fillColorSelect = document.getElementById('fill-color-select').value;
            if (fillColorSelect === 'custom-fill') {
                document.getElementById('custom-fill-color').style.display = 'inline';
                document.getElementById('custom-fill-color-label').style.display = 'inline';
            } else {
                document.getElementById('custom-fill-color').style.display = 'none';
                document.getElementById('custom-fill-color-label').style.display = 'none';
            }
            updatePolygonColors();
        });

        // Event listener for showing/hiding custom color inputs for stroke color
        document.getElementById('stroke-color-select').addEventListener('change', function() {
            var strokeColorSelect = document.getElementById('stroke-color-select').value;
            if (strokeColorSelect === 'custom-stroke') {
                document.getElementById('custom-stroke-color').style.display = 'inline';
                document.getElementById('custom-stroke-color-label').style.display = 'inline';
            } else {
                document.getElementById('custom-stroke-color').style.display = 'none';
                document.getElementById('custom-stroke-color-label').style.display = 'none';
            }
            updatePolygonColors();
        });
    </script>



    <script src="{{ asset('js/modal_map.js') }}"></script>

    <script>
        $(document).ready(function () {
            let sortOrder = 'asc';
            let sortColumn = 'id';
            let currentPage = 1;
            let parcelCurrentPage = 1;
            let agriPage = 1;
            let cropCategoryPage = 1;
            let cropVarietyPage = 1;
    
            function getPageRange(currentPage) {
                const startPage = Math.floor((currentPage - 1) / 3) * 3 + 1;
                const endPage = startPage + 2;
                return { startPage, endPage };
            }
    
            function fetchFarmersData() {
                const filters = {
                    polygon_search: $('#search-polygon').val(),
                    parcel_search: $('#search-parcel').val(),
                    agri_search: $('#search-agri').val(),
                    crop_category_search: $('#search-crop-category').val(),
                    crop_variety_search: $('#search-crop-variety').val(),
                    sort_order: sortOrder,
                    sort_column: sortColumn,
                    polygon_page: currentPage,
                    parcel_page: parcelCurrentPage,
                    agri_page: agriPage,
                    crop_category_page: cropCategoryPage,
                    crop_variety_page: cropVarietyPage
                };
    
                $.ajax({
                    url: '/admin-view-polygon',
                    type: 'GET',
                    data: filters,
                    success: function (response) {
                        $('#polygon-info-list, #parcel-boundaries-list, #agri-districts-list, #crop-category-list, #crop-variety-list').empty();
                        $('#pagination-links, #parcel-pagination-links, #agri-pagination-links, #crop-category-pagination-links, #crop-variety-pagination-links').empty();
    
                        // Polygons
                        response.polygons.data.forEach(info => {
                            $('#polygon-info-list').append(`
                                <tr>
                                    <td>${info.id}</td>
                                    <td>${info.polygon_name || 'N/A'}</td>
                                    <td>${info.area || 'N/A'}</td>
                                    <td>${info.altitude || 'N/A'}</td>
                                    <td>${info.strokecolor || 'N/A'}</td>
                                    <td>
                                        <a href="/admin-edit-polygon/${info.id}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></button></a>
                                        <form action="/admin-delete-polygon/${info.id}" method="post" style="display:inline">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            `);
                        });
    
                        // Parcels
                        response.parcels.data.forEach(boundary => {
                            $('#parcel-boundaries-list').append(`
                                <tr>
                                    <td>${boundary.id}</td>
                                    <td>${boundary.parcel_name || 'N/A'}</td>
                                    <td>${boundary.arpowner_na || 'N/A'}</td>
                                    <td>${boundary.actual_used || 'N/A'}</td>
                                    <td>${boundary.area || 'N/A'}</td>
                                    <td>${boundary.strokecolor || 'N/A'}</td>
                                    <td>
                                        <a href="/admin-edit-parcel-boarders/${boundary.id}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></button></a>
                                        <form action="/admin-delete-parcel-boarders/${boundary.id}" method="post" style="display:inline">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            `);
                        });
    
                        // Agri Districts
                        response.AgriDistrict.data.forEach(item => {
                            $('#agri-districts-list').append(`
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.district || 'N/A'}</td>
                                    <td>${item.description || 'N/A'}</td>
                                    <td>${item.latitude || 'N/A'}</td>
                                    <td>${item.longitude || 'N/A'}</td>
                                    <td>${item.altitude || 'N/A'}</td>
                                    <td>
                                        <a href="/admin-update-agridistrict/${item.id}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></button></a>
                                        <form action="/admin-delete-agridistrict/${item.id}" method="post" style="display:inline">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            `);
                        });
    
                        // Crop Category
                        response.CropCat.data.forEach(item => {
                            $('#crop-category-list').append(`
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.crop_name || 'N/A'}</td>
                                    <td>
                                        <a href="/admin-edit-new-crop/${item.id}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></button></a>
                                        <form action="/admin-delete-crop/${item.id}" method="post" style="display:inline">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            `);
                        });
    
                        // Crop Variety
                        response.CropVariety.data.forEach(item => {
                            $('#crop-variety-list').append(`
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.crop_name || 'N/A'}</td>
                                    <td>${item.variety_name || 'N/A'}</td>
                                    <td>
                                        <a href="/admin-edit-crop-variety/${item.id}"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"></i></button></a>
                                        <form action="/admin-delete-crop-variety/${item.id}" method="post" style="display:inline">
                                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            `);
                        });
    
                        // Pagination
                        createPagination('#pagination-links', response.polygons.current_page, response.polygons.last_page, 'data-page');
                        createPagination('#parcel-pagination-links', response.parcels.current_page, response.parcels.last_page, 'data-parcel-page');
                        createPagination('#agri-pagination-links', response.AgriDistrict.current_page, response.AgriDistrict.last_page, 'data-agri-page');
                        createPagination('#crop-category-pagination-links', response.CropCat.current_page, response.CropCat.last_page, 'data-crop-category-page');
                        createPagination('#crop-variety-pagination-links', response.CropVariety.current_page, response.CropVariety.last_page, 'data-crop-variety-page');
                    }
                });
            }
    
            function createPagination(container, current, last, attr) {
                const { startPage, endPage } = getPageRange(current);
                const $container = $(container).empty();
    
                $container.append(`<li class="page-item ${current === 1 ? 'disabled' : ''}">
                    <a href="#" class="page-link" ${attr}="${current - 1}">&laquo;</a>
                </li>`);
    
                for (let i = startPage; i <= endPage && i <= last; i++) {
                    const active = (i === current) ? 'active' : '';
                    $container.append(`<li class="page-item ${active}">
                        <a href="#" class="page-link" ${attr}="${i}">${i}</a>
                    </li>`);
                }
    
                $container.append(`<li class="page-item ${current === last ? 'disabled' : ''}">
                    <a href="#" class="page-link" ${attr}="${current + 1}">&raquo;</a>
                </li>`);
            }
    
            // Pagination click handler
            $(document).on('click', '.page-link', function (e) {
                e.preventDefault();
                const $link = $(this);
    
                if ($link.attr('data-page')) currentPage = parseInt($link.attr('data-page'));
                else if ($link.attr('data-parcel-page')) parcelCurrentPage = parseInt($link.attr('data-parcel-page'));
                else if ($link.attr('data-agri-page')) agriPage = parseInt($link.attr('data-agri-page'));
                else if ($link.attr('data-crop-category-page')) cropCategoryPage = parseInt($link.attr('data-crop-category-page'));
                else if ($link.attr('data-crop-variety-page')) cropVarietyPage = parseInt($link.attr('data-crop-variety-page'));
    
                fetchFarmersData();
            });
    
            // Individual search fields
            $('#search-polygon').on('input', () => { currentPage = 1; fetchFarmersData(); });
            $('#search-parcel').on('input', () => { parcelCurrentPage = 1; fetchFarmersData(); });
            $('#search-agri').on('input', () => { agriPage = 1; fetchFarmersData(); });
            $('#search-crop-category').on('input', () => { cropCategoryPage = 1; fetchFarmersData(); });
            $('#search-crop-variety').on('input', () => { cropVarietyPage = 1; fetchFarmersData(); });
    
            // Initial load
            fetchFarmersData();
        });
    </script>
    
    
        
@endsection
