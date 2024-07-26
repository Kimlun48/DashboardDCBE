<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ils extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getIlsSP(){
        $result = DB::connection ('DB_ILS')->select('EXEC Laporan_Crossdok_lebih_dari_1hari');
        $collection = collect($result)->sortByDesc('late'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection; 

       
    }

}
