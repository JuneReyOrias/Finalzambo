
@extends('admin.dashb')
@section('admin') 


<div class="page-content">
<nav class="page-breadcrumb">
<!-- Your existing code here -->
@if ($errors->has('search_error'))
<div class="alert alert-danger">
  {{ $errors->first('search_error') }}
</div>
@endif


{{-- <!-- File input for uploading files -->
<input type="file" id="fileInput" accept=".kml, .kmz, .geojson"> --}}
<input type="hidden" id="fileInput" accept=".kml,.kmz">
<div class="d-flex justify-content-between">
    <form action="{{ route('map.arcmap') }}" method="GET" class="d-flex">
        <input type="text" name="query" placeholder="Search" class="form-control me-2">
        <button type="submit" class="btn btn-success">Search</button>
    </form>

    <form id="showAllForm" action="{{ route('map.arcmap') }}" method="GET">
        <button class="btn btn-outline-success" type="submit">All</button>
    </form>
</div>


{{-- <!-- Container to display search results -->
<div id="searchResults"></div> --}}

@foreach($farmLocation as $location)
<div class="test" 
data-lat="{{ $location->latitude }}" 
data-lng="{{ $location->longitude }}" 
data-location="{{ $location->district}}" 
data-description="{{ $location->description}}" 
data-lastname="{{ $location->last_name.', '.$location->first_name.', '.$location->middle_name}}" 
{{-- data-mothers="{{ $location->mothers_maiden_name}}"  --}}
data-address="{{$location->home_address}}"
{{-- data-agrDistrict="{{$location->agri_district}}" --}}
data-farmAddress="{{$location->farm_address}}"
data-farmCity="{{$location->farm_address.','.$location->agri_district.','.$location->city}}"
data-farm_org="{{$location->no_of_years_as_farmers}}"
data-status="{{$location->tenurial_status}}"
data-years="{{$location->no_of_years_as_farmers}}"
data-landtitle="{{$location->land_title_no}}"
data-lotno= "{{$location->lot_no}}"
data-areaprone="{{$location->area_prone_to}}"
data-ecosystem="{{$location->ecosystem}}"
data-typevariety="{{$location->type_of_variety}}"
data-prefered="{{$location->preferred_variety}}"
data-wetseason="{{$location->planting_schedule_wet_season}}"
data-dryseason="{{$location->planting_schedule_dry_season}}"
data-cropping="{{$location->no_of_cropping_per_year}}"
data-yieldha="{{$location->yield_kg_ha}}"
data-capital="{{$location->source_of_capital}}"
data-rsba="{{$location->rsba_registered}}"
data-pcic="{{$location->pcic_insured}}"
data-assisted="{{$location->government_assisted}}"
data-sex="{{$location->sex}}"
data-area_has="{{$location->total_physical_area}}"
data-cultivated_has="{{$location->total_area_cultivated}}"

