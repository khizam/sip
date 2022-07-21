<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Bahan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'bahan';

    protected $primaryKey = 'id_bahan';

    protected $fillable = [
        'nama_bahan'
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'bahan';
    protected $guarded = [];

}
