<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
        
        return response($user->createToken($request->name)->plainTextToken, 200)
        ->header('Content-Type', 'text/plain');

    }
}
