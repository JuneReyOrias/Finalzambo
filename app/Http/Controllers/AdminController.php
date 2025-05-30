<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParcellaryBoundariesRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\FarmProfile;

use App\Models\Polygon;
use App\Models\Fertilizer;
use App\Models\FixedCost;
use App\Models\Labor;
use App\Models\FarmerOrg;
use App\Models\Farmer;
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
use Illuminate\Response;
use App\Models\User;
use App\Models\CropParcel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Notifications\UserDataUpdated;
use App\Notifications\AgentAddedNewData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

// update the password

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8', // Add more validation rules as needed
        ]);
    
        $user = User::find($request->id);
    
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
    
            return response()->json(['message' => 'Password updated successfully']);
        }
    
        return response()->json(['error' => 'User not found'], 404);
    }
    

//farmers data multiple delete
public function multipleDeletefarmers(Request $request)
{
    $ids = $request->input('ids');

    if (empty($ids)) {
        return response()->json(['message' => 'No records selected'], 400);
    }

    // Assuming 'YourModel' is the model associated with the data
    // Replace 'YourModel' with the actual model you're using
    PersonalInformations::whereIn('id', $ids)->delete();

    return response()->json(['message' => 'Selected records have been deleted successfully']);
}



// Variable cost multiple delete
public function multipleDeleteSoldscost(Request $request)
{
    $ids = $request->input('ids');

    if (empty($ids)) {
        return response()->json(['message' => 'No records selected'], 400);
    }

    // Assuming 'YourModel' is the model associated with the data
    // Replace 'YourModel' with the actual model you're using
    VariableCost::whereIn('id', $ids)->delete();

    return response()->json(['message' => 'Selected records have been deleted successfully']);
}

 // Variable cost multiple delete
 public function multipleDeleteVariablecost(Request $request)
 {
     $ids = $request->input('ids');
 
     if (empty($ids)) {
         return response()->json(['message' => 'No records selected'], 400);
     }
 
     // Assuming 'YourModel' is the model associated with the data
     // Replace 'YourModel' with the actual model you're using
     VariableCost::whereIn('id', $ids)->delete();
 
     return response()->json(['message' => 'Selected records have been deleted successfully']);
 }
 // Machineries cost multiple delete
 public function multipleDeleteMachineries(Request $request)
 {
     $ids = $request->input('ids');
 
     if (empty($ids)) {
         return response()->json(['message' => 'No records selected'], 400);
     }
 
     // Assuming 'YourModel' is the model associated with the data
     // Replace 'YourModel' with the actual model you're using
     MachineriesUseds::whereIn('id', $ids)->delete();
 
     return response()->json(['message' => 'Selected records have been deleted successfully']);
 }
// fixed cost multiple delete
 public function multipleDeleteFixedCost(Request $request)
 {
     $ids = $request->input('ids');
 
     if (empty($ids)) {
         return response()->json(['message' => 'No records selected'], 400);
     }
 
     // Assuming 'YourModel' is the model associated with the data
     // Replace 'YourModel' with the actual model you're using
     FixedCost::whereIn('id', $ids)->delete();
 
     return response()->json(['message' => 'Selected records have been deleted successfully']);
 }
// production multiple delete
public function multipleDelete(Request $request)
{
    $ids = $request->input('ids');

    if (empty($ids)) {
        return response()->json(['message' => 'No records selected'], 400);
    }

    // Assuming 'YourModel' is the model associated with the data
    // Replace 'YourModel' with the actual model you're using
    LastProductionDatas::whereIn('id', $ids)->delete();

    return response()->json(['message' => 'Selected records have been deleted successfully']);
}
 public function updateCropLocation(Request $request)
 {
     // Validate incoming data
     $request->validate([
         'user_id' => 'required|exists:users,id', // Ensure the user_id exists in the users table
         'crops_farms_id' => 'required|exists:crops_farms,id' // Ensure the crops_farms_id exists
     ]);
 
 
     // Update the farm profile with the new user_id
     $CropFarmLocation = Crop::findOrFail($request->crops_farms_id);
     $CropFarmLocation->users_id = $request->user_id;
     $CropFarmLocation->save();
 
     // // Send a notification to the user about the update
     $user = $CropFarmLocation->user; // Access the user through the relationship
     if ($user) {
         $user->notify(new AgentAddedNewData($CropFarmLocation));
     } else {
         return response()->json([
             'success' => false,
             'message' => 'User not found for the specified crop location.',
         ], 404);
     }
     // Return a success response
     return response()->json([
         'success' => true,
         'message' => 'Crop farms Location updated successfully! The Agent has been notified.'
     ]);
 }

