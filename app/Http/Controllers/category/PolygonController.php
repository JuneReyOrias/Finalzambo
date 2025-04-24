<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolygonRequest;
use App\Models\AgriDistrict;
use App\Models\Categorize;
use App\Models\CropCategory;
use App\Models\FarmProfile;
use App\Models\Fertilizer;
use App\Models\Labor;
use App\Models\LastProductionDatas;
use App\Models\ParcellaryBoundaries;
use App\Models\PersonalInformations;
use App\Models\Pesticide;
use App\Models\Polygon;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Models\Barangay;
use App\Models\User;
use App\Models\VariableCost;
use Carbon\Carbon;
use App\Models\CropParcel;
use Illuminate\Support\Facades\Storage;

class PolygonController extends Controller
{
     /**
     * Display a listing of the resource.
     */
  
    /**
     * Show the form for creating a new resource.
     */
  
    


    public function Polygons()
    {
    // Check if the user is authenticated
    if (Auth::check()) {
        // User is authenticated, proceed with retrieving the user's ID
        $userId = Auth::id();

        // Find the user based on the retrieved ID
        $admin = User::find($userId);

        if ($admin) {
            // Assuming $user represents the currently logged-in user
            $user = auth()->user();

            // Check if user is authenticated before proceeding
            if (!$user) {
                // Handle unauthenticated user, for example, redirect them to login
                return redirect()->route('login');
            }

            // Find the user's personal information by their ID
            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
         
            // Fetch the farm ID associated with the user
            $farmId = $user->farm_id;
            $agri_districts = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('users_id', $farmId)->latest()->first();
            $agriculture = AgriDistrict::all();
      

            
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');


            
  // Fetch all CropParcel records and transform them
  $mapdata = CropParcel::all()->map(function($parcel) {
    // Output the individual parcel data for debugging
  //   echo "Parcel data fetched: " . json_encode($parcel) . "\n";

    // Decode the JSON coordinates
    $coordinates = json_decode($parcel->coordinates);
    
    // Check if the coordinates are valid and properly formatted
    if (!is_array($coordinates)) {
      //   echo "Invalid coordinates for parcel ID {$parcel->id}: " . $parcel->coordinates . "\n";
        return null; // Return null for invalid data
    }

    return [
        'id' => $parcel->id, // Include the ID for reference
        'coordinates' => $coordinates, // Include the decoded coordinates
        'area' => $parcel->area, // Assuming there's an area field
        'altitude' => $parcel->altitude, // Assuming there's an altitude field
        'strokecolor' => $parcel->strokecolor, // Include the stroke color
        'fillColor' => $parcel->fillColor // Optionally include the fill color if available
    ];
})->filter(); // Remove any null values from the collection



// If the request expects JSON, return mapdata as a JSON response
if (request()->wantsJson()) {
    return response()->json($mapdata);
}
            // Return the view with the fetched data
            return view('polygon.polygon_create', compact('admin', 'profile', 'farmprofile','totalRiceProduction'
            ,'agri_districts','agri_districts_id','userId','agriculture','mapdata'
            
            ));
        } else {
            // Handle the case where the user is not found
            // You can redirect the user or display an error message
            return redirect()->route('login')->with('error', 'User not found.');
        }
    } else {
        // Handle the case where the user is not authenticated
        // Redirect the user to the login page
        return redirect()->route('login');
    }
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        
          
    
           $parcel = new Polygon();
           $parcel->users_id = $request->users_id;
         
           $parcel->agri_districts = $request->agri_districts;
           $parcel->poly_name = $request->poly_name;
           $parcel->verone_latitude = $request->verone_latitude;
           $parcel->verone_longitude = $request->verone_longitude;
           $parcel->vertwo_latitude = $request->vertwo_latitude;
           $parcel->vertwo_longitude = $request->vertwo_longitude;
           $parcel->verthree_latitude = $request->verthree_latitude;
           $parcel->verthree_longitude = $request->verthree_longitude;
           $parcel->vertfour_latitude = $request->vertfour_latitude;
           $parcel->vertfour_longitude = $request->vertfour_longitude;

           $parcel->verfive_latitude = $request->verfive_latitude;
           $parcel->verfive_longitude = $request->verfive_longitude;
           $parcel->versix_latitude = $request->vertfour_latitude;
           $parcel->versix_longitude = $request->vertfour_longitude;
           $parcel->verseven_latitude = $request->verseven_latitude;
           $parcel->verseven_longitude = $request->verseven_longitude;
           $parcel->vereight_latitude = $request->vereight_latitude;
           $parcel->verteight_longitude = $request->verteight_longitude;
         
           $parcel->longitude = $request->longitude;
           $parcel->latitude = $request->latitude;
           $parcel->area = $request->area;
           $parcel->strokecolor = $request->strokecolor;
        //  dd($parcel);
        // Save the new FarmProfile
        $parcel->save();

           
            return redirect('/admin-view-polygon')->with('message','Polygon Boundary added successsfully');
        
        }
        catch(\Exception $ex){
            dd($ex); // Debugging statement to inspect the exception
            return redirect('/personalinformation')->with('message','Someting went wrong');
            
        }   
    }
