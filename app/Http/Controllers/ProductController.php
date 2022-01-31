<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function createNewProduct(Request $request){
        $accessControl = self::accessControlCommerce($request->input('cif'));
        if(isset($accessControl)){
            return $accessControl;
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


    public function deleteProduct(Request $request){
        $accessControl = self::accessControlCommerce($request->input('cif'));
        if(isset($accessControl)){
            return $accessControl;
        }
        $product = Product::where('idCommerce', $request->input('idCommerce'))
            ->where('name', $request->input('name'))
            ->get();
        if (count($product) != 0) {
            $product[0]->delete();
            return response()->json(['message' => 'The product has been deleted']);
        }
        return response()->json(['message' => 'This product not exist'], 404);
    }
}
