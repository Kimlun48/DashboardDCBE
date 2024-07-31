<?php

namespace App\Models\Outbound;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesOrder extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getSalesOrder(){

         // Mengaktifkan ANSI_NULLS dan ANSI_WARNINGS
         DB::connection('DB_ILS')->statement('SET ANSI_NULLS ON');
         DB::connection('DB_ILS')->statement('SET ANSI_WARNINGS ON');

        $result = DB::connection ('DB_ILS')->select('EXEC DashboardV3_SALES_ORDER');
        $collection = collect($result);
        //->sortByDesc('TYPE'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection;        
    }
}