// fixed cost view





public function polygonshow(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $admin = User::find(Auth::id());
    if (!$admin) {
        return redirect()->route('login')->with('error', 'User not found.');
    }

    // ========== POLYGON QUERY ==========
    $polygons = CropParcel::query();

    if ($request->filled('polygon_search')) {
        $keyword = $request->input('polygon_search');
        $polygons->where(function ($query) use ($keyword) {
            $query->where('polygon_name', 'like', "%$keyword%")
                  ->orWhere('strokecolor', 'like', "%$keyword%");
        });
    }

    if ($request->filled('sort_column') && $request->filled('sort_order')) {
        $polygons->orderBy($request->input('sort_column'), $request->input('sort_order'));
    } else {
        $polygons->orderBy('id', 'asc');
    }

    $polygonPage = $request->input('polygon_page', 1);
    $polygons = $polygons->paginate(4, ['*'], 'polygon_page', $polygonPage);

    // ========== PARCEL QUERY ==========
    $parcels = ParcellaryBoundaries::query();

    if ($request->filled('parcel_search')) {
        $keyword = $request->input('parcel_search');
        $parcels->where(function ($q) use ($keyword) {
            $q->where('parcel_name', 'like', "%$keyword%")
              ->orWhere('barangay_name', 'like', "%$keyword%")
              ->orWhere('arpowner_na', 'like', "%$keyword%");
        });
    }

    $parcelPage = $request->input('parcel_page', 1);
    $parcels = $parcels->orderBy('id', 'asc')->paginate(4, ['*'], 'parcel_page', $parcelPage);

    // ========== FERTILIZER SEARCH ==========
    $AgriDistrictQuery = AgriDistrict::query();
    if ($request->filled('agri_search')) {
        $searchTerm = $request->input('agri_search');
        $AgriDistrictQuery->where(function ($query) use ($searchTerm) {
            $query->where('district', 'like', "%$searchTerm%")
                ->orWhere('latitude', 'like', "%$searchTerm%")
                ->orWhere('longitude', 'like', "%$searchTerm%");
        });
    }
    $agriPage = $request->input('agri_page', 1);
    $AgriDistrict = $AgriDistrictQuery->orderBy('id', 'asc')->paginate(4, ['*'], 'agri_page', $agriPage);
   

    // ========== CROP CATEGORY ==========
    $CropCatQuery = CropCategory::query();
    if ($request->filled('crop_category_search')) {
        $searchTerm = $request->input('crop_category_search');
        $CropCatQuery->where(function ($query) use ($searchTerm) {
            $query->where('crop_name', 'like', "%$searchTerm%")
                  ->orWhere('type_of_variety', 'like', "%$searchTerm%");
        });
    }

    $cropCategoryPage = $request->input('crop_category_page', 1);
    $CropCat = $CropCatQuery->orderBy('id', 'asc')->paginate(2, ['*'], 'crop_category_page', $cropCategoryPage);
   
  
    $cropVarieties = CropCategory::all()->groupBy('crop_name');

    // ========== CROP VARIETY ==========
    $CropVarietyQuery = Categorize::query();
    if ($request->filled('crop_variety_search')) {
        $searchTerm = $request->input('crop_variety_search');
        $CropVarietyQuery->where(function ($query) use ($searchTerm) {
            $query->where('crop_name', 'like', "%$searchTerm%")
                  ->orWhere('variety_name', 'like', "%$searchTerm%");
        });
    }

    $cropVarietyPage = $request->input('crop_variety_page', 1);
    $CropVariety = $CropVarietyQuery->orderBy('id', 'asc')->paginate(2, ['*'], 'crop_variety_page', $cropVarietyPage);
   
 

    // ========== OTHER DATA ==========
    $districts = PersonalInformations::select('agri_district')->distinct()->orderBy('agri_district')->get();
    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');


    // Fetch all CropParcel records and transform them
    $mapdata = CropParcel::all()->map(function($parcel) {
        // Output the individual parcel data for debugging
    //   echo "Parcel data fetched: " . json_encode($parcel) . "\n";

        // Decode the JSON coordinates
        $coordinates = json_decode($parcel->coordinates);
        
        // Check if the coordinates are valid and properly formatted
        if (!is_array($coordinates)) {
        //   echo "Invalid coordinates for parcel ID {$parcel->id}: " . $parcel->coordinates . "\n";
            return null; // Return null for invalid data
        }

        return [
            'polygon_name' => $parcel->polygon_name, 
            'coordinates' => $coordinates, // Include the decoded coordinates
            'area' => $parcel->area, // Assuming there's an area field
            'altitude' => $parcel->altitude, // Assuming there's an altitude field
            'strokecolor' => $parcel->strokecolor, // Include the stroke color
            'fillColor' => $parcel->fillColor // Optionally include the fill color if available
        ];
    })->filter(); // Remove any null values from the collection
    // ========== AJAX RESPONSE ==========
    if ($request->ajax()) {
        return response()->json([
            'polygons' => $polygons,
            'parcels' => $parcels,
            'AgriDistrict' => $AgriDistrict,
            'CropCat' => $CropCat,
            'CropVariety' => $CropVariety,
            'districts' => $districts,
            'totalRiceProduction' => $totalRiceProduction,

        ]);
    }

    // ========== INITIAL VIEW ==========
    return view('polygon.polygons_show', compact(
        'admin', 'polygons', 'parcels', 'districts', 'totalRiceProduction',
        'AgriDistrict', 'CropCat', 'cropVarieties', 'CropVariety','mapdata'
    ));
}





