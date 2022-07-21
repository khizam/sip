<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Kategori extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'kategori';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori'
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'kategori';

    protected $guarded = [];
}
