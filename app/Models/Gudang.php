<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Gudang extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'gudang';

    protected $primaryKey = 'id_gudang';

    protected $fillable = [
        'id_lab',
        'id_status_gudang',
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'gudang';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function lab() {
        return $this->hasOne(Lab::class,'id_lab','id_lab');
    }

    public function status_gudang() {
        return $this->belongsTo(StatusGudang::class,'id_status_gudang','id_status');
    }
}
