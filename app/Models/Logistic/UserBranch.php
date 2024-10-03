<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserBranch extends Model
{
    use HasFactory;
    protected $connection = 'DB_RKM_LIVE_2';
    protected $table = 'DB_RKM_LIVE_2';

    public static function getUserBranch(){

         // Mengaktifkan ANSI_NULLS dan ANSI_WARNINGS
        //  DB::connection('DB_ILS')->statement('SET ANSI_NULLS ON');
        //  DB::connection('DB_ILS')->statement('SET ANSI_WARNINGS ON');

        $result = DB::connection ('DB_RKM_LIVE_2')->select('EXEC dbo.TMSP_USER_BRANCH_DASH');
        $collection = collect($result);
        //->sortByDesc('TYPE'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection;        
    }
}
