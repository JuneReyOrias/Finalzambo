<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParcellaryBoundariesRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\FarmProfile;
use App\Models\Fertilizer;
use App\Models\FixedCost;
use App\Models\Labor;
use App\Models\FarmerOrg;
use App\Models\Crop;
use App\Models\Barangay;
use App\Models\LastProductionDatas;
use App\Models\MachineriesUseds;
use App\Models\ParcellaryBoundaries;
use App\Models\Pesticide;
use App\Models\Seed;
use App\Models\VariableCost;
use App\Http\Requests\FarmProfileRequest;
use App\Http\Requests\FixedCostRequest;
use App\Http\Requests\MachineriesUsedtRequest;
use App\Http\Requests\UpdateMachineriesUsedRequest;
use App\Http\Requests\LastProductionDatasRequest;
use App\Http\Requests\UpdateLastProductiondatasRequest;
use App\Http\Requests\SeedRequest;
use App\Http\Requests\LaborRequest;
use App\Http\Requests\FertilizerRequest;
use App\Http\Requests\PesticidesRequest;
use App\Http\Requests\TransportRequest;
use App\Http\Requests\VariableCostRequest;
use App\Models\PersonalInformations;
use App\Http\Requests\PersonalInformationsRequest;
use App\Http\Controllers\Backend\PersonalInformationsController;
use App\Models\AgriDistrict;
use App\Models\Transport;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use Exception;
class AdminController extends Controller
{
   
 // Constructor to apply no-cache headers to all methods in this controller
 public function __construct()
 {
     $this->middleware(function ($request, $next) {
         // Prevent caching of the page
         return $next($request)->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                               ->header('Pragma', 'no-cache')
                               ->header('Expires', '0');
     });
 }
        public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }//end 
    
    public function adminDashb(Request $request)
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
// Calculate the total area planted per district
$totalAreaPlantedPerDistrict = $farmProfilesQuery
    ->select('agri_districts_id', DB::raw('sum(total_physical_area) as total_area_planted'))
    ->groupBy('agri_districts_id')
    ->pluck('total_area_planted', 'agri_districts_id');

// Fetch district names for the calculated totals
$districtNames = AgriDistrict::whereIn('id', $totalAreaPlantedPerDistrict->keys())->pluck('district', 'id');

// Combine the district names with their respective total area planted
$totalAreaPlantedByDistrict = $districtNames->map(function ($districtName, $districtId) use ($totalAreaPlantedPerDistrict) {
    return [
        'district' => $districtName,
        'total_area_planted' => $totalAreaPlantedPerDistrict[$districtId],
    ];
})->values(); // Use values() to re-index the array

if ($request->ajax()) {
    // Prepare the response data
    $response = [
        'districts' => $totalAreaPlantedByDistrict->pluck('district')->toArray(),
        'areas' => $totalAreaPlantedByDistrict->pluck('total_area_planted')->map(function($area) {
            return round($area, 2); // Round each area to 2 decimal places
        })->toArray()
    ];



    // Return the response as JSON
    return response()->json($response);
}
// Calculate the total area yield per district
$totalAreaYieldPerDistrict = $farmProfilesQuery
    ->select('agri_districts_id', DB::raw('sum(yield_kg_ha) as total_areaYIELD'))
    ->groupBy('agri_districts_id')
    ->pluck('total_areaYIELD', 'agri_districts_id');

// Fetch district names for the calculated totals
$districtNames = AgriDistrict::whereIn('id', $totalAreaYieldPerDistrict->keys())->pluck('district', 'id');

// Combine the district names with their respective total area yield
$totalAreaYieldPerDistricts = $districtNames->map(function ($districtName, $districtId) use ($totalAreaYieldPerDistrict) {
    return [
        'district' => $districtName,
        'total_areaYIELD' => $totalAreaYieldPerDistrict[$districtId], // Correctly using $totalAreaYieldPerDistrict here
    ];
})->values(); // Use values() to re-index the array


       // Calculate the total area yield per district
$totalAreaYieldPerDistrict = $farmProfilesQuery
->select('agri_districts_id', DB::raw('sum(yield_kg_ha) as total_areaYIELD'))
->groupBy('agri_districts_id')
->pluck('total_areaYIELD', 'agri_districts_id');

// Calculate the total area planted per district
$totalAreaPlantedPerDistrict = $farmProfilesQuery
->select('agri_districts_id', DB::raw('sum(total_physical_area) as total_areaPLANTED'))
->groupBy('agri_districts_id')
->pluck('total_areaPLANTED', 'agri_districts_id');

// Fetch district names for the calculated totals
$districtNames = AgriDistrict::whereIn('id', $totalAreaYieldPerDistrict->keys())->pluck('district', 'id');

// Combine the district names with their respective total area yield and planted, and calculate yield per area planted
$totalAreaYieldPerDistrictss= $districtNames->map(function ($districtName, $districtId) use ($totalAreaYieldPerDistrict, $totalAreaPlantedPerDistrict) {
// Fetch the total area yield and planted for each district
$totalAreaYield = $totalAreaYieldPerDistrict[$districtId] ?? 0;
$totalAreaPlanted = $totalAreaPlantedPerDistrict[$districtId] ?? 0;

// Calculate yield per area planted (avoid division by zero)
$yieldPerAreaPlanted = ($totalAreaPlanted != 0) ? $totalAreaYield / $totalAreaPlanted : 0;

return [
    'district' => $districtName,
    'total_areaYIELD' => $totalAreaYield,
    'total_areaPLANTED' => $totalAreaPlanted,
    'yieldPerAreaPlanted' => $yieldPerAreaPlanted, // Added yield per area planted
];
})->values();
 // Use values() to re-index the array

// // Calculate the total area planted per district
// $totalCostPerDISTRICT = $variableCostQuery
//     ->select('agri_districts_id', DB::raw('sum(total_variable_cost) as variable_cost'))
//     ->groupBy('agri_districts_id')
//     ->pluck('variable_cost', 'agri_districts_id');

// // Fetch district names for the calculated totals
// $districtNames = AgriDistrict::whereIn('id', $totalAreaPlantedPerDistrict->keys())->pluck('district', 'id');

// // Combine the district names with their respective total area planted
// $totalAreaPlantedByDistrict = $districtNames->map(function ($districtName, $districtId) use ($totalAreaPlantedPerDistrict) {
//     return [
//         'district' => $districtName,
//         'variable_cost' => $totalAreaPlantedPerDistrict[$districtId],
//     ];
// })->values(); // Use values() to re-index the array


 
            return view('admin.index', compact(
                'totalFarms', 'totalAreaPlanted', 'totalAreaYield', 'totalCost', 'yieldPerAreaPlanted',
                'averageCostPerAreaPlanted', 'totalRiceProduction', 'pieChartData', 'barChartData',
                'selectedCropName', 'selectedDateFrom', 'selectedDateTo', 'crops', 'districts', 'selectedDistrict',
                'minDate', 'maxDate', 'admin', 'pieChartDatas','distributionFrequency','flatFarmers','paginatedFarmers',
                'totalAreaPlantedByDistrict','totalAreaYieldPerDistricts','totalAreaYieldPerDistrictss'
            ));
        } else {
            return redirect()->route('login')->with('error', 'User not found.');
        }
    } else {
        return redirect()->route('login');
    }
}
// Method to check if resources exist
protected function resourcesExist($cropName, $district)
{
    $cropExists = Crop::where('crop_name', $cropName)->exists();
    $districtExists = AgriDistrict::where('district', $district)->exists();
    return $cropExists && $districtExists;
}

//   public function adminDashb(Request $request)
// {
//     if (Auth::check()) {
//         $userId = Auth::id();
//         $admin = User::find($userId);

//         if ($admin) {
//             $totalfarms = FarmProfile::count();
//             $totalAreaPlanted = FarmProfile::sum('total_physical_area');
//             $totalAreaYield = FarmProfile::sum('yield_kg_ha');
//             $totalCost = VariableCost::sum('total_variable_cost');
//             $yieldPerAreaPlanted = ($totalAreaPlanted != 0) ? $totalAreaYield / $totalAreaPlanted : 0;
//             $averageCostPerAreaPlanted = ($totalAreaPlanted != 0) ? $totalCost / $totalAreaPlanted : 0;
//             $totalRiceProductionInkg = LastProductionDatas::sum('yield_tons_per_kg');
//             $totalRiceProduction = $totalRiceProductionInkg / 1000;
//             $districts = AgriDistrict::all();

//             $selectedCrop = $request->input('crop', 'Rice');
//             $selectedDate = $request->input('harvestDate', '');
//             $selectedCycle = $request->input('croppingCycle', '');

//             // Fetch farm data grouped by district based on selected crop
//             $data = FarmProfile::join('crops_farms', 'farm_profiles.id', '=', 'crops_farms.farm_profiles_id')
//                 ->where('crops_farms.crop_name', $selectedCrop)
//                 ->with('district')  // Assuming you have a relationship 'district' defined
//                 ->get()
//                 ->groupBy('district.agri_districts_id');

//             // Fetch yield data dynamically
//             $yieldDataQuery = FarmProfile::join('crops_farms', 'farm_profiles.id', '=', 'crops_farms.farm_profiles_id')
//                 ->join('last_production_datas', 'crops_farms.id', '=', 'last_production_datas.crops_farms_id')
//                 ->where('crops_farms.crop_name', $selectedCrop)
//                 ->when($selectedDate, function ($query, $selectedDate) {
//                     return $query->where('last_production_datas.date_harvested', $selectedDate);
//                 })
//                 ->when($selectedCycle, function ($query, $selectedCycle) {
//                     return $query->where('last_production_datas.cropping_no', $selectedCycle);
//                 })
//                 ->select('farm_profiles.agri_districts_id', 'last_production_datas.yield_tons_per_kg')
//                 ->get()
//                 ->groupBy('agri_districts_id')
//                 ->map(function ($districtData) {
//                     return $districtData->sum('yield_tons_per_kg');
//                 });

//             $availableCycles = $yieldDataQuery->keys();
//             $selectedCycle = !empty($selectedCycle) && $availableCycles->contains($selectedCycle) ? $selectedCycle : $availableCycles->first();

//             // Fetch total production data for the pie chart
//             $totalProductionData = FarmProfile::join('crops_farms', 'farm_profiles.id', '=', 'crops_farms.farm_profiles_id')
//                 ->where('crops_farms.crop_name', $selectedCrop)
//                 ->select('crops_farms.crop_name', DB::raw('SUM(last_production_datas.yield_tons_per_kg) as total_yield'))
//                 ->join('last_production_datas', 'crops_farms.id', '=', 'last_production_datas.crops_farms_id')
//                 ->groupBy('crops_farms.crop_name')
//                 ->get()
//                 ->mapWithKeys(function ($item) {
//                     return [$item->crop_name => $item->total_yield];
//                 });

