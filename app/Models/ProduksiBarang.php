<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class ProduksiBarang extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'produksi_barang';

    protected $primaryKey = "id_produksi";

    protected $fillable = [
        'id_produk',
        'id_status',
        'jumlah',
        'keterangan',
        'id_user',
        'id_satuan',
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'produksibarang';

    protected $casts = ['created_at', 'updated_at'];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusProduksi::class, 'id_status');
    }
}
