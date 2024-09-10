<?php

namespace App\Http\Controllers\Backend;
use App\Models\AgriDistrict;
use App\Models\FarmProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\FarmProfileRequest;
use App\Http\Requests\UpdateFarmProfileRequest;
use App\Models\LastProductionDatas;
use App\Models\PersonalInformations;
use App\Models\MachineriesUseds;
use App\Models\FixedCost;
use App\Models\ProductionSold;
use App\Models\Barangay;
use App\Models\FarmerOrg;
use App\Models\Categorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Optional;
use App\Models\KmlFile;
use Illuminate\Support\Facades\Auth;
use App\Models\CropCategory;
use App\Models\Seed;
use App\Models\User;
use App\Models\Crop;
use App\Models\VariableCost;
use Illuminause Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;te\Support\Facades\Storage;

class FarmProfileController extends Controller
{
   

        // adding new farm profile data
                    public function FarmProfile(Request $request,$id)
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

                        // Fetch user's information
                        $user_id = $user->id;
                        $agri_district = $user->agri_district;
                        $agri_districts_id = $user->agri_districts_id;
                        $cropVarieties = CropCategory::all();
                        // Find the user by their ID and eager load the personalInformation relationship
                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        $personalinfos = PersonalInformations::find($id);


    // Handle AJAX requests
    if ($request->ajax()) {
        $type = $request->input('type');

        // Handle requests for barangays and organizations
        if ($type === 'barangays' || $type === 'organizations') {
            $district = $request->input('district');

            if ($type === 'barangays') {
                $barangays = Barangay::where('district', $district)->get(['id', 'barangay_name']);
                return response()->json($barangays);

            } elseif ($type === 'organizations') {
                $organizations = FarmerOrg::where('district', $district)->get(['id', 'organization_name']);
                return response()->json($organizations);
            }

            return response()->json(['error' => 'Invalid type parameter.'], 400);
        }

        // Handle requests for crop names and crop varieties
        if ($type === 'crops') {
            $crops = CropCategory::pluck( 'crop_name','crop_name',);
            return response()->json($crops);
        }
       
        if ($type === 'varieties') {
            $cropId = $request->input('crop_name');
            $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
            return response()->json($varieties);
        }
        if ($type === 'seedname') {
            // Retrieve the 'variety_name' from the request
            $varietyId = $request->input('variety_name');
        
            // Fetch the seeds based on the variety name and return the result as a JSON response
            $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
        
            // Return the seeds as a JSON response for the frontend
            return response()->json($seeds);
        }
        return response()->json(['error' => 'Invalid type parameter.'], 400);
    }
    


                        // Return the view with the fetched data
                        return view('farm_profile.farm_index', compact('agri_district', 'agri_districts_id', 'admin', 'profile',
                        'totalRiceProduction','userId','cropVarieties','personalinfos','userId'));
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

