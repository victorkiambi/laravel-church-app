<?php

namespace App\Http\Controllers;

use App\DTO\AppUserDTO;
use App\Models\AppUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register a new user
    public function register(Request $request): JsonResponse
    {
        //Validate the incoming request using the already included validator method
        $request->validate([
            'username' => 'required|string|unique:app_users',
            'email' => 'required|email|unique:app_users',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string'
        ]);


        $registeredUser = AppUser::where('email', $request->email)->first();
        if ($registeredUser) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user already exists'
            ], 409);
        }
        //Create the user
        $appUser = new AppUser([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        ]);

        if ($appUser->save()) {
            $tokenResult = $appUser->createToken('authToken')->plainTextToken;

            $appUserDTO = new AppUserDTO($appUser->id, $appUser->username, $appUser->email, $appUser->first_name, $appUser->last_name);
            //If the user is created successfully, return the json response
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $appUserDTO,
                'token' => $tokenResult
            ], 201);
        } else {
            //Else, return an error response
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user could not be created'
            ], 500);
        }
    }

    //Login a registered user
    public function login(Request $request): JsonResponse
    {
        //Validate the incoming request using the already included validator method
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $appUser = AppUser::where('email', $request->email)->first();
        if(!$appUser || !Hash::check($request->password, $appUser->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

            //If login is successful, create a token for the user
            $tokenResult = $appUser->createToken('authToken')->plainTextToken;
            $appUserDTO = new AppUserDTO($appUser->id, $appUser->username, $appUser->email, $appUser->first_name, $appUser->last_name);

            //Return a json response with the user data and token
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => $appUserDTO,
                'token' => $tokenResult
            ], 200);

    }

    //Get authenticated user
    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    //Logout user
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ], 200);
    }
}