//             // If the request is AJAX, return JSON data
//             if ($request->ajax()) {
//                 return response()->json([
//                     'yieldData' => $yieldDataQuery,
//                     'totalProduction' => $totalRiceProduction
//                 ]);
//             }

//             // Otherwise, return the normal view
//             return view('admin.index', compact(
//                 'data', 'yieldDataQuery', 'selectedCrop', 'selectedDate', 'selectedCycle', 'totalfarms', 'districts', 'admin',
//                 'totalAreaPlanted', 'totalAreaYield', 'totalCost', 'yieldPerAreaPlanted',
//                 'averageCostPerAreaPlanted', 'totalRiceProduction', 'totalProductionData'
//             ));
//         } else {
//             return redirect()->route('login')->with('error', 'User not found.');
//         }
//     } else {
//         return redirect()->route('login');
//     }
// }
  
    // public function getFarmerReports($district)
    // {
    //     // Fetch farmer reports based on the selected district
    //     $FarmersData = DB::table('personal_informations')
    //         ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
    //         ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
    //         ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
    //         ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
    //         ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
    //         ->select(
    //             'personal_informations.*',
    //             'farm_profiles.*',
    //             'fixed_costs.*',
    //             'machineries_useds.*',
    //             'variable_costs.*',
    //             'last_production_datas.*'
    //         )
    //         ->where('farm_profiles.district', $district)
    //         ->orderBy('personal_informations.id', 'desc')
    //         ->get();

    //     return response()->json($FarmersData);
    // }





    // public function AdminLogin(){
    //      return view('admin.admin_login');
    // }//end

 
    // update the profile data 
    public function AdminProfile()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // User is authenticated, proceed with retrieving the user's ID
            $userId = Auth::id();
    
            // Find the user based on the retrieved ID
            $admin = User::find($userId);
    
            if ($admin) {
                // Assuming you have additional logic to fetch dashboard data
               
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with dashboard data
                return view('admin.admin_profile', compact('admin','totalRiceProduction'));
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
    

    public function update(Request $request){
        
        try {
            $id =Auth::user()->id;
       $data= User:: find($id);
       if ($data) {
           // Check if a file is present in the request and if it's valid
           if ($request->hasFile('image') && $request->file('image')->isValid()) {
               // Retrieve the image file from the request
               $image = $request->file('image');
   
               // Generate a unique image name using current timestamp and file extension
               $imagename = time() . '.' . $image->getClientOriginalExtension();
   
               // Move the uploaded image to the 'productimages' directory with the generated name
               $image->move('adminimages', $imagename);
   
               // Delete the previous image file, if exists
               if ($data->image) {
                   Storage::delete('adminimages/' . $data->image);
               }
   
               // Set the image name in the Product data
               $data->image = $imagename;
           }
   
       $data->name= $request->name;
       $data->email= $request->email;
       $data->agri_district= $request->agri_district;
       $data->password= $request->password;
       $data->role= $request->role;
    
        
      $data->save();
        // Redirect back after processing
        return redirect()->route('admin.admin_profile')->with('message', 'Profile updated successfully');
       } else {
           // Redirect back with error message if product not found
           return redirect()->back()->with('error', 'Product not found');
       }
   } catch (Exception $e) {
       dd($e);
       // Handle any exceptions and redirect back with error message
       return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
   }
   }





   
 
//    parcel boarders 
   public function ParcelBoarders(Request $request)
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
               $agri_district = $user->agri_district;
               // Check if user is authenticated before proceeding
               if (!$user) {
                   // Handle unauthenticated user, for example, redirect them to login
                   return redirect()->route('login');
               }
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
        
        
        
        
               // Fetch user's information
               $user_id = $user->id;
               $agri_district = $user->agri_district;
               $agri_districts_id = $user->agri_districts_id;
   
               // Find the user by their ID and eager load the personalInformation relationship
               $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
               $agri_districts = AgriDistrict::all();
               $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
               // Return the view with the fetched data
               return view('parcels.new_parcels', compact('agri_districts', 'agri_districts_id', 'admin', 'profile','totalRiceProduction','userId'));
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


public function newparcels(Request $request)
{
    try {
        
    
                $parcel = new ParcellaryBoundaries();
                $parcel->users_id = $request->users_id;
              
                $parcel->agri_districts = $request->agri_districts;
                $parcel->barangay_name = $request->barangay_name;
                $parcel->parcel_name = $request->parcel_name;
                $parcel->arpowner_na = $request->arpowner_na;
                $parcel->tct_no = $request->tct_no;
                $parcel->lot_no = $request->lot_no;
                $parcel->pkind_desc = $request->pkind_desc;
                $parcel->puse_desc = $request->puse_desc;
                $parcel->actual_used = $request->actual_used;
                $parcel->longitude = $request->longitude;
                $parcel->latitude = $request->latitude;
                $parcel->area = $request->area;
                $parcel->parcolor = $request->parcolor;
              
                // dd($parcel);
                // Save the new FarmProfile
                $parcel->save();
        // Redirect with success message
        return redirect('/admin-view-polygon')->with('message', 'Parcelary Boundaries added successfully');
    } catch (Exception $ex) {
        // Debugging statement to inspect the exception
        dd($ex);
        // Redirect with error message
        return redirect('/admin-add-parcel')->with('message', 'Something went wrong');
    }
}



// admin cost view

public function Parcelshow()
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
               $agri_districts = $user->agri_district;
               $agri_districts_id = $user->agri_districts_id;
   
               // Find the user by their ID and eager load the personalInformation relationship
               $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
               $parcels=ParcellaryBoundaries::orderBy('id','desc')->paginate(20);
               $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
               // Return the view with the fetched data
               return view('parcels.show', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
            'parcels','totalRiceProduction'));
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
// admin cost update

public function ParcelEdit( Request $request,$id)
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
               $agri_districts = $user->agri_district;
               $agri_districts_id = $user->agri_districts_id;
   
               // Find the user by their ID and eager load the personalInformation relationship
               $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
               $parcels=ParcellaryBoundaries::find($id);

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
               return view('parcels.parcels_edit', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
            'parcels','totalRiceProduction'));
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


public function ParcelUpdates(Request $request,$id)
{

    try{
        

        $parcel =  ParcellaryBoundaries::find($id);
        $parcel->users_id = $request->users_id;
      
        $parcel->agri_districts = $request->agri_districts;
        $parcel->barangay_name = $request->barangay_name;
        $parcel->parcel_name = $request->parcel_name;
        $parcel->arpowner_na = $request->arpowner_na;
        $parcel->tct_no = $request->tct_no;
        $parcel->lot_no = $request->lot_no;
        $parcel->pkind_desc = $request->pkind_desc;
        $parcel->puse_desc = $request->puse_desc;
        $parcel->actual_used = $request->actual_used;
        $parcel->longitude = $request->longitude;
        $parcel->latitude = $request->latitude;
        $parcel->area = $request->area;
        $parcel->parcolor = $request->parcolor;
      
        // dd($parcel);
        // Save the new FarmProfile
        $parcel->save();
        return redirect('/admin-view-polygon')->with('message','Parcellary Boundaries Data Updated successsfully');
    
    }
    catch(Exception $ex){
        dd($ex); // Debugging statement to inspect the exception
        return redirect('/edit-parcel-boarders/{parcels}')->with('message','Someting went wrong');
        
    }   
} 






public function Parceldelete($id) {
    try {
        // Find the personal information by ID
       $parcels = ParcellaryBoundaries::find($id);

        // Check if the personal information exists
        if (!$parcels) {
            return redirect()->back()->with('error', 'Farm Profilenot found');
        }

        // Delete the personal information data from the database
       $parcels->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Parcellary Boundaries deleted Successfully');

    } catch (Exception $e) {
        // Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
    }
}

// creatinng new users account

public function newAccounts()
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
               $agri_districts = $user->agri_district;
               $agri_districts_id = $user->agri_districts_id;
   
               // Find the user by their ID and eager load the personalInformation relationship
               $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
              
               $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
               // Return the view with the fetched data
               return view('admin.create_account.new_accounts', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
            'totalRiceProduction'));
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
            //create new accounts  //create new accounts
            public function NewUsers(RegisterRequest $request){
                try{
                    // dd($request->all());
                    $data= $request->validated();
                    $data= $request->all();
                    $user = new User;
                  
                    $user->first_name = $request['first_name'];
                    $user->last_name = $request['last_name'];
                    $user->email = $request['email'];
                    $user->district = $request['district'];
                    $user->password = bcrypt($request['password']); // Hash the password for security
                    $user->role = $request['role'];
                    // dd($user);
                    $user->save();
                    return redirect('/view-accounts')->with('message','Account Added Successsfully');
                
                }
                catch(Exception $ex){
                    dd($ex);
                    return redirect('/new-accounts')->with('message','Someting went wrong');
                }

                
             }
            //  users view by admin 
            public function Accountview(Request $request)
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
                        $agri_districts = $user->agri_district;
                        $agri_districts_id = $user->agri_districts_id;
            
                        // Find the user by their ID and eager load the personalInformation relationship
                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                        $users=User::orderBy('id','desc')->paginate(20);
                           // Query for transports with search functionality
                           $usersQuery = User::query();
                           if ($request->has('search')) {
                               $searchTerm = $request->input('search');
                               $usersQuery->where(function($query) use ($searchTerm) {
                                   $query->where('email', 'like', "%$searchTerm%")
                                       ->orWhere('name', 'like', "%$searchTerm%")
                                       ->orWhere('agri_district', 'like', "%$searchTerm%");
                               });
                           }
                           $users = $usersQuery->orderBy('id','asc')->paginate(10);
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        // Return the view with the fetched data
                        return view('admin.create_account.display_users', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
                       'totalRiceProduction','users'));
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

                        
                        // admin cost update
        

                        public function  editAccount($id)
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
                                    $agri_districts = $user->agri_district;
                                    $agri_districts_id = $user->agri_districts_id;
                        
                                    // Find the user by their ID and eager load the personalInformation relationship
                                    $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                                    $users=User::find($id);
                                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                                    // Return the view with the fetched data
                                    return view('admin.create_account.edit_accounts', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
                                    'totalRiceProduction','users'));
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
            public function updateAccounts(Request $request, $id){
                    
                try {
                    
            $data= User:: find($id);
            if ($data) {
                // Check if a file is present in the request and if it's valid
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    // Retrieve the image file from the request
                    $image = $request->file('image');

                    // Generate a unique image name using current timestamp and file extension
                    $imagename = time() . '.' . $image->getClientOriginalExtension();

                    // Move the uploaded image to the 'productimages' directory with the generated name
                    $image->move('adminimages', $imagename);

                    // Delete the previous image file, if exists
                    if ($data->image) {
                        Storage::delete('adminimages/' . $data->image);
                    }

                    // Set the image name in the Product data
                    $data->image = $imagename;
                }

                // $data->name = $request['name'];
                $data->first_name = $request['first_name'];
                $data->last_name = $request['last_name'];
                $data->email = $request['email'];
                $data->district = $request['district'];
                // $data->password = bcrypt($request['password']); // Hash the password for security
                $data->role = $request['role'];
                // dd($data);
                $data->save();

                // Redirect back after processing
                return redirect('/view-accounts')->with('message', 'Account updated successfully');
            } 
            } catch (Exception $e) {
            //    dd($e);
            // Handle any exceptions and redirect back with error message
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
            }
            }







