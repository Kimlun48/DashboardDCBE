<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKendaraan extends Model
{
    use HasFactory;
    protected $connection = 'DB_EMAIL';
    protected $table = 'Logistic_Tipe_Kendaraan';
    protected $primaryKey = 'id'; 
    protected $keyType = 'int';

    protected $fillable = ([
        'id',
        'tipe',
    ]);
    public $timestamps = false;
}
