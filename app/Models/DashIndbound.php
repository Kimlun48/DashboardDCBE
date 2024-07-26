<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DashIndbound extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getDashInbound()
    {
        $result = DB::connection('DB_ILS')->select('Dashboard_Inbound_V2');
        $collection = collect($result);
        //->sortByDesc('TYPE'); 
        //  $sorted = $collection->sortByDesc('late');   
        return $collection;
    }
}
