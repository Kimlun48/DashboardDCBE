<?php

namespace App\Models\Inbound;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodReceiptPO extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';
    protected $table = 'LOCATION_INVENTORY';

    public static function getGoodReceiptPO(){
        $result = DB::connection ('DB_ILS')->select('EXEC Last_3_Month_Chart');
        $collection = collect($result);
        //->sortByDesc('TYPE'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection;  
    }



}