// Delete users access by admin
public function deleteusers($id) {
    try {
        // Find the personal information by ID
       $users = User::find($id);

        // Check if the personal information exists
        if (!$users) {
            return redirect()->back()->with('error', 'Farm Profilenot found');
        }

        // Delete the personal information data from the database
       $users->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Parcellary Boundaries deleted Successfully');

    } catch (Exception $e) {
        // Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
    }
}


// farmers info per agri district
 

 public function farmerAyalas()
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
 
             // Find the farm profile using the fetched farm ID
             $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
 
       
 
             // Fetch ayala farmers fetching  data
             $FarmersData = DB::table('personal_informations')
             ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
             ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
             ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
             ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
             ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
             ->select(
                 'personal_informations.*',
                 'farm_profiles.*',
                 'fixed_costs.*',
                 'machineries_useds.*',
                 'variable_costs.*',
                 'last_production_datas.*'
             )
             ->orderBy('personal_informations.id', 'desc') // Order by the ID of personal_informations table in descending order
             ->get();
             // Specify the agri district you want to filter by
                 // Calculate the age for each farmer
                 foreach ($FarmersData as $farmer) {
                     // Calculate the age for each farmer
                     $dateOfBirth = $farmer->date_of_birth;
                     $age = Carbon::parse($dateOfBirth)->age;
 
                     // Add the age to the farmer object
                     $farmer->age = $age;
                 }
             // Count the number of farmers in the "ayala" district
             $totalfarms = DB::table('personal_informations')
             ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
             ->where('farm_profiles.agri_districts', 'ayala')
             ->distinct()
             ->count('personal_informations.id');
 
               // Calculate the total area planted in the "ayala" district
             $totalAreaPlantedAyala = DB::table('farm_profiles')
             ->where('agri_districts', 'ayala')
             ->sum('total_physical_area');
             $totalAreaYieldAyala = DB::table('farm_profiles')
             ->where('agri_districts', 'ayala')
             ->sum('yield_kg_ha');
          
              // Calculate the total fixed cost in the "ayala" district
             $totalFixedCostAyala = DB::table('fixed_costs')
             ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'fixed_costs.personal_informations_id')
             ->where('farm_profiles.agri_districts', 'ayala')
             ->sum('fixed_costs.total_amount');
             
                   // Calculate the total machineries cost in the "ayala" district
                   $totalMachineriesUsedAyala= DB::table('machineries_useds')
                   ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','machineries_useds.personal_informations_id')
                   ->where('farm_profiles.agri_districts', 'ayala')
                   ->sum('machineries_useds.total_cost_for_machineries');
 
                 // Calculate the total variable cost in the "ayala" district
                 $totalVariableCostAyala = DB::table('variable_costs')
                 ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','variable_costs.personal_informations_id')
                 ->where('farm_profiles.agri_districts', 'ayala')
                 ->sum('variable_costs.total_variable_cost');
 
                     // Calculate the total rice production in the Ayala district
                     $totalRiceProductionAyala = LastProductionDatas::join('farm_profiles', 'last_production_datas.personal_informations_id', '=', 'farm_profiles.personal_informations_id')
                     ->where('farm_profiles.agri_districtS', 'Ayala')
                     ->sum('last_production_datas.yield_tons_per_kg');
 
 
                               // Count owner tenants
                             $countOwnerTenants = DB::table('personal_informations')
                             ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                             ->where('farm_profiles.agri_districts', 'ayala')
                             ->where('farm_profiles.tenurial_status', 'owner')
                             ->distinct()
                             ->count('farm_profiles.tenurial_status');
 
                             // Count tiller tenant tenants
                             $countTillerTenantTenants = DB::table('personal_informations')
                             ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                             ->where('farm_profiles.agri_districts', 'ayala')
                             ->where('farm_profiles.tenurial_status', 'tiller tenant')
                             ->distinct()
                             ->count('farm_profiles.tenurial_status');
 
                             // Count tiller tenants
                             $countTillerTenants = DB::table('personal_informations')
                             ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                             ->where('farm_profiles.agri_districts', 'ayala')
                             ->where('farm_profiles.tenurial_status', 'tiller')
                             ->distinct()
                             ->count('farm_profiles.tenurial_status');
 
                             // Count lease tenants
                             $countLeaseTenants = DB::table('personal_informations')
                             ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                             ->where('farm_profiles.agri_districts', 'ayala')
                             ->where('farm_profiles.tenurial_status', 'lease')
                             ->distinct()
                             ->count('farm_profiles.tenurial_status');
                         // Count owner tenants
                     $countOwner = DB::table('personal_informations')
                     ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                     ->where('farm_profiles.agri_districts', 'ayala')
                     ->where('farm_profiles.tenurial_status', 'owner')
                     ->distinct()
                     ->count('farm_profiles.tenurial_status');
 
                     // total farmers organizattion
                     $countorg = DB::table('personal_informations')
                     ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                     ->where('farm_profiles.agri_districts', 'ayala')
                     ->distinct('personal_informations.nameof_farmers_ass_org_coop')
                     ->count('personal_informations.nameof_farmers_ass_org_coop');
 
 
                 // Calculate rice productivity in the Ayala district
                 $riceProductivityAyala = ($totalAreaPlantedAyala > 0) ? $totalRiceProductionAyala / $totalAreaPlantedAyala : 0;
 
                  // Assuming $personalinformation->date_of_birth contains the date of birth in "YYYY-MM-DD" format
      
             $totalAreaPlanted = FarmProfile::sum('total_physical_area');
             $totalAreaYield = FarmProfile::sum('yield_kg_ha');
             $totalCost= VariableCost::sum('total_variable_cost');
                 
             $yieldPerAreaPlanted = ($totalAreaPlantedAyala!= 0) ?  $totalAreaYieldAyala/ $totalAreaPlantedAyala : 0;
             $averageCostPerAreaPlanted = ($totalAreaPlantedAyala != 0) ? $totalVariableCostAyala / $totalAreaPlantedAyala : 0;
             $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
 
             // Return the view with the fetched data
             return view('admin.Agri_district.ayala_farmer', compact('admin', 'profile', 'farmProfile','FarmersData','totalRiceProduction',
             'totalfarms','totalAreaPlantedAyala','totalAreaYieldAyala',
             'totalFixedCostAyala','totalCost','yieldPerAreaPlanted','averageCostPerAreaPlanted',
             'totalMachineriesUsedAyala','totalVariableCostAyala','riceProductivityAyala',
             'countOwnerTenants','countTillerTenantTenants','countTillerTenants','countLeaseTenants','countOwner','countorg'));
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
 
//  tumaga farmers info view by admin


public function FarmerTumagainfo()
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

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

      

            // Fetch ayala farmers fetching  data
            $FarmersData = DB::table('personal_informations')
            ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
            ->select(
                'personal_informations.*',
                'farm_profiles.*',
                'fixed_costs.*',
                'machineries_useds.*',
                'variable_costs.*',
                'last_production_datas.*'
            )
            ->orderBy('personal_informations.id', 'desc') // Order by the ID of personal_informations table in descending order
            ->get();
            // Specify the agri district you want to filter by
                // Calculate the age for each farmer
                foreach ($FarmersData as $farmer) {
                    // Calculate the age for each farmer
                    $dateOfBirth = $farmer->date_of_birth;
                    $age = Carbon::parse($dateOfBirth)->age;

                    // Add the age to the farmer object
                    $farmer->age = $age;
                }
            // Count the number of farmers in the "ayala" district
            $totalfarms = DB::table('personal_informations')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->where('farm_profiles.agri_districts', 'tumaga')
            ->distinct()
            ->count('personal_informations.id');

              // Calculate the total area planted in the "tumaga" district
            $totalAreaPlantedAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'tumaga')
            ->sum('total_physical_area');
            $totalAreaYieldAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'tumaga')
            ->sum('yield_kg_ha');
         
             // Calculate the total fixed cost in the "tumaga" district
            $totalFixedCostAyala = DB::table('fixed_costs')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'fixed_costs.personal_informations_id')
            ->where('farm_profiles.agri_districts', 'tumaga')
            ->sum('fixed_costs.total_amount');
            
                  // Calculate the total machineries cost in the "tumaga" district
                  $totalMachineriesUsedAyala= DB::table('machineries_useds')
                  ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','machineries_useds.personal_informations_id')
                  ->where('farm_profiles.agri_districts', 'tumaga')
                  ->sum('machineries_useds.total_cost_for_machineries');

                // Calculate the total variable cost in the "tumaga" district
                $totalVariableCostAyala = DB::table('variable_costs')
                ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','variable_costs.personal_informations_id')
                ->where('farm_profiles.agri_districts', 'tumaga')
                ->sum('variable_costs.total_variable_cost');

                    // Calculate the total rice production in the Ayala district
                    $totalRiceProductionAyala = LastProductionDatas::join('farm_profiles', 'last_production_datas.personal_informations_id', '=', 'farm_profiles.personal_informations_id')
                    ->where('farm_profiles.agri_districtS', 'tumaga')
                    ->sum('last_production_datas.yield_tons_per_kg');


                              // Count owner tenants
                            $countOwnerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'tumaga')
                            ->where('farm_profiles.tenurial_status', 'owner')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenant tenants
                            $countTillerTenantTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'tumaga')
                            ->where('farm_profiles.tenurial_status', 'tiller tenant')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenants
                            $countTillerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'tumaga')
                            ->where('farm_profiles.tenurial_status', 'tiller')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count lease tenants
                            $countLeaseTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'tumaga')
                            ->where('farm_profiles.tenurial_status', 'lease')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');
                        // Count owner tenants
                    $countOwner = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'tumaga')
                    ->where('farm_profiles.tenurial_status', 'owner')
                    ->distinct()
                    ->count('farm_profiles.tenurial_status');

                    // total farmers organizattion
                    $countorg = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'tumaga')
                    ->distinct('personal_informations.nameof_farmers_ass_org_coop')
                    ->count('personal_informations.nameof_farmers_ass_org_coop');


                // Calculate rice productivity in the Ayala district
                $riceProductivityAyala = ($totalAreaPlantedAyala > 0) ? $totalRiceProductionAyala / $totalAreaPlantedAyala : 0;

                 // Assuming $personalinformation->date_of_birth contains the date of birth in "YYYY-MM-DD" format
     
            $totalAreaPlanted = FarmProfile::sum('total_physical_area');
            $totalAreaYield = FarmProfile::sum('yield_kg_ha');
            $totalCost= VariableCost::sum('total_variable_cost');
                
            $yieldPerAreaPlanted = ($totalAreaPlantedAyala!= 0) ?  $totalAreaYieldAyala/ $totalAreaPlantedAyala : 0;
            $averageCostPerAreaPlanted = ($totalAreaPlantedAyala != 0) ? $totalVariableCostAyala / $totalAreaPlantedAyala : 0;
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

            // Return the view with the fetched data
            return view('admin.Agri_district.tumaga_farmer', compact('admin', 'profile', 'farmProfile','FarmersData','totalRiceProduction',
            'totalfarms','totalAreaPlantedAyala','totalAreaYieldAyala',
            'totalFixedCostAyala','totalCost','yieldPerAreaPlanted','averageCostPerAreaPlanted',
            'totalMachineriesUsedAyala','totalVariableCostAyala','riceProductivityAyala',
            'countOwnerTenants','countTillerTenantTenants','countTillerTenants','countLeaseTenants','countOwner','countorg'));
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

