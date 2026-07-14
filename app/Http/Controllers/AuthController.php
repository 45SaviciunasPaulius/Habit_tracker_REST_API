<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request){
         $validated = $request->validated();

          $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json(['message' => 'Bad credentials'], 401);
            }

         $token = $user->createToken($user->name)->plainTextToken;

         return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();    

       $user = User::create([
            'name' => $validated['name'], 
            'email' => $validated['email'], 
            'password' => $validated['password'], 
        ]);

        $token = $user->createToken($validated['name'])->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function logout(){

        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => "Successfully logged out"], 200);
    }
}
