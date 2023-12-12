<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{



  




    public function login()
    {
        return view('auth.login');
    }  
    public function home(){

        return view('admin.userhome');
    }
    public function adminhome(){

        return view('admin.adminhome');
    }
      

    public function loginpost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            if(Auth()->user()->usertype=='admin'){

                return redirect()->route('admin.home');
            }else{

                return redirect()->route('user.home');
            }

        }else{
            return redirect("login")->withSuccess('Login details are not valid');

        }
           
                       
        }
  
       
    



    public function register()
    {
        return view('auth.register');
    }
      

    public function registration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return back()->with('success','registered successfully');
    }


    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    
    

    // public function dashboard()
    // {
    //     if(Auth::check()){
    //         return view('admin.home');
    //     }
  
    //     return redirect("login")->withSuccess('You are not allowed to access');
    // }
    

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}