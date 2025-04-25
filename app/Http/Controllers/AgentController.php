<?php

namespace App\Http\Controllers;
use App\Models\PersonalInformationArchive;
use App\Notifications\UserDataUpdated;
use App\Models\FarmProfile;
use App\Models\FixedCostArchive;
use App\Models\VariableCostArchive;
use App\Models\MachineriesCostArchive;
use App\Models\Fertilizer;
use App\Models\FixedCost;
use App\Models\ProductionArchive;
use App\Models\Labor;
use App\Models\CropFarmsArchive;
use App\Models\LastProductionDatas;
use App\Models\FarmProfileArchive;
use App\Models\MachineriesUseds;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\AgriDistrict;
use Illuminate\Support\Facades\Storage;
use App\Models\PersonalInformations;
use App\Http\Requests\PersonalInformationsRequest;
use App\Http\Controllers\Backend\PersonalInformationsController;
use App\Models\Transport;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Crop;
use App\Models\ProductionSold;
use App\Models\Barangay;
use App\Models\CropCategory;
use App\Models\Categorize;
use App\Models\FarmerOrg;
use App\Models\CropParcel;
use App\Models\ParcellaryBoundaries;
use App\Models\Polygon;
use App\Models\Notification;
use App\Notifications\SurveyFormSubmitted;
use App\Notifications\AdminNotification;
class AgentController extends Controller
{


    // fetch users 
    public function getUsers()
{
    $users = User::select('id', 'first_name','last_name')->get();
    return response()->json($users);
}
public function updateFarmProfile(Request $request)
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


    public function showFarmerProfiles(Request $request,$id)
    {
        // Fetch the farm profile data
        $farmProfile = FarmProfile::with('cropFarms')->find($id);
    
        // You might also want to fetch the admin data if necessary
        $agent = Auth::user(); // Assuming you are using Laravel's Auth to get the currently logged-in user
    
        // Check if farm profile exists
        if (!$farmProfile) {
            return redirect()->route('farmProfiles.index')->with('error', 'Farm profile not found.');
        }
    
        // Prepare data for view
           // Fetch the farm profile data with all the related data
$farmProfile = FarmProfile::with([
    'cropFarms.lastProductionDatas', 
    'cropFarms.fixedCosts', 
    'cropFarms.machineries', 
    'cropFarms.variableCosts', 
    'cropFarms.productionSolds',
    'personalInformation' // Include personalInformation relationship
])->find($id);

// Check if the farm profile exists

// Check if there are any farm profiles before processing
//  if ($farmProfile->isEmpty()) {
//     // Return an empty response if no farm profiles are found
//     return response()->json([
//         'message' => 'No farm profiles found',
//         'formattedIncomeData' => [],
//         'croppingLabels' => [],
//         'croppingYields' => [],
//     ]);
// }
//     // Prepare data for crops
$cropsData = $farmProfile->cropFarms->map(function ($crop) {
    return [
        'cropName' => $crop->crop_name,
        'typeOfVariety' => $crop->type_of_variety_planted ?? $crop->preferred_variety, // Use preferred_variety if type_of_variety_planted is null

        'yield' => $crop->yield_kg_ha,
        'plantingScheduleWet' => $crop->planting_schedule_wetseason 
            ? Carbon::parse($crop->planting_schedule_wetseason)->format('F D Y') : null,
        'plantingScheduleDry' => $crop->planting_schedule_dryseason 
            ? Carbon::parse($crop->planting_schedule_dryseason)->format('F D Y') : null,
        'lastHarvestDate' => $crop->last_harvest_date,
        'croppingNumberperyear' => $crop->no_of_cropping_per_year,
        'lastProductionDatas' => $crop->lastProductionDatas,
        'fixedCosts' => $crop->fixedCosts,
        'machineries' => $crop->machineries,
        'variableCosts' => $crop->variableCosts,
        'productionSolds' => $crop->productionSolds,
    ];
});

// Prepare GPS data
$gpsData = [
    // 'farmAddress' => $farmProfile->address,
    'gpsLatitude' => $farmProfile->gps_latitude,
    'gpsLongitude' => $farmProfile->gps_longitude,
                                      'FarmAddress' => $farmProfile->farm_address,
                              'NoYears' => $farmProfile->no_of_years_as_farmers,
                              'totalPhysicalArea' => $farmProfile->total_physical_area,
                              'TotalCultivated' => $farmProfile->total_area_cultivated,
                              'tenurial_status' => $farmProfile->tenurial_status,
                              'area_prone_to' => $farmProfile->area_prone_to,
                              'ecosystem' => $farmProfile->ecosystem,
                              'rsba_registered' => $farmProfile->rsba_registered,
                              'pcic_insured' => $farmProfile->pcic_insured,
                              'government_assisted' => $farmProfile->government_assisted,
                              'source_of_capital' => $farmProfile->tenurial_status,
];
     // Get personal information if exists
     $personalInfo = $farmProfile->personalInformation;

     $data = [
         'full_name' => $personalInfo ? 
             ($personalInfo->first_name . 
             ($personalInfo->middle_name ? ' ' . $personalInfo->middle_name : '') . 
             ' ' . $personalInfo->last_name) : 
             null,
         'civilStatus' => $personalInfo ? $personalInfo->civil_status : null,
         'orgName' => $personalInfo ? $personalInfo->nameof_farmers_ass_org_coop : null,
         'address' => collect([$personalInfo->barangay ?? null, $personalInfo->district ?? null, $personalInfo->city ?? null])
                         ->filter()
                         ->implode(', ') ?: null,
         'homeAddress' => $personalInfo->home_address ?: null,
         'land_title_no' => $personalInfo->land_title_no,
         'lot_no' => $personalInfo->lot_no,
         'province' => $personalInfo->province,
         'country' => $personalInfo->country,
         'street' => $personalInfo->street,
         'zip_code' => $personalInfo->zip_code,
         'sex' => $personalInfo->sex,
         'religion' => $personalInfo->religion,
         'place_of_birth' => $personalInfo->place_of_birth,
         'contact_no' => $personalInfo->contact_no,
         'name_legal_spouse' => $personalInfo->name_legal_spouse,
         'no_of_children' => $personalInfo->no_of_children,
         'mothers_maiden_name' => $personalInfo->mothers_maiden_name,
         'highest_formal_education' => $personalInfo->highest_formal_education,
         'person_with_disability' => $personalInfo->person_with_disability,
         'pwd_id_no' => $personalInfo->pwd_id_no,
         'id_type' => $personalInfo->id_type,
         'gov_id_no' => $personalInfo->gov_id_no,
         'name_contact_person' => $personalInfo->name_contact_person,
         'cp_tel_no' => $personalInfo->cp_tel_no,
         'date_of_birth' => $personalInfo->date_of_birth,
         'age' => $personalInfo->date_of_birth ? Carbon::now()->diffInYears(Carbon::parse($personalInfo->date_of_birth)) : null,
     ];

    $grossIncomeData = [];
    $croppingData = [];
    $cropYieldData = [];

    // Process gross income data for each crop in $cropsData
    foreach ($cropsData as $cropData) {
        // Sum the gross income from production sold data
        $productionSoldIncome = $cropData['productionSolds']->sum('gross_income');
    
        // Determine the crop name
        $cropName = $cropData['cropName'];
    
        // Initialize the crop name key in gross income data if it doesn't exist
        if (!isset($grossIncomeData[$cropName])) {
            $grossIncomeData[$cropName] = 0;
        }
    
        if ($productionSoldIncome > 0) {
            // Accumulate the income
            $grossIncomeData[$cropName] += $productionSoldIncome;
        } else {
            // Fallback to last production data if production sold data is unavailable
            $lastProductionIncome = $cropData['lastProductionDatas']->sum(function($lastProductionData) {
                return $lastProductionData->gross_income_palay + $lastProductionData->gross_income_rice;
            });
    
            // Accumulate the income from last production data
            $grossIncomeData[$cropName] += $lastProductionIncome;
        }
    
        // Process cropping data for each last production data
        foreach ($cropData['lastProductionDatas'] as $productionData) {
            $croppingNo = $productionData->cropping_no; // Get cropping number
            $totalYieldKg = $productionData->yield_tons_per_kg; // Total yield in kg
    
            // Initialize cropping number in croppingData if it doesn't exist
            if (!isset($croppingData[$croppingNo])) {
                $croppingData[$croppingNo] = 0;
            }
            // Accumulate the yield per cropping number
            $croppingData[$croppingNo] += $totalYieldKg;
        }
    }
    // Process crop yield data for each crop in $cropsData
foreach ($cropsData as $cropData) {
// Determine the crop name
$cropName = $cropData['cropName'];

// Initialize the crop name key in crop yield data if it doesn't exist
if (!isset($cropYieldData[$cropName])) {
    $cropYieldData[$cropName] = 0;
}

// Process yield from last production data
foreach ($cropData['lastProductionDatas'] as $productionData) {
    $totalYieldKg = $productionData->yield_tons_per_kg; // Total yield in kg

    // Accumulate the yield for the crop
    $cropYieldData[$cropName] += $totalYieldKg;
}
}

    // Prepare formatted income data for the chart
            $formattedIncomeData = [
                'labels' => array_keys($grossIncomeData),
                'data' => array_values($grossIncomeData),
            ];
            
            // Prepare formatted cropping data for the chart
            $formattedCroppingData = [
                'labels' => array_keys($croppingData),
                'data' => array_map(fn($kg) => $kg / 1000, array_values($croppingData)), // Convert kg to tons
            ];
            // Format the data for Chart.js
            $formattedYieldData = [
                'labels' => array_map('ucfirst', array_keys($cropYieldData)), // Capitalize the first letter of each crop name
                'data' => array_values($cropYieldData),  // Assuming this is the yield in kg or tons
            ];

    // Check if the request is AJAX
    if ($request->ajax()) {
        return response()->json([
            'formattedIncomeData' => $formattedIncomeData,
            'formattedCroppingData' => $formattedCroppingData,
            'formattedYieldData' => $formattedYieldData,
        ]);
    }
    

        // Return the view with the necessary data
        return view('agent.farmprofile.profile_farmers', compact('farmProfile', 'cropsData', 'gpsData', 'agent','data','farmProfile'));
    }

// Function to retrieve and display all relevant data on the agent dashboard. 
// This includes farmer profiles, farm data, production statistics, and any additional information necessary for the agent's operations.

    
    public function  AgentDashboard(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $agent = User::find($userId);
    
            if ($agent) {
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
                
       // Now you can pass $barChartData to your JavaScript function
            
 // Prepare tenurial status data
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
                return view('agent.agent_index', compact(
                    'totalFarms',
                    'totalAreaPlanted',
                    'totalAreaYield',
                    'totalCost',
                    'yieldPerAreaPlanted',
                    'averageCostPerAreaPlanted',
                    'totalRiceProduction',
                    'crops',
                    'agent',
                    'districts',
                   
                
                 
                ));
            }
    
            return redirect()->back()->with('error', 'Admin not found.');
        }
    
        return redirect()->route('login')->with('error', 'You need to log in first.');
    }

// Functionality for the agent logout button. 
// Logs the agent out of the system, ends the session, and redirects to the login page or home screen.

    public function agentlog(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');


      
    }//end 


// Fetching personal information and geographic coordinates to be inserted into the farm profile. 
// Ensures data integrity and alignment between personal details and farm location data.

