<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Supplier extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    protected $guarded = [];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default.
     */
    protected static $logName = 'supplier';
}
