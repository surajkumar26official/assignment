<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|string|in:SuperAdmin,Admin,Member,Sales,Manager,Engineer',
                'company_name' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ]);
        }

        $inviter = auth('sanctum')->user();
        if (!$inviter || !$inviter->hasAnyRole(['SuperAdmin', 'Admin'])) {
            return response()->json([
                'status' => false,
                'error' => 'Only SuperAdmin or Admin can invite users'
            ]);
        }

        $role = $request->role;
        $companyName = $request->company_name;

        if ($inviter->hasRole('Admin')) {
            $companyId = $inviter->company_id;
            $company = $inviter->company;
        } else {
            $companyId = $inviter->company_id;
            $company = $inviter->company;

            if ($companyName) {
                $company = Companies::where('name', $companyName)->first();

                if (!$company) {
                    $company = Companies::create(['name' => $companyName]);
                }
                $companyId = $company->id;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'company_id' => $companyId,
        ]);

        $user->assignRole($role);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user->load('company'),
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('company');
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user->load('company'),
            'roles' => $user->getRoleNames(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
