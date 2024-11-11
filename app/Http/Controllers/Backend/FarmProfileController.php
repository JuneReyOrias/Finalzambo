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
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use App\Models\CropParcel;
use App\Models\ParcellaryBoundaries;
use App\Models\Polygon;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Pagination\LengthAwarePaginator;

class FarmProfileController extends Controller
{
   

   
        public function showFarmerProfiles(Request $request,$id)
        {
            // Fetch the farm profile data
            $farmProfile = FarmProfile::with('cropFarms')->find($id);
        
            // You might also want to fetch the admin data if necessary
            $admin = Auth::user(); // Assuming you are using Laravel's Auth to get the currently logged-in user
        
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
            return view('farm_profile.farmer_profile', compact('farmProfile', 'cropsData', 'gpsData', 'admin','data','farmProfile'));
        }
            
        // public function showFarmerProfiles(Request $request,$id)
        // {
        //     // Check if the user is authenticated
        //     if (Auth::check()) {
        //         // User is authenticated, proceed with retrieving the user's ID
        //         $userId = Auth::id();
        
        //         // Find the user based on the retrieved ID
        //         $admin = User::find($userId);
        
        //         if ($admin) {
        //             // Assuming $user represents the currently logged-in user
        //             $admin = auth()->user();
        
        //             // Check if user is authenticated before proceeding
        //             if (!$admin) {
        //                 // Handle unauthenticated user, for example, redirect them to login
        //                 return redirect()->route('login');
        //             }
        
        //             // Find the user's personal information by their ID
        //             $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
        
        //             // Fetch the farm ID associated with the user
        //             $farmId = $admin->farm_id;
        
        //             // Find the farm profile using the fetched farm ID
        //             $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
        
        //             // $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])
        //             //     ->where('users_id', $userId) // Filter based on user_id
        //             //     ->get();
        //             $farmData = FarmProfile::find($id);
        //             $farmProfiles = FarmProfile::with([
        //                 'cropFarms', 
        //                 'cropFarms.lastProductionDatas', 
        //                 'cropFarms.fixedCosts', 
        //                 'cropFarms.machineries', 
        //                 'cropFarms.variableCosts', 
        //                 'cropFarms.productionSolds',
        //                 'personalInformation'
        //             ])
        //             // ->where('users_id', $userId) // Filter based on user_id
        //             ->get();
                 
            
        //             // Format the data for the pie chart (label and data pairs)
                
        //                   // Prepare an array for GPS coordinates
        //                   $gpsData = [];
        //                   foreach ($farmProfiles as $farmProfile) {
        //                       // Concatenate all crop names associated with the farm profile
        //                   // This will create a comma-separated string of crop names
        //                   foreach ($farmProfile->cropFarms as $cropFarm) {
        //                       $cropNames = $cropFarm->crop_name; // Fetch individual crop name
        //                       $cropVariety = $cropFarm->type_of_variety_planted ?? $cropFarm->preferred_variety; // Fetch individual crop variety or preferred variety // Fetch individual crop variety
        //                       $croppingperYear = $cropFarm->no_of_cropping_per_year; // Fetch individual cropping per year
        //                       $yield = $cropFarm->yield_kg_ha; // Fetch individual yield
        //                       $planting_schedule_wetseason = $cropFarm->planting_schedule_wetseason;
        //                       $planting_schedule_dryseason = $cropFarm->planting_schedule_dryseason;
                             
                              
                      
        //                       // Now you can use these variables as needed
        //                       // For example, you could print them
        //                       // echo "Crop Name: $cropNames, Crop Variety: $cropVariety, Cropping/Year: $croppingperYear, Yield: $yield kg/ha\n";
        //                   }
        
        
        //                       // Access personal information (if it exists)
        //                           $farmerName = $farmProfile->personalInformation ? 
        //                           ($farmProfile->personalInformation->first_name . 
        //                           ($farmProfile->personalInformation->middle_name ? ' ' . $farmProfile->personalInformation->middle_name : '') . 
        //                           ' ' . $farmProfile->personalInformation->last_name) : 
        //                           null;
                                  
        
        //                       $civilStatus = $farmProfile->personalInformation ? $farmProfile->personalInformation->civil_status : null; // Adjust field name as needed
        //                       $orgName = $farmProfile->personalInformation ? $farmProfile->personalInformation->nameof_farmers_ass_org_coop: null; // Adjust field name as needed
        //                      // Fetch the city, district, and barangay from personal information
        //                         $city = $farmProfile->personalInformation ? $farmProfile->personalInformation->city : null;
        //                         $district = $farmProfile->personalInformation ? $farmProfile->personalInformation->district : null;
        //                         $barangay = $farmProfile->personalInformation ? $farmProfile->personalInformation->barangay : null; 
        
        //                         // Join city, district, and barangay into a single string, skipping null values
        //                         $completeAddress = collect([$barangay, $district, $city])
        //                                             ->filter()
        //                                             ->implode(', ');
        
        //                         // Fetch home_address and fallback to completeAddress if home_address is null
        //                         $homeAddress = $farmProfile->personalInformation && $farmProfile->personalInformation->home_address 
        //                                     ? $farmProfile->personalInformation->home_address 
        //                                     : $completeAddress;
        
        //                       $landtitleNo = $farmProfile->personalInformation ? $farmProfile->personalInformation->land_title_no: null;
        //                       $lotNo = $farmProfile->personalInformation ? $farmProfile->personalInformation->lot_no: null;
        //                       $province = $farmProfile->personalInformation ? $farmProfile->personalInformation->province: null;
        //                       $country = $farmProfile->personalInformation ? $farmProfile->personalInformation->country: null;
                              
