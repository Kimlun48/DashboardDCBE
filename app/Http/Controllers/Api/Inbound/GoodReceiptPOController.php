<?php

namespace App\Http\Controllers\Api\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inbound\GoodReceiptPO;
use App\Http\Resources\Inbound\GoodreceiptpoResource;

class GoodReceiptPOController extends Controller
{
       protected $data;
       
       public function __construct()
       {
        $this->data = GoodReceiptPO::getGoodReceiptPO();
       }

       public function index()
       {
        return new GoodreceiptpoResource(true, "List Data Good Receipt Po", $this->data);
       }

       public function topLate()
       {
           // Ambil data dan urutkan berdasarkan DEADLINE
           $toplate = $this->data->where('CLOSE_DATE', '=', 'open')
                                 ->where('DEADLINE', '>', 0)
                                 ->sortByDesc('DEADLINE')
                                 ->take(5); // Batasi hanya lima data teratas
       
           return new GoodreceiptpoResource(true, 'List Data GRPO Top Late', $toplate->values()->all());
       }
       



       public function threemounthLate()
       {
           $late = $this->data->where('CLOSE_DATE', 'closed')
                              ->where('DAYS_TO_CLOSE', '>', 0)
                              ->sortByDesc('DAYS_TO_CLOSE'); // Mengurutkan berdasarkan DAYS_TO_CLOSE secara descending
                              
           return new GoodreceiptpoResource(true, 'List Data GRPO Three Month Late', $late->values()->all());
       }


       public function threemounthOntime()
       {
        $ontime = $this->data->where('CLOSE_DATE', 'closed')
                         ->where('DAYS_TO_CLOSE', 0)
                         ->sortByDesc('DAYS_TO_CLOSE');
                        // ->sortByDesc('RECEIPT_DATE');
                        // ->orderBy('CLOSE_DATE', 'DESC');
        return new GoodreceiptpoResource(true, 'List Data GRPO three mounth Ontime', $ontime->values()->all());
       }

       public function getStatistics()
       {
           // Ambil data dari metode getIlsSP yang sekarang mengembalikan koleksi
           $data = GoodReceiptPO::getGoodReceiptPO();
   
           // Hitung jumlah item dengan nilai 'late' > 0 dan 'late' = 0
           $late = $data->where('CLOSE_DATE', 'closed')
                        ->where('DAYS_TO_CLOSE', '>', 0)
                        ->count();
           $ontime = $data->where('CLOSE_DATE', 'closed')
                        ->where('DAYS_TO_CLOSE', 0)
                        ->count();
           $all = $late + $ontime;
   
           return response()->json([
               'success' => true,
               'message' => 'Statistik Data GRPO Last three Month',
               'data' => [
                   'late' => $late,
                   'ontime' => $ontime,
                   'all' => $all,
               ],
           ]);
       }
    }