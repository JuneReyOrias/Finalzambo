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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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

                
                    // Handle the 'fixedData' request type for fetchingMachineriesUseds data
                    if ($type === 'personalinfos') {
                        $personalinfos = PersonalInformations::find($id); // Find the fixed cost data by ID
                        if ($personalinfos) {
                            return response()->json($personalinfos); // Return the data as JSON
                        } else {
                            return response()->json(['error' => 'farm data not found.'], 404);
                        }
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
//         public function  productionview (Request $request, $id)
// {
//     // Check if the user is authenticated
//     if (Auth::check()) {
//         // User is authenticated, proceed with retrieving the user's ID
//         $userId = Auth::id();

//         // Find the user based on the retrieved ID
//         $admin = User::find($userId);

//         if ($admin) {
//             // Assuming $user represents the currently logged-in user
//             $user = auth()->user();

//             // Check if user is authenticated before proceeding
//             if (!$user) {
//                 // Handle unauthenticated user, for example, redirect them to login
//                 return redirect()->route('login');
//             }

//             // Find the user's personal information by their ID
//             $profile = PersonalInformations::where('users_id', $userId)->latest()->first();

//             // Fetch the farm ID associated with the user
//             $farmId = $user->farm_id;
//             $agri_district = $user->agri_district;
//             $agri_districts_id = $user->agri_districts_id;

//                     // Find the farm profile using the fetched farm ID
//                     $farmProfile = FarmProfile::where('id', $farmId)->latest()->first();
//                     $farmData = FarmProfile::find($id);
//                 // Fetch farmer's information based on ID
//                 $cropData = Crop::find($id);


//                   // Fetch the LastProductionDatas using crops_farms_id
//             $lastProductionDatas = LastProductionDatas::where('crops_farms_id', $id)->get();

//             // Initialize array to hold the personal information records
//             $personalInfos = collect();

//             foreach ($lastProductionDatas as $data) {
//                 // Fetch the related CropFarm
//                 $cropFarm = $data->cropFarm;

//                 if ($cropFarm) {
//                     // Fetch the related FarmProfile
//                     $farmProfile = $cropFarm->farmProfile;

//                     if ($farmProfile) {
//                         // Fetch the related PersonalInformations
//                         $personalInfo = $farmProfile->personalInformation;

//                         if ($personalInfo) {
//                             $personalInfos->push($personalInfo);
//                         }
//                     }
//                 }
//             }

//             // Remove duplicate personal information records
//             $personalInfos = $personalInfos->unique('id');

//                 $cropName = $request->input('crop_name');

                
            
//                 //  Fetch all crop data or filter based on the selected crop name
//                  if ($cropName && $cropName != 'All') {
//                     $cropData = Crop::where('farm_profiles_id', $id)
//                                     ->where('crop_name', $cropName)
                                    
//                                     ->get();
//                 } else {
//                     $cropData = Crop::where('farm_profiles_id', $id)
//                                     ->with( 'farmprofile')
//                                     ->get();
//                 }
//                 $productionData = LastProductionDatas::where('crops_farms_id', $id)
//                                                 ->with('crop')
//                                                 ->get();
           
               
//                 // fixed cost
//                 $FixedData = FixedCost::where('last_production_datas_id', $id)
           
//                 ->get();

//                 $machineriesData =MachineriesUseds::where('last_production_datas_id', $id)
           
//                 ->get();
//                 $variableData =VariableCost::where('last_production_datas_id', $id)
           
//                 ->get();
      

            
//             $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
//             // Return the view with the fetched data
//             return view('admin.farmersdata.production', compact('admin', 'profile', 'farmProfile','totalRiceProduction'
//             ,'userId','agri_district','agri_districts_id','cropData','id','productionData','FixedData'
//             ,'farmData','machineriesData','variableData','personalInfos'
//             ));
//         } else {
//             // Handle the case where the user is not found
//             // You can redirect the user or display an error message
//             return redirect()->route('login')->with('error', 'User not found.');
//         }
//     } else {
//         // Handle the case where the user is not authenticated
//         // Redirect the user to the login page
//         return redirect()->route('login');
//     }
// }
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


// add new production if empty
  
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
   
      
          
        $production = $request->productions;  // Assuming 'production' is a field in the request
        // return $production;
    //  dd($production);
        
                 $productionModel = new LastProductionDatas();
              //    $productionModel -> users_id = $users_id;
              //    $productionModel -> farm_profiles_id =  $cropModel -> farm_profiles_id;
                 $productionModel -> crops_farms_id = $production['crops_farms_id'];
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
             return [
                 'success' => "Saved to database" // Corrected the syntax here
             ];
         }  


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
    

        // admin fixed cost 

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
        return redirect()->back()->with('message', 'Something went wrong');
    }  
    } 

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
  




}


