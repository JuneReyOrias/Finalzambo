<?php

namespace App\Http\Controllers;

use App\Imports\CropImport;
use App\Imports\FixedsImport;
use App\Imports\ImportFertilizer;
use App\Imports\ImportLastProductionDatas;
use App\Imports\ImportMultipleFile;
use App\Imports\ImportPesticide;
use App\Imports\ImportSeed;
use App\Imports\ImportTransport;
use App\Imports\ImportVariableCost;
use App\Imports\PersonalinfoImport;
use App\Imports\FarmImport;
use App\Imports\PersonalInformationsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\PersonalInformations;
use App\Models\FarmProfile;
use App\Models\User;
use App\Models\LastProductionDatas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Imports\CombineImport; // Import the CombinedImport class if needed
use App\Imports\ImportFixedCost;
use App\Imports\ImportLabor;
use App\Imports\MachinesImport;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Exports\MultipleSheetsExport;
use App\Imports\SoldsImport;

class FileController extends Controller
{

    public function downloadTemplate()
    {
        return Excel::download(new MultipleSheetsExport, 'data_import_template.xlsx');
    }


            public function  MultiFiles()
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

            

                    
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    // Return the view with the fetched data
                    return view('multifile.import', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                    
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

    public function  MultiFilesAgent()
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
    
          
    
                
                $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                // Return the view with the fetched data
                return view('multifile.import_agent', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                
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
// public function saveUploadForm(Request $request)
// {

   
//         $request->validate([
//             'upload_file' => 'nullable|mimes:xlsx,xls,csv',
//         ]);
    
//         $uploadFile = $request->file('upload_file');
    
//         try {
//             // Load the data from the Excel file
//             $import = new ImportMultipleFile();
//             $importedRows = Excel::import($import, $uploadFile);
    
//             // Check if any rows were inserted into the database
//             if ($importedRows > 0) {
//                 return back()->withStatus('File Imported Successfully');
//             } else {
//                 return back()->withError('No data inserted into the database.');
//             }
//         } catch (\Exception $e) {
//             dd($e); // Debugging statement to inspect the exception
//             return back()->withError('Error importing file: ' . $e->getMessage());
//         }
// }

public function saveUploadForm(Request $request)
{
  // Validate the file input
  $request->validate([
    'upload_file' => 'required|file|mimes:xlsx,xls',
]);

// $uploadFile = $request->file('upload_file');

try {
    $userId = Auth::id();
    $user = auth()->user();
    $agri_districts_id = $user->agri_districts_id;
    $agri_district = $user->agri_district;

    // Import data for PersonalInformations
    $personalInformationImport = new PersonalInfoImport();
    $personalInformations = Excel::toCollection($personalInformationImport, $request->file('upload_file'))->first();

// Check if the uploaded file is empty
if ($personalInformations->isEmpty()) {
return back()->withError("Error: The Excel file is empty. Please upload a file with data.");
}

foreach ($personalInformations as $personalInformation) {
// Define an array of required fields
$requiredFields = ['first name', 'last name', 'middle name', 'extension name', 'home address', 'sex', 'religion', 'date of birth', 'place of birth', 'contact no', 'civil_status', 'name legal spouse', 'no of children', 'mothers  maiden name', 'highest formal education', 'person with disability', 'pwd id no', 'government_issued_id', 'id_type', 'gov id no', 'member of any farmers ass org coop', 'name of farmers ass  org coop', 'name contact person', 'cp tel no'];

// Check if any required field is empty or null
foreach ($requiredFields as $field) {
    if (empty($personalInformation[$field])) {
        return back()->withError("Error: The $field field cannot be empty.");
    }
}
// Validate personal information fields
$personalInformationValidator = Validator::make($personalInformation->toArray(), [
'first_name' => 'required|string|max:255',
'middle_name' => 'required|string|max:255',
'last_name' => 'required|string|max:255',
'extension_name' => 'nullable|string|max:50',
'home_address' => 'required|string|max:500',
'sex' => 'required|string|in:male,female,other',
'religion' => 'required|string|max:100',
'date_of_birth' => 'required|date',
'place_of_birth' => 'required|string|max:255',
'contact_no' => 'required|numeric',
'civil_status' => 'required|string',
'name_legal_spouse' => 'nullable|string|max:255',
'no_of_children' => 'nullable|integer|min:0',
'mothers_maiden_name' => 'required|string|max:255',
'highest_formal_education' => 'required|string|max:100',
'person_with_disability' => 'nullable|boolean',
'pwd_id_no' => 'nullable_if:person_with_disability,true|string|max:50',
'government_issued_id' => 'nullable|string|max:50',
'id_type' => 'nullable|string|max:50',
'gov_id_no' => 'nullable|string|max:50',
'member_ofany_farmers_ass_org_coop' => 'nullable|boolean',
'nameof_farmers_ass_org_coop' => 'nullable_if:member_ofany_farmers_ass_org_coop,true|string|max:255',
'name_contact_person' => 'nullable|string|max:255',
'cp_tel_no' => 'nullable|numeric',
'date_interview' => 'required|date'
])->after(function ($validator) use ($personalInformation) {
// Check for duplicate record based on specific fields
$exists = PersonalInformations::where('first_name', $personalInformation->first_name)
    ->where('last_name', $personalInformation->last_name)
    ->where('mothers_maiden_name', $personalInformation->mothers_maiden_name)
    // ->where('date_of_birth', $personalInformation->date_of_birth)
    ->exists();

if ($exists) {
    $validator->errors()->add('duplicate', 'A record with the same personal information already exists.');
}
});

if ($personalInformationValidator->fails()) {
// Get the error messages
$errors = $personalInformationValidator->errors()->all();
// Redirect back with error messages
return back()->withError('Error: Personal information validation failed')->withErrors($errors);
}

        
        $personalInformationModel = new PersonalInformations([
            'users_id' => $userId,
            'agri_districts_id' => $agri_districts_id,
            'agri_district' => $agri_district,
            'first_name' => $personalInformation['first_name'],
            'middle_name' => $personalInformation['middle_name'],
            'last_name' => $personalInformation['last_name'],
            'extension_name' => $personalInformation['extension_name'],
            'home_address' => $personalInformation['home_address'],
            'sex' => $personalInformation['sex'],
            'religion' => $personalInformation['religion'],
            'date_of_birth' => $personalInformation['date_of_birth'],
            'place_of_birth' => $personalInformation['place_of_birth'],
            'contact_no' => $personalInformation['contact_no'],
            'civil_status' => $personalInformation['civil_status'],
            'name_legal_spouse' => $personalInformation['name_legal_spouse'],
            'no_of_children' => $personalInformation['no_of_children'],
            'mothers_maiden_name' => $personalInformation['mothers_maiden_name'],
            'highest_formal_education' => $personalInformation['highest_formal_education'],
            'person_with_disability' => $personalInformation['person_with_disability'],
            'pwd_id_no' => $personalInformation['pwd_id_no'],
            'government_issued_id' => $personalInformation['government_issued_id'],
            'id_type' => $personalInformation['id_type'],
            'gov_id_no' => $personalInformation['gov_id_no'],
            'member_ofany_farmers_ass_org_coop' => $personalInformation['member_ofany_farmers_ass_org_coop'],
            'nameof_farmers_ass_org_coop' => $personalInformation['nameof_farmers_ass_org_coop'],
            'name_contact_person' => $personalInformation['name_contact_person'],
            'cp_tel_no' => $personalInformation['cp_tel_no'],
         'date_interview' => Carbon::parse($personalInformation['date_interview'])->format('Y-m-d'),
            // Add other fields as needed
        ]);

        $personalInformationModel->save();

        if ($personalInformationModel->id) {
            // Import farm profile and retrieve the primary ID
            $farmProfileImport = new FarmImport($personalInformationModel->id);
            Excel::import($farmProfileImport, $request->file('upload_file'));
            $farmModel = $farmProfileImport->getFarmModel();

            // Check if farm model exists
            if ($farmModel && $farmModel->id) {
                  // crops import
                  $CropImport = new CropImport($personalInformationModel->id, $farmModel->id);
                  Excel::import($CropImport, $request->file('upload_file'));
                  $CropId = $CropImport->getCropId();
                  // Import last production data
                  $lastproductionImport = new ImportLastProductionDatas($personalInformationModel->id, $farmModel->id,  $CropId);
                  Excel::import($lastproductionImport, $request->file('upload_file'));
                  $ProductionId = $lastproductionImport->getProductionId();

                  // Import fixed cost and machines data, variable cost
                  $fixedCostImport = new FixedsImport($personalInformationModel->id, $farmModel->id,  $CropId, $ProductionId);
                  $machinesImport = new MachinesImport($personalInformationModel->id, $farmModel->id,  $CropId,  $ProductionId);
                  Excel::import($fixedCostImport, $request->file('upload_file'));
                  Excel::import($machinesImport, $request->file('upload_file'));
                  $variableImport = new ImportVariableCost($personalInformationModel->id, $farmModel->id,$CropId, $ProductionId);
                  Excel::import($variableImport, $request->file('upload_file'));
            } else {
                // Handle error if farm profile ID is not retrieved
                return back()->withError('Error: Failed to save farm profile record');
            }
        } else {
            // Display an error message if the primary key is null
            return back()->withError('Error: Failed to save personal information record');
        }
    }
    return back()->withStatus('Data Imported Successfully');
} catch (\Exception $e) {
    // dd($e); // Debugging statement to inspect the exception
    return back()->withError('Error importing data: ' . $e->getMessage());
}
}

public function AgentsaveUploadForm(Request $request)
{
    // Validate the file input
    $request->validate([
        'upload_file' => 'required|file|mimes:xlsx,xls',
    ]);

    try {
        $userId = Auth::id();
        $user = auth()->user();
        $agri_districts_id = $user->agri_districts_id;
        $agri_district = $user->district;

        // Import data for PersonalInformations
        $personalInformationImport = new PersonalInfoImport();
        $personalInformations = Excel::toCollection($personalInformationImport, $request->file('upload_file'))->first();

        // Check if the uploaded file is empty
        if ($personalInformations->isEmpty()) {
            return back()->withError("Error: The Excel file is empty. Please upload a file with data.");
        }

        foreach ($personalInformations as $personalInformation) {
            // Convert to array for direct access
            $personalInformationArray = $personalInformation->toArray();

            // Validate required fields
            $requiredFields = ['first_name', 'last_name', 'home_address', 'sex', 'religion', 'date_of_birth', 'mothers_maiden_name'];
            foreach ($requiredFields as $field) {
                if (empty($personalInformationArray[$field])) {
                    return back()->withError("Error: The $field field cannot be empty.");
                }
            }

            // Validate fields and check for duplicates
            $personalInformationValidator = Validator::make($personalInformationArray, [
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name'=> 'required',
                'extension_name'=> 'nullable',
                'home_address'=> 'required',
                'sex'=> 'required',
                'religion'=> 'required',
                'date_of_birth'=> 'required',
                'place_of_birth'=> 'nullable',
                'contact_no'=> 'nullable',
                'civil_status'=> 'nullable',
                'name_legal_spouse'=> 'nullable',
                'no_of_children'=> 'nullable',
                'mothers_maiden_name' => 'nullable',
                'highest_formal_education' => 'nullable',
                'person_with_disability' => 'nullable',
                'pwd_id_no' => 'nullable',
                'government_issued_id' => 'nullable',
                'id_type' => 'nullable',
                'gov_id_no' => 'nullable',
                'member_ofany_farmers_ass_org_coop' => 'nullable',
                'nameof_farmers_ass_org_coop' => 'nullable',
                'date_interview'=>'required',
            ])->after(function ($validator) use ($personalInformationArray) {
                // Check for duplicates
                $exists = PersonalInformations::where('first_name', $personalInformationArray['first_name'])
                    ->where('last_name', $personalInformationArray['last_name'])
                    ->where('mothers_maiden_name', $personalInformationArray['mothers_maiden_name'])
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('duplicate', 'A record with the same personal information already exists.');
                }
            });

            if ($personalInformationValidator->fails()) {
                $errors = $personalInformationValidator->errors()->all();
                return back()->withError('Error: Personal information validation failed')->withErrors($errors);
            }

            // Create personal information record
            $personalInformationModel = PersonalInformations::firstOrCreate([
                'users_id' => $userId,
              
                'agri_district' => $agri_district,
                'first_name' => $personalInformationArray['first_name'],
                'middle_name' => $personalInformationArray['middle_name'] ?? null,
                'last_name' => $personalInformationArray['last_name'],
                'extension_name' => $personalInformationArray['extension_name'] ?? null,
                'home_address' => $personalInformationArray['home_address'],
                'sex' => $personalInformationArray['sex'],
                'religion' => $personalInformationArray['religion'],
               
                'date_of_birth' => Carbon::parse($personalInformationArray['date_of_birth'])->format('Y-m-d'),
                'place_of_birth' => $personalInformationArray['place_of_birth'],
                'contact_no' => $personalInformationArray['contact_no'],
                'civil_status' => $personalInformationArray['civil_status'],
                'name_legal_spouse' => $personalInformationArray['name_legal_spouse'] ?? null,
                'no_of_children' => $personalInformationArray['no_of_children'],
                'mothers_maiden_name' => $personalInformationArray['mothers_maiden_name'],
                'highest_formal_education' => $personalInformationArray['highest_formal_education'],
                'person_with_disability' => $personalInformationArray['person_with_disability'],
                'pwd_id_no' => $personalInformationArray['pwd_id_no'] ?? null,
                'government_issued_id' => $personalInformationArray['government_issued_id'],
                'id_type' => $personalInformationArray['id_type'],
                'gov_id_no' => $personalInformationArray['gov_id_no'],
                'member_ofany_farmers_ass_org_coop' => $personalInformationArray['member_ofany_farmers_ass_org_coop'],
                'nameof_farmers_ass_org_coop' => $personalInformationArray['nameof_farmers_ass_org_coop'] ?? null,
                'name_contact_person' => $personalInformationArray['name_contact_person'] ?? null,
                'cp_tel_no' => $personalInformationArray['cp_tel_no'] ?? null,
                'date_interview' => Carbon::parse($personalInformationArray['date_interview'])->format('Y-m-d'),
            ]);
            // dd($personalInformationModel);
            $personalInformationModel->save();
            // Import related data for each personal information record
            if ($personalInformationModel->exists) {
                $farmProfileImport = new FarmImport($personalInformationModel->id);
                Excel::import($farmProfileImport, $request->file('upload_file'));
                $farmModel = $farmProfileImport->getFarmModel();

                if ($farmModel && $farmModel->exists) {
                    $CropImport = new CropImport($personalInformationModel->id, $farmModel->id);
                    Excel::import($CropImport, $request->file('upload_file'));
                    $CropId = $CropImport->getCropId();

                    $lastProductionImport = new ImportLastProductionDatas($personalInformationModel->id, $farmModel->id, $CropId);
                    Excel::import($lastProductionImport, $request->file('upload_file'));
                    $ProductionId = $lastProductionImport->getProductionId();

                    
                    Excel::import(new SoldsImport($personalInformationModel->id, $farmModel->id, $CropId, $ProductionId), $request->file('upload_file'));
                    Excel::import(new FixedsImport($personalInformationModel->id, $farmModel->id, $CropId, $ProductionId), $request->file('upload_file'));
                    Excel::import(new MachinesImport($personalInformationModel->id, $farmModel->id, $CropId, $ProductionId), $request->file('upload_file'));
                    Excel::import(new ImportVariableCost($personalInformationModel->id, $farmModel->id, $CropId, $ProductionId), $request->file('upload_file'));
                } else {
                    return back()->withError('Error: Failed to save farm profile record');
                }
            } else {
                return back()->withError('Error: Failed to save personal information record');
            }
        }

        return back()->withStatus('Data Imported Successfully');
    } catch (\Exception $e) {
        
        return back()->withError('Error importing data: ' . $e->getMessage());
    }
}

}
