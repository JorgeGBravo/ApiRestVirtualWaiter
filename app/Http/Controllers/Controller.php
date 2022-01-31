<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\Table;
use App\Models\UserCommerce;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function existUserCommerce($dataDocument){
        $commerce = Commerce::where('cif', $dataDocument)->get();
        if(count($commerce) != 0){
            return true;
        }
        $user = User::all()->where('cif', $dataDocument);
        if(count($user) != 0){
            return true;
        }
    }

    public static function validateDataCreate($request){
        $data = $request->input('tradeName');
        if(!isset($data)){
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
            return $validatedData->getMessageBag()->first();
        }
    }

    public static function validatedDataUpdate($request){
        $validatedData = Validator::make($request->all(), [
            'address' => 'string|max:255|nullable',
            'province' => 'string|max:255|nullable',
            'country' => 'string|max:255|nullable',
            'zipcode' => 'string|max:255|nullable',
            'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9|nullable',
            'email' => 'string|email|max:255|unique:users|nullable',
            'isAdmin' => 'boolean|nullable',
        ]);
        if ($validatedData->fails()) {
            return $validatedData->getMessageBag()->first();        }
    }

    public static function validatedDataProduct($request){
        $validatedData = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'price' => 'required|numeric|dimensions:ratio=3/2',
        ]);
        if ($validatedData->fails()) {
            return $validatedData->getMessageBag()->first();        }
    }

    public function accessControlCommerce($cif){
        $isAdmin = User::isAdmin();
        if ($isAdmin == false) {
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }
        $commerce = UserCommerce::where('cif', $cif)
            ->where('idUser', Auth::id())
            ->get();
        if (count($commerce) == 0) {
            return response()->json(['message' => 'no assigned commerce permissions'], 403);
        }
    }

}