        //                       $street = $farmProfile->personalInformation ? $farmProfile->personalInformation->street: null;
        //                       $zip_code = $farmProfile->personalInformation ? $farmProfile->personalInformation->zip_code: null;
        //                       $sex = $farmProfile->personalInformation ? $farmProfile->personalInformation->sex: null;
        //                       $religion = $farmProfile->personalInformation ? $farmProfile->personalInformation->religion: null;
        //                       $place_of_birth = $farmProfile->personalInformation ? $farmProfile->personalInformation->place_of_birth: null;
        //                       $contact_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->contact_no: null;
        //                       $civil_status = $farmProfile->personalInformation ? $farmProfile->personalInformation->civil_status: null;
        //                       $name_legal_spouse = $farmProfile->personalInformation ? $farmProfile->personalInformation->name_legal_spouse: null;
        //                       $no_of_children = $farmProfile->personalInformation ? $farmProfile->personalInformation->no_of_children: null;
        //                       $mothers_maiden_name = $farmProfile->personalInformation ? $farmProfile->personalInformation->mothers_maiden_name: null;
        //                       $highest_formal_education = $farmProfile->personalInformation ? $farmProfile->personalInformation->highest_formal_education: null;
        //                       $person_with_disability = $farmProfile->personalInformation ? $farmProfile->personalInformation->person_with_disability: null;
        //                       $pwd_id_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->pwd_id_no: null;
        //                       $id_type = $farmProfile->personalInformation ? $farmProfile->personalInformation->id_type: null;
        //                       $gov_id_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->gov_id_no: null;
        //                       $nameof_farmers_ass_org_coop = $farmProfile->personalInformation ? $farmProfile->personalInformation->nameof_farmers_ass_org_coop: null;
        //                       $name_contact_person = $farmProfile->personalInformation ? $farmProfile->personalInformation->name_contact_person: null;
        //                       $cp_tel_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->cp_tel_no: null;
        
                            
        //                   // Fetch date_of_birth from the related personalInformation model
        //                   $dateOfBirth = $farmProfile->personalInformation ? $farmProfile->personalInformation->date_of_birth : null;
        
        //                   // Calculate age based only on the year (ignores month/day)
        //                   $age = null;
        //                   if ($dateOfBirth) {
        //                       $birthYear = Carbon::parse($dateOfBirth)->year; // Extract year of birth
        //                       $currentYear = Carbon::now()->year; // Get the current year
        
        //                       // Debugging: check the values of birthYear and currentYear
        //                       // dd($birthYear, $currentYear); // This will dump the values to the screen and stop execution
        
        //                       $age = $currentYear - $birthYear; // Calculate the difference in years
        //                   }
        
        //                       $gpsData[] = [
        //                           'gpsLatitude' => $farmProfile->gps_latitude,
        //                           'gpsLongitude' => $farmProfile->gps_longitude,
        //                           'FarmAddress' => $farmProfile->farm_address,
        //                           'NoYears' => $farmProfile->no_of_years_as_farmers,
        //                           'totalPhysicalArea' => $farmProfile->total_physical_area,
        //                           'TotalCultivated' => $farmProfile->total_area_cultivated,
        //                           'tenurial_status' => $farmProfile->tenurial_status,
        //                           'area_prone_to' => $farmProfile->area_prone_to,
        //                           'ecosystem' => $farmProfile->ecosystem,
        //                           'rsba_registered' => $farmProfile->rsba_registered,
        //                           'pcic_insured' => $farmProfile->pcic_insured,
        //                           'government_assisted' => $farmProfile->government_assisted,
        //                           'source_of_capital' => $farmProfile->tenurial_status,
        
        //                           'cropName' => $cropNames, // List of crops
        //                           'cropVariety' => $cropVariety,
        //                           'croppingperYear' => $croppingperYear,
        //                           'planting_schedule_wetseason' => $planting_schedule_wetseason ? Carbon::parse($planting_schedule_wetseason)->format('F d, Y') : 'N/A',
        //                           'planting_schedule_dryseason' => $planting_schedule_dryseason ? Carbon::parse($planting_schedule_dryseason)->format('F d, Y') : 'N/A',
        //                           'Yield' => $yield,
        
        //                           'farmerName' => $farmerName, // Farmer's name from personal information
        //                           'civilStatus' => $civilStatus,
        //                           'orgName' => $orgName,
        //                           'homeAddress' => $homeAddress,
        //                           'landtitleNo' => $landtitleNo,
        //                           'lotNo' => $lotNo,
        //                           'age' => $age,
        
        //                           'country'=>$country,
        //                           'province'=>$province,
        //                           'street'=>$street,
        //                           'zip_code'=>$zip_code,
        //                           'sex'=>$sex,
        //                           'religion'=>$religion,
        //                           'mothers_maiden_name'=>$mothers_maiden_name,
        //                           'place_of_birth'=>$place_of_birth,
        //                           'contact_no'=>$contact_no,
        //                           'name_legal_spouse'=>$name_legal_spouse,
        //                           'no_of_children'=>$no_of_children,
        //                           'highest_formal_education'=>$highest_formal_education,
        //                           'person_with_disability'=>$person_with_disability,
        //                           'pwd_id_no'=>$pwd_id_no,
        //                           'gov_id_no'=>$gov_id_no,
        //                           'id_type'=>$id_type,
        //                           'name_contact_person'=>$name_contact_person,
        //                           'cp_tel_no'=>$cp_tel_no,
                                
        
        //                       ];
        //                   }
        
        
        //                 // Initialize an array to hold crop data
        //                     $cropData = [];
        
        //                     // Loop through each farm profile to gather crop farm data
        //                     foreach ($farmProfiles as $farmProfile) {
        //                         foreach ($farmProfile->cropFarms as $cropFarm) {
        //                             $cropName = $cropFarm->crop_name; // Assuming there is a crop_name field
        //                             $totalYield = $cropFarm->lastProductionDatas->sum('yield_tons_per_kg'); // Sum of yield per crop
        
        //                             // Initialize crop data if not set
        //                             if (!isset($cropData[$cropName])) {
        //                                 $cropData[$cropName] = 0;
        //                             }
                                    
        //                             // Accumulate total yield for the crop
        //                             $cropData[$cropName] += $totalYield;
        //                         }
        //                     }
        
        //                     // Format the data for Chart.js
        //                     $formattedData = [
        //                         'labels' => array_map('ucfirst', array_keys($cropData)), // Capitalize the first letter of each crop name
        //               'data' => array_values($cropData),  
                    
        //             ];
        
        //             // Initialize an array to hold the gross income per crop
        //                         $grossIncomeData = [];
        
        //                         // Loop through the farm profiles
        //                         foreach ($farmProfiles as $farmProfile) {
        //                             foreach ($farmProfile->cropFarms as $cropFarm) {
        //                                 // Check for production sold data
        //                                 $productionSold = $cropFarm->productionSolds->sum('gross_income'); // Assuming 'income' is the field for gross income
        
        //                                 // If there's no production sold data, fallback to last production data
        //                                 if ($productionSold > 0) {
        //                                     if (!isset($grossIncomeData[$cropFarm->crop_name])) {
        //                                         $grossIncomeData[$cropFarm->crop_name] = 0;
        //                                     }
        //                                     $grossIncomeData[$cropFarm->crop_name] += $productionSold; // Store the production sold income
        //                                 } else {
        //                                     // Calculate the total income from last production data
        //                                     $lastProductionIncome = $cropFarm->lastProductionDatas->sum(function($lastProductionData) {
        //                                         return $lastProductionData->gross_income_palay + $lastProductionData->gross_income_rice; // Sum the relevant income fields
        //                                     });
        
        //                                     if (!isset($grossIncomeData[$cropFarm->crop_name])) {
        //                                         $grossIncomeData[$cropFarm->crop_name] = 0;
        //                                     }
        //                                     $grossIncomeData[$cropFarm->crop_name] += $lastProductionIncome; // Store the last production income
        //                                 }
        //                             }
        //                         }
        
        //                         // Prepare formatted data for the response
        //                         $formattedIncomeData = [
        //                             'labels' => array_keys($grossIncomeData),
        //                             'data' => array_values($grossIncomeData),
        //                         ];
        
        
        
        //                             // Prepare the data for the chart
        //                         $croppingData = [];
        //                         foreach ($farmProfiles as $farmProfile) {
        //                             foreach ($farmProfile->cropFarms as $cropFarm) {
        //                                 foreach ($cropFarm->lastProductionDatas as $productionData) {
        //                                     $noOfCropping = $productionData->cropping_no;
        //                                     $totalYieldKg = $productionData->yield_tons_per_kg; // Assuming you have a field for total yield in kg
                                            
        //                                     if (!isset($croppingData[$noOfCropping])) {
        //                                         $croppingData[$noOfCropping] = 0;
        //                                     }
        //                                     $croppingData[$noOfCropping] += $totalYieldKg; // Aggregate total yield
        //                                 }
        //                             }
        //                         }
        //                         // Convert data to a format suitable for Chart.js
        //                         $labels = array_keys($croppingData); // Number of cropping
        //                         $yields = array_map(fn($kg) => $kg / 1000, array_values($croppingData)); // Convert kg to tons
        
        //                    // Check if the request is AJAX
        //             if (request()->ajax()) {
        //                 return response()->json([
        //                     'formattedData' => $formattedData,
        //                     'formattedIncomeData' => $formattedIncomeData,
        //                     'labels' => $labels,
        //                      'yields' => $yields,
        //                 ]);
        //             }
        
        
        //             // Return the view with the fetched data (non-AJAX)
        //             return view('farm_profile.farmer_profile', compact('admin', 'gpsData', 'farmProfiles','farmData'));
        