data-verone_lat="{{ $location->verone_latitude }}" 
data-verone_lng="{{ $location->verone_longitude }}" 
data-vertwo_lat="{{ $location->vertwo_latitude }}" 
data-vertwo_lng="{{ $location->vertwo_longitude }}" 
data-verthree_lat="{{ $location->verthree_latitude }}" 
data-verthree_lng="{{ $location->verthree_longitude }}" 
data-vertfour_lat="{{ $location->vertfour_latitude }}" 
data-vertfour_lng="{{ $location->vertfour_longitude }}" 
data-verfive_lat="{{ $location->verfive_latitude }}" 
data-verfive_lng="{{ $location->verfive_longitude }}" 
data-versix_lat="{{ $location->versix_latitude }}" 
data-versix_lng="{{ $location->versix_longitude }}" 
data-verseven_lat="{{ $location->verseven_latitude }}" 
data-verseven_lng="{{ $location->verseven_longitude }}" 
data-vereight_lat="{{ $location->vereight_latitude }}" 
data-verteight_lng="{{ $location->verteight_longitude }}"
data-color="{{ $location->strokecolor }}"
data-area= "{{$location->area}}"
data-perimeter= "{{$location->area}}"
data-farms_lat="{{ $location->gps_latitude }}" 
data-farms_lng="{{ $location->gps_longitude }}" 
data-personalInfo_id="{{ $location->personal_informations_id}}"
 ></div>



 {{-- <div  data-verone_lat="{{ $location->verone_latitude }}">{{ $location->verone_latitude }}</div> --}}
{{-- <div      data-location="{{ $location->district }}" >{{ $location->district }}</div> --}}
@endforeach
{{-- @foreach($polygons as $boundary)
<div class="poly" 
data-verone_lat="{{ $boundary->verone_latitude }}" 
data-verone_lng="{{ $boundary->verone_longitude }}" 
data-vertwo_lat="{{ $boundary->vertwo_latitude }}" 
data-vertwo_lng="{{ $boundary->vertwo_longitude }}" 
data-verthree_lat="{{ $boundary->verthree_latitude }}" 
data-verthree_lng="{{ $boundary->verthree_longitude }}" 
data-vertfour_lat="{{ $boundary->vertfour_latitude }}" 
data-vertfour_lng="{{ $boundary->vertfour_longitude }}" ></div>

@endforeach  --}}
{{-- 
@foreach($districts as $location)
<div class="test" 
data-verone_lat="{{ $location->verone_latitude }}" 
data-verone_lng="{{ $location->verone_longitude }}" 
data-vertwo_lat="{{ $location->vertwo_latitude }}" 
data-vertwo_lng="{{ $location->vertwo_longitude }}" 
data-verthree_lat="{{ $location->verthree_latitude }}" 
data-verthree_lng="{{ $location->verthree_longitude }}" 
data-vertfour_lat="{{ $location->vertfour_latitude }}" 
data-vertfour_lng="{{ $location->vertfour_longitude }}" ></div>

@endforeach  --}}


<div>
@php
$id = Auth::id();

// Find the user by their ID and eager load the personalInformation relationship
$location= App\Models\AgriDistrict::all();

@endphp
@foreach ($location as $location)
<div class="newdistrict"
  data-lat="{{ $location->latitude }}" 
  data-lng="{{ $location->longitude }}" 
  data-location="{{ $location->district}}" 
  data-description="{{ $location->description}}"></div>
@endforeach
</div>
<div>
@php
$id = Auth::id();

// Find the user by their ID and eager load the personalInformation relationship
$location= App\Models\Polygon::all();

@endphp
@foreach ($location as $location)
<div class="newpolygo"
data-verone_lat="{{ $location->verone_latitude }}" 
data-verone_lng="{{ $location->verone_longitude }}" 
data-vertwo_lat="{{ $location->vertwo_latitude }}" 
data-vertwo_lng="{{ $location->vertwo_longitude }}" 
data-verthree_lat="{{ $location->verthree_latitude }}" 
data-verthree_lng="{{ $location->verthree_longitude }}" 
data-vertfour_lat="{{ $location->vertfour_latitude }}" 
data-vertfour_lng="{{ $location->vertfour_longitude }}" 
data-verfive_lat="{{ $location->verfive_latitude }}" 
data-verfive_lng="{{ $location->verfive_longitude }}" 
data-versix_lat="{{ $location->versix_latitude }}" 
data-versix_lng="{{ $location->versix_longitude }}" 
data-verseven_lat="{{ $location->verseven_latitude }}" 
data-verseven_lng="{{ $location->verseven_longitude }}" 
data-vereight_lat="{{ $location->vereight_latitude }}" 
data-verteight_lng="{{ $location->verteight_longitude }}"
data-color="{{ $location->strokecolor }}"
data-area= "{{$location->area}}"
data-perimeter= "{{$location->perimeter}}"
data-polyname= "{{$location->poly_name}}"
>


</div>
@endforeach
</div>








<div>
@php
$id = Auth::id();

// Find the user by their ID and eager load the personalInformation relationship
$parcels= App\Models\ParcellaryBoundaries::all();

@endphp
@foreach ($parcels as $parcel )


<div class="newparcel" 
data-parcolors ={{$parcel->parcolor}}
data-parname ={{$parcel->parcel_name}}
data-arpowner_na ={{$parcel->arpowner_na}}
data-brgy_name  ={{$parcel->brgy_name }}

data-lot_no ={{$parcel->lot_no}}
data-tct_no ={{$parcel->tct_no}}
data-pkind_desc ={{$parcel->pkind_desc  }}
data-puse_desc ={{$parcel->puse_desc  }}
data-actual_used ={{$parcel->actual_used  }}
data-paronelat ={{$parcel->parone_latitude}}
data-paronelong ={{$parcel->parone_longitude}}
data-partwolat ={{$parcel->partwo_latitude}}
data-partwolong ={{$parcel->partwo_longitude}}
data-parthreelat ={{$parcel->parthree_latitude}}
data-parthreelong ={{$parcel->parthree_longitude}}
data-parfourlat ={{$parcel->parfour_latitude}}
data-parfourlong ={{$parcel->parfour_longitude}}
data-parfivelat ={{$parcel->parfive_latitude}}
data-parfivelong ={{$parcel->parfive_longitude}}
data-parsixlat ={{$parcel->parsix_latitude}}
data-parsixlong ={{$parcel->parsix_longitude}}
data-parsevenlat ={{$parcel->parseven_latitude}}
data-parsevenlong ={{$parcel->parseven_longitude}}
data-pareightlat ={{$parcel->pareight_latitude}}
data-pareightlong ={{$parcel->pareight_longitude}}
data-parninelat ={{$parcel->parnine_latitude}}
data-parninelong ={{$parcel->parnine_longitude}}
data-partenlat ={{$parcel->parten_latitude}}
data-partenlong ={{$parcel->parten_longitude}}
data-parelevenlat ={{$parcel->pareleven_latitude}}
data-parelevenlong ={{$parcel->pareleven_longitude}}
data-paronetwelvelat ={{$parcel->partwelve_latitude}}
data-partwelvelong ={{$parcel->partwelve_longitude}}


></div>

@endforeach

</div> 





</nav>







<style>
/* Set the height of the map container */
#map {
height: 550px;
}
</style>


<div id="map"></div>
<script>
    window.onload = function() {
        // Convert PHP variable $kmlUrl to a JavaScript variable using JSON.parse
        var kmlUrl = {!! json_encode($kmlUrl) !!};


        console.log('KML URL:', kmlUrl); // Log the fetched KML URL for debugging
        // Call the initMap function with the fetched KML URL
        initMap(kmlUrl);
    };
</script>



{{-- <button onclick="savePolyline()">Save Polyline</button> --}}
{{-- <input type="checkbox" id="satelliteToggle"> Satellite View --}}
</div>
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">

</script>
{{-- <script>
@php
$id = Auth::id();
// Define $personalinformation here, assuming it's available in your PHP code
// Find the user by their ID and eager load the personalInformation relationship
$personalinformation = App\Models\PersonalInformations::find($id);
@endphp

// Check if $personalinformation is not null before using it
@if($personalinformation)
const personalInformationId = "{{ $personalinformation->id ?? '' }}";

const mapViewInfoUrl = personalInformationId ? "{{ route('agent.personal_info.update_records', ':id') }}".replace(':id', personalInformationId) : '';

@endif
</script> --}}

{{-- <script src="{{ asset('js/map_script.js') }}"></script> --}}
<script src="{{ asset('js/old.js') }}"></script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var kmlUrl = '{{ $kmlUrl }}';
        var apiKey = 'AIzaSyDE7griy6QaQSc-PTnmqKPtjYi3EAPG3iw';
        initMap(kmlUrl, apiKey);
    });
</script> --}}

{{-- <script src="{{ asset('js/fetchdat.js') }}"></script> --}}
{{-- <script src="{{ asset('js/new.js') }}"></script> --}}

{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASjYAj6KP3LA2oEEicDMbDCOOdw6Gfey4&callback=initMap" async defer></script> --}}


{{-- <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I", v: "weekly"});</script> --}}
{{-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDE7griy6QaQSc-PTnmqKPtjYi3EAPG3iw&callback=initMap" ></script> --}}
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMstylquYwo8gAuOrkrF5IsN6K8gbgV6I&callback=initMap" ></script>
@endsection