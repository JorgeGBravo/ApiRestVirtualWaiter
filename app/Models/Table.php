<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    public static function tableExists($idCommerce, $table){
        $numberTable =Table::where('idCommerce', $idCommerce)
            ->where('numberTable', $table);
        if(!isset($numberTable)){
            return true;
        }
    }
}