// admin update assign farm farmers profile based on users register
public function AdminupdateFarmProfile(Request $request)
{
    // Validate incoming data
    $request->validate([
        'user_id' => 'required|exists:users,id', // Ensure the user_id exists in the users table
        'farm_profile_id' => 'required|exists:farm_profiles,id' // Ensure the farm_profile_id exists
    ]);

    // Check if the user_id is already associated with another farm profile
    $existingProfile = FarmProfile::where('users_id', $request->user_id)
                                   ->where('id', '!=', $request->farm_profile_id)
                                   ->first();

    if ($existingProfile) {
        // Respond with a failure message if the user is already associated with another farm profile
        return response()->json([
            'success' => false,
            'message' => 'The selected user is already associated with another farm profile. Please choose a different user.'
        ]);
    }

    // Update the farm profile with the new user_id
    $farmProfile = FarmProfile::findOrFail($request->farm_profile_id);
    $farmProfile->users_id = $request->user_id;
    $farmProfile->save();

    // Send a notification to the user about the update
    $user = $farmProfile->user; // Assuming you have a relation to the User model
    $user->notify(new UserDataUpdated($farmProfile));

    // Return a success response
    return response()->json([
        'success' => true,
        'message' => 'Farm profile updated successfully! The user has been notified.'
    ]);
}

    // admin log out

        public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
   
 // Function to create a new polygon record, storing the geographic boundaries or shape data associated with the map or farmer location.

    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'coordinates' => 'required|array',
           
          
        ]);

        // Create the polygon record
        $polygon = new CropParcel();
        $polygon->coordinates = json_encode($request->coordinates); // Save as JSON
        $polygon->polygon_name = $request->polygonName;
        $polygon->area = $request->area;
        $polygon->altitude = $request->altitude;
        $polygon->strokecolor = $request->strokecolor;
        $polygon->save();

        // Return a response to the frontend
        
        return response()->json(['success' => true, 'polygon_id' => $polygon->id]);
    }
        
    // Function to retrieve all relevant data for the admin dashboard,
    //  including statistics and records, and pass the data to the dashboard view for display.
 
    public function adminDashb(Request $request)
    {

     
        if (Auth::check()) {
            $userId = Auth::id();
            $admin = User::find($userId);
    
            if ($admin) {
                // Fetch distinct crops and districts from the database
                $crops = Crop::distinct()->pluck('crop_name');
                $districts = AgriDistrict::distinct()->pluck('district');
                $personalInformationId = $request->input('personal_informations_id');
             
                // Initialize variables for dashboard totals
                $totalFarms = 0;
                $totalAreaPlanted = 0;
                $totalAreaYield = 0;
                $totalCost = 0;
                $yieldPerAreaPlanted = 0;
                $averageCostPerAreaPlanted = 0;
                $totalRiceProduction = 0;
                $totalYieldsPerDistrict = []; // To hold total yields per district
    
                // Check if it's an AJAX request
                if ($request->ajax()) {
                    // Validate incoming request data
                    $request->validate([
                        'crop_name' => 'nullable|string',
                        'dateFrom' => 'nullable|date',
                        'dateTo' => 'nullable|date',
                        'district' => 'nullable|string',
                    ]);
    
                    // Fetch selected filters
                    $selectedCropName = $request->input('crop_name', '');
                    $selectedDateFrom = $request->input('dateFrom', '');
                    $selectedDateTo = $request->input('dateTo', '');
                    $selectedDistrict = $request->input('district', '');
    
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
                    $totalRiceProduction = $totalRiceProductionInKg / 1000; // Convert to tons
    
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
                    
                    // Loop through crop farms
                    foreach ($cropFarms as $cropFarm) {
                        // Get district name or default to 'Not specified'
                        $districtName = $cropFarm->farmProfile->agriDistrict->district ?? 'Not specified';
                        
                        // Get the crop name or 'Not specified' if not available
                        $cropName = $cropFarm->crop_name ?? 'Not specified';
                    
                        // Filter by selected district (skip if doesn't match and not "All")
                        if ($selectedDistrict && $selectedDistrict !== 'All' && $districtName !== $selectedDistrict) {
                            continue;
                        }
                    
                        // Filter by selected crop (skip if doesn't match and not "All")
                        if ($selectedCropName && $selectedCropName !== 'All' && $cropName !== $selectedCropName) {
                            continue;
                        }
                    
                        // Initialize district data if not already set
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
                    
                        // Loop through production data
                        foreach ($cropFarm->lastProductionData as $productionData) {
                            $harvestDate = $productionData->date_harvested;
                            $yield = $productionData->yield_tons_per_kg;
                    
                            // Filter by date range if specified
                            if ($selectedDateFrom && $selectedDateTo && 
                                ($selectedDateFrom !== 'All' && $selectedDateTo !== 'All') &&
                                ($harvestDate < $selectedDateFrom || $harvestDate > $selectedDateTo)) {
                                continue; // Skip if the harvest date is outside the selected date range
                            }
                    
                            // Accumulate yield per district
                            $yieldPerDistrict[$districtName] += $yield;
                            $dateRange[] = $harvestDate;
                        }
                    
                        // Count the type of variety planted
                        $typeOfVarietyPlanted = $cropFarm->type_of_variety_planted ?? 'Not specified';
                    
                        if (!isset($typeVarietyCountsPerDistrict[$districtName][$typeOfVarietyPlanted])) {
                            $typeVarietyCountsPerDistrict[$districtName][$typeOfVarietyPlanted] = 0;
                        }
                    
                        $typeVarietyCountsPerDistrict[$districtName][$typeOfVarietyPlanted]++;
                    }
                    
                 // Prepare data for pie chart (crops)
                        $pieChartData = [
                            'labels' => array_keys($yieldPerDistrict),
                            'datasets' => [[
                                'data' => array_values($yieldPerDistrict),
                                'backgroundColor' => ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'], // Add more colors as needed
                                'hoverBackgroundColor' => ['#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'], // Add more hover colors if needed
                            ]]
                        ];



                         // Calculate total production for each crop
                $totalProduction = [];
                foreach ($crops as $crop) {
                    $cropProductionQuery = LastProductionDatas::whereHas('cropFarms.crop', function ($query) use ($crop) {
                        $query->where('crop_name', $crop);
                    });

                    if ($selectedDistrict) {
                        $cropProductionQuery->whereHas('cropFarms.farmProfile.agriDistrict', function ($query) use ($selectedDistrict) {
                            $query->where('district', $selectedDistrict);
                        });
                    }

                    $totalProduction[$crop] = $cropProductionQuery->sum('yield_tons_per_kg') / 100000
                    ; // In tons
                }

                // Prepare data for donut chart
                $donutChartData = [
                    'labels' => array_keys($totalProduction),
                    'datasets' => [[
                        'data' => array_values($totalProduction),
                        'backgroundColor' => [ '#009e2e', '#FFCE56','#e3004d', '#4BC0C0', '#9966FF', '#FF9F40','#ff0000'],
                        'hoverBackgroundColor' => [ '#009e2e', '#FFCE56','#e3004d', '#4BC0C0', '#9966FF', '#FF9F40','#ff0000'],
                    ]],
                ];

                $barChartLabels = [];
                $barChartValuesByDistrict = []; // Group values by district
                $varietiesPerDistrict = [];
                
                // Assuming you have a variable for the crop name
                $cropName = $selectedCropName; // Make sure this is set appropriately
                
                // Initialize an array to hold the dataset for each district
                $districts = array_keys($typeVarietyCountsPerDistrict);
                
                // Show data for selected district or all districts
                if ($selectedDistrict && $selectedDistrict !== 'All') {
                    $districts = [$selectedDistrict]; // Only include the selected district
                }
                
                foreach ($districts as $district) {
                    if (isset($typeVarietyCountsPerDistrict[$district])) {
                        $varieties = $typeVarietyCountsPerDistrict[$district];
                        $barChartValuesByDistrict[$district] = [];
                        
                        foreach ($varieties as $variety => $count) {
                            if (!in_array($variety, $barChartLabels)) {
                                $barChartLabels[] = $variety;
                            }
                            // Initialize the count for this variety in the district
                            $barChartValuesByDistrict[$district][$variety] = $count;
                        }
                    }
                }
                
                // Prepare datasets for the chart
                $datasets = [];
                foreach ($districts as $district) {
                    $data = [];
                    foreach ($barChartLabels as $variety) {
                        // Populate the data array for each variety
                        $data[] = isset($barChartValuesByDistrict[$district][$variety]) ? $barChartValuesByDistrict[$district][$variety] : 0;
                    }
                    
                    // Create a dataset for each district
                    $datasets[] = [
                        'label' => "{$district} - {$cropName}", // District and crop name as legend label
                        'data' => $data,
                        'backgroundColor' => '#' . substr(md5(rand()), 0, 6), // Generate a random color for each district
                        'borderColor' => '#' . substr(md5(rand()), 0, 6), // Border color
                        'borderWidth' => 1,
                        'varieties' => $barChartLabels // Include varieties for tooltip display
                    ];
                }
                
                // Prepare the final data structure for the bar chart
                $barChartData = [
                    'labels' => $barChartLabels,
                    'datasets' => $datasets // Use the datasets array
                ];
                

// Prepare tenurial status data
$tenurialStatusCounts = $farmProfilesQuery->select('tenurial_status', DB::raw('count(*) as count'))
->groupBy('tenurial_status')
->get();

// Structure the tenurial status data for the radial chart
$tenurialStatusData = [];
foreach ($tenurialStatusCounts as $statusCount) {
$tenurialStatusData[$statusCount->tenurial_status] = $statusCount->count;
}

// Prepare data for radial chart
$radialChartData = [
'labels' => array_keys($tenurialStatusData), // Tenurial status labels
'datasets' => [
    [
        'label' => '', // Label for the dataset
        'data' => array_values($tenurialStatusData), // Corresponding counts
        'backgroundColor' => [
           '#ff0000', '#55007f', '#e3004d', '#ff00ff', '#ff5500', '#00aa00', '#008FFB'
        ],
        'hoverOffset' => 4 // Optional hover effect
    ]
]
];

// Fetch district names
$farmProfilesQuery = FarmProfile::query();

// Get the distribution frequency
$distributionFrequency = $farmProfilesQuery
    ->select('agri_districts', DB::raw('count(*) as total'))
    ->groupBy('agri_districts')
    ->pluck('total', 'agri_districts');

// // Get the total count of farms
// $totalFarms = $farmProfilesQuery->count();
$district = AgriDistrict::whereIn('id', $distributionFrequency->keys())->pluck('district', 'id');

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



   // Adjust this query as per your application logic
   $farmProfilesQuery = FarmProfile::query(); // Adjust the model if necessary

   // Calculate the total area planted per district
   $totalAreaPlantedPerDistrict = $farmProfilesQuery
       ->select('agri_districts_id', DB::raw('SUM(total_physical_area) AS total_area_planted'))
       ->groupBy('agri_districts_id')
       ->pluck('total_area_planted', 'agri_districts_id');

   // Fetch district names for the calculated totals
   $districtNames = AgriDistrict::whereIn('id', $totalAreaPlantedPerDistrict->keys())
       ->pluck('district', 'id');

   // Combine the district names with their respective total area planted
   $totalAreaPlantedByDistrict = $districtNames->map(function ($districtName, $districtId) use ($totalAreaPlantedPerDistrict) {
       return [
           'district' => $districtName,
           'total_area_planted' => $totalAreaPlantedPerDistrict[$districtId],
       ];
   })->values(); // Use values() to re-index the array

   
    // Fetch total variable costs with created_at timestamps
    $variableCostsQuery = VariableCost::query()
        ->select('total_variable_cost', 'created_at')
        ->when($dateRange === 'last_month', function ($query) {
            return $query->where('created_at', '>=', now()->subMonth());
        })
        ->when($dateRange === 'last_year', function ($query) {
            return $query->where('created_at', '>=', now()->subYear());
        })
        ->get();

    // Prepare data for response
    $totalVariableCosts = $variableCostsQuery->pluck('total_variable_cost');
    $timestamps = $variableCostsQuery->pluck('created_at')->map(function ($date) {
        return $date->format('F-Y'); // Format the date to show year and full month name
    }); // Filter out duplicate entries
    

// In your controller method

// Initialize the variable cost query
$variableCostQuery = VariableCost::query();

// Apply filtering based on selected crop name
if ($selectedCropName) {
    $variableCostQuery->whereHas('lastProductionData.cropFarms.crop', function ($query) use ($selectedCropName) {
        $query->where('crop_name', $selectedCropName);
    });
}

// Apply filtering based on selected district
if ($selectedDistrict) {
    $variableCostQuery->whereHas('lastProductionData.cropFarms.farmProfile.agriDistrict', function ($query) use ($selectedDistrict) {
        $query->where('district', $selectedDistrict);
    });
}

// Apply filtering based on date range
if ($selectedDateFrom && $selectedDateTo) {
    $variableCostQuery->whereHas('lastProductionData', function ($query) use ($selectedDateFrom, $selectedDateTo) {
        $query->whereBetween('date_harvested', [$selectedDateFrom, $selectedDateTo]);
    });
}

// Query to calculate total costs grouped by year
$totalCostByYear = $variableCostQuery->selectRaw('YEAR(created_at) as year, SUM(total_variable_cost) as total_cost')
    ->groupBy('year')
    ->orderBy('year') // Order by year to ensure correct timeline
    ->get();

// Prepare the data for the chart
$years = [];
$totalCosts = [];

foreach ($totalCostByYear as $cost) {
    $years[] = $cost->year;
    $totalCosts[] = $cost->total_cost;
}



// Return the data as JSON for AJAX requests
return response()->json([
    
    'farmersTable' => view('admin.partials.farmers_table', ['paginatedFarmers' => $paginatedFarmers])->render(),
    'paginationLinks' => view('admin.partials.pagination', ['paginatedFarmers' => $paginatedFarmers])->render(),
    'totalFarms' => $totalFarms,
    'totalAreaPlanted' => $totalAreaPlanted,
    'totalAreaYield' => $totalAreaYield,
    'totalCost' => $totalCost,
    'yieldPerAreaPlanted' => $yieldPerAreaPlanted,
    'averageCostPerAreaPlanted' => $averageCostPerAreaPlanted,
    'totalRiceProduction' => $totalRiceProduction,
    'pieChartData' => $pieChartData,
    'radialChartData' => $radialChartData,
    'donutChartData' => $donutChartData, // Include donut chart data
    'barChartLabels' => $barChartLabels,
    'barChartData' => $barChartData,
    'crops' => $crops,
    'districts' => $districts,
    'totalAreaPlantedByDistrict'=>$totalAreaPlantedByDistrict,
    'distributionFrequency' => $distributionFrequency,
    'district' => $district,
    'totalVariableCosts' => $totalVariableCosts,
    'timestamps' => $timestamps,
    'years' => $years,
    'totalCosts' => $totalCosts,
//    '$totalVariableCostsByDistrict'=>$$totalVariableCostsByDistrict

    // Include other necessary data here
]);

                }
    
                // Pass all data to the view
                return view('admin.index', compact(
                    'totalFarms',
                    'totalAreaPlanted',
                    'totalAreaYield',
                    'totalCost',
                    'yieldPerAreaPlanted',
                    'averageCostPerAreaPlanted',
                    'totalRiceProduction',
                    'crops',
                    'admin',
                    'districts',
              
                   
                
                 
                ));
            }
    
            return redirect()->back()->with('error', 'Admin not found.');
          
        }
    
        return redirect()->route('login')->with('error', 'You need to log in first.');
        
    }
    
