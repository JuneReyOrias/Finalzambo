<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\AgriDistrict;
use App\Models\Categorize;
use App\Models\CropParcel;
use App\Models\FarmProfile;
use App\Models\LastProductionDatas;
use App\Models\ParcellaryBoundaries;
use App\Models\PersonalInformations;
use App\Models\Polygon;
use App\Models\User;
use App\Models\VariableCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AgriDistrictController extends Controller
{
    

        // add new agri district pin in the map
    public function DisplayAgri(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // User is authenticated, proceed with retrieving the user's ID
            $userId = Auth::id();
    
            // Find the user based on the retrieved ID
            $admin = User::find($userId);
    
            if ($admin) {
                // Assuming you have additional logic to fetch dashboard data
                $totalfarms = FarmProfile::count();
                $totalAreaPlanted = FarmProfile::sum('total_physical_area');
                $totalAreaYield = FarmProfile::sum('yield_kg_ha');
                $totalCost = VariableCost::sum('total_variable_cost');
                $Agriculture= AgriDistrict::all();
                $yieldPerAreaPlanted = ($totalAreaPlanted != 0) ? $totalAreaYield / $totalAreaPlanted : 0;
                $averageCostPerAreaPlanted = ($totalAreaPlanted != 0) ? $totalCost / $totalAreaPlanted : 0;
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                $polygons = Polygon::all();
   // Fetch all agri districts
   $agriDistricts = AgriDistrict::all(); // Get all agri districts

                   // Prepare agri district GPS coordinates
            $districtsData = [];
            foreach ($agriDistricts as $district) {
                $districtsData[] = [
                    'gpsLatitude' => $district->latitude,
                    'gpsLongitude' => $district->longitude,
                    'districtName' => $district->district,
                    'description' => $district->description,
              
                ];
            }
            $polygonsData = [];
            foreach ($polygons as $polygon) {
                // Prepare coordinates array from vertex fields
                $coordinates = [
                    ['lat' => $polygon->verone_latitude, 'lng' => $polygon->verone_longitude],
                    ['lat' => $polygon->vertwo_latitude, 'lng' => $polygon->vertwo_longitude],
                    ['lat' => $polygon->verthree_latitude, 'lng' => $polygon->verthree_longitude],
                    ['lat' => $polygon->vertfour_latitude, 'lng' => $polygon->vertfour_longitude],
                    ['lat' => $polygon->verfive_latitude, 'lng' => $polygon->verfive_longitude],
                    ['lat' => $polygon->versix_latitude, 'lng' => $polygon->versix_longitude],
                    ['lat' => $polygon->verseven_latitude, 'lng' => $polygon->verseven_longitude],
                    ['lat' => $polygon->vereight_latitude, 'lng' => $polygon->verteight_longitude]
                ];
                
                // Push to polygonData
                $polygonsData[] = [
                    'id' => $polygon->id,
                    'name' => $polygon->poly_name,
                    'coordinates' => $coordinates,
                    'strokeColor' => $polygon->strokecolor, // Stroke color of the polygon
                    'area' => $polygon->area, // Area of the polygon (if applicable)
                    'perimeter' => $polygon->perimeter // Perimeter of the polygon (if applicable)
                ];
            }
            
         

            // Fetch all CropParcel records and transform them
            $mapdata = CropParcel::all()->map(function($parcel) {
            
                // Decode the JSON coordinates
                $coordinates = json_decode($parcel->coordinates);
                
                // Check if the coordinates are valid and properly formatted
                if (!is_array($coordinates)) {
                //   echo "Invalid coordinates for parcel ID {$parcel->id}: " . $parcel->coordinates . "\n";
                    return null; // Return null for invalid data
                }

                return [
                    'polygon_name' => $parcel->polygon_name, // Include the ID for reference
                    'coordinates' => $coordinates, // Include the decoded coordinates
                    'area' => $parcel->area, // Assuming there's an area field
                    'altitude' => $parcel->altitude, // Assuming there's an altitude field
                    'strokecolor' => $parcel->strokecolor, // Include the stroke color
                    'fillColor' => $parcel->fillColor // Optionally include the fill color if available
                ];
            })->filter(); // Remove any null values from the collection

            
                $parceldata = ParcellaryBoundaries::all()->map(function($parcel) {
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
                        'parcel_name' => $parcel->parcel_name, // Include the ID for reference
                        'arpowner_na' => $parcel->arpowner_na, 
                        'agri_districts' => $parcel->agri_districts, 
                        'barangay_name' => $parcel->barangay_name, 
                        'tct_no' => $parcel->tct_no, 
                        'lot_no' => $parcel->lot_no, 
                        'pkind_desc' => $parcel->pkind_desc, 
                        'puse_desc' => $parcel->puse_desc, 
                        'actual_used' => $parcel->actual_used, 
                        'coordinates' => $coordinates, // Include the decoded coordinates
                        'area' => $parcel->area, // Assuming there's an area field
                        'altitude' => $parcel->altitude, // Assuming there's an altitude field
                        'strokecolor' => $parcel->strokecolor, // Include the stroke color
                    
                    ];
                })->filter(); // Remove any null values from the collection



            // Check if the request is an AJAX request
            if ($request->ajax()) {
                // Return the response as JSON for AJAX requests
                return response()->json([
                   
                    'totalRiceProduction' => $totalRiceProduction,
                
                    'polygons' => $polygonsData,
                    'districtsData' => $districtsData // Send all district GPS coordinates
                ]);
            
            } else {
                // Return the view with dashboard data
           
                return view('agri_districts.display', [
                    'admin' => $admin,
                    'Agriculture' => $Agriculture,
                    'userId' => $userId,
                    'totalRiceProduction' => $totalRiceProduction,
                    'userId' =>$userId, 
                  
                 
                    'districtsData' => $districtsData,
                    'mapdata' => $mapdata, // Pass to view
                    'parceldata'=> $parceldata 
                ]);
            
            }
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
        
            // $data= $request->validated([]);
            // $data= $request->all();

            
            $addDistrict= new AgriDistrict;
            $addDistrict->users_id = $request->users_id;
            $addDistrict->district =$request->district;
            $addDistrict->description =$request->description;
            $addDistrict->latitude =$request->latitude;
            $addDistrict->longitude =$request->longitude;
            // $addDistrict->altitude =$request->altitude;
            // dd($addDistrict);
            $addDistrict->save();
            return redirect('/admin-view-polygon')->with('message','AgriDistrict added successsfully');
        
        }
        catch(\Exception $ex){
            // dd($ex); // Debugging statement to inspect the exception
            return redirect('/admin-add-district')->with('message','Someting went wrong');
            
        }   
    }


