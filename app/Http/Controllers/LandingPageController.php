<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Http\Requests\ParcellaryBoundariesRequest;
use App\Http\Requests\RegisterRequest;

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

use Illuminate\Support\Facades\DB;
class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function LandingPage()
    {
      
        return view('landing-page.page');
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
        $page->home_logo = $request['home_logo'];
               
        $page->home_imageslider = $request['home_imageslider'];
        $page->feature_header = $request['feature_header'];
        $page->feature_description = $request['feature_description'];
        $page->agri_features = $request['agri_features'];
        $page->agri_description = $request['agri_description'];
      
        // dd($page);
        $page->save();
        
        return redirect('/admin-view-homepage-setting')->with('message', 'homepage added successfully');
    } catch(\Exception $ex) {
        dd($ex);
        return redirect('/admin-add-homepage')->with('message', 'Something went wrong');
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
            $page->home_logo = $request['home_logo'];
                   
            $page->home_imageslider = $request['home_imageslider'];
            $page->feature_header = $request['feature_header'];
            $page->feature_description = $request['feature_description'];
            $page->agri_features = $request['agri_features'];
            $page->agri_description = $request['agri_description'];
          
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

    
}
