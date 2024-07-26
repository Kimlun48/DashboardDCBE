<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class indelivstock extends Model
{
    use HasFactory;
    protected $connection = 'DB_ILS';

    protected $table = 'LOCATION_INVENTORY';

    public static function getDelivStock(){
        $result = DB::connection ('DB_ILS')->select('EXEC Inbound_Stok_Kurang');
        $collection = collect($result)->sortBy('Deadline'); 
      //  $sorted = $collection->sortByDesc('late');   
        return $collection; 

       
    }



  //   public static function getDelivStock($page = 1, $perPage = 10) {
  //     $result = DB::connection('DB_ILS')->select('EXEC Laporan_Delivery_Stok_Kurang');
  //     $collection = collect($result)->sortBy('Deadline');
  
  //     // Menghitung total item
  //     $total = $collection->count();
  
  //     // Memotong koleksi berdasarkan halaman saat ini dan jumlah item per halaman
  //     $items = $collection->slice(($page - 1) * $perPage, $perPage)->values();
  
  //     // Membuat LengthAwarePaginator instance
  //     $paginatedItems = new LengthAwarePaginator($items, $total, $perPage, $page, [
  //         'path' => LengthAwarePaginator::resolveCurrentPath(),
  //     ]);
  
  //     return $paginatedItems;
  // }
}