// culianan rice farmers view by admin
            
public function FarmerCulianansInfo()
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

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

      

            // Fetch ayala farmers fetching  data
            $FarmersData = DB::table('personal_informations')
            ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
            ->select(
                'personal_informations.*',
                'farm_profiles.*',
                'fixed_costs.*',
                'machineries_useds.*',
                'variable_costs.*',
                'last_production_datas.*'
            )
            ->orderBy('personal_informations.id', 'desc') // Order by the ID of personal_informations table in descending order
            ->get();
            // Specify the agri district you want to filter by
                // Calculate the age for each farmer
                foreach ($FarmersData as $farmer) {
                    // Calculate the age for each farmer
                    $dateOfBirth = $farmer->date_of_birth;
                    $age = Carbon::parse($dateOfBirth)->age;

                    // Add the age to the farmer object
                    $farmer->age = $age;
                }
            // Count the number of farmers in the "ayala" district
            $totalfarms = DB::table('personal_informations')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->where('farm_profiles.agri_districts', 'culianan')
            ->distinct()
            ->count('personal_informations.id');

              // Calculate the total area planted in the "culianan" district
            $totalAreaPlantedAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'culianan')
            ->sum('total_physical_area');
            $totalAreaYieldAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'culianan')
            ->sum('yield_kg_ha');
         
             // Calculate the total fixed cost in the "culianan" district
            $totalFixedCostAyala = DB::table('fixed_costs')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'fixed_costs.personal_informations_id')
            ->where('farm_profiles.agri_districts', 'culianan')
            ->sum('fixed_costs.total_amount');
            
                  // Calculate the total machineries cost in the "culianan" district
                  $totalMachineriesUsedAyala= DB::table('machineries_useds')
                  ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','machineries_useds.personal_informations_id')
                  ->where('farm_profiles.agri_districts', 'culianan')
                  ->sum('machineries_useds.total_cost_for_machineries');

                // Calculate the total variable cost in the "culianan" district
                $totalVariableCostAyala = DB::table('variable_costs')
                ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','variable_costs.personal_informations_id')
                ->where('farm_profiles.agri_districts', 'culianan')
                ->sum('variable_costs.total_variable_cost');

                    // Calculate the total rice production in the Ayala district
                    $totalRiceProductionAyala = LastProductionDatas::join('farm_profiles', 'last_production_datas.personal_informations_id', '=', 'farm_profiles.personal_informations_id')
                    ->where('farm_profiles.agri_districtS', 'culianan')
                    ->sum('last_production_datas.yield_tons_per_kg');


                              // Count owner tenants
                            $countOwnerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'culianan')
                            ->where('farm_profiles.tenurial_status', 'owner')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenant tenants
                            $countTillerTenantTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'culianan')
                            ->where('farm_profiles.tenurial_status', 'tiller tenant')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenants
                            $countTillerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'culianan')
                            ->where('farm_profiles.tenurial_status', 'tiller')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count lease tenants
                            $countLeaseTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'culianan')
                            ->where('farm_profiles.tenurial_status', 'lease')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');
                        // Count owner tenants
                    $countOwner = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'culianan')
                    ->where('farm_profiles.tenurial_status', 'owner')
                    ->distinct()
                    ->count('farm_profiles.tenurial_status');

                    // total farmers organizattion
                    $countorg = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'culianan')
                    ->distinct('personal_informations.nameof_farmers_ass_org_coop')
                    ->count('personal_informations.nameof_farmers_ass_org_coop');


                // Calculate rice productivity in the Ayala district
                $riceProductivityAyala = ($totalAreaPlantedAyala > 0) ? $totalRiceProductionAyala / $totalAreaPlantedAyala : 0;

                 // Assuming $personalinformation->date_of_birth contains the date of birth in "YYYY-MM-DD" format
     
            $totalAreaPlanted = FarmProfile::sum('total_physical_area');
            $totalAreaYield = FarmProfile::sum('yield_kg_ha');
            $totalCost= VariableCost::sum('total_variable_cost');
                
            $yieldPerAreaPlanted = ($totalAreaPlantedAyala!= 0) ?  $totalAreaYieldAyala/ $totalAreaPlantedAyala : 0;
            $averageCostPerAreaPlanted = ($totalAreaPlantedAyala != 0) ? $totalVariableCostAyala / $totalAreaPlantedAyala : 0;
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

            // Return the view with the fetched data
            return view('admin.Agri_district.culianan_farmer', compact('admin', 'profile', 'farmProfile','FarmersData','totalRiceProduction',
            'totalfarms','totalAreaPlantedAyala','totalAreaYieldAyala',
            'totalFixedCostAyala','totalCost','yieldPerAreaPlanted','averageCostPerAreaPlanted',
            'totalMachineriesUsedAyala','totalVariableCostAyala','riceProductivityAyala',
            'countOwnerTenants','countTillerTenantTenants','countTillerTenants','countLeaseTenants','countOwner','countorg'));
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
        // manicahan famrers info view by admin
        public function FarmerManicahanInfo()
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
        
                    // Find the farm profile using the fetched farm ID
                    $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
        
              
        
                    // Fetch ayala farmers fetching  data
                    $FarmersData = DB::table('personal_informations')
                    ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
                    ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
                    ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
                    ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
                    ->select(
                        'personal_informations.*',
                        'farm_profiles.*',
                        'fixed_costs.*',
                        'machineries_useds.*',
                        'variable_costs.*',
                        'last_production_datas.*'
                    )
                    ->orderBy('personal_informations.id', 'desc') // Order by the ID of personal_informations table in descending order
                    ->get();
                    // Specify the agri district you want to filter by
                        // Calculate the age for each farmer
                        foreach ($FarmersData as $farmer) {
                            // Calculate the age for each farmer
                            $dateOfBirth = $farmer->date_of_birth;
                            $age = Carbon::parse($dateOfBirth)->age;
        
                            // Add the age to the farmer object
                            $farmer->age = $age;
                        }
                    // Count the number of farmers in the "ayala" district
                    $totalfarms = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'manicahan')
                    ->distinct()
                    ->count('personal_informations.id');
        
                      // Calculate the total area planted in the "manicahan" district
                    $totalAreaPlantedAyala = DB::table('farm_profiles')
                    ->where('agri_districts', 'manicahan')
                    ->sum('total_physical_area');
                    $totalAreaYieldAyala = DB::table('farm_profiles')
                    ->where('agri_districts', 'manicahan')
                    ->sum('yield_kg_ha');
                 
                     // Calculate the total fixed cost in the "manicahan" district
                    $totalFixedCostAyala = DB::table('fixed_costs')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'fixed_costs.personal_informations_id')
                    ->where('farm_profiles.agri_districts', 'manicahan')
                    ->sum('fixed_costs.total_amount');
                    
                          // Calculate the total machineries cost in the "manicahan" district
                          $totalMachineriesUsedAyala= DB::table('machineries_useds')
                          ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','machineries_useds.personal_informations_id')
                          ->where('farm_profiles.agri_districts', 'manicahan')
                          ->sum('machineries_useds.total_cost_for_machineries');
        
                        // Calculate the total variable cost in the "manicahan" district
                        $totalVariableCostAyala = DB::table('variable_costs')
                        ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','variable_costs.personal_informations_id')
                        ->where('farm_profiles.agri_districts', 'manicahan')
                        ->sum('variable_costs.total_variable_cost');
        
                            // Calculate the total rice production in the Ayala district
                            $totalRiceProductionAyala = LastProductionDatas::join('farm_profiles', 'last_production_datas.personal_informations_id', '=', 'farm_profiles.personal_informations_id')
                            ->where('farm_profiles.agri_districtS', 'culianan')
                            ->sum('last_production_datas.yield_tons_per_kg');
        
        
                                      // Count owner tenants
                                    $countOwnerTenants = DB::table('personal_informations')
                                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                                    ->where('farm_profiles.agri_districts', 'manicahan')
                                    ->where('farm_profiles.tenurial_status', 'owner')
                                    ->distinct()
                                    ->count('farm_profiles.tenurial_status');
        
                                    // Count tiller tenant tenants
                                    $countTillerTenantTenants = DB::table('personal_informations')
                                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                                    ->where('farm_profiles.agri_districts', 'manicahan')
                                    ->where('farm_profiles.tenurial_status', 'tiller tenant')
                                    ->distinct()
                                    ->count('farm_profiles.tenurial_status');
        
                                    // Count tiller tenants
                                    $countTillerTenants = DB::table('personal_informations')
                                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                                    ->where('farm_profiles.agri_districts', 'manicahan')
                                    ->where('farm_profiles.tenurial_status', 'tiller')
                                    ->distinct()
                                    ->count('farm_profiles.tenurial_status');
        
                                    // Count lease tenants
                                    $countLeaseTenants = DB::table('personal_informations')
                                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                                    ->where('farm_profiles.agri_districts', 'manicahan')
                                    ->where('farm_profiles.tenurial_status', 'lease')
                                    ->distinct()
                                    ->count('farm_profiles.tenurial_status');
                                // Count owner tenants
                            $countOwner = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'manicahan')
                            ->where('farm_profiles.tenurial_status', 'owner')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');
        
                            // total farmers organizattion
                            $countorg = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'manicahan')
                            ->distinct('personal_informations.nameof_farmers_ass_org_coop')
                            ->count('personal_informations.nameof_farmers_ass_org_coop');
        
        
                        // Calculate rice productivity in the Ayala district
                        $riceProductivityAyala = ($totalAreaPlantedAyala > 0) ? $totalRiceProductionAyala / $totalAreaPlantedAyala : 0;
        
                         // Assuming $personalinformation->date_of_birth contains the date of birth in "YYYY-MM-DD" format
             
                    $totalAreaPlanted = FarmProfile::sum('total_physical_area');
                    $totalAreaYield = FarmProfile::sum('yield_kg_ha');
                    $totalCost= VariableCost::sum('total_variable_cost');
                        
                    $yieldPerAreaPlanted = ($totalAreaPlantedAyala!= 0) ?  $totalAreaYieldAyala/ $totalAreaPlantedAyala : 0;
                    $averageCostPerAreaPlanted = ($totalAreaPlantedAyala != 0) ? $totalVariableCostAyala / $totalAreaPlantedAyala : 0;
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        
                    // Return the view with the fetched data
                    return view('admin.Agri_district.manicahan_farmer', compact('admin', 'profile', 'farmProfile','FarmersData','totalRiceProduction',
                    'totalfarms','totalAreaPlantedAyala','totalAreaYieldAyala',
                    'totalFixedCostAyala','totalCost','yieldPerAreaPlanted','averageCostPerAreaPlanted',
                    'totalMachineriesUsedAyala','totalVariableCostAyala','riceProductivityAyala',
                    'countOwnerTenants','countTillerTenantTenants','countTillerTenants','countLeaseTenants','countOwner','countorg'));
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
        // curuan farmers info view by admin

        
