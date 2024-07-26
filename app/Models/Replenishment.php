<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Replenishment extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getReplenishment()
    {
        $result = DB::connection('DB_ILS')->select('EXEC Storage_Replenishment');
        $collection = collect($result);
        //  $sorted = $collection->sortByDesc('late');   
        return $collection;
    }
}
