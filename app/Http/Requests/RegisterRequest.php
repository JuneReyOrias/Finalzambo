<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rule= [
       
            'first_name'=>[
                'required',
                'string',
                'max:50',
            ],
            'last_name'=>[
                'required',
                'string',
                'max:50',
            ],
            'email'=>[
                'required',
                'string',
                'max:150',
                'unique:'.User::class,
            ],
            
            'district'=>[
                'required',
                'string',
                'max:50',
            ],
            'password'=>[
                'required',
                'string',
                'max:20',
                
            ],
           
           
        ];
        return $rule;
    }
    public function messages(){
       return [
            'first_name.required'=>'Please input your firstname',
            'last_name.required'=>'Please input your lastname',
            'email.required'=>'Please input your email',
            'agri_district.required'=>'Please choose your agri_district you belong',
            'password.required'=>'Please input your password',
           
            
       ];
    
    }
}


