<?php

namespace App\Http\Controllers\Backend;
use App\Models\FarmerOrg;
use App\Models\FixedCost;
use App\Models\FixedCostArchive;
use App\Models\LastProductionDatas;
use App\Models\MachineriesCostArchive;
use App\Models\MachineriesUseds;
use App\Models\ProductionCrop;
use App\Models\ProductionSold;
use App\Models\ProductionArchive;
use App\Models\Barangay;
use App\Models\CropCategory;
use App\Models\Categorize;
use App\Models\PersonalInformations;
use App\Models\VariableCost; 
use App\Models\PersonalInformationArchive;
use App\Models\VariableCostArchive;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\MultipleFile;
use App\Models\ParcellaryBoundaries;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalInformationsRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Models\Crop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Strings;
use App\Models\KmlFile;
use App\Models\User;
use App\Models\AgriDistrict;
use App\Models\FarmProfile;
use App\Models\Seed;
use App\Models\Polygon;
use App\Models\CropParcel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
class PersonalInformationsController extends Controller
{

protected $personalInformations;
public function __construct() {
    $this->personalInformations = new PersonalInformations;

}

// check cropping no
public function checkCroppingNo(Request $request)
{
    // Validate that cropping_no is provided
    $request->validate([
        'cropping_no' => 'required|numeric',
    ]);

  // Check if the cropping_no already exists for the given crops_farms_id
  // Check if the cropping_no already exists for the given crops_farms_id
  $existingCroppingNo = LastProductionDatas::where('crops_farms_id', $request->crops_farms_id)
  ->where('cropping_no', $request->cropping_no)
  ->first();

if ($existingCroppingNo) {
return response()->json([
    'success' => false,
    'message' => 'The cropping number already exists for this crop farm. Please choose a different one.'
]);
}

   
}

// join table for farmprfofiles


   
    public function Gmap()
    {
     $personalInformations= PersonalInformations::all();
     $parcels= ParcellaryBoundaries::all();
   
        // Fetch the latest uploaded KML file from the database
      

       
    

     return view('map.gmap',compact('personalInformations','parcels','kmlFile'));
    }




    public function Agent(): View
    {
        $personalInformation= PersonalInformations::all();
    return view('personalinfo.index_agent',compact('personalInformation'));
    }
   


    //agent form personal info form
    public function PersonalInfoCrudAgent():View{
        $personalInformations= PersonalInformations::latest()->get();
        return view('personalinfo.show_agent',compact('personalInformations'));
    }
   


 

        // view the personalinfo by admin
        public function PersonalInfoView(Request $request)
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
                    return view('personalinfo.create', compact('admin', 'profile', 'personalinfos','farmProfiles','fixedcosts','machineries','variable','productions','totalRiceProduction'));
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
        