            public function Arcmap(Request $request)
            {
                if (Auth::check()) {
                    $userId = Auth::id();
                    $admin = User::find($userId);
            
                    if ($admin) {
                        $user = auth()->user();
                        if (!$user) {
                            return redirect()->route('login');
                        }
            
                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                        $farmId = $user->farm_id;
                        $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
            
                        $searchQuery = $request->input('query');
                        $searchType = $request->input('search_type');
            
                        if ($searchQuery === mb_strtoupper($searchQuery, 'UTF-8')) {
                            return redirect()->back()->withErrors(['search_error' => 'Search query cannot be in all capital letters.']);
                        }
            
                        $farmLocationQuery = DB::table('farm_profiles')
                            ->join('agri_districts', 'farm_profiles.agri_districts_id', '=', 'agri_districts.id')
                            ->leftJoin('polygons', 'farm_profiles.polygons_id', '=', 'polygons.id')
                            ->leftJoin('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->select('farm_profiles.*', 'agri_districts.*', 'polygons.*', 'personal_informations.*');
            
                        switch ($searchType) {
                            case 'longitude':
                                $farmLocationQuery->where('farm_profiles.longitude', '=', $searchQuery);
                                break;
                            case 'latitude':
                                $farmLocationQuery->where('farm_profiles.latitude', '=', $searchQuery);
                                break;
                            default:
                                $farmLocationQuery->where(function ($query) use ($searchQuery) {
                                    $query->where('personal_informations.last_name', 'like', '%' . $searchQuery . '%')
                                          ->orWhere('personal_informations.middle_name', 'like', '%' . $searchQuery . '%')
                                          ->orWhere('personal_informations.first_name', 'like', '%' . $searchQuery . '%')
                                          ->orWhere('farm_profiles.tenurial_status', 'like', '%' . $searchQuery . '%');
                                });
                                break;
                        }
            
                        $farmLocation = $farmLocationQuery->get();
            
                        if ($farmLocation->isEmpty()) {
                            return redirect()->back()->withErrors(['search_error' => 'No farm locations found for the provided query.']);
                        }
            
                        $agriDistrictIds = [];
                        $polygonsIds = [];
            
                        foreach ($farmLocation as $location) {
                            $agriDistrictIds[] = $location->id;
                            $polygonsIds[] = $location->id;
                        }
            
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        // Retrieve all KML file URLs from the database
                        $kmlUrl = KmlFile::all()->pluck('file_path')->toArray();
                        return view('map.arcmap', compact('profile', 'farmProfile', 'farmLocation', 'totalRiceProduction',
                            'agriDistrictIds', 'polygonsIds', 'admin', 'kmlUrl', 'searchQuery', 'searchType'));
                    } else {
                        return redirect()->route('login')->with('error', 'User not found.');
                    }
                } else {
                    return redirect()->route('login');
                }
            }
            
            

// agent map view
public function Gmap(Request $request)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // User is authenticated, proceed with retrieving the user's ID
        $userId = Auth::id();

        // Find the user based on the retrieved ID
        $agent = User::find($userId);

        if ($agent) {
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

           // Retrieve the search query from the request
           $searchQuery = $request->input('query');
           $searchType = $request->input('search_type'); // Assuming 'search_type' is provided in the request
           
           // Check if the search query is in all capital letters
           if ($searchQuery === mb_strtoupper($searchQuery, 'UTF-8')) {
               // If the search query is in all capital letters, redirect back with an error message
               return redirect()->back()->withErrors(['search_error' => 'Search query cannot be in all capital letters.']);
           }
           
           // Query to fetch farm locations based on last name, middle name, first name, longitude, or latitude
           $farmLocationQuery = DB::table('farm_profiles')
               ->join('agri_districts', 'farm_profiles.agri_districts_id', '=', 'agri_districts.id')
               ->leftJoin('polygons', 'farm_profiles.polygons_id', '=', 'polygons.id')
               ->leftJoin('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
               ->select('farm_profiles.*', 'agri_districts.*', 'polygons.*', 'personal_informations.*');
           
           // Check the search type and add appropriate conditions
           switch ($searchType) {
               case 'longitude':
                   $farmLocationQuery->where('farm_profiles.longitude', '=', $searchQuery);
                   break;
               case 'latitude':
                   $farmLocationQuery->where('farm_profiles.latitude', '=', $searchQuery);
                   break;
               default:
                   // For other search types, search in names
                   $farmLocationQuery->where(function ($query) use ($searchQuery) {
                       $query->where('personal_informations.last_name', 'like', '%' . $searchQuery . '%')
                             ->orWhere('personal_informations.middle_name', 'like', '%' . $searchQuery . '%')
                             ->orWhere('personal_informations.first_name', 'like', '%' . $searchQuery . '%')
                             ->orWhere('farm_profiles.tenurial_status', 'like', '%' . $searchQuery . '%');
                   });
                   break;
           }
           
           // Execute the query to fetch farm locations
           $farmLocation = $farmLocationQuery->get();
           
           // If no farm locations are found, redirect back with an error message
           if ($farmLocation->isEmpty()) {
               return redirect()->back()->withErrors(['search_error' => 'No farm locations found for the provided query.']);
           }
           
           // Initialize empty arrays
           $agriDistrictIds = [];
           $polygonsIds = [];
           
           // Loop through each row of the result
           foreach ($farmLocation as $location) {
               // Extract agri_district_id and polygons_id from each row
               $agriDistrictIds[] = $location->id;
               $polygonsIds[] = $location->id;
           }

            
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('map.gmap', compact('agent', 'profile', 'farmProfile','farmLocation','totalRiceProduction',
            'agriDistrictIds', 'agriDistrictIds',
            'polygonsIds',
            'searchQuery' , // Pass the search query to the view
            'searchType', // Pass the search type to the view
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
        // user view the map
    public function agrimap(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // User is authenticated, proceed with retrieving the user's ID
            $userId = Auth::id();
    
            // Find the user based on the retrieved ID
            $agent = User::find($userId);
    
            if ($agent) {
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
    
               // Retrieve the search query from the request
               $searchQuery = $request->input('query');
               $searchType = $request->input('search_type'); // Assuming 'search_type' is provided in the request
               
               // Check if the search query is in all capital letters
               if ($searchQuery === mb_strtoupper($searchQuery, 'UTF-8')) {
                   // If the search query is in all capital letters, redirect back with an error message
                   return redirect()->back()->withErrors(['search_error' => 'Search query cannot be in all capital letters.']);
               }
               
               // Query to fetch farm locations based on last name, middle name, first name, longitude, or latitude
               $farmLocationQuery = DB::table('farm_profiles')
                   ->join('agri_districts', 'farm_profiles.agri_districts_id', '=', 'agri_districts.id')
                   ->leftJoin('polygons', 'farm_profiles.polygons_id', '=', 'polygons.id')
                   ->leftJoin('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                   ->select('farm_profiles.*', 'agri_districts.*', 'polygons.*', 'personal_informations.*');
               
               // Check the search type and add appropriate conditions
               switch ($searchType) {
                   case 'longitude':
                       $farmLocationQuery->where('farm_profiles.longitude', '=', $searchQuery);
                       break;
                   case 'latitude':
                       $farmLocationQuery->where('farm_profiles.latitude', '=', $searchQuery);
                       break;
                   default:
                       // For other search types, search in names
                       $farmLocationQuery->where(function ($query) use ($searchQuery) {
                           $query->where('personal_informations.last_name', 'like', '%' . $searchQuery . '%')
                                 ->orWhere('personal_informations.middle_name', 'like', '%' . $searchQuery . '%')
                                 ->orWhere('personal_informations.first_name', 'like', '%' . $searchQuery . '%')
                                 ->orWhere('farm_profiles.tenurial_status', 'like', '%' . $searchQuery . '%');
                       });
                       break;
               }
               
               // Execute the query to fetch farm locations
               $farmLocation = $farmLocationQuery->get();
               
               // If no farm locations are found, redirect back with an error message
               if ($farmLocation->isEmpty()) {
                   return redirect()->back()->withErrors(['search_error' => 'No farm locations found for the provided query.']);
               }
               
               // Initialize empty arrays
               $agriDistrictIds = [];
               $polygonsIds = [];
               
               // Loop through each row of the result
               foreach ($farmLocation as $location) {
                   // Extract agri_district_id and polygons_id from each row
                   $agriDistrictIds[] = $location->id;
                   $polygonsIds[] = $location->id;
               }
    
                
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('map.agrimap', compact('agent', 'profile', 'farmProfile','farmLocation','totalRiceProduction',
                'agriDistrictIds', 'agriDistrictIds',
                'polygonsIds',
                'searchQuery' , // Pass the search query to the view
                'searchType', // Pass the search type to the view
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
    
   
  
   

    // insertion of new data into farm profile table by admin

// public function store(Request $request)
// {
//     try {
//         // Get authenticated user
//         $user = auth()->user();

//         // Validate the incoming request data
//         // $data = $request->validated();

//         // Check if FarmProfile with the given personal_informations_id already exists
//         $existingFarmProfile = FarmProfile::where('personal_informations_id', $request->input('personal_informations_id'))->first();

//         if ($existingFarmProfile) {
//             return redirect('/admin-farmprofile')->with('error', 'Farm Profile with this information already exists.');
//         }

//         // Create a new FarmProfile instance
//         $farmProfile = new FarmProfile;
//         $farmProfile->users_id = $request->users_id;
//         $farmProfile->personal_informations_id = $request->personal_informations_id;
//         $farmProfile->agri_districts_id = $request->agri_districts_id;
//         $farmProfile->agri_districts = $request->agri_districts;
//         $farmProfile->tenurial_status = $request->tenurial_status === 'Add' ? $request->add_newTenure : $request->tenurial_status;
//         $farmProfile->rice_farm_address = $request->rice_farm_address;
//         $farmProfile->no_of_years_as_farmers = $request->no_of_years_as_farmers === 'Add' ? $request->add_newFarmyears : $request->no_of_years_as_farmers;
//         $farmProfile->gps_longitude = $request->gps_longitude;
//         $farmProfile->gps_latitude = $request->gps_latitude;
//         $farmProfile->total_physical_area_has = $request->total_physical_area_has;
//         $farmProfile->rice_area_cultivated_has = $request->rice_area_cultivated_has;
//         $farmProfile->land_title_no = $request->land_title_no;
//         $farmProfile->lot_no = $request->lot_no;
//         $farmProfile->area_prone_to = $request->area_prone_to === 'Add Prone' ? $request->add_newProneYear : $request->area_prone_to;
//         $farmProfile->ecosystem = $request->ecosystem === 'Add ecosystem' ? $request->Add_Ecosystem : $request->ecosystem;
//         $farmProfile->type_rice_variety = $request->type_rice_variety;
//         $farmProfile->prefered_variety = $request->prefered_variety;
//         $farmProfile->plant_schedule_wetseason = $request->plant_schedule_wetseason;
//         $farmProfile->plant_schedule_dryseason = $request->plant_schedule_dryseason;
//         $farmProfile->no_of_cropping_yr = $request->no_of_cropping_yr === 'Adds' ? $request->add_cropyear : $request->no_of_cropping_yr;
//         $farmProfile->yield_kg_ha = $request->yield_kg_ha;
//         $farmProfile->rsba_register = $request->rsba_register;
//         $farmProfile->pcic_insured = $request->pcic_insured;
//         $farmProfile->government_assisted = $request->government_assisted;
//         $farmProfile->source_of_capital = $request->source_of_capital === 'Others' ? $request->add_sourceCapital : $request->source_of_capital;
//         $farmProfile->remarks_recommendation = $request->remarks_recommendation;
//         $farmProfile->oca_district_office = $request->oca_district_office;
//         $farmProfile->name_technicians = $request->name_technicians;
//         $farmProfile->date_interview = $request->date_interview;
//         dd($farmProfile);
//         // Save the new FarmProfile
//         $farmProfile->save();

//         // Redirect with success message
//         return redirect('/admin-fixedcost')->with('message', 'Farm Profile added successfully');
//     } catch (\Exception $ex) {
//         // Log the exception or handle it appropriately
//         // dd($ex);
//         return redirect('/admin-farmprofile')->with('message', 'Something went wrong');
//     }
// }  
   
    // farmers view of all the data from farm profile by admin 
    
  
  
    // public function store(Request $request)
    // {
      
    //     // Farm info
    //     $farms = $request->farm;
    //     $farmModel = new FarmProfile();
    
    //     $farmModel->tenurial_status = $farms['tenurial_status'];
    //     $farmModel->farm_address = $farms['farm_address'];
    //     // $farmModel->no_of_years_as_farmers = $farms['no_of_years_as_farmers'];
    //     $farmModel->gps_longitude = $farms['gps_longitude'];
    //     $farmModel->gps_latitude = $farms['gps_latitude'];
    //     $farmModel->total_physical_area = $farms['Total_area_cultivated_has'];
    //     $farmModel->total_area_cultivated = $farms['Total_area_cultivated_has'];
    //     $farmModel->land_title_no = $farms['land_title_no'];
    //     $farmModel->lot_no = $farms['lot_no'];
    //     $farmModel->area_prone_to = $farms['area_prone_to'];
    //     $farmModel->ecosystem = $farms['ecosystem'];
    //     $farmModel->rsba_registered = $farms['rsba_register'];
    //     $farmModel->pcic_insured = $farms['pcic_insured'];
    //     $farmModel->government_assisted = $farms['government_assisted'];
    //     $farmModel->source_of_capital = $farms['source_of_capital'];
    //     $farmModel->remarks_recommendation = $farms['remarks'];
    //     $farmModel->oca_district_office = $farms;
    //     $farmModel->name_of_field_officer_technician = $farms['name_technicians'];
    //     $farmModel->date_interviewed = $farms['date_interview'];
    
    //     $farmModel->save();
    
    //     // VARIABLES
    //     $farm_id = $farmModel->id;
    //     $users_id =   $farmModel->users_id;
    //     // VARIABLES
    
    //     // Crop info
    //     foreach ($request->crops as $crop) {
    //         $cropModel = new Crop();
    //         $cropModel->farm_profiles_id = $farm_id;
    //         $cropModel->crop_name = $crop['crop_name'];
    //         $cropModel->users_id = $users_id;
    //         $cropModel->planting_schedule_dryseason = $crop['variety']['dry_season'];
    //         $cropModel->no_of_cropping_per_year = $crop['variety']['no_cropping_year'];
    //         $cropModel->preferred_variety = $crop['variety']['preferred'];
    //         $cropModel->type_of_variety_planted = $crop['variety']['type_variety'];
    //         $cropModel->planting_schedule_wetseason = $crop['variety']['wet_season'];
    //         $cropModel->yield_kg_ha = $crop['variety']['yield_kg_ha'];
    //         $cropModel->save();
    
    //         $crop_id = $cropModel->id;
    
    //         $productionModel = new LastProductionDatas();
    //         $productionModel->users_id = $users_id;
    //         $productionModel->farm_profiles_id = $farm_id;
    //         $productionModel->crops_farms_id = $crop_id;
    //         $productionModel->seed_source = $crop['production']['seedSource'];
    //         $productionModel->seeds_used_in_kg = $crop['production']['seedUsed'];
    //         $productionModel->seeds_typed_used = $crop['production']['seedtype'];
    //         $productionModel->no_of_fertilizer_used_in_bags = $crop['production']['fertilizedUsed'];
    //         $productionModel->no_of_insecticides_used_in_l = $crop['production']['insecticide'];
    //         $productionModel->no_of_pesticides_used_in_l_per_kg = $crop['production']['pesticidesUsed'];
    //         $productionModel->area_planted = $crop['production']['areaPlanted'];
    //         $productionModel->date_planted = $crop['production']['datePlanted'];
    //         $productionModel->date_harvested = $crop['production']['Dateharvested'];
    //         $productionModel->unit = $crop['production']['unit'];
    //         $productionModel->yield_tons_per_kg = $crop['production']['yieldkg'];
    //         $productionModel->save();
    
    //         // productionid
    //         $productionId = $productionModel->id;
    
    //         foreach ($crop['sales'] as $sale) {
    //             // Create a new sale associated with the production ID
    //             $salesModel = new ProductionSold();
    //             $salesModel->last_production_datas_id = $productionId;
    //             $salesModel->sold_to = $sale['soldTo'];
    //             $salesModel->measurement = $sale['measurement'];
    //             $salesModel->unit_price_rice_per_kg = $sale['unit_price'];
    //             $salesModel->quantity = $sale['quantity'];
    //             $salesModel->gross_income = $sale['grossIncome'];
    //             $salesModel->save();
    //         }
    
    //         // FIXED COST
    //         $fixedcostModel = new FixedCost();
    //         $fixedcostModel->crops_farms_id = $crop_id;
    //         $fixedcostModel->users_id = $users_id;
    //         $fixedcostModel->labor = $crop['fixed_cost']['labor'];
    //         $fixedcostModel->fertilizer = $crop['fixed_cost']['fertilizer'];
    //         $fixedcostModel->pesticides = $crop['fixed_cost']['pesticides'];
    //         $fixedcostModel->irrigation = $crop['fixed_cost']['irrigation'];
    //         $fixedcostModel->other = $crop['fixed_cost']['other'];
    //         $fixedcostModel->save();
    //         // FIXED COST
    
    //         // VARIABLE COST
    //         $variablecostModel = new VariableCost();
    //         $variablecostModel->crops_farms_id = $crop_id;
    //         $variablecostModel->users_id = $users_id;
    //         $variablecostModel->labor = $crop['variable_cost']['labor'];
    //         $variablecostModel->fertilizer = $crop['variable_cost']['fertilizer'];
    //         $variablecostModel->pesticides = $crop['variable_cost']['pesticides'];
    //         $variablecostModel->irrigation = $crop['variable_cost']['irrigation'];
    //         $variablecostModel->other = $crop['variable_cost']['other'];
    //         $variablecostModel->save();
    //         // VARIABLE COST
    
         

    //         // LOAN INFO
    //     }
    
    //     return response()->json([
    //         'success' => 'Data saved successfully!'
    //     ]);
    // }
    public function saveFarms(Request $request)
    {
    
    
    
          // Farmer info
        //   $farmerdata = $request -> farmer;
    
        //   $existingFarmer = PersonalInformations::where('last_name', $farmerdata['last_name'])
        //   ->where('first_name', $farmerdata['first_name'])
        //   ->where('mothers_maiden_name', $farmerdata['mothers_maiden_name'])
        //   ->where('date_of_birth', $farmerdata['date_of_birth'])
        //   ->first();
    
        //   if ($existingFarmer) {
        //       return response()->json([
        //           'error' => 'A record with this last name, first name, mother\'s maiden name, and date of birth already exists.'
        //       ], 400); // Send a 400 Bad Request status code
        //   }
        //   $farmerModel = new PersonalInformations();
        //   $farmerModel -> users_id = $farmerdata['users_id'];
        //   $farmerModel -> first_name = $farmerdata['first_name'];
        //   $farmerModel -> middle_name= $farmerdata['middle_name'];
        //   $farmerModel -> last_name= $farmerdata['last_name'];
        //   $farmerModel -> extension_name = $farmerdata['extension_name'];
        //   $farmerModel -> country= $farmerdata['country'];
        //   $farmerModel -> province= $farmerdata['province'];
        //   $farmerModel -> city = $farmerdata['city'];
        //   $farmerModel -> district= $farmerdata['agri_district'];
        //   $farmerModel -> barangay= $farmerdata['barangay'];
        //   $farmerModel -> street= $farmerdata['street'];
        //   $farmerModel -> zip_code= $farmerdata['zip_code'];
        //   $farmerModel -> sex= $farmerdata['sex'];
        //   $farmerModel -> religion = $farmerdata['religion'];
        //   $farmerModel -> date_of_birth= $farmerdata['date_of_birth'];
        //   $farmerModel -> place_of_birth= $farmerdata['place_of_birth'];
        //   $farmerModel -> contact_no = $farmerdata['contact_no'];
        //   $farmerModel -> civil_status= $farmerdata['civil_status'];
        //   $farmerModel -> name_legal_spouse= $farmerdata['name_legal_spouse'];
        //   $farmerModel -> no_of_children = $farmerdata['no_of_children'];
        //   $farmerModel -> mothers_maiden_name= $farmerdata['mothers_maiden_name'];
        //   $farmerModel -> highest_formal_education= $farmerdata['highest_formal_education'];
        //   $farmerModel -> person_with_disability = $farmerdata['person_with_disability'];
        //   $farmerModel -> pwd_id_no= $farmerdata['YEspwd_id_no'];
        //   $farmerModel -> government_issued_id= $farmerdata['government_issued_id'];
        //   $farmerModel -> id_type = $farmerdata['id_type'];
        //   $farmerModel -> gov_id_no= $farmerdata['add_Idtype'];
        //   $farmerModel -> member_ofany_farmers_ass_org_coop= $farmerdata['member_ofany_farmers'];
        //   $farmerModel -> nameof_farmers_ass_org_coop = $farmerdata['nameof_farmers'];
        //   $farmerModel -> name_contact_person= $farmerdata['name_contact_person'];
        //   $farmerModel -> cp_tel_no= $farmerdata['cp_tel_no'];
        //   $farmerModel -> date_interview= $farmerdata['date_of_interviewed'];
        //   $farmerModel ->save();
    
    
        // VARIABLES
        // VARIABLES
        // $farmer_id = $farmerModel -> id;
        // VARIABLES
        // VARIABLES
        // $farmerModel -> users_id=1;
           // Farm info
          $farms = $request -> farm;
        //   return $farms;
          $farmModel = new FarmProfile();
    
        //   $farmModel -> users_id =1;
    
        //   // FROM USER
        //   $farmModel -> agri_districts_id = 1;
    
    
        //   $farmModel -> personal_informations_id = 4096;
    
        //   $farmModel -> polygons_id = $farms['polygons_id'];
        //   $farmModel -> agri_districts = $farms['agri_districts'];
        $farmModel -> personal_informations_id = $farms['personal_info'];
        $farmModel -> users_id = $farms['user_id'];
          $farmModel -> tenurial_status = $farms['tenurial_status'];
          $farmModel -> farm_address = $farms['farm_address'];
    
          $farmModel -> no_of_years_as_farmers = $farms['no_of_years_as_farmers'];
          $farmModel -> gps_longitude = $farms['gps_longitude'];
          $farmModel -> gps_latitude = $farms['gps_latitude'];
          $farmModel -> total_physical_area = $farms['Total_area_cultivated_has'];
          $farmModel -> total_area_cultivated = $farms['Total_area_cultivated_has'];
          $farmModel -> land_title_no = $farms['land_title_no'];
          $farmModel -> lot_no = $farms['lot_no'];
          $farmModel -> area_prone_to = $farms['area_prone_to'];
          $farmModel -> ecosystem = $farms['ecosystem'];
          $farmModel -> rsba_registered = $farms['rsba_register'];
          $farmModel -> pcic_insured = $farms['pcic_insured'];
          $farmModel -> government_assisted = $farms['government_assisted'];
          $farmModel -> source_of_capital = $farms['source_of_capital'];
          $farmModel -> remarks_recommendation = $farms['remarks'];
        //   $farmModel -> oca_district_office =$farmerModel -> district;
          $farmModel -> name_of_field_officer_technician = $farms['name_technicians'];
          $farmModel -> date_interviewed = $farms['date_interview'];
         
          $farmModel ->save();
        
        // VARIABLES
        // VARIABLES
        $farm_id = $farmModel -> id;

        // return $farmModel;
        $users_id =  $farmModel -> users_id;
        // VARIABLES
        // VARIABLES
    
    
          // Crop info 
          foreach ($request -> crops as $crop) {
              $cropModel = new Crop();
              $cropModel -> farm_profiles_id = $farm_id;
              $cropModel -> crop_name = $crop['crop_name'];
              $cropModel -> users_id = $users_id;
              $cropModel -> planting_schedule_dryseason = $crop['variety']['dry_season'];
              $cropModel -> no_of_cropping_per_year = $crop['variety']['no_cropping_year'];
              $cropModel -> preferred_variety = $crop['variety']['preferred'];
              $cropModel -> type_of_variety_planted = $crop['variety']['type_variety'];
              $cropModel -> planting_schedule_wetseason	 = $crop['variety']['wet_season'];
              $cropModel -> yield_kg_ha = $crop['variety']['yield_kg_ha'];
              $cropModel -> save();
    
              $crop_id = $cropModel -> id;
    
              $productionModel = new LastProductionDatas();
              $productionModel -> users_id = $users_id;
              $productionModel -> farm_profiles_id = $farm_id;
              $productionModel -> crops_farms_id = $crop_id;
              $productionModel -> seed_source = $crop['production']['seedSource'];
              $productionModel -> seeds_used_in_kg = $crop['production']['seedUsed'];
              $productionModel -> seeds_typed_used = $crop['production']['seedtype'];
              $productionModel -> no_of_fertilizer_used_in_bags = $crop['production']['fertilizedUsed'];
              $productionModel -> no_of_insecticides_used_in_l = $crop['production']['insecticide'];
              $productionModel -> no_of_pesticides_used_in_l_per_kg = $crop['production']['pesticidesUsed'];
              $productionModel -> area_planted = $crop['production']['areaPlanted'];
              $productionModel -> date_planted = $crop['production']['datePlanted'];
              $productionModel -> date_planted = $crop['production']['Dateharvested'];
              $productionModel -> unit = $crop['production']['unit'];
              $productionModel -> yield_tons_per_kg = $crop['production']['yieldkg'];
          
             
              $productionModel -> save();
    
            // productionid
            $productionId=$productionModel ->id;
    
            foreach ($crop['sales'] as $sale) {
                // Create a new sale associated with the production ID
                $salesModel = new ProductionSold();
                $salesModel -> last_production_datas_id = $productionId;
                $salesModel -> sold_to = $sale['soldTo'];
                $salesModel -> measurement = $sale['measurement'];
                $salesModel -> 	unit_price_rice_per_kg = $sale['unit_price'];
                $salesModel -> 	quantity = $sale['quantity'];
                $salesModel -> 	gross_income = $sale['grossIncome'];
                $salesModel ->save();
            }
    
    
            // FIXED COST
            $fixedcostModel = new FixedCost();
            $fixedcostModel -> users_id = $users_id;
            $fixedcostModel -> farm_profiles_id = $farm_id;
            $fixedcostModel -> crops_farms_id = $crop_id;
            $fixedcostModel -> last_production_datas_id = $productionId;
            $fixedcostModel -> 	particular = $crop['fixedCost']['particular'];
            $fixedcostModel -> no_of_ha = $crop['fixedCost']['no_of_has'];
            $fixedcostModel -> cost_per_ha = $crop['fixedCost']['costperHas'];
            $fixedcostModel -> total_amount = $crop['fixedCost']['TotalFixed'];
            $fixedcostModel -> save();
    
            // machineries
              $machineriesModel = new MachineriesUseds();
              $machineriesModel -> users_id = $users_id;
              $machineriesModel -> farm_profiles_id = $farm_id;
              $machineriesModel -> crops_farms_id = $crop_id;
              $machineriesModel -> last_production_datas_id = $productionId;
              $machineriesModel-> plowing_machineries_used = $crop['machineries']['PlowingMachine'];
              $machineriesModel -> plo_ownership_status = $crop['machineries']['plow_status'];
            
              $machineriesModel -> no_of_plowing = $crop['machineries']['no_of_plowing'];
              $machineriesModel -> plowing_cost = $crop['machineries']['cost_per_plowing'];
              $machineriesModel -> plowing_cost_total = $crop['machineries']['plowing_cost'];
              $machineriesModel -> harrowing_machineries_used = $crop['machineries']['harro_machine'];
              $machineriesModel -> harro_ownership_status = $crop['machineries']['harro_ownership_status'];
              $machineriesModel -> no_of_harrowing = $crop['machineries']['no_of_harrowing'];
              $machineriesModel -> harrowing_cost = $crop['machineries']['cost_per_harrowing'];
              $machineriesModel -> harrowing_cost_total = $crop['machineries']['harrowing_cost_total'];
              $machineriesModel -> harvesting_machineries_used = $crop['machineries']['harvest_machine'];
              $machineriesModel -> harvest_ownership_status	 = $crop['machineries']['harvest_ownership_status'];
           
            //   $machineriesModel -> harvesting_cost = $crop['machineries']['harvesting_cost'];
              $machineriesModel -> harvesting_cost_total = $crop['machineries']['Harvesting_cost_total'];
              $machineriesModel -> postharvest_machineries_used = $crop['machineries']['postharves_machine'];
              $machineriesModel -> postharv_ownership_status = $crop['machineries']['postharv_ownership_status'];
              $machineriesModel -> post_harvest_cost = $crop['machineries']['postharvestCost'];
              $machineriesModel -> 	total_cost_for_machineries = $crop['machineries']['total_cost_for_machineries'];
              $machineriesModel -> save();
    
            //   variable cost
              $variablesModel = new VariableCost();
              $variablesModel -> users_id = $users_id;
              $variablesModel -> farm_profiles_id = $farm_id;
              $variablesModel -> crops_farms_id = $crop_id;
              $variablesModel -> last_production_datas_id = $productionId;
            //   seeds
          
              $variablesModel -> seed_name = $crop['variables']['seed_name'];
              $variablesModel -> unit = $crop['variables']['unit'];
              $variablesModel -> quantity = $crop['variables']['quantity'];
              $variablesModel -> unit_price = $crop['variables']['unit_price_seed'];
              $variablesModel -> total_seed_cost = $crop['variables']['total_seed_cost'];
    
               //   seeds
               $variablesModel -> labor_no_of_person = $crop['variables']['no_of_person'];
               $variablesModel -> rate_per_person = $crop['variables']['rate_per_person'];
               $variablesModel -> total_labor_cost = $crop['variables']['total_labor_cost'];
    
                // fertilizer
               $variablesModel -> name_of_fertilizer = $crop['variables']['name_of_fertilizer'];
               $variablesModel -> type_of_fertilizer = $crop['variables']['total_seed_cost'];
               $variablesModel -> no_of_sacks = $crop['variables']['no_ofsacks'];
               $variablesModel -> unit_price_per_sacks = $crop['variables']['unitprice_per_sacks'];
               $variablesModel -> total_cost_fertilizers = $crop['variables']['total_cost_fertilizers'];
    
                 //pesticides
                 $variablesModel -> pesticide_name = $crop['variables']['pesticides_name'];
                //  $variablesModel ->	type_of_pesticides = $crop['variables']['no_of_l_kg'];2
                 $variablesModel -> no_of_l_kg = $crop['variables']['no_of_l_kg'];
                 $variablesModel -> unit_price_of_pesticides = $crop['variables']['unitprice_ofpesticides'];
                 $variablesModel -> total_cost_pesticides = $crop['variables']['total_cost_pesticides'];
             
                  //transportation
                  $variablesModel -> name_of_vehicle = $crop['variables']['type_of_vehicle'];
                 
                  $variablesModel -> total_transport_delivery_cost = $crop['variables']['total_seed_cost'];
               
                  $variablesModel -> total_machinery_fuel_cost= $crop['variables']['total_machinery_fuel_cost'];
                  $variablesModel -> total_variable_cost= $crop['variables']['total_variable_costs'];
                  $variablesModel -> save();
         
                //   return $request;
                }
    
       
    
    
    
    
    
    
          // Return success message
          return [
              'success' => "Saved to database" // Corrected the syntax here
          ];
      }
    public function ViewFarmProfile(Request $request)
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
    
                // Fetch all farm profiles with their associated personal information and agricultural districts
                $farmProfiles = FarmProfile::select('farm_profiles.*')
                    ->leftJoin('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->with('agriDistrict')
                    ->orderBy('farm_profiles.id', 'desc');
    
                // Check if a search query is provided
                if ($request->has('search')) {
                    $keyword = $request->input('search');
                    // Apply search filters for last name and first name
                    $farmProfiles->where(function ($query) use ($keyword) {
                        $query->where('personal_informations.last_name', 'like', "%$keyword%")
                              ->orWhere('personal_informations.first_name', 'like', "%$keyword%");
                    });
                }
    
                // Paginate the results
                $farmProfiles = $farmProfiles->paginate(20);
    
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
    
                // Return the view with the fetched data
                return view('farm_profile.farminfo_view', compact('admin', 'profile', 'farmProfiles', 'totalRiceProduction'));
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
    
    
    // agent farm profile update data view
    public function EditFarmProfile($id)
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
                $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                $farmprofiles=FarmProfile::find($id);
          
    
                
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('farm_profile.farm_edit', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                ,'farmprofiles','agri_districts','agri_districts_id','userId'
                
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
    
    // agent farm profile update data
        public function UpdateFarmProfiles(Request $request,$id)
        {
        
            try{
                
    
                // $data= $request->validated();
                // $data= $request->all();
                
                $data= FarmProfile::find($id);

               
                $data->users_id = $request->users_id;
                $data->personal_informations_id = $request->personal_informations_id;
             
              
                $data->agri_districts = $request->agri_districts;
                $data->tenurial_status = $request->tenurial_status === 'Add' ? $request->add_newTenure : $request->tenurial_status;
                $data->farm_address = $request->farm_address;
                $data->no_of_years_as_farmers = $request->no_of_years_as_farmers === 'Add' ? $request->add_newFarmyears : $request->no_of_years_as_farmers;
                $data->gps_longitude = $request->gps_longitude;
                $data->gps_latitude = $request->gps_latitude;
                $data->total_physical_area = $request->total_physical_area;
                $data->total_area_cultivated = $request->total_area_cultivated;
                $data->land_title_no = $request->land_title_no;
                $data->lot_no = $request->lot_no;
                $data->area_prone_to = $request->area_prone_to === 'Add Prone' ? $request->add_newProneYear : $request->area_prone_to;
                $data->ecosystem = $request->ecosystem === 'Add ecosystem' ? $request->Add_Ecosystem : $request->ecosystem;
                // $data->type_rice_variety = $request->type_rice_variety;
                // $data->prefered_variety = $request->prefered_variety;
                // $data->plant_schedule_wetseason = $request->plant_schedule_wetseason;
                // $data->plant_schedule_dryseason = $request->plant_schedule_dryseason;
                // $data->no_of_cropping_yr = $request->no_of_cropping_yr === 'Adds' ? $request->add_cropyear : $request->no_of_cropping_yr;
                // $data->yield_kg_ha = $request->yield_kg_ha;
                $data->rsba_registered = $request->rsba_registered;
                $data->pcic_insured = $request->pcic_insured;
                $data->government_assisted = $request->government_assisted;
                $data->source_of_capital = $request->source_of_capital === 'Others' ? $request->add_sourceCapital : $request->source_of_capital;
                $data->remarks_recommendation = $request->remarks_recommendation;
                $data->oca_district_office = $request->oca_district_office;
                $data->name_of_field_officer_technician = $request->name_of_field_officer_technician;
                $data->date_interviewed = $request->date_interviewed;

                // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('farmimage'), $imageName);
                $data->image = $imageName;
            }

                // dd($data);
                $data->save();     
                
            // Redirect back with success message
            return redirect()->back()->with('message', 'Farm Profile Data updated successfully');
    
    }catch(\Exception $ex){
   
                // dd($ex); // Debugging statement to inspect the exception
                return redirect('/update-farmprofile/{farmprofiles}')->with('message','Someting went wrong');
                
            }   
        } 
    
 // fFarm profile delete
public function farmdelete($id) {
    try {
        // Find the personal information by ID
        $farmprofiles = FarmProfile::find($id);

        // Check if the personal information exists
        if (!$farmprofiles) {
            return redirect()->back()->with('error', 'Farm Profilenot found');
        }

        // Delete the personal information data from the database
        $farmprofiles->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Farm Profile deleted successfully');

    } catch (\Exception $e) {
        // Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
    }
}

// crops farms store of data
  // adding new farm profile data
  public function cropsnewfarm(Request $request,$id)
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

              // Fetch user's information
              $user_id = $user->id;
              $agri_district = $user->agri_district;
              $agri_districts_id = $user->agri_districts_id;
              $cropVarieties = CropCategory::all();
              // Find the user by their ID and eager load the personalInformation relationship
              $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
              $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Fetch farm profile data
            $farmData = FarmProfile::find($id);

                    // Handle AJAX requests
                    if ($request->ajax()) {
                    $type = $request->input('type');

                    // Handle requests for barangays and organizations
                    if ($type === 'barangays' || $type === 'organizations') {
                    $district = $request->input('district');

                    if ($type === 'barangays') {
                        $barangays = Barangay::where('district', $district)->get(['id', 'barangay_name']);
                        return response()->json($barangays);

                    } elseif ($type === 'organizations') {
                        $organizations = FarmerOrg::where('district', $district)->get(['id', 'organization_name']);
                        return response()->json($organizations);
                    }

                    return response()->json(['error' => 'Invalid type parameter.'], 400);
                    }

                    // Handle requests for crop names and crop varieties
                    if ($type === 'crops') {
                    $crops = CropCategory::pluck( 'crop_name','crop_name',);
                    return response()->json($crops);
                    }

                    if ($type === 'varieties') {
                    $cropId = $request->input('crop_name');
                    $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
                    return response()->json($varieties);
                    }
                    if ($type === 'seedname') {
                    // Retrieve the 'variety_name' from the request
                    $varietyId = $request->input('variety_name');

                    // Fetch the seeds based on the variety name and return the result as a JSON response
                    $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');

                    // Return the seeds as a JSON response for the frontend
                    return response()->json($seeds);
                    }
                    return response()->json(['error' => 'Invalid type parameter.'], 400);
                    }



              // Return the view with the fetched data
              return view('admin.farmersdata.cropsdata.add_crop', compact('agri_district', 'agri_districts_id', 'admin', 'profile',
              'totalRiceProduction','userId','cropVarieties','farmData'));
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


  public function saveCropfarm(Request $request)
  {
 
    
        //   // Farmer info
        //   $farmerdata = $request -> farmer;
    
        //   $existingFarmer = PersonalInformations::where('last_name', $farmerdata['last_name'])
        //   ->where('first_name', $farmerdata['first_name'])
        //   ->where('mothers_maiden_name', $farmerdata['mothers_maiden_name'])
        //   ->where('date_of_birth', $farmerdata['date_of_birth'])
        //   ->first();
    
        //   if ($existingFarmer) {
        //       return response()->json([
        //           'error' => 'A record with this last name, first name, mother\'s maiden name, and date of birth already exists.'
        //       ], 400); // Send a 400 Bad Request status code
        //   }
        //   $farmerModel = new PersonalInformations();
        //   $farmerModel -> users_id = $farmerdata['users_id'];
        //   $farmerModel -> first_name = $farmerdata['first_name'];
        //   $farmerModel -> middle_name= $farmerdata['middle_name'];
        //   $farmerModel -> last_name= $farmerdata['last_name'];
        //   $farmerModel -> extension_name = $farmerdata['extension_name'];
        //   $farmerModel -> country= $farmerdata['country'];
        //   $farmerModel -> province= $farmerdata['province'];
        //   $farmerModel -> city = $farmerdata['city'];
        //   $farmerModel -> district= $farmerdata['agri_district'];
        //   $farmerModel -> barangay= $farmerdata['barangay'];
        //   $farmerModel -> street= $farmerdata['street'];
        //   $farmerModel -> zip_code= $farmerdata['zip_code'];
        //   $farmerModel -> sex= $farmerdata['sex'];
        //   $farmerModel -> religion = $farmerdata['religion'];
        //   $farmerModel -> date_of_birth= $farmerdata['date_of_birth'];
        //   $farmerModel -> place_of_birth= $farmerdata['place_of_birth'];
        //   $farmerModel -> contact_no = $farmerdata['contact_no'];
        //   $farmerModel -> civil_status= $farmerdata['civil_status'];
        //   $farmerModel -> name_legal_spouse= $farmerdata['name_legal_spouse'];
        //   $farmerModel -> no_of_children = $farmerdata['no_of_children'];
        //   $farmerModel -> mothers_maiden_name= $farmerdata['mothers_maiden_name'];
        //   $farmerModel -> highest_formal_education= $farmerdata['highest_formal_education'];
        //   $farmerModel -> person_with_disability = $farmerdata['person_with_disability'];
        //   $farmerModel -> pwd_id_no= $farmerdata['YEspwd_id_no'];
        //   $farmerModel -> government_issued_id= $farmerdata['government_issued_id'];
        //   $farmerModel -> id_type = $farmerdata['id_type'];
        //   $farmerModel -> gov_id_no= $farmerdata['add_Idtype'];
        //   $farmerModel -> member_ofany_farmers_ass_org_coop= $farmerdata['member_ofany_farmers'];
        //   $farmerModel -> nameof_farmers_ass_org_coop = $farmerdata['nameof_farmers'];
        //   $farmerModel -> name_contact_person= $farmerdata['name_contact_person'];
        //   $farmerModel -> cp_tel_no= $farmerdata['cp_tel_no'];
        //   $farmerModel -> date_interview= $farmerdata['date_of_interviewed'];
        //   $farmerModel ->save();
    
    
        // // VARIABLES
        // // VARIABLES
        // $farmer_id = $farmerModel =1;
        // // VARIABLES
        // // VARIABLES
    
        //    // Farm info
        //    $farms = $request -> farm;
        //    $farmModel = new FarmProfile();
     
        //    $farmModel -> users_id = 1;
     
        //    // FROM USER
        //    $farmModel -> agri_districts_id = 1;
     
     
        //  //   $farmModel -> personal_informations_id = $farmer_id;
     
        //  //   $farmModel -> polygons_id = $farms['polygons_id'];
        //  //   $farmModel -> agri_districts = $farms['agri_districts'];
        //  $farmModel -> users_id = $farms['users_id'];
        //  $farmModel -> personal_informations_id = $farms['personalinfo_id'];
        //  $farmModel -> agri_districts = $farms['agri_districts'];
        //    $farmModel -> tenurial_status = $farms['tenurial_status'];
        //    $farmModel -> farm_address = $farms['farm_address'];
     
        //    $farmModel -> no_of_years_as_farmers = $farms['no_of_years_as_farmers'];
        //    $farmModel -> gps_longitude = $farms['gps_longitude'];
        //    $farmModel -> gps_latitude = $farms['gps_latitude'];
        //    $farmModel -> total_physical_area = $farms['Total_area_cultivated_has'];
        //    $farmModel -> total_area_cultivated = $farms['Total_area_cultivated_has'];
        //    $farmModel -> land_title_no = $farms['land_title_no'];
        //    $farmModel -> lot_no = $farms['lot_no'];
        //    $farmModel -> area_prone_to = $farms['area_prone_to'];
        //    $farmModel -> ecosystem = $farms['ecosystem'];
        //    $farmModel -> rsba_registered = $farms['rsba_register'];
        //    $farmModel -> pcic_insured = $farms['pcic_insured'];
        //    $farmModel -> government_assisted = $farms['government_assisted'];
        //    $farmModel -> source_of_capital = $farms['source_of_capital'];
        //    $farmModel -> remarks_recommendation = $farms['remarks'];
        //  //   $farmModel -> oca_district_office =$farmerModel -> district;
        //    $farmModel -> name_of_field_officer_technician = $farms['name_technicians'];
        //    $farmModel -> date_interviewed = $farms['date_interview'];
     
        //    $farmModel ->save();
          
        //  // VARIABLES
        //  // VARIABLES
        //  $farm_id = $farmModel -> id;
        //  $users_id =  $farmerModel =1;
         // VARIABLES
         // VARIABLES
     
     // Farm info
           $crops = $request -> crops;
           // Crop info 
           foreach ($crops as $crop) {
               $cropModel = new Crop();
            //    $cropModel -> farm_profiles_id =  $crop['farmId'];
               $cropModel -> crop_name = $crop['crop_name'];
            //    $cropModel -> users_id = $users_id;
               $cropModel -> farm_profiles_id = $crop['variety']['farmId'];
               $cropModel -> planting_schedule_dryseason = $crop['variety']['dry_season'];
               $cropModel -> no_of_cropping_per_year = $crop['variety']['no_cropping_year'];
               $cropModel -> preferred_variety = $crop['variety']['preferred'];
               $cropModel -> type_of_variety_planted = $crop['variety']['type_variety'];
               $cropModel -> planting_schedule_wetseason	 = $crop['variety']['wet_season'];
               $cropModel -> yield_kg_ha = $crop['variety']['yield_kg_ha'];
               $cropModel -> save();
     
               $crop_id = $cropModel -> id;
     
               $productionModel = new LastProductionDatas();
            //    $productionModel -> users_id = $users_id;
            //    $productionModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
               $productionModel -> crops_farms_id = $crop_id;
               $productionModel -> seed_source = $crop['production']['seedSource'];
               $productionModel -> seeds_used_in_kg = $crop['production']['seedUsed'];
               $productionModel -> seeds_typed_used = $crop['production']['seedtype'];
               $productionModel -> no_of_fertilizer_used_in_bags = $crop['production']['fertilizedUsed'];
               $productionModel -> no_of_insecticides_used_in_l = $crop['production']['insecticide'];
               $productionModel -> no_of_pesticides_used_in_l_per_kg = $crop['production']['pesticidesUsed'];
               $productionModel -> area_planted = $crop['production']['areaPlanted'];
               $productionModel -> date_planted = $crop['production']['datePlanted'];
               $productionModel -> date_planted = $crop['production']['Dateharvested'];
               $productionModel -> unit = $crop['production']['unit'];
               $productionModel -> yield_tons_per_kg = $crop['production']['yieldkg'];
           
              
               $productionModel -> save();
     
             // productionid
             $productionId=$productionModel ->id;
     
             foreach ($crop['sales'] as $sale) {
                 // Create a new sale associated with the production ID
                 $salesModel = new ProductionSold();
                 $salesModel -> last_production_datas_id = $productionId;
                 $salesModel -> sold_to = $sale['soldTo'];
                 $salesModel -> measurement = $sale['measurement'];
                 $salesModel -> 	unit_price_rice_per_kg = $sale['unit_price'];
                 $salesModel -> 	quantity = $sale['quantity'];
                 $salesModel -> 	gross_income = $sale['grossIncome'];
                 $salesModel ->save();
             }
     
     
             // FIXED COST
             $fixedcostModel = new FixedCost();
            //  $fixedcostModel -> users_id = $users_id;
            //  $fixedcostModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
             $fixedcostModel -> crops_farms_id = $crop_id;
             $fixedcostModel -> last_production_datas_id = $productionId;
             $fixedcostModel -> 	particular = $crop['fixedCost']['particular'];
             $fixedcostModel -> no_of_ha = $crop['fixedCost']['no_of_has'];
             $fixedcostModel -> cost_per_ha = $crop['fixedCost']['costperHas'];
             $fixedcostModel -> total_amount = $crop['fixedCost']['TotalFixed'];
             $fixedcostModel -> save();
     
             // machineries
               $machineriesModel = new MachineriesUseds();
            //    $machineriesModel -> users_id = $users_id;
            //    $machineriesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
               $machineriesModel -> crops_farms_id = $crop_id;
               $machineriesModel -> last_production_datas_id = $productionId;
               $machineriesModel-> plowing_machineries_used = $crop['machineries']['PlowingMachine'];
               $machineriesModel -> plo_ownership_status = $crop['machineries']['plow_status'];
             
               $machineriesModel -> no_of_plowing = $crop['machineries']['no_of_plowing'];
               $machineriesModel -> plowing_cost = $crop['machineries']['cost_per_plowing'];
               $machineriesModel -> plowing_cost_total = $crop['machineries']['plowing_cost'];
               $machineriesModel -> harrowing_machineries_used = $crop['machineries']['harro_machine'];
               $machineriesModel -> harro_ownership_status = $crop['machineries']['harro_ownership_status'];
               $machineriesModel -> no_of_harrowing = $crop['machineries']['no_of_harrowing'];
               $machineriesModel -> harrowing_cost = $crop['machineries']['cost_per_harrowing'];
               $machineriesModel -> harrowing_cost_total = $crop['machineries']['harrowing_cost_total'];
               $machineriesModel -> harvesting_machineries_used = $crop['machineries']['harvest_machine'];
               $machineriesModel -> harvest_ownership_status	 = $crop['machineries']['harvest_ownership_status'];
            
             //   $machineriesModel -> harvesting_cost = $crop['machineries']['harvesting_cost'];
               $machineriesModel -> harvesting_cost_total = $crop['machineries']['Harvesting_cost_total'];
               $machineriesModel -> postharvest_machineries_used = $crop['machineries']['postharves_machine'];
               $machineriesModel -> postharv_ownership_status = $crop['machineries']['postharv_ownership_status'];
               $machineriesModel -> post_harvest_cost = $crop['machineries']['postharvestCost'];
               $machineriesModel -> 	total_cost_for_machineries = $crop['machineries']['total_cost_for_machineries'];
               $machineriesModel -> save();
     
             //   variable cost
               $variablesModel = new VariableCost();
            //    $variablesModel -> users_id = $users_id;
            //    $variablesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
               $variablesModel -> crops_farms_id = $crop_id;
               $variablesModel -> last_production_datas_id = $productionId;
             //   seeds
           
               $variablesModel -> seed_name = $crop['variables']['seed_name'];
               $variablesModel -> unit = $crop['variables']['unit'];
               $variablesModel -> quantity = $crop['variables']['quantity'];
               $variablesModel -> unit_price = $crop['variables']['unit_price_seed'];
               $variablesModel -> total_seed_cost = $crop['variables']['total_seed_cost'];
     
                //   seeds
                $variablesModel -> labor_no_of_person = $crop['variables']['no_of_person'];
                $variablesModel -> rate_per_person = $crop['variables']['rate_per_person'];
                $variablesModel -> total_labor_cost = $crop['variables']['total_labor_cost'];
     
                 // fertilizer
                $variablesModel -> name_of_fertilizer = $crop['variables']['name_of_fertilizer'];
                $variablesModel -> type_of_fertilizer = $crop['variables']['total_seed_cost'];
                $variablesModel -> no_of_sacks = $crop['variables']['no_ofsacks'];
                $variablesModel -> unit_price_per_sacks = $crop['variables']['unitprice_per_sacks'];
                $variablesModel -> total_cost_fertilizers = $crop['variables']['total_cost_fertilizers'];
     
                  //pesticides
                  $variablesModel -> pesticide_name = $crop['variables']['pesticides_name'];
                 //  $variablesModel ->	type_of_pesticides = $crop['variables']['no_of_l_kg'];2
                  $variablesModel -> no_of_l_kg = $crop['variables']['no_of_l_kg'];
                  $variablesModel -> unit_price_of_pesticides = $crop['variables']['unitprice_ofpesticides'];
                  $variablesModel -> total_cost_pesticides = $crop['variables']['total_cost_pesticides'];
              
                   //transportation
                   $variablesModel -> name_of_vehicle = $crop['variables']['type_of_vehicle'];
                  
                   $variablesModel -> total_transport_delivery_cost = $crop['variables']['total_seed_cost'];
                
                   $variablesModel -> total_machinery_fuel_cost= $crop['variables']['total_machinery_fuel_cost'];
                   $variablesModel -> total_variable_cost= $crop['variables']['total_variable_costs'];
                   $variablesModel -> save();
          
                  
                 }
          
        
     
     
     
     
     
     
           // Return success message
           return [
               'success' => "Saved to database" // Corrected the syntax here
           ];
       }  
   
       public function  CropEdit(Request $request,$id)
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
                   $cropfarm= Crop::find($id);
                   
                     // Handle AJAX requests
                     if ($request->ajax()) {
                        $type = $request->input('type');
    
                        // Handle requests for barangays and organizations
                        if ($type === 'barangays' || $type === 'organizations') {
                        $district = $request->input('district');
    
                        if ($type === 'barangays') {
                            $barangays = Barangay::where('district', $district)->get(['id', 'barangay_name']);
                            return response()->json($barangays);
    
                        } elseif ($type === 'organizations') {
                            $organizations = FarmerOrg::where('district', $district)->get(['id', 'organization_name']);
                            return response()->json($organizations);
                        }
    
                        return response()->json(['error' => 'Invalid type parameter.'], 400);
                        }
    
                        // Handle requests for crop names and crop varieties
                        if ($type === 'crops') {
                        $crops = CropCategory::pluck( 'crop_name','crop_name',);
                        return response()->json($crops);
                        }
    
                        if ($type === 'varieties') {
                        $cropId = $request->input('crop_name');
                        $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
                        return response()->json($varieties);
                        }
                        if ($type === 'seedname') {
                        // Retrieve the 'variety_name' from the request
                        $varietyId = $request->input('variety_name');
    
                        // Fetch the seeds based on the variety name and return the result as a JSON response
                        $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
    
                        // Return the seeds as a JSON response for the frontend
                        return response()->json($seeds);
                        }
                        return response()->json(['error' => 'Invalid type parameter.'], 400);
                        }
    
       
                   
                   $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                   // Return the view with the fetched data
                   return view('admin.farmersdata.cropsdata.edit_crops', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                   ,'cropfarm','userId','agri_district','agri_districts_id'
                   
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


       public function Updatecrop(Request $request,$id)
       {
       
           try{
               
   
               // $data= $request->validated();
               // $data= $request->all();
               
               $data= Crop::find($id);

              
               $data->users_id = $request->users_id;
             
            
               $data->farm_profiles_id = $request->farm_profiles_id;
               $data->crop_name = $request->crop_name;
               $data->type_of_variety_planted = $request->type_of_variety_planted;
      
               $data->preferred_variety = $request->preferred_variety;
               $data->planting_schedule_wetseason = $request->planting_schedule_wetseason;
               $data->planting_schedule_dryseason = $request->planting_schedule_dryseason;
               $data->no_of_cropping_per_year = $request->no_of_cropping_per_year === 'Adds' ? $request->add_cropyear : $request->no_of_cropping_per_year;
               $data->yield_kg_ha = $request->yield_kg_ha;
            


            //    dd($data);
               $data->save();     
               
           // Redirect back with success message
           return redirect()->back()->with('message', 'Crop Farm Data updated successfully');
   
   }catch(\Exception $ex){
  
            //    dd($ex); // Debugging statement to inspect the exception
               return redirect('/admin-edit-crop-farms/{farmData}')->with('message','Someting went wrong');
               
           }   
       } 

       public function Deletecropfarm($id) {
        try {
            // Find thecrop farm by ID
            $crofarms = Crop::find($id);
    
            // Check if thecrop farm exists
            if (!$crofarms) {
                return redirect()->back()->with('error', 'crop farm not found');
            }
    
            // Delete thecrop farm data from the database
            $crofarms->delete();
    
            // Redirect back with success message
            return redirect()->back()->with('message', 'crop farm deleted successfully');
    
        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with error message
            return redirect()->back()->with('error', 'Error deleting crop farm: ' . $e->getMessage());
        }
    }


    
    public function AllCrops(Request $request)
{
    if (Auth::check()) {
        $userId = Auth::id();
        $admin = User::find($userId);

        if ($admin) {
            // Fetch filter inputs
            $selectedCropName = $request->input('crop_name', ''); // Default to empty for "All Crops"
            $selectedDateFrom = $request->input('dateFrom', '');
            $selectedDateTo = $request->input('dateTo', '');
            $selectedDistrict = $request->input('district', ''); // New input for district

            // Fetch distinct crops and districts from the database
            $crops = Crop::distinct()->pluck('crop_name');
            $districts = AgriDistrict::distinct()->pluck('district');

            // Initialize queries for filtering
            $farmProfilesQuery = FarmProfile::query();
            $variableCostQuery = VariableCost::query();
            $lastProductionDatasQuery = LastProductionDatas::query();

            // Apply filtering based on selected crop name
            if ($selectedCropName) {
                $farmProfilesQuery->whereHas('crops', function ($query) use ($selectedCropName) {
                    $query->where('crop_name', $selectedCropName);
                });

                $variableCostQuery->whereHas('lastProductionData.cropFarms.crop', function ($query) use ($selectedCropName) {
                    $query->where('crop_name', $selectedCropName);
                });

                $lastProductionDatasQuery->whereHas('cropFarms.crop', function ($query) use ($selectedCropName) {
                    $query->where('crop_name', $selectedCropName);
                });
            }

            // Apply filtering based on selected district
            if ($selectedDistrict) {
                $farmProfilesQuery->whereHas('agriDistrict', function ($query) use ($selectedDistrict) {
                    $query->where('district', $selectedDistrict);
                });

                $variableCostQuery->whereHas('lastProductionData.cropFarms.farmProfile.agriDistrict', function ($query) use ($selectedDistrict) {
                    $query->where('district', $selectedDistrict);
                });

                $lastProductionDatasQuery->whereHas('cropFarms.farmProfile.agriDistrict', function ($query) use ($selectedDistrict) {
                    $query->where('district', $selectedDistrict);
                });
            }

            // Apply filtering based on date range
            if ($selectedDateFrom && $selectedDateTo) {
                $lastProductionDatasQuery->whereBetween('date_harvested', [$selectedDateFrom, $selectedDateTo]);
            }

            // Calculate totals based on the filtered results
            $totalFarms = $farmProfilesQuery->count();
            $totalAreaPlanted = $farmProfilesQuery->sum('total_physical_area');
            $totalAreaYield = $farmProfilesQuery->sum('yield_kg_ha');
            $totalCost = $variableCostQuery->sum('total_variable_cost');
            $yieldPerAreaPlanted = ($totalAreaPlanted != 0) ? $totalAreaYield / $totalAreaPlanted : 0;
            $averageCostPerAreaPlanted = ($totalAreaPlanted != 0) ? $totalCost / $totalAreaPlanted : 0;
            $totalRiceProductionInKg = $lastProductionDatasQuery->sum('yield_tons_per_kg');
            $totalRiceProduction = $totalRiceProductionInKg / 100000; // Convert to tons

            // Fetch crop farms based on selected crop name and district
            $cropFarmsQuery = Crop::with('farmProfile.agriDistrict', 'lastProductionData');

            if ($selectedCropName) {
                $cropFarmsQuery->where('crop_name', $selectedCropName);
            }

            $cropFarms = $cropFarmsQuery->get();

            // Initialize arrays for chart data
            $yieldPerDistrict = [];
            $typeVarietyCountsPerDistrict = [];
            $dateRange = [];

            foreach ($cropFarms as $cropFarm) {
                $districtName = $cropFarm->farmProfile->agriDistrict->district ?? 'Not specified';

                if ($selectedDistrict && $districtName !== $selectedDistrict) {
                    continue; // Skip if the district does not match the selected one
                }

                if (!isset($yieldPerDistrict[$districtName])) {
                    $yieldPerDistrict[$districtName] = 0;
                }

                if (!isset($typeVarietyCountsPerDistrict[$districtName])) {
                    $typeVarietyCountsPerDistrict[$districtName] = [
                        'Inbred' => 0,
                        'Hybrid' => 0,
                        'Not specified' => 0,
                    ];
                }

                foreach ($cropFarm->lastProductionData as $productionData) {
                    $harvestDate = $productionData->date_harvested;
                    $yield = $productionData->yield_tons_per_kg;

                    if ($selectedDateFrom && $selectedDateTo && ($harvestDate < $selectedDateFrom || $harvestDate > $selectedDateTo)) {
                        continue; // Skip if the harvest date is outside the selected date range
                    }

                    $yieldPerDistrict[$districtName] += $yield;
                    $dateRange[] = $harvestDate;
                }

                $typeOfVarietyPlanted = $cropFarm->type_of_variety_planted ?? 'Not specified';

                if (!isset($typeVarietyCountsPerDistrict[$districtName][$typeOfVarietyPlanted])) {
                    $typeVarietyCountsPerDistrict[$districtName][$typeOfVarietyPlanted] = 0;
                }

                $typeVarietyCountsPerDistrict[$districtName][$typeOfVarietyPlanted]++;
            }

            // Prepare data for pie chart
            $pieChartData = [
                'labels' => array_keys($yieldPerDistrict),
                'series' => array_values($yieldPerDistrict),
            ];

            // Prepare data for bar chart
            // $barChartData = [];
            // foreach ($typeVarietyCountsPerDistrict as $district => $varieties) {
            //     $barChartData[] = [
            //         'name' => $district,
            //         'data' => array_values($varieties)
            //     ];
            // }
            // Populate the bar chart data with proper names
         // Function to format names to proper names if they are not already
         function formatLabel($label) {
            return ucwords(str_replace('_', ' ', strtolower($label)));
        }
        $formattedDistricts = $districts->map(function ($district) {
            return formatLabel($district);
        });
                // Transform data to include formatted names
foreach ($typeVarietyCountsPerDistrict as $district => $varieties) {
    // Format the district name
    $formattedDistrictName = formatLabel($district);

    // Alternatively, use the formatted name if it's in the list
    $districtName = $formattedDistricts->contains($formattedDistrictName) ? $formattedDistrictName : 'Not Specified';

    $barChartData[] = [
        'name' => $districtName,
        'data' => array_values($varieties)
    ];
}
            // Initialize an array to hold total rice production per district
            $totalRiceProductionPerDistrict = [];

            // Calculate total rice production for each district
            foreach ($cropFarms as $cropFarm) {
                $districtName = $cropFarm->farmProfile->agriDistrict->district ?? 'Not specified';

                if (!isset($totalRiceProductionPerDistrict[$districtName])) {
                    $totalRiceProductionPerDistrict[$districtName] = 0;
                }

                foreach ($cropFarm->lastProductionData as $productionData) {
                    $yield = $productionData->yield_tons_per_kg;
                    $totalRiceProductionPerDistrict[$districtName] += $yield;
                }
            }

            // Prepare data for pie chart
      
            // Prepare data for pie chart showing total rice production per district
            $pieChartDatas = [
                'labels' => array_keys($totalRiceProductionPerDistrict),
                'series' => array_values($totalRiceProductionPerDistrict),
            ];


            // Determine date range
            $dateRange = array_unique($dateRange);
            sort($dateRange);
            $minDate = $dateRange[0] ?? '';
            $maxDate = end($dateRange) ?? '';


         // Fetch the count of farms per district
    $distributionFrequency = $farmProfilesQuery
    ->select('agri_districts_id', DB::raw('count(*) as total'))
    ->groupBy('agri_districts_id')
    ->pluck('total', 'agri_districts_id');

// Fetch district names
$districts = AgriDistrict::whereIn('id', $distributionFrequency->keys())->pluck('district', 'id');

// Fetch farmers information grouped by district
$farmProfiles = FarmProfile::with('personalInformation', 'agriDistrict')
    ->when($selectedDistrict, function ($query, $selectedDistrict) {
        $query->whereHas('agriDistrict', function ($query) use ($selectedDistrict) {
            $query->where('district', $selectedDistrict);
        });
    })
    ->get();

// Group farmers by district and structure their information
$groupedFarmers = $farmProfiles->groupBy(function ($farmProfile) {
    return $farmProfile->agriDistrict->district ?? 'Unknown';
})->mapWithKeys(function ($group, $district) {
    return [
        $district => $group->map(function ($farmProfile) {
            return [
                'first_name' => $farmProfile->personalInformation->first_name ?? 'N/A',
                'last_name' => $farmProfile->personalInformation->last_name ?? 'N/A',
                'organization' => $farmProfile->personalInformation->nameof_farmers_ass_org_coop ?? 'N/A',
            ];
        })
    ];
});

// Flatten the grouped farmers data for pagination
$flatFarmers = $groupedFarmers->flatMap(function ($farmers, $district) {
    return $farmers->map(function ($farmer) use ($district) {
        return array_merge($farmer, ['district' => $district]);
    });
});

// Implement pagination
$currentPage = Paginator::resolveCurrentPage();
$perPage = 5; // Number of items per page
$paginatedFarmers = new LengthAwarePaginator(
    $flatFarmers->forPage($currentPage, $perPage),
    $flatFarmers->count(),
    $perPage,
    $currentPage,
    ['path' => Paginator::resolveCurrentPath()]
);

if ($request->ajax()) {
    $farmersTable = view('admin.partials.farmers_table', compact('paginatedFarmers'))->render();
    $paginationLinks = view('admin.partials.pagination', compact('paginatedFarmers'))->render(); // Assuming you place the pagination markup in this view

    return response()->json([
        'farmers' => $farmersTable,
        'pagination' => $paginationLinks,
    ]);
}


            
            return view('admin.cropsreport.all_crops', compact(
                'totalFarms', 'totalAreaPlanted', 'totalAreaYield', 'totalCost', 'yieldPerAreaPlanted',
                'averageCostPerAreaPlanted', 'totalRiceProduction', 'pieChartData', 'barChartData',
                'selectedCropName', 'selectedDateFrom', 'selectedDateTo', 'crops', 'districts', 'selectedDistrict',
                'minDate', 'maxDate', 'admin', 'pieChartDatas','distributionFrequency','flatFarmers','paginatedFarmers'
            ));
        } else {
            return redirect()->route('login')->with('error', 'User not found.');
        }
    } else {
        return redirect()->route('login');
    }
}

}
