<?php

namespace App\Http\Controllers;
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
use App\Models\Notification;
use App\Models\Transport;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
       // view farmers org access by admin


     
    public function addnotification(){
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
        $notif=Notification::orderBy('id','asc')->paginate(5);
    
    
        
        $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
        // Return the view with the fetched data
        return view('admin.notification.view_notif', compact('userId','admin', 'profile', 'farmProfile','totalRiceProduction'
        ,'userId','notif'));
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
        // view farmers org form access by admin


        public function Message()
        {
            // Check if the user is authenticated
            if (Auth::check()) {
                // User is authenticated, proceed with retrieving the user's ID
                $userId = Auth::id();
                
                // Find the authenticated user (admin)
                $admin = User::find($userId);
                
                if ($admin) {
                    // Fetch the currently authenticated user
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
                
                    // Fetch the total rice production data
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    
                    // Fetch the role of the current user
                    $userRole = $user->role;
                    
                    // Fetch all users with the role 'agent'
                    $agents = User::where('role', 'agent')->get();
                    
                    // Fetch all users with the role 'user'
                    $regularUsers = User::where('role', 'user')->get();
                    
                    // Fetch all users with the role 'admin'
                    $admins = User::where('role', 'admin')->get();
        
                    // Return the view with the fetched data
                    return view('admin.notification.add_notif', compact(
                        'userId', 
                        'admin', 
                        'profile', 
                        'farmProfile', 
                        'totalRiceProduction', 
                        'userRole', 
                        'agents', 
                        'regularUsers', // Passing regular users
                        'admins' // Passing admins
                    ));
                } else {
                    return redirect()->route('login')->with('error', 'User not found.');
                }
            } else {
                // Handle the case where the user is not authenticated
                return redirect()->route('login');
            }
        }
        

        public function Messagestore(Request $request)
        { 
            try {
            
                $message = new Notification;
               
                $message->sender_id = $request['sender_id'];
                $message->receiver_id = $request['receiver_id'];
                $message->message = $request['message'];
              
                // dd($message);
                $message->save();
                
                return redirect('/admin-view-notification')->with('message', 'message send successfully');
            } catch(\Exception $ex) {
                dd($ex);
                return redirect('/admin-add-notification')->with('message', 'Something went wrong');
            }
        }

        public function NotifEdit(Request $request, $id)
        {
            // Check if the user is authenticated
            if (Auth::check()) {
                // User is authenticated, proceed with retrieving the user's ID
                $userId = Auth::id();
                
                // Find the authenticated user (admin)
                $admin = User::find($userId);
                
                if ($admin) {
                    // Fetch the currently authenticated user
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
                
                    // Fetch the total rice production data
                    $totalRiceProduction = LastProductionDatas::sum('yield_tons_per_kg');
                    
                    // Fetch the role of the current user
                    $userRole = $user->role;
                    
                    // Fetch all users with the role 'agent'
                    $agents = User::where('role', 'agent')->get();
                    
                    // Fetch all users with the role 'user'
                    $regularUsers = User::where('role', 'user')->get();
                    $notif= Notification::find($id);
                    // Fetch all users with the role 'admin'
                    $admins = User::where('role', 'admin')->get();
        
                    // Return the view with the fetched data
                    return view('admin.notification.edit_notif', compact(
                        'userId', 
                        'admin', 
                        'profile', 
                        'farmProfile', 
                        'totalRiceProduction', 
                        'userRole', 
                        'agents', 
                        'regularUsers', // Passing regular users
                        'admins', // Passing admins
                        'notif'

                    ));
                } else {
                    return redirect()->route('login')->with('error', 'User not found.');
                }
            } else {
                // Handle the case where the user is not authenticated
                return redirect()->route('login');
            }
        }

        public function MessageUpdate(Request $request,$id)
        { 
            try {
            
                $message =Notification::find($id);
                $message->users_id = $request['users_id'];
                $message->sender_id = $request['sender_id'];
                $message->receiver_id = $request['receiver_id'];
                $message->message = $request['message'];
              
                // dd($message);
                $message->save();
                
                return redirect('/admin-view-notification')->with('message', 'notification updated successfully');
            } catch(\Exception $ex) {
                dd($ex);
                return redirect('/admin-add-notification')->with('message', 'Something went wrong');
            }
        }

        public function DeleteNotif($id) {
            try {
                // Find the personal information by ID
                $notif = Notification::find($id);
        
                // Check if the personal information exists
                if (!$notif) {
                    return redirect()->back()->with('error', 'Notification not found');
                }
        
                // Delete the personal information data from the database
                $notif->delete();
        
                // Redirect back with success message
                return redirect()->back()->with('message', 'Notification deleted successfully');
        
            } catch (\Exception $e) {
                // Handle any exceptions and redirect back with error message
                return redirect()->back()->with('error', 'Error deleting Notification: ' . $e->getMessage());
            }
        }

}
