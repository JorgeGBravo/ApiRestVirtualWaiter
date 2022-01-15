<?php

namespace App\Http\Controllers;

use App\Models\CommerceTable;
use App\Models\Table;
use App\Models\User;
use App\Models\UserCommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    public function createTable(Request $request, $idCommerce)
    {
        $isAdmin = User::isAdmin();
        if ($isAdmin == false) {
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }

        $numberTable = $request->input('numberTable');
        $tableExists = Table::tableExists($idCommerce, $numberTable);
        if($tableExists == true){
            return response()->json(['message' => 'this table exists'], 409);
        }

        $usersCommerce = UserCommerce::where('idCommerce', $idCommerce)->where('userId', Auth::id())->get()->all();
        if (isset($usersCommerce)) {
            $newTable = Table::create([
                'idCommerce' => $idCommerce,
                'numberTable' => $numberTable,
            ]);
            CommerceTable::create([
                'idCommerce' => $idCommerce,
                'idTable' => $newTable->id(),
            ]);
            return response()->json([$newTable], 201);
        }
        return response()->json(['message' => 'user without permission'], 401);
    }

    public function deleteTable(Request $request,$idCommerce){

        $isAdmin = User::isAdmin();
        if ($isAdmin == false) {
            return response()->json(['message' => 'You do not have Administrator permissions'], 403);
        }
        $numberTable = $request->input('numberTable');

        $table =Table::where('idCommerce', $idCommerce)
            ->where('numberTable', $numberTable)
            ->get();
        $commerceTable = CommerceTable::where('idCommerce', $idCommerce)
            ->where('idTable', $table[0]->id)
            ->get();

        if(count($table) == 0){
            return response()->json(['message' => 'this table does not exist'], 409);
        }
        $table[0]->delete();
        $commerceTable[0]->delete();
        return response()->json(['message' => 'The table number: '.$numberTable.' has been deleted']);


    }

    public function createUrl(){
        //this function creates url to access the trading desk
    }
}
