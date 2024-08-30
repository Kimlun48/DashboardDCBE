<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TransaksiRequest extends Model
{
    use HasFactory;
    protected $connection = 'DB_EMAIL';
    protected $table = 'Logistic_Transaksi_Req';
    protected $primaryKey = 'id_req'; 
    protected $keyType = 'int';
    protected $fillable = [
        'id_req', 
        'vendor_code', 
        'nama_vendor', 
        'sopir',
        'id_jadwal',
        'id_kendaraan',
        'surat_jalan',
        'slot_req',
        'nama_kendaraan',
        'status',
        'date_arrived',
        'date_completed',
        'date_loading_goods'

    ];
    // public $timestamps = false; 

    public function schedule () 
    {
        return $this->belongsTo(Schedule::class, 'id_jadwal', 'id');
    } 

   
}
