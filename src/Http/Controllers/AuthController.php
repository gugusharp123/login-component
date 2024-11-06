<?php

namespace Avalon\LrvLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Avalon\LrvLogin\Services\EmailService;

class AuthController
{
    /**
     * Show the registration form
     * 
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('lrv_login::auth.register');
    }

    /**
     * Handle the user registration process
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 200);
    }

    /**
     * Show the login form
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showLoginForm()
    {
        if(!Auth::check()){
            return view('lrv_login::auth.login');
        }else{
            return response()->json(['message' => 'User Already Logged In'], 201);
        }
    }

    /**
     * Handle user login
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['message' => 'User Logged In successfully'], 201);
    }

    /**
     * Logout the user and redirect to login page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Show the forgot password form
     * 
     * @return \Illuminate\View\View
     */
    public function forgotPasswordForm(Request $request)
    {
        return view('lrv_login::auth.forgot-password');
    }

    /**
     * Handle the forgot password process
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $verificationCode = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT); // code for email verification
        $user->update(['remember_token' => $verificationCode]);

        // return response()->json(['message' => 'Verification Code sent to your email']);
        return redirect()->route('reset-password');
    }

    /**
     * Handle the password reset process
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($request->verificationCode == $user->remember_token) {
            $user->update(['password' => $request->password, 'remember_token' => null]);
            return response()->json(['message' => 'Passwords changed successfully'], 404);
        } else {
            // invalid Verification Code
            return response()->json(['message' => 'Incorrect Verification Code'], 404);
        }
    }
}
