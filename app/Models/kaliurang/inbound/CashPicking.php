<?php

namespace App\Models\kaliurang\inbound;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashPicking extends Model
{
    use HasFactory;
    protected $connection = 'DB_RKM_LIVE_2';

    protected $table = 'DB_RKM_LIVE_2';

    public static function getCashPicking($WAREHOUSE){
    
    $results = DB::connection('DB_RKM_LIVE_2')->select('EXEC dbo.Pick_and_pack_cash_dashboard_store @WAREHOUSE = ? ', [
        $WAREHOUSE,
    ]);

    return $results;
    }
}