public function FarmercuruanInfo()
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

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

      

            // Fetch ayala farmers fetching  data
            $FarmersData = DB::table('personal_informations')
            ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
            ->select(
                'personal_informations.*',
                'farm_profiles.*',
                'fixed_costs.*',
                'machineries_useds.*',
                'variable_costs.*',
                'last_production_datas.*'
            )
            ->orderBy('personal_informations.id', 'desc') // Order by the ID of personal_informations table in descending order
            ->get();
            // Specify the agri district you want to filter by
                // Calculate the age for each farmer
                foreach ($FarmersData as $farmer) {
                    // Calculate the age for each farmer
                    $dateOfBirth = $farmer->date_of_birth;
                    $age = Carbon::parse($dateOfBirth)->age;

                    // Add the age to the farmer object
                    $farmer->age = $age;
                }
            // Count the number of farmers in the "ayala" district
            $totalfarms = DB::table('personal_informations')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->where('farm_profiles.agri_districts', 'curuan')
            ->distinct()
            ->count('personal_informations.id');

              // Calculate the total area planted in the "curuan" district
            $totalAreaPlantedAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'curuan')
            ->sum('total_physical_area');
            $totalAreaYieldAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'curuan')
            ->sum('yield_kg_ha');
         
             // Calculate the total fixed cost in the "curuan" district
            $totalFixedCostAyala = DB::table('fixed_costs')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'fixed_costs.personal_informations_id')
            ->where('farm_profiles.agri_districts', 'curuan')
            ->sum('fixed_costs.total_amount');
            
                  // Calculate the total machineries cost in the "curuan" district
                  $totalMachineriesUsedAyala= DB::table('machineries_useds')
                  ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','machineries_useds.personal_informations_id')
                  ->where('farm_profiles.agri_districts', 'curuan')
                  ->sum('machineries_useds.total_cost_for_machineries');

                // Calculate the total variable cost in the "curuan" district
                $totalVariableCostAyala = DB::table('variable_costs')
                ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','variable_costs.personal_informations_id')
                ->where('farm_profiles.agri_districts', 'curuan')
                ->sum('variable_costs.total_variable_cost');

                    // Calculate the total rice production in the Ayala district
                    $totalRiceProductionAyala = LastProductionDatas::join('farm_profiles', 'last_production_datas.personal_informations_id', '=', 'farm_profiles.personal_informations_id')
                    ->where('farm_profiles.agri_districtS', 'curuan')
                    ->sum('last_production_datas.yield_tons_per_kg');


                              // Count owner tenants
                            $countOwnerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'curuan')
                            ->where('farm_profiles.tenurial_status', 'owner')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenant tenants
                            $countTillerTenantTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'curuan')
                            ->where('farm_profiles.tenurial_status', 'tiller tenant')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenants
                            $countTillerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'curuan')
                            ->where('farm_profiles.tenurial_status', 'tiller')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count lease tenants
                            $countLeaseTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'curuan')
                            ->where('farm_profiles.tenurial_status', 'lease')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');
                        // Count owner tenants
                    $countOwner = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'curuan')
                    ->where('farm_profiles.tenurial_status', 'owner')
                    ->distinct()
                    ->count('farm_profiles.tenurial_status');

                    // total farmers organizattion
                    $countorg = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'curuan')
                    ->distinct('personal_informations.nameof_farmers_ass_org_coop')
                    ->count('personal_informations.nameof_farmers_ass_org_coop');


                // Calculate rice productivity in the Ayala district
                $riceProductivityAyala = ($totalAreaPlantedAyala > 0) ? $totalRiceProductionAyala / $totalAreaPlantedAyala : 0;

                 // Assuming $personalinformation->date_of_birth contains the date of birth in "YYYY-MM-DD" format
     
            $totalAreaPlanted = FarmProfile::sum('total_physical_area');
            $totalAreaYield = FarmProfile::sum('yield_kg_ha');
            $totalCost= VariableCost::sum('total_variable_cost');
                
            $yieldPerAreaPlanted = ($totalAreaPlantedAyala!= 0) ?  $totalAreaYieldAyala/ $totalAreaPlantedAyala : 0;
            $averageCostPerAreaPlanted = ($totalAreaPlantedAyala != 0) ? $totalVariableCostAyala / $totalAreaPlantedAyala : 0;
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

            // Return the view with the fetched data
            return view('admin.Agri_district.curuan_farmer', compact('admin', 'profile', 'farmProfile','FarmersData','totalRiceProduction',
            'totalfarms','totalAreaPlantedAyala','totalAreaYieldAyala',
            'totalFixedCostAyala','totalCost','yieldPerAreaPlanted','averageCostPerAreaPlanted',
            'totalMachineriesUsedAyala','totalVariableCostAyala','riceProductivityAyala',
            'countOwnerTenants','countTillerTenantTenants','countTillerTenants','countLeaseTenants','countOwner','countorg'));
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
        //vitalifarmers view by users
    
    

