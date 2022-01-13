<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function existUserOrCommerce($dataDocument){
        $commerce = Commerce::all()->where('cif', $dataDocument);
        if(count($commerce) === 0){
            return response()->json(['message' => 'the cif already exists']);
        }
        $user = User::all()->where('cif', $dataDocument);
        if(count($user) === 0){
            return response()->json(['message' => 'the cif already exists']);
        }
    }

    public static function onlyAdmin()
    {
        if (auth()->id() === 0) {
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }
    }

    public static function validateDataCreate($request){
        $data = $request->input('tradeName');
        if($data === null){
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
        }else{
            $validatedData = Validator::make($request->all(), [
                'tradeName' => 'required|string|max:255',
                'cif' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'zipcode' => 'required|string|max:255',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        }
        if ($validatedData->fails()) {
            $validate = $validatedData->getMessageBag()->first();
            return $validate;
        }
    }

    public static function validatedDataUpdate($request){
        $validatedData = Validator::make($request->all(), [
            'address' => 'string|max:255',
            'province' => 'string|max:255',
            'country' => 'string|max:255',
            'zipcode' => 'string|max:255',
            'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'email' => 'string|email|max:255|unique:users',
            'isAdmin' => 'boolean',
        ]);
        if ($validatedData->fails()) {
            $validate = $validatedData->getMessageBag()->first();
            return $validate;        }
    }
}
