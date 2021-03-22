<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastName'=>['required','string','max:255'],
            'username'=>['required','string','max:255' ,'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address'=>['required'],
            'contact'=>['required','numeric','min:8','unique:users'],
            'dob'=> ['required'],
            'status'=>['required','string','max:7'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $statusInput=$data['status'];
        if($statusInput== "Admin"){
            $status=1;
        }else if($statusInput== "Employee"){
            $status=2;
        }else if($statusInput== "HOD"){
            $status=3;
        }
        return User::create([
            'name' => $data['name'],
            'lastName'=> $data['lastName'],
            'username'=> $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'address' => $data['address'],
            'contact'=> $data['contact'], //Carbon::parse($value)->format('m/d/Y');
            $dateOb=$data['dob'],
            'dob'=>Carbon::parse($dateOb)->format('Y/m/d'),
            'status'=> $status,
            'role_id'=>$status,
        ]);
    }
}
