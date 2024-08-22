<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHour extends Model
{
    use HasFactory;
    protected $connection = 'DB_EMAIL';
    protected $table = 'SR_MasterHour';
    protected $primaryKey = 'id'; 
    protected $keyType = 'int';

    protected $fillable = ([
        'id', 
        'mulai', 
        'akhir', 
        'jenis_aktivitas',
        'status',
        'slot',
        'jenis_jam'
    ]);
    public $timestamps = false; 
}
