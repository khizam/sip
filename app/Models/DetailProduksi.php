<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    protected $casts = ['created_at','updated_at'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class,'id_bahan');
    }

    public function produksi()
    {
        return $this->belongsTo(ProduksiBarang::class,'id_produksi');
    }

    public function detail()
    {
        return $this->belongsTo(DetailProduksi::class,'id_detail');
    }

}
