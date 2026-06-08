<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {

            $validated = $request->validate([
                'email'    => 'required|email',
                'password' => 'required'
            ]);

            if (!Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password']
            ])) {

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'  => true,
                'message' => 'Login successful',
                'token'   => $token,
                'user'    => $user
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {

            return response()->json([
                'status' => true,
                'user' => $request->user()
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Unable to fetch profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {

            $validated = $request->validate([
                'current_password'          => 'required|string',
                'new_password'              => 'required|string|min:8|different:current_password|confirmed',
            ]);

            $user = $request->user();

            if (! Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Current password is incorrect',
                ], 422);
            }

            $user->password = $validated['new_password'];
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'Password changed successfully',
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => 'Failed to change password',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logout successful'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkAuth(Request $request)
    {
    if ($request->user()) {
        return response()->json([
            'status' => true,
            'message' => 'User is logged in',
            'user' => $request->user()
        ], 200);
    }

    return response()->json([
        'status' => false,
        'message' => 'User is not authenticated'
    ], 401);
    }
}