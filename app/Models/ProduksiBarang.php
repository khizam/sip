<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;

class ProduksiBarang extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'produksi_barang';

    protected $primaryKey = "id_produksi";

    protected $fillable = [
        'id_produk',
        'kode_labproduksi',
        'id_status',
        'jumlah',
        'keterangan',
        'id_user',
        'id_satuan',
        'jumlah_hasil_produksi'
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;


    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'produksi_barang';

    protected $guarded = [];

    protected $casts = ['created_at', 'updated_at'];





    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function bahan()
    {
        return $this->hasOne(Bahan::class, 'id_bahan', 'id_bahan');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    public function jenis_produksi()
    {
        return $this->belongsTo(JenisProduksi::class, 'id_jenisproduksi', 'id_jenisproduksi');
    }

    public function status()
    {
        return $this->belongsTo(StatusProduksi::class, 'id_status', 'id_status');
    }

    public function detailProduksi(): HasMany
    {
        return $this->hasMany(DetailProduksi::class, 'id_produksi');
    }
}