// Method to check if resources exist
protected function resourcesExist($cropName, $district)
{
    $cropExists = Crop::where('crop_name', $cropName)->exists();
    $districtExists = AgriDistrict::where('district', $district)->exists();
    return $cropExists && $districtExists;
}

 
// Function to handle updating the profile data. It retrieves the existing profile information, allows modifications, 
// and saves the updated data to the database to reflect the changes in the user’s profile.

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
   
    //    $data->name= $request->name;
    //    $data->email= $request->email;
    //    $data->agri_district= $request->agri_district;
    //    $data->password= $request->password;
    //    $data->role= $request->role;
    
        
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





   
 // Function to save new parcel borders, storing the geographic boundaries or shape data for each parcel in the database.

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


// If the request expects JSON, return mapdata as a JSON response
// if (request()->wantsJson()) {
//     return response()->json($parceldata);
// }
     
               // Return the view with the fetched data
               return view('parcels.new_parcels', compact('agri_districts', 'agri_districts_id',
                'admin', 'profile','totalRiceProduction','userId','mapdata','parceldata'));
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

// CRUD operations for managing parcel data:
// - Create: Adds new parcel records, including geographic boundaries and parcel details, to the database.
// - Read: Retrieves and displays parcel data for analysis, reporting, or mapping purposes.
// - Update: Modifies existing parcel records based on updated information (e.g., boundaries, ownership, or parcel details).
// - Delete: Removes parcel records from the database when no longer needed or relevant.


