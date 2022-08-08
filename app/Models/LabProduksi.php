<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LabProduksi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'lab_produksi';

    protected $primaryKey = "id_labproduksi";

    protected $fillable = [
        'id_produksi',
        'jumlah_produksi',
        'lost',
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'labproduksi';

    protected $casts = ['created_at','updated_at'];
}
