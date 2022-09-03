<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Parameter extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'parameter';

    protected $primaryKey = 'id_parameter';

    protected $fillable = [
        'nama_parameter',
        'nomor_parameter'
    ];

    protected static $logFillable = true;

    protected static $logName = 'parameter';
}
