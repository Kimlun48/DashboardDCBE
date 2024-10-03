<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $connection = 'DB_EMAIL';
    protected $table = 'Logistic_Master_Kendaraan';
    protected $primaryKey = 'id_kendaraan'; 
    protected $keyType = 'int';

    protected $fillable = ([
        'id_kendaraan',
        'Jenis_Kendaraan',
        'slot_Kendaraan',
        'tipe_pallet',
    ]);
    public $timestamps = false;
}