        //         } else {
        //             // Handle the case where the user is not found
        //             return redirect()->route('login')->with('error', 'User not found.');
        //         }
        //     } else {
        //         // Handle the case where the user is not authenticated
        //         return redirect()->route('login');
        //     }
        // }
         

//         public function showFarmerProfiles(Request $request, $id)
// {
//     // Check if the user is authenticated
//     if (Auth::check()) {
//         // User is authenticated, proceed with retrieving the user's ID
//         $userId = Auth::id();

//         // Find the user based on the retrieved ID
//         $admin = User::find($userId);

//         if ($admin) {
//             // Check if user is authenticated before proceeding
//             if (!$admin) {
//                 // Handle unauthenticated user, for example, redirect them to login
//                 return redirect()->route('login');
//             }

//             // Find the user's personal information by their ID
//             $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

//             // Fetch the farm ID associated with the user
//             $farmId = $admin->farm_id;

//             // Find the farm profile using the fetched farm ID
//             $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

//             // Find the specific farm profile by the provided ID
//             $farmData = FarmProfile::find($id);

//             // Fetch all farm profiles with related models
//             $farmProfiles = FarmProfile::with([
//                 'cropFarms', 
//                 'cropFarms.lastProductionDatas', 
//                 'cropFarms.fixedCosts', 
//                 'cropFarms.machineries', 
//                 'cropFarms.variableCosts', 
//                 'cropFarms.productionSolds',
//                 'personalInformation'
//             ])
//             // Uncomment if you want to filter by user_id
//             // ->where('users_id', $userId) 
//             ->get();

//             // Initialize arrays for data collection
//             $gpsData = [];
//             $cropsData = []; // To store crop-related data
            
//             // Variables for aggregated data
//             $totalAreaPlanted = 0;
//             $totalYield = 0;
//             $totalCost = 0; // For any financial costs
//             $averageYieldPerArea = 0;

//             foreach ($farmProfiles as $farmProfile) {
//                 // Access personal information (if it exists)
//                 foreach ($farmProfile->cropFarms as $cropFarm) {
//                                           $cropNames = $cropFarm->crop_name; // Fetch individual crop name
//                                           $cropVariety = $cropFarm->type_of_variety_planted ?? $cropFarm->preferred_variety; // Fetch individual crop variety or preferred variety // Fetch individual crop variety
//                                           $croppingperYear = $cropFarm->no_of_cropping_per_year; // Fetch individual cropping per year
//                                           $yield = $cropFarm->yield_kg_ha; // Fetch individual yield
//                                           $planting_schedule_wetseason = $cropFarm->planting_schedule_wetseason;
//                                           $planting_schedule_dryseason = $cropFarm->planting_schedule_dryseason;
                                         
                                          
//                 $farmerName = $farmProfile->personalInformation ? 
//                     ($farmProfile->personalInformation->first_name . 
//                     ($farmProfile->personalInformation->middle_name ? ' ' . $farmProfile->personalInformation->middle_name : '') . 
//                     ' ' . $farmProfile->personalInformation->last_name) : 
//                     null;


                    
//                               $civilStatus = $farmProfile->personalInformation ? $farmProfile->personalInformation->civil_status : null; // Adjust field name as needed
//                               $orgName = $farmProfile->personalInformation ? $farmProfile->personalInformation->nameof_farmers_ass_org_coop: null; // Adjust field name as needed
//                              // Fetch the city, district, and barangay from personal information
//                                 $city = $farmProfile->personalInformation ? $farmProfile->personalInformation->city : null;
//                                 $district = $farmProfile->personalInformation ? $farmProfile->personalInformation->district : null;
//                                 $barangay = $farmProfile->personalInformation ? $farmProfile->personalInformation->barangay : null; 
        
//                                 // Join city, district, and barangay into a single string, skipping null values
//                                 $completeAddress = collect([$barangay, $district, $city])
//                                                     ->filter()
//                                                     ->implode(', ');
        
//                                 // Fetch home_address and fallback to completeAddress if home_address is null
//                                 $homeAddress = $farmProfile->personalInformation && $farmProfile->personalInformation->home_address 
//                                             ? $farmProfile->personalInformation->home_address 
//                                             : $completeAddress;
        
//                               $landtitleNo = $farmProfile->personalInformation ? $farmProfile->personalInformation->land_title_no: null;
//                               $lotNo = $farmProfile->personalInformation ? $farmProfile->personalInformation->lot_no: null;
//                               $province = $farmProfile->personalInformation ? $farmProfile->personalInformation->province: null;
//                               $country = $farmProfile->personalInformation ? $farmProfile->personalInformation->country: null;
                              
//                               $street = $farmProfile->personalInformation ? $farmProfile->personalInformation->street: null;
//                               $zip_code = $farmProfile->personalInformation ? $farmProfile->personalInformation->zip_code: null;
//                               $sex = $farmProfile->personalInformation ? $farmProfile->personalInformation->sex: null;
//                               $religion = $farmProfile->personalInformation ? $farmProfile->personalInformation->religion: null;
//                               $place_of_birth = $farmProfile->personalInformation ? $farmProfile->personalInformation->place_of_birth: null;
//                               $contact_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->contact_no: null;
//                               $civil_status = $farmProfile->personalInformation ? $farmProfile->personalInformation->civil_status: null;
//                               $name_legal_spouse = $farmProfile->personalInformation ? $farmProfile->personalInformation->name_legal_spouse: null;
//                               $no_of_children = $farmProfile->personalInformation ? $farmProfile->personalInformation->no_of_children: null;
//                               $mothers_maiden_name = $farmProfile->personalInformation ? $farmProfile->personalInformation->mothers_maiden_name: null;
//                               $highest_formal_education = $farmProfile->personalInformation ? $farmProfile->personalInformation->highest_formal_education: null;
//                               $person_with_disability = $farmProfile->personalInformation ? $farmProfile->personalInformation->person_with_disability: null;
//                               $pwd_id_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->pwd_id_no: null;
//                               $id_type = $farmProfile->personalInformation ? $farmProfile->personalInformation->id_type: null;
//                               $gov_id_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->gov_id_no: null;
//                               $nameof_farmers_ass_org_coop = $farmProfile->personalInformation ? $farmProfile->personalInformation->nameof_farmers_ass_org_coop: null;
//                               $name_contact_person = $farmProfile->personalInformation ? $farmProfile->personalInformation->name_contact_person: null;
//                               $cp_tel_no = $farmProfile->personalInformation ? $farmProfile->personalInformation->cp_tel_no: null;
        
                            
//                     $dateOfBirth = $farmProfile->personalInformation ? $farmProfile->personalInformation->date_of_birth : null;
        
//                     //                   // Calculate age based only on the year (ignores month/day)
//                                       $age = null;
//                                       if ($dateOfBirth) {
//                                           $birthYear = Carbon::parse($dateOfBirth)->year; // Extract year of birth
//                                           $currentYear = Carbon::now()->year; // Get the current year
                    
//                                           // Debugging: check the values of birthYear and currentYear
//                                           // dd($birthYear, $currentYear); // This will dump the values to the screen and stop execution
                    
//                                           $age = $currentYear - $birthYear; // Calculate the difference in years
//                                       }
                    
//                 // Collect all relevant farm data for GPS and other details
//                 $gpsData[] = [
//                     'gpsLatitude' => $farmProfile->gps_latitude,
//                                               'gpsLongitude' => $farmProfile->gps_longitude,
//                                               'FarmAddress' => $farmProfile->farm_address,
//                                               'NoYears' => $farmProfile->no_of_years_as_farmers,
//                                               'totalPhysicalArea' => $farmProfile->total_physical_area,
//                                               'TotalCultivated' => $farmProfile->total_area_cultivated,
//                                               'tenurial_status' => $farmProfile->tenurial_status,
//                                               'area_prone_to' => $farmProfile->area_prone_to,
//                                               'ecosystem' => $farmProfile->ecosystem,
//                                               'rsba_registered' => $farmProfile->rsba_registered,
//                                               'pcic_insured' => $farmProfile->pcic_insured,
//                                               'government_assisted' => $farmProfile->government_assisted,
//                                               'source_of_capital' => $farmProfile->tenurial_status,
                    
//                                             //   'cropName' => $cropNames, // List of crops
//                                             //   'cropVariety' => $cropVariety,
//                                             //   'croppingperYear' => $croppingperYear,
//                                             //   'planting_schedule_wetseason' => $planting_schedule_wetseason ? Carbon::parse($planting_schedule_wetseason)->format('F d, Y') : 'N/A',
//                                             //   'planting_schedule_dryseason' => $planting_schedule_dryseason ? Carbon::parse($planting_schedule_dryseason)->format('F d, Y') : 'N/A',
//                                             //   'Yield' => $yield,
                    
//                                               'farmerName' => $farmerName, // Farmer's name from personal information
//                                               'civilStatus' => $civilStatus,
//                                               'orgName' => $orgName,
//                                               'homeAddress' => $homeAddress,
//                                               'landtitleNo' => $landtitleNo,
//                                               'lotNo' => $lotNo,
//                                               'age' => $age,
                    
//                                               'country'=>$country,
//                                               'province'=>$province,
//                                               'street'=>$street,
//                                               'zip_code'=>$zip_code,
//                                               'sex'=>$sex,
//                                               'religion'=>$religion,
//                                               'mothers_maiden_name'=>$mothers_maiden_name,
//                                               'place_of_birth'=>$place_of_birth,
//                                               'contact_no'=>$contact_no,
//                                               'name_legal_spouse'=>$name_legal_spouse,
//                                               'no_of_children'=>$no_of_children,
//                                               'highest_formal_education'=>$highest_formal_education,
//                                               'person_with_disability'=>$person_with_disability,
//                                               'pwd_id_no'=>$pwd_id_no,
//                                               'gov_id_no'=>$gov_id_no,
//                                               'id_type'=>$id_type,
//                                               'name_contact_person'=>$name_contact_person,
//                                               'cp_tel_no'=>$cp_tel_no,
                                            
                    
//                 ];
//             }
//                 // Process crop data
//                 foreach ($farmProfile->cropFarms as $cropFarm) {
//                     // Prepare crop data
//                     $cropName = $cropFarm->crop_name; // Fetch individual crop name
//                     $cropYield = $cropFarm->yield_kg_ha;
//                     $totalAreaPlanted += $farmProfile->total_physical_area_has; // Sum up the total area planted
//                     $totalYield += $cropYield; // Sum up total yield
                    
//                     // You can add fixed costs and variable costs to totalCost
//                     $totalCost += $cropFarm->fixedCosts->sum('amount') + $cropFarm->variableCosts->sum('amount');

//                     $cropsData[] = [
//                         'cropName' => $cropFarm->crop_name, // Crop name
//                         'cropVariety' => $cropFarm->type_of_variety_planted ?? $cropFarm->preferred_variety, // Crop variety or preferred variety
//                         'croppingPerYear' => $cropFarm->no_of_cropping_per_year, // Cropping per year
//                         'yield' => $cropYield, // Yield in kg per hectare
//                         'plantingScheduleWetSeason' => $cropFarm->planting_schedule_wetseason, // Wet season planting schedule
//                         'plantingScheduleDrySeason' => $cropFarm->planting_schedule_dryseason, // Dry season planting schedule
//                         'lastHarvestDate' => $cropFarm->lastProductionDatas->pluck('harvest_date')->last(), // Last harvest date
//                         'croppingNumber' => $cropFarm->lastProductionDatas->pluck('cropping_no')->last(), // Cropping number
//                     ];
//                 }
//             }

//             // Calculate average yield per area planted
//             if ($totalAreaPlanted > 0) {
//                 $averageYieldPerArea = $totalYield / $totalAreaPlanted; // Calculate average yield
//             }

//             // Prepare data for charts or additional processing
//             $chartData = [
//                 'totalAreaPlanted' => $totalAreaPlanted,
//                 'totalYield' => $totalYield,
//                 'totalCost' => $totalCost,
//                 'averageYieldPerArea' => $averageYieldPerArea,
//                 'cropsData' => $cropsData,
//             ];

//             // Return the view with the necessary data
//             return view('farm_profile.farmer_profile', compact('farmData', 'farmProfiles', 'gpsData', 'chartData')); // Adjust 'your_view' to your actual view file name
//         } else {
//             return redirect()->route('login')->withErrors(['error' => 'User not found.']);
//         }
//     } else {
//         return redirect()->route('login'); // Redirect unauthenticated users
//     }
// }

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
            
            

// user farmer profiling data
public function FarmerProfiling(Request $request)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // User is authenticated, proceed with retrieving the user's ID
        $userId = Auth::id();

