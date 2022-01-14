<?php

namespace App\Http\Controllers;

use App\Models\CommerceTable;
use App\Models\Table;
use App\Models\UserCommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TableController extends Controller
{
    public function createTable(Request $request, $idCommerce)
    {
        self::onlyAdmin();
        $numberTable = $request->input('numberTable');
        self::tableExists($idCommerce, $numberTable);
        $usersCommerce = UserCommerce::where('idCommerce', $idCommerce)->get()->all();

        foreach ($usersCommerce as $position => $user) {
            if ($user == Auth::id()) {
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
        }
        return response()->json(['message' => 'user without permission'], 401);

    }

    public function createUrl(){

    }
}