        // edit page for admin
        public function  PersonalInfoEdit(Request $request,$id)
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
                    $personalinfos= PersonalInformations::find($id);
               // Handle AJAX requests
               if ($request->ajax()) {
                // Get the request type
                $type = $request->input('type');
        
                // Handle the 'personalinfos' request type
                if ($type === 'personalinfos') {
                    // Find the PersonalInformation data by ID
                    $personalinfos = PersonalInformations::find($id); 
        
                    if ($personalinfos) {
                        return response()->json($personalinfos); // Return the data as JSON
                    } else {
                        return response()->json(['error' => 'Personal information not found.'], 404);
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



        
                // Handle the 'districts' request type
                if ($type === 'districts') {
                    $districts = AgriDistrict::pluck('district', 'district'); // Fetch agri-district names
                    return response()->json($districts);
                }
        
                // Handle the 'barangays' request type
                if ($type === 'barangays') {
                    $district = $request->input('district');
                    if (!$district) {
                        return response()->json(['error' => 'District is required.'], 400);
                    }
                    $barangays = Barangay::where('district', $district)->pluck('barangay_name', 'barangay_name');
                    return response()->json($barangays);
                }
        
                // Handle the 'organizations' request type
                if ($type === 'organizations') {
                    $district = $request->input('district');
                    if (!$district) {
                        return response()->json(['error' => 'District is required.'], 400);
                    }
                    $organizations = FarmerOrg::where('district', $district)->pluck('organization_name', 'organization_name');
                    return response()->json($organizations);
                }
        
                // Handle the 'crops' request type
                if ($type === 'crops') {
                    $crops = CropCategory::pluck('crop_name', 'crop_name');
                    return response()->json($crops);
                }
        
                // Handle the 'varieties' request type
                if ($type === 'varieties') {
                    $cropName = $request->input('crop_name');
                    if (!$cropName) {
                        return response()->json(['error' => 'Crop name is required.'], 400);
                    }
                    $varieties = Categorize::where('crop_name', $cropName)->pluck('variety_name', 'variety_name');
                    return response()->json($varieties);
                }
        
                // Handle the 'seedname' request type
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
                    return view('personalinfo.edit_info', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
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
 
        public function PersonalInfoUpdate(Request $request, $id)
        {
            try {
                // Validate the request data
                $request->validate([
                    'users_id' => 'nullable|integer',
                    'first_name' => 'required|string|max:255',
                    'middle_name' => 'nullable|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'extension_name' => 'nullable|string|max:255',
                   
                    'city' => 'nullable|string|max:255',
                    'district' => 'nullable|string|max:255',
                    'barangay' => 'nullable|string|max:255',
                    'home_address' => 'nullable|string|max:255',
                    'sex' => 'nullable|string|max:10',
                    'religion' => 'nullable|string|max:255',
                    'date_of_birth' => 'nullable|date',
                    'place_of_birth' => 'nullable|string|max:255',
                    'contact_no' => 'nullable|string|max:20',
                    'civil_status' => 'nullable|string|max:20',
                    'name_legal_spouse' => 'nullable|string|max:255',
                    'no_of_children' => 'nullable|integer|min:0',
                    'mothers_maiden_name' => 'nullable|string|max:255',
                    'highest_formal_education' => 'nullable|string|max:255',
                    'person_with_disability' => 'nullable|string|max:10',
                    'pwd_id_no' => 'nullable|string|max:50',
                    'government_issued_id' => 'nullable|string|max:255',
                    'id_type' => 'nullable|string|max:50',
                    'gov_id_no' => 'nullable|string|max:255',
                    'member_ofany_farmers_ass_org_coop' => 'nullable|string|max:255',
                    'nameof_farmers_ass_org_coop' => 'nullable|string|max:255',
                    'name_contact_person' => 'nullable|string|max:255',
                    'cp_tel_no' => 'nullable|string|max:20',
                    'date_interview' => 'nullable|date',
                    'image' => 'nullable|image|max:2048',
                ]);
        
                // Step 1: Find or fail
                $data = PersonalInformations::findOrFail($id);
        
                // Step 2: Archive existing data
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
        
                // Step 3: Handle image upload
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $imagename = time() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->storeAs('personalInfoimages', $imagename, 'public');
                    $data->image = $imagename;
                }
        
                // Step 4: Update personal information
                $data->update([
                    'users_id' => $request->users_id,
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'extension_name' => $request->extension_name === 'others' ? $request->add_extName : $request->extension_name,
                    'country' => $request->country,
                    'province' => $request->province,
                    'city' => $request->city,
                    'district' => $request->district,
                    'barangay' => $request->barangay,
                    'home_address' => $request->home_address,
                    'sex' => $request->sex,
                    'religion' => $request->religion === 'other' ? $request->add_Religion : $request->religion,
                    'date_of_birth' => $request->date_of_birth,
                    'place_of_birth' => $request->place_of_birth === 'Add Place of Birth' ? $request->add_PlaceBirth : $request->place_of_birth,
                    'contact_no' => $request->contact_no,
                    'civil_status' => $request->civil_status,
                    'name_legal_spouse' => $request->name_legal_spouse,
                    'no_of_children' => $request->no_of_children === 'Add' ? $request->add_noChildren : $request->no_of_children,
                    'mothers_maiden_name' => $request->mothers_maiden_name,
                    'highest_formal_education' => $request->highest_formal_education === 'Other' ? $request->add_formEduc : $request->highest_formal_education,
                    'person_with_disability' => $request->person_with_disability,
                    'pwd_id_no' => $request->pwd_id_no,
                    'government_issued_id' => $request->government_issued_id,
                    'id_type' => $request->id_type,
                    'gov_id_no' => $request->gov_id_no,
                    'member_ofany_farmers_ass_org_coop' => $request->member_ofany_farmers_ass_org_coop,
                    'nameof_farmers_ass_org_coop' => $request->nameof_farmers_ass_org_coop === 'add' ? $request->add_FarmersGroup : $request->nameof_farmers_ass_org_coop,
                    'name_contact_person' => $request->name_contact_person,
                    'cp_tel_no' => $request->cp_tel_no,
                    'date_interview' => $request->date_interview,
                ]);
        
                // Step 5: Success response
                return redirect()->route('admin.farmersdata.genfarmers')
                    ->with('message', 'Personal information updated successfully');
        
            } catch (\Exception $ex) {
                // Log error for debugging
            dd($ex);
        
                // Error response
                return redirect()->route('personalinfo.edit_info', ['personalinfos' => $id])
                    ->with('message', 'Something went wrong: ' . $ex->getMessage());
            }
        }
        
            // deleting personal info by admin
            public function DeletePersonalInfo($id) {
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


    

// all farmers data view ny the users 
public function forms() {

    try { 

    $allfarmers = DB::table('personal_informations')
    ->leftJoin('farm_profiles', 'farm_profiles.id', '=', 'personal_informations.id')
    ->leftJoin('fixed_costs', 'fixed_costs.id', '=', 'personal_informations.id')
    ->leftJoin('machineries_useds', 'machineries_useds.id', '=', 'personal_informations.id')
    ->leftJoin('seeds', 'seeds.id', '=', 'personal_informations.id')
    ->leftJoin('fertilizers', 'fertilizers.id', '=', 'personal_informations.id')
    ->leftJoin('labors', 'labors.id', '=', 'personal_informations.id')
    ->leftJoin('pesticides', 'pesticides.id', '=', 'personal_informations.id')
    ->leftJoin('transports', 'transports.id', '=', 'personal_informations.id')
    ->leftJoin('variable_costs', 'variable_costs.id', '=', 'personal_informations.id')
    ->leftJoin('last_production_datas', 'last_production_datas.id', '=', 'personal_informations.id')
    ->select(
        'personal_informations.*',
        'farm_profiles.*',
        'fixed_costs.*',
        'machineries_useds.*', // Select all columns from machineries_useds
        'seeds.*',
        'fertilizers.*',
        'labors.*',
        'pesticides.*',
        'transports.*',
        'variable_costs.*',
        'last_production_datas.*', 
        )->paginate(10)
;
  
    return view('user.forms_data',compact('allfarmers'));
} catch (\Exception $ex) {
    // Log the exception for debugging purposes
    dd($ex);
    return redirect()->back()->with('message', 'Something went wrong');
}



}

// viewing the all farmers in farm profile
public function profileFarmer($id) {
   
            try { 
        
            $allfarmers =PersonalInformations:: find($id)
            ->leftJoin('farm_profiles', 'farm_profiles.id', '=', 'personal_informations.id')
            ->leftJoin('fixed_costs', 'fixed_costs.id', '=', 'personal_informations.id')
            ->leftJoin('machineries_useds', 'machineries_useds.id', '=', 'personal_informations.id')
            ->leftJoin('seeds', 'seeds.id', '=', 'personal_informations.id')
            ->leftJoin('fertilizers', 'fertilizers.id', '=', 'personal_informations.id')
            ->leftJoin('labors', 'labors.id', '=', 'personal_informations.id')
            ->leftJoin('pesticides', 'pesticides.id', '=', 'personal_informations.id')
            ->leftJoin('transports', 'transports.id', '=', 'personal_informations.id')
            ->leftJoin('variable_costs', 'variable_costs.id', '=', 'personal_informations.id')
            ->leftJoin('last_production_datas', 'last_production_datas.id', '=', 'personal_informations.id')
           
            ->select(
                'personal_informations.*',
                'farm_profiles.*',
                'fixed_costs.*',
                'machineries_useds.*', // Select all columns from machineries_useds
                'seeds.*',
                'fertilizers.*',
                'labors.*',
                'pesticides.*',
                'transports.*',
                'variable_costs.*',
                'last_production_datas.*', 
                ) ->first();
          
            return view('agent.allfarmersinfo.profile',compact('allfarmers'));
        } catch (\Exception $ex) {
            // Log the exception for debugging purposes
            dd($ex);
            return redirect()->back()->with('message', 'Something went wrong');
        }
    
    
    
    }


// admin farmers data display
public function FarmersInfo() {

    try { 

    $allfarmers = DB::table('personal_informations')
    ->leftJoin('farm_profiles', 'farm_profiles.id', '=', 'personal_informations.id')
    ->leftJoin('fixed_costs', 'fixed_costs.id', '=', 'personal_informations.id')
    ->leftJoin('machineries_useds', 'machineries_useds.id', '=', 'personal_informations.id')
    ->leftJoin('seeds', 'seeds.id', '=', 'personal_informations.id')
    ->leftJoin('fertilizers', 'fertilizers.id', '=', 'personal_informations.id')
    ->leftJoin('labors', 'labors.id', '=', 'personal_informations.id')
    ->leftJoin('pesticides', 'pesticides.id', '=', 'personal_informations.id')
    ->leftJoin('transports', 'transports.id', '=', 'personal_informations.id')
    ->leftJoin('variable_costs', 'variable_costs.id', '=', 'personal_informations.id')
    ->leftJoin('last_production_datas', 'last_production_datas.id', '=', 'personal_informations.id')
    ->select(
        'personal_informations.*',
        'farm_profiles.*',
        'fixed_costs.*',
        'machineries_useds.*', // Select all columns from machineries_useds
        'seeds.*',
        'fertilizers.*',
        'labors.*',
        'pesticides.*',
        'transports.*',
        'variable_costs.*',
        'last_production_datas.*', 
        )->paginate(10)
;
  
    return view('admin.allfarmersdata.farmers_info',compact('allfarmers'));
} catch (\Exception $ex) {
    // Log the exception for debugging purposes
    // dd($ex);
    return redirect()->back()->with('message', 'Something went wrong');
}



}



public function farmview($id)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // Retrieve the authenticated user ID
        $userId = Auth::id();

        // Find the user based on the retrieved ID
        $admin = User::find($userId);

        if ($admin) {
            // Retrieve the user's personal information
            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

            // Fetch the user's farm ID and agricultural district information
            $farmId = $admin->farm_id;
            $agri_district = $admin->agri_district;
            $agri_districts_id = $admin->agri_districts_id;

     
                                // Get the currently logged-in user
                        $loggedInUser = auth()->user();

                        // Check if the logged-in user is an admin
                        if ($loggedInUser->role === 'admin') {
                            // Admin can view all users
                            $users = User::where('role', 'user')
                                        ->select('id', 'first_name', 'last_name')
                                        ->get();
                        } elseif ($loggedInUser->role === 'agent') {
                            // For agents, get users within the same district
                            $agentDistrict = $loggedInUser->district;

                            // Fetch users with role 'user' who belong to the same district
                            $users = User::where('role', 'user')
                                        ->where('district', $agentDistrict)
                                        ->select('id', 'first_name', 'last_name')
                                        ->get();
                        } else {
                            // Handle other roles or set $users as an empty collection if needed
                            $users = collect();
                        }


            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
            $farmData = FarmProfile::with('personalInformation')
            ->where('personal_informations_id', $id)
            ->paginate(5);
            // Fetch farmer's personal information based on the provided ID
            $personalinfos = PersonalInformations::find($id);

            // // Fetch farm data based on the farmer's ID
            // // Use the correct relationship name 'personalInformation' instead of 'personalinfo'
            // $farmData = FarmProfile::with('personalInformation')->where('personal_informations_id', $id)->get()
            // ->unique('personal_informations_id'); // Ensure unique by personal_informations_id
 

            // Calculate total rice production
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

            // Return the view with the fetched data
            return view('admin.farmersdata.farm', compact(
                'admin', 'profile', 'farmProfile', 'totalRiceProduction',
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



public function  cropview(Request $request, $id)
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

                                // Get the currently logged-in user
                                $loggedInUser = auth()->user();

                                // Check if the logged-in user is an admin
                                if ($loggedInUser->role === 'admin') {
                                    // Admin can view all users
                                    $users = User::where('role', 'agent')
                                                ->select('id', 'first_name', 'last_name', 'district')
                                                ->get();
                                } elseif ($loggedInUser->role === 'agent') {
                                    // For agents, get users within the same district
                                    $agentDistrict = $loggedInUser->district;
        
                                    // Fetch users with role 'user' who belong to the same district
                                    $users = User::where('role', 'user')
                                                ->where('district', $agentDistrict)
                                                ->select('id', 'first_name', 'last_name')
                                                ->get();
                                } else {
                                    // Handle other roles or set $users as an empty collection if needed
                                    $users = collect();
                                }
                    // Find the farm profile using the fetched farm ID
                    $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

                // Fetch farmer's information based on ID
                $farmData = FarmProfile::find($id);
                 // Fetch CropFarms related to the given ID and get the FarmProfiles
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
            return view('admin.farmersdata.crop', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
            ,'farmData','userId','agri_district','agri_districts_id','cropData','id','personalInfos', 'cropFarms','users'
            
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

// Retrieves production data from the database and passes it to the template for displaying the fetched data on the frontend.
// CUR (Create, Update, Read) functionality for managing production data:
// - Create: Adds new production records (e.g., yield, harvest details) to the database.
// - Update: Modifies existing production data to reflect updated yield or crop details.
// - Read: Retrieves and displays production data from the database based on selected criteria for analysis or reporting.

public function productionview (Request $request, $id)
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
            return view('admin.farmersdata.production', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
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

// add 
  
public function productionAdd(Request $request,$id)
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
            return view('admin.farmersdata.crudProduction.add', compact('agri_district', 'agri_districts_id', 'admin', 'profile',
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

    // store new production

    public function productionSave(Request $request)
    {
   
        try {

          
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
            $salesModel->last_production_datas_id = $productionId;
            $salesModel->crops_farms_id = $crop_id; // Assuming $cropsId is set earlier in the code
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
             return response()->json(['success' => 'Data saved successfully!']);

            } catch (\Exception $e) {
                // Catch any errors during the save process
                return response()->json(['error' => 'Failed to save data: ' . $e->getMessage()], 500);
            }
         }  
        

        //  update
         public function productionEdit(Request $request,$id)
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
                   $cropData = Crop::find($id);
                   $production = LastProductionDatas::with('cropFarm')->find($id);
           

                           // Handle AJAX requests
                           if ($request->ajax()) {
                           $type = $request->input('type');
                           if ($type === 'production') {
                             $production =LastProductionDatas::with('cropFarm')->find($id); // Find the fixed cost data by ID
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
                     return view('admin.farmersdata.crudProduction.edit', compact('agri_district', 'agri_districts_id', 'admin', 'profile',
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

         public function productionUpdate(Request $request,$id)
         {
         
             try{
                 
     
                 // $data= $request->validated();
                 // $data= $request->all();
                 
                 $data= LastProductionDatas::find($id);
                 if (!$data) {
                    return redirect()->route('admin.farmersdata.production', $id)
                        ->with('message', 'Production not found');
                }
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
             return redirect()->route('admin.farmersdata.production', $data->crops_farms_id)
             ->with('message', 'Production Data updated successfully');
         } catch (\Exception $ex) {
             // Handle the exception and provide error feedback
             return redirect()->back()->with('message', 'Something went wrong');
         }  
         } 
  
        //  delete
         public function productiondelete($id) {
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
    

  // CRUD operations for managing fixed cost data related to production:
// - Create: Adds new fixed cost records (e.g., equipment, rent, utilities) to the database.
// - Read: Retrieves and displays fixed cost data for analysis or financial reporting.
// - Update: Modifies existing fixed cost records based on updated cost details or changes in expenses.
// - Delete: Removes fixed cost data from the database when no longer required or applicable.

        public function fixedAdd(Request $request,$id)
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
                    return view('admin.farmersdata.CrudFixed.add', compact('agri_district', 'agri_districts_id', 'admin', 'profile',
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
        // store data
        public function fixedSave(Request $request)
        {
       
          
              
     
                
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
           

                //     $crop_id=  $fixedcostModel ->crops_farms_id ;
                //    $machineries=$request->machineries;
                //    // machineries
                //      $machineriesModel = new MachineriesUseds();
                //   //    $machineriesModel -> users_id = $users_id;
                //   //    $machineriesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                //      $machineriesModel -> crops_farms_id = $crop_id;
     
                //      $machineriesModel-> plowing_machineries_used = $machineries['plowing-machine'];
                //      $machineriesModel -> plo_ownership_status = $machineries['plow_status'];
                   
                //      $machineriesModel -> no_of_plowing = $machineries['no_of_plowing'];
                //      $machineriesModel -> plowing_cost = $machineries['cost_per_plowing'];
                //      $machineriesModel -> plowing_cost_total = $machineries['plowing_cost'];

                //      $machineriesModel -> harrowing_machineries_used = $machineries['harro_machine'];
                //      $machineriesModel -> harro_ownership_status = $machineries['harro_ownership_status'];
                //      $machineriesModel -> no_of_harrowing = $machineries['no_of_harrowing'];
                //      $machineriesModel -> harrowing_cost = $machineries['cost_per_harrowing'];
                //      $machineriesModel -> harrowing_cost_total = $machineries['harrowing_cost_total'];

                //     //  $machineriesModel -> harvesting_machineries_used = $machineries['harvest_machine'];
                //      $machineriesModel -> harvest_ownership_status	 = $machineries['harvest_ownership_status'];
                  
                //     //  $machineriesModel -> harvesting_cost = $machineries['harvesting_cost'];
                //      $machineriesModel -> harvesting_cost_total = $machineries['Harvesting_cost_total'];

                //      $machineriesModel -> postharvest_machineries_used = $machineries['postharves_machine'];
                //      $machineriesModel -> postharv_ownership_status = $machineries['postharv_ownership_status'];
                //      $machineriesModel -> post_harvest_cost = $machineries['postharvestCost'];
                //      $machineriesModel -> 	total_cost_for_machineries = $machineries['total_cost_for_machineries'];
                //      $machineriesModel -> save();
           

                //      $variable= $request->variables;
                //    //   variable cost
                //      $variablesModel = new VariableCost();
                //   //    $variablesModel -> users_id = $users_id;
                //   //    $variablesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                //      $variablesModel -> crops_farms_id = $crop_id;
                    
                //    //   seeds
                 
                //      $variablesModel -> seed_name = $variable['seed_name'];
                //      $variablesModel -> unit = $variable['unit'];
                //      $variablesModel -> quantity = $variable['quantity'];
                //      $variablesModel -> unit_price = $variable['unit_price_seed'];
                //      $variablesModel -> total_seed_cost = $variable['total_seed_cost'];
           
                //       //   seeds
                //       $variablesModel -> labor_no_of_person = $variable['no_of_person'];
                //       $variablesModel -> rate_per_person = $variable['rate_per_person'];
                //       $variablesModel -> total_labor_cost = $variable['total_labor_cost'];
           
                //        // fertilizer
                //       $variablesModel -> name_of_fertilizer = $variable['name_of_fertilizer'];
                //       $variablesModel -> type_of_fertilizer = $variable['total_seed_cost'];
                //       $variablesModel -> no_of_sacks = $variable['no_ofsacks'];
                //       $variablesModel -> unit_price_per_sacks = $variable['unitprice_per_sacks'];
                //       $variablesModel -> total_cost_fertilizers = $variable['total_cost_fertilizers'];
           
                //         //pesticides
                //         $variablesModel -> pesticide_name = $variable['pesticides_name'];
                //        //  $variablesModel ->	type_of_pesticides = $variable['no_of_l_kg'];2
                //         $variablesModel -> no_of_l_kg = $variable['no_of_l_kg'];
                //         $variablesModel -> unit_price_of_pesticides = $variable['unitprice_ofpesticides'];
                //         $variablesModel -> total_cost_pesticides = $variable['total_cost_pesticides'];
                    
                //          //transportation
                //          $variablesModel -> name_of_vehicle = $variable['type_of_vehicle'];
                        
                //          $variablesModel -> total_transport_delivery_cost = $variable['total_seed_cost'];
                      
                //          $variablesModel -> total_machinery_fuel_cost= $variable['total_machinery_fuel_cost'];
                //          $variablesModel -> total_variable_cost= $variable['total_variable_costs'];
                //          $variablesModel -> save();
                
                        // return $request;
                       
                
                 // Return success message
                 return [
                     'success' => "Saved to database" // Corrected the syntax here
                 ];
             }  
            //  update and edit
             public function fixedEdit(Request $request, $id)
             {
                 // Check if the user is authenticated
                 if (Auth::check()) {
                     // Retrieve the authenticated user's ID
                     $userId = Auth::id();
                     $admin = User::find($userId);
             
                     if ($admin) {
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
             
                                                             // Handle the 'archives' request type for fetching archives by PersonalInformations ID
                                                             if ($type === 'costArhive') {
                                                                // First, check if the PersonalInformation record exists
                                                                $fixedData = FixedCost::find($id);
                            
                                                                // If the PersonalInformation record is not found, return a 404 with the message
                                                                if (!$fixedData ) {
                                                                    return response()->json(['message' => 'Fixed Cost not found.'], 404);
                                                                }
                                                            // Fetch the archives associated with the PersonalInformation ID
                                                                $archives =  FixedCostArchive::where('fixed_costs_id', $id)->get();
                            
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
                         return view('admin.farmersdata.CrudFixed.edit', compact(
                             'agri_district', 'agri_districts_id', 'admin', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                             'farmData', 'cropData', 'production', 'fixedData'
                         ));
                     } else {
                         return redirect()->route('login')->with('error', 'User not found.');
                     }
                 } else {
                     return redirect()->route('login');
                 }
             }
             
             public function fixedUpdate(Request $request,$id)
             {
             
                 try{
                     
         
                     // $data= $request->validated();
                     // $data= $request->all();
                     
                     $data= FixedCost::find($id);
                     if (!$data) {
                        return redirect()->route('admin.farmersdata.production', $id)
                            ->with('message', 'Fixed Cost not found');
                    }
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
                 return redirect()->route('admin.farmersdata.production', $data->crops_farms_id)
                 ->with('message', 'Fixed Cost Data updated successfully');
             } catch (\Exception $ex) {
                 // Handle the exception and provide error feedback
                 return redirect()->back()->with('message', 'Something went wrong');
             }  
             } 

            //  delete
       public function fixeddelete($id) {
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

// CRUD operations for managing machinery cost data:
// - Create: Adds new machinery cost records (e.g., purchase cost, maintenance, repairs) to the database.
// - Read: Retrieves and displays machinery cost data for analysis or reporting purposes.
// - Update: Modifies existing machinery cost records based on updated expenses or equipment changes.
// - Delete: Removes machinery cost data from the database when no longer necessary or applicable.

    // add 

    public function AddMachinerie(Request $request,$id)
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
              $cropData = Crop::find($id);
              $lastproduction = LastProductionDatas::find($id);
              $machineriesData =MachineriesUseds::find($id);
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
                return view('admin.farmersdata.CrudMachineries.add', compact('agri_district', 'agri_districts_id', 'admin', 'profile',
                'totalRiceProduction','userId','cropVarieties','farmData','cropData','lastproduction','machineriesData'));
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
    
    public function MachineriesSave(Request $request)
    {
   
      
          
 
            
            // $fixedCost= $request->fixedcost; 

            //    // FIXED COST
            //    $fixedcostModel = new FixedCost();
            //   //  $fixedcostModel -> users_id = $users_id;
            //   //  $fixedcostModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
            //    $fixedcostModel ->crops_farms_id = $fixedCost['crops_farms_id'];
            // //    $fixedcostModel -> last_production_datas_id = $productionId;
            //    $fixedcostModel -> particular = $fixedCost['particular'];
            //    $fixedcostModel -> no_of_ha = $fixedCost['no-has'];
            //    $fixedcostModel -> cost_per_ha = $fixedCost['cost-has'];
            //    $fixedcostModel -> total_amount = $fixedCost['total-amount'];
            //    $fixedcostModel -> save();
       

                // $crop_id=  $fixedcostModel ->crops_farms_id ;
               $machineries=$request->machineries;
               // machineries
                 $machineriesModel = new MachineriesUseds();
              //    $machineriesModel -> users_id = $users_id;
              //    $machineriesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                 $machineriesModel -> crops_farms_id =$machineries ['crops_farms_id'];
 
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
       

            //      $variable= $request->variables;
            //    //   variable cost
            //      $variablesModel = new VariableCost();
            //   //    $variablesModel -> users_id = $users_id;
            //   //    $variablesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
            //      $variablesModel -> crops_farms_id = $crop_id;
                
            //    //   seeds
             
            //      $variablesModel -> seed_name = $variable['seed_name'];
            //      $variablesModel -> unit = $variable['unit'];
            //      $variablesModel -> quantity = $variable['quantity'];
            //      $variablesModel -> unit_price = $variable['unit_price_seed'];
            //      $variablesModel -> total_seed_cost = $variable['total_seed_cost'];
       
            //       //   seeds
            //       $variablesModel -> labor_no_of_person = $variable['no_of_person'];
            //       $variablesModel -> rate_per_person = $variable['rate_per_person'];
            //       $variablesModel -> total_labor_cost = $variable['total_labor_cost'];
       
            //        // fertilizer
            //       $variablesModel -> name_of_fertilizer = $variable['name_of_fertilizer'];
            //       $variablesModel -> type_of_fertilizer = $variable['total_seed_cost'];
            //       $variablesModel -> no_of_sacks = $variable['no_ofsacks'];
            //       $variablesModel -> unit_price_per_sacks = $variable['unitprice_per_sacks'];
            //       $variablesModel -> total_cost_fertilizers = $variable['total_cost_fertilizers'];
       
            //         //pesticides
            //         $variablesModel -> pesticide_name = $variable['pesticides_name'];
            //        //  $variablesModel ->	type_of_pesticides = $variable['no_of_l_kg'];2
            //         $variablesModel -> no_of_l_kg = $variable['no_of_l_kg'];
            //         $variablesModel -> unit_price_of_pesticides = $variable['unitprice_ofpesticides'];
            //         $variablesModel -> total_cost_pesticides = $variable['total_cost_pesticides'];
                
            //          //transportation
            //          $variablesModel -> name_of_vehicle = $variable['type_of_vehicle'];
                    
            //          $variablesModel -> total_transport_delivery_cost = $variable['total_seed_cost'];
                  
            //          $variablesModel -> total_machinery_fuel_cost= $variable['total_machinery_fuel_cost'];
            //          $variablesModel -> total_variable_cost= $variable['total_variable_costs'];
            //          $variablesModel -> save();
            
                    // return $request;
                   
            
             // Return success message
             return [
                 'success' => "Saved to database" // Corrected the syntax here
             ];
         }  

        //  update and edit

         public function MachineriesEdit(Request $request, $id)
         {
             // Check if the user is authenticated
             if (Auth::check()) {
                 // Retrieve the authenticated user's ID
                 $userId = Auth::id();
                 $admin = User::find($userId);
         
                 if ($admin) {
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
                     return view('admin.farmersdata.CrudMachineries.edit', compact(
                         'agri_district', 'agri_districts_id', 'admin', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                         'farmData', 'cropData', 'production', 'fixedData','machineriesData'
                     ));
                 } else {
                     return redirect()->route('login')->with('error', 'User not found.');
                 }
             } else {
                 return redirect()->route('login');
             }
         }
   
         public function MachineriesUpdate(Request $request,$id)
         {

         try{


         // $data= $request->validated();
         // $data= $request->all();

         $machineused= MachineriesUseds::find($id);
         if (!$machineused) {
            return redirect()->route('admin.farmersdata.production', $id)
                ->with('message', 'Fixed Cost not found');
        }
        
        MachineriesCostArchive::create([
            'machineries_useds_id' => $machineused->id,
            'crops_farms_id' => $machineused->crops_farms_id,
            'last_production_machineuseds_id' => $machineused->last_production_machineuseds_id,
            'farm_profiles_id' => $machineused->farm_profiles_id,
            'users_id' => $machineused->users_id,
            'personal_informations_id' => $machineused->personal_informations_id,
           
        
            // New fields
            
            'plowing_machineries_used' => $machineused->plowing_machineries_used,
            'plo_ownership_status' => $machineused->plo_ownership_status,
            'no_of_plowing' => $machineused->no_of_plowing,
            'plowing_cost' => $machineused->plowing_cost,
            'plowing_cost_total' => $machineused->plowing_cost_total,
        
            'harrowing_machineries_used' => $machineused->harrowing_machineries_used,
            'harro_ownership_status' => $machineused->harro_ownership_status,
            'no_of_harrowing' => $machineused->no_of_harrowing,
            'harrowing_cost' => $machineused->harrowing_cost,
            'harrowing_cost_total' => $machineused->harrowing_cost_total,
        
            'harvesting_machineries_used' => $machineused->harvesting_machineries_used,
            'harvest_ownership_status' => $machineused->harvest_ownership_status,
            'harvesting_cost_total' => $machineused->harvesting_cost_total,
        
            'postharvest_machineries_used' => $machineused->postharvest_machineries_used,
            'postharv_ownership_status' => $machineused->postharv_ownership_status,
            'post_harvest_cost' => $machineused->post_harvest_cost,
        
            'total_cost_for_machineries' => $machineused->total_cost_for_machineries,
        ]);
        

         $machineused->users_id = $request->users_id;


         $machineused->crops_farms_id = $request->crops_farms_id;
         $machineused-> plowing_machineries_used = $request->plowing_machineries_used === 'OthersPlowing' ? $request->add_Plowingmachineries : $request->plowing_machineries_used;
         $machineused-> plo_ownership_status = $request->plo_ownership_status === 'Other' ? $request->add_PlowingStatus : $request->plo_ownership_status;
         $machineused->no_of_plowing = $request->no_of_plowing;
         $machineused->plowing_cost = $request->plowing_cost;
         $machineused-> plowing_cost_total = $request->plowing_cost_total;
          
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
         return redirect()->route('admin.farmersdata.production', $machineused->crops_farms_id)
         ->with('message', 'Machineries Cost Data updated successfully');
     } catch (\Exception $ex) {
         // Handle the exception and provide error feedback
         return redirect()->back()->with('message', 'Something went wrong');
     }  
         }

        //  delete

         public function Machineriesdelete($id) {
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




// CRUD operations for managing variable cost data:
// - Create: Adds new variable cost records (e.g., raw materials, labor, utilities) to the database.
// - Read: Retrieves and displays variable cost data for analysis, financial reporting, or decision-making.
// - Update: Modifies existing variable cost records based on changes in expenses or input requirements.
// - Delete: Removes variable cost data from the database when no longer relevant or needed.

            //  add

            public function AddVariable(Request $request,$id)
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
              $cropData = Crop::find($id);
              $lastproduction = LastProductionDatas::find($id);
              $machineriesData =MachineriesUseds::find($id);
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
                return view('admin.farmersdata.CrudVariable.add', compact('agri_district', 'agri_districts_id', 'admin', 'profile',
                'totalRiceProduction','userId','cropVarieties','farmData','cropData','lastproduction','machineriesData'));
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
    public function VariableSave(Request $request)
    {
   
      
          
 
            
            // $fixedCost= $request->fixedcost; 

            //    // FIXED COST
            //    $fixedcostModel = new FixedCost();
            //   //  $fixedcostModel -> users_id = $users_id;
            //   //  $fixedcostModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
            //    $fixedcostModel ->crops_farms_id = $fixedCost['crops_farms_id'];
            // //    $fixedcostModel -> last_production_datas_id = $productionId;
            //    $fixedcostModel -> particular = $fixedCost['particular'];
            //    $fixedcostModel -> no_of_ha = $fixedCost['no-has'];
            //    $fixedcostModel -> cost_per_ha = $fixedCost['cost-has'];
            //    $fixedcostModel -> total_amount = $fixedCost['total-amount'];
            //    $fixedcostModel -> save();
       

                // $crop_id=  $fixedcostModel ->crops_farms_id ;
            //    $machineries=$request->machineries;
            //    // machineries
            //      $machineriesModel = new MachineriesUseds();
            //   //    $machineriesModel -> users_id = $users_id;
            //   //    $machineriesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
            //      $machineriesModel -> crops_farms_id =$machineries ['crops_farms_id'];
 
            //      $machineriesModel-> plowing_machineries_used = $machineries['plowing-machine'];
            //      $machineriesModel -> plo_ownership_status = $machineries['plow_status'];
               
            //      $machineriesModel -> no_of_plowing = $machineries['no_of_plowing'];
            //      $machineriesModel -> plowing_cost = $machineries['cost_per_plowing'];
            //      $machineriesModel -> plowing_cost_total = $machineries['plowing_cost'];

            //      $machineriesModel -> harrowing_machineries_used = $machineries['harro_machine'];
            //      $machineriesModel -> harro_ownership_status = $machineries['harro_ownership_status'];
            //      $machineriesModel -> no_of_harrowing = $machineries['no_of_harrowing'];
            //      $machineriesModel -> harrowing_cost = $machineries['cost_per_harrowing'];
            //      $machineriesModel -> harrowing_cost_total = $machineries['harrowing_cost_total'];

            //     //  $machineriesModel -> harvesting_machineries_used = $machineries['harvest_machine'];
            //      $machineriesModel -> harvest_ownership_status	 = $machineries['harvest_ownership_status'];
              
            //     //  $machineriesModel -> harvesting_cost = $machineries['harvesting_cost'];
            //      $machineriesModel -> harvesting_cost_total = $machineries['Harvesting_cost_total'];

            //      $machineriesModel -> postharvest_machineries_used = $machineries['postharves_machine'];
            //      $machineriesModel -> postharv_ownership_status = $machineries['postharv_ownership_status'];
            //      $machineriesModel -> post_harvest_cost = $machineries['postharvestCost'];
            //      $machineriesModel -> 	total_cost_for_machineries = $machineries['total_cost_for_machineries'];
            //      $machineriesModel -> save();
       

                 $variable= $request->variables;
               //   variable cost
                 $variablesModel = new VariableCost();
              //    $variablesModel -> users_id = $users_id;
              //    $variablesModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                 $variablesModel -> crops_farms_id = $variable ['crops_farms_id'];
                
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

            // update and edit
    public function VariableEdit(Request $request, $id)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve the authenticated user's ID
            $userId = Auth::id();
            $admin = User::find($userId);
    
            if ($admin) {
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
                return view('admin.farmersdata.CrudVariable.edit', compact(
                    'agri_district', 'agri_districts_id', 'admin', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                    'farmData', 'cropData', 'production', 'fixedData','machineriesData','variablesData'
                ));
            } else {
                return redirect()->route('login')->with('error', 'User not found.');
            }
        } else {
            return redirect()->route('login');
        }
    }
    

    public function VariableUpdate(Request $request,$id)
    {

    try{


    // $data= $request->validated();
    // $data= $request->all();

    $variable= VariableCost::find($id);


    if (!$variable) {
        return redirect()->route('admin.farmersdata.production', $id)
            ->with('message', 'Previous Variable Cost data not found');
    }
    
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
        return redirect()->route('admin.farmersdata.production', $variable->crops_farms_id)
        ->with('message', 'Variable Cost Data updated successfully');
    } catch (\Exception $ex) {
        // Handle the exception and provide error feedback
        return redirect()->back()->with('message', 'Please Try Again');
    }  
    } 

        // Delete

    public function Variabledelete($id) {
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

// CRUD operations for managing production sold data:
// - Create: Adds new records for products sold (e.g., quantities, sale price, and date of sale) to the database.
// - Read: Retrieves and displays production sold data for reporting, analysis, or decision-making purposes.
// - Update: Modifies existing records of sold production based on changes in quantities, prices, or sale conditions.
// - Delete: Removes production sold records from the database when no longer needed or applicable.

        // add

        public function AddSolds(Request $request, $id)
        {
            // Check if the user is authenticated
            if (Auth::check()) {
                // Retrieve the authenticated user's ID
                $userId = Auth::id();
                $admin = User::find($userId);
        
                if ($admin) {
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
                    return view('admin.farmersdata.CrudSolds.add', compact(
                        'agri_district', 'agri_districts_id', 'admin', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                        'farmData', 'cropData', 'production', 'fixedData','machineriesData','variablesData','Solds'
                    ));
                } else {
                    return redirect()->route('login')->with('error', 'User not found.');
                }
            } else {
                return redirect()->route('login');
            }
        }

        // store

        public function SoldsSave(Request $request)
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

            //  update and edit 

             public function SoldsEdit(Request $request, $id)
             {
                 // Check if the user is authenticated
                 if (Auth::check()) {
                     // Retrieve the authenticated user's ID
                     $userId = Auth::id();
                     $admin = User::find($userId);
             
                     if ($admin) {
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
                         return view('admin.farmersdata.CrudSolds.edit', compact(
                             'agri_district', 'agri_districts_id', 'admin', 'profile', 'totalRiceProduction', 'userId', 'cropVarieties', 
                             'farmData', 'cropData', 'production', 'fixedData','machineriesData','variablesData','Solds'
                         ));
                     } else {
                         return redirect()->route('login')->with('error', 'User not found.');
                     }
                 } else {
                     return redirect()->route('login');
                 }
             }

             public function SoldsUpdate(Request $request, $id)
             {
                 try {
                     // Find the ProductionSold record
                     $solds = ProductionSold::find($id);
             
                     // Update fields with request data
                     $solds->crops_farms_id = $request->crops_farms_id;
                     $solds->last_production_datas_id = $request->last_production_datas_id;
                     $solds->sold_to = $request->sold_to;
                     $solds->measurement = $request->measurement;
                     $solds->quantity = $request->quantity;
                     $solds->unit_price_rice_per_kg = $request->unit_price_rice_per_kg;
                     $solds->gross_income = $request->gross_income;
             
                     // Save the updated record
                     $solds->save();
             
                     // Redirect to the production view page based on the crop_farms_id
                     return redirect()->route('admin.farmersdata.production', $solds->crops_farms_id)
                         ->with('message', 'Production Solds Data updated successfully');
                 } catch (\Exception $ex) {
                     // Handle the exception and provide error feedback
                     return redirect()->back()->with('message', 'Something went wrong');
                 }
             }

            //  delete

             public function Soldsdelete($id) {
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



//samplefolder function darmer data from the form. Upon clicking the save or submit button, the input data is passed to the database for storage.

public function samplefolder(Request $request) {
    // Check if the user is authenticated
    if (Auth::check()) {
        // User is authenticated
        $user = Auth::user(); // You can use Auth::user() directly
        $userId = $user->id; // Get the authenticated user's ID
    
        $admin = User::find($userId);
        
        if ($admin) {
    // Fetch agri_district and select_member from the user
    $agri_district = $user->agri_district;
    $selectMember = $user->select_member; // Assuming `select_member` is the correct attribute

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
            if ($request->ajax()) {
                $type = $request->input('type');

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
            // Check if there are any farm profiles
            if ($farmProfiles->isEmpty() && $agriDistricts->isEmpty()) {
                return response()->json(['error' => 'No farm profiles or agri districts found.'], 404);
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
                    'admin' => $admin,
                    'profile' => $profile,
                    'farmProfiles' => $farmProfiles,
                    'totalRiceProduction' => $totalRiceProduction,
                
                    'polygons' => $polygonsData,
                    'districtsData' => $districtsData // Send all district GPS coordinates
                ]);
            } else {
                // Return the view with the fetched data for regular requests
                return view('admin.farmersdata.samplefolder.farm_edit', [
                    'admin' => $admin,
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

// Function to check if the farmer already exists in the database. If the farmer’s data is found, the form submission is halted and a validation message is provided to the user.


public function checkFarmerExistence(Request $request)
{
    $exists = PersonalInformations::where('first_name', $request->first_name)
        ->where('last_name', $request->last_name)
        ->where('mothers_maiden_name', $request->mothers_maiden_name)
        // ->where('date_of_birth', $request->date_of_birth)
        ->exists();

    return response()->json(['exists' => $exists]);
}

// save form
public function test(Request $request)
{



      // Farmer info
      $farmerdata = $request -> farmer;

      $existingFarmer = PersonalInformations::where('last_name', $farmerdata['last_name'])
      ->where('first_name', $farmerdata['first_name'])
      ->where('mothers_maiden_name', $farmerdata['mothers_maiden_name'])
      ->where('date_of_birth', $farmerdata['date_of_birth'])
      ->first();
  
  if ($existingFarmer) {
      return response()->json([
          'error' => 'A record with this last name, first name, mother\'s maiden name, and date of birth already exists.',
          'existing_data' => [
              'last_name' => $existingFarmer->last_name,
              'first_name' => $existingFarmer->first_name,
              'mothers_maiden_name' => $existingFarmer->mothers_maiden_name,
              'date_of_birth' => $existingFarmer->date_of_birth,
              // Add other relevant fields here if needed
          ]
      ], 400); // Send a 400 Bad Request status code
  }
  
      $farmerModel = new PersonalInformations();
      $farmerModel -> users_id = $farmerdata['users_id'];
      $farmerModel -> first_name = $farmerdata['first_name'];
      $farmerModel -> middle_name= $farmerdata['middle_name'];
      $farmerModel -> last_name= $farmerdata['last_name'];
      $farmerModel -> extension_name = $farmerdata['extension_name'];
      $farmerModel -> country= $farmerdata['country'];
      $farmerModel -> province= $farmerdata['province'];
      $farmerModel -> city = $farmerdata['city'];
      $farmerModel -> district= $farmerdata['agri_district'];
      $farmerModel -> barangay= $farmerdata['barangay'];
      
    //   $farmerModel -> street= $farmerdata['street'];
    //   $farmerModel -> zip_code= $farmerdata['zip_code'];
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


    // VARIABLES
    // VARIABLES
    $farmer_id = $farmerModel -> id;
    // VARIABLES
    // VARIABLES

       // Farm info
      $farms = $request -> farm;
      $farmModel = new FarmProfile();

      $farmModel -> users_id = $farmerModel -> users_id;

      // FROM USER
      $farmModel -> agri_districts_id = 1;


      $farmModel -> personal_informations_id = $farmer_id;

    //   $farmModel -> polygons_id = $farms['polygons_id'];
    //   $farmModel -> agri_districts = $farms['agri_districts'];

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
      $farmModel -> oca_district_office =$farmerModel -> district;
      $farmModel -> name_of_field_officer_technician = $farms['name_technicians'];
      $farmModel -> date_interviewed = $farms['date_interview'];

      $farmModel ->save();
     
    // VARIABLES
    // VARIABLES
    $farm_id = $farmModel -> id;
    $users_id =  $farmerModel -> users_id;
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
     
            
            }

   






      // Return success message
      return [
          'success' => "Saved to database" // Corrected the syntax here
      ];
  }



}


