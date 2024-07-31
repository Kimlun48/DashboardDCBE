<?php

namespace App\Models\Inbound;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ItrIn extends Model
{
    
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getItrIn(){
        $result = DB::connection ('DB_ILS')->select('EXEC DashboardV3_Detail_ITRIN');
        $collection = collect($result);
        //->sortByDesc('TYPE'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection;        
    }
    
}
