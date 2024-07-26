<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DashboardStore extends Model
{

    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function GetDashboardStore()
    {
        $result = DB::connection('DB_ILS')->select('Dashboard_Store_v1');
        $collection = collect($result);
        //->sortByDesc('TYPE'); 
        //  $sorted = $collection->sortByDesc('late');   
        return $collection;
    }
}
