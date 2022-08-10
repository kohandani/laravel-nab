<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|string",
            "c_password" => "required|same:password",
        ]);

        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return $this->yresp([
            "user" =>  $user,
            "token" => $token 
        ],201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|string",
        ]);

        if($validator->fails()){
            return $this->nresp($validator->messages(),500);
        }

        $user = User::where('email' , $request->email)->first();
        if(!$user) {
            return $this->nresp("There is no user with this email",401);
        }
        if(!Hash::check($request->password,$user->password)) {
            return $this->nresp("Password is Wrong",401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return $this->yresp([
            "user" =>  $user,
            "token" => $token 
        ],200);
    }
    public function logout() {
        auth()->user()->tokens()->delete();
        return $this->yresp("You are logged out",200);
    }
}
