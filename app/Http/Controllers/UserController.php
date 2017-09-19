<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    public function signup(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        $user= new User();
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->password=bcrypt($request->input('password'));
        $user->phone=$request->input('phone');
        $user->location=$request->input('location');


        $user->save();
        return response()->json(['message'=>'user created!'],201);
    }

    public function signin(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $credentials=$request->only('email','password');
        try{
            if(!$token=JWTAuth::attempt($credentials)){
                return response()->json([
                    'error'=>'invalid credentials'
                ],401);
            }
        }catch(JWTException $e){
            return response()->json([
                'error'=>'Couldn t create a token'
            ]);
        }
        return response()->json([
            'token'=>$token],201);
    }


}
