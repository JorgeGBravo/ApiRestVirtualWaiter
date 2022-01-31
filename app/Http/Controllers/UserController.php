<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        $userExist = self::existUserCommerce($request->input('cif'));
        if($userExist == true){
            return response()->json(['message' => 'the cif already exists']);
        }
        $validator = self::validateDataCreate($request);
        if($validator != null){
            return response()->json(['message' => $validator], 400);
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
            'isAdmin' => $request->input('isAdmin'),
        ]);
        return response()->json($user, 201);
    }

    public function updateUser(Request $request)
    {
        $validator = self::validatedDataUpdate($request);
        if ($validator != null) {
            return response()->json(['message' => $validator], 400);
        }
        $user = User::where('id', Auth::id())->get();
        if (count($user) != 0) {
            $address = $request->input('address');
            if (isset($address)) {
                $user[0]->address = $address;
            }
            $province = $request->input('province');
            if (isset($province)) {
                $user[0]->province = $province;
            }
            $country = $request->input('country');
            if (isset($country)) {
                $user[0]->country = $country;
            }
            $zipcode = $request->input('zipcode');
            if (isset($zipcode)) {
                $user[0]->zipcode = $zipcode;
            }
            $phone = $request->input('phone');
            if (isset($phone)) {
                $user[0]->phone = $phone;
            }
            $email = $request->input('email');
            if (isset($email)) {
                $user[0]->email = $email;
            }
            $isAdmin = $request->input('isAdmin');
            if (isset($isAdmin)) {
                $user[0]->isAdmin = $isAdmin;
            }
            $user[0]->save();
            return response()->json($user[0]);
        }
        return response()->json(['message' => 'the user with the cif does not exist']);
    }

    public function prueba()
    {
        return response()->json(['message' => 'esto es una prueba']);
    }

}
