<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\Categorize;
use App\Models\CropCategory;
use App\Models\FarmProfile;
use App\Models\LastProductionDatas;
use App\Models\PersonalInformations;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class CropCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    public function CropCategory()
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
                return view('crop_category.crop_create', compact('userId','admin','totalRiceProduction'));
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
    public function Cropping()
    {
        $cropcat = CropCategory::all();
     return view('crops.crops_create',compact('cropcat'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        
          
            $addCrop= new CropCategory();
            $addCrop->users_id = $request->users_id;
            // $addCrop->crop_name =$request->crop_name;
            if ($request->crop_name === 'Add') {
                $addCrop->crop_name = $request->new_crop_name; // Use the value entered in the "add_extenstion name" input field
           } else {
                $addCrop->crop_name = $request->crop_name; // Use the selected color from the dropdown
           }
            // $addCrop->type_of_variety =$request->type_of_variety;
        
            // $addCrop->altitude =$request->altitude;
            // dd($addCrop);
            $addCrop->save();
            return redirect('/admin-add-new-crop')->with('message','Crop Category added successsfully');
        
        }
        catch(\Exception $ex){
            dd($ex); // Debugging statement to inspect the exception
            return redirect('/admin-add-new-crop')->with('message','Someting went wrong');
            
        }   
    }

    
    public function editcrop($id){
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
        $cropsEdit= CropCategory::find($id);
    
        $crop= CropCategory::all();
        
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        // Return the view with the fetched data
        return view('crop_category.crop_edit', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
        ,'userId','cropsEdit','crop'));
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

    public function Updatecrops(Request $request,$id){
        try {
                
            $variety = CropCategory::find($id);
            $variety->users_id = $request['users_id'];
            if ($request->crop_name === 'Add') {
                $variety->crop_name = $request->new_crop_name; // Use the value entered in the "add_extenstion name" input field
           } else {
                $variety->crop_name = $request->crop_name; // Use the selected color from the dropdown
           }
            // $variety->variety_name = $request['variety_name'];
          
            // dd($variety);
            $variety->save();
            
            return redirect('/admin-view-polygon')->with('message', 'Crop update successfully');
        } catch(\Exception $ex) {
            // dd($ex);
            return redirect('/admin-edit-new-crop/{cropsEdit}')->with('message', 'Something went wrong');
        }
    
    
     }
     public function Deletecategory($id) {
        try {
            // Find the personal information by ID
            $variety =CropCategory::find($id);
    
            // Check if the personal information exists
            if (!$variety) {
                return redirect()->back()->with('error', 'Variety not found');
            }
    
            // Delete the personal information data from the database
            $variety->delete();
    
            // Redirect back with success message
            return redirect()->back()->with('message', 'Variety deleted successfully');
    
        } catch (\Exception $e) {
            // Handle any exceptions and redirect back with error message
            return redirect()->back()->with('error', 'Error deleting Variety: ' . $e->getMessage());
        }
    }
}
