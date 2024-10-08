<?php

namespace App\Models\Logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticDocUpload extends Model
{
    use HasFactory;
    protected $connection = 'DB_EMAIL';
    protected $table = 'Logistic_Dok_Upload';
    protected $primaryKey = 'id'; 
    protected $keyType = 'int';

    protected $fillable = ([
        'cp_driver',
        'id_trans_req',
        'no_po',
        'no_js',
        'kode_barang',
        'nama_barang',
        'qty',
        'uom',
        'keterangan',
    ]);
    public $timestamps = false;

    
    public function transaksiRequest()
    {
        return $this->belongsTo(TransaksiRequest::class, 'id_trans_req', 'id_req');
    }
}
