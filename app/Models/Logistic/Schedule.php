<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $connection = 'DB_EMAIL';
    protected $table = 'SR_AvailableSchedule';

    protected $fillable = [
        'id', 
        'hari', 
        'mulai', 
        'akhir',
        'jenis_aktivitas',
        'slot',
        'available_slot',
        'status'
    ];
    public $timestamps = false;

    public function transaksiRequest()
    {
        return $this->hasMany(TransaksiRequest::class, 'id_jadwal', 'id');
    }

    public function transaksiRequest1()
    {
        return $this->hasMany(TransaksiRequest::class, 'id_req', 'id');
    }
}
