<?php

namespace App\Models\kaliurang\inbound;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StoreKaliurang extends Model
{
    use HasFactory;
    protected $connection = 'DB_RKM_LIVE_2';

    protected $table = 'DB_RKM_LIVE_2';

    public static function getStoreKaliurang($WAREHOUSE, $TYPE){
    
    $results = DB::connection('DB_RKM_LIVE_2')->select('EXEC dbo.TMSP_DASHBOARD_STORE_PND_CASH_2 @WAREHOUSE = ?, @TYPE = ?', [
        $WAREHOUSE,
        $TYPE
    ]);

    return $results;
    }

}