public function Parcel(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'coordinates' => 'required|array',
    ]);

    // Create the polygon record
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
    $parcel->coordinates = json_encode($request->coordinates); // Save as JSON

    $parcel->area = $request->area;
    $parcel->altitude = $request->altitude;
    $parcel->strokecolor = $request->strokecolor;
    $parcel->save();

    // Flash a success message
    session()->flash('success', 'Parcel successfully created!');

    // Return a JSON response indicating success and redirection URL
    return response()->json([
        'success' => true, 
    'redirect_url' => route('polygon.polygons_show') // Replace with the correct route name or URL
    ]);
}



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
        'polygon_name' => $parcel->polygon_name, // Include the ID for reference
        'coordinates' => $coordinates, // Include the decoded coordinates
        'area' => $parcel->area, // Assuming there's an area field
        'altitude' => $parcel->altitude, // Assuming there's an altitude field
        'strokecolor' => $parcel->strokecolor, // Include the stroke color
        'fillColor' => $parcel->fillColor // Optionally include the fill color if available
    ];
})->filter(); // Remove any null values from the collection

$parceldata = collect([$parcels])->map(function($parcel) {
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

        'parcel_name' => $parcel->parcel_name, // Include the ID for reference
        'coordinates' => $coordinates, // Include the decoded coordinates
        'area' => $parcel->area, // Assuming there's an area field
        'altitude' => $parcel->altitude, // Assuming there's an altitude field
        'strokecolor' => $parcel->strokecolor, // Include the stroke color
      
    ];
})->filter(); // Remove any null values from the collection

               // Return the view with the fetched data
               return view('parcels.parcels_edit', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
            'parcels','totalRiceProduction','mapdata','parceldata'));
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
    // Validate the incoming data
    $request->validate([
        'coordinates' => 'required|array',
    ]);

    // Create the polygon record
    $parcel =   ParcellaryBoundaries::find($id);

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
    $parcel->coordinates = json_encode($request->coordinates); // Save as JSON

    $parcel->area = $request->area;
    $parcel->altitude = $request->altitude;
    $parcel->strokecolor = $request->strokecolor;
    $parcel->save();

    // Flash a success message
    session()->flash('success', 'Parcel Updated successfully !');

    // Return a JSON response indicating success and redirection URL
    return response()->json([
        'success' => true, 
    'redirect_url' => route('polygon.polygons_show') // Replace with the correct route name or URL
    ]);
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

            //create new accounts
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

             public function AdminViewNewFarmer(Request $request)
             {
                 // Check if the user is authenticated
                 if (Auth::check()) {
                     // User is authenticated, proceed with retrieving the user's ID
                     $userId = Auth::id();
             
                     // Find the user based on the retrieved ID
                     $admin = User::find($userId);
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
                        
            $users = Farmer::orderBy('id', 'asc');
        
            // Filter by district if specified
            if ($request->has('district') && $request->input('district') !== null) {
                $districtFilter = $request->input('district');
        
                if ($districtFilter !== 'All') {
                    // Case-insensitive comparison for the district filter
                    $users->whereRaw('UPPER(district) = ?', [strtoupper($districtFilter)]);
                }
            } else {
                // If 'district' is null or not provided, include all records
                $users->whereNotNull('id');
            }
        
            // Filter by interview date
            if ($request->has('created_at') && $request->input('created_at') !== null) {
                $dateFilter = $request->input('created_at');
                if ($dateFilter == 'new') {
                    $users->whereDate('created_at', '>=', now()->subMonths(6)); // New records
                } elseif ($dateFilter == 'old') {
                    $users->whereDate('created_at', '<', now()->subMonths(6)); // Old records
                }
            }
        
            // Search functionality for personal information
            if ($request->has('search') && $request->input('search') !== null) {
                $keyword = $request->input('search');
                $users->where(function ($query) use ($keyword) {
                    $query->where('last_name', 'like', "%$keyword%")
                          ->orWhere('first_name', 'like', "%$keyword%");
                });
            }
        
            // Apply sorting if specified
            if ($request->has('sortColumn') && $request->has('sortOrder')) {
                $users->orderBy($request->sortColumn, $request->sortOrder);
            }
        
            // Paginate the personal information results
            $users = $users->paginate(4);
        
            // Fetch distinct districts for the dropdown
            $districts = Farmer::select('district')
                                             ->distinct()
                                             ->orderBy('district')
                                             ->get();
        
            // Calculate total rice production
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'users' => $users,
                 
                    'districts' => $districts,
                    'totalRiceProduction' => $totalRiceProduction,
                ]);
            }
                         $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                         // Return the view with the fetched data
                         return view('admin.create_account.farmer.view_farmerAcc', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
                        'totalRiceProduction',));
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


             public function confirmFarmer($id)
             {
                 try {
                     // Fetch the farmer
                     $farmer = Farmer::findOrFail($id);
             
                     // Move data to the users table
                     $user = new User();
                     $user->first_name = $farmer->first_name ;
                      $user->last_name = $farmer->last_name;
                     $user->email = $farmer->email;
                     $user->password = $farmer->password; // Ensure password is hashed
                     $user->district = $farmer->district;
                     $user->role = 'user'; // Assign role if applicable
                     $user->save();
             
                     // Delete from farmers table
                     $farmer->delete();
             
                     return response()->json(['success' => true]);
                 } catch (\Exception $e) {
                     return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
                 }
             }

             public function deleteFarmerForm($id)
             {
                 try {
                     $personalInfo = Farmer::findOrFail($id);
                     $personalInfo->delete();
             
                     return redirect()->back()->with('message', 'User/Farmer account decline.');
                 } catch (\Exception $e) {
                     return redirect()->back()->with('error', 'An error occurred while deleting the record.');
                 }
             }
             



            //  users view by admin 

            public function AdminAccount(Request $request)
            {
                // Check if the user is authenticated
                if (Auth::check()) {
                    // User is authenticated, proceed with retrieving the user's ID
                    $userId = Auth::id();
            
                    // Find the user based on the retrieved ID
                    $admin = User::find($userId);
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
                                       ->orWhere('first_name', 'like', "%$searchTerm%")
                                       ->orWhere('district', 'like', "%$searchTerm%");
                               });
                           }
                           $users = $usersQuery->orderBy('id','asc')->paginate(10);

                        $users = User::orderBy('id', 'asc');
        
                        // Filter by district if specified
                        if ($request->has('district') && $request->input('district') !== null) {
                            $districtFilter = $request->input('district');
                    
                            if ($districtFilter !== 'All') {
                                // Case-insensitive comparison for the district filter
                                $users->whereRaw('UPPER(district) = ?', [strtoupper($districtFilter)]);
                            }
                        } else {
                            // If 'district' is null or not provided, include all records
                            $users->whereNotNull('id');
                        }
                    
                        // Filter by interview date
                        if ($request->has('created_at') && $request->input('created_at') !== null) {
                            $dateFilter = $request->input('created_at');
                            if ($dateFilter == 'new') {
                                $users->whereDate('created_at', '>=', now()->subMonths(6)); // New records
                            } elseif ($dateFilter == 'old') {
                                $users->whereDate('created_at', '<', now()->subMonths(6)); // Old records
                            }
                        }
                    
                        // Search functionality for personal information
                        if ($request->has('search') && $request->input('search') !== null) {
                            $keyword = $request->input('search');
                            $users->where(function ($query) use ($keyword) {
                                $query->where('last_name', 'like', "%$keyword%")
                                      ->orWhere('first_name', 'like', "%$keyword%");
                            });
                        }
                    
                        // Apply sorting if specified
                        if ($request->has('sortColumn') && $request->has('sortOrder')) {
                            $users->orderBy($request->sortColumn, $request->sortOrder);
                        }
                    
                        // Paginate the personal information results
                        $users = $users->paginate(4);
                    
                        // Fetch distinct districts for the dropdown
                        $districts = User::select('district')
                                                         ->distinct()
                                                         ->orderBy('district')
                                                         ->get();
                    
                        // Calculate total rice production
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    
                        // Return JSON response for AJAX requests
                        if ($request->ajax()) {
                            return response()->json([
                                'users' => $users,
                             
                                'districts' => $districts,
                                'totalRiceProduction' => $totalRiceProduction,
                            ]);
                        }
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        // Return the view with the fetched data
                        return view('admin.create_account.admin_account', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
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


            public function AgentAccount(Request $request)
            {
                // Check if the user is authenticated
                if (Auth::check()) {
                    // User is authenticated, proceed with retrieving the user's ID
                    $userId = Auth::id();
            
                    // Find the user based on the retrieved ID
                    $admin = User::find($userId);
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
                                       ->orWhere('first_name', 'like', "%$searchTerm%")
                                       ->orWhere('district', 'like', "%$searchTerm%");
                               });
                           }
                           $users = $usersQuery->orderBy('id','asc')->paginate(10);

                        $users = User::orderBy('id', 'asc');
        
                        // Filter by district if specified
                        if ($request->has('district') && $request->input('district') !== null) {
                            $districtFilter = $request->input('district');
                    
                            if ($districtFilter !== 'All') {
                                // Case-insensitive comparison for the district filter
                                $users->whereRaw('UPPER(district) = ?', [strtoupper($districtFilter)]);
                            }
                        } else {
                            // If 'district' is null or not provided, include all records
                            $users->whereNotNull('id');
                        }
                    
                        // Filter by interview date
                        if ($request->has('created_at') && $request->input('created_at') !== null) {
                            $dateFilter = $request->input('created_at');
                            if ($dateFilter == 'new') {
                                $users->whereDate('created_at', '>=', now()->subMonths(6)); // New records
                            } elseif ($dateFilter == 'old') {
                                $users->whereDate('created_at', '<', now()->subMonths(6)); // Old records
                            }
                        }
                    
                        // Search functionality for personal information
                        if ($request->has('search') && $request->input('search') !== null) {
                            $keyword = $request->input('search');
                            $users->where(function ($query) use ($keyword) {
                                $query->where('last_name', 'like', "%$keyword%")
                                      ->orWhere('first_name', 'like', "%$keyword%");
                            });
                        }
                    
                        // Apply sorting if specified
                        if ($request->has('sortColumn') && $request->has('sortOrder')) {
                            $users->orderBy($request->sortColumn, $request->sortOrder);
                        }
                    
                        // Paginate the personal information results
                        $users = $users->paginate(4);
                    
                        // Fetch distinct districts for the dropdown
                        $districts = User::select('district')
                                                         ->distinct()
                                                         ->orderBy('district')
                                                         ->get();
                    
                        // Calculate total rice production
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    
                        // Return JSON response for AJAX requests
                        if ($request->ajax()) {
                            return response()->json([
                                'users' => $users,
                             
                                'districts' => $districts,
                                'totalRiceProduction' => $totalRiceProduction,
                            ]);
                        }
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        // Return the view with the fetched data
                        return view('admin.create_account.agent_account', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
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
            public function Accountview(Request $request)
            {
                // Check if the user is authenticated
                if (Auth::check()) {
                    // User is authenticated, proceed with retrieving the user's ID
                    $userId = Auth::id();
            
                    // Find the user based on the retrieved ID
                    $admin = User::find($userId);
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
                                       ->orWhere('first_name', 'like', "%$searchTerm%")
                                       ->orWhere('district', 'like', "%$searchTerm%");
                               });
                           }
                           $users = $usersQuery->orderBy('id','asc')->paginate(10);

                        $users = User::orderBy('id', 'asc');
        
                        // Filter by district if specified
                        if ($request->has('district') && $request->input('district') !== null) {
                            $districtFilter = $request->input('district');
                    
                            if ($districtFilter !== 'All') {
                                // Case-insensitive comparison for the district filter
                                $users->whereRaw('UPPER(district) = ?', [strtoupper($districtFilter)]);
                            }
                        } else {
                            // If 'district' is null or not provided, include all records
                            $users->whereNotNull('id');
                        }
                    
                        // Filter by interview date
                        if ($request->has('created_at') && $request->input('created_at') !== null) {
                            $dateFilter = $request->input('created_at');
                            if ($dateFilter == 'new') {
                                $users->whereDate('created_at', '>=', now()->subMonths(6)); // New records
                            } elseif ($dateFilter == 'old') {
                                $users->whereDate('created_at', '<', now()->subMonths(6)); // Old records
                            }
                        }
                    
                        // Search functionality for personal information
                        if ($request->has('search') && $request->input('search') !== null) {
                            $keyword = $request->input('search');
                            $users->where(function ($query) use ($keyword) {
                                $query->where('last_name', 'like', "%$keyword%")
                                      ->orWhere('first_name', 'like', "%$keyword%");
                            });
                        }
                    
                        // Apply sorting if specified
                        if ($request->has('sortColumn') && $request->has('sortOrder')) {
                            $users->orderBy($request->sortColumn, $request->sortOrder);
                        }
                    
                        // Paginate the personal information results
                        $users = $users->paginate(4);
                    
                        // Fetch distinct districts for the dropdown
                        $districts = User::select('district')
                                                         ->distinct()
                                                         ->orderBy('district')
                                                         ->get();
                    
                        // Calculate total rice production
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    
                        // Return JSON response for AJAX requests
                        if ($request->ajax()) {
                            return response()->json([
                                'users' => $users,
                             
                                'districts' => $districts,
                                'totalRiceProduction' => $totalRiceProduction,
                            ]);
                        }
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


                        public function  editpassword($id)
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
                                    return view('admin.create_account.update_password', compact('agri_districts', 'agri_districts_id', 'admin', 'profile',
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

                        public function Updatepasswords(Request $request, $id){
                    
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
                            $data->password = $request['new_password'];
                          
                            // dd($data);
                            $data->save();
            
                            // Redirect back after processing
                            return redirect('/view-accounts')->with('message', 'Account updated successfully');
                        } 
                        } catch (Exception $e) {
                        //    dd($e);
                        // Handle any exceptions and redirect back with error message
                        return redirect()->back()->with('error', 'Error updating password: ' . $e->getMessage());
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
                    return redirect()->back()->with('message', 'Account deleted Successfully');

                } catch (Exception $e) {
                    // Handle any exceptions and redirect back with error message
                    return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
                }
            }


    public function CornMap(Request $request) {
        // Check if the user is authenticated
        if (Auth::check()) {
            // User is authenticated
            $userId = Auth::id();
            $admin = User::find($userId);
            
            if ($admin) {
                // Find the user's personal information by their ID
                $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                $polygons = Polygon::all();
                // Fetch all farm profiles
                $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])->get();

    
                // Fetch all agri districts
                $agriDistricts = AgriDistrict::all(); // Get all agri districts
    
                // Check if there are any farm profiles
                if ($farmProfiles->isEmpty() && $agriDistricts->isEmpty()) {
                    return response()->json(['error' => 'No farm profiles or agri districts found.'], 404);
                }
    
                // Fetch total rice production
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
    
                                // Prepare an array for GPS coordinates
                    $gpsData = [];
                    foreach ($farmProfiles as $farmProfile) {
                        // Concatenate all crop names associated with the farm profile
                    // This will create a comma-separated string of crop names
                    foreach ($farmProfile->cropFarms as $cropFarm) {
                        $cropNames = $cropFarm->crop_name; // Fetch individual crop name
                        $cropVariety = $cropFarm->type_of_variety_planted; // Fetch individual crop variety
                        $croppingperYear = $cropFarm->no_of_cropping_per_year; // Fetch individual cropping per year
                        $yield = $cropFarm->yield_kg_ha; // Fetch individual yield
                
                        // Now you can use these variables as needed
                        // For example, you could print them
                        // echo "Crop Name: $cropNames, Crop Variety: $cropVariety, Cropping/Year: $croppingperYear, Yield: $yield kg/ha\n";
                    }


                        // Access personal information (if it exists)
                            $farmerName = $farmProfile->personalInformation ? 
                            ($farmProfile->personalInformation->first_name . 
                            ($farmProfile->personalInformation->middle_name ? ' ' . $farmProfile->personalInformation->middle_name : '') . 
                            ' ' . $farmProfile->personalInformation->last_name) : 
                            null;
                            

                        $civilStatus = $farmProfile->personalInformation ? $farmProfile->personalInformation->civil_status : null; // Adjust field name as needed
                        $orgName = $farmProfile->personalInformation ? $farmProfile->personalInformation->nameof_farmers_ass_org_coop: null; // Adjust field name as needed
                        $homeAddress = $farmProfile->personalInformation ? $farmProfile->personalInformation->home_address: null;
                        $landtitleNo = $farmProfile->personalInformation ? $farmProfile->personalInformation->land_title_no: null;
                        $lotNo = $farmProfile->personalInformation ? $farmProfile->personalInformation->lot_no: null;

                    // Fetch date_of_birth from the related personalInformation model
                    $dateOfBirth = $farmProfile->personalInformation ? $farmProfile->personalInformation->date_of_birth : null;

                    // Calculate age based only on the year (ignores month/day)
                    $age = null;
                    if ($dateOfBirth) {
                        $birthYear = Carbon::parse($dateOfBirth)->year; // Extract year of birth
                        $currentYear = Carbon::now()->year; // Get the current year

                        // Debugging: check the values of birthYear and currentYear
                        // dd($birthYear, $currentYear); // This will dump the values to the screen and stop execution

                        $age = $currentYear - $birthYear; // Calculate the difference in years
                    }

                        $gpsData[] = [
                            'gpsLatitude' => $farmProfile->gps_latitude,
                            'gpsLongitude' => $farmProfile->gps_longitude,
                            'FarmAddress' => $farmProfile->farm_address,
                            'NoYears' => $farmProfile->no_of_years_as_farmers,
                            'totalPhysicalArea' => $farmProfile->total_physical_area,
                            'TotalCultivated' => $farmProfile->total_area_cultivated,
                             'tenurial_status' => $farmProfile->tenurial_status,
                           'district' => ucwords(strtolower($farmProfile->agri_districts)),

                            
                            'cropName' => $cropNames, // List of crops
                            'cropVariety' => $cropVariety,
                            'croppingperYear' => $croppingperYear,
                            'Yield' => $yield,

                            'farmerName' => $farmerName, // Farmer's name from personal information
                            'civilStatus' => $civilStatus,
                            'orgName' => $orgName,
                            'homeAddress' => $homeAddress,
                            'landtitleNo' => $landtitleNo,
                            'lotNo' => $lotNo,
                            'age' => $age,


                        ];
                    }

    
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
                        'admin' => $admin,
                        'profile' => $profile,
                        'farmProfiles' => $farmProfiles,
                        'totalRiceProduction' => $totalRiceProduction,
                        'gpsData' => $gpsData,
                        'polygons' => $polygonsData,
                        'districtsData' => $districtsData // Send all district GPS coordinates
                    ]);
                } else {
                    // Return the view with the fetched data for regular requests
                    return view('map.cornmap', [
                        'admin' => $admin,
                        'profile' => $profile,
                        'farmProfiles' => $farmProfiles,
                        'totalRiceProduction' => $totalRiceProduction,
                        'gpsData' => $gpsData,
                        'districtsData' => $districtsData,
                        'mapdata' => $mapdata, // Pass to view
                        'parceldata'=> $parceldata 
                    ]);
                }
            }  else {
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
    
  

// Controller method for showing the coconut map view
public function CoconutMap() {
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
                return redirect()->route('login');
            }

            // Find the user's personal information by their ID
            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

            // Fetch the farm ID associated with the user
            $farmId = $user->farm_id;

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

            // Calculate total rice production
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

           // Retrieve all CropParcel entries
  // Output to indicate the start of the fetching process
//   echo "Fetching CropParcel records...\n";

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

  // Output the count of valid mapdata fetched
//   echo "Valid mapdata fetched: " . $mapdata->count() . "\n";

  // If the request expects JSON, return mapdata as a JSON response
  if (request()->wantsJson()) {
      return response()->json($mapdata);
  }

            // Return the view with the fetched data
            return view('map.coconutmap', compact('admin', 'profile', 'farmProfile', 'totalRiceProduction','mapdata' ));
        } else {
            return redirect()->route('login')->with('error', 'User not found.');
        }
    } else {
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

// Function to manage the survey process on the admin page. It handles retrieving, displaying, and processing survey data for administrative purposes.

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

            
            // varieties
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

            // store 
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

                //  public function viewBaranagay(Request $request){
                //     // Check if the user is authenticated
                // if (Auth::check()) {
                // // User is authenticated, proceed with retrieving the user's ID
                // $userId = Auth::id();
                
                // // Find the user based on the retrieved ID
                // $admin = User::find($userId);
                
                // if ($admin) {
                //     // Assuming $user represents the currently logged-in user
                //     $user = auth()->user();
                
                //     // Check if user is authenticated before proceeding
                //     if (!$user) {
                //         // Handle unauthenticated user, for example, redirect them to login
                //         return redirect()->route('login');
                //     }
                
                //     // Find the user's personal information by their ID
                //     $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                
                //     // Fetch the farm ID associated with the user
                //     $farmId = $user->farm_id;
                
                //     // Find the farm profile using the fetched farm ID
                //     $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                // // Query for labors with search functionality
                // $barangaysQuery = Barangay::query();
                // if ($request->has('search')) {
                //     $searchTerm = $request->input('search');
                //     $barangaysQuery->where(function($query) use ($searchTerm) {
                //         $query->where('barangay_name', 'like', "%$searchTerm%");
                           
                //     });
                // }
                // $barangays = $barangaysQuery->orderBy('id','asc')->paginate(10);
                // // $productions = LastProductionDatas::with('personalinformation', 'farmprofile','agridistrict')
                // // ->orderBy('id', 'asc');
                
                // $agriDistrict = AgriDistrict::all();
                    
                //     $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                //     // Return the view with the fetched data
                //     return view('admin.barangay.view_barangay', compact('agriDistrict','barangays','userId','admin', 'profile', 'farmProfile','totalRiceProduction'
                //     ,'userId'));
                // } else {
                //     // Handle the case where the user is not found
                //     // You can redirect the user or display an error message
                //     return redirect()->route('login')->with('error', 'User not found.');
                // }
                // } else {
                // // Handle the case where the user is not authenticated
                // // Redirect the user to the login page
                // return redirect()->route('login');
                // }
                // }

   public function viewBarangay(Request $request)
    {
        // Redirect to login if not authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the logged-in admin user
        $admin = User::find(Auth::id());
        if (!$admin) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // Query the Barangay model
        $barangays = Barangay::query();

        // Handle search
        if ($request->filled('barangay_search')) {
            $keyword = $request->input('barangay_search');
            $barangays->where('barangay_name', 'like', "%{$keyword}%")
            ->orwhere('district', 'like', "%{$keyword}%");
        }

        // Handle sorting
        $sortColumn = $request->input('sort_column', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $barangays->orderBy($sortColumn, $sortOrder);

        // Handle pagination
        $barangayPage = $request->input('barangay_page', 1);
        $barangays = $barangays->paginate(4, ['*'], 'barangay_page', $barangayPage);

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'barangays' => $barangays
            ]);
        }

        // Initial full-page view
        return view('admin.barangay.view_barangay', compact('barangays', 'admin'));
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
                                return redirect()->route('admin.barangay.view_barangay')
                                                 ->with('message', 'barangay data deleted successfully');
                            } else {
                                return redirect()->route('admin.barangay.view_barangay')
                                                 ->with('message', 'barangay data not found');
                            }
                        } catch (Exception $e) {
                            return redirect()->route('admin.barangay.view_barangay')
                                             ->with('message', 'Error deleting barangay data : ' . $e->getMessage());
                        }
                    }
                    // end barangay


                        // CRUD operations for managing barangay data:
                        // - Create: Adds new barangay records, including location and related information, to the database.
                        // - Read: Retrieves and displays barangay data for reference or administrative purposes.
                        // - Update: Modifies existing barangay records, such as updates to location or other relevant details.
                        // - Delete: Removes barangay records from the database when no longer needed or applicable.

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


                public function saveFarmerOrg(Request $request )
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

                    // public function viewfarmersOrg(Request $request){
                    //     // Check if the user is authenticated
                    // if (Auth::check()) {
                    // // User is authenticated, proceed with retrieving the user's ID
                    // $userId = Auth::id();
                    
                    // // Find the user based on the retrieved ID
                    // $admin = User::find($userId);
                    
                    // if ($admin) {
                    //     // Assuming $user represents the currently logged-in user
                    //     $user = auth()->user();
                    
                    //     // Check if user is authenticated before proceeding
                    //     if (!$user) {
                    //         // Handle unauthenticated user, for example, redirect them to login
                    //         return redirect()->route('login');
                    //     }
                    
                    //     // Find the user's personal information by their ID
                    //     $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                    
                    //     // Fetch the farm ID associated with the user
                    //     $farmId = $user->farm_id;
                    
                    //     // Find the farm profile using the fetched farm ID
                    //     $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                    
                    //     $FarmerOrgQuery = FarmerOrg::query();
                    //     if ($request->has('search')) {
                    //         $searchTerm = $request->input('search');
                    //         $FarmerOrgQuery->where(function($query) use ($searchTerm) {
                    //             $query->where('organization_name', 'like', "%$searchTerm%");
                                  
                                
                    //         });
                    //     }
                    //     $FarmerOrg = $FarmerOrgQuery->orderBy('id','asc')->paginate(10);
                    
                        
                    //     $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    //     // Return the view with the fetched data
                    //     return view('admin.farmerOrg.view_orgs', compact('FarmerOrg','userId','admin', 'profile', 'farmProfile','totalRiceProduction'
                    //     ,'userId'));
                    // } else {
                    //     // Handle the case where the user is not found
                    //     // You can redirect the user or display an error message
                    //     return redirect()->route('login')->with('error', 'User not found.');
                    // }
                    // } else {
                    // // Handle the case where the user is not authenticated
                    // // Redirect the user to the login page
                    // return redirect()->route('login');
                    // }
                    // }

   public function viewfarmersOrg(Request $request)
    {
        // Redirect to login if not authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the logged-in admin user
        $admin = User::find(Auth::id());
        if (!$admin) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // Query the Barangay model
        $FarmerOrg = FarmerOrg::query();

        // Handle search
        if ($request->filled('FarmerOrg_search')) {
            $keyword = $request->input('FarmerOrg_search');
            $FarmerOrg->where('organization_name', 'like', "%{$keyword}%")
            ->orwhere('district', 'like', "%{$keyword}%");
        }

        // Handle sorting
        $sortColumn = $request->input('sort_column', 'id');
        $sortOrder = $request->input('sort_order', 'asc');
        $FarmerOrg->orderBy($sortColumn, $sortOrder);

        // Handle pagination
        $FarmerOrgPage = $request->input('FarmerOrg_page', 1);
        $FarmerOrg = $FarmerOrg->paginate(4, ['*'], 'FarmerOrg_page', $FarmerOrgPage);

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'FarmerOrg' => $FarmerOrg
            ]);
        }

        // Initial full-page view
        return view('admin.farmerOrg.view_orgs', compact('FarmerOrg', 'admin'));
    }
       
                        // update and delete by admin

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

                            } catch (Exception $e) {
                                // Handle any exceptions and redirect back with error message
                                return redirect()->back()->with('error', 'Error deleting Farmer Organization: ' . $e->getMessage());
                            }
                        }




  // Function to view personal information and retrieve farmer data from the database. 
