<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class DetailProduksi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'detail_produksi';

    protected $primaryKey = "id_detail";

    protected $fillable = [
        'id_bahan',
        'id_produksi',
        'jumlah',
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'detailproduksi';

    protected $with = ['bahan'];

    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }

    public function produksi()
    {
        return $this->belongsTo(ProduksiBarang::class, 'id_produksi');
    }

    public function permintaanBahan()
    {
        return $this->belongsTo(PermintaanBahan::class, 'id_detail', 'id_detail_produksi');
    }

}
