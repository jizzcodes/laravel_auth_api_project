<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use JWTAuth;

use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller



{

    public function __construct()
    {
        $this->middleware('throttle:api');
    }
    
    public function register(Request $request)
    {

       $validator =  Validator::make($request->all(),[

          'name'=>'required|string|min:2|max:100',
          'email'=>'required|string|email|max:100|unique:users',
          'password'=>'required|string|min:6|confirmed'
     
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(),400);
        }
    
       $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)

        ]);

        return response()->json([

            'message'=>'user registered succesfully',
            'user'=>$user

        ]);
    }


    //login controller

    public function loginuser(Request $request)
    {
        $validator =  Validator::make($request->all(),[
        'email'=>'required|string|email|max:100',
        'password'=>'required|string|min:6',
   
      ]);

      if($validator->fails())
      {
          return response()->json($validator->errors(),400);
      }

      if(!$token = Auth()->attempt($validator->validated()))
      {
         return response()->json([

            'error'=>'UnAuthorised'

         ]);
      }
      return $this->respondWithToken($token);

        
    }

    protected function respondWithToken($token)
    {
     

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60
            // 'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);

      
    }



    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }






    public function user(Request $request)
    {
        return response()->json(auth()->user());
    }


    public function userlist(Request $request)
    {
        $users = User::all();
        return response()->json(['users'=>$users],200);
    }



}

