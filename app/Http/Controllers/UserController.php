<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerUser(Request $request)
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
            'isAdmin' => 'boolean',
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
            'isAdmin' => $request->input('isAdmin'),


        ]);
        return response()->json($user, 200);
    }

    public function updateUser(Request $request){
        $validatedData = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'email' => 'required|string|email|max:255|unique:users',
            'isAdmin' => 'boolean',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->getMessageBag()->first()], 400);
        }

        $user = User::where('cif', $request->input('cif'))->get();
        if(count($user) != 0){
            $address = $request->input('address');
            $province = $request->input('province');
            $country = $request->input('country');
            $zipcode = $request->input('zipcode');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $isAdmin = $request->input('isAdmin');

            if(isset($address)){
                $user[0]->address = $request->input('address');
            }
            if(isset($province)){
                $user[0]->address = $request->input('$province');
            }
            if(isset($country)){
                $user[0]->address = $request->input('country');
            }
            if(isset($zipcode)){
                $user[0]->address = $request->input('zipcode');
            }
            if(isset($phone)){
                $user[0]->address = $request->input('phone');
            }
            if(isset($email)){
                $user[0]->address = $request->input('email');
            }
            if(isset($isAdmin)){
                $user[0]->isAdmin = $request->input('isAdmin');
            }
            $user[0]->save();
            return response()->json($user[0], 200);

        }
        return response()->json(['message' => 'the user with the cif does not exist']);
    }
}
