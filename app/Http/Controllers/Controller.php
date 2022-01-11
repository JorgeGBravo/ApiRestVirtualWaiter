<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
}
