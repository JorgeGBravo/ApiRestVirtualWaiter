<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\User;
use App\Models\UserCommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommerceController extends Controller
{
    public function registerCommerce(Request $request)
    {
        $isAdmin = User::isAdmin();
        if($isAdmin == false){
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }

        $commerceExist = self::existUserCommerce($request->input('cif'));
        if($commerceExist == true){
            return response()->json(['message' => 'the cif already exists'],409);
        }

        $validator = self::validateDataCreate($request);
        if($validator != null){
            return response()->json(['message' => $validator], 400);
        }

        $commerce = Commerce::create([
            'tradeName' => strtolower($request->input('tradeName')),
            'idUser' => Auth::id(),
            'cif' => strtolower($request->input('cif')),
            'address' => strtolower($request->input('address')),
            'province' => strtolower($request->input('province')),
            'country' => strtolower($request->input('country')),
            'zipcode' => strtolower($request->input('zipcode')),
            'phone' => strtolower($request->input('zipcode')),
            'email' => strtolower($request->input('email')),
            'lastUserWhoModifiedTheField' => Auth::id(),
        ]);
        log::info($commerce->id);
        UserCommerce::create([
            'idUser' => Auth::id(),
            'idCommerce' => $commerce->id,
        ]);

        return response()->json($commerce, 201);
    }

    public function myCommerces(){

        $commerces = Commerce::where('idUser', Auth::id())->get();
        if(count($commerces) === 0){
            return response()->json(['message' => 'you have no associated stores'], 204);
        }
        return response()->json($commerces);
    }

    public function updateCommerces(Request $request)
    {
        $commerce = Commerce::where('cif', $request->input('cif'))
            ->where('idUser', Auth::id())
            ->get();
        if (count($commerce) == 0) {
            return response()->json(['message' => 'no assigned commerce permissions'], 403);
        }

        $isAdmin = User::isAdmin();
        log::info($isAdmin);
        if ($isAdmin == false) {
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }

        $validator = self::validatedDataUpdate($request);
        if ($validator != null) {
            return response()->json(['message' => $validator], 400);
        }

        $address = $request->input('address');
        if (isset($address)) {
            $commerce[0]->address = $request->input('address');
        }
        $province = $request->input('province');
        if (isset($province)) {
            $commerce[0]->address = $request->input('$province');
        }
        $country = $request->input('country');
        if (isset($country)) {
            $commerce[0]->address = $request->input('country');
        }
        $zipcode = $request->input('zipcode');
        if (isset($zipcode)) {
            $commerce[0]->address = $request->input('zipcode');
        }
        $phone = $request->input('phone');
        if (isset($phone)) {
            $commerce[0]->address = $request->input('phone');
        }
        $email = $request->input('email');
        if (isset($email)) {
            $commerce[0]->address = $request->input('email');
        }
        $commerce[0]->save();
        return response()->json($commerce[0]);
    }

}
