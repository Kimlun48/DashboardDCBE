<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AlertCash extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getAlertCash(){
        $result = DB::connection ('DB_ILS')->select('EXEC Alert_Cash');
        $collection = collect($result)->sortByDesc('DocDate'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection; 

       
    }
}
