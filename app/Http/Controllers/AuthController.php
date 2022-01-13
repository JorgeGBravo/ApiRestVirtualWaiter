<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only(strtolower('email'), 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where('email', strtolower($request['email']))->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], 200);
    }

    public function changePassword(Request $request)
    {
        $user = User::where('email', '=', strtolower($request->input('email')))
            ->where('id', '=', Auth::id())
            ->get();
        if (count($user) != 0) {
            $user[0]->password = Hash::make($request->input('newPassword'));
            $user[0]->save();
            return response()->json(['message' => 'Updated Password'], 200);
        }
        return response()->json(['message' => 'You are not a registered user'], 403);
    }



}
