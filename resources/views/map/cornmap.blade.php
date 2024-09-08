@extends('admin.dashb')
@section('admin')

@extends('layouts._footer-script')
@extends('layouts._head')

<div class="page-content">
    <div class="d-flex justify-content-between">
        <form action="" method="GET" class="d-flex">
            <input type="text" name="query" placeholder="Search" class="form-control me-2">
            <button type="submit" class="btn btn-success">Search</button>
        </form>
    
        <form id="showAllForm" action="" method="GET">
            <button class="btn btn-outline-success" type="submit">All</button>
        </form>
    </div>
<div id="map" style="height: 500px; width: 100%;"></div>


</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&libraries=drawing,geometry&callback=initMap"></script>
<script type="text/javascript">
 var map;
var drawingManager;
var selectedShape;
var markers = [];
var polygons = []; // Array to hold the saved polygons

function initMap() {
  var initialLocation = {lat: 6.9214, lng: 122.0790};

  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: initialLocation,
    mapTypeId: 'terrain'
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
      editable: true
    }
  });
  drawingManager.setMap(map);

  // Add event listener for the drawing manager
  google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
    if (event.type === google.maps.drawing.OverlayType.POLYGON) {
      if (selectedShape) {
        selectedShape.setMap(null);
      }
      selectedShape = event.overlay;
      var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
      document.getElementById('area').value = area.toFixed(2); // Calculate and set area

      // Get the altitude of the first point of the polygon
      var path = selectedShape.getPath().getArray();
      var latLng = path[0];
      getElevation(latLng);

      // Save the polygon
      savePolygon(selectedShape);
    }
  });

  // This event listener will call addMarker() when the map is clicked.
  map.addListener('click', function(event) {
    if (markers.length >= 1) {
        deleteMarkers();
    }

    addMarker(event.latLng);
    document.getElementById('lat').value = event.latLng.lat();
    document.getElementById('long').value = event.latLng.lng();

    // Fetch the altitude for the clicked point
    getElevation(event.latLng);
  });

  // Event listener for latitude and longitude input fields
  $('#lat, #long').on('change', function() {
    var lat = parseFloat($('#lat').val());
    var lng = parseFloat($('#long').val());
    
    if (!isNaN(lat) && !isNaN(lng)) {
      var location = { lat: lat, lng: lng };
      map.setCenter(location);
      deleteMarkers();
      addMarker(location);
    }
  });

  // Function to add marker to the map
  function addMarker(location) {
    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
    markers.push(marker);
  }

  // Function to delete markers from the map
  function deleteMarkers() {
    markers.forEach(marker => {
      marker.setMap(null);
    });
    markers = [];
  }

  // Fetch and display the elevation of a location
  function getElevation(latLng) {
    var elevator = new google.maps.ElevationService();
    elevator.getElevationForLocations({'locations': [latLng]}, function(results, status) {
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

  // Save the polygon
  function savePolygon(polygon) {
    // Get the coordinates of the polygon
    var path = polygon.getPath().getArray().map(function(latLng) {
      return { lat: latLng.lat(), lng: latLng.lng() };
    });
    
    // Store the polygon (you can also send this data to a server)
    polygons.push(path);
    console.log('Polygon saved:', path);
  }

  // Load saved polygons
  function loadPolygons() {
    polygons.forEach(function(path) {
      var polygon = new google.maps.Polygon({
        paths: path,
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        editable: true,
        map: map
      });

      // Add event listener for editing
      google.maps.event.addListener(polygon, 'click', function() {
        if (selectedShape) {
          selectedShape.setMap(null);
        }
        selectedShape = polygon;
      });
    });
  }

  // Initialize and load saved polygons
  loadPolygons();
}

</script>

@endsection