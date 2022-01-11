<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Models\UserCommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommerceController extends Controller
{
    public function registerCommerce(Request $request)
    {
        self::existUserOrCommerce($request->input('cif'));
        self::onlyAdmin();
        $validatedData = Validator::make($request->all(), [
            'tradeName' => 'required|string|max:255',
            'cif' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->getMessageBag()->first()], 400);
        }
        $user = Commerce::create([
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
        UserCommerce::create([
            'idUser' => auth()->id(),
            'idCommerce' => $user->id(),
        ]);

        return response()->json($user, 200);
    }


    public function myCommerces(){

        $commerces = Commerce::where('idUser', Auth::id());
        if(count($commerces) != 0){
            return response()->json($commerces, 200);
        }
        return response()->json(['message' => 'you have no associated stores']);
    }

    public function updateCommerces(Request $request){
        $this->onlyAdmin();
        $validatedData = Validator::make($request->all(), [
            'address' => 'string|max:255',
            'province' => 'string|max:255',
            'country' => 'string|max:255',
            'zipcode' => 'string|max:255',
            'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'email' => 'string|email|max:255|unique:users',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->getMessageBag()->first()], 400);
        }

        $commerce = Commerce::where('cif',$request->input('cif'))
            ->where('idUser', Auth::id())
            ->get();
        if(count($commerce) != 0){
            $address = $request->input('address');
            $province = $request->input('province');
            $country = $request->input('country');
            $zipcode = $request->input('zipcode');
            $phone = $request->input('phone');
            $email = $request->input('email');

            if(isset($address)){
                $commerce[0]->address = $request->input('address');
            }
            if(isset($province)){
                $commerce[0]->address = $request->input('$province');
            }
            if(isset($country)){
                $commerce[0]->address = $request->input('country');
            }
            if(isset($zipcode)){
                $commerce[0]->address = $request->input('zipcode');
            }
            if(isset($phone)){
                $commerce[0]->address = $request->input('phone');
            }
            if(isset($email)){
                $commerce[0]->address = $request->input('email');
            }
            $commerce[0]->save();
            return response()->json($commerce[0], 200);
        }
        return response()->json(['message' => 'This commerce not exists'], 403);
    }

}
