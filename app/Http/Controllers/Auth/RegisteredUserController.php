<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

     public function store(RegisterRequest $request): RedirectResponse
     { 
         try {
             // Fetch validated data directly into $data
             $data = $request->validated();
             
             $user = new User;
            
             $user->first_name = $request['first_name'];
             $user->last_name = $request['last_name'];
             $user->email = $request['email'];
             $user->district = $request['district'];
             $user->password = bcrypt($request['password']); // Hash the password for security
            //  $user->role = $request['role'];
            //  dd($user);
             $user->save();
             
             return redirect('/login')->with('message', 'Registered successfully');
         } catch(\Exception $ex) {
            //  dd($ex);
             return redirect('/register')->with('message', 'Something went wrong');
         }
     }
     
}
