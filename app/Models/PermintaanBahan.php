<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBahan extends Model
{
    use HasFactory;

    protected $table = "permintaan_bahan";

    protected $primaryKey = 'id_request';

    protected $fillable = [
        'id_detail_produksi',
        'jumlah_bahan',
        'keterangan',
        'user_produksi',
        'user_gudang',
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'permintaan_bahan';

    protected $guarded = [];

    public function detailProduksi()
    {
        return $this->belongsTo(DetailProduksi::class, 'id_detail_produksi');
    }

    public function userProduksi()
    {
        return $this->belongsTo(User::class, 'id_user_produksi');
    }

    public function userGudang()
    {
        return $this->belongsTo(User::class, 'id_user_gudang');
    }
}