// CRUD operations for agent to manage personal information:
// - Create: Allows the agent to add new personal information for farmers, including contact and basic details.
// - Read: Retrieves and displays personal information for review or further processing.
// - Update: Modifies existing personal information to reflect any changes or updates.
// - Delete: Removes personal information from the database when no longer relevant or needed.

      public function addPersonalInfo()
      {
          if (Auth::check()) {
              // User is authenticated, proceed with retrieving the user's ID
              $userId = Auth::id();
      
              // Find the user based on the retrieved ID
              $agent = User::find($userId);
      
              if ($agent) {
                  // Assuming you have additional logic to fetch other agent information
                  $agri_district = $agent->agri_district;
                  $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                  // Return the view with agent information
                  return view('agent.personal_info.add_info', compact('userId','totalRiceProduction', 'agri_district', 'agent'));
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
      

//   add


    public function addinfo(PersonalInformationsRequest $request)
    {
      
        try{
            // Check if the associated PersonalInformations record exists
    // Access the primary key of the PersonalInformations model instance

    $existingPersonalInformations = PersonalInformations::where([
        ['first_name', '=', $request->input('first_name')],
        ['middle_name', '=', $request->input('middle_name')],
        ['last_name', '=', $request->input('last_name')],
       
       
    
      
        // Add other fields here
    ])->first();
    
    if ($existingPersonalInformations) {
        // FarmProfile with the given personal_informations_id and other fields already exists
        // You can handle this scenario here, for example, return an error message
        return redirect('/add-personal-info')->with('error', 'Farm Profile with this information already exists.');
    }
    
    $personalInformation= $request->validated();
    $personalInformation= $request->all();
           $personalInformation= new PersonalInformations;
        //    dd($request->all());
     
  // Check if a file is present in the request and if it's valid
if ($request->hasFile('image') && $request->file('image')->isValid()) {
    // Retrieve the image file from the request
    $image = $request->file('image');
    
    // Generate a unique image name using current timestamp and file extension
    $imagename = time() . '.' . $image->getClientOriginalExtension();
    
    // Move the uploaded image to the 'personalInfoimages' directory with the generated name
    $image->move('personalInfoimages', $imagename);
    
    // Set the image name in the PersonalInformation model
    $personalInformation->image = $imagename;
} 
            $personalInformation->users_id =$request->users_id;
            $personalInformation->first_name= $request->first_name;
            $personalInformation->middle_name= $request->middle_name;
            $personalInformation->last_name=  $request->last_name;

            if ($request->extension_name === 'others') {
                $personalInformation->extension_name = $request->add_extName; // Use the value entered in the "add_extenstion name" input field
           } else {
                $personalInformation->extension_name = $request->extension_name; // Use the selected color from the dropdown
           }
            $personalInformation->country=  $request->country;
            $personalInformation->province=  $request->province;
            $personalInformation->city=  $request->city;
            $personalInformation->agri_district=  $request->agri_district;
            $personalInformation->barangay=  $request->barangay;
            
             $personalInformation->home_address=  $request->home_address;
             $personalInformation->sex=  $request->sex;

             if ($request->religion=== 'other') {
                $personalInformation->religion= $request->add_Religion; // Use the value entered in the "religion" input field
           } else {
                $personalInformation->religion= $request->religion; // Use the selected religion from the dropdown
           }
             $personalInformation->date_of_birth=  $request->date_of_birth;
            
             if ($request->place_of_birth=== 'Add Place of Birth') {
                $personalInformation->place_of_birth= $request->add_PlaceBirth; // Use the value entered in the "place_of_birth" input field
           } else {
                $personalInformation->place_of_birth= $request->place_of_birth; // Use the selected place_of_birth from the dropdown
           }
             $personalInformation->contact_no=  $request->contact_no;
             $personalInformation->civil_status=  $request->civil_status;
             $personalInformation->name_legal_spouse=  $request->name_legal_spouse;

             if ($request->no_of_children=== 'Add') {
                $personalInformation->no_of_children= $request->add_noChildren; // Use the value entered in the "no_of_children" input field
                } else {
                        $personalInformation->no_of_children= $request->no_of_children; // Use the selected no_of_children from the dropdown
                }
    
             $personalInformation->mothers_maiden_name=  $request->mothers_maiden_name;
             if ($request->highest_formal_education=== 'Other') {
                $personalInformation->highest_formal_education= $request->add_formEduc; // Use the value entered in the "highest_formal_education" input field
                } else {
                        $personalInformation->highest_formal_education= $request->highest_formal_education; // Use the selected highest_formal_education from the dropdown
                }
             $personalInformation->person_with_disability=  $request->person_with_disability;
             $personalInformation->pwd_id_no=  $request->pwd_id_no;
             $personalInformation->government_issued_id=  $request->government_issued_id;
             $personalInformation->id_type=  $request->id_type;
             $personalInformation->gov_id_no=  $request->gov_id_no;
             $personalInformation->member_ofany_farmers_ass_org_coop=  $request->member_ofany_farmers_ass_org_coop;
             
             if ($request->nameof_farmers_ass_org_coop === 'add') {
                $personalInformation->nameof_farmers_ass_org_coop = $request->add_FarmersGroup; // Use the value entered in the "add_extenstion name" input field
           } else {
                $personalInformation->nameof_farmers_ass_org_coop = $request->nameof_farmers_ass_org_coop; // Use the selected color from the dropdown
           }
             $personalInformation->name_contact_person=  $request->name_contact_person;
      
             $personalInformation->cp_tel_no=  $request->cp_tel_no;
            



        
            // dd($personalInformation);
             $personalInformation->save();
            return redirect('/add-farm-profile')->with('message','Personal informations added successsfully');
        
        }
        catch(\Exception $ex){
            dd($ex); // Debugging statement to inspect the exception
            return redirect('/add-personal-info')->with('message','Someting went wrong');
            
        }   


        //inserting multiple insertion of data into database
        
        
               
          
  

}


public function farmprofiles()
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

            // Fetch user's information
            $user_id = $user->id;
            $agri_districts = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;

            // Find the user by their ID and eager load the personalInformation relationship
            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.farmprofile.add_profile', compact('agri_districts','userId','totalRiceProduction', 'agri_districts_id', 'agent', 'profile'));
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



public function AddFarmProfile(FarmProfileRequest $request)
{
    try {
        // Get authenticated user
        $user = auth()->user();

        // Validate the incoming request data
        $data = $request->validated();

        // Check if FarmProfile with the given personal_informations_id already exists
        $existingFarmProfile = FarmProfile::where('personal_informations_id', $request->input('personal_informations_id'))->first();

        if ($existingFarmProfile) {
            return redirect('/add-farm-profile')->with('error', 'Farm Profile with this information already exists.');
        }

        // Create a new FarmProfile instance
        $farmProfile = new FarmProfile;
        
        $farmProfile->users_id = $request->users_id;
        $farmProfile->personal_informations_id = $request->personal_informations_id;
        $farmProfile->agri_districts_id = $request->agri_districts_id;
        $farmProfile->agri_districts = $request->agri_districts;
        $farmProfile->tenurial_status = $request->tenurial_status === 'Add' ? $request->add_newTenure : $request->tenurial_status;
        $farmProfile->rice_farm_address = $request->rice_farm_address;
        $farmProfile->no_of_years_as_farmers = $request->no_of_years_as_farmers === 'Add' ? $request->add_newFarmyears : $request->no_of_years_as_farmers;
        $farmProfile->gps_longitude = $request->gps_longitude;
        $farmProfile->gps_latitude = $request->gps_latitude;
        $farmProfile->total_physical_area_has = $request->total_physical_area_has;
        $farmProfile->rice_area_cultivated_has = $request->rice_area_cultivated_has;
        $farmProfile->land_title_no = $request->land_title_no;
        $farmProfile->lot_no = $request->lot_no;
        $farmProfile->area_prone_to = $request->area_prone_to === 'Add Prone' ? $request->add_newProneYear : $request->area_prone_to;
        $farmProfile->ecosystem = $request->ecosystem === 'Add ecosystem' ? $request->Add_Ecosystem : $request->ecosystem;
        $farmProfile->type_rice_variety = $request->type_rice_variety;
        $farmProfile->prefered_variety = $request->prefered_variety;
        $farmProfile->plant_schedule_wetseason = $request->plant_schedule_wetseason;
        $farmProfile->plant_schedule_dryseason = $request->plant_schedule_dryseason;
        $farmProfile->no_of_cropping_yr = $request->no_of_cropping_yr === 'Adds' ? $request->add_cropyear : $request->no_of_cropping_yr;
        $farmProfile->yield_kg_ha = $request->yield_kg_ha;
        $farmProfile->rsba_register = $request->rsba_register;
        $farmProfile->pcic_insured = $request->pcic_insured;
        $farmProfile->government_assisted = $request->government_assisted;
        $farmProfile->source_of_capital = $request->source_of_capital === 'Others' ? $request->add_sourceCapital : $request->source_of_capital;
        $farmProfile->remarks_recommendation = $request->remarks_recommendation;
        $farmProfile->oca_district_office = $request->oca_district_office;
        $farmProfile->name_technicians = $request->name_technicians;
        $farmProfile->date_interview = $request->date_interview;
        // dd($farmProfile);
        // Save the new FarmProfile
        $farmProfile->save();

        // Redirect with success message
        return redirect('/add-fixed-cost')->with('message', 'Farm Profile added successfully');
    } catch (\Exception $ex) {
        // Log the exception or handle it appropriately
        dd($ex);
        return redirect('/add-farm-profile')->with('message', 'Something went wrong');
    }
}


// agent fixed cost view
// CRUD operations for [ResourceName]:
// - Create: Adds new records to the database, capturing relevant details for the resource.
// - Read: Retrieves and displays existing records from the database for analysis or reporting purposes.
// - Update: Allows modification of existing records to keep data accurate and up-to-date.
// - Delete: Removes records from the database when they are no longer needed.
// These operations provide full management of [ResourceName] data.


public function fixedCost()
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.fixedcost.add_fcost', compact('agent','totalRiceProduction','userId', 'profile', 'farmprofile'));
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

//agent add a new fixed cost

public function AddFcost(FixedCostRequest $request)
{
    try{

        $existingFixedCost =  FixedCost::where([
            ['personal_informations_id', '=', $request->input('personal_informations_id')],
            ['farm_profiles_id', '=', $request->input('farm_profiles_id')],
        

            // Add other fields here
        ])->first();
        
        if ( $existingFixedCost) {
            // FarmProfile with the given personal_informations_id and other fields already exists
            // You can handle this scenario here, for example, return an error message
            return redirect('/add-farm-profile')->with('error', 'Farm Profile with this information already exists.');
        }


        $data= $request->validated();
        $data= $request->all();
        $fixedcost= new FixedCost;
        $fixedcost->personal_informations_id = $request->personal_informations_id;
        $fixedcost->farm_profiles_id = $request->farm_profiles_id;
        $fixedcost->particular = $request->particular=== 'Other' ? $request->Add_Particular : $request->particular;
        $fixedcost->no_of_ha = $request->no_of_ha;
        $fixedcost->cost_per_ha = $request->cost_per_ha;
        $fixedcost->total_amount = $request->total_amount;
    
    //    dd($fixedcost);
        $fixedcost->save();


        return redirect('/add-machinereies-used')->with('message','Machineries Cost added successsfully');
    
    }
    catch(\Exception $ex){
        return redirect('/add-fixed-cost')->with('message','Someting went wrong');
    }
}

// CRUD operations for Machineries Used:
// - Create: Allows agents to add new machinery records, specifying details such as type, model, purpose, and associated costs used in farming operations.
// - Read: Retrieves and displays the list of machinery records for analysis, reporting, or operational planning.
// - Update: Enables editing of existing machinery records to reflect changes in usage, maintenance status, or costs.
// - Delete: Removes machinery records from the database when no longer in use or relevant.
// These operations ensure accurate management and tracking of machinery data in the farming ecosystem.


public function machineUsed()
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.machineused.add_mused', compact('agent','totalRiceProduction','userId', 'profile', 'farmprofile'));
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
// agent add new machineries used
public function AddMused(MachineriesUsedtRequest $request)
{
    try{
        $existingMachineriesUseds =  MachineriesUseds::where([
            ['personal_informations_id', '=', $request->input('personal_informations_id')],
            ['farm_profiles_id', '=', $request->input('farm_profiles_id')],
        

            // Add other fields here
        ])->first();
        
        if ($existingMachineriesUseds) {
            // FarmProfile with the given personal_informations_id and other fields already exists
            // You can handle this scenario here, for example, return an error message
            return redirect('/add-machinereies-used')->with('error', 'Farm Profile with this information already exists.');
        }



        $data= $request->validated();
        $data= $request->all();
       $machineused= new MachineriesUseds;
       $machineused-> personal_informations_id = $request->personal_informations_id;
       $machineused->farm_profiles_id = $request->farm_profiles_id;
       $machineused-> plowing_machineries_used = $request->plowing_machineries_used === 'OthersPlowing' ? $request->add_Plowingmachineries : $request->plowing_machineries_used;
       $machineused-> plo_ownership_status = $request->plo_ownership_status === 'Other' ? $request->add_PlowingStatus : $request->plo_ownership_status;
       $machineused->no_of_plowing = $request->no_of_plowing;
       $machineused->cost_per_plowing = $request->cost_per_plowing;
       $machineused-> plowing_cost = $request->plowing_cost;
        
       $machineused-> harrowing_machineries_used = $request->harrowing_machineries_used=== 'OtherHarrowing' ? $request->Add_HarrowingMachineries : $request->harrowing_machineries_used;
       $machineused->harro_ownership_status = $request->harro_ownership_status=== 'Otherharveststat' ? $request->add_harvestingStatus : $request->harro_ownership_status;
       $machineused->no_of_harrowing = $request->no_of_harrowing; 
       $machineused->cost_per_harrowing = $request->cost_per_harrowing; 
       $machineused->harrowing_cost = $request->harrowing_cost;

       $machineused->harvesting_machineries_used = $request->harvesting_machineries_used=== 'OtherHarvesting' ? $request->add_HarvestingMachineries : $request->harvesting_machineries_used;
       $machineused->harvest_ownership_status = $request->harvest_ownership_status=== 'OtherHarvesting' ? $request->add_HarvestingMachineries : $request->harvest_ownership_status;
       $machineused->harvesting_cost = $request->harvesting_cost;

       $machineused->postharvest_machineries_used = $request->postharvest_machineries_used=== 'Otherpostharvest' ? $request->add_postharvestMachineries : $request->postharvest_machineries_used;
       $machineused->postharv_ownership_status = $request->postharv_ownership_status=== 'OtherpostharvestStatus' ? $request->add_postStatus : $request->postharv_ownership_status;
       $machineused->post_harvest_cost = $request->post_harvest_cost;
       $machineused->total_cost_for_machineries = $request->total_cost_for_machineries;
         
        // dd($machineused);
        $machineused->save();
        return redirect('/add-variable-cost-seed')->with('message','Machineries Used added successsfully');
    
    }
    catch(\Exception $ex){

        dd($ex);
        return redirect('/add-machinereies-used')->with('message','Someting went wrong');
    }
}


// CRUD operations for Production Data:
// - Create: Allows agents or farmers to add new production records, including details such as crop type, yield quantity, harvest date, and associated costs or revenue.
// - Read: Retrieves and displays production data for analysis, reporting, or decision-making, such as yield trends and performance metrics.
// - Update: Enables modification of existing production records to correct errors or reflect updated information, such as adjustments to yield quantities or revenue figures.
// - Delete: Removes production records from the database when they are no longer relevant or required.
// These operations support efficient tracking and management of production data, helping optimize farming strategies and resource allocation.

// agent lastt production view

public function LastProduction()
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
            $farmId = $user->id;
            $agri_districts = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;
            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.lastproduction.add_production', compact('agent','totalRiceProduction','userId', 'profile','agri_districts_id', 'farmprofile'));
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
// agent added new last production data
public function AddNewProduction(LastProductionDatasRequest $request)
    {
        try{
            $existingLastProductionDatas =  LastProductionDatas::where([
                ['personal_informations_id', '=', $request->input('personal_informations_id')],
                ['farm_profiles_id', '=', $request->input('farm_profiles_id')],
                ['agri_districts_id', '=', $request->input('agri_districts_id')],
            
    
                // Add other fields here
            ])->first();
            
            if ($existingLastProductionDatas) {
                // FarmProfile with the given personal_informations_id and other fields already exists
                // You can handle this scenario here, for example, return an error message
                return redirect('/add-machinereies-used')->with('error', 'Farm Profile with this information already exists.');
            }
    


            $data= $request->validated();
            $data= $request->all();
           $lastproduction= new LastProductionDatas;

           $lastproduction->personal_informations_id = $request->personal_informations_id;
           $lastproduction->farm_profiles_id = $request->farm_profiles_id;
           $lastproduction->agri_districts_id = $request->agri_districts_id;
           $lastproduction->seeds_typed_used = $request->seeds_typed_used;
           $lastproduction->seeds_used_in_kg = $request->seeds_used_in_kg;
           $lastproduction->seed_source = $request->seed_source=== 'Add' ? $request->add_seedsource : $request->seed_source;
           $lastproduction->no_of_fertilizer_used_in_bags = $request->no_of_fertilizer_used_in_bags;
                
           $lastproduction->no_of_pesticides_used_in_l_per_kg = $request->no_of_pesticides_used_in_l_per_kg;
           $lastproduction->no_of_insecticides_used_in_l = $request->no_of_insecticides_used_in_l;
           $lastproduction->area_planted = $request->area_planted;
           $lastproduction->date_planted = $request->date_planted;
           $lastproduction->date_harvested = $request->date_harvested;
           $lastproduction->yield_tons_per_kg = $request->yield_tons_per_kg;
        
           $lastproduction->unit_price_palay_per_kg = $request->unit_price_palay_per_kg;
           $lastproduction->unit_price_rice_per_kg = $request->unit_price_rice_per_kg;
           $lastproduction->type_of_product = $request->type_of_product;
           $lastproduction->sold_to = $request->sold_to;
           $lastproduction->if_palay_milled_where =  $request->if_palay_milled_where;
           $lastproduction->gross_income_palay = $request->gross_income_palay;
           $lastproduction->gross_income_rice =  $request->gross_income_rice;
        
            // dd($lastproduction);
            $lastproduction->save();
            return redirect('/add-personal-info')->with('message','Rice Survey Form Completed!');
        
        }
        catch(\Exception $ex){
            return redirect('/add-last-production')->with('message','Someting went wrong');
        }
    }



// CRUD operations for Variable Cost:
// - Create: Allows agents to add new variable cost records, including expenses such as seeds, fertilizers, pesticides, labor, and other recurring costs related to farming operations.
// - Read: Retrieves and displays variable cost records for analysis, budgeting, or reporting purposes.
// - Update: Enables editing of existing variable cost records to reflect changes in expenses or correct data inaccuracies.
// - Delete: Removes variable cost records from the database when no longer relevant or applicable.
// These operations ensure accurate tracking and management of recurring farming expenses, aiding in financial planning and reporting.



 public function variableVartotal()
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
                $farmId = $user->id;
    
                // Find the farm profile using the fetched farm ID
                $farmprofile = FarmProfile::where('users_id', $farmId)->latest()->first();
                
                // Calculate total rice production
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                
                // Fetch labor information
                $labor = Labor::where('users_id', $userId)->latest()->first();
                
                // Fetch seed information
                $seed = Seed::where('users_id', $userId)->latest()->first();
                
                // Fetch fertilizer information
                $fertilizer = Fertilizer::where('users_id', $userId)->latest()->first();
                
                // Fetch pesticide information
                $pesticide = Pesticide::where('users_id', $userId)->latest()->first();
                
                // Fetch transport information
                $transport = Transport::where('users_id', $userId)->latest()->first();
    
                // Return the view with the fetched data
                return view('agent.variablecost.variable_total.add_vartotal', compact('admin', 'profile', 'farmprofile', 'totalRiceProduction', 'userId', 'labor', 'seed', 'fertilizer', 'pesticide', 'transport'));
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



// agent add new varaible cost vartotal
public function AddNewVartotal(VariableCostRequest $request)
    {
        {
            try{
                $existingVariableCost =  VariableCost::where([
                    ['personal_informations_id', '=', $request->input('personal_informations_id')],
                    ['farm_profiles_id', '=', $request->input('farm_profiles_id')],
                    ['seeds_id', '=', $request->input('seeds_id')],
                    ['labors_id', '=', $request->input('labors_id')],
                    ['fertilizers_id', '=', $request->input('fertilizers_id')],
                
                    ['pesticides_id', '=', $request->input('pesticides_id')],
                    ['transports_id', '=', $request->input('transports_id')],
                
                
        
                    // Add other fields here
                ])->first();
                
                if ($existingVariableCost) {
                    // FarmProfile with the given personal_informations_id and other fields already exists
                    // You can handle this scenario here, for example, return an error message
                    return redirect('/add-variable-cost-vartotal')->with('error', 'VariableCost with this information already exists.');
                }
                $data= $request->validated();
                $data= $request->all();
                
              $vartotal= new VariableCost;
              $vartotal->personal_informations_id = $request->personal_informations_id;
              $vartotal->farm_profiles_id = $request->farm_profiles_id;
              $vartotal->seeds_id = $request->seeds_id;
              $vartotal->labors_id = $request->labors_id;
              $vartotal->fertilizers_id = $request->fertilizers_id;
              $vartotal->pesticides_id = $request->pesticides_id;
              $vartotal->transports_id = $request->transports_id;
              $vartotal->total_seed_cost = $request->total_seed_cost;
              $vartotal->total_labor_cost = $request->total_labor_cost;
              $vartotal->total_cost_fertilizers = $request->total_cost_fertilizers;
              $vartotal->total_cost_pesticides = $request->total_cost_pesticides;
              $vartotal->total_transport_per_deliverycost = $request->total_transport_per_deliverycost;


              $vartotal->total_machinery_fuel_cost =$request->total_machinery_fuel_cost;
              $vartotal->total_variable_cost =$request->total_variable_cost;
             
            //   dd($vartotal);
               $vartotal->save();
                return redirect('/add-last-production')->with('message','Variable Cost Added Successfully');
            
            }
            catch(\Exception $ex){
                // dd($ex);
                return redirect('/add-variable-cost-vartotal')->with('message','Someting went wrong');
            }
        }
    }





// checking of datta inserted for personal information

public function viewpersoninfo(Request $request)
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
            $personalinfos = $personalinfos->paginate(20);

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
            return view('agent.personal_info.view_infor', compact('agent', 'profile', 'personalinfos','farmProfiles','fixedcosts','machineries','variable','productions','totalRiceProduction'));
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





// update the personal info
public function   updateview($id){
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
            $farmId = $user->id;
            $agri_district = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;
            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $personalinfos=PersonalInformations::find($id);
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.personal_info.update_records', compact('agent','agri_district', 'profile', 'userId','farmprofile','personalinfos','totalRiceProduction'));
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


// edit the receipt form
public function updateinfo(PersonalInformationsRequest $request,$id)
{
  
    try{
        

        $data= $request->validated();
        $data= $request->all();
        $data= PersonalInformations::find($id);
                                    
                // Check if a file is present in the request and if it's valid
                if ($request->hasFile('personal_photo') && $request->file('personal_photo')->isValid()) {
                    // Retrieve the personal_photo file from the request
                    $personal_photo = $request->file('personal_photo');

                    // Generate a unique personal_photo name using current timestamp and file extension
                    $imagename = time() . '.' . $personal_photo->getClientOriginalExtension();

                    // Move the uploaded personal_photo to the 'productimages' directory with the generated name
                    $personal_photo->move('farmimages', $imagename);

                    // Delete the previous personal_photo file, if exists
                    if ($data->personal_photo) {
                        Storage::delete('farmimages/' . $data->personal_photo);
                    }

                    // Set the personal_photo name in the Product data
                    $data->personal_photo = $imagename;
                }
            $data->first_name = $request->first_name;
        $data->middle_name = $request->middle_name;
        $data->last_name = $request->last_name;
        $data->extension_name = $request->extension_name;
        $data->home_address = $request->home_address;
        $data->sex = $request->sex;
        $data->religion = $request->religion;
        $data->date_of_birth = $request->date_of_birth;
        $data->place_of_birth = $request->place_of_birth;
        $data->contact_no = $request->contact_no;
        $data->civil_status = $request->civil_status;
        $data->name_legal_spouse = $request->name_legal_spouse;

        $data->no_of_children = $request->no_of_children;
        $data->mothers_maiden_name = $request->mothers_maiden_name;
        $data->highest_formal_education = $request->highest_formal_education;
        $data->person_with_disability = $request->person_with_disability;
        $data->pwd_id_no = $request->pwd_id_no;
        $data->government_issued_id = $request->government_issued_id;
        $data->id_type = $request->id_type;
        $data->gov_id_no = $request->gov_id_no;
        $data->member_ofany_farmers_ass_org_coop = $request->member_ofany_farmers_ass_org_coop;
        $data->nameof_farmers_ass_org_coop = $request->nameof_farmers_ass_org_coop;
        $data->name_contact_person = $request->name_contact_person;
        $data->cp_tel_no = $request->cp_tel_no;
        $data->cp_tel_no = $request->cp_tel_no;

      
         $data->save();     
        
       
        return redirect('/agent-show-personal-info')->with('message','Personal informations Updated successsfully');
    
    }
    catch(\Exception $ex){
        // dd($ex); // Debugging statement to inspect the exception
        return redirect('/agent-update-personal-info/{personalinfos}')->with('message','Someting went wrong');
        
    }   
} 

// deleting personal informations
public function infodelete($id) {
    try {
        // Find the personal information by ID
        $personalinformations = PersonalInformations::find($id);

        // Check if the personal information exists
        if (!$personalinformations) {
            return redirect()->back()->with('error', 'Personal information not found');
        }

        // Delete the personal information data from the database
        $personalinformations->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Personal information deleted successfully');

    } catch (\Exception $e) {
        // Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
    }
}


// view the fetch data of farm

public function  showfarm(){
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $farmprofiles=FarmProfile::orderBy('id','desc')->paginate(20);
            // Return the view with the fetched data
            return view('agent.farmprofile.farm_view', compact('agent', 'profile', 'farmprofile','farmprofiles'));
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
public function  farmUpdate($id){
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
            $farmId = $user->id;
            $agri_districts = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;
            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $farmProfiles=FarmProfile::find($id);
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.farmprofile.farm_update', compact('agent','agri_districts_id','agri_districts' ,'profile','totalRiceProduction','userId', 'farmprofile','farmProfiles'));
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
    public function updatesFarm(FarmProfileRequest $request,$id)
    {
    
        try{
            

            $data= $request->validated();
            $data= $request->all();
            
            $data= FarmProfile::find($id);

 // Check if a file is present in the request and if it's valid
 if ($request->hasFile('farm_images') && $request->file('farm_images')->isValid()) {
    // Retrieve the farm_images file from the request
    $farm_images = $request->file('farm_images');

    // Generate a unique farm_images name using current timestamp and file extension
    $imagename = time() . '.' . $farm_images->getClientOriginalExtension();

    // Move the uploaded farm_images to the 'productimages' directory with the generated name
    $farm_images->move('farmimages', $imagename);

    // Delete the previous farm_images file, if exists
    if ($data->farm_images) {
        Storage::delete('farmimages/' . $data->farm_images);
    }

    // Set the farm_images name in the Product data
    $data->farm_images = $imagename;
}
            $data->personal_informations_id = $request->personal_informations_id;  
            $data->agri_districts_id = $request->agri_districts_id;
            $data->tenurial_status = $request->tenurial_status;
            $data->rice_farm_address = $request->rice_farm_address;
            $data->no_of_years_as_farmers = $request->no_of_years_as_farmers;
            $data->gps_longitude = $request->gps_longitude;
            $data->gps_latitude = $request->gps_latitude;
            $data->total_physical_area_has = $request->total_physical_area_has;
            $data->rice_area_cultivated_has = $request->rice_area_cultivated_has;
            $data->rice_area_cultivated_has = $request->rice_area_cultivated_has;
            $data->land_title_no = $request->land_title_no;
            $data->lot_no = $request->lot_no;
            $data->area_prone_to= $request->area_prone_to;

            $data->ecosystem = $request->ecosystem;
            $data->type_rice_variety = $request->type_rice_variety;
            $data->prefered_variety = $request->prefered_variety;
            $data->plant_schedule_wetseason = $request->plant_schedule_wetseason;
            $data->plant_schedule_dryseason = $request->plant_schedule_dryseason;
            $data->no_of_cropping_yr = $request->no_of_cropping_yr;
            $data->yield_kg_ha = $request->yield_kg_ha;
            $data->rsba_register = $request->rsba_register;
            $data->pcic_insured = $request->pcic_insured;
            $data->source_of_capital = $request->source_of_capital;
            $data->remarks_recommendation = $request->remarks_recommendation;
            $data->oca_district_office = $request->oca_district_office;
            $data->name_technicians = $request->name_technicians;
            $data->date_interview = $request->date_interview;

            
            $data->save();     
            
        
            return redirect('/agent-show-personal-info')->with('message','Farm Profile Data Update successsfully');
        
        }
        catch(\Exception $ex){
            // dd($ex); // Debugging statement to inspect the exception
            return redirect('/agent-update-farm-profile/{farmProfiles}')->with('message','Someting went wrong');
            
        }   
    } 

//Farm profile delete
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

// fixed cost view

public function  viewFixed(){
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $fixedcosts=FixedCost::orderBy('id','desc')->paginate(20);
            // Return the view with the fetched data
            return view('agent.fixedcost.fcost_view', compact('agent', 'profile', 'farmprofile','fixedcosts'));
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
// fixed cost update

public function FixedUpdate($id){
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $fixedcosts=FixedCost::find($id);

            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.fixedcost.fixed_updates', compact('agent','userId', 'profile','totalRiceProduction', 'farmprofile','fixedcosts'));
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

public function UpdateFixedCost(FixedCostRequest $request,$id)
{

    try{
        

        $data= $request->validated();
        $data= $request->all();
        
        $data= FixedCost::find($id);

        $data->personal_informations_id = $request->personal_informations_id;  
        $data->farm_profiles_id = $request->farm_profiles_id;
        $data->particular = $request->particular;
        $data->no_of_ha = $request->no_of_ha;
        $data->cost_per_ha = $request->cost_per_ha;
        $data->total_amount = $request->total_amount;
  
       

        
        $data->save();     
        
    
        return redirect('/agent-show-personal-info')->with('message','Fixed cost Data Updated successsfully');
    
    }
    catch(\Exception $ex){
        // dd($ex); // Debugging statement to inspect the exception
        return redirect('/agent-update-fixed-cost/{fixedcosts}')->with('message','Someting went wrong');
        
    }   
} 

public function fixedcostdelete($id) {
    try {
        // Find the personal information by ID
       $fixedcosts = FixedCost::find($id);

        // Check if the personal information exists
        if (!$fixedcosts) {
            return redirect()->back()->with('error', 'Farm Profilenot found');
        }

        // Delete the personal information data from the database
       $fixedcosts->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Fixed Cost deleted Successfully');

    } catch (\Exception $e) {
        // Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
    }
}



// machineries used view 

public function MachineUpdate($id){
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $machineries=MachineriesUseds::find($id);

            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.machineused.update_machine', compact('agent','userId', 'profile','totalRiceProduction', 'farmprofile','machineries'));
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




public function machinedelete($id) {
    try {
        // Find the personal information by ID
      $machineries =MachineriesUseds::find($id);

        // Check if the personal information exists
        if (!$machineries) {
            return redirect()->back()->with('error', 'Farm Profilenot found');
        }

        // Delete the personal information data from the database
      $machineries->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Machineries Used deleted Successfully');

    } catch (\Exception $e) {
        dd($e);// Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
    }
}

// last production view

public function viewProduction(){
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $productions= LastProductionDatas::orderBy('id','desc')->paginate(20);
            // Return the view with the fetched data
            return view('agent.lastproduction.view_prod', compact('agent', 'profile', 'farmprofile','productions'));
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

// last prduction view update

public function produpdate($id){
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
            $farmId = $user->id;
            $agri_district = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;
            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $productions= LastProductionDatas::find($id);

            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.lastproduction.last_edit', compact('agent','userId', 'profile','totalRiceProduction','agri_districts_id', 'farmprofile','productions'));
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
 public function update(LastProductionDatasRequest $request,$id)
{

    try{
        

        $data= $request->validated();
        $data= $request->all();
        
        $data=LastProductionDatas::find($id);

        $data->personal_informations_id = $request->personal_informations_id;  
        $data->farm_profiles_id = $request->farm_profiles_id;
        $data->agri_districts_id = $request->agri_districts_id;

        $data->seeds_typed_used = $request->seeds_typed_used;
        $data->seeds_used_in_kg = $request->seeds_used_in_kg;
        $data->seed_source = $request->seed_source;
        
        $data->no_of_fertilizer_used_in_bags = $request->no_of_fertilizer_used_in_bags;
        $data->no_of_pesticides_used_in_l_per_kg = $request->no_of_pesticides_used_in_l_per_kg;
        $data->no_of_insecticides_used_in_l = $request->no_of_insecticides_used_in_l;

        $data->area_planted = $request->area_planted;
        $data->date_planted = $request->date_planted;
        $data->date_harvested = $request->date_harvested;
        $data->yield_tons_per_kg = $request->yield_tons_per_kg;
        $data->unit_price_palay_per_kg = $request->unit_price_palay_per_kg;
        $data->unit_price_rice_per_kg = $request->unit_price_rice_per_kg;
        $data->type_of_product = $request->type_of_product;
       
        $data->sold_to = $request->sold_to;
  
        $data->if_palay_milled_where= $request->if_palay_milled_where;
        
        $data->gross_income_palay = $request->gross_income_palay;
        
        $data->gross_income_rice= $request->gross_income_rice;

        
        $data->save();     
        
    
        return redirect('/agent-show-personal-info')->with('message','Last Production Data Updated successsfully');
    
    }
    catch(\Exception $ex){
        // dd($ex); // Debugging statement to inspect the exception
        return redirect('/agent-update-last-production/{production}')->with('message','Someting went wrong');
        
    }   
} 


// update the production
public function ProductionDelete($id) {
    try {
        // Find the personal information by ID
       $productions =LastProductionDatas::find($id);

        // Check if the personal information exists
        if (! $productions) {
            return redirect()->back()->with('error', 'Farm Profilenot found');
        }

        // Delete the personal information data from the database
       $productions->delete();

        // Redirect back with success message
        return redirect()->back()->with('message', 'Last Production Data deleted Successfully');

    } catch (\Exception $e) {
        dd($e);// Handle any exceptions and redirect back with error message
        return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
    }
}

// varaible cost view, edit, update and delete access by agent

public function displayvar(){
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $variable= VariableCost::orderBy('id','desc')->paginate(10);
            // Return the view with the fetched data
            return view('agent.variablecost.variable_total.show_var', compact('agent', 'profile', 'farmprofile','variable'));
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

// update the variale cost total


public function varupdate($id){
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
            $farmId = $user->id;
            $agri_district = $user->agri_district;
            $agri_districts_id = $user->agri_districts_id;
            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $variable= VariableCost::find($id);

            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.variablecost.variable_total.var_edited', compact('agent','userId', 'profile','totalRiceProduction', 'farmprofile','variable'));
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

public function updatevaria(VariableCostRequest $request,$id)
{

   try{
       

       $data= $request->validated();
       $data= $request->all();
       
       $data=VariableCost::find($id);

       $data->personal_informations_id = $request->personal_informations_id;  
       $data->farm_profiles_id = $request->farm_profiles_id;


       $data->seeds_id = $request->seeds_id;
       $data->labors_id = $request->labors_id;
       $data->fertilizers_id = $request->fertilizers_id;
       
       $data->pesticides_id = $request->pesticides_id;
       $data->transports_id = $request->transports_id;
       $data->total_machinery_fuel_cost = $request->total_machinery_fuel_cost;

       $data->total_variable_cost = $request->total_variable_cost;
 
       $data->save();     
       
   
       return redirect('/agent-show-personal-info')->with('message','Variable Cost Data Updated successsfully');
   
   }
   catch(\Exception $ex){
       dd($ex); // Debugging statement to inspect the exception
       return redirect('/agent-update-variable-cost/{variables}')->with('message','Someting went wrong');
       
   }   
} 


public function vardelete($id) {
   try {
       // Find the personal information by ID
     $variable =VariableCost::find($id);

       // Check if the personal information exists
       if (!$variable) {
           return redirect()->back()->with('error', 'Farm Profilenot found');
       }

       // Delete the personal information data from the database
     $variable->delete();

       // Redirect back with success message
       return redirect()->back()->with('message', 'Variable Cost deleted Successfully');

   } catch (\Exception $e) {
       dd($e);// Handle any exceptions and redirect back with error message
       return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
   }
}




// agent update profile
public function AgentProfile(){
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
            $farmId = $user->id;

            // Find the farm profile using the fetched farm ID
            $farmprofile = FarmProfile::where('id', $farmId)->latest()->first();
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.profile.agent_profiles', compact('agent', 'profile','totalRiceProduction', 'farmprofile'));
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


public function Agentupdate(Request $request){
   
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
            $image->move('agentimages', $imagename);

            // Delete the previous image file, if exists
            if ($data->image) {
                Storage::delete('agentimages/' . $data->image);
            }

            // Set the image name in the Product data
            $data->image = $imagename;
        }

    // $data->first_name= $request->first_name;
    // $data->last_name= $request->last_name;
    // $data->email= $request->email;
    // $data->agri_district= $request->agri_district;
    
    
 
     
   $data->save();
     // Redirect back after processing
     return redirect()->route('agent.profile.agent_profiles')->with('message', 'Profile updated successfully');
    } else {
        // Redirect back with error message if product not found
        return redirect()->back()->with('error', 'Product not found');
    }
} catch (\Exception $e) {
    dd($e);
    // Handle any exceptions and redirect back with error message
    return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
}
}



// map view by agent
public function mapView($id){
    $personlinformation=PersonalInformations::find($id);
    return view('map.view_map_info',compact('personlinformation'));
}














// multiple impor of excels in Dataase access by agent
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




// Function to display all crop data, including rice corn  map using Google Maps API. 
// This feature visualizes the geographical distribution of crops by plotting their locations and associated data on the map.
// It enhances user understanding of crop patterns and distribution across different regions.

        public function CornMap(Request $request) {
            // Check if the user is authenticated
            if (Auth::check()) {
                // User is authenticated
                $userId = Auth::id();
                $agent = User::find($userId);
                
                if ($agent) {
                    // Find the user's personal information by their ID
                    $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                    $polygons = Polygon::all();
                    // Fetch all farm profiles
                    $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])
                    ->whereHas('cropFarms', function ($query) use ($userId) {
                        $query->where('users_id', $userId);
                    })
                    ->get();
                
    
        
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
                            'agent' => $agent,
                            'profile' => $profile,
                            'farmProfiles' => $farmProfiles,
                            'totalRiceProduction' => $totalRiceProduction,
                            'gpsData' => $gpsData,
                            'polygons' => $polygonsData,
                            'districtsData' => $districtsData // Send all district GPS coordinates
                        ]);
                    } else {
                        // Return the view with the fetched data for regular requests
                        return view('agent.agri.cornmap', [
                            'agent' => $agent,
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
        
   // agent view coconut map farmers
   public function CoconutMaps(){
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
    return view('agent.agri.coconutmap', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
    
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


   // agent view Chicken map farmers
   public function ChickenMap(){
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
    return view('agent.agri.chickenmap', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
    
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

   // agent view Hogs map farmers
   public function HogsMap(){
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
    return view('agent.agri.hogsmap', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
    
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


        // agent CORN
          // agent view CORN REPORT/AGRIDISTRICT
   public function ayalaCorn(){
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
    return view('agent.corn.districtreport.ayala', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
    
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

        // agent view forms
              // agent CORN
          // agent view CORN REPORT/AGRIDISTRICT
   public function CornForm(){
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
    return view('agent.corn.forms.corn_form', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
    
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
                return view('agent.corn.farmersInfo.information', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
                
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
                return view('agent.corn.variety.varieties', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
                
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
            // agent view production
            public function Productions(){
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
                return view('agent.corn.production.reportsproduce', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
                
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

            public function AgentAllCrops(Request $request)
            {
                if (Auth::check()) {
                    $userId = Auth::id();
                    $agent = User::find($userId);
            
                    if ($agent) {
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
                $farmersTable = view('agent.partials.farmers_table', compact('paginatedFarmers'))->render();
                $paginationLinks = view('agent.partials.pagination', compact('paginatedFarmers'))->render(); // Assuming you place the pagination markup in this view
            
                return response()->json([
                    'farmers' => $farmersTable,
                    'pagination' => $paginationLinks,
                ]);
            }
            
            
                        
                        return view('agent.CropReport.all_crops', compact(
                            'totalFarms', 'totalAreaPlanted', 'totalAreaYield', 'totalCost', 'yieldPerAreaPlanted',
                            'averageCostPerAreaPlanted', 'totalRiceProduction', 'pieChartData', 'barChartData',
                            'selectedCropName', 'selectedDateFrom', 'selectedDateTo', 'crops', 'districts', 'selectedDistrict',
                            'minDate', 'maxDate', 'agent', 'pieChartDatas','distributionFrequency','flatFarmers','paginatedFarmers'
                        ));
                    } else {
                        return redirect()->route('login')->with('error', 'User not found.');
                    }
                } else {
                    return redirect()->route('login');
                }
            }
            
           
    


public function ViewSurveyForm(Request $request) {
    // Check if the user is authenticated
    if (Auth::check()) {
         // User is authenticated, proceed with retrieving the user's ID
        $user = Auth::user(); // You can use Auth::user() directly
        $userId = $user->id; // Get the authenticated user's ID
        $agent = User::find($userId); // Fetch user details
        
        if ($agent) {
            $agri_district = $user->district;
                        $selectMember = $user->select_member; // Assuming `select_member` is the correct attribute
            
                        // Find the user's personal information
                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
            
                        // Fetch the farm ID and agri district ID associated with the user
                        $farmId = $user->farm_id;
                        $agri_districts_id = $user->agri_districts_id;
            
                        // Find the farm profile using the fetched farm ID
                        $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
            
                        // Find the user's personal information
                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

                    // Fetch the farm ID and agri district ID associated with the user
                    $farmId = $user->farm_id;
                    $agri_districts_id = $user->agri_districts_id;
    
            // Find the user's personal information by their ID
            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
            $polygons = Polygon::all();
            // Fetch all farm profiles
            $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])->get();


            // Fetch all agri districts
            $agriDistricts = AgriDistrict::all(); // Get all agri districts
// Handle AJAX requests
         // Handle AJAX requests
         if ($request->ajax()) {
            $type = $request->input('type');

               // Handle requests for districts based on logged-in user's agri_district
if ($type === 'districts') {
    // Fetch districts where the logged-in user has access
    $districts = User::where('district', $agri_district)
                     ->distinct()
                     ->pluck('district', 'district');
    return response()->json($districts);
}

// Handle requests for barangays based on the logged-in user's agri_district
if ($type === 'barangays') {
    $district = $request->input('district');

    // Check if a district is provided
    if (!$district) {
        return response()->json(['error' => 'District is required.'], 400);
    }

    // Fetch barangays that belong to the selected district and logged-in user's agri_district
    $barangays = Barangay::where('district', $district)
                         ->where('district', $agri_district)
                         ->pluck('barangay_name', 'barangay_name');
    return response()->json($barangays);
}

// Handle requests for organizations based on the logged-in user's agri_district
if ($type === 'organizations') {
    $district = $request->input('district');

    // Check if a district is provided
    if (!$district) {
        return response()->json(['error' => 'District is required.'], 400);
    }

    // Fetch organizations that belong to the selected district and logged-in user's agri_district
    $organizations = FarmerOrg::where('district', $district)
                              ->where('district', $agri_district)
                              ->pluck('organization_name', 'organization_name');
    return response()->json($organizations);
}

            // Handle requests for crop names
            if ($type === 'crops') {
                $crops = CropCategory::pluck('crop_name', 'crop_name');
                return response()->json($crops);
            }

            // Handle requests for crop varieties based on the selected crop name
            if ($type === 'varieties') {
                $cropName = $request->input('crop_name');
                if (!$cropName) {
                    return response()->json(['error' => 'Crop name is required.'], 400);
                }
                $varieties = Categorize::where('crop_name', $cropName)->pluck('variety_name', 'variety_name');
                return response()->json($varieties);
            }

            // Handle requests for seed names based on the selected variety name
            if ($type === 'seedname') {
                $varietyName = $request->input('variety_name');
                if (!$varietyName) {
                    return response()->json(['error' => 'Variety name is required.'], 400);
                }
                $seeds = Seed::where('variety_name', $varietyName)->pluck('seed_name', 'seed_name');
                return response()->json($seeds);
            }

            // Invalid request type
            return response()->json(['error' => 'Invalid type parameter.'], 400);
        }


            // Fetch total rice production
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

              

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
                    'agent' => $agent,
                    'profile' => $profile,
                    'farmProfiles' => $farmProfiles,
                    'totalRiceProduction' => $totalRiceProduction,
                
                    'polygons' => $polygonsData,
                    'districtsData' => $districtsData // Send all district GPS coordinates
                ]);
            } else {
                // Return the view with the fetched data for regular requests
                return view('agent.SurveyForm.new_farmer', [
                    'agent' => $agent,
                    'profile' => $profile,
                    'farmProfiles' => $farmProfiles,
                    'totalRiceProduction' => $totalRiceProduction,
                    'userId' =>$userId, 
                    'agri_district'=>$agri_district, 
                    'agri_districts_id'=>$agri_districts_id, 
                    'selectMember'=>$selectMember,
             
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

            // agent access farmer crops survey form
            public function AgentSurveyForm(Request $request)
            {
                // Farmer Information
                $farmerdata = $request->farmer;
            
                // Check for existing farmer
                $existingFarmer = PersonalInformations::where('last_name', $farmerdata['last_name'])
                    ->where('first_name', $farmerdata['first_name'])
                    ->where('mothers_maiden_name', $farmerdata['mothers_maiden_name'])
                    ->where('date_of_birth', $farmerdata['date_of_birth'])
                    ->first();
            
                if ($existingFarmer) {
                    return response()->json([
                        'error' => 'A record with this last name, first name, mother\'s maiden name, and date of birth already exists.'
                    ], 400);
                }
            
                // Save farmer info
                $farmerModel = new PersonalInformations();
                $farmerModel -> users_id = $farmerdata['users_id'];
      $farmerModel -> first_name = $farmerdata['first_name'];
      $farmerModel -> middle_name= $farmerdata['middle_name'];
      $farmerModel -> last_name= $farmerdata['last_name'];
      $farmerModel -> extension_name = $farmerdata['extension_name'];
      $farmerModel -> country= $farmerdata['country'];
      $farmerModel -> province= $farmerdata['province'];
      $farmerModel -> city = $farmerdata['city'];
      $farmerModel -> agri_district = $farmerdata['districts'];
      $farmerModel -> district= $farmerdata['agri_district'];
      $farmerModel -> barangay= $farmerdata['barangay'];
    //   $farmerModel -> home_address= $farmerdata['home_address'];
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
      $farmerModel -> pwd_id_no= $farmerdata['YEspwd_id_no'];
      $farmerModel -> government_issued_id= $farmerdata['government_issued_id'];
      $farmerModel -> id_type = $farmerdata['id_type'];
      $farmerModel -> gov_id_no= $farmerdata['add_Idtype'];
      $farmerModel -> member_ofany_farmers_ass_org_coop= $farmerdata['member_ofany_farmers'];
      $farmerModel -> nameof_farmers_ass_org_coop = $farmerdata['nameof_farmers'];
      $farmerModel -> name_contact_person= $farmerdata['name_contact_person'];
      $farmerModel -> cp_tel_no= $farmerdata['cp_tel_no'];
      $farmerModel -> date_interview= $farmerdata['date_of_interviewed'];
      $farmerModel ->save();
                $farmer_id = $farmerModel->id;
            
                // Farm Information
                $farms = $request->farm;
                $farmProfile = new FarmProfile();
                $farmProfile->fill([
                    'users_id' =>1,
                    'agri_districts_id' => 1,
                    'agri_districts' => $farmerModel->agri_district,
                    'personal_informations_id' => $farmer_id,
                    'tenurial_status' => $farms['tenurial_status'] ?? null,
                    'farm_address' => $farms['farm_address'] ?? null,
                    'no_of_years_as_farmers' => $farms['no_of_years_as_farmers'] ?? null,
                    'gps_longitude' => $farms['gps_longitude'] ?? null,
                    'gps_latitude' => $farms['gps_latitude'] ?? null,
                    'total_physical_area' => $farms['total_physical_area'] ?? null,
                    'total_area_cultivated' => $farms['total_area_cultivated'] ?? null,
                    'land_title_no' => $farms['land_title_no'] ?? null,
                    'lot_no' => $farms['lot_no'] ?? null,
                    'area_prone_to' => $farms['area_prone_to'] ?? null,
                    'ecosystem' => $farms['ecosystem'] ?? null,
                    'rsba_registered' => $farms['rsba_register'] ?? null,
                    'pcic_insured' => $farms['pcic_insured'] ?? null,
                    'government_assisted' => $farms['government_assisted'] ?? null,
                    'source_of_capital' => $farms['source_of_capital'] ?? null,
                    'remarks_recommendation' => $farms['remarks'] ?? null,
                    'oca_district_office' => $farmerModel->district,
                    'name_of_field_officer_technician' => $farms['name_technicians'] ?? null,
                    'date_interviewed' => $farms['date_interview'] ?? null
                ]);
                $farmProfile->save();
                $farm_id = $farmProfile->id;
                $users_id = $farmProfile->users_id;
            
                // Save crops and related data
                foreach ($request->crops as $crop) {
                    $cropModel = new Crop();
                    $cropModel->fill([
                        'farm_profiles_id' => $farm_id,
                        'crop_name' => $crop['crop_name'],
                        'users_id' => $users_id,
                        'planting_schedule_dryseason' => $crop['variety']['dry_season'] ?? null,
                        'no_of_cropping_per_year' => $crop['variety']['no_cropping_year'] ?? null,
                        'preferred_variety' => $crop['variety']['preferred'] ?? null,
                        'type_of_variety_planted' => $crop['variety']['type_variety'] ?? null,
                        'planting_schedule_wetseason' => $crop['variety']['wet_season'] ?? null,
                        'yield_kg_ha' => $crop['variety']['yield_kg_ha'] ?? null
                    ]);
                    $cropModel->save();
            
                    $crop_id = $cropModel->id;
            
                    // Save production data
                    $productionModel = new LastProductionDatas();
                    $productionModel->fill([
                        'users_id' => $users_id,
                        'farm_profiles_id' => $farm_id,
                        'crops_farms_id' => $crop_id,
                        'seed_source' => $crop['production']['seedSource'] ?? null,
                        'seeds_used_in_kg' => $crop['production']['seedUsed'] ?? null,
                        'seeds_typed_used' => $crop['production']['seedtype'] ?? null,
                        'no_of_fertilizer_used_in_bags' => $crop['production']['fertilizedUsed'] ?? null,
                        'no_of_insecticides_used_in_l' => $crop['production']['insecticide'] ?? null,
                        'no_of_pesticides_used_in_l_per_kg' => $crop['production']['pesticidesUsed'] ?? null,
                        'area_planted' => $crop['production']['areaPlanted'] ?? null,
                        'date_planted' => $crop['production']['datePlanted'] ?? null,
                        'date_harvested' => $crop['production']['Dateharvested'] ?? null,
                        'unit' => $crop['production']['unit'] ?? null,
                        'yield_tons_per_kg' => $crop['production']['yieldkg'] ?? null
                    ]);
                    $productionModel->save();
                    $productionId = $productionModel->id;
            
                    // Save sales data
                    foreach ($crop['sales'] as $sale) {
                        $salesModel = new ProductionSold();
                        $salesModel->last_production_datas_id = $productionId;
                        $salesModel->sold_to = $sale['soldTo'];
                        $salesModel->measurement = $sale['measurement'];
                        $salesModel->unit_price_rice_per_kg = $sale['unit_price'];
                        $salesModel->quantity = $sale['quantity'];
                        $salesModel->gross_income = $sale['grossIncome'];
                        $salesModel->save();
                    }
            
                    // Save fixed cost
                    $fixedcostModel = new FixedCost();
                    $fixedcostModel->users_id = $users_id;
                    $fixedcostModel->farm_profiles_id = $farm_id;
                    $fixedcostModel->crops_farms_id = $crop_id;
                    $fixedcostModel->last_production_datas_id = $productionId;
                    $fixedcostModel->particular = $crop['fixedCost']['particular'];
                    $fixedcostModel->no_of_ha = $crop['fixedCost']['no_of_has'];
                    $fixedcostModel->cost_per_ha = $crop['fixedCost']['costperHas'];
                    $fixedcostModel->total_amount = $crop['fixedCost']['TotalFixed'];
                    $fixedcostModel->save();
            
                    // Save machineries data
                    $machineriesModel = new MachineriesUseds();
                    $machineriesModel->users_id = $users_id;
                    $machineriesModel->farm_profiles_id = $farm_id;
                    $machineriesModel->crops_farms_id = $crop_id;
                    $machineriesModel->last_production_datas_id = $productionId;
                    $machineriesModel->plowing_machineries_used = $crop['machineries']['PlowingMachine'];
                    $machineriesModel->plo_ownership_status = $crop['machineries']['plow_status'];
                    $machineriesModel->no_of_plowing = $crop['machineries']['no_of_plowing'];
                    $machineriesModel->plowing_cost = $crop['machineries']['cost_per_plowing'];
                    $machineriesModel->plowing_cost_total = $crop['machineries']['plowing_cost'];
                    $machineriesModel->harrowing_machineries_used = $crop['machineries']['harro_machine'];
                    $machineriesModel->harro_ownership_status = $crop['machineries']['harro_ownership_status'];
                    $machineriesModel->no_of_harrowing = $crop['machineries']['no_of_harrowing'];
                    $machineriesModel->harrowing_cost = $crop['machineries']['cost_per_harrowing'];
                    $machineriesModel->harrowing_cost_total = $crop['machineries']['harrowing_cost_total'];
                    $machineriesModel->harvesting_machineries_used = $crop['machineries']['harvest_machine'];
                    $machineriesModel->harvest_ownership_status = $crop['machineries']['harvest_ownership_status'];
                    $machineriesModel->harvesting_cost_total = $crop['machineries']['Harvesting_cost_total'];
                    $machineriesModel->postharvest_machineries_used = $crop['machineries']['postharves_machine'];
                    $machineriesModel->postharv_ownership_status = $crop['machineries']['postharv_ownership_status'];
                    $machineriesModel->post_harvest_cost = $crop['machineries']['post_harvest_cost'];
                    $machineriesModel->post_harvest_cost_total = $crop['machineries']['post_harvest_cost_total'];
                    $machineriesModel->save();
                }
            
                $user = $farmProfile->user; // Assuming you have a relation to the User model
                $user->notify(new AdminNotification($farmProfile));
            
                return response()->json([
                    'success' => 'Data saved and notifications sent successfully!'
                ]);
            }
            
            


    // view the personalinfo by admin
public function ViewFarmers(Request $request)
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

            // Fetch all personal information
            $personalinfos = PersonalInformations::where('users_id', auth()->id())  // Filter based on the authenticated user's id
            ->orderBy('id', 'asc');
        
        
        
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
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('agent.FarmerInfo.farmers_view', compact('agent', 'profile', 'personalinfos','farmProfiles','districts'));
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
                    // farmers edit info access by agent
                    public function FarmersInfoEdit(Request $request,$id)
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
                                $agri_district = $user->agri_district;
                                $agri_districts_id = $user->agri_districts_id;
                                // Find the farm profile using the fetched farm ID
                                $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                                $personalinfos= PersonalInformations::find($id);
                        // Handle AJAX requests
                        if ($request->ajax()) {
                            $type = $request->input('type');


                            // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                            if ($type === 'personalinfos') {
                                $personalinfos = PersonalInformations::find($id); // Find the fixed cost data by ID
                                if ($personalinfos) {
                                    return response()->json($personalinfos); // Return the data as JSON
                                } else {
                                    return response()->json(['error' => 'farm data not found.'], 404);
                                }
                            }


                             // Handle the 'archives' request type for fetching archives by PersonalInformations ID
                    if ($type === 'archives') {
                        // First, check if the PersonalInformation record exists
                        $personalinfos = PersonalInformations::find($id);

                        // If the PersonalInformation record is not found, return a 404 with the message
                        if (!$personalinfos) {
                            return response()->json(['message' => 'Personal Information not found.'], 404);
                        }

                        // Fetch the archives associated with the PersonalInformation ID
                        $archives = PersonalInformationArchive::where('personal_informations_id', $id)->get();

                        // If no archives are found, return a message
                        if ($archives->isEmpty()) {
                            return response()->json(['message' => 'No archive record yet.'], 404);
                        }

                        // Return the archives data as JSON
                        return response()->json($archives);
                    }

                            // Handle requests for agri-districts
                            if ($type === 'districts') {
                                $districts = AgriDistrict::pluck('district', 'district'); // Fetch agri-district names
                                return response()->json($districts);
                            }

                            // Handle requests for barangays based on the selected district
                            if ($type === 'barangays') {
                                $district = $request->input('district');
                                if (!$district) {
                                    return response()->json(['error' => 'District is required.'], 400);
                                }
                                $barangays = Barangay::where('district', $district)->pluck('barangay_name', 'barangay_name');
                                return response()->json($barangays);
                            }

                            // Handle requests for organizations based on the selected district
                            if ($type === 'organizations') {
                                $district = $request->input('district');
                                if (!$district) {
                                    return response()->json(['error' => 'District is required.'], 400);
                                }
                                $organizations = FarmerOrg::where('district', $district)->pluck('organization_name', 'organization_name');
                                return response()->json($organizations);
                            }

                            // Handle requests for crop names
                            if ($type === 'crops') {
                                $crops = CropCategory::pluck('crop_name', 'crop_name');
                                return response()->json($crops);
                            }

                            // Handle requests for crop varieties based on the selected crop name
                            if ($type === 'varieties') {
                                $cropName = $request->input('crop_name');
                                if (!$cropName) {
                                    return response()->json(['error' => 'Crop name is required.'], 400);
                                }
                                $varieties = Categorize::where('crop_name', $cropName)->pluck('variety_name', 'variety_name');
                                return response()->json($varieties);
                            }

                            // Handle requests for seed names based on the selected variety name
                            if ($type === 'seedname') {
                                $varietyName = $request->input('variety_name');
                                if (!$varietyName) {
                                    return response()->json(['error' => 'Variety name is required.'], 400);
                                }
                                $seeds = Seed::where('variety_name', $varietyName)->pluck('seed_name', 'seed_name');
                                return response()->json($seeds);
                            }

                            // Invalid request type
                            return response()->json(['error' => 'Invalid type parameter.'], 400);
                        }


                                
                                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                                // Return the view with the fetched data
                                return view('agent.FarmerInfo.crudfarmer.edit', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
                                ,'personalinfos','userId','agri_district','agri_districts_id'
                                
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
                        // store the update farmers info
                    public function StoreFarmers(Request $request,$id)
                    {
              
                         try{
                    
            
                                // $data= $request->validated();
                                // $data= $request->all();
                                $data= PersonalInformations::find($id);
                                // Step 2: Archive the current data before updating it
               PersonalInformationArchive::create([
                'personal_informations_id' => $data->id,  // Foreign key reference to the original record
                'users_id' => $data->users_id,
                'first_name' => $data->first_name,
                'middle_name' => $data->middle_name,
                'last_name' => $data->last_name,
                'extension_name' => $data->extension_name,
                'country' => $data->country,
                'province' => $data->province,
                'city' => $data->city,
                'district' => $data->district,
                'barangay' => $data->barangay,
                'home_address' => $data->home_address,
                'sex' => $data->sex,
                'religion' => $data->religion,
                'date_of_birth' => $data->date_of_birth,
                'place_of_birth' => $data->place_of_birth,
                'contact_no' => $data->contact_no,
                'civil_status' => $data->civil_status,
                'name_legal_spouse' => $data->name_legal_spouse,
                'no_of_children' => $data->no_of_children,
                'mothers_maiden_name' => $data->mothers_maiden_name,
                'highest_formal_education' => $data->highest_formal_education,
                'person_with_disability' => $data->person_with_disability,
                'pwd_id_no' => $data->pwd_id_no,
                'government_issued_id' => $data->government_issued_id,
                'id_type' => $data->id_type,
                'gov_id_no' => $data->gov_id_no,
                'member_ofany_farmers_ass_org_coop' => $data->member_ofany_farmers_ass_org_coop,
                'nameof_farmers_ass_org_coop' => $data->nameof_farmers_ass_org_coop,
                'name_contact_person' => $data->name_contact_person,
                'cp_tel_no' => $data->cp_tel_no,
                'agri_district' => $data->agri_district,
                'date_interview' => $data->date_interview,
            ]);
                               
              // Check if a file is present in the request and if it's valid
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Retrieve the image file from the request
                $image = $request->file('image');
                
                // Generate a unique image name using current timestamp and file extension
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                
                // Move the uploaded image to the 'personalInfoimages' directory with the generated name
                $image->move('personalInfoimages', $imagename);
                
                // Set the image name in the PersonalInformation model
                $data->image = $imagename;
            } 
                        $data->users_id =$request->users_id;
                        $data->first_name= $request->first_name;
                        $data->middle_name= $request->middle_name;
                        $data->last_name=  $request->last_name;
            
                        if ($request->extension_name === 'others') {
                            $data->extension_name = $request->add_extName; // Use the value entered in the "add_extenstion name" input field
                       } else {
                            $data->extension_name = $request->extension_name; // Use the selected color from the dropdown
                       }
                        $data->country=  $request->country;
                        $data->province=  $request->province;
                        $data->city=  $request->city;
                        $data->agri_district=  $request->agri_district;
                        $data->barangay=  $request->barangay;
                        
                         $data->home_address=  $request->home_address;
                         $data->sex=  $request->sex;
            
                         if ($request->religion=== 'other') {
                            $data->religion= $request->add_Religion; // Use the value entered in the "religion" input field
                       } else {
                            $data->religion= $request->religion; // Use the selected religion from the dropdown
                       }
                         $data->date_of_birth=  $request->date_of_birth;
                        
                         if ($request->place_of_birth=== 'Add Place of Birth') {
                            $data->place_of_birth= $request->add_PlaceBirth; // Use the value entered in the "place_of_birth" input field
                       } else {
                            $data->place_of_birth= $request->place_of_birth; // Use the selected place_of_birth from the dropdown
                       }
                         $data->contact_no=  $request->contact_no;
                         $data->civil_status=  $request->civil_status;
                         $data->name_legal_spouse=  $request->name_legal_spouse;
            
                         if ($request->no_of_children=== 'Add') {
                            $data->no_of_children= $request->add_noChildren; // Use the value entered in the "no_of_children" input field
                            } else {
                                    $data->no_of_children= $request->no_of_children; // Use the selected no_of_children from the dropdown
                            }
                
                         $data->mothers_maiden_name=  $request->mothers_maiden_name;
                         if ($request->highest_formal_education=== 'Other') {
                            $data->highest_formal_education= $request->add_formEduc; // Use the value entered in the "highest_formal_education" input field
                            } else {
                                    $data->highest_formal_education= $request->highest_formal_education; // Use the selected highest_formal_education from the dropdown
                            }
                         $data->person_with_disability=  $request->person_with_disability;
                         $data->pwd_id_no=  $request->pwd_id_no;
                         $data->government_issued_id=  $request->government_issued_id;
                         $data->id_type=  $request->id_type;
                         $data->gov_id_no=  $request->gov_id_no;
                         $data->member_ofany_farmers_ass_org_coop=  $request->member_ofany_farmers_ass_org_coop;
                         
                         if ($request->nameof_farmers_ass_org_coop === 'add') {
                            $data->nameof_farmers_ass_org_coop = $request->add_FarmersGroup; // Use the value entered in the "add_extenstion name" input field
                       } else {
                            $data->nameof_farmers_ass_org_coop = $request->nameof_farmers_ass_org_coop; // Use the selected color from the dropdown
                       }
                         $data->name_contact_person=  $request->name_contact_person;
                  
                         $data->cp_tel_no=  $request->cp_tel_no;
                        
            
            
            
                                // dd($data);
                                $data->save();     
                                
                            
                                return redirect('/agent-view-farmers')->with('message','Personal informations Updated successsfully');
                            
                            }
                            catch(\Exception $ex){
                                // dd($ex); // Debugging statement to inspect the exception
                                return redirect('/agent-edit-farmers/{personalinfos}')->with('message','Please Try again');
                                
                            }   
                        } 
            
                        // deleting personal info by admin
                        public function DeleteFarmers($id) {
                            try {
                                // Find the personal information by ID
                                $personalinformations = PersonalInformations::find($id);
                        
                                // Check if the personal information exists
                                if (!$personalinformations) {
                                    return redirect()->back()->with('error', 'Personal information not found');
                                }
                        
                                // Delete the personal information data from the database
                                $personalinformations->delete();
                        
                                // Redirect back with success message
                                return redirect()->back()->with('message', 'Personal information deleted successfully');
                        
                            } catch (\Exception $e) {
                                // Handle any exceptions and redirect back with error message
                                return redirect()->back()->with('error', 'Error deleting personal information: ' . $e->getMessage());
                            }
                        }
            

                // farm view access by agent

                public function Viewfarms($id)
                {
                    // Check if the user is authenticated
                    if (Auth::check()) {
                        // Retrieve the authenticated user ID
                        $userId = Auth::id();

                        // Find the user based on the retrieved ID
                        $agent = User::find($userId);

                        if ($agent) {
                            // Retrieve the user's personal information
                            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

                            // Fetch the user's farm ID and agricultural district information
                            $farmId = $agent->farm_id;
                            $agri_district = $agent->district;
                            $agri_districts_id = $agent->agri_districts_id;
                         // Get the currently logged-in user
                            $loggedInUser = auth()->user();

                            // Check if the logged-in user is an agent
                            if ($loggedInUser->role === 'agent') {
                                // Get the district of the agent
                                $agentDistrict = $loggedInUser->district;

                                // Fetch users with role 'user' who belong to the same district
                                $users = User::where('role', 'user')
                                            ->where('district', $agentDistrict)
                                            ->select('id', 'first_name', 'last_name')
                                            ->get();
                            } else {
                                // If not an agent, fetch all users with role 'user' (or handle as needed)
                                $users = User::where('role', 'user')
                                            ->select('id', 'first_name', 'last_name')
                                            ->get();
                            }

               
                            // Find the farm profile using the fetched farm ID
                            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

                            // Fetch farmer's personal information based on the provided ID
                            $personalinfos = PersonalInformations::find($id);

                            // Fetch farm data based on the farmer's ID
                            // Use the correct relationship name 'personalInformation' instead of 'personalinfo'
                            $farmData = FarmProfile::with('personalInformation')
                            ->where('personal_informations_id', $id)
                            ->paginate(5);
                        
                        

                            // Calculate total rice production
                            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

                            // Return the view with the fetched data
                            return view('agent.FarmerInfo.farm_view', compact(
                                'agent', 'profile', 'farmProfile', 'totalRiceProduction',
                                'personalinfos', 'userId', 'agri_district', 'agri_districts_id', 'farmData','users'
                            ));
                        } else {
                            // Handle the case where the user is not found
                            return redirect()->route('login')->with('error', 'User not found.');
                        }
                    } else {
                        // Handle the case where the user is not authenticated
                        return redirect()->route('login');
                    }
                }

                // adding new farm profile data
                public function NewAddFarms(Request $request,$id)
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

                            // Fetch user's information
                            $user_id = $user->id;
                            $agri_district = $user->agri_district;
                            $agri_districts_id = $user->agri_districts_id;
                            $cropVarieties = CropCategory::all();
                            // Find the user by their ID and eager load the personalInformation relationship
                            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                            $personalinfos = PersonalInformations::find($id);
                            $polygons = Polygon::all();
                            // Fetch all farm profiles
                            $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])->get();
                
                
                            // Fetch all agri districts
                            $agriDistricts = AgriDistrict::all(); // Get all agri districts

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


                            if ($request->ajax()) {
                                // Return the response as JSON for AJAX requests
                                return response()->json([
                                    'agent' => $agent,
                                    'profile' => $profile,
                                    // 'farmProfiles' => $farmProfiles,
                                    // 'totalRiceProduction' => $totalRiceProduction,
                                
                                    // 'polygons' => $polygonsData,
                                    // 'districtsData' => $districtsData // Send all district GPS coordinates
                                ]);
                            } else {

                            // Return the view with the fetched data
                       return view('agent.FarmerInfo.crudFarm.add',compact('agri_district', 'agri_districts_id', 'agent', 'profile',
                       'totalRiceProduction','userId','cropVarieties','personalinfos','userId', 'mapdata', 'parceldata'));
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


                // new farm added 
             
                public function StoreNewFarms(Request $request)
    {
    
    


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
              $productionModel -> cropping_no = $crop['production']['Cropping'];
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


                     public function ViewEditFarms(Request $request,$id)
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
                                 $agri_districts = $user->agri_district;
                                 $agri_districts_id = $user->agri_districts_id;
                 
                                 // Find the farm profile using the fetched farm ID
                                 $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                                 $farmprofiles=FarmProfile::find($id);
                           
                                 if ($request->ajax()) {
                                    $type = $request->input('type');
                                        // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                                        if ($type === 'farmprofiles') {
                                            $farmprofiles = FarmProfile::find($id); // Find the fixed cost data by ID
                                            if ($farmprofiles) {
                                                return response()->json($farmprofiles); // Return the data as JSON
                                            } else {
                                                return response()->json(['error' => 'farm data not found.'], 404);
                                            }
                                        }

                                        
                      // Handle the 'archives' request type for fetching archives by PersonalInformations ID
                    if ($type === 'archives') {
                        // First, check if the PersonalInformation record exists
                        $farmprofiles = FarmProfile::find($id);

                        // If the PersonalInformation record is not found, return a 404 with the message
                        if (!$farmprofiles) {
                            return response()->json(['message' => 'Farm Profile not found.'], 404);
                        }
                       // Fetch the archives associated with the PersonalInformation ID
                        $archives = FarmProfileArchive::where('farm_profiles_id', $id)->get();

                        // If no archives are found, return a message
                        if ($archives->isEmpty()) {
                            return response()->json(['message' => 'No archive record yet.'], 404);
                        }

                        // Return the archives data as JSON
                        return response()->json($archives);
                    }
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
                                return view('agent.FarmerInfo.crudFarm.edit', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
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
                         public function EditFarms(Request $request,$id)
                         {
                         
                             try{
                                 
                     
                                 // $data= $request->validated();
                                 // $data= $request->all();
                                 
                                 $ersonalinfos= FarmProfile::find($id);
                 
                                 FarmProfileArchive::create([
                                    'farm_profiles_id' => $ersonalinfos->id,
                                    'users_id' => $ersonalinfos->users_id,
                                    'personal_informations_id' => $ersonalinfos->personal_informations_id,
                                    'agri_districts_id' => $ersonalinfos->agri_districts_id,
                                    'agri_districts' => $ersonalinfos->agri_districts,
                                    'polygons_id' => $ersonalinfos->polygons_id,
                                    'tenurial_status' => $ersonalinfos->tenurial_status,
                                    'farm_address' => $ersonalinfos->farm_address,
                                    'no_of_years_as_farmers' => $ersonalinfos->no_of_years_as_farmers,
                                    'gps_longitude' => $ersonalinfos->gps_longitude,
                                    'gps_latitude' => $ersonalinfos->gps_latitude,
                                    'total_physical_area' => $ersonalinfos->total_physical_area,
                                    'total_area_cultivated' => $ersonalinfos->total_area_cultivated,
                                    'land_title_no' => $ersonalinfos->land_title_no,
                                    'lot_no' => $ersonalinfos->lot_no,
                                    'area_prone_to' => $ersonalinfos->area_prone_to,
                                    'ecosystem' => $ersonalinfos->ecosystem,
                                    // 'type_rice_variety' => $ersonalinfos->type_rice_variety,
                                    // 'prefered_variety' => $ersonalinfos->prefered_variety,
                                    // 'plant_schedule_wetseason' => $ersonalinfos->plant_schedule_wetseason,
                                    // 'plant_schedule_dryseason' => $ersonalinfos->plant_schedule_dryseason,
                                    // 'no_of_cropping_yr' => $ersonalinfos->no_of_cropping_yr,
                                    // 'yield_kg_ha' => $ersonalinfos->yield_kg_ha,
                                    'rsba_registered' => $ersonalinfos->rsba_registered,
                                    'pcic_insured' => $ersonalinfos->pcic_insured,
                                    'government_assisted' => $ersonalinfos->government_assisted,
                                    'source_of_capital' => $ersonalinfos->source_of_capital,
                                    'remarks_recommendation' => $ersonalinfos->remarks_recommendation,
                                    'oca_district_office' => $ersonalinfos->oca_district_office,
                                    'name_of_field_officer_technician' => $ersonalinfos->name_of_field_officer_technician,
                                    'date_interviewed' => $ersonalinfos->date_interviewed,
                                    
                                ]);
                                
                                 $ersonalinfos->users_id = $request->users_id;
                                 $ersonalinfos->personal_informations_id = $request->personal_informations_id;
                              
                               
                                 $ersonalinfos->agri_districts = $request->agri_districts;
                                 $ersonalinfos->tenurial_status = $request->tenurial_status === 'Add' ? $request->add_newTenure : $request->tenurial_status;
                                 $ersonalinfos->farm_address = $request->farm_address;
                                 $ersonalinfos->no_of_years_as_farmers = $request->no_of_years_as_farmers === 'Add' ? $request->add_newFarmyears : $request->no_of_years_as_farmers;
                                 $ersonalinfos->gps_longitude = $request->gps_longitude;
                                 $ersonalinfos->gps_latitude = $request->gps_latitude;
                                 $ersonalinfos->total_physical_area = $request->total_physical_area;
                                 $ersonalinfos->total_area_cultivated = $request->total_area_cultivated;
                                 $ersonalinfos->land_title_no = $request->land_title_no;
                                 $ersonalinfos->lot_no = $request->lot_no;
                                 $ersonalinfos->area_prone_to = $request->area_prone_to === 'Add Prone' ? $request->add_newProneYear : $request->area_prone_to;
                                 $ersonalinfos->ecosystem = $request->ecosystem === 'Add ecosystem' ? $request->Add_Ecosystem : $request->ecosystem;
                            
                                 $ersonalinfos->rsba_registered = $request->rsba_registered;
                                 $ersonalinfos->pcic_insured = $request->pcic_insured;
                                 $ersonalinfos->government_assisted = $request->government_assisted;
                                 $ersonalinfos->source_of_capital = $request->source_of_capital === 'Others' ? $request->add_sourceCapital : $request->source_of_capital;
                                 $ersonalinfos->remarks_recommendation = $request->remarks_recommendation;
                                 $ersonalinfos->oca_district_office = $request->oca_district_office;
                                 $ersonalinfos->name_of_field_officer_technician = $request->name_of_field_officer_technician;
                                 $ersonalinfos->date_interviewed = $request->date_interviewed;
                 
                                 // Handle image upload
                             if ($request->hasFile('image') && $request->file('image')->isValid()) {
                                 $image = $request->file('image');
                                 $imageName = time() . '.' . $image->getClientOriginalExtension();
                                 $image->move(public_path('farmimage'), $imageName);
                                 $ersonalinfos->image = $imageName;
                             }
                 
                                 // dd($ersonalinfos);
                                 $ersonalinfos->save();     
                                 
                             // Redirect back with success message
                             return redirect()->route('agent.FarmerInfo.farm_view',  $ersonalinfos->personal_informations_id)
                                  ->with('message', 'Farm Data updated successfully');
   
                            }catch(\Exception $ex){
                            
                                        dd($ex); // Debugging statement to inspect the exception
                                        return redirect()->back()->with('message', 'Something went wrong');
                                        
                                    }     
                         } 
                     
                  // fFarm profile delete
                 public function DeleteFarm($id) {
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
                 public function ViewFarmerCrops(Request $request, $id)
                 {
                     // Check if the user is authenticated
                     if (!Auth::check()) {
                         return redirect()->route('login');
                     }
                 
                     $userId = Auth::id();
                     $agent = User::find($userId);
                 
                     if (!$agent) {
                         return redirect()->route('login')->with('error', 'User not found.');
                     }
                 
                     $user = auth()->user();
                     $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                     $agri_district = $user->agri_district;
                     $agri_districts_id = $user->agri_districts_id;
                 
                     // Fetch CropFarms related to the given ID and get the FarmProfiles
                     $cropFarms = Crop::with(['farmProfile.personalInformation'])
                     ->where('farm_profiles_id', $id)
                     ->paginate(5);
                 
                     // Access the FarmProfile from the Crop model
                     $farmData = FarmProfile::find($id); // Get the first farm profile if exists
                 
                     // Extract unique personal information records from the related FarmProfiles
                     $personalInfos = $cropFarms->map(function ($cropFarm) {
                         return $cropFarm->farmProfile->personalInformation;
                     })->unique('id');
                 
                     $cropName = $request->input('crop_name');
                 
                     // Fetch all crop data or filter based on the selected crop name
                     if ($cropName && $cropName != 'All') {
                         $cropData = Crop::where('farm_profiles_id', $id)
                                         ->where('crop_name', $cropName)
                                         ->paginate(10); // Use paginate here too
                     } else {
                         $cropData = Crop::where('farm_profiles_id', $id)
                                         ->with('farmProfile')
                                         ->paginate(10); // Use paginate here too
                     }
                  
                                
                                               
                     $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                 
                     // Return the view with the fetched data
                     return view('agent.FarmerInfo.crops_view', compact(
                         'agent', 
                         'profile', 
                         'farmData',  // Changed variable name here
                         'totalRiceProduction',
                         'userId', 
                         'agri_district', 
                         'agri_districts_id', 
                         'cropData', 
                         'id', 
                         'personalInfos', 
                         'cropFarms'
                     ));
                 }
                 


           // CRUD operations for Crops:
// - Create: Allows users or agents to add new crop records, including details such as crop name, variety, planting date, harvesting schedule, and associated farm ID.
// - Read: Retrieves and displays crop data for analysis, reporting, or visualization on dashboards or maps.
// - Update: Enables modification of crop records to correct errors or update information, such as changes in planting schedules or yield expectations.
// - Delete: Removes crop records from the database when no longer relevant or required.
// These operations facilitate efficient management of crop data, ensuring accurate and up-to-date records for better agricultural planning and monitoring.

  // adding new farm profile data

  public function ViewAddCrops(Request $request, $id)
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
                        $crops = CropCategory::pluck('crop_name', 'crop_name');
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
                return view('agent.FarmerInfo.CrudCrop.Add', compact('agri_district', 'agri_districts_id', 'agent', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 'farmData'));
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


  public function SaveNewCrop(Request $request)
  {
 
    
   
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
   
       public function  EditCrops(Request $request,$id)
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
                   $agri_district = $user->agri_district;
                   $agri_districts_id = $user->agri_districts_id;
                   // Find the farm profile using the fetched farm ID
                   $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                   $cropfarm= Crop::find($id);
                   
                     // Handle AJAX requests
                     if ($request->ajax()) {
                        $type = $request->input('type');
                            // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                            if ($type === 'cropfarm') {
                                $cropfarm =Crop::find($id); // Find the fixed cost data by ID
                                if ($cropfarm) {
                                    return response()->json($cropfarm); // Return the data as JSON
                                } else {
                                    return response()->json(['error' => 'crop farm cost data not found.'], 404);
                                }
                            }


                               // Handle the 'archives' request type for fetching archives by PersonalInformations ID
                               if ($type === 'archives') {
                                // First, check if the PersonalInformation record exists
                                $cropfarm = Crop::find($id);

                                // If the PersonalInformation record is not found, return a 404 with the message
                                if (!$cropfarm) {
                                    return response()->json(['message' => 'Crop Farm not found.'], 404);
                                }
                            // Fetch the archives associated with the PersonalInformation ID
                                $archives = CropFarmsArchive::where('crops_farms_id', $id)->get();

                                // If no archives are found, return a message
                                if ($archives->isEmpty()) {
                                    return response()->json(['message' => 'No archive record yet.'], 404);
                                }

                                // Return the archives data as JSON
                                return response()->json($archives);
                            }
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
                   return view('agent.FarmerInfo.CrudCrop.Edit', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
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


       public function UpdatedCrop(Request $request,$id)
       {
       
           try{
               
   
               // $data= $request->validated();
               // $data= $request->all();
               
               $data= Crop::find($id);

               CropFarmsArchive::create([
                'crops_farms_id' => $data->id,
                'users_id' => $data->users_id,
                'personal_informations_id' => $data->personal_informations_id,
                'crop_name' => $data->crop_name,
                'type_of_variety_planted' => $data->type_of_variety_planted,
                'preferred_variety' => $data->preferred_variety,
                'planting_schedule_wetseason' => $data->planting_schedule_wetseason,
                'planting_schedule_dryseason' => $data->planting_schedule_dryseason,
                'no_of_cropping_per_year' => $data->no_of_cropping_per_year,
                'quantity' => $data->quantity,
               
                'yield_kg_ha' => $data->yield_kg_ha,
                'created_at' => $data->created_at,

            ]);
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
               
               return redirect()->route('agent.FarmerInfo.crops_view',  $data->farm_profiles_id)
               ->with('message', 'Crop Farm Data updated successfully');
   
                 }catch(\Exception $ex){
  
               dd($ex); // Debugging statement to inspect the exception
            return redirect()->back()->with('message', 'Something went wrong');
               
           }   
       } 

       public function DeletingCrops($id) {
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

// CRUD operations for Production:
// - Create: Allows users or agents to add new production records, including details such as crop type, yield, harvest date, production cost, revenue, and farm ID.
// - Read: Retrieves and displays production data for analysis, reporting, or visualization, helping users track productivity and trends over time.
// - Update: Enables modification of existing production records to correct inaccuracies or reflect updated information, such as yield adjustments or revenue changes.
// - Delete: Removes production records from the database when they are outdated or no longer relevant.
// These operations ensure efficient management of production data, supporting informed decision-making and effective resource planning.

    // agent access Production view
            // production view

            public function FarmerProduction (Request $request, $id)
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
                        $agri_district = $user->agri_district;
                        $agri_districts_id = $user->agri_districts_id;
            
                                // Find the farm profile using the fetched farm ID
                                $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
                                $farmData = FarmProfile::find($id);
                            // Fetch farmer's information based on ID
                            $cropData = Crop::find($id);
                            $fixed= FixedCost::find($id);
                            $lastproduction = LastProductionDatas::find($id);
            
                        // Fetch the LastProductionDatas using crops_farms_id
                                $lastProductionDatas = LastProductionDatas::where('crops_farms_id', $id)->get();

                                // Initialize array to hold the personal information records
                                $personalInfos = collect();

                                // Fetch FixedCost, MachineriesUseds, VariableCost, and ProductionSold data using the last_production_datas_id
                                $FixedData = FixedCost::whereIn('last_production_datas_id', $lastProductionDatas->pluck('id'))->get();
                                $machineriesData = MachineriesUseds::whereIn('last_production_datas_id', $lastProductionDatas->pluck('id'))->get();
                                $variableData = VariableCost::whereIn('last_production_datas_id', $lastProductionDatas->pluck('id'))->get();
                                $productionSold = ProductionSold::whereIn('last_production_datas_id', $lastProductionDatas->pluck('id'))->get();  // ProductionSold data

                                // Loop through the LastProductionDatas to fetch related CropFarm, FarmProfile, and PersonalInformations
                                foreach ($lastProductionDatas as $data) {
                                    // Fetch the related CropFarm
                                    $cropFarm = $data->cropFarm;

                                    if ($cropFarm) {
                                        // Fetch the related FarmProfile
                                        $farmProfile = $cropFarm->farmProfile;

                                        if ($farmProfile) {
                                            // Fetch the related PersonalInformations
                                            $personalInfo = $farmProfile->personalInformation;

                                            if ($personalInfo) {
                                                $personalInfos->push($personalInfo);
                                            }
                                        }
                                    }
                                }

                                // Remove duplicate personal information records
                                $personalInfos = $personalInfos->unique('id');

                                // Handle crop data
                                // $cropName = $request->input('crop_name');

                                // // Fetch all crop data or filter based on the selected crop name
                                // if ($cropName && $cropName != 'All') {
                                //     $cropData = Crop::where('farm_profiles_id', $id)
                                //                     ->where('crop_name', $cropName)
                                //                     ->get();
                                // } else {
                                //     $cropData = Crop::where('farm_profiles_id', $id)
                                //                     ->with('farmprofile')
                                //                     ->get();
                                // }

                                // Fetch production data with related crops
                                $productionData = LastProductionDatas::where('crops_farms_id', $id)
                                                                    ->with('crop')
                                                                    ->get();

                                // Fetch related data for FixedCost, MachineriesUseds, VariableCost, and ProductionSold
                                    // Get crops_farms_id from last_production_datas
                                    $cropsFarmsIds = $lastProductionDatas->pluck('crops_farms_id');

                                    // Fetch data for FixedCost
                                    $fixedData = FixedCost::whereIn('crops_farms_id', $cropsFarmsIds)->get();

                                    // Fetch data for MachineriesUseds
                                    $machineriesData = MachineriesUseds::whereIn('crops_farms_id', $cropsFarmsIds)->get();

                                    // Fetch data for VariableCost
                                    $variableData = VariableCost::whereIn('crops_farms_id', $cropsFarmsIds)->get();

                                    // Fetch data for ProductionSold based on crops_farms_id
                                    $productionSold = ProductionSold::whereIn('crops_farms_id', $cropsFarmsIds)->get();

                                                    
            
                        
                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                        // Return the view with the fetched data
                        return view('agent.FarmerInfo.production_view', compact('agent', 'profile', 'farmProfile','totalRiceProduction'
                        ,'userId','agri_district','agri_districts_id','cropData','id','productionData','fixedData'
                        ,'farmData','machineriesData','variableData','personalInfos','productionSold','lastproduction','fixed'
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


            // add new production if empty
  
            public function viewCropProduction(Request $request,$id)
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
                      $cropData = Crop::find($id);
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
                        return view('agent.FarmerInfo.product.new_data', compact('agri_district', 'agri_districts_id', 'agent', 'profile',
                        'totalRiceProduction','userId','cropVarieties','farmData','cropData'));
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

            public function storeProduction(Request $request)
            {
           
              
                  
                $production = $request->productions;  // Assuming 'production' is a field in the request
                // return $production;
            //  dd($production);
                
                         $productionModel = new LastProductionDatas();
                      //    $productionModel -> users_id = $users_id;
                      //    $productionModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                         $productionModel -> crops_farms_id = $production['crops_farms_id'];
                         $productionModel -> cropping_no = $production['cropping_no'];
                         $productionModel -> seed_source = $production['seed-source'];
                         $productionModel -> seeds_used_in_kg = $production['seed-used'];
                         $productionModel -> seeds_typed_used = $production['seed-type'];
                         $productionModel -> no_of_fertilizer_used_in_bags = $production['fertilized-used'];
                         $productionModel -> no_of_insecticides_used_in_l = $production['pesticides-used'];
                         $productionModel -> no_of_pesticides_used_in_l_per_kg = $production['insecticides-used'];
                         $productionModel -> area_planted = $production['area-planted'];
                         $productionModel -> date_planted = $production['date-planted'];
                         $productionModel -> date_planted = $production['date-harvested'];
                         $productionModel -> unit = $production['unit'];
                         $productionModel -> yield_tons_per_kg = $production['yield-kg'];
                     
                        
                         $productionModel -> save();

                         $crop_id=  $productionModel -> crops_farms_id;
                       // productionid
                       $productionId=$productionModel ->id;
                          
            
                // Iterate through the sales data
                foreach ( $request->salesData as $sale) {
                    // Create a new sale associated with the production ID
                    $salesModel = new ProductionSold();
                    
                    // Assign values to the new sale model from the request data
                    $salesModel->last_production_datas_id = $productionId; // Assuming $productionId is set earlier in the code
                    $salesModel->sold_to = $sale['soldTo'];
                    $salesModel->measurement = $sale['measurement'];
                    $salesModel->unit_price_rice_per_kg = $sale['unit_price']; // Ensure the key names match your form data
                    $salesModel->quantity = $sale['quantity'];
                    $salesModel->gross_income = $sale['grossIncome'];
                    
                    // Save the new sale to the database
                    $salesModel->save();
                }
                    
                    $fixedCost= $request->fixedcost; 
                       // FIXED COST
                       $fixedcostModel = new FixedCost();
                      //  $fixedcostModel -> users_id = $users_id;
                      //  $fixedcostModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                       $fixedcostModel -> crops_farms_id = $crop_id;
                       $fixedcostModel -> last_production_datas_id = $productionId;
                       $fixedcostModel -> particular = $fixedCost['particular'];
                       $fixedcostModel -> no_of_ha = $fixedCost['no-has'];
                       $fixedcostModel -> cost_per_ha = $fixedCost['cost-has'];
                       $fixedcostModel -> total_amount = $fixedCost['total-amount'];
                       $fixedcostModel -> save();
               


                       $machineries=$request->machineries;
                       // machineries
                         $machineriesModel = new MachineriesUseds();
                      //    $machineriesModel -> users_id = $users_id;
                      //    $machineriesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                         $machineriesModel -> crops_farms_id = $crop_id;
                         $machineriesModel -> last_production_datas_id = $productionId;
                         $machineriesModel-> plowing_machineries_used = $machineries['plowing-machine'];
                         $machineriesModel -> plo_ownership_status = $machineries['plow_status'];
                       
                         $machineriesModel -> no_of_plowing = $machineries['no_of_plowing'];
                         $machineriesModel -> plowing_cost = $machineries['cost_per_plowing'];
                         $machineriesModel -> plowing_cost_total = $machineries['plowing_cost'];

                         $machineriesModel -> harrowing_machineries_used = $machineries['harro_machine'];
                         $machineriesModel -> harro_ownership_status = $machineries['harro_ownership_status'];
                         $machineriesModel -> no_of_harrowing = $machineries['no_of_harrowing'];
                         $machineriesModel -> harrowing_cost = $machineries['cost_per_harrowing'];
                         $machineriesModel -> harrowing_cost_total = $machineries['harrowing_cost_total'];

                        //  $machineriesModel -> harvesting_machineries_used = $machineries['harvest_machine'];
                         $machineriesModel -> harvest_ownership_status	 = $machineries['harvest_ownership_status'];
                      
                        //  $machineriesModel -> harvesting_cost = $machineries['harvesting_cost'];
                         $machineriesModel -> harvesting_cost_total = $machineries['Harvesting_cost_total'];

                         $machineriesModel -> postharvest_machineries_used = $machineries['postharves_machine'];
                         $machineriesModel -> postharv_ownership_status = $machineries['postharv_ownership_status'];
                         $machineriesModel -> post_harvest_cost = $machineries['postharvestCost'];
                         $machineriesModel -> 	total_cost_for_machineries = $machineries['total_cost_for_machineries'];
                         $machineriesModel -> save();
               

                         $variable= $request->variables;
                       //   variable cost
                         $variablesModel = new VariableCost();
                      //    $variablesModel -> users_id = $users_id;
                      //    $variablesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                         $variablesModel -> crops_farms_id = $crop_id;
                         $variablesModel -> last_production_datas_id = $productionId;
                       //   seeds
                     
                         $variablesModel -> seed_name = $variable['seed_name'];
                         $variablesModel -> unit = $variable['unit'];
                         $variablesModel -> quantity = $variable['quantity'];
                         $variablesModel -> unit_price = $variable['unit_price_seed'];
                         $variablesModel -> total_seed_cost = $variable['total_seed_cost'];
               
                          //   seeds
                          $variablesModel -> labor_no_of_person = $variable['no_of_person'];
                          $variablesModel -> rate_per_person = $variable['rate_per_person'];
                          $variablesModel -> total_labor_cost = $variable['total_labor_cost'];
               
                           // fertilizer
                          $variablesModel -> name_of_fertilizer = $variable['name_of_fertilizer'];
                          $variablesModel -> type_of_fertilizer = $variable['total_seed_cost'];
                          $variablesModel -> no_of_sacks = $variable['no_ofsacks'];
                          $variablesModel -> unit_price_per_sacks = $variable['unitprice_per_sacks'];
                          $variablesModel -> total_cost_fertilizers = $variable['total_cost_fertilizers'];
               
                            //pesticides
                            $variablesModel -> pesticide_name = $variable['pesticides_name'];
                           //  $variablesModel ->	type_of_pesticides = $variable['no_of_l_kg'];2
                            $variablesModel -> no_of_l_kg = $variable['no_of_l_kg'];
                            $variablesModel -> unit_price_of_pesticides = $variable['unitprice_ofpesticides'];
                            $variablesModel -> total_cost_pesticides = $variable['total_cost_pesticides'];
                        
                             //transportation
                             $variablesModel -> name_of_vehicle = $variable['type_of_vehicle'];
                            
                             $variablesModel -> total_transport_delivery_cost = $variable['total_seed_cost'];
                          
                             $variablesModel -> total_machinery_fuel_cost= $variable['total_machinery_fuel_cost'];
                             $variablesModel -> total_variable_cost= $variable['total_variable_costs'];
                             $variablesModel -> save();
                    
                            // return $request;
                           
                    
                     // Return success message
                     return [
                         'success' => "Saved to database" // Corrected the syntax here
                     ];
                 }  


                //  edit and update
  
            public function EditProductionCrops(Request $request,$id)
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
                      $cropData = Crop::find($id);
                      $production = LastProductionDatas::with('cropFarm')->find($id);
              

                              // Handle AJAX requests
                              if ($request->ajax()) {
                              $type = $request->input('type');
                              if ($type === 'production') {
                                $production =LastProductionDatas::find($id); // Find the fixed cost data by ID
                                if ($production) {
                                    return response()->json($production); // Return the data as JSON
                                } else {
                                    return response()->json(['error' => 'variable cost data not found.'], 404);
                                }
                            }
            
                            
                             // Handle the 'archives' request type for fetching archives by PersonalInformations ID
                             if ($type === 'archives') {
                                // First, check if the PersonalInformation record exists
                                $production = LastProductionDatas::with('cropFarm')->find($id);

                                // If the PersonalInformation record is not found, return a 404 with the message
                                if (!$production) {
                                    return response()->json(['message' => 'Production not found.'], 404);
                                }
                            // Fetch the archives associated with the PersonalInformation ID
                                $archives = ProductionArchive::where('last_production_datas_id', $id)->get();

                                // If no archives are found, return a message
                                if ($archives->isEmpty()) {
                                    return response()->json(['message' => 'No archive record yet.'], 404);
                                }

                                // Return the archives data as JSON
                                return response()->json($archives);
                            }



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
                        return view('agent.FarmerInfo.product.edit', compact('agri_district', 'agri_districts_id', 'agent', 'profile',
                        'totalRiceProduction','userId','cropVarieties','farmData','cropData','production'));
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



            public function UpdatedProduction(Request $request,$id)
       {
       
           try{
               
   
               // $data= $request->validated();
               // $data= $request->all();
               
               $data= LastProductionDatas::find($id);

                ProductionArchive::create([
                    'last_production_datas_id' => $data->id,
                    'users_id' => $data->users_id,
                    'personal_informations_id' => $data->personal_informations_id,
                    'farm_profiles_id ' => $data->farm_profiles_id ,
                    'crops_farms_id' => $data->crops_farms_id,
                    'seeds_typed_used' => $data->seeds_typed_used,
                    'seeds_used_in_kg' => $data->seeds_used_in_kg,
                    'seed_source' => $data->seed_source,
                    'unit' => $data->unit,
                    'no_of_fertilizer_used_in_bags' => $data->no_of_fertilizer_used_in_bags,
                    'no_of_pesticides_used_in_l_per_kg' => $data->no_of_pesticides_used_in_l_per_kg,
                    'no_of_insecticides_used_in_l' => $data->no_of_insecticides_used_in_l,
                    'area_planted' => $data->area_planted,
                    
                    'date_planted' => $data->date_planted,
                    'date_harvested' => $data->date_harvested,
                    'yield_tons_per_kg' => $data->yield_tons_per_kg,
                    'unit_price_palay_per_kg' => $data->unit_price_palay_per_kg,
                    'unit_price_rice_per_kg' => $data->unit_price_rice_per_kg,
                    'type_of_product' => $data->type_of_product,

                    'sold_to' => $data->sold_to,
                    'if_palay_milled_where' => $data->if_palay_milled_where,
                    'gross_income_palay' => $data->gross_income_palay,
                    'gross_income_rice' => $data->gross_income_rice,
                    'create_at' => $data->created_at,
    
                ]);
               $data->users_id = $request->users_id;
             
            
               $data->crops_farms_id = $request->crops_farms_id;
               $data->seeds_typed_used = $request->seeds_typed_used;
               $data->seeds_used_in_kg = $request->seeds_used_in_kg;
      
               $data->seed_source = $request->seed_source;
               $data->unit = $request->unit;
               $data->no_of_fertilizer_used_in_bags = $request->no_of_fertilizer_used_in_bags;
               $data->no_of_pesticides_used_in_l_per_kg = $request->no_of_pesticides_used_in_l_per_kg === 'Adds' ? $request->add_cropyear : $request->no_of_pesticides_used_in_l_per_kg;
               $data->no_of_insecticides_used_in_l = $request->no_of_insecticides_used_in_l;
               $data->area_planted = $request->area_planted;
               $data->date_planted = $request->date_planted;
               $data->	date_harvested = $request->	date_harvested;
               $data->	yield_tons_per_kg = $request->	yield_tons_per_kg;
            //    dd($data);
               $data->save();     
               
           // Redirect back with success message
           // Redirect back with success message
           return redirect()->route('agent.FarmerInfo.production_view', $data->crops_farms_id)
           ->with('message', 'Production Data updated successfully');
       } catch (\Exception $ex) {
           // Handle the exception and provide error feedback
           return redirect()->back()->with('message', 'Something went wrong');
       }  
       } 


       
       public function DeleteProduction($id) {
        try {
            // Find thecrop farm by ID
            $productionData = LastProductionDatas::find($id);
    
            // Check if thecrop farm exists
            if (!$productionData) {
                return redirect()->back()->with('error', 'Production  not found');
            }
    
            // Delete theProduction  data from the database
            $productionData->delete();
    
            // Redirect back with success message
            return redirect()->back()->with('message', 'Production  deleted successfully');
    
        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with error message
            return redirect()->back()->with('error', 'Error deleting Production : ' . $e->getMessage());
        }
    }

// CRUD operations for Fixed Cost:
// - Create: Allows users or agents to add new fixed cost records, such as costs related to machinery, equipment, infrastructure, land leases, or other long-term expenses.
// - Read: Retrieves and displays fixed cost data for analysis, reporting, or budget tracking to assess the financial stability and costs associated with farming operations.
// - Update: Enables modification of existing fixed cost records to reflect changes in expenses, contracts, or pricing over time.
// - Delete: Removes fixed cost records from the database when they are no longer relevant, or the associated expense is no longer incurred.
// These operations ensure accurate tracking and management of fixed costs, enabling better financial planning and resource allocation.

    // agent access fixed cost view

        
            public function viewFixedCost(Request $request,$id)
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
                      $cropData = Crop::find($id);
                      $lastproduction = LastProductionDatas::find($id);
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
                        return view('agent.FarmerInfo.fixed.add_view', compact('agri_district', 'agri_districts_id', 'agent', 'profile',
                        'totalRiceProduction','userId','cropVarieties','farmData','cropData','lastproduction'));
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

            public function storeFixedCost(Request $request)
            {
           
              
                  
            //     $production = $request->productions;  // Assuming 'production' is a field in the request
            //     // return $production;
            // //  dd($production);
                
            //              $productionModel = new LastProductionDatas();
            //           //    $productionModel -> users_id = $users_id;
            //           //    $productionModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
            //              $productionModel -> crops_farms_id = $production['crops_farms_id'];
            //              $productionModel -> seed_source = $production['seed-source'];
            //              $productionModel -> seeds_used_in_kg = $production['seed-used'];
            //              $productionModel -> seeds_typed_used = $production['seed-type'];
            //              $productionModel -> no_of_fertilizer_used_in_bags = $production['fertilized-used'];
            //              $productionModel -> no_of_insecticides_used_in_l = $production['pesticides-used'];
            //              $productionModel -> no_of_pesticides_used_in_l_per_kg = $production['insecticides-used'];
            //              $productionModel -> area_planted = $production['area-planted'];
            //              $productionModel -> date_planted = $production['date-planted'];
            //              $productionModel -> date_planted = $production['date-harvested'];
            //              $productionModel -> unit = $production['unit'];
            //              $productionModel -> yield_tons_per_kg = $production['yield-kg'];
                     
                        
            //              $productionModel -> save();

            //              $crop_id=  $productionModel -> crops_farms_id;
            //            // productionid
            //            $productionId=$productionModel ->id;
                          
            
            //     // Iterate through the sales data
            //     foreach ( $request->salesData as $sale) {
            //         // Create a new sale associated with the production ID
            //         $salesModel = new ProductionSold();
                    
            //         // Assign values to the new sale model from the request data
            //         $salesModel->last_production_datas_id = $productionId; // Assuming $productionId is set earlier in the code
            //         $salesModel->sold_to = $sale['soldTo'];
            //         $salesModel->measurement = $sale['measurement'];
            //         $salesModel->unit_price_rice_per_kg = $sale['unit_price']; // Ensure the key names match your form data
            //         $salesModel->quantity = $sale['quantity'];
            //         $salesModel->gross_income = $sale['grossIncome'];
                    
            //         // Save the new sale to the database
            //         $salesModel->save();
            //     }
                    
                    $fixedCost= $request->fixedcost; 

                       // FIXED COST
                       $fixedcostModel = new FixedCost();
                      //  $fixedcostModel -> users_id = $users_id;
                      //  $fixedcostModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                       $fixedcostModel ->crops_farms_id = $fixedCost['crops_farms_id'];
                    //    $fixedcostModel -> last_production_datas_id = $productionId;
                       $fixedcostModel -> particular = $fixedCost['particular'];
                       $fixedcostModel -> no_of_ha = $fixedCost['no-has'];
                       $fixedcostModel -> cost_per_ha = $fixedCost['cost-has'];
                       $fixedcostModel -> total_amount = $fixedCost['total-amount'];
                       $fixedcostModel -> save();
               

                        $crop_id=  $fixedcostModel ->crops_farms_id ;
                       $machineries=$request->machineries;
                       // machineries
                         $machineriesModel = new MachineriesUseds();
                      //    $machineriesModel -> users_id = $users_id;
                      //    $machineriesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                         $machineriesModel -> crops_farms_id = $crop_id;
         
                         $machineriesModel-> plowing_machineries_used = $machineries['plowing-machine'];
                         $machineriesModel -> plo_ownership_status = $machineries['plow_status'];
                       
                         $machineriesModel -> no_of_plowing = $machineries['no_of_plowing'];
                         $machineriesModel -> plowing_cost = $machineries['cost_per_plowing'];
                         $machineriesModel -> plowing_cost_total = $machineries['plowing_cost'];

                         $machineriesModel -> harrowing_machineries_used = $machineries['harro_machine'];
                         $machineriesModel -> harro_ownership_status = $machineries['harro_ownership_status'];
                         $machineriesModel -> no_of_harrowing = $machineries['no_of_harrowing'];
                         $machineriesModel -> harrowing_cost = $machineries['cost_per_harrowing'];
                         $machineriesModel -> harrowing_cost_total = $machineries['harrowing_cost_total'];

                        //  $machineriesModel -> harvesting_machineries_used = $machineries['harvest_machine'];
                         $machineriesModel -> harvest_ownership_status	 = $machineries['harvest_ownership_status'];
                      
                        //  $machineriesModel -> harvesting_cost = $machineries['harvesting_cost'];
                         $machineriesModel -> harvesting_cost_total = $machineries['Harvesting_cost_total'];

                         $machineriesModel -> postharvest_machineries_used = $machineries['postharves_machine'];
                         $machineriesModel -> postharv_ownership_status = $machineries['postharv_ownership_status'];
                         $machineriesModel -> post_harvest_cost = $machineries['postharvestCost'];
                         $machineriesModel -> 	total_cost_for_machineries = $machineries['total_cost_for_machineries'];
                         $machineriesModel -> save();
               

                         $variable= $request->variables;
                       //   variable cost
                         $variablesModel = new VariableCost();
                      //    $variablesModel -> users_id = $users_id;
                      //    $variablesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                         $variablesModel -> crops_farms_id = $crop_id;
                        
                       //   seeds
                     
                         $variablesModel -> seed_name = $variable['seed_name'];
                         $variablesModel -> unit = $variable['unit'];
                         $variablesModel -> quantity = $variable['quantity'];
                         $variablesModel -> unit_price = $variable['unit_price_seed'];
                         $variablesModel -> total_seed_cost = $variable['total_seed_cost'];
               
                          //   seeds
                          $variablesModel -> labor_no_of_person = $variable['no_of_person'];
                          $variablesModel -> rate_per_person = $variable['rate_per_person'];
                          $variablesModel -> total_labor_cost = $variable['total_labor_cost'];
               
                           // fertilizer
                          $variablesModel -> name_of_fertilizer = $variable['name_of_fertilizer'];
                          $variablesModel -> type_of_fertilizer = $variable['total_seed_cost'];
                          $variablesModel -> no_of_sacks = $variable['no_ofsacks'];
                          $variablesModel -> unit_price_per_sacks = $variable['unitprice_per_sacks'];
                          $variablesModel -> total_cost_fertilizers = $variable['total_cost_fertilizers'];
               
                            //pesticides
                            $variablesModel -> pesticide_name = $variable['pesticides_name'];
                           //  $variablesModel ->	type_of_pesticides = $variable['no_of_l_kg'];2
                            $variablesModel -> no_of_l_kg = $variable['no_of_l_kg'];
                            $variablesModel -> unit_price_of_pesticides = $variable['unitprice_ofpesticides'];
                            $variablesModel -> total_cost_pesticides = $variable['total_cost_pesticides'];
                        
                             //transportation
                             $variablesModel -> name_of_vehicle = $variable['type_of_vehicle'];
                            
                             $variablesModel -> total_transport_delivery_cost = $variable['total_seed_cost'];
                          
                             $variablesModel -> total_machinery_fuel_cost= $variable['total_machinery_fuel_cost'];
                             $variablesModel -> total_variable_cost= $variable['total_variable_costs'];
                             $variablesModel -> save();
                    
                            // return $request;
                           
                    
                     // Return success message
                     return [
                         'success' => "Saved to database" // Corrected the syntax here
                     ];
                 }  


                //  edit productions

                            // add new production if empty
  
                            public function EditFixedCost(Request $request, $id)
                            {
                                // Check if the user is authenticated
                                if (Auth::check()) {
                                    // Retrieve the authenticated user's ID
                                    $userId = Auth::id();
                                    $agent = User::find($userId);
                            
                                    if ($agent) {
                                        $user = auth()->user();
                                        
                                        // Ensure user is authenticated
                                        if (!$user) {
                                            return redirect()->route('login');
                                        }
                            
                                        // Fetch other related data
                                        $user_id = $user->id;
                                        $agri_district = $user->agri_district;
                                        $agri_districts_id = $user->agri_districts_id;
                                        $cropVarieties = CropCategory::all();
                            
                                        // Fetch profile and other necessary data
                                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                                        $farmData = FarmProfile::find($id);
                                        $cropData = Crop::find($id);
                                        $fixedData = FixedCost::find($id);
                                        $production = LastProductionDatas::with('cropFarm')->find($id);
                                       
                                       
                                    
                                        // Handle AJAX requests
                                        if ($request->ajax()) {
                                            $type = $request->input('type');
                            
                                            // Handle the 'fixedData' request type for fetching FixedCost data
                                            if ($type === 'fixedData') {
                                                $fixedData = FixedCost::find($id); // Find the fixed cost data by ID
                                                if ($fixedData) {
                                                    return response()->json($fixedData); // Return the data as JSON
                                                } else {
                                                    return response()->json(['error' => 'Fixed cost data not found.'], 404);
                                                }
                                            }
                            
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
                                            }
                            
                                            // Handle requests for crops and varieties
                                            if ($type === 'crops') {
                                                $crops = CropCategory::pluck('crop_name', 'crop_name');
                                                return response()->json($crops);
                                            }
                            
                                            if ($type === 'varieties') {
                                                $cropId = $request->input('crop_name');
                                                $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
                                                return response()->json($varieties);
                                            }
                            
                                            if ($type === 'seedname') {
                                                $varietyId = $request->input('variety_name');
                                                $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
                                                return response()->json($seeds);
                                            }
                            
                                            return response()->json(['error' => 'Invalid type parameter.'], 400);
                                        }
                            
                                        // Return the view with the fetched data
                                        return view('agent.FarmerInfo.fixed.edit_view', compact(
                                            'agri_district', 'agri_districts_id', 'agent', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                                            'farmData', 'cropData', 'production', 'fixedData'
                                        ));
                                    } else {
                                        return redirect()->route('login')->with('error', 'User not found.');
                                    }
                                } else {
                                    return redirect()->route('login');
                                }
                            }
                            

            public function UpdatedFixedCost(Request $request,$id)
       {
       
           try{
               
   
               // $data= $request->validated();
               // $data= $request->all();
               
               $data= FixedCost::find($id);
               FixedCostArchive::create([
                'fixed_costs_id' => $data->id,
                'crops_farms_id' => $data->crops_farms_id,
                'last_production_datas_id' => $data->last_production_datas_id,
                'farm_profiles_id' => $data->farm_profiles_id,

                'users_id' => $data->users_id,
                'personal_informations_id' => $data->personal_informations_id,
                'crop_name' => $data->crop_name,
                'particular' => $data->particular,
                'no_of_ha' => $data->no_of_ha,
                'cost_per_ha' => $data->cost_per_ha,
                'total_amount' => $data->	total_amount,
               
                'created_at' => $data->created_at,

            ]);
              
               $data->users_id = $request->users_id;
             
            
               $data->crops_farms_id = $request->crops_farms_id;
               $data->particular = $request->particular;
               $data->no_of_ha = $request->no_of_ha;
      
               $data->cost_per_ha = $request->cost_per_ha;
               $data->total_amount = $request->total_amount;
              
            //    dd($data);
               $data->save();     
               
           // Redirect back with success message
           return redirect()->route('agent.FarmerInfo.production_view', $data->crops_farms_id)
           ->with('message', 'Fixed Cost Data updated successfully');
       } catch (\Exception $ex) {
           // Handle the exception and provide error feedback
           return redirect()->back()->with('message', 'Something went wrong');
       }  
       } 


       
       public function DeleteFixedCost($id) {
        try {
            // Find thecrop farm by ID
            $fixedCost =FixedCost::find($id);
    
            // Check if thecrop farm exists
            if (!$fixedCost) {
                return redirect()->back()->with('error', 'FixedCost  not found');
            }
    
            // Delete theFixedCost  data from the database
            $fixedCost->delete();
    
            // Redirect back with success message
            return redirect()->back()->with('message', 'FixedCost  deleted successfully');
    
        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with error message
            return redirect()->back()->with('error', 'Error deleting Fixed: ' . $e->getMessage());
        }
    }


// CRUD operations for Machineries:
// - Create: Allows users or agents to add new machinery records, including details such as machinery type, model, cost, purpose, and maintenance schedule.
// - Read: Retrieves and displays machinery data to track usage, maintenance history, and costs for operational planning or financial reporting.
// - Update: Enables modification of existing machinery records, such as updating maintenance status, changing machinery details, or adjusting usage data.
// - Delete: Removes machinery records from the database when they are no longer in use, obsolete, or replaced by newer equipment.
// These operations help manage and track machinery usage, ensuring accurate records for efficient farm operations and cost management.


                                    public function EditMachine(Request $request, $id)
                                    {
                                        // Check if the user is authenticated
                                        if (Auth::check()) {
                                            // Retrieve the authenticated user's ID
                                            $userId = Auth::id();
                                            $agent = User::find($userId);
                                    
                                            if ($agent) {
                                                $user = auth()->user();
                                                
                                                // Ensure user is authenticated
                                                if (!$user) {
                                                    return redirect()->route('login');
                                                }
                                    
                                                // Fetch other related data
                                                $user_id = $user->id;
                                                $agri_district = $user->agri_district;
                                                $agri_districts_id = $user->agri_districts_id;
                                                $cropVarieties = CropCategory::all();
                                    
                                                // Fetch profile and other necessary data
                                                $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                                                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                                                $farmData = FarmProfile::find($id);
                                                $cropData = Crop::find($id);
                                                $fixedData = FixedCost::find($id);
                                                $machineriesData =MachineriesUseds::find($id);
                                                $production = LastProductionDatas::with('cropFarm')->find($id);
                                            
                                            
                                            
                                                // Handle AJAX requests
                                                if ($request->ajax()) {
                                                    $type = $request->input('type');
                                    
                                                    // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                                                    if ($type === 'machineriesData') {
                                                        $machineriesData =MachineriesUseds::find($id); // Find the fixed cost data by ID
                                                        if ($machineriesData) {
                                                            return response()->json($machineriesData); // Return the data as JSON
                                                        } else {
                                                            return response()->json(['error' => 'Fixed cost data not found.'], 404);
                                                        }
                                                    }
                                    
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
                                                    }
                                    
                                                    // Handle requests for crops and varieties
                                                    if ($type === 'crops') {
                                                        $crops = CropCategory::pluck('crop_name', 'crop_name');
                                                        return response()->json($crops);
                                                    }
                                    
                                                    if ($type === 'varieties') {
                                                        $cropId = $request->input('crop_name');
                                                        $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
                                                        return response()->json($varieties);
                                                    }
                                    
                                                    if ($type === 'seedname') {
                                                        $varietyId = $request->input('variety_name');
                                                        $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
                                                        return response()->json($seeds);
                                                    }
                                    
                                                    return response()->json(['error' => 'Invalid type parameter.'], 400);
                                                }
                                    
                                                // Return the view with the fetched data
                                                return view('agent.FarmerInfo.machineries.edit_view', compact(
                                                    'agri_district', 'agri_districts_id', 'agent', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                                                    'farmData', 'cropData', 'production', 'fixedData','machineriesData'
                                                ));
                                            } else {
                                                return redirect()->route('login')->with('error', 'User not found.');
                                            }
                                        } else {
                                            return redirect()->route('login');
                                        }
                                    }
                                    

                                public function UpdateMachine(Request $request,$id)
                                {

                                try{


                                // $data= $request->validated();
                                // $data= $request->all();

                                $machineused= MachineriesUseds::find($id);


                                $machineused->users_id = $request->users_id;


                                $machineused->crops_farms_id = $request->crops_farms_id;
                                $machineused-> plowing_machineries_used = $request->plowing_machineries_used === 'OthersPlowing' ? $request->add_Plowingmachineries : $request->plowing_machineries_used;
                                $machineused-> plo_ownership_status = $request->plo_ownership_status === 'Other' ? $request->add_PlowingStatus : $request->plo_ownership_status;
                                $machineused->no_of_plowing = $request->no_of_plowing;
                                $machineused->cost_per_plowing = $request->cost_per_plowing;
                                $machineused-> plowing_cost = $request->plowing_cost;
                                 
                                $machineused-> harrowing_machineries_used = $request->harrowing_machineries_used=== 'OtherHarrowing' ? $request->Add_HarrowingMachineries : $request->harrowing_machineries_used;
                                $machineused->harro_ownership_status = $request->harro_ownership_status=== 'Otherharveststat' ? $request->add_harvestingStatus : $request->harro_ownership_status;
                                $machineused->no_of_harrowing = $request->no_of_harrowing; 
                                $machineused->harrowing_cost = $request->harrowing_cost;
                                $machineused->harrowing_cost_total = $request->harrowing_cost_total; 
                             
                         
                                $machineused->harvesting_machineries_used = $request->harvesting_machineries_used=== 'OtherHarvesting' ? $request->add_HarvestingMachineries : $request->harvesting_machineries_used;
                                $machineused->harvest_ownership_status = $request->harvest_ownership_status=== 'OtherHarvesting' ? $request->add_HarvestingMachineries : $request->harvest_ownership_status;
                                $machineused->no_of_harvesting = $request->no_of_harvesting;
                                $machineused->cost_per_harvesting = $request->cost_per_harvesting;
                                $machineused->harvesting_cost_total = $request->harvesting_cost_total;
                         
                                $machineused->postharvest_machineries_used = $request->postharvest_machineries_used=== 'Otherpostharvest' ? $request->add_postharvestMachineries : $request->postharvest_machineries_used;
                                $machineused->postharv_ownership_status = $request->postharv_ownership_status=== 'OtherpostharvestStatus' ? $request->add_postStatus : $request->postharv_ownership_status;
                                $machineused->post_harvest_cost = $request->post_harvest_cost;
                                $machineused->total_cost_for_machineries = $request->total_cost_for_machineries;
                                  
                                //  dd($machineused);
                                 $machineused->save();

                                // Redirect back with success message
                                return redirect()->route('agent.FarmerInfo.production_view', $machineused->crops_farms_id)
                                ->with('message', 'Machineries Cost Data updated successfully');
                            } catch (\Exception $ex) {
                                // dd($ex);
                                // Handle the exception and provide error feedback
                                return redirect()->back()->with('message', 'Something went wrong');
                            }  
                                } 



                                public function Delete($id) {
                                try {
                                // Find thecrop farm by ID
                                $fixedCost =MachineriesUseds::find($id);

                                // Check if thecrop farm exists
                                if (!$fixedCost) {
                                return redirect()->back()->with('error', 'Machineries  not found');
                                }

                                // Delete theMachineries  data from the database
                                $fixedCost->delete();

                                // Redirect back with success message
                                return redirect()->back()->with('message', 'Machineries  deleted successfully');

                                } catch (\Exception $e) {
                                // Handle any exceptions and redirect back with error message
                                return redirect()->back()->with('error', 'Error deleting Machineries: ' . $e->getMessage());
                                }
                                }

  // CRUD operations for Variable Cost:
// - Create: Allows users or agents to add new variable cost records, including expenses such as seeds, fertilizers, pesticides, labor, irrigation, and other recurring costs associated with farming operations.
// - Read: Retrieves and displays variable cost data for analysis, reporting, or financial planning, helping track recurring expenses and profitability.
// - Update: Enables modification of existing variable cost records to reflect changes in prices, quantities, or other cost adjustments over time.
// - Delete: Removes variable cost records from the database when they are no longer applicable or required, or when costs have been fully paid.
// These operations ensure effective tracking and management of variable costs, aiding in budgeting, cost control, and profitability analysis for farming operations.

                            // variable cost access by agent

                                public function EditVariable(Request $request, $id)
                                {
                                    // Check if the user is authenticated
                                    if (Auth::check()) {
                                        // Retrieve the authenticated user's ID
                                        $userId = Auth::id();
                                        $agent = User::find($userId);
                                
                                        if ($agent) {
                                            $user = auth()->user();
                                            
                                            // Ensure user is authenticated
                                            if (!$user) {
                                                return redirect()->route('login');
                                            }
                                
                                            // Fetch other related data
                                            $user_id = $user->id;
                                            $agri_district = $user->agri_district;
                                            $agri_districts_id = $user->agri_districts_id;
                                            $cropVarieties = CropCategory::all();
                                
                                            // Fetch profile and other necessary data
                                            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                                            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                                            $farmData = FarmProfile::find($id);
                                            $cropData = Crop::find($id);
                                            $fixedData = FixedCost::with('cropFarm')->find($id);
                                            $machineriesData =MachineriesUseds::with('cropFarm')->find($id);
                                            $variablesData =VariableCost::with('cropFarm')->find($id);
                                            $production = LastProductionDatas::with('cropFarm')->find($id);
                                        
                                        
                                        
                                            // Handle AJAX requests
                                            if ($request->ajax()) {
                                                $type = $request->input('type');
                                
                                                // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                                                if ($type === 'variablesData') {
                                                    $variablesData =VariableCost::find($id); // Find the fixed cost data by ID
                                                    if ($variablesData) {
                                                        return response()->json($variablesData); // Return the data as JSON
                                                    } else {
                                                        return response()->json(['error' => 'variable cost data not found.'], 404);
                                                    }
                                                }
                                
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
                                                }
                                
                                                // Handle requests for crops and varieties
                                                if ($type === 'crops') {
                                                    $crops = CropCategory::pluck('crop_name', 'crop_name');
                                                    return response()->json($crops);
                                                }
                                
                                                if ($type === 'varieties') {
                                                    $cropId = $request->input('crop_name');
                                                    $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
                                                    return response()->json($varieties);
                                                }
                                
                                                if ($type === 'seedname') {
                                                    $varietyId = $request->input('variety_name');
                                                    $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
                                                    return response()->json($seeds);
                                                }
                                
                                                return response()->json(['error' => 'Invalid type parameter.'], 400);
                                            }
                                
                                            // Return the view with the fetched data
                                            return view('agent.FarmerInfo.variable.edit', compact(
                                                'agri_district', 'agri_districts_id', 'agent', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                                                'farmData', 'cropData', 'production', 'fixedData','machineriesData','variablesData'
                                            ));
                                        } else {
                                            return redirect()->route('login')->with('error', 'User not found.');
                                        }
                                    } else {
                                        return redirect()->route('login');
                                    }
                                }
                                

                            public function UpdateVariable(Request $request,$id)
                            {

                            try{


                            // $data= $request->validated();
                            // $data= $request->all();

                            $variable= VariableCost::find($id);
                            // Pass the previous data into the new record
                            VariableCostArchive::create([
                                'variable_costs_id' => $variable->id,
                                'personal_informations_id' => $variable->personal_informations_id,
                                'farm_profiles_id' => $variable->farm_profiles_id,
                                'last_production_datas_id' => $variable->last_production_datas_id,
                                'crops_farms_id' => $variable->crops_farms_id,
                                'users_id' => $variable->users_id,

                                // Seed Information
                                'unit' => $variable->unit,
                                'quantity' => $variable->quantity,
                                'unit_price' => $variable->unit_price,
                                'total_seed_cost' => $variable->total_seed_cost,

                                // Labor Information
                                'labor_no_of_person' => $variable->labor_no_of_person,
                                'rate_per_person' => $variable->rate_per_person,
                                'total_labor_cost' => $variable->total_labor_cost,

                                // Fertilizer Information
                                'no_of_sacks' => $variable->no_of_sacks,
                                'unit_price_per_sacks' => $variable->unit_price_per_sacks,
                                'total_cost_fertilizers' => $variable->total_cost_fertilizers,

                                // Pesticides Information
                                'no_of_l_kg' => $variable->no_of_l_kg,
                                'unit_price_of_pesticides' => $variable->unit_price_of_pesticides,
                                'total_cost_pesticides' => $variable->total_cost_pesticides,

                                // Transport Information
                                'total_transport_delivery_cost' => $variable->total_transport_delivery_cost,

                                // Total Costs
                                'total_machinery_fuel_cost' => $variable->total_machinery_fuel_cost,
                                'total_variable_cost' => $variable->total_variable_cost,

                                // Pass the previous created_at timestamp
                                'old_created_at' => $variable->created_at,

                                // Optional: Use the same updated_at timestamp, or set a new one
                                'updated_at' => now(),
                            ]);

                            $variable->users_id = $request->users_id;


                            $variable->crops_farms_id = $request->crops_farms_id;
                            $variable-> seed_name = $request->seed_name;
                            $variable-> unit = $request->unit;
                            $variable->quantity = $request->quantity;
                            $variable->unit_price = $request->unit_price;
                            $variable-> total_seed_cost = $request->total_seed_cost;
                             
                            $variable-> labor_no_of_person = $request->labor_no_of_person;
                            $variable->rate_per_person = $request->rate_per_person;
                            $variable->total_labor_cost = $request->total_labor_cost; 
                            $variable->name_of_fertilizer = $request->name_of_fertilizer;
                            $variable->no_of_sacks = $request->no_of_sacks; 
                         
                     
                            $variable->unit_price_per_sacks = $request->unit_price_per_sacks;
                            $variable->total_cost_fertilizers = $request->total_cost_fertilizers;
                            $variable->pesticide_name = $request->pesticide_name;
                            $variable->no_of_l_kg = $request->no_of_l_kg;
                            $variable->unit_price_of_pesticides = $request->unit_price_of_pesticides;
                         
                                $variable->total_cost_pesticides = $request->total_cost_pesticides;
                                $variable->name_of_vehicle = $request->name_of_vehicle;
                                $variable->total_transport_delivery_cost = $request->total_transport_delivery_cost;
                                $variable->total_machinery_fuel_cost = $request->total_machinery_fuel_cost;
                                $variable->total_variable_cost = $request->total_variable_cost;
                            //  dd($variable);
                             $variable->save();

                         
                            
                                // Redirect to the production view page based on the crop_farms_id
                                return redirect()->route('agent.FarmerInfo.production_view', $variable->crops_farms_id)
                                ->with('message', 'Variable Cost Data updated successfully');
                            } catch (\Exception $ex) {
                                // Handle the exception and provide error feedback
                                return redirect()->back()->with('message', 'Something went wrong');
                            }  
                            } 



                            public function DeleteVariable($id) {
                            try {
                            // Find thecrop farm by ID
                            $variablesData =VariableCost::find($id);

                            // Check if thecrop farm exists
                            if (!$variablesData) {
                            return redirect()->back()->with('error', 'variable  not found');
                            }

                            // Delete thevariable  data from the database
                            $variablesData->delete();

                            // Redirect back with success message
                            return redirect()->back()->with('message', 'variable  deleted successfully');

                            } catch (\Exception $e) {
                            // Handle any exceptions and redirect back with error message
                            return redirect()->back()->with('error', 'Error deleting variable: ' . $e->getMessage());
                            }
                            }


// CRUD operations for Production Sold:
// - Create: Allows users or agents to add new records for sold production, including details such as quantity sold, sale price, sale date, buyer information, and related crop data.
// - Read: Retrieves and displays records of production sold for analysis, reporting, or tracking sales performance and revenue generation.
// - Update: Enables modification of existing sales records to reflect updates such as price changes, quantity sold, or corrections in buyer details.
// - Delete: Removes sales records from the database when no longer relevant, such as in the case of errors, canceled transactions, or refunded sales.
// These operations ensure accurate tracking of sold production, aiding in sales reporting, revenue calculation, and inventory management.

                       
                            public function AddSolds(Request $request, $id)
                            {
                                // Check if the user is authenticated
                                if (Auth::check()) {
                                    // Retrieve the authenticated user's ID
                                    $userId = Auth::id();
                                    $agent = User::find($userId);
                            
                                    if ($agent) {
                                        $user = auth()->user();
                                        
                                        // Ensure user is authenticated
                                        if (!$user) {
                                            return redirect()->route('login');
                                        }
                            
                                        // Fetch other related data
                                        $user_id = $user->id;
                                        $agri_district = $user->agri_district;
                                        $agri_districts_id = $user->agri_districts_id;
                                        $cropVarieties = CropCategory::all();
                            
                                        // Fetch profile and other necessary data
                                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                                        $farmData = FarmProfile::find($id);
                                        $cropData = Crop::find($id);
                                        $fixedData = FixedCost::with('cropFarm')->find($id);
                                        $machineriesData =MachineriesUseds::with('cropFarm')->find($id);
                                        $variablesData =VariableCost::with('cropFarm')->find($id);
                                        $Solds = ProductionSold::with('cropFarm')->find($id);
                                        $production = LastProductionDatas::with('cropFarm')->find($id);
                                    
                                    
                                    
                                        // Handle AJAX requests
                                        if ($request->ajax()) {
                                            $type = $request->input('type');
                            
                                            // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                                            if ($type === 'Solds') {
                                                $Solds =ProductionSold::find($id); // Find the fixed cost data by ID
                                                if ($Solds) {
                                                    return response()->json($Solds); // Return the data as JSON
                                                } else {
                                                    return response()->json(['error' => 'variable cost data not found.'], 404);
                                                }
                                            }
                            
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
                                            }
                            
                                            // Handle requests for crops and varieties
                                            if ($type === 'crops') {
                                                $crops = CropCategory::pluck('crop_name', 'crop_name');
                                                return response()->json($crops);
                                            }
                            
                                            if ($type === 'varieties') {
                                                $cropId = $request->input('crop_name');
                                                $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
                                                return response()->json($varieties);
                                            }
                            
                                            if ($type === 'seedname') {
                                                $varietyId = $request->input('variety_name');
                                                $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
                                                return response()->json($seeds);
                                            }
                            
                                            return response()->json(['error' => 'Invalid type parameter.'], 400);
                                        }
                            
                                        // Return the view with the fetched data
                                        return view('agent.FarmerInfo.Solds.add', compact(
                                            'agri_district', 'agri_districts_id', 'agent', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                                            'farmData', 'cropData', 'production', 'fixedData','machineriesData','variablesData','Solds'
                                        ));
                                    } else {
                                        return redirect()->route('login')->with('error', 'User not found.');
                                    }
                                } else {
                                    return redirect()->route('login');
                                }
                            }


                            public function storeSolds(Request $request)
                            {
                           
                              
                                  
                               
                                // return $production;
                            //  dd($production);
                                
                                    
                                // Iterate through the sales data
                                foreach ( $request->salesData as $sale) {
                                    // Create a new sale associated with the production ID
                                    $salesModel = new ProductionSold();
                                    
                                    // Assign values to the new sale model from the request data
                                    $salesModel->crops_farms_id = $sale['cropsId'];
                                    $salesModel->sold_to = $sale['soldTo']; // Assuming $productionId is set earlier in the code
                                    $salesModel->sold_to = $sale['soldTo'];
                                    $salesModel->measurement = $sale['measurement'];
                                    $salesModel->unit_price_rice_per_kg = $sale['unit_price']; // Ensure the key names match your form data
                                    $salesModel->quantity = $sale['quantity'];
                                    $salesModel->gross_income = $sale['grossIncome'];
                                    
                                    // Save the new sale to the database
                                    $salesModel->save();
                                }
                                    
                                   
                
                                            // return $request;
                                           
                                    
                                     // Return success message
                                     return [
                                         'success' => "Saved to database" // Corrected the syntax here
                                     ];
                                 }  
                
                            // edit solds 
                            public function EditSolds(Request $request, $id)
                            {
                                // Check if the user is authenticated
                                if (Auth::check()) {
                                    // Retrieve the authenticated user's ID
                                    $userId = Auth::id();
                                    $agent = User::find($userId);
                            
                                    if ($agent) {
                                        $user = auth()->user();
                                        
                                        // Ensure user is authenticated
                                        if (!$user) {
                                            return redirect()->route('login');
                                        }
                            
                                        // Fetch other related data
                                        $user_id = $user->id;
                                        $agri_district = $user->agri_district;
                                        $agri_districts_id = $user->agri_districts_id;
                                        $cropVarieties = CropCategory::all();
                            
                                        // Fetch profile and other necessary data
                                        $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                                        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                                        $farmData = FarmProfile::find($id);
                                        $cropData = Crop::find($id);
                                        $fixedData = FixedCost::with('cropFarm')->find($id);
                                        $machineriesData =MachineriesUseds::with('cropFarm')->find($id);
                                        $variablesData =VariableCost::with('cropFarm')->find($id);
                                        $Solds = ProductionSold::with('cropFarm')->find($id);
                                        $production = LastProductionDatas::with('cropFarm')->find($id);
                                    
                                    
                                    
                                        // Handle AJAX requests
                                        if ($request->ajax()) {
                                            $type = $request->input('type');
                            
                                            // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                                            if ($type === 'ProductionSolds') {
                                                $Solds =ProductionSold::find($id); // Find the fixed cost data by ID
                                                if ($Solds) {
                                                    return response()->json($Solds); // Return the data as JSON
                                                } else {
                                                    return response()->json(['error' => 'Solds cost data not found.'], 404);
                                                }
                                            }
                            
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
                                            }
                            
                                            // Handle requests for crops and varieties
                                            if ($type === 'crops') {
                                                $crops = CropCategory::pluck('crop_name', 'crop_name');
                                                return response()->json($crops);
                                            }
                            
                                            if ($type === 'varieties') {
                                                $cropId = $request->input('crop_name');
                                                $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
                                                return response()->json($varieties);
                                            }
                            
                                            if ($type === 'seedname') {
                                                $varietyId = $request->input('variety_name');
                                                $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
                                                return response()->json($seeds);
                                            }
                            
                                            return response()->json(['error' => 'Invalid type parameter.'], 400);
                                        }
                            
                                        // Return the view with the fetched data
                                        return view('agent.FarmerInfo.Solds.edit', compact(
                                            'agri_district', 'agri_districts_id', 'agent', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                                            'farmData', 'cropData', 'production', 'fixedData','machineriesData','variablesData','Solds'
                                        ));
                                    } else {
                                        return redirect()->route('login')->with('error', 'User not found.');
                                    }
                                } else {
                                    return redirect()->route('login');
                                }
                            }
                            
                            public function UpdateSolds(Request $request, $id)
                            {
                                try {
                                    // Find the ProductionSold record
                                    $solds = ProductionSold::find($id);
                            
                                    // Update fields with request data
                                    $solds->crops_farms_id = $request->crops_farms_id;
                                    $solds->last_production_datas_id = $request->last_production_datas_id;
                                    $solds->sold_to = $request->sold_to;
                                    $solds->measurement = $request->measurement;
                                    $solds->measurement = $request->measurement;
                                    $solds->unit_price_rice_per_kg = $request->unit_price_rice_per_kg;
                                    $solds->gross_income = $request->gross_income;
                            
                                    // Save the updated record
                                    $solds->save();
                            
                                    // Redirect to the production view page based on the crop_farms_id
                                    return redirect()->route('agent.FarmerInfo.production_view', $solds->crops_farms_id)
                                        ->with('message', 'Production Solds Data updated successfully');
                                } catch (\Exception $ex) {
                                    // Handle the exception and provide error feedback
                                    return redirect()->back()->with('message', 'Something went wrong');
                                }
                            }

                        public function DeleteSolds($id) {
                        try {
                        // Find thecrop farm by ID
                        $Solds =ProductionSold::find($id);

                        // Check if thecrop farm exists
                        if (!$Solds) {
                        return redirect()->back()->with('error', 'Production Solds  not found');
                        }

                        // Delete theProduction Solds  data from the database
                        $Solds->delete();

                        // Redirect back with success message
                        return redirect()->back()->with('message', 'Production Solds  deleted successfully');

                        } catch (\Exception $e) {
                        // Handle any exceptions and redirect back with error message
                        return redirect()->back()->with('error', 'Error deleting Production Solds: ' . $e->getMessage());
                        }
                        }

}


