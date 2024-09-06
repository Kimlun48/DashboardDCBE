<?php

namespace App\Models\kaliurang\inbound;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class grpo extends Model
{
    use HasFactory;
    protected $connection = 'DB_RKM_LIVE_2';

    protected $table = 'DB_RKM_LIVE_2';

    public static function getGrpo($WAREHOUSE, $BIN, $TYPE){
    
    $results = DB::connection('DB_RKM_LIVE_2')->select('EXEC dbo.TMSP_DASHBOARD_WAREHOUSE_STORE @WAREHOUSE = ?, @BIN = ?, @TYPE = ?', [
        $WAREHOUSE,
        $BIN,
        $TYPE
    ]);

    return $results;
    }
}
