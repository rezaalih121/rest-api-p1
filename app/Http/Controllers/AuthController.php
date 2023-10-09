<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = \App\Models\User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return $this->success(
            $response 
        );
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string:users,email',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where( 'email' ,$fields['email'])->first();

        // Check Password
        if(!$user || !Hash::check($fields['password'] , $user->password)){
            return response(
                [
                    'message' => 'Bad credits' 
                ] , 401
                );
        }

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return $this->success(
            $response 
        );
    }

    public function logout(Request $request){
        
        auth()->user()->tokens()->delete();

        Auth::user()->currentAccessToken()->delete();
        return $this->success(
            'Logged out',
            'Logged out'
        );

    }
}
