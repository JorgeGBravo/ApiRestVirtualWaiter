<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerUserManager(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cif' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'gender' => 'string|max:255',
            'birthdate' => 'string|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->getMessageBag()->first()], 400);
        }

        $user = User::create([
            'name' => strtolower($request->input('name')),
            'surname' => strtolower($request->input('surname')),
            'cif' => strtolower($request->input('cif')),
            'address' => strtolower($request->input('address')),
            'province' => strtolower($request->input('province')),
            'country' => strtolower($request->input('country')),
            'zipcode' => strtolower($request->input('zipcode')),
            'gender' => strtolower($request->input('gender')),
            'birthdate' => strtolower($request->input('birthdate')),
            'phone' => strtolower($request->input('phone')),
            'email' => strtolower($request->input('email')),
            'password' => Hash::make($request->input('password')),
            'isAdmin' => 1,
        ]);
        return response()->json($user, 200);
    }



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
            if ($user[0]->email === strtolower($request->input('email')))
            {
                $user[0]->password = Hash::make($request->input('newPassword'));
                $user[0]->save();
                return response()->json(['message' => 'Updated Password'], 200);
            }
        }
        return response()->json(['message' => 'You are not a registered user'], 403);
    }


}