// polgygons boundary for edit view by fetching the spicific id

public function polygonEdit(Request $request,$id)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // User is authenticated, proceed with retrieving the user's ID
        $userId = Auth::id();

        // Find the user based on the retrieved ID
        $admin = User::find($userId);

        if ($admin) {
            // Assuming $user represents the currently logged-in user
            $user = auth()->user();

            // Check if user is authenticated before proceeding
            if (!$user) {
                // Handle unauthenticated user, for example, redirect them to login
                return redirect()->route('login');
            }

            // Find the user's personal information by their ID
            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
         
            // Fetch the farm ID associated with the user
            $farmId = $user->farm_id;
            $agri_districts = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('users_id', $farmId)->latest()->first();
            $polygon = CropParcel::find($id);

            $mapdata = collect([$polygon])->map(function($parcel) {
                if (!$parcel) {
                    return null; // Return null if the polygon is not found
                }
            
                // Decode the JSON coordinates
                $coordinates = json_decode($parcel->coordinates);
            
                // Check if the coordinates are valid and properly formatted
                if (!is_array($coordinates)) {
                    return null; // Return null for invalid data
                }
            
                return [
                    'polygon_name' => $parcel->polygon_name, 
                    'coordinates' => $coordinates, // Include the decoded coordinates
                    'area' => $parcel->area, // Assuming there's an area field
                    'altitude' => $parcel->altitude, // Assuming there's an altitude field
                    'strokecolor' => $parcel->strokecolor, // Include the stroke color
                    'fillColor' => $parcel->fillColor // Optionally include the fill color if available
                ];
            })->filter(); // Remove any null values from the collection
            
            // // Output the result for debugging purposes (optional)
            // if ($mapdata->isEmpty()) {
            //     echo "No valid data found for the given ID.";
            // } else {
            //     // Output or process the map data as needed
            //     echo json_encode($mapdata);
            // }
            if ($request->ajax()) {
                $type = $request->input('type'); // Get the type of request (districts or barangays)
                
                // Handle requests for agri-districts
                if ($type === 'districts') {
                    $districts = AgriDistrict::pluck('district', 'district'); // Fetch agri-district names as key-value pairs
                    return response()->json($districts);
                }
        
                // Handle requests for barangays based on selected district
                if ($type === 'barangays') {
                    $district = $request->input('district'); // Get the selected district
                    $barangays = Barangay::where('district', $district)->pluck('barangay_name', 'barangay_name'); // Fetch barangays for the district
                    return response()->json($barangays);
                }
        
                return response()->json(['error' => 'Invalid type parameter.'], 400);
            }
        
            
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('polygon.polygons_edit', compact('admin', 'profile', 'farmprofile','totalRiceProduction'
            ,'agri_districts','agri_districts_id','userId','polygon','mapdata'
            
            ));
        } else {
            // Handle the case where the user is not found
            // You can redirect the user or display an error message
            return redirect()->route('login')->with('error', 'User not found.');
        }
    } else {
        // Handle the case where the user is not authenticated
        // Redirect the user to the login page
        return redirect()->route('login');
    }
}
// public function polygonUpdates(PolygonRequest $request,$id)
// {

