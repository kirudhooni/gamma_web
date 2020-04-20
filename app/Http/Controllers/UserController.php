<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        
        // return response($user->createToken($request->name)->plainTextToken, 200)
        // ->header('Content-Type', 'text/plain');

        return response()->json([
            "user" => $user,
            "token" => $user->createToken($request->name)->plainTextToken,
        ], 200);

    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

       if (Auth::attempt($request->only('email', 'password'))){
           return response()->json(Auth::user(), 200);
       }
       throw ValidationException::withMessages([
           'email' => ['The provided credentials are incorrect']
       ]);

    }
}