public function VitaliInfoFarmer()
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

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

      

            // Fetch ayala farmers fetching  data
            $FarmersData = DB::table('personal_informations')
            ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
            ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
            ->select(
                'personal_informations.*',
                'farm_profiles.*',
                'fixed_costs.*',
                'machineries_useds.*',
                'variable_costs.*',
                'last_production_datas.*'
            )
            ->orderBy('personal_informations.id', 'desc') // Order by the ID of personal_informations table in descending order
            ->get();
            // Specify the agri district you want to filter by
                // Calculate the age for each farmer
                foreach ($FarmersData as $farmer) {
                    // Calculate the age for each farmer
                    $dateOfBirth = $farmer->date_of_birth;
                    $age = Carbon::parse($dateOfBirth)->age;

                    // Add the age to the farmer object
                    $farmer->age = $age;
                }
            // Count the number of farmers in the "ayala" district
            $totalfarms = DB::table('personal_informations')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->where('farm_profiles.agri_districts', 'ayala')
            ->distinct()
            ->count('personal_informations.id');

              // Calculate the total area planted in the "vitali" district
            $totalAreaPlantedAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'vitali')
            ->sum('total_physical_area');
            $totalAreaYieldAyala = DB::table('farm_profiles')
            ->where('agri_districts', 'vitali')
            ->sum('yield_kg_ha');
         
             // Calculate the total fixed cost in the "vitali" district
            $totalFixedCostAyala = DB::table('fixed_costs')
            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'fixed_costs.personal_informations_id')
            ->where('farm_profiles.agri_districts', 'vitali')
            ->sum('fixed_costs.total_amount');
            
                  // Calculate the total machineries cost in the "vitali" district
                  $totalMachineriesUsedAyala= DB::table('machineries_useds')
                  ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','machineries_useds.personal_informations_id')
                  ->where('farm_profiles.agri_districts', 'vitali')
                  ->sum('machineries_useds.total_cost_for_machineries');

                // Calculate the total variable cost in the "vitali" district
                $totalVariableCostAyala = DB::table('variable_costs')
                ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=','variable_costs.personal_informations_id')
                ->where('farm_profiles.agri_districts', 'vitali')
                ->sum('variable_costs.total_variable_cost');

                    // Calculate the total rice production in the Ayala district
                    $totalRiceProductionAyala = LastProductionDatas::join('farm_profiles', 'last_production_datas.personal_informations_id', '=', 'farm_profiles.personal_informations_id')
                    ->where('farm_profiles.agri_districtS', 'vitali')
                    ->sum('last_production_datas.yield_tons_per_kg');


                              // Count owner tenants
                            $countOwnerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'vitali')
                            ->where('farm_profiles.tenurial_status', 'owner')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenant tenants
                            $countTillerTenantTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'vitali')
                            ->where('farm_profiles.tenurial_status', 'tiller tenant')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count tiller tenants
                            $countTillerTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'vitali')
                            ->where('farm_profiles.tenurial_status', 'tiller')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');

                            // Count lease tenants
                            $countLeaseTenants = DB::table('personal_informations')
                            ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                            ->where('farm_profiles.agri_districts', 'vitali')
                            ->where('farm_profiles.tenurial_status', 'lease')
                            ->distinct()
                            ->count('farm_profiles.tenurial_status');
                        // Count owner tenants
                    $countOwner = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'vitali')
                    ->where('farm_profiles.tenurial_status', 'owner')
                    ->distinct()
                    ->count('farm_profiles.tenurial_status');

                    // total farmers organizattion
                    $countorg = DB::table('personal_informations')
                    ->join('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                    ->where('farm_profiles.agri_districts', 'vitali')
                    ->distinct('personal_informations.nameof_farmers_ass_org_coop')
                    ->count('personal_informations.nameof_farmers_ass_org_coop');


                // Calculate rice productivity in the Ayala district
                $riceProductivityAyala = ($totalAreaPlantedAyala > 0) ? $totalRiceProductionAyala / $totalAreaPlantedAyala : 0;

                 // Assuming $personalinformation->date_of_birth contains the date of birth in "YYYY-MM-DD" format
     
            $totalAreaPlanted = FarmProfile::sum('total_physical_area');
            $totalAreaYield = FarmProfile::sum('yield_kg_ha');
            $totalCost= VariableCost::sum('total_variable_cost');
                
            $yieldPerAreaPlanted = ($totalAreaPlantedAyala!= 0) ?  $totalAreaYieldAyala/ $totalAreaPlantedAyala : 0;
            $averageCostPerAreaPlanted = ($totalAreaPlantedAyala != 0) ? $totalVariableCostAyala / $totalAreaPlantedAyala : 0;
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

            // Return the view with the fetched data
            return view('admin.Agri_district.vitali_farmer', compact('admin', 'profile', 'farmProfile','FarmersData','totalRiceProduction',
            'totalfarms','totalAreaPlantedAyala','totalAreaYieldAyala',
            'totalFixedCostAyala','totalCost','yieldPerAreaPlanted','averageCostPerAreaPlanted',
            'totalMachineriesUsedAyala','totalVariableCostAyala','riceProductivityAyala',
            'countOwnerTenants','countTillerTenantTenants','countTillerTenants','countLeaseTenants','countOwner','countorg'));
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


    // crop varietys per agri district access by admin

    // rice varieties per agri-district view by admin
    
public function FarmersRiceVarietyDistrict()
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

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

      

            // Fetch inbred variety data
            $inbredData = DB::table('personal_informations')
                ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                ->select(
                    'personal_informations.agri_district',
                    'farm_profiles.type_rice_variety',
                    'farm_profiles.prefered_variety'
                )
                ->orderBy('personal_informations.agri_district')
                ->get();

            // Group the data by district
            $InbredInfo = [];
            foreach ($inbredData as $data) {
                $typeVariety = $data->type_rice_variety;
                $preferedVariety = $data->prefered_variety;

                // If type of variety is "N/A", use preferred variety
                if (strtolower($typeVariety) === 'n/a' || strtolower($typeVariety) === 'na') {
                    $variety = $preferedVariety;
                } else {
                    $variety = $typeVariety;
                }

                if (!isset($InbredInfo[$data->agri_district][$variety])) {
                    $InbredInfo[$data->agri_district][$variety] = ['count' => 0, 'percentage' => 0];
                }

                $InbredInfo[$data->agri_district][$variety]['count']++;
            }

            // Calculate percentage for each rice variety in each district
            foreach ($InbredInfo as $district => &$varieties) {
                $totalRiceVarietiesInDistrict = array_sum(array_column($varieties, 'count'));
                foreach ($varieties as &$data) {
                    $percentage = ($totalRiceVarietiesInDistrict > 0) ? ($data['count'] / $totalRiceVarietiesInDistrict) * 100 : 0;
                    $data['percentage'] = number_format($percentage, 2);
                }
            }
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('admin.rice_varieties.rice_varietydistrict', compact('admin', 'profile', 'farmProfile', 'InbredInfo','totalRiceProduction'));
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

    public function Plantingschedrice(){
        try {
            $farmersData = DB::table('personal_informations')
                ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
                ->select(
                    'personal_informations.agri_district',
                    'last_production_datas.date_planted',
                    'farm_profiles.*',
                    'personal_informations.last_name',
                    'personal_informations.first_name',
                    'farm_profiles.type_rice_variety',
                    'farm_profiles.prefered_variety',
                )
                ->orderBy('personal_informations.agri_district')
                ->get();
    
            // Group the data by district
            $plantingSchedule = [];
            foreach ($farmersData as $data) {
                $plantingSchedule[$data->agri_district][] = [
                    'last_name' => $data->last_name,
                    'first_name' => $data->first_name,
                    'date_planted' => $data->date_planted,
                    'type_rice_variety' => $data->type_rice_variety,
                    'prefered_variety' => $data->prefered_variety,
                ];
            }
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            return view('admin.rice_schedule.rice_planting', compact('plantingSchedule','totalRiceProduction'));
        } catch (\Exception $ex) {
            // Log the exception for debugging purposes
            dd($ex);
            return redirect()->back()->with('message', 'Something went wrong');
        }
       
    }

    

    // rice harvest
    public function HarvestSchedRices(){
        try {
            $harvestData = DB::table('personal_informations')
            ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
                ->select(
                    'personal_informations.agri_district',
                    'personal_informations.last_name',
                    'personal_informations.first_name',
                    'last_production_datas.date_harvested',
                    'farm_profiles.type_rice_variety',
                    'farm_profiles.prefered_variety',
                    
                )
                ->orderBy('personal_informations.agri_district')
                ->get();
    
            // Group the data by district
            $harvestSchedule = [];
            foreach ($harvestData as $data) {
                $harvestSchedule[$data->agri_district][] = [
                    'last_name' => $data->last_name,
                    'first_name' => $data->first_name,
                    'date_harvested' => $data->date_harvested,
                    'type_rice_variety' => $data->type_rice_variety,
                    'prefered_variety' => $data->prefered_variety,
                ];
            }
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            return view('admin.rice_schedule.rice_harvest', compact('harvestSchedule','totalRiceProduction'));
        } catch (\Exception $ex) {
            // Log the exception for debugging purposes
            dd($ex);
            return redirect()->back()->with('message', 'Something went wrong');
        }
        
    }

    // crop production per district
   
    public function ProductionperRice()
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
    
                // Find the farm profile using the fetched farm ID
                $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
    
          
    
                // Fetch last production data  farmers fetching  data
                $riceProductionData = DB::table('personal_informations')
                ->leftJoin('farm_profiles', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                ->leftJoin('fixed_costs', 'fixed_costs.personal_informations_id', '=', 'personal_informations.id')
                ->leftJoin('machineries_useds', 'machineries_useds.personal_informations_id', '=', 'personal_informations.id')
                ->leftJoin('variable_costs', 'variable_costs.personal_informations_id', '=', 'personal_informations.id')
                    ->leftJoin('last_production_datas', 'last_production_datas.personal_informations_id', '=', 'personal_informations.id')
                    ->select(
                        'personal_informations.*',
                        'farm_profiles.*',
                        'fixed_costs.*',
                        'machineries_useds.*',
                        'variable_costs.*',
                        'personal_informations.agri_district',
                
                        'personal_informations.last_name',
                        'personal_informations.first_name',
                        'last_production_datas.date_planted',
                        'last_production_datas.date_harvested',
                        'last_production_datas.yield_tons_per_kg',
                        'last_production_datas.unit_price_palay_per_kg',
                        'last_production_datas.unit_price_rice_per_kg',
                        'last_production_datas.gross_income_palay',
                        'last_production_datas.gross_income_rice',
                        'last_production_datas.type_of_product'
                    )
                    // ->where('last_production_datas.type_of_product', 'rice',) // Filter for rice production only
                    ->orderBy('personal_informations.agri_district')
                    ->get();
        
                // Group the data by district
                $riceProductionSchedule = [];
                foreach ($riceProductionData as $data) {
                    $riceProductionSchedule[$data->agri_district][] = [
                        'last_name' => $data->last_name,
                        'first_name' => $data->first_name,
                        'date_planted' => $data->date_planted,
                        'date_harvested' => $data->date_harvested,
                        'yield_tons_per_kg' => $data->yield_tons_per_kg,
                        'unit_price_palay_per_kg' => $data->unit_price_palay_per_kg,
                        'unit_price_rice_per_kg' => $data->unit_price_rice_per_kg,
                        'gross_income_palay' => $data->gross_income_palay,
                        'gross_income_rice' => $data->gross_income_rice,
                        'type_of_product' => $data->type_of_product
                    ];
                }
                 // Initialize an array to store total rice production per district
            $totalRiceProductionPerDistrict = [];

            // Group the data by district and calculate total rice production per district
            foreach ($riceProductionData as $data) {
                $district = $data->agri_district;
                $riceProduction = $data->yield_tons_per_kg;

                // If the district is not already in the array, initialize it with the rice production
                if (!isset($totalRiceProductionPerDistrict[$district])) {
                    $totalRiceProductionPerDistrict[$district] = $riceProduction;
                } else {
                    // If the district is already in the array, add the rice production to the existing total
                    $totalRiceProductionPerDistrict[$district] += $riceProduction;
                }
            }
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('admin.crop_production.rice_crops', compact('admin', 'profile', 'farmProfile','totalRiceProduction',
               'riceProductionSchedule','totalRiceProductionPerDistrict'
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
    
    // multiple of data to database
    public function ExcelFile()
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

      

            
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.mutipleFile.import_excelFile', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
            
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
    // farmers report
    // public function FarmersReport(){
    //     $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
    //     return view
    // }


        // admin view corn map farmers
        public function CornMap(){
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

      

            
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('map.cornmap', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
            ,'userId'));
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

   // admin view coconut map farmers
   public function CoconutMap(){
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



    
    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
    // Return the view with the fetched data
    return view('map.coconutmap', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
    
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


   // admin view Chicken map farmers
   public function ChickenMap(){
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



    
    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
    // Return the view with the fetched data
    return view('map.chickenmap', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
    
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

   // admin view Hogs map farmers
   public function HogsMap(){
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



    
    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
    // Return the view with the fetched data
    return view('map.hogsmap', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
    
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


        // ADMIN CORN
          // admin view CORN REPORT/AGRIDISTRICT
   public function ayalaCorn(){
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



    
    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
    // Return the view with the fetched data
    return view('admin.corn.districtreport.ayala', compact('admin','userId', 'profile', 'farmProfile','totalRiceProduction'
    
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

        // admin view forms
              // ADMIN CORN
          // admin view CORN REPORT/AGRIDISTRIC


// // corn saving farmers info
// public function CornSave(Request $request)
//     {
      
//         try{
        
//           // Access the primary key of the PersonalInformations model instance

//     $existingPersonalInformations = PersonalInformations::where([
//         ['first_name', '=', $request->input('first_name')],
//         ['middle_name', '=', $request->input('middle_name')],
//         ['last_name', '=', $request->input('last_name')],
       
       
    
      
//         // Add other fields here
//     ])->first();
    
//     if ($existingPersonalInformations) {
//         // FarmProfile with the given personal_informations_id and other fields already exists
//         // You can handle this scenario here, for example, return an error message
//         return redirect('/add-personal-info')->with('error', 'Farm Profile with this information already exists.');
//     }
    
//     // $personalInformation= $request->validated();
//     // $personalInformation= $request->all();
//            $personalInformation= new PersonalInformations;
//         //    dd($request->all());
     
//   // Check if a file is present in the request and if it's valid
// if ($request->hasFile('image') && $request->file('image')->isValid()) {
//     // Retrieve the image file from the request
//     $image = $request->file('image');
    
//     // Generate a unique image name using current timestamp and file extension
//     $imagename = time() . '.' . $image->getClientOriginalExtension();
    
//     // Move the uploaded image to the 'personalInfoimages' directory with the generated name
//     $image->move('personalInfoimages', $imagename);
    
//     // Set the image name in the PersonalInformation model
//     $personalInformation->image = $imagename;
// } 
//             $personalInformation->users_id =$request->users_id;
//             $personalInformation->first_name= $request->first_name;
//             $personalInformation->middle_name= $request->middle_name;
//             $personalInformation->last_name=  $request->last_name;

//             if ($request->extension_name === 'others') {
//                 $personalInformation->extension_name = $request->add_extName; // Use the value entered in the "add_extenstion name" input field
//            } else {
//                 $personalInformation->extension_name = $request->extension_name; // Use the selected color from the dropdown
//            }
//             $personalInformation->country=  $request->country;
//             $personalInformation->province=  $request->province;
//             $personalInformation->city=  $request->city;
//             $personalInformation->agri_district=  $request->agri_district;
//             $personalInformation->barangay=  $request->barangay;
            
//              $personalInformation->home_address=  $request->home_address;
//              $personalInformation->sex=  $request->sex;

//              if ($request->religion=== 'other') {
//                 $personalInformation->religion= $request->add_Religion; // Use the value entered in the "religion" input field
//            } else {
//                 $personalInformation->religion= $request->religion; // Use the selected religion from the dropdown
//            }
//              $personalInformation->date_of_birth=  $request->date_of_birth;
            
//              if ($request->place_of_birth=== 'Add Place of Birth') {
//                 $personalInformation->place_of_birth= $request->add_PlaceBirth; // Use the value entered in the "place_of_birth" input field
//            } else {
//                 $personalInformation->place_of_birth= $request->place_of_birth; // Use the selected place_of_birth from the dropdown
//            }
//              $personalInformation->contact_no=  $request->contact_no;
//              $personalInformation->civil_status=  $request->civil_status;
//              $personalInformation->name_legal_spouse=  $request->name_legal_spouse;

//              if ($request->no_of_children=== 'Add') {
//                 $personalInformation->no_of_children= $request->add_noChildren; // Use the value entered in the "no_of_children" input field
//                 } else {
//                         $personalInformation->no_of_children= $request->no_of_children; // Use the selected no_of_children from the dropdown
//                 }
    
//              $personalInformation->mothers_maiden_name=  $request->mothers_maiden_name;
//              if ($request->highest_formal_education=== 'Other') {
//                 $personalInformation->highest_formal_education= $request->add_formEduc; // Use the value entered in the "highest_formal_education" input field
//                 } else {
//                         $personalInformation->highest_formal_education= $request->highest_formal_education; // Use the selected highest_formal_education from the dropdown
//                 }
//              $personalInformation->person_with_disability=  $request->person_with_disability;
//              $personalInformation->pwd_id_no=  $request->pwd_id_no;
//              $personalInformation->government_issued_id=  $request->government_issued_id;
//              $personalInformation->id_type=  $request->id_type;
//              $personalInformation->gov_id_no=  $request->gov_id_no;
//              $personalInformation->member_ofany_farmers_ass_org_coop=  $request->member_ofany_farmers_ass_org_coop;
             
//              if ($request->nameof_farmers_ass_org_coop === 'add') {
//                 $personalInformation->nameof_farmers_ass_org_coop = $request->add_FarmersGroup; // Use the value entered in the "add_extenstion name" input field
//            } else {
//                 $personalInformation->nameof_farmers_ass_org_coop = $request->nameof_farmers_ass_org_coop; // Use the selected color from the dropdown
//            }
//              $personalInformation->name_contact_person=  $request->name_contact_person;
      
//              $personalInformation->cp_tel_no=  $request->cp_tel_no;
//              $personalInformation->date_interview=  $request->date_interview;
//              $personalInformation->crop_type=  $request->crop_type;
//              $personalInformation->livestock_type=  $request->livestock_type;


        
//             dd($personalInformation);
//              $personalInformation->save();
//             return redirect('/admin-view-forms')->with('message',' Corn Personal informations Added successsfully');
        
//         }
//         catch(\Exception $ex){
//             // dd($ex); // Debugging statement to inspect the exception
//             return redirect('/admin-view-forms')->with('message','Please Try Again');
            
//         }   
        
// } 




public function CornSave(Request $request)
{
      // Farmer info
      $farmerdata = $request -> farm;
      $farmerModel = new FarmProfile();
      $farmerModel -> users_id = $farmerdata['users_id'];
      $farmerModel -> first_name = $farmerdata['first_name'];
      $farmerModel -> middle_name= $farmerdata['middle_name'];
      $farmerModel -> last_name= $farmerdata['last_name'];
      $farmerModel -> extension_name = $farmerdata['extension_name'];
      $farmerModel -> country= $farmerdata['country'];
      $farmerModel -> province= $farmerdata['province'];
      $farmerModel -> city = $farmerdata['city'];
      $farmerModel -> district= $farmerdata['district'];
      $farmerModel -> barangay= $farmerdata['barangay'];
      $farmerModel -> street= $farmerdata['street'];
      $farmerModel -> zip_code= $farmerdata['zip_code'];
      $farmerModel -> sex= $farmerdata['sex'];
      $farmerModel -> religion = $farmerdata['religion'];
      $farmerModel -> date_of_birth= $farmerdata['date_of_birth'];
      $farmerModel -> place_of_birth= $farmerdata['place_of_birth'];
      $farmerModel -> contact_no = $farmerdata['contact_no'];
      $farmerModel -> civil_status= $farmerdata['civil_status'];
      $farmerModel -> name_legal_spouse= $farmerdata['name_legal_spouse'];
      $farmerModel -> no_of_children = $farmerdata['no_of_children'];
      $farmerModel -> mothers_maiden_name= $farmerdata['mothers_maiden_name'];
      $farmerModel -> highest_formal_education= $farmerdata['highest_formal_education'];
      $farmerModel -> person_with_disability = $farmerdata['person_with_disability'];
      $farmerModel -> pwd_id_no= $farmerdata['pwd_id_no'];
      $farmerModel -> government_issued_id= $farmerdata['government_issued_id'];
      $farmerModel -> id_type = $farmerdata['id_type'];
      $farmerModel -> gov_id_no= $farmerdata['gov_id_no'];
      $farmerModel -> member_ofany_farmers_ass_org_coop= $farmerdata['member_ofany_farmers_ass_org_coop'];
      $farmerModel -> nameof_farmers_ass_org_coop = $farmerdata['nameof_farmers_ass_org_coop'];
      $farmerModel -> name_contact_person= $farmerdata['name_contact_person'];
      $farmerModel -> cp_tel_no= $farmerdata['cp_tel_no'];
      $farmerModel -> date_interview= $farmerdata['date_interview'];
      $farmerModel ->save();

       // Farm info
      $farms = $request -> farm;
      $farmModel = new FarmProfile();
      $farmModel -> users_id = $farms['users_id'];
      $farmModel -> agri_districts_id = $farms['agri_districts_id'];
      $farmModel -> personal_informations_id = $farms['farmer_id'];
      $farmModel -> polygons_id = $farms['polygons_id'];
      $farmModel -> agri_districts = $farms['agri_districts'];
      $farmModel -> tenurial_status = $farms['tenurial_status'];
      $farmModel -> farm_address = $farms['farm_address'];
      $farmModel -> no_of_years_as_farmers = $farms['no_of_years_as_farmers'];
      $farmModel -> gps_longitude = $farms['gps_longitude'];
      $farmModel -> gps_latitude = $farms['gps_latitude'];
      $farmModel -> total_physical_area = $farms['total_physical_area'];
      $farmModel -> total_area_cultivated = $farms['total_area_cultivated'];
      $farmModel -> land_title_no = $farms['land_title_no'];
      $farmModel -> lot_no = $farms['lot_no'];
      $farmModel -> area_prone_to = $farms['area_prone_to'];
      $farmModel -> ecosystem = $farms['ecosystem'];
      $farmModel -> rsba_registered = $farms['rsba_registered'];
      $farmModel -> pcic_insured = $farms['pcic_insured'];
      $farmModel -> government_assisted = $farms['government_assisted'];
      $farmModel -> source_of_capital = $farms['source_of_capital'];
      $farmModel -> remarks_recommendation = $farms['remarks_recommendation'];
         $farmModel -> oca_district_office = $farms['oca_district_office'];
         $farmModel -> name_of_field_officer_technician	 = $farms['name_of_field_officer_technician	'];
         $farmModel -> date_interviewed = $farms['date_interviewed'];

      $farmModel ->save();
     
      // Farm Id pass to crop
      $farmProfileId = $farmModel->id;
      // $farm = $request->input('farm', []);

      // $farmerModel = new FarmProfile();

      // return $farmerModel;

      // Crop info 

      foreach ($request -> crops as $crop) {
          $cropModel = new Crop();
          $cropModel -> farm_profiles_id = $farmProfileId;
          // $cropModel -> users_id = $farmer_id;
          $cropModel -> crop_name = $crop['crop_name'];
          $cropModel -> save();

         
      }
        // fetching crop id per then pass to production
      $cropId=$cropModel->id;

       //Production info 
      $productionData = $request -> productions;
      $productionModel = new FarmProfile();
      $productionModel -> users_id = $productionData['users_id'];
      $productionModel -> crops_farms_id = $productionData['crops_farms_id'];
   
      $productionModel -> seeds_typed_used = $productionData['seeds_typed_used'];
      $productionModel -> seeds_used_in_kg = $productionData['seeds_used_in_kg'];
      $productionModel -> seed_source = $productionData['seed_source'];
      $productionModel -> unit = $productionData['unit'];
      $productionModel -> no_of_fertilizer_used_in_bags = $productionData['no_of_fertilizer_used_in_bags'];
      $productionModel -> no_of_pesticides_used_in_l_per_kg = $productionData['no_of_pesticides_used_in_l_per_kg'];
      $productionModel -> no_of_insecticides_used_in_l = $productionData['no_of_insecticides_used_in_l'];
      $productionModel -> area_planted = $productionData['area_planted'];
      $productionModel -> date_planted = $productionData['date_planted'];
      $productionModel -> date_harvested = $productionData['date_harvested'];
      $productionModel -> yield_tons_per_kg = $productionData['yield_tons_per_kg'];
      $productionModel -> unit_price_palay_per_kg = $productionData['unit_price_palay_per_kg'];
      $productionModel -> unit_price_rice_per_kg = $productionData['unit_price_rice_per_kg'];
      $productionModel -> type_of_product = $productionData['type_of_product'];
      $productionModel -> sold_to = $productionData['sold_to'];
      $productionModel -> government_assisted = $productionData['government_assisted'];
      $productionModel -> source_of_capital = $productionData['source_of_capital'];
      $productionModel -> remarks_recommendation = $productionData['remarks_recommendation'];
         $productionModel -> oca_district_office = $productionData['oca_district_office'];
         $productionModel -> name_of_field_officer_technician	 = $productionData['name_of_field_officer_technician	'];
         $productionModel -> date_interviewed = $productionData['date_interviewed'];

      $productionModel ->save();





      // Return success message
      return [
          'success' => "Saved to database" // Corrected the syntax here
      ];
  }



    // patials form steps
     // farmers informations
     public function Getforms(){
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



        
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        // Return the view with the fetched data
        return view('admin.corn.forms.partials.forms-steps', compact('admin','userId' ,'profile', 'farmProfile','totalRiceProduction'
        
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



            // farmers informations
            public function FarmerInformations(){
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



                
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('admin.corn.farmersInfo.information', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                
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

            
            // farmers informations
            public function Varieties(){
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

               

                
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('admin.corn.variety.varieties', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                
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
            // admin view production
            public function Productions(){
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



                
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('admin.corn.production.reportsproduce', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                
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



            // barangay form add acces
            public function barangayForm(){
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
                $agriDistrict = AgriDistrict::all();
            
            
                
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('admin.barangay.add_form', compact('agriDistrict' ,'userId','admin', 'profile', 'farmProfile','totalRiceProduction'
                ,'userId'));
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


            public function newBarangay(Request $request)
            {
                try{
                
                    // $data= $request->validated([]);
                    // $data= $request->all();
        
                    
                    $barangay= new Barangay;
                    $barangay->users_id = $request->users_id;
                    $barangay->district =$request->district ;
                    $barangay->barangay_name =$request->barangay_name;
                   
                    // $barangay->altitude =$request->altitude;
                    $barangay->save();
                    return redirect('/admin-view-barangays')->with('message','barangay added successsfully');
                
                }
                catch(\Exception $ex){
                    dd($ex); // Debugging statement to inspect the exception
                    return redirect('/admin-view-barangays')->with('message','Someting went wrong');
                    
                }   
            }



                 // view barangay form access by admin

                 public function viewBaranagay(Request $request){
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
                // Query for labors with search functionality
                $barangaysQuery = Barangay::query();
                if ($request->has('search')) {
                    $searchTerm = $request->input('search');
                    $barangaysQuery->where(function($query) use ($searchTerm) {
                        $query->where('no_of_person', 'like', "%$searchTerm%")
                            ->orWhere('total_labor_cost', 'like', "%$searchTerm%")
                            ->orWhere('rate_per_person', 'like', "%$searchTerm%");
                    });
                }
                $barangays = $barangaysQuery->orderBy('id','asc')->paginate(10);
                // $productions = LastProductionDatas::with('personalinformation', 'farmprofile','agridistrict')
                // ->orderBy('id', 'asc');
                
                $agriDistrict = AgriDistrict::all();
                    
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    // Return the view with the fetched data
                    return view('admin.barangay.view_forms', compact('agriDistrict','barangays','userId','admin', 'profile', 'farmProfile','totalRiceProduction'
                    ,'userId'));
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


                    // view barangay form access by admin

                    public function EditBrgy($id){
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
                        
                    
                        $barangay= Barangay::find($id);
                        $agriDistrict = AgriDistrict::all();
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        // Return the view with the fetched data
                        return view('admin.barangay.edit_barangay', compact('agriDistrict','barangay','userId','admin', 'profile', 'farmProfile','totalRiceProduction'
                        ,'userId'));
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

                    public function updateBarangay(Request $request,$id)
                    {
                        try{
                        
                            // $data= $request->validated([]);
                            // $data= $request->all();
                
                            
                            $barangay= Barangay::find($id);
                            $barangay->users_id = $request->users_id;
                            $barangay->district =$request->district ;
                            $barangay->barangay_name =$request->barangay_name;
                           
                            // $barangay->altitude =$request->altitude;
                            // dd($barangay);
                            $barangay->save();
                            return redirect('/admin-view-barangays')->with('message','barangay updated successsfully');
                        
                        }
                        catch(\Exception $ex){
                            dd($ex); // Debugging statement to inspect the exception
                            return redirect('/admin-view-barangays')->with('message','Someting went wrong');
                            
                        }   
                    }
                    // delete baranay here below 
                    public function destroy(string $id)
                    {
                        try {
                            $barangay = Barangay::where('id', $id);
                        
                            if ($barangay) {
                                $barangay->delete();
                                return redirect()->route('admin.barangay.view_forms')
                                                 ->with('message', 'barangay data deleted successfully');
                            } else {
                                return redirect()->route('admin.barangay.view_forms')
                                                 ->with('message', 'barangay data not found');
                            }
                        } catch (\Exception $e) {
                            return redirect()->route('admin.barangay.view_forms')
                                             ->with('message', 'Error deleting barangay data : ' . $e->getMessage());
                        }
                    }
                    // end barangay



                        // view farmers org access by admin

                 public function addFamerOrg(){
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
                
                
                
                    $agriDistrict = AgriDistrict::all();
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    // Return the view with the fetched data
                    return view('admin.farmerOrg.add_org', compact('agriDistrict','userId','admin', 'profile', 'farmProfile','totalRiceProduction'
                    ,'userId'));
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


                public function saveFarmerOrg(Request $request
                )
                {
                    try{
                    
                        // $data= $request->validated([]);
                        // $data= $request->all();
            
                        
                        $barangay= new FarmerOrg;
                        $barangay->users_id = $request->users_id;
                        $barangay->district =$request->district;
                        $barangay->organization_name =$request->organization_name;
                       
                        // $barangay->altitude =$request->altitude;
                        // dd($barangay);
                        $barangay->save();
                        return redirect('/admin-view-farmer-org')->with('message','Farmer Organization updated successsfully');
                    
                    }
                    catch(\Exception $ex){
                        dd($ex); // Debugging statement to inspect the exception
                        return redirect('/admin-view-farmer-org')->with('message','Someting went wrong');
                        
                    }   
                }

                    // view farmers org form access by admin

                    public function viewfarmersOrg(Request $request){
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
                    
                        $FarmerOrgQuery = FarmerOrg::query();
                        if ($request->has('search')) {
                            $searchTerm = $request->input('search');
                            $FarmerOrgQuery->where(function($query) use ($searchTerm) {
                                $query->where('no_of_person', 'like', "%$searchTerm%")
                                    ->orWhere('total_labor_cost', 'like', "%$searchTerm%")
                                    ->orWhere('rate_per_person', 'like', "%$searchTerm%");
                            });
                        }
                        $FarmerOrg = $FarmerOrgQuery->orderBy('id','asc')->paginate(10);
                    
                        
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        // Return the view with the fetched data
                        return view('admin.farmerOrg.view_orgs', compact('FarmerOrg','userId','admin', 'profile', 'farmProfile','totalRiceProduction'
                        ,'userId'));
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


                        // view barangay form access by admin

                 public function EditOrg($id){
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
                
                    $farmerOrg = FarmerOrg::find($id);
                    $agriDistrict = AgriDistrict::all();
                    
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    // Return the view with the fetched data
                    return view('admin.farmerOrg.edit_org', compact('farmerOrg','userId','admin', 'profile', 
                    'farmProfile','totalRiceProduction','agriDistrict'
                    ,'userId'));
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

                
                public function updateFarmerOrg(Request $request,$id
                )
                {
                    try{
                    
                        // $data= $request->validated([]);
                        // $data= $request->all();
            
                        
                        $organization= FarmerOrg::find($id);
                        $organization->users_id = $request->users_id;
                        $organization->district =$request->district;
                        $organization->organization_name =$request->organization_name;
                       
                        // $organization->altitude =$request->altitude;
                        // dd($organization);
                        $organization->save();
                        return redirect('/admin-view-farmer-org')->with('message','Farmer Organization updated successsfully');
                    
                    }
                    catch(\Exception $ex){
                        // dd($ex); // Debugging statement to inspect the exception
                        return redirect('/admin-view-farmer-org')->with('message','Someting went wrong');
                        
                    }   
                }

                                            // deleting personal informations
                        public function deleteFarmerOrg($id) {
                            try {
                                // Find the personal information by ID
                                $organization = FarmerOrg::find($id);

                                // Check if the personal information exists
                                if (!$organization) {
                                    return redirect()->back()->with('error', 'Farmer Organization not found');
                                }

                                // Delete the personal information data from the database
                                $organization->delete();

                                // Redirect back with success message
                                return redirect()->back()->with('message', 'Farmer Organization deleted successfully');

                            } catch (\Exception $e) {
                                // Handle any exceptions and redirect back with error message
                                return redirect()->back()->with('error', 'Error deleting Farmer Organization: ' . $e->getMessage());
                            }
                        }




        // view the personalinfo by admin
        public function GenFarmers(Request $request)
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
        
                    // Fetch all personal information
                    $personalinfos = PersonalInformations::orderBy('id', 'asc');
        
                    // Search functionality
                    if ($request->has('search')) {
                        $keyword = $request->input('search');
                        $personalinfos->where(function ($query) use ($keyword) {
                            $query->where('last_name', 'like', "%$keyword%")
                                  ->orWhere('first_name', 'like', "%$keyword%");
                            // Add more search filters as needed
                        });
                    }
        
                    // Paginate the results
                    $personalinfos = $personalinfos->paginate(4);

                     // Fetch all farm profiles with their associated personal information and agricultural districts
                        $farmProfiles = FarmProfile::select('farm_profiles.*')
                        ->leftJoin('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                        ->with('agriDistrict')
                        ->orderBy('farm_profiles.id', 'asc');

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

                      // Query for fixed costs with eager loading of related models
                    $fixedcosts = FixedCost::with('personalinformation', 'farmprofile')
                    ->orderBy('id', 'asc');

                    // Apply search functionality
                    if ($request->has('search')) {
                        $keyword = $request->input('search');
                        $fixedcosts->where(function ($query) use ($keyword) {
                            $query->whereHas('personalinformation', function ($query) use ($keyword) {
                                $query->where('last_name', 'like', "%$keyword%")
                                    ->orWhere('first_name', 'like', "%$keyword%");
                            });
                        });
                    }

                    // Paginate the results
                    $fixedcosts = $fixedcosts->paginate(20);

                      // Query for fixed costs with eager loading of related models
                            $machineries = MachineriesUseds::with('personalinformation', 'farmprofile')
                            ->orderBy('id', 'asc');

                        // Apply search functionality
                        if ($request->has('search')) {
                            $keyword = $request->input('search');
                            $machineries->where(function ($query) use ($keyword) {
                                $query->whereHas('personalinformation', function ($query) use ($keyword) {
                                    $query->where('last_name', 'like', "%$keyword%")
                                        ->orWhere('first_name', 'like', "%$keyword%");
                                });
                            });
                        }

                        // Paginate the results
                        $machineries = $machineries->paginate(20);

                            // Query for variable cost with search functionality
                                $variable = VariableCost::with('personalinformation', 'farmprofile','seeds','labors','fertilizers','pesticides','transports')
                                ->orderBy('id', 'asc');
                
                            // Apply search functionality
                            if ($request->has('search')) {
                                $keyword = $request->input('search');
                                $variable->where(function ($query) use ($keyword) {
                                    $query->whereHas('personalinformation', function ($query) use ($keyword) {
                                        $query->where('last_name', 'like', "%$keyword%")
                                            ->orWhere('first_name', 'like', "%$keyword%");
                                    });
                                });
                            }
                
                            // Paginate the results
                            $variable = $variable->paginate(20);

                            // Query for fixed costs with eager loading of related models


                            $productions = LastProductionDatas::with('personalinformation', 'farmprofile','agridistrict')
                            ->orderBy('id', 'asc');

                        // Apply search functionality
                        if ($request->has('search')) {
                            $keyword = $request->input('search');
                            $productions->where(function ($query) use ($keyword) {
                                $query->whereHas('personalinformation', function ($query) use ($keyword) {
                                    $query->where('last_name', 'like', "%$keyword%")
                                        ->orWhere('first_name', 'like', "%$keyword%");
                                });
                            });
                        }

                        // Paginate the results
                        $productions = $productions->paginate(20);

                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    // Return the view with the fetched data
                    return view('admin.farmersdata.genfarmers', compact('admin', 'profile', 'personalinfos','farmProfiles','fixedcosts','machineries','variable','productions','totalRiceProduction'));
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
}