//     try{
        

//         $data= $request->validated();
//         $data= $request->all();
        
//         $polygon= CropParcel::find($id);

//         $polygon->coordinates = json_encode($request->coordinates); // Save as JSON
//         $polygon->polygon_name = $request->polygonName;
//         $polygon->area = $request->area;
//         $polygon->altitude = $request->altitude;
//         $polygon->strokecolor = $request->strokecolor;
//         $polygon->save();
       

//         // dd($data);
//         $polygon->save();     
        
    
//         return redirect('/admin-view-polygon')->with('message','Polygon Boundary Data Updated successsfully');
    
//       }
//     catch(\Exception $ex){
//         dd($ex); // Debugging statement to inspect the exception
//         return redirect('/admin-edit-polygon/{polygons}')->with('message','Someting went wrong');
        
//       }   
//     } 

public function update(Request $request, $id)
{
    // Validate the incoming data
    $request->validate([
        'coordinates' => 'required|array',
        'polygonName' => 'required|string|max:255',
        'area' => 'required|numeric',
        'altitude' => 'required|numeric',
        'strokecolor' => 'required|string|max:7', // Assuming hex color
    ]);

    // Find the existing polygon record by ID
    $polygon = CropParcel::findOrFail($id); // Use findOrFail to throw an error if not found

    // Update the polygon record
    $polygon->coordinates = json_encode($request->coordinates); // Update coordinates
    $polygon->polygon_name = $request->polygonName; // Update polygon name
    $polygon->area = $request->area; // Update area
    $polygon->altitude = $request->altitude; // Update altitude
    $polygon->strokecolor = $request->strokecolor; // Update stroke color
    $polygon->save(); // Save the updated record

    // Return a response to the frontend
    return response()->json(['success' => true, 'polygon_id' => $polygon->id]);
}




    public function polygondelete($id) {
    try {
        // Find the personal information by ID
        $polygon = CropParcel::find($id);
    
        // Check if the personal information exists
        if (!$polygon) {
            return redirect()->back()->with('error', 'Polygon not found');
        }

        // Delete the personal information data from the database
       $polygon->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Polygon deleted Successfully');
    } catch (\Exception $e) {
        // Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting PoLygon Boundary: ' . $e->getMessage());
    }
    }


    public function AddVariety(){
        // Check if the user is authenticated
    if (Auth::check()) {
    // User is authenticated, proceed with retrieving the user's ID
    $userId = Auth::id();
    
    // Find the user based on the retrieved ID
    $admin = User::find($userId);
    
    if ($admin) {
        // Assuming $user represents the currently logged-in user
        $user = auth()->user();
    
        // Check if user is authenticated before proceeding
        if (!$user) {
            // Handle unauthenticated user, for example, redirect them to login
            return redirect()->route('login');
        }
    
        // Find the user's personal information by their ID
        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
    
        // Fetch the farm ID associated with the user
        $farmId = $user->farm_id;
    
        // Find the farm profile using the fetched farm ID
        $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
        $crop = CropCategory::all()->unique('crop_name')->values();
    
    
        
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        // Return the view with the fetched data
        return view('admin.variety.add_variety', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
        ,'userId','crop'));
    } else {
        // Handle the case where the user is not found
        // You can redirect the user or display an error message
        return redirect()->route('login')->with('error', 'User not found.');
    }
    } else {
    // Handle the case where the user is not authenticated
    // Redirect the user to the login page
    return redirect()->route('login');
    }

    }
    // store data to database
    public function SaveVariety(Request $request){
        try {
                
            $variety = new Categorize();
            $variety->users_id = $request['users_id'];
            if ($request->crop_name === 'Add') {
                $variety->crop_name = $request->new_crop_name; // Use the value entered in the "add_extenstion name" input field
           } else {
                $variety->crop_name = $request->crop_name; // Use the selected color from the dropdown
           }
           
            $variety->variety_name = $request['variety_name'];
          
            // dd($variety);
            $variety->save();
            
            return redirect('/admin-view-polygon')->with('message', 'Variety added successfully');
        } catch(\Exception $ex) {
            // dd($ex);
            return redirect('/admin-add-crop-variety')->with('message', 'Something went wrong');
        }
    
    
     }

     public function editVariety($id){
        // Check if the user is authenticated
    if (Auth::check()) {
    // User is authenticated, proceed with retrieving the user's ID
    $userId = Auth::id();
    
    // Find the user based on the retrieved ID
    $admin = User::find($userId);
    
    if ($admin) {
        // Assuming $user represents the currently logged-in user
        $user = auth()->user();
    
        // Check if user is authenticated before proceeding
        if (!$user) {
            // Handle unauthenticated user, for example, redirect them to login
            return redirect()->route('login');
        }
    
        // Find the user's personal information by their ID
        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
    
        // Fetch the farm ID associated with the user
        $farmId = $user->farm_id;
    
        // Find the farm profile using the fetched farm ID
        $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
        $variety= Categorize::find($id);
    
        $crop= CropCategory::all();
        
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        // Return the view with the fetched data
        return view('admin.variety.edit_variety', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
        ,'userId','variety','crop'));
    } else {
        // Handle the case where the user is not found
        // You can redirect the user or display an error message
        return redirect()->route('login')->with('error', 'User not found.');
    }
    } else {
    // Handle the case where the user is not authenticated
    // Redirect the user to the login page
    return redirect()->route('login');
    }
    }

    public function UpdateVariety(Request $request,$id){
        try {
                
            $variety = Categorize::find($id);
            $variety->users_id = $request['users_id'];
            if ($request->crop_name === 'Add') {
                $variety->crop_name = $request->new_crop_name; // Use the value entered in the "add_extenstion name" input field
           } else {
                $variety->crop_name = $request->crop_name; // Use the selected color from the dropdown
           }
            $variety->variety_name = $request['variety_name'];
          
            // dd($variety);
            $variety->save();
            
            return redirect('/admin-view-polygon')->with('message', 'Variety update successfully');
        } catch(\Exception $ex) {
            // dd($ex);
            return redirect('/admin-edit-crop-variety')->with('message', 'Something went wrong');
        }
    
    
     }


     public function DeleteVariety($id) {
        try {
            // Find the personal information by ID
            $variety =Categorize::find($id);
    
            // Check if the personal information exists
            if (!$variety) {
                return redirect()->back()->with('error', 'Variety not found');
            }
    
            // Delete the personal information data from the database
            $variety->delete();
    
            // Redirect back with success message
            return redirect()->back()->with('message', 'Variety deleted successfully');
    
        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with error message
            return redirect()->back()->with('error', 'Error deleting Variety: ' . $e->getMessage());
        }
    }
    }
