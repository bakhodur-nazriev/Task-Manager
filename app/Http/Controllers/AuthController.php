<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'patronymic' => 'string|max:255|nullable',
            'gender' => 'required|in:male,female',
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'gender' => $request->gender,
            'login' => $request->login,
            'email' => $request->email,
            'pasword' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();

        Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user->login, $request->password));

        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(Request $request) {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('login', 'password');

        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('LaravelPassportAuth')->accessToken;

            return response()->json(['token' => '$token'], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function userInfo(Request $request) {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request) {
        $user = $request->user();
        $user->update($request->all());

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
