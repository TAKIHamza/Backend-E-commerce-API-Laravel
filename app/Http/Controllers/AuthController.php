<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Command;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'client',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
    
    function users(Request $request)
    {
    $user = Auth::user();
    //Check if the user making the request is an admin
    if ($user->role!="admin") {
        return response()->json(['message' => 'Access denied. Only admins can send users.'], 403);
    }

    // If the user is an admin, proceed to send the users
    $users = User::all();

    return response()->json(['users' => $users],200);
    }

    function changeUserRole(Request $request)
    {
        $user = Auth::user();
        //Check if the user making the request is an admin
        if ($user->role!="admin") {
            return response()->json(['message' => 'Access denied.'], 403);
        }

    // Find the user by ID
    $user = User::find($request->id);

    // Check if the user exists
    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    // Update the user's role
    $newRole = $request->input('role');
    $user->role = $newRole;
    $user->save();

    return response()->json(['message' => 'User role updated successfully.' ],200);
    }
    
    function deleteUser(Request $request)
{
       $user = Auth::user();
        //Check if the user making the request is an admin
        if ($user->role!="admin") {
            return response()->json(['message' => 'Access denied.'], 403);
        }
    // Find the user by ID
    $user = User::find($request->id);

    // Check if the user exists
    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    // Delete the user
    $user->delete();

    return response()->json(['message' => 'User deleted successfully.'],200);
}

}
        