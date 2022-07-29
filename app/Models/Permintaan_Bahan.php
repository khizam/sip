<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Permintaan_Bahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'permintaan_bahan';

    protected $primaryKey = "id_request";

    protected $fillable = [
        'id_request',
        'detail_bahan_produksi',
        'jumlah_bahan',
        'keterangan',
        'user_produksi',
        'user_gudang',
    ];

    protected static $logFillable = true;

    protected static $logName = 'permintaanbahan';

    protected $casts = ['created_at', 'updated_at'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }

    public function userproduksi()
    {
        return $this->belongsTo(User::class, 'user_produksi');
    }

    public function usergudang()
    {
        return $this->belongsTo(User::class, 'user_gudang');
    }

}
