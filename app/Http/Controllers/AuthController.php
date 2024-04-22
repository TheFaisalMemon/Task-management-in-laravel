<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function Authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes())
        {
            $arrayData = array(
                'email' => $request->email,
                'password' => $request->password
            );
            if(Auth::guard('user')->attempt($arrayData))
            {
                return redirect()->route('pages.dashboard');
            }
            else
            {
                return redirect()->route('login')->withInput()->with('error','Invalid Email Address or Password');
            }
        }
        else
        {
            return redirect()->route("login")->withInput()->withErrors($validator);
        }
    }

    public function register()
    {
        return view('register');
    }

    public function registerProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'email' => 'required|email|unique:users',
           'password' => 'required|confirmed'
        ]);

        if($validator->passes())
        {
            $user = new User();
            $user->name = 'Ahmed Khan';
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'student';
            $user->save();

            return redirect()->route('login')->with('success','Student Registered Successfully');
        }
        else
        {
            return redirect()->route('register')->withInput()->withErrors($validator);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