        // Find the user based on the retrieved ID
        $user = User::find($userId);

        if ($user) {
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

            // $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])
            //     ->where('users_id', $userId) // Filter based on user_id
            //     ->get();

            $farmProfiles = FarmProfile::with([
                'cropFarms', 
                'cropFarms.lastProductionDatas', 
                'cropFarms.fixedCosts', 
                'cropFarms.machineries', 
                'cropFarms.variableCosts', 
                'cropFarms.productionSolds',
                'personalInformation'
            ])
            ->where('users_id', $userId) // Filter based on user_id
            ->get();
         
    
            // Format the data for the pie chart (label and data pairs)
        
                  // Prepare an array for GPS coordinates
                  $gpsData = [];
                  foreach ($farmProfiles as $farmProfile) {
                      // Concatenate all crop names associated with the farm profile
                  // This will create a comma-separated string of crop names
                  foreach ($farmProfile->cropFarms as $cropFarm) {
                    // Check if $cropFarm is defined and retrieve values with defaults
                    $cropNames = $cropFarm->crop_name ?? 'Unknown Crop';
                    $cropVariety = $cropFarm->type_of_variety_planted ?? $cropFarm->preferred_variety ?? 'N/A';
                    $croppingperYear = $cropFarm->no_of_cropping_per_year ?? 0;
                    $yield = $cropFarm->yield_kg_ha ?? 'N/A';
                    $planting_schedule_wetseason = $cropFarm->planting_schedule_wetseason 
                        ? Carbon::parse($cropFarm->planting_schedule_wetseason)->format('F d, Y') 
                        : 'N/A';
                    $planting_schedule_dryseason = $cropFarm->planting_schedule_dryseason 
                        ? Carbon::parse($cropFarm->planting_schedule_dryseason)->format('F d, Y') 
                        : 'N/A';
                
                    // Personal information fields
                    $farmerName = $farmProfile->personalInformation 
                        ? ($farmProfile->personalInformation->first_name . 
                          ($farmProfile->personalInformation->middle_name ? ' ' . $farmProfile->personalInformation->middle_name : '') . 
                          ' ' . $farmProfile->personalInformation->last_name) 
                        : 'N/A';
                
                    $civilStatus = $farmProfile->personalInformation->civil_status ?? 'N/A';
                    $orgName = $farmProfile->personalInformation->nameof_farmers_ass_org_coop ?? 'N/A';
                    $city = $farmProfile->personalInformation->city ?? 'N/A';
                    $district = $farmProfile->personalInformation->district ?? 'N/A';
                    $barangay = $farmProfile->personalInformation->barangay ?? 'N/A';
                
                    $completeAddress = collect([$barangay, $district, $city])->filter()->implode(', ');
                    $homeAddress = $farmProfile->personalInformation->home_address ?? $completeAddress;
                
                    $landtitleNo = $farmProfile->personalInformation->land_title_no ?? 'N/A';
                    $lotNo = $farmProfile->personalInformation->lot_no ?? 'N/A';
                    $province = $farmProfile->personalInformation->province ?? 'N/A';
                    $country = $farmProfile->personalInformation->country ?? 'N/A';
                    $street = $farmProfile->personalInformation->street ?? 'N/A';
                    $zip_code = $farmProfile->personalInformation->zip_code ?? 'N/A';
                    $sex = $farmProfile->personalInformation->sex ?? 'N/A';
                    $religion = $farmProfile->personalInformation->religion ?? 'N/A';
                    $place_of_birth = $farmProfile->personalInformation->place_of_birth ?? 'N/A';
                    $contact_no = $farmProfile->personalInformation->contact_no ?? 'N/A';
                    $name_legal_spouse = $farmProfile->personalInformation->name_legal_spouse ?? 'N/A';
                    $no_of_children = $farmProfile->personalInformation->no_of_children ?? 'N/A';
                    $mothers_maiden_name = $farmProfile->personalInformation->mothers_maiden_name ?? 'N/A';
                    $highest_formal_education = $farmProfile->personalInformation->highest_formal_education ?? 'N/A';
                    $person_with_disability = $farmProfile->personalInformation->person_with_disability ?? 'N/A';
                    $pwd_id_no = $farmProfile->personalInformation->pwd_id_no ?? 'N/A';
                    $id_type = $farmProfile->personalInformation->id_type ?? 'N/A';
                    $gov_id_no = $farmProfile->personalInformation->gov_id_no ?? 'N/A';
                    $name_contact_person = $farmProfile->personalInformation->name_contact_person ?? 'N/A';
                    $cp_tel_no = $farmProfile->personalInformation->cp_tel_no ?? 'N/A';
                
                    $dateOfBirth = $farmProfile->personalInformation->date_of_birth ?? null;
                    $age = $dateOfBirth ? Carbon::now()->year - Carbon::parse($dateOfBirth)->year : 'N/A';
                
                    $gpsData[] = [
                        'gpsLatitude' => $farmProfile->gps_latitude ?? 'N/A',
                        'gpsLongitude' => $farmProfile->gps_longitude ?? 'N/A',
                        'FarmAddress' => $farmProfile->farm_address ?? 'N/A',
                        'NoYears' => $farmProfile->no_of_years_as_farmers ?? 0,
                        'totalPhysicalArea' => $farmProfile->total_physical_area ?? 0,
                        'TotalCultivated' => $farmProfile->total_area_cultivated ?? 0,
                        'tenurial_status' => $farmProfile->tenurial_status ?? 'N/A',
                        'area_prone_to' => $farmProfile->area_prone_to ?? 'N/A',
                        'ecosystem' => $farmProfile->ecosystem ?? 'N/A',
                        'rsba_registered' => $farmProfile->rsba_registered ?? 'N/A',
                        'pcic_insured' => $farmProfile->pcic_insured ?? 'N/A',
                        'government_assisted' => $farmProfile->government_assisted ?? 'N/A',
                        'source_of_capital' => $farmProfile->source_of_capital ?? 'N/A',
                
                        'cropName' => $cropNames,
                        'cropVariety' => $cropVariety,
                        'croppingperYear' => $croppingperYear,
                        'planting_schedule_wetseason' => $planting_schedule_wetseason,
                        'planting_schedule_dryseason' => $planting_schedule_dryseason,
                        'Yield' => $yield,
                
                        'farmerName' => $farmerName,
                        'civilStatus' => $civilStatus,
                        'orgName' => $orgName,
                        'homeAddress' => $homeAddress,
                        'landtitleNo' => $landtitleNo,
                        'lotNo' => $lotNo,
                        'age' => $age,
                
                        'country' => $country,
                        'province' => $province,
                        'street' => $street,
                        'zip_code' => $zip_code,
                        'sex' => $sex,
                        'religion' => $religion,
                        'mothers_maiden_name' => $mothers_maiden_name,
                        'place_of_birth' => $place_of_birth,
                        'contact_no' => $contact_no,
                        'name_legal_spouse' => $name_legal_spouse,
                        'no_of_children' => $no_of_children,
                        'highest_formal_education' => $highest_formal_education,
                        'person_with_disability' => $person_with_disability,
                        'pwd_id_no' => $pwd_id_no,
                        'gov_id_no' => $gov_id_no,
                        'id_type' => $id_type,
                        'name_contact_person' => $name_contact_person,
                        'cp_tel_no' => $cp_tel_no,
                    ];
                }
            }

               // Initialize an array to hold crop data
$cropYield = [];
$cropData = []; // Initialize cropData here to avoid undefined variable errors

// Loop through each farm profile to gather crop farm data
foreach ($farmProfiles as $farmProfile) {
    foreach ($farmProfile->cropFarms as $cropFarm) {
        $cropName = $cropFarm->crop_name; // Assuming there is a crop_name field
        $totalYield = $cropFarm->lastProductionDatas->sum('yield_tons_per_kg'); // Sum of yield per crop

        // Initialize crop data if not set
        if (!isset($cropData[$cropName])) {
            $cropData[$cropName] = 0;
        }
        
        // Accumulate total yield for the crop
        $cropData[$cropName] += $totalYield;
    }
}

// Format the data for Chart.js, handle empty cropData case
$formattedData = [
    'labels' => !empty($cropData) ? array_map('ucfirst', array_keys($cropData)) : ['No Data'],
    'data' => !empty($cropData) ? array_values($cropData) : [0],
];

// Initialize an array to hold the gross income per crop
$grossIncomeData = [];

// Loop through the farm profiles
foreach ($farmProfiles as $farmProfile) {
    foreach ($farmProfile->cropFarms as $cropFarm) {
        // Check for production sold data
        $productionSold = $cropFarm->productionSolds->sum('gross_income'); // Assuming 'gross_income' is the field

        // If there's no production sold data, fallback to last production data
        if ($productionSold > 0) {
            if (!isset($grossIncomeData[$cropFarm->crop_name])) {
                $grossIncomeData[$cropFarm->crop_name] = 0;
            }
            $grossIncomeData[$cropFarm->crop_name] += $productionSold; // Store the production sold income
        } else {
            // Calculate the total income from last production data
            $lastProductionIncome = $cropFarm->lastProductionDatas->sum(function($lastProductionData) {
                return $lastProductionData->gross_income_palay + $lastProductionData->gross_income_rice; // Sum income fields
            });

            if (!isset($grossIncomeData[$cropFarm->crop_name])) {
                $grossIncomeData[$cropFarm->crop_name] = 0;
            }
            $grossIncomeData[$cropFarm->crop_name] += $lastProductionIncome; // Store the last production income
        }
    }
}

// Prepare formatted data for the response, handle empty grossIncomeData case
$formattedIncomeData = [
    'labels' => !empty($grossIncomeData) ? array_keys($grossIncomeData) : ['No Data'],
    'data' => !empty($grossIncomeData) ? array_values($grossIncomeData) : [0],
];

// Prepare the data for the cropping chart
$croppingData = [];
foreach ($farmProfiles as $farmProfile) {
    foreach ($farmProfile->cropFarms as $cropFarm) {
        foreach ($cropFarm->lastProductionDatas as $productionData) {
            $noOfCropping = $productionData->cropping_no;
            $totalYieldKg = $productionData->yield_tons_per_kg; // Total yield in kg
            
            if (!isset($croppingData[$noOfCropping])) {
                $croppingData[$noOfCropping] = 0;
            }
            $croppingData[$noOfCropping] += $totalYieldKg; // Aggregate total yield
        }
    }
}

// Convert cropping data to a format suitable for Chart.js, handle empty croppingData case
$labels = !empty($croppingData) ? array_keys($croppingData) : ['No Data'];
$yields = !empty($croppingData) ? array_map(fn($kg) => $kg / 1000, array_values($croppingData)) : [0]; // Convert kg to tons

// Check if the request is AJAX
if (request()->ajax()) {
    return response()->json([
        'formattedData' => $formattedData,
        'formattedIncomeData' => $formattedIncomeData,
        'labels' => $labels,
        'yields' => $yields,
    ]);
}


            // Return the view with the fetched data (non-AJAX)
            return view('user.farmerInfo.profilingData', compact('user', 'gpsData', 'farmProfiles',));

        } else {
            // Handle the case where the user is not found
            return redirect()->route('login')->with('error', 'User not found.');
        }
    } else {
        // Handle the case where the user is not authenticated
        return redirect()->route('login');
    }
}
 
    
    public function agrimap(Request $request) {
        // Check if the user is authenticated
        if (Auth::check()) {
            // User is authenticated
            $userId = Auth::id();
            $user = User::find($userId);
            
            if ($user) {
                // Find the user's personal information by their ID
                $profile = PersonalInformations::where('users_id', $userId)->latest()->first();
                $polygons = Polygon::all();
                // Fetch all farm profiles
                // $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])->get();
                $farmProfiles = FarmProfile::with(['cropFarms', 'personalInformation'])
                ->where('users_id', $userId) // Filter based on user_id
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
                            'TenurialStatus' => $farmProfile->tenurial_status,
                            'TotalCultivated' => $farmProfile->total_area_cultivated,
                            
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
                        'user' => $user,
                        'profile' => $profile,
                        'farmProfiles' => $farmProfiles,
                        'totalRiceProduction' => $totalRiceProduction,
                        'gpsData' => $gpsData,
                        'polygons' => $polygonsData,
                        'districtsData' => $districtsData // Send all district GPS coordinates
                    ]);
                } else {
                    // Return the view with the fetched data for regular requests
                    return view('map.agrimap', [
                        'user' => $user,
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

  
   

  
    public function saveFarms(Request $request)
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
    
    
    //farm profile update data view
    public function EditFarmProfile(Request $request,$id)
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
                $personalinfos = PersonalInformations::find($id);
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
                return view('farm_profile.farm_edit', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                ,'farmprofiles','agri_districts','agri_districts_id','userId','personalinfos'
                
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
                
                $personalinfos= FarmProfile::find($id);

               
                $personalinfos->users_id = $request->users_id;
                $personalinfos->personal_informations_id = $request->personal_informations_id;
             
              
                $personalinfos->agri_districts = $request->agri_districts;
                $personalinfos->tenurial_status = $request->tenurial_status === 'Add' ? $request->add_newTenure : $request->tenurial_status;
                $personalinfos->farm_address = $request->farm_address;
                $personalinfos->no_of_years_as_farmers = $request->no_of_years_as_farmers === 'Add' ? $request->add_newFarmyears : $request->no_of_years_as_farmers;
                $personalinfos->gps_longitude = $request->gps_longitude;
                $personalinfos->gps_latitude = $request->gps_latitude;
                $personalinfos->total_physical_area = $request->total_physical_area;
                $personalinfos->total_area_cultivated = $request->total_area_cultivated;
                $personalinfos->land_title_no = $request->land_title_no;
                $personalinfos->lot_no = $request->lot_no;
                $personalinfos->area_prone_to = $request->area_prone_to === 'Add Prone' ? $request->add_newProneYear : $request->area_prone_to;
                $personalinfos->ecosystem = $request->ecosystem === 'Add ecosystem' ? $request->Add_Ecosystem : $request->ecosystem;
                // $personalinfos->type_rice_variety = $request->type_rice_variety;
                // $personalinfos->prefered_variety = $request->prefered_variety;
                // $personalinfos->plant_schedule_wetseason = $request->plant_schedule_wetseason;
                // $personalinfos->plant_schedule_dryseason = $request->plant_schedule_dryseason;
                // $personalinfos->no_of_cropping_yr = $request->no_of_cropping_yr === 'Adds' ? $request->add_cropyear : $request->no_of_cropping_yr;
                // $personalinfos->yield_kg_ha = $request->yield_kg_ha;
                $personalinfos->rsba_registered = $request->rsba_registered;
                $personalinfos->pcic_insured = $request->pcic_insured;
                $personalinfos->government_assisted = $request->government_assisted;
                $personalinfos->source_of_capital = $request->source_of_capital === 'Others' ? $request->add_sourceCapital : $request->source_of_capital;
                $personalinfos->remarks_recommendation = $request->remarks_recommendation;
                // $personalinfos->oca_district_office = $request->oca_district_office;
                $personalinfos->name_of_field_officer_technician = $request->name_of_field_officer_technician;
                $personalinfos->date_interviewed = $request->date_interviewed;

                // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('farmimage'), $imageName);
                $personalinfos->image = $imageName;
            }

                // dd($personalinfos);
                $personalinfos->save();     
                
                                       // Redirect back with success message
                                       return redirect()->route('admin.farmersdata.farm',  $personalinfos->personal_informations_id)
                                       ->with('message', 'Farm Data updated successfully');
        
                                 }catch(\Exception $ex){
                                 
                                             dd($ex); // Debugging statement to inspect the exception
                                             return redirect()->back()->with('message', 'Something went wrong');
                                             
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
                            // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                            if ($type === 'cropfarm') {
                                $cropfarm =Crop::find($id); // Find the fixed cost data by ID
                                if ($cropfarm) {
                                    return response()->json($cropfarm); // Return the data as JSON
                                } else {
                                    return response()->json(['error' => 'crop farm cost data not found.'], 404);
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
               
               return redirect()->route('admin.farmersdata.crop',  $data->farm_profiles_id)
               ->with('message', 'Crop Farm Data updated successfully');
   
                 }catch(\Exception $ex){
  
               dd($ex); // Debugging statement to inspect the exception
            return redirect()->back()->with('message', 'Something went wrong');
               
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


