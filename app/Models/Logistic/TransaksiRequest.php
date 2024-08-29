<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransaksiRequest extends Model
{
    use HasFactory;
    protected $connection = 'DB_EMAIL';
    protected $table = 'Logistic_Transaksi_Req';
    protected $primaryKey = 'id_req'; 
    protected $keyType = 'int';
    protected $fillable = ([
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

    ]);
    // public $timestamps = false; 

    // Accessor for created_at
    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->setTimezone('Asia/Jakarta');
    // }

    // // Accessor for updated_at
    // public function getUpdatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->setTimezone('Asia/Jakarta');
    // }
//     public function getUpdatedAtAttribute()
// {
//     return \Carbon\Carbon::parse($this->attributes['updated_at'])
//        ->diffForHumans();
// }

// public function getCreatedAtAttribute()
// {
//     return \Carbon\Carbon::parse($this->attributes['created_at'])
//        ->format('d, M Y H:i');
// }
}
