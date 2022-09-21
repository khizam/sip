<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Barangmasuk extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'barangmasuk';

    protected $primaryKey = 'id_barangmasuk';

    protected $fillable = [
        'id_bahan',
        'id_kategori',
        'id_supplier',
        'jumlah_bahan',
        'id_kemasan',
        'nomor_po',
        'pengirim',
        'penerima',
        'berat_kotor',
        'tara',
        'netto',
        'reject',
        'kendaraan',
        'id',
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'barangmasuk';

    protected $guarded = [];

    public function bahan(){
        return $this->belongsTo(Bahan::class,'id_bahan','id_bahan');
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class,'id_kategori','id_kategori');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'id_supplier','id_supplier');
    }

    public function kemasan(){
        return $this->belongsTo(Kemasan::class,'id_kemasan','id_kemasan');
    }
}
