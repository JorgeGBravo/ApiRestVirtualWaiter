<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
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
        return response()->json($user, 200);
    }

    public function updateUser(Request $request){

        $validator = self::validatedDataUpdate($request);
        if($validator != null){
            return response()->json(['message' => $validator], 400);
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

    public function pruebaValidator(Request $request){
        $validator = self::validateDataCreate($request);
        if($validator != null){
            return response()->json(['message' => $validator], 400);
        }

    }
}
