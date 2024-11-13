<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Http\Requests\ParcellaryBoundariesRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Crop;
use App\Models\FarmProfile;
use App\Models\Fertilizer;
use App\Models\FixedCost;
use App\Models\Labor;
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
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function fetchData()
    {
        $landingPageData = LandingPage::first();
        $features = json_decode($landingPageData->agri_feature, true) ?? []; 

        $data = [
            'home_title' => $landingPageData->home_title ?? '',
            'home_description' => $landingPageData->home_description ?? '',
            'feature_header' => $landingPageData->feature_header ?? '',
            'feature_description' => $landingPageData->feature_description ?? '',
            'features'=> $features
        ];

        return response()->json($data);
    }
    public function AboutUs()
    {
        $Aboutdata = AboutUs::first();
        // $features = json_decode($landingPageData->agri_feature, true) ?? []; 

        $data = [
            'welcome_title' => $Aboutdata->welcome_title ?? '',
            'welcome_description' => $Aboutdata->welcome_description ?? '',
            'mission_header' => $Aboutdata->mission_title ?? '',
            'mission_description' => $Aboutdata->mission_description ?? '',
            'vision' => $Aboutdata->vision ?? '',
            'vision_description' => $Aboutdata->vision_description ?? '',
            
        ];

        return response()->json($data);
    }     
    

    public function ContactUs()
    {
        $dataContact = ContactUs::first();
        // $features = json_decode($landingPageData->agri_feature, true) ?? []; 
        $features = json_decode($dataContact->coordinates, true) ?? []; 
        $data = [
 
            
            'intro_title' => $landingPageData->intro_title ?? '',
            'location_address' => $landingPageData->location_address ?? '',
            'email' => $landingPageData->email ?? '',
            'contact_no' => $landingPageData->contact_no ?? '',
            'features'=> $features
            
        ];

        return response()->json($data);
    } 
    public function FarmersProfile()
     {
         $farmProfiles = FarmProfile::with([
             'cropFarms',
             'cropFarms.lastProductionDatas',
             'cropFarms.fixedCosts',
             'cropFarms.machineries',
           
             'cropFarms.variableCosts',
             'cropFarms.productionSolds',
             'personalInformation'
         ])->get();

        //  $machineryCostData = [];

        //  // Loop through each farm profile
        //  foreach ($farmProfiles as $farmProfile) {
        //      // Loop through each crop farm associated with the profile
        //      foreach ($farmProfile->cropFarms as $cropFarm) {
        //          // Loop through each production data associated with the crop farm
        //          foreach ($cropFarm->lastProductionDatas as $productionData) {
        //              $croppingNo = $productionData->cropping_no;
         
        //              // Initialize the cost data for the cropping number if not already set
        //              if (!isset($machineryCostData[$croppingNo])) {
        //                  $machineryCostData[$croppingNo] = 0;
        //              }
         
        //              // Loop through each machinery associated with the crop farm
        //              foreach ($cropFarm->machineries as $machinery) {
        //                  // Ensure lastUsageData is available and is a collection
        //                  if ($machinery->lastUsageData) {
        //                      // Loop through each usage data for the machinery
        //                      foreach ($machinery->lastUsageData as $usageData) {
        //                          // Check if total_cost_for_machineries is set and numeric
        //                          if (isset($usageData->total_cost_for_machineries) && is_numeric($usageData->total_cost_for_machineries)) {
        //                              $machineryCostData[$croppingNo] += $usageData->total_cost_for_machineries;
        //                          }
        //                      }
        //                  }
        //              }
        //          }
        //      }
        //  }
        $machineryCostData = [];

        foreach ($farmProfiles as $farmProfile) {
            foreach ($farmProfile->cropFarms as $cropFarm) {
                foreach ($cropFarm->lastProductionDatas as $productionData) {
                    $croppingNo = $productionData->cropping_no;
    
                    // Initialize the cropping number if not set
                    if (!isset($machineryCostData[$croppingNo])) {
                        $machineryCostData[$croppingNo] = 0;
                    }
    
                    // Sum up all machinery costs
                    foreach ($cropFarm->machineries as $machinery) {
                        $machineryCostData[$croppingNo] += $machinery->total_cost_for_machineries; 
                    }
                }
            }
        }
    
       
    $variableCostData = [];

    foreach ($farmProfiles as $farmProfile) {
        foreach ($farmProfile->cropFarms as $cropFarm) {
            foreach ($cropFarm->lastProductionDatas as $productionData) {
                $croppingNo = $productionData->cropping_no;

                // Initialize the cropping number if not set
                if (!isset($variableCostData[$croppingNo])) {
                    $variableCostData[$croppingNo] = 0;
                }

                // Sum up all variable costs
                foreach ($cropFarm->variableCosts as $variableCost) {
                    $variableCostData[$croppingNo] += $variableCost->total_variable_cost; // Adjust 'amount' based on your field name
                }
            }
        }
    }
         
             // Count occurrences of sex values
    $sexCounts = $farmProfiles->flatMap(function ($farmProfile) {
        // Check if personalInformation exists and return the sex value
        return $farmProfile->personalInformation ? [$farmProfile->personalInformation->sex] : [];
    })->countBy(function ($sex) {
        // Normalize the sex value to ensure consistency in counting
        return ucfirst(strtolower($sex)); // Convert to lower case and capitalize first letter
    });

    // Get total counts for Male and Female, defaulting to 0 if not found
    $totalMale = $sexCounts->get('Male', 0);
    $totalFemale = $sexCounts->get('Female', 0);


 


         // Initialize an array to hold unique crop names and their total gross incomes
         $totalGrossIncomeByCrop = [];
     
         foreach ($farmProfiles as $farmProfile) {
             foreach ($farmProfile->cropFarms as $cropFarm) {
                 // Capitalize the crop name to ensure it's a proper noun
                 $cropName = ucwords(strtolower($cropFarm->crop_name)); // Proper noun formatting
     
                 // Initialize gross income for this crop if it doesn't exist
                 if (!isset($totalGrossIncomeByCrop[$cropName])) {
                     $totalGrossIncomeByCrop[$cropName] = 0;
                 }
     
                 // Calculate production sold income
                 $productionSold = $cropFarm->productionSolds->sum('gross_income');
     
                 // If there's production sold data, use it; otherwise, fallback to last production data
                 if ($productionSold > 0) {
                     $totalGrossIncomeByCrop[$cropName] += $productionSold; // Increment gross income
                 } else {
                     $lastProductionIncome = $cropFarm->lastProductionDatas->sum(function($lastProductionData) {
                         return $lastProductionData->gross_income_palay + $lastProductionData->gross_income_rice;
                     });
                     $totalGrossIncomeByCrop[$cropName] += $lastProductionIncome; // Increment gross income
                 }
             }
         }
     
         // Prepare the data for response
         $grossIncomeData = [
             'labels' => array_keys($totalGrossIncomeByCrop),
             'data' => array_values($totalGrossIncomeByCrop),
         ];
     
         // Prepare cropping data for the chart
         $croppingData = [];
         foreach ($farmProfiles as $farmProfile) {
             foreach ($farmProfile->cropFarms as $cropFarm) {
                 // Capitalize the crop name
                 $cropName = ucwords(strtolower($cropFarm->crop_name)); 
     
                 foreach ($cropFarm->lastProductionDatas as $productionData) {
                     $noOfCropping = $productionData->cropping_no;
                     $totalYieldKg = $productionData->yield_tons_per_kg;
     
                     if (!isset($croppingData[$noOfCropping])) {
                         $croppingData[$noOfCropping] = 0;
                     }
                     $croppingData[$noOfCropping] += $totalYieldKg; // Aggregate total yield
                 }
             }
         }
     
         $labels = array_keys($croppingData);
         $yields = array_map(fn($kg) => $kg / 1000, array_values($croppingData)); // Convert kg to tons
     



  
         // Check if the request is AJAX
         if (request()->ajax()) {
             return response()->json([
                 'grossIncome' => $grossIncomeData, // Total gross income by crop
                 'croppingData' => [
                     'labels' => $labels,
                     'yields' => $yields,
        
                        
                 ],
                 'labels' => array_keys($machineryCostData),
        'series' => array_values($machineryCostData),
                 'male' => $totalMale,
                 'female' => $totalFemale,
                 'variableCostLabels' => array_keys($variableCostData), // Cropping numbers
                 'variableCostSeries' => array_values($variableCostData) // Total variable costs per cropping number
             ]);
         }
     }
     
     
    
    public function LandingPage(Request $request)
    {
       
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
                    $totalAreaYield = Crop::whereIn('farm_profiles_id', $farmProfilesQuery->pluck('id'))
        ->sum('yield_kg_ha');
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

$districtFarmCounts = FarmProfile::select('agri_districts_id', DB::raw('count(*) as count'))
->groupBy('agri_districts_id')
->with('agriDistrict') // Eager load the AgriDistrict relation
->get();

// Structure the farm count data for the pie chart
$districtFarmData = [];
foreach ($districtFarmCounts as $farmCount) {
$districtName = optional($farmCount->agriDistrict)->name ?? 'Unknown';
$districtFarmData[] = [
    'name' => $districtName,
    'y' => $farmCount->count
];
}

// Prepare data for pie chart
$pieChartDatasDistrict = [
    'series' => array_column($districtFarmData, 'y'), // Extract the counts for the pie chart
    'labels' => array_column($districtFarmData, 'name'), // Extract the district names for labels
];

//    // Fetch all districts for dropdowns
//    $districts = AgriDistrict::all();

//    // Initialize the FarmProfile query
//    $farmProfilesQuery = FarmProfile::with('personalInformation', 'agriDistrict');

//    // Apply filters based on the selected criteria
//    if ($selectedDistrict && $selectedDistrict !== 'All') {
//        $farmProfilesQuery->whereHas('agriDistrict', function ($query) use ($selectedDistrict) {
//            $query->where('district', $selectedDistrict);
//        });
//    }

//    if ($selectedCropName && $selectedCropName !== 'All') {
//        $farmProfilesQuery->whereHas('crops', function ($query) use ($selectedCropName) {
//            $query->where('name', $selectedCropName);
//        });
//    }

//    if ($selectedDateFrom && $selectedDateTo) {
//        $farmProfilesQuery->whereBetween('created_at', [$selectedDateFrom, $selectedDateTo]);
//    }
    // Initialize the FarmProfile query
    $farmProfilesQuery = FarmProfile::query()
        ->when($selectedCropName, function ($query) use ($selectedCropName) {
            // Filter by crop_name if it is provided
            $query->whereHas('cropFarms', function ($cropQuery) use ($selectedCropName) {
                $cropQuery->where('crop_name', $selectedCropName);
            });
        })
        ->when($selectedDistrict, function ($query) use ($selectedDistrict) {
            // Filter by district if provided
            $query->where('agri_districts', $selectedDistrict);
        })
        ->when($selectedDateFrom, function ($query) use ($selectedDateFrom) {
            // Filter by start date if provided
            $query->where('created_at', '>=', $selectedDateFrom);
        })
        ->when($selectedDateTo, function ($query) use ($selectedDateTo) {
            // Filter by end date if provided
            $query->where('created_at', '<=', $selectedDateTo);
        });

    // Get the distribution frequency of farms in the filtered agri districts
    $distributionFrequency = $farmProfilesQuery
        ->select('agri_districts', DB::raw('count(*) as total'))
        ->groupBy('agri_districts')
        ->pluck('total', 'agri_districts');

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
    
    // 'farmersTable' => view('admin.partials.farmers_table', ['paginatedFarmers' => $paginatedFarmers])->render(),
    // 'paginationLinks' => view('admin.partials.pagination', ['paginatedFarmers' => $paginatedFarmers])->render(),
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
    'districtFarmData'=>$districtFarmData,
  
    
//    '$totalVariableCostsByDistrict'=>$$totalVariableCostsByDistrict

    // Include other necessary data here
]);

                }
    
                // Pass all data to the view
                return view('landing-page.page', compact(
                    'totalFarms',
                    'totalAreaPlanted',
                    'totalAreaYield',
                    'totalCost',
                    'yieldPerAreaPlanted',
                    'averageCostPerAreaPlanted',
                    'totalRiceProduction',
                    'crops',
                   
                    'districts',
                 
                   
                
                 
                ));
            }
 
    
    public function viewHomepages(){
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
        $Page=LandingPage::orderBy('id','asc')->paginate(5);
    
    
        
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        // Return the view with the fetched data
        return view('landing-page.view_homepage', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
        ,'userId','Page'));
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
        //
    }

    /**
     * Display the specified resource.
     */
   
     public function addHomepage(){
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
        return view('landing-page.add_homepage', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
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

 public function SavePage(Request $request){
    try {
            
        $page = new LandingPage();
        $page->users_id = $request['users_id'];
        $page->home_title = $request['home_title'];
        $page->home_description = $request['home_description'];
        // $page->home_logo = $request['home_logo'];
        // $page->agri_logo = $request['agri_logo'];      
        // $page->home_imageslider = $request['home_imageslider'];
        // $page->feature_header = $request['feature_header'];
        // $page->feature_description = $request['feature_description'];
        // $page->agri_features = $request['agri_features'];
        // $page->agri_description = $request['agri_description'];
      
        // dd($page);
        $page->save();
        
        return redirect('/admin-view-homepage-setting')->with('message', 'homepage added successfully');
    } catch(\Exception $ex) {
        // dd($ex);
        return redirect('/admin-add-homepage')->with('message', 'Please Try again');
    }


 }
    /**
     * Show the form for editing the specified resource.
     */
   
     public function editHomepage($id){
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
        $Page= LandingPage::find($id);
    
    
        
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        // Return the view with the fetched data
        return view('landing-page.edit_homepage', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
        ,'userId','Page'));
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

    public function editSave(Request $request,$id){
        try {
                
            $page = LandingPage::find($id);
         
            $page->users_id = $request['users_id'];
            $page->home_title = $request['home_title'];
            $page->home_description = $request['home_description'];
            // $page->home_logo = $request['home_logo'];
            // $page->agri_logo = $request['agri_logo'];      
            // $page->home_imageslider = $request['home_imageslider'];
            // $page->feature_header = $request['feature_header'];
            // $page->feature_description = $request['feature_description'];
            // $page->agri_features = $request['agri_features'];
            // $page->agri_description = $request['agri_description'];
            // dd($page);
            $page->save();
            
            return redirect('/admin-view-homepage-setting')->with('message', 'homepage added successfully');
        } catch(\Exception $ex) {
            dd($ex);
            return redirect('/admin-edit-homepage/{Page}')->with('message', 'Something went wrong');
        }
    
    
     }

    public function DeletePage($id) {
        try {
            // Find the personal information by ID
            $notif = LandingPage::find($id);
    
            // Check if the personal information exists
            if (!$notif) {
                return redirect()->back()->with('error', 'Homepage not found');
            }
    
            // Delete the personal information data from the database
            $notif->delete();
    
            // Redirect back with success message
            return redirect()->back()->with('message', 'Homepage deleted successfully');
    
        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with error message
            return redirect()->back()->with('error', 'Error deleting Homepage: ' . $e->getMessage());
        }
    }

    
    // Features
    public function addFeatures(){
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
        return view('landing-page.Features.add', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
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
    
}
