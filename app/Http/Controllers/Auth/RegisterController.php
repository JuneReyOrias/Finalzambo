<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Agent;
use App\Notifications\NewRegisteredFarmer;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    
    public function CreateFarmer()
    {
        return view('admin.create_account.farmer.new_farmer');
    }

    // public function register(Request $request)
    // {
    //     // $request->validate([
    //     //     'first_name' => 'required|string|max:255',
    //     //     'last_name' => 'required|string|max:255',
    //     //     'email' => 'required|string|email|max:255|unique:users|unique:admins|unique:agents',
    //     //     'password' => 'required|string|min:8|confirmed',
    //     //     'role' => 'required|in:user,admin,agent',
    //     // ]);

    //     switch ($request->role) {
    //         case 'user':
    //             User::create([
    //                 'first_name' => $request->first_name,
    //                 'last_name' => $request->last_name,
    //                 'email' => $request->email,
    //                 'password' => Hash::make($request->password),
    //             ]);
    //             break;

    //         case 'admin':
    //             Admin::create([
    //                 'first_name' => $request->first_name,
    //                 'last_name' => $request->last_name,
    //                 'email' => $request->email,
    //                 'password' => Hash::make($request->password),
    //             ]);
    //             break;

    //         case 'agent':
    //             Agent::create([
    //                 'first_name' => $request->first_name,
    //                 'last_name' => $request->last_name,
    //                 'email' => $request->email,
    //                 'password' => Hash::make($request->password),
    //             ]);
    //             break;
    //     }

    //     return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
    // }

    public function Farmer(RegisterRequest $request): RedirectResponse
     { 
         try {
             // Fetch validated data directly into $data
            //  $data = $request->validated();
             
             $farmer = new Farmer;
             $farmer->users_id = 1;
             $farmer->first_name = $request['first_name'];
             $farmer->last_name = $request['last_name'];
             $farmer->email = $request['email'];
             $farmer->district = $request['district'];
             $farmer->password = bcrypt($request['password']); // Hash the password for security
            //  $farmer->role = $request['role'];
            //  dd($farmer);
             $farmer->save();
             $user = $farmer->user; // Access the user through the relationship
             if ($user) {
                 $user->notify(new NewRegisteredFarmer($farmer));
             } else {
                 return response()->json([
                     'success' => false,
                     'message' => 'User not found for the specified crop location.',
                 ], 404);
             }
             return redirect('/Create-Account')->with('message', 'Registered successfully');
         } catch(\Exception $ex) {
             dd($ex);
             return redirect('/Create-Account')->with('message', 'Something went wrong');
         }
     }

}