// This allows the admin or authorized users to access and display all data related to the farmers, including personal details and farm-related information.


        public function GenFarmers(Request $request)
        {
            // Check if the user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login');
            }
        
            $userId = Auth::id();
            $admin = User::find($userId);
        
            if (!$admin) {
                return redirect()->route('login')->with('error', 'User not found.');
            }
        
            // Base query for personal information
            $personalinfos = PersonalInformations::orderBy('id', 'asc');
        
            // Filter by district if specified
            if ($request->has('district') && $request->input('district') !== null) {
                $districtFilter = $request->input('district');
        
                if ($districtFilter !== 'All') {
                    // Case-insensitive comparison for the district filter
                    $personalinfos->whereRaw('UPPER(agri_district) = ?', [strtoupper($districtFilter)]);
                }
            } else {
                // If 'district' is null or not provided, include all records
                $personalinfos->whereNotNull('id');
            }
        
            // Filter by interview date
            if ($request->has('date_interview') && $request->input('date_interview') !== null) {
                $dateFilter = $request->input('date_interview');
                if ($dateFilter == 'new') {
                    $personalinfos->whereDate('date_interview', '>=', now()->subMonths(6)); // New records
                } elseif ($dateFilter == 'old') {
                    $personalinfos->whereDate('date_interview', '<', now()->subMonths(6)); // Old records
                }
            }
        
            // Search functionality for personal information
            if ($request->has('search') && $request->input('search') !== null) {
                $keyword = $request->input('search');
                $personalinfos->where(function ($query) use ($keyword) {
                    $query->where('last_name', 'like', "%$keyword%")
                          ->orWhere('first_name', 'like', "%$keyword%");
                });
            }
        
            // Apply sorting if specified
            if ($request->has('sortColumn') && $request->has('sortOrder')) {
                $personalinfos->orderBy($request->sortColumn, $request->sortOrder);
            }
        
            // Paginate the personal information results
            $personalinfos = $personalinfos->paginate(4);
        
            // Fetch distinct districts for the dropdown
            $districts = PersonalInformations::select('agri_district')
                                             ->distinct()
                                             ->orderBy('agri_district')
                                             ->get();
        
            // Base query for farm profiles
            $farmProfiles = FarmProfile::select('farm_profiles.*')
                                       ->leftJoin('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                                       ->with('agriDistrict')
                                       ->orderBy('farm_profiles.id', 'asc');
        
            // Search functionality for farm profiles
            if ($request->has('search') && $request->input('search') !== null) {
                $keyword = $request->input('search');
                $farmProfiles->where(function ($query) use ($keyword) {
                    $query->where('personal_informations.last_name', 'like', "%$keyword%")
                          ->orWhere('personal_informations.first_name', 'like', "%$keyword%");
                });
            }
        
            // Paginate the farm profiles results
            $farmProfiles = $farmProfiles->paginate(20);
        
            // Calculate total rice production
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'personalinfos' => $personalinfos,
                    'farmProfiles' => $farmProfiles,
                    'districts' => $districts,
                    'totalRiceProduction' => $totalRiceProduction,
                ]);
            }
        
            // For regular requests, return the view
            return view('admin.farmersdata.genfarmers', compact('admin', 'personalinfos', 'farmProfiles', 'districts'));
        }
        

        public function ReportsFarmer(Request $request)
        {
            // Check if the user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login');
            }
        
            $userId = Auth::id();
            $admin = User::find($userId);
        
            if (!$admin) {
                return redirect()->route('login')->with('error', 'User not found.');
            }
        
            // Base query for personal information
            $personalinfos = PersonalInformations::orderBy('id', 'asc');
        
            // Filter by district if specified
            if ($request->has('district') && $request->input('district') !== null) {
                $districtFilter = $request->input('district');
        
                if ($districtFilter !== 'All') {
                    // Case-insensitive comparison for the district filter
                    $personalinfos->whereRaw('UPPER(agri_district) = ?', [strtoupper($districtFilter)]);
                }
            } else {
                // If 'district' is null or not provided, include all records
                $personalinfos->whereNotNull('id');
            }
        
            // Filter by interview date
            if ($request->has('date_interview') && $request->input('date_interview') !== null) {
                $dateFilter = $request->input('date_interview');
                if ($dateFilter == 'new') {
                    $personalinfos->whereDate('date_interview', '>=', now()->subMonths(6)); // New records
                } elseif ($dateFilter == 'old') {
                    $personalinfos->whereDate('date_interview', '<', now()->subMonths(6)); // Old records
                }
            }
        
            // Search functionality for personal information
            if ($request->has('search') && $request->input('search') !== null) {
                $keyword = $request->input('search');
                $personalinfos->where(function ($query) use ($keyword) {
                    $query->where('last_name', 'like', "%$keyword%")
                          ->orWhere('first_name', 'like', "%$keyword%");
                });
            }
        
            // Apply sorting if specified
            if ($request->has('sortColumn') && $request->has('sortOrder')) {
                $personalinfos->orderBy($request->sortColumn, $request->sortOrder);
            }
        
            // Paginate the personal information results
            $personalinfos = $personalinfos->paginate(100);
        
            // Fetch distinct districts for the dropdown
            $districts = PersonalInformations::select('agri_district')
                                             ->distinct()
                                             ->orderBy('agri_district')
                                             ->get();
        
            // Base query for farm profiles
            $farmProfiles = FarmProfile::select('farm_profiles.*')
                                       ->leftJoin('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
                                       ->with('agriDistrict')
                                       ->orderBy('farm_profiles.id', 'asc');
        
            // Search functionality for farm profiles
            if ($request->has('search') && $request->input('search') !== null) {
                $keyword = $request->input('search');
                $farmProfiles->where(function ($query) use ($keyword) {
                    $query->where('personal_informations.last_name', 'like', "%$keyword%")
                          ->orWhere('personal_informations.first_name', 'like', "%$keyword%");
                });
            }
        
            // Paginate the farm profiles results
            $farmProfiles = $farmProfiles->paginate(20);
        
            // Calculate total rice production
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        
            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'personalinfos' => $personalinfos,
                    'farmProfiles' => $farmProfiles,
                    'districts' => $districts,
                    'totalRiceProduction' => $totalRiceProduction,
                ]);
            }
        
            // For regular requests, return the view
            return view('admin.farmersdata.farmer_report', compact('admin', 'personalinfos', 'farmProfiles', 'districts'));
        }


        // Retrieving all farmers data from database to create a analytics report
   
        public function AnalyticReport(Request $request)
        {
            if (!Auth::check()) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return redirect()->route('login');
            }
        
            try {
                // Fetch farmer count by district
                $data = FarmProfile::getFarmerCountByDistrict();
        
                // Format the data for the chart
                $formattedData = $data->map(function ($item) {
                    return [
                        'agri_districts' => $item->agri_districts,
                        'farmer_count' => $item->farmer_count,
                    ];
                });
        
                // If the request is AJAX, return JSON response
                if ($request->ajax()) {
                    return response()->json($formattedData);
                }
        
                // Otherwise, return the view with 'admin' data
                $admin = Auth::user(); // Assuming you're passing the authenticated user
                return view('admin.GeneralReport.FarmersReport', compact('admin', 'formattedData'));
        
            } catch (Exception $e) {
                // Log the error and return a message
                Log::error('Error fetching analytics report: ' . $e->getMessage());
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }
        
        
                    }
