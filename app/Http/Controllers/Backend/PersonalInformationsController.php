<?php

namespace App\Http\Controllers\Backend;
use App\Models\FarmerOrg;
use App\Models\FixedCost;
use App\Models\LastProductionDatas;
use App\Models\MachineriesUseds;
use App\Models\ProductionCrop;
use App\Models\ProductionSold;
use App\Models\Barangay;
use App\Models\CropCategory;
use App\Models\Categorize;
use App\Models\PersonalInformations;
use App\Models\VariableCost;
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
use Nette\Utils\Strings;
use App\Models\KmlFile;
use App\Models\User;
use App\Models\AgriDistrict;
use App\Models\FarmProfile;
use App\Models\Seed;
use Illuminate\Support\Facades\Auth;

class PersonalInformationsController extends Controller
{

protected $personalInformations;
public function __construct() {
    $this->personalInformations = new PersonalInformations;

}


// join table for farmprfofiles


    //join all table and then fetch specific column
public function Personalfarms() {

    try { 

    $personalInformations = DB::table('personal_informations')
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
        )
    ->get();
  
    return view('farm-table.join_table',['personalInformations' => $personalInformations]);
} catch (\Exception $ex) {
    // Log the exception for debugging purposes
    dd($ex);
    return redirect()->back()->with('message', 'Something went wrong');
}
 
// }
    }
   
    public function Gmap()
    {
     $personalInformations= PersonalInformations::all();
     $parcels= ParcellaryBoundaries::all();
   
        // Fetch the latest uploaded KML file from the database
        $kmlFile = KmlFile::latest()->first();

       
    

     return view('map.gmap',compact('personalInformations','parcels','kmlFile'));
    }


        // view the personalinfo by admin
        public function PersonalInfo()
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
                    $agri_district = $admin->agri_district;
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
                 
                    $personalInformation= PersonalInformations::all();
        
                    
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    // Return the view with the fetched data
                    return view('personalinfo.index', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
                    ,'personalInformation','userId','agri_district'
                    
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

    public function Agent(): View
    {
        $personalInformation= PersonalInformations::all();
    return view('personalinfo.index_agent',compact('personalInformation'));
    }
   

    public function PersonalInfoCrud():View{
        $personalInformations= PersonalInformations::latest()->get();
        return view('personalinfo.create',compact('personalInformations'));
    }

    //agent form personal info form
    public function PersonalInfoCrudAgent():View{
        $personalInformations= PersonalInformations::latest()->get();
        return view('personalinfo.show_agent',compact('personalInformations'));
    }
   


    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonalInformationsRequest $request): RedirectResponse
    {
      
        try{
        
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
    
    // $personalInformation= $request->validated();
    // $personalInformation= $request->all();
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
            



        
            dd($personalInformation);
             $personalInformation->save();
            return redirect('/admin-farmprofile')->with('message','Personal informations Added successsfully');
        
        }
        catch(\Exception $ex){
            // dd($ex); // Debugging statement to inspect the exception
            return redirect('/admin-add-personalinformation')->with('message','Please Try Again');
            
        }   
        
        
               
          
  

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
        // new update store by admin FOR PERSONAL INFO
        // public function PersonalInfoUpdate(Request $request, $id)
        // {
        //     // Farmer info
        //     $farmerdata = $request->farmer;
        
        //     // Find the PersonalInformation record by ID and check if it exists
        //     $personalinfos = PersonalInformations::find($id);
        
           
        //     // Proceed with updating if the record is found
        //     $personalinfos->users_id = $farmerdata['users_id'];
        //     $personalinfos->first_name = $farmerdata['first_name'];
        //     $personalinfos->middle_name = $farmerdata['middle_name'];
        //     $personalinfos->last_name = $farmerdata['last_name'];
        //     $personalinfos->extension_name = $farmerdata['extension_name'];
        //     $personalinfos->country = $farmerdata['country'];
        //     $personalinfos->province = $farmerdata['province'];
        //     $personalinfos->city = $farmerdata['city'];
        //     $personalinfos->district = $farmerdata['agri_district'];
        //     $personalinfos->barangay = $farmerdata['barangay'];
        //     $personalinfos->street = $farmerdata['street'];
        //     $personalinfos->zip_code = $farmerdata['zip_code'];
        //     $personalinfos->sex = $farmerdata['sex'];
        //     $personalinfos->religion = $farmerdata['religion'];
        //     $personalinfos->date_of_birth = $farmerdata['date_of_birth'];
        //     $personalinfos->place_of_birth = $farmerdata['place_of_birth'];
        //     $personalinfos->contact_no = $farmerdata['contact_no'];
        //     $personalinfos->civil_status = $farmerdata['civil_status'];
        //     $personalinfos->name_legal_spouse = $farmerdata['name_legal_spouse'];
        //     $personalinfos->no_of_children = $farmerdata['no_of_children'];
        //     $personalinfos->mothers_maiden_name = $farmerdata['mothers_maiden_name'];
        //     $personalinfos->highest_formal_education = $farmerdata['highest_formal_education'];
        //     $personalinfos->person_with_disability = $farmerdata['person_with_disability'];
        //     $personalinfos->pwd_id_no = $farmerdata['YEspwd_id_no'];
        //     $personalinfos->government_issued_id = $farmerdata['government_issued_id'];
        //     $personalinfos->id_type = $farmerdata['id_type'];
        //     $personalinfos->gov_id_no = $farmerdata['add_Idtype'];
        //     $personalinfos->member_ofany_farmers_ass_org_coop = $farmerdata['member_ofany_farmers'];
        //     $personalinfos->nameof_farmers_ass_org_coop = $farmerdata['nameof_farmers'];
        //     $personalinfos->name_contact_person = $farmerdata['name_contact_person'];
        //     $personalinfos->cp_tel_no = $farmerdata['cp_tel_no'];
        //     $personalinfos->date_interview = $farmerdata['date_of_interviewed'];
        //     $personalinfos->save();
        
        //     // Continue with the rest of the function (farm, crops, etc.)
        // }
        
        public function PersonalInfoUpdate(Request $request,$id)
        {
  
             try{
        

                    // $data= $request->validated();
                    // $data= $request->all();
                    $data= PersonalInformations::find($id);
                    
                   
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
                    
                
                    return redirect('/admin-view-General-Farmers')->with('message','Personal informations Updated successsfully');
                
                }
                catch(\Exception $ex){
                    // dd($ex); // Debugging statement to inspect the exception
                    return redirect('/admin-update-personalinfo/{personalinfos}')->with('message','Someting went wrong');
                    
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

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

            // Fetch farmer's personal information based on the provided ID
            $personalinfos = PersonalInformations::find($id);

            // Fetch farm data based on the farmer's ID
            // Use the correct relationship name 'personalInformation' instead of 'personalinfo'
            $farmData = FarmProfile::with('personalInformation')->where('personal_informations_id', $id)->get()
            ->unique('personal_informations_id'); // Ensure unique by personal_informations_id
 

            // Calculate total rice production
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

            // Return the view with the fetched data
            return view('admin.farmersdata.farm', compact(
                'admin', 'profile', 'farmProfile', 'totalRiceProduction',
                'personalinfos', 'userId', 'agri_district', 'agri_districts_id', 'farmData'
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

                    // Find the farm profile using the fetched farm ID
                    $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

                // Fetch farmer's information based on ID
                $farmData = FarmProfile::find($id);
                 // Fetch CropFarms related to the given ID and get the FarmProfiles
            $cropFarms = Crop::with('farmProfile.personalInformation')
            ->where('farm_profiles_id', $id)
            ->get();

        // Extract unique personal information records from the related FarmProfiles
        $personalInfos = $cropFarms->map(function ($cropFarm) {
            return $cropFarm->farmProfile->personalInformation;
        })->unique('id');

                $cropName = $request->input('crop_name');

                // Fetch farm profile data
                $farmData = FarmProfile::find($id);
            
                 // Fetch all crop data or filter based on the selected crop name
                 if ($cropName && $cropName != 'All') {
                    $cropData = Crop::where('farm_profiles_id', $id)
                                    ->where('crop_name', $cropName)
                                    
                                    ->get();
                } else {
                    $cropData = Crop::where('farm_profiles_id', $id)
                                    ->with( 'farmprofile')
                                    ->get();
                }

      

            
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('admin.farmersdata.crop', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
            ,'farmData','userId','agri_district','agri_districts_id','cropData','id','personalInfos', 'cropFarms'
            
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

        // production view
        public function  productionview (Request $request, $id)
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


                  // Fetch the LastProductionDatas using crops_farms_id
            $lastProductionDatas = LastProductionDatas::where('crops_farms_id', $id)->get();

            // Initialize array to hold the personal information records
            $personalInfos = collect();

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

                $cropName = $request->input('crop_name');

                
            
                //  Fetch all crop data or filter based on the selected crop name
                 if ($cropName && $cropName != 'All') {
                    $cropData = Crop::where('farm_profiles_id', $id)
                                    ->where('crop_name', $cropName)
                                    
                                    ->get();
                } else {
                    $cropData = Crop::where('farm_profiles_id', $id)
                                    ->with( 'farmprofile')
                                    ->get();
                }
                $productionData = LastProductionDatas::where('crops_farms_id', $id)
                                                ->with('crop')
                                                ->get();
           
               
                // fixed cost
                $FixedData = FixedCost::where('last_production_datas_id', $id)
           
                ->get();

                $machineriesData =MachineriesUseds::where('last_production_datas_id', $id)
           
                ->get();
                $variableData =VariableCost::where('last_production_datas_id', $id)
           
                ->get();
      

            
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            // Return the view with the fetched data
            return view('admin.farmersdata.production', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
            ,'userId','agri_district','agri_districts_id','cropData','id','productionData','FixedData'
            ,'farmData','machineriesData','variableData','personalInfos'
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


// samplefolder

public function samplefolder(Request $request)
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // User is authenticated, proceed with retrieving the user's ID
        $user = Auth::user(); // You can use Auth::user() directly
        $userId = $user->id; // Get the authenticated user's ID
        $admin = User::find($userId); // Fetch user details

        if ($admin) {
            // Fetch agri_district and select_member from the user
            $agri_district = $user->agri_district;
            $selectMember = $user->select_member; // Assuming `select_member` is the correct attribute

            // Find the user's personal information
            $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

            // Fetch the farm ID and agri district ID associated with the user
            $farmId = $user->farm_id;
            $agri_districts_id = $user->agri_districts_id;

            // Find the farm profile using the fetched farm ID
            $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

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

            // For non-AJAX requests, continue rendering the view
            $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
            return view('admin.farmersdata.samplefolder.farm_edit', compact(
                'admin', 
                'profile', 
                'farmProfile', 
                'totalRiceProduction', 
                'userId', 
                'agri_district', 
                'agri_districts_id', 
                'selectMember'
            ));
        } else {
            return redirect()->route('login')->with('error', 'User not found.');
        }
    } else {
        return redirect()->route('login');
    }
}


// public function samplefolder(Request $request)
// {
//     // Check if the user is authenticated
//     if (Auth::check()) {
//         // User is authenticated, proceed with retrieving the user's ID
//         $userId = Auth::id();
//         $admin = User::find($userId);

//         if ($admin) {
//             // Fetch user information
//             $user = auth()->user();
//             $agri_district = $admin->agri_district;
//             $selectMember = $user->select_member; // Assuming `select_member` is the correct attribute

//             // Check if user is authenticated before proceeding
//             if (!$user) {
//                 return redirect()->route('login');
//             }

//             // Find the user's personal information
//             $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

//             // Fetch the farm ID associated with the user
//             $farmId = $user->farm_id;
//             $agri_districts_id = $user->agri_districts_id;

//             // Find the farm profile using the fetched farm ID
//             $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

//             // Handle AJAX requests
//             // if ($request->ajax()) {
//             //     $type = $request->input('type');

//             //     // Handle requests for barangays and organizations
//             //     if ($type === 'barangays' || $type === 'organizations') {
//             //         $district = $request->input('district');
        
//             //         if ($type === 'barangays') {
//             //             $barangays = Barangay::where('district', $district)->get(['id', 'barangay_name']);
//             //             return response()->json($barangays);
        
//             //         } elseif ($type === 'organizations') {
//             //             $organizations = FarmerOrg::where('district', $district)->get(['id', 'organization_name']);
//             //             return response()->json($organizations);
//             //         }
        
//             //         return response()->json(['error' => 'Invalid type parameter.'], 400);
//             //     }
//                  // Handle requests for agri-districts
                


//                  if ($request->ajax()) {
//                     $type = $request->input('type');
                
//                     // Handle requests for agri-districts
//                     if ($type === 'districts') {
//                         $districts = AgriDistrict::pluck('district', 'district'); // Fetch agri-district names
//                         return response()->json($districts); // Added missing semicolon here
//                     }
                
//                     // Handle requests for barangays based on the selected district
//                     if ($type === 'barangays') {
//                         $district = $request->input('district');
//                         if (!$district) {
//                             return response()->json(['error' => 'District is required.'], 400);
//                         }
                
//                         $barangays = Barangay::where('district', $district)->pluck('barangay_name', 'barangay_name');
//                         return response()->json($barangays);
//                     }
                
//                     // Handle requests for organizations based on the selected district
//                     if ($type === 'organizations') {
//                         $district = $request->input('district');
//                         if (!$district) {
//                             return response()->json(['error' => 'District is required.'], 400);
//                         }
                
//                         $organizations = FarmerOrg::where('district', $district)->pluck('organization_name', 'organization_name');
//                         return response()->json($organizations);
//                     }
                
//                     // Handle requests for crop names
//                     if ($type === 'crops') {
//                         $crops = CropCategory::pluck('crop_name', 'crop_name');
//                         return response()->json($crops);
//                     }
                
//                     // Handle requests for crop varieties based on the selected crop name
//                     if ($type === 'varieties') {
//                         $cropName = $request->input('crop_name');
//                         if (!$cropName) {
//                             return response()->json(['error' => 'Crop name is required.'], 400);
//                         }
                
//                         $varieties = Categorize::where('crop_name', $cropName)->pluck('variety_name', 'variety_name');
//                         return response()->json($varieties);
//                     }
                
//                     // Handle requests for seed names based on the selected variety name
//                     if ($type === 'seedname') {
//                         $varietyName = $request->input('variety_name');
//                         if (!$varietyName) {
//                             return response()->json(['error' => 'Variety name is required.'], 400);
//                         }
                
//                         $seeds = Seed::where('variety_name', $varietyName)->pluck('seed_name', 'seed_name');
//                         return response()->json($seeds);
//                     }
                
//                     // Invalid request type
//                     return response()->json(['error' => 'Invalid type parameter.'], 400);
//                 }
                
//             // For non-AJAX requests, continue rendering the view
//             $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
//             return view('admin.farmersdata.samplefolder.farm_edit', compact('admin', 'profile', 'farmProfile', 
//             'totalRiceProduction', 'userId', 'agri_district', 'agri_districts_id', 'selectMember'));
//         } else {
//             return redirect()->route('login')->with('error', 'User not found.');
//         }
//     } else {
//         return redirect()->route('login');
//     }
// }

// public function samplefolder(Request $request)
// {
//     // Check if the user is authenticated
//     if (Auth::check()) {
//         // User is authenticated, proceed with retrieving the user's ID
//         $userId = Auth::id();
//         $admin = User::find($userId);

//         if ($admin) {
//             // Fetch user information
//             $user = auth()->user();
//             $agri_district = $admin->agri_district;
//             $selectMember = $user->select_member; // Assuming `select_member` is the correct attribute

//             // Check if user is authenticated before proceeding
//             if (!$user) {
//                 return redirect()->route('login');
//             }

//             // Find the user's personal information
//             $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

//             // Fetch the farm ID associated with the user
//             $farmId = $user->farm_id;
//             $agri_districts_id = $user->agri_districts_id;

//             // Find the farm profile using the fetched farm ID
//             $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();

//             // Handle AJAX requests
//             if ($request->ajax()) {
//                 $type = $request->input('type');

//                 // Search for an existing farmer with the same details
//                 if ($type === 'check-farmer') {
//                     // Validate the input data
//                     $validated = $request->validate([
//                         'first_name' => 'required|string|max:255',
//                         'last_name' => 'required|string|max:255',
//                         'mothers_maiden_name' => 'required|string|max:255',
//                         'date_of_birth' => 'required|date',
//                     ]);

//                     // Check if a farmer with the same details already exists
//                     $farmerExists = PersonalInformations::where('first_name', $validated['first_name'])
//                         ->where('last_name', $validated['last_name'])
//                         ->where('mothers_maiden_name', $validated['mothers_maiden_name'])
//                         ->where('date_of_birth', $validated['date_of_birth'])
//                         ->exists();

//                     // Return a response indicating if the farmer exists or not
//                     if ($farmerExists) {
//                         return response()->json(['exists' => true, 'message' => 'This farmer already exists in the database.']);
//                     } else {
//                         return response()->json(['exists' => false]);
//                     }
//                 }

//                 // Handle requests for barangays and organizations
//                 if ($type === 'barangays' || $type === 'organizations') {
//                     $district = $request->input('district');
        
//                     if ($type === 'barangays') {
//                         $barangays = Barangay::where('district', $district)->get(['id', 'barangay_name']);
//                         return response()->json($barangays);
        
//                     } elseif ($type === 'organizations') {
//                         $organizations = FarmerOrg::where('district', $district)->get(['id', 'organization_name']);
//                         return response()->json($organizations);
//                     }
        
//                     return response()->json(['error' => 'Invalid type parameter.'], 400);
//                 }

//                 // Handle requests for crop names and crop varieties
//                 if ($type === 'crops') {
//                     $crops = CropCategory::pluck('crop_name', 'crop_name');
//                     return response()->json($crops);
//                 }

//                 if ($type === 'varieties') {
//                     $cropId = $request->input('crop_name');
//                     $varieties = Categorize::where('crop_name', $cropId)->pluck('variety_name', 'variety_name');
//                     return response()->json($varieties);
//                 }

//                 if ($type === 'seedname') {
//                     // Retrieve the 'variety_name' from the request
//                     $varietyId = $request->input('variety_name');
                
//                     // Fetch the seeds based on the variety name and return the result as a JSON response
//                     $seeds = Seed::where('variety_name', $varietyId)->pluck('seed_name', 'seed_name');
                
//                     // Return the seeds as a JSON response for the frontend
//                     return response()->json($seeds);
//                 }

//                 return response()->json(['error' => 'Invalid type parameter.'], 400);
//             }

//             // For non-AJAX requests, continue rendering the view
//             $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');

//             return view('admin.farmersdata.samplefolder.farm_edit', compact(
//                 'admin', 'profile', 'farmProfile', 'totalRiceProduction', 
//                 'userId', 'agri_district', 'agri_districts_id', 'selectMember'
//             ));
//         } else {
//             return redirect()->route('login')->with('error', 'User not found.');
//         }
//     } else {
//         return redirect()->route('login');
//     }
// }






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
              'error' => 'A record with this last name, first name, mother\'s maiden name, and date of birth already exists.'
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
     
              return $request;
            }

   






      // Return success message
      return [
          'success' => "Saved to database" // Corrected the syntax here
      ];
  }


  public function updatefarmer(Request $request,$id)
  {
  
  
  
        // Farmer info
        $farmerdata = $request -> farmer;
  
        // $existingFarmer = PersonalInformations::where('last_name', $farmerdata['last_name'])
        // ->where('first_name', $farmerdata['first_name'])
        // ->where('mothers_maiden_name', $farmerdata['mothers_maiden_name'])
        // ->where('date_of_birth', $farmerdata['date_of_birth'])
        // ->first();
  
        // if ($existingFarmer) {
        //     return response()->json([
        //         'error' => 'A record with this last name, first name, mother\'s maiden name, and date of birth already exists.'
        //     ], 400); // Send a 400 Bad Request status code
        // }
        $farmerModel =PersonalInformations::find($id);
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
    //   $farmer_id = $farmerModel -> id;
    //   // VARIABLES
    //   // VARIABLES
  
    //      // Farm info
    //     $farms = $request -> farm;
    //     $farmModel = new FarmProfile();
  
    //     $farmModel -> users_id = $farmerModel -> users_id;
  
    //     // FROM USER
    //     $farmModel -> agri_districts_id = 1;
  
  
    //     $farmModel -> personal_informations_id = $farmer_id;
  
    //   //   $farmModel -> polygons_id = $farms['polygons_id'];
    //   //   $farmModel -> agri_districts = $farms['agri_districts'];
  
    //     $farmModel -> tenurial_status = $farms['tenurial_status'];
    //     $farmModel -> farm_address = $farms['farm_address'];
  
    //     $farmModel -> no_of_years_as_farmers = $farms['no_of_years_as_farmers'];
    //     $farmModel -> gps_longitude = $farms['gps_longitude'];
    //     $farmModel -> gps_latitude = $farms['gps_latitude'];
    //     $farmModel -> total_physical_area = $farms['Total_area_cultivated_has'];
    //     $farmModel -> total_area_cultivated = $farms['Total_area_cultivated_has'];
    //     $farmModel -> land_title_no = $farms['land_title_no'];
    //     $farmModel -> lot_no = $farms['lot_no'];
    //     $farmModel -> area_prone_to = $farms['area_prone_to'];
    //     $farmModel -> ecosystem = $farms['ecosystem'];
    //     $farmModel -> rsba_registered = $farms['rsba_register'];
    //     $farmModel -> pcic_insured = $farms['pcic_insured'];
    //     $farmModel -> government_assisted = $farms['government_assisted'];
    //     $farmModel -> source_of_capital = $farms['source_of_capital'];
    //     $farmModel -> remarks_recommendation = $farms['remarks'];
    //     $farmModel -> oca_district_office =$farmerModel -> district;
    //     $farmModel -> name_of_field_officer_technician = $farms['name_technicians'];
    //     $farmModel -> date_interviewed = $farms['date_interview'];
  
    //     $farmModel ->save();
       
    //   // VARIABLES
    //   // VARIABLES
    //   $farm_id = $farmModel -> id;
    //   $users_id =  $farmerModel -> users_id;
    //   // VARIABLES
    //   // VARIABLES
  
  
    //     // Crop info 
    //     foreach ($request -> crops as $crop) {
    //         $cropModel = new Crop();
    //         $cropModel -> farm_profiles_id = $farm_id;
    //         $cropModel -> crop_name = $crop['crop_name'];
    //         $cropModel -> users_id = $users_id;
    //         $cropModel -> planting_schedule_dryseason = $crop['variety']['dry_season'];
    //         $cropModel -> no_of_cropping_per_year = $crop['variety']['no_cropping_year'];
    //         $cropModel -> preferred_variety = $crop['variety']['preferred'];
    //         $cropModel -> type_of_variety_planted = $crop['variety']['type_variety'];
    //         $cropModel -> planting_schedule_wetseason	 = $crop['variety']['wet_season'];
    //         $cropModel -> yield_kg_ha = $crop['variety']['yield_kg_ha'];
    //         $cropModel -> save();
  
    //         $crop_id = $cropModel -> id;
  
    //         $productionModel = new LastProductionDatas();
    //         $productionModel -> users_id = $users_id;
    //         $productionModel -> farm_profiles_id = $farm_id;
    //         $productionModel -> crops_farms_id = $crop_id;
    //         $productionModel -> seed_source = $crop['production']['seedSource'];
    //         $productionModel -> seeds_used_in_kg = $crop['production']['seedUsed'];
    //         $productionModel -> seeds_typed_used = $crop['production']['seedtype'];
    //         $productionModel -> no_of_fertilizer_used_in_bags = $crop['production']['fertilizedUsed'];
    //         $productionModel -> no_of_insecticides_used_in_l = $crop['production']['insecticide'];
    //         $productionModel -> no_of_pesticides_used_in_l_per_kg = $crop['production']['pesticidesUsed'];
    //         $productionModel -> area_planted = $crop['production']['areaPlanted'];
    //         $productionModel -> date_planted = $crop['production']['datePlanted'];
    //         $productionModel -> date_planted = $crop['production']['Dateharvested'];
    //         $productionModel -> unit = $crop['production']['unit'];
    //         $productionModel -> yield_tons_per_kg = $crop['production']['yieldkg'];
        
           
    //         $productionModel -> save();
  
    //       // productionid
    //       $productionId=$productionModel ->id;
  
    //       foreach ($crop['sales'] as $sale) {
    //           // Create a new sale associated with the production ID
    //           $salesModel = new ProductionSold();
    //           $salesModel -> last_production_datas_id = $productionId;
    //           $salesModel -> sold_to = $sale['soldTo'];
    //           $salesModel -> measurement = $sale['measurement'];
    //           $salesModel -> 	unit_price_rice_per_kg = $sale['unit_price'];
    //           $salesModel -> 	quantity = $sale['quantity'];
    //           $salesModel -> 	gross_income = $sale['grossIncome'];
    //           $salesModel ->save();
    //       }
  
  
    //       // FIXED COST
    //       $fixedcostModel = new FixedCost();
    //       $fixedcostModel -> users_id = $users_id;
    //       $fixedcostModel -> farm_profiles_id = $farm_id;
    //       $fixedcostModel -> crops_farms_id = $crop_id;
    //       $fixedcostModel -> last_production_datas_id = $productionId;
    //       $fixedcostModel -> 	particular = $crop['fixedCost']['particular'];
    //       $fixedcostModel -> no_of_ha = $crop['fixedCost']['no_of_has'];
    //       $fixedcostModel -> cost_per_ha = $crop['fixedCost']['costperHas'];
    //       $fixedcostModel -> total_amount = $crop['fixedCost']['TotalFixed'];
    //       $fixedcostModel -> save();
  
    //       // machineries
    //         $machineriesModel = new MachineriesUseds();
    //         $machineriesModel -> users_id = $users_id;
    //         $machineriesModel -> farm_profiles_id = $farm_id;
    //         $machineriesModel -> crops_farms_id = $crop_id;
    //         $machineriesModel -> last_production_datas_id = $productionId;
    //         $machineriesModel-> plowing_machineries_used = $crop['machineries']['PlowingMachine'];
    //         $machineriesModel -> plo_ownership_status = $crop['machineries']['plow_status'];
          
    //         $machineriesModel -> no_of_plowing = $crop['machineries']['no_of_plowing'];
    //         $machineriesModel -> plowing_cost = $crop['machineries']['cost_per_plowing'];
    //         $machineriesModel -> plowing_cost_total = $crop['machineries']['plowing_cost'];
    //         $machineriesModel -> harrowing_machineries_used = $crop['machineries']['harro_machine'];
    //         $machineriesModel -> harro_ownership_status = $crop['machineries']['harro_ownership_status'];
    //         $machineriesModel -> no_of_harrowing = $crop['machineries']['no_of_harrowing'];
    //         $machineriesModel -> harrowing_cost = $crop['machineries']['cost_per_harrowing'];
    //         $machineriesModel -> harrowing_cost_total = $crop['machineries']['harrowing_cost_total'];
    //         $machineriesModel -> harvesting_machineries_used = $crop['machineries']['harvest_machine'];
    //         $machineriesModel -> harvest_ownership_status	 = $crop['machineries']['harvest_ownership_status'];
         
    //       //   $machineriesModel -> harvesting_cost = $crop['machineries']['harvesting_cost'];
    //         $machineriesModel -> harvesting_cost_total = $crop['machineries']['Harvesting_cost_total'];
    //         $machineriesModel -> postharvest_machineries_used = $crop['machineries']['postharves_machine'];
    //         $machineriesModel -> postharv_ownership_status = $crop['machineries']['postharv_ownership_status'];
    //         $machineriesModel -> post_harvest_cost = $crop['machineries']['postharvestCost'];
    //         $machineriesModel -> 	total_cost_for_machineries = $crop['machineries']['total_cost_for_machineries'];
    //         $machineriesModel -> save();
  
    //       //   variable cost
    //         $variablesModel = new VariableCost();
    //         $variablesModel -> users_id = $users_id;
    //         $variablesModel -> farm_profiles_id = $farm_id;
    //         $variablesModel -> crops_farms_id = $crop_id;
    //         $variablesModel -> last_production_datas_id = $productionId;
    //       //   seeds
        
    //         $variablesModel -> seed_name = $crop['variables']['seed_name'];
    //         $variablesModel -> unit = $crop['variables']['unit'];
    //         $variablesModel -> quantity = $crop['variables']['quantity'];
    //         $variablesModel -> unit_price = $crop['variables']['unit_price_seed'];
    //         $variablesModel -> total_seed_cost = $crop['variables']['total_seed_cost'];
  
    //          //   seeds
    //          $variablesModel -> labor_no_of_person = $crop['variables']['no_of_person'];
    //          $variablesModel -> rate_per_person = $crop['variables']['rate_per_person'];
    //          $variablesModel -> total_labor_cost = $crop['variables']['total_labor_cost'];
  
    //           // fertilizer
    //          $variablesModel -> name_of_fertilizer = $crop['variables']['name_of_fertilizer'];
    //          $variablesModel -> type_of_fertilizer = $crop['variables']['total_seed_cost'];
    //          $variablesModel -> no_of_sacks = $crop['variables']['no_ofsacks'];
    //          $variablesModel -> unit_price_per_sacks = $crop['variables']['unitprice_per_sacks'];
    //          $variablesModel -> total_cost_fertilizers = $crop['variables']['total_cost_fertilizers'];
  
    //            //pesticides
    //            $variablesModel -> pesticide_name = $crop['variables']['pesticides_name'];
    //           //  $variablesModel ->	type_of_pesticides = $crop['variables']['no_of_l_kg'];2
    //            $variablesModel -> no_of_l_kg = $crop['variables']['no_of_l_kg'];
    //            $variablesModel -> unit_price_of_pesticides = $crop['variables']['unitprice_ofpesticides'];
    //            $variablesModel -> total_cost_pesticides = $crop['variables']['total_cost_pesticides'];
           
    //             //transportation
    //             $variablesModel -> name_of_vehicle = $crop['variables']['type_of_vehicle'];
               
    //             $variablesModel -> total_transport_delivery_cost = $crop['variables']['total_seed_cost'];
             
    //             $variablesModel -> total_machinery_fuel_cost= $crop['variables']['total_machinery_fuel_cost'];
    //             $variablesModel -> total_variable_cost= $crop['variables']['total_variable_costs'];
    //             $variablesModel -> save();
       
            //     return $request;
            //   }
  
     
  
  
  
  
  
  
        // Return success message
        return [
            'success' => "Successfull Farmers info updated" // Corrected the syntax here
        ];
    }
  
// public function test(Request $request)
// {
//     // Extract farmer data from the request
//     $farmerdata = $request->farmer;

//     // Check for existing record
//     $existingFarmer = PersonalInformations::where('last_name', $farmerdata['last_name'])
//         ->where('first_name', $farmerdata['first_name'])
//         ->where('mothers_maiden_name', $farmerdata['mothers_maiden_name'])
//         ->where('date_of_birth', $farmerdata['date_of_birth'])
//         ->first();

//         if ($existingFarmer) {
//             return response()->json([
//                 'error' => 'A record with this last name, first name, mother\'s maiden name, and date of birth already exists.'
//             ], 400); // Send a 400 Bad Request status code
//         }

//     // Proceed with saving farmer data
//     $farmerModel = new PersonalInformations();
//     $farmerModel->users_id = $farmerdata['users_id'];
//     $farmerModel->first_name = $farmerdata['first_name'];
//     $farmerModel->middle_name = $farmerdata['middle_name'];
//     $farmerModel->last_name = $farmerdata['last_name'];
//     $farmerModel->extension_name = $farmerdata['extension_name'];
//     $farmerModel->country = $farmerdata['country'];
//     $farmerModel->province = $farmerdata['province'];
//     $farmerModel->city = $farmerdata['city'];
//     $farmerModel->district = $farmerdata['agri_district'];
//     $farmerModel->barangay = $farmerdata['barangay'];
//     $farmerModel->street = $farmerdata['street'];
//     $farmerModel->zip_code = $farmerdata['zip_code'];
//     $farmerModel->sex = $farmerdata['sex'];
//     $farmerModel->religion = $farmerdata['religion'];
//     $farmerModel->date_of_birth = $farmerdata['date_of_birth'];
//     $farmerModel->place_of_birth = $farmerdata['place_of_birth'];
//     $farmerModel->contact_no = $farmerdata['contact_no'];
//     $farmerModel->civil_status = $farmerdata['civil_status'];
//     $farmerModel->name_legal_spouse = $farmerdata['name_legal_spouse'];
//     $farmerModel->no_of_children = $farmerdata['no_of_children'];
//     $farmerModel->mothers_maiden_name = $farmerdata['mothers_maiden_name'];
//     $farmerModel->highest_formal_education = $farmerdata['highest_formal_education'];
//     $farmerModel->person_with_disability = $farmerdata['person_with_disability'];
//     $farmerModel->pwd_id_no = $farmerdata['YEspwd_id_no'];
//     $farmerModel->government_issued_id = $farmerdata['government_issued_id'];
//     $farmerModel->id_type = $farmerdata['id_type'];
//     // $farmerModel->gov_id_no = $farmerdata['gov_id_no'];
//     $farmerModel->member_ofany_farmers_ass_org_coop = $farmerdata['member_ofany_farmers'];
//     $farmerModel->nameof_farmers_ass_org_coop = $farmerdata['nameof_farmers'];
//     $farmerModel->name_contact_person = $farmerdata['name_contact_person'];
//     $farmerModel->cp_tel_no = $farmerdata['cp_tel_no'];
//     $farmerModel->date_interview= $farmerdata['date_of_interviewed'];
//     $farmerModel->save();

//     // VARIABLES
//     $farmer_id = $farmerModel->id;
//     // VARIABLES

//     // Farm info
//     $farms = $request->farm;
//     $farmModel = new FarmProfile();

//     $farmModel->users_id = $farmerModel->users_id;
//     $farmModel->agri_districts_id = 1; // Adjust as needed
//     $farmModel->personal_informations_id = $farmer_id;

//     $farmModel->tenurial_status = $farms['tenurial_status'];
//     $farmModel->farm_address = $farms['farm_address'];
//     $farmModel->no_of_years_as_farmers = $farms['no_of_years_as_farmers'];
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
//     $farmModel->oca_district_office = $farmerModel->district;
//     $farmModel->name_of_field_officer_technician = $farms['name_technicians'];
//     $farmModel->date_interviewed = $farms['date_interview'];

//     $farmModel->save();

//     // VARIABLES
//     $farm_id = $farmModel->id;
//     $users_id = $farmerModel->users_id;
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
//         $fixedcostModel->labor = $crop['fixedCost']['labor'];
//         $fixedcostModel->fertilizer = $crop['fixedCost']['fertilizer'];
//         $fixedcostModel->pesticides = $crop['fixedCost']['pesticides'];
//         $fixedcostModel->irrigation = $crop['fixedCost']['irrigation'];
//         $fixedcostModel->other = $crop['fixedCost']['other'];
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
//         return $request;
//     }

//     return response()->json([
//         'success' => 'Data saved successfully!'
//     ]);
// }



}


