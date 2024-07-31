<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ListPicking extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getListPicking(){
      DB::connection('DB_ILS')->statement('SET ANSI_NULLS ON');
      DB::connection('DB_ILS')->statement('SET ANSI_WARNINGS ON');
        $result = DB::connection ('DB_ILS')->select('EXEC LAPORAN_WORK_PICKING');
        $collection = collect($result);
        //->sortByDesc('TYPE'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection;        
    }
}