public function  AgriInfoEdit($id)
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
                    $agri_district = $user->agri_district;
                    $agri_districts_id = $user->agri_districts_id;
                    // Find the farm profile using the fetched farm ID
                    $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                    $AgriDistrict= AgriDistrict::find($id);
              
        
                    
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    // Return the view with the fetched data
                    return view('agri_districts.agri_edit', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                    ,'AgriDistrict','userId','agri_district','agri_districts_id'
                    
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
        try{
        
            $addDistrict= AgriDistrict::find($id);
            $addDistrict->users_id = $request->users_id;
            $addDistrict->district =$request->district;
            $addDistrict->description =$request->description;
            $addDistrict->latitude =$request->latitude;
            $addDistrict->longitude =$request->longitude;
            // $addDistrict->altitude =$request->altitude;
            // dd($addDistrict);
            $addDistrict->save();
            return redirect('/admin-view-polygon')->with('message','AgriDistrict updated successsfully');
        
        }
        catch(\Exception $ex){
            // dd($ex); // Debugging statement to inspect the exception
            return redirect('/admin-view-polygon')->with('message','Someting went wrong');
            
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $agridistrict = AgriDistrict::where('id', $id);
        
            if ($agridistrict) {
                $agridistrict->delete();
                return redirect()->route('polygon.polygons_show')
                                 ->with('message', 'AgriDistrict data deleted successfully');
            } else {
                return redirect()->route('polygon.polygons_show')
                                 ->with('message', 'AgriDistrict data not found');
            }
        } catch (\Exception $e) {
            return redirect()->route('polygon.polygons_show')
                             ->with('message', 'Error deleting AgriDistrict data : ' . $e->getMessage());
        }
    }
}
