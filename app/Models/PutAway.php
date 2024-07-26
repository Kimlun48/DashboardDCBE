<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PutAway extends Model
{
  use HasFactory;
  protected $connection = 'DB_ILS';

  protected $table = 'LOCATION_INVENTORY';

  public static function getPutAway()
  {
    $result = DB::connection('DB_ILS')->select('EXEC Inbound_Receipt_Chart');
    $collection = collect($result)->sortByDesc('Late');
    //  $sorted = $collection->sortByDesc('late');   
    return $collection;
  }
}
