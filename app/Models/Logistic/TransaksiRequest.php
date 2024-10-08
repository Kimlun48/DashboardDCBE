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
        'date_loading_goods',
        'date_checkout_security'

    ];
    // // public $timestamps = false; 

    // public function schedule () 
    // {
    //     return $this->belongsTo(Schedule::class, 'id_jadwal', 'id');
    // } 

   
    // public function schedule1 () 
    // {
    //     return $this->belongsTo(Schedule::class, 'id_req', 'id');
    // } 

    // public function logdoc () 
    // {
    //     return $this->hasMany(TransaksiRequest::class, 'id_req', 'id_trans_req');
    // } 
    // Relasi ke Schedule berdasarkan id_jadwal
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_jadwal', 'id');
    }

    // Relasi kedua ke Schedule tetapi berdasarkan id_req
    public function schedule1()
    {
        return $this->belongsTo(Schedule::class, 'id_req', 'id');
    }

    public function logdoc()
    {
        return $this->hasMany(LogisticDocUpload::class, 'id_trans_req', 'id_req');
    }
   
}
