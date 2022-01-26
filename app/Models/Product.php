<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    public static function createNewProduct(Request $request){
        $isAdmin = User::isAdmin();
        if ($isAdmin == false) {
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }
        $commerce = Commerce::where('cif', $request->input('cif'))
            ->where('idUser', Auth::id())
            ->get();
        if (count($commerce) == 0) {
            return response()->json(['message' => 'no assigned commerce permissions'], 403);
        }
        $validator = self::validatedDataProduct($request);
        if($validator != null){
            return response()->json(['message' => $validator], 400);
        }

        $newProduct = Product::create([
            'IdCommerce' => $request->input('idCommerce'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'lastUserWhoModifiedTheField' => Auth::id(),
        ]);
        return response()->json($newProduct);
    }


    public static function deleteProduct(Request $request){
        $isAdmin = User::isAdmin();
        if ($isAdmin == false) {
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }
        $commerce = Commerce::where('cif', $request->input('cif'))
            ->where('idUser', Auth::id())
            ->get();
        if (count($commerce) == 0) {
            return response()->json(['message' => 'no assigned commerce permissions'], 403);
        }
        $product = Product::all()
            ->where('idCommmerce', $request->input('idCommmerce'))
            ->where('name', $request->input('name'))
            ->get();
        if (count($product) != 0) {
            $product[0]->delete();
            return response()->json(['message' => 'The product has been deleted']);
        }
        return response()->json(['message' => 'This product not exist'], 404);
    }

}
