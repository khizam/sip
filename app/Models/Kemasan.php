<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Kemasan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'kemasan';

    protected $primaryKey = 'id_kemasan';

    protected $fillable = [
        'jenis_kemasan'
    ];

    protected static $logfillable = true;

    protected static $logName = 'kemasan';

    protected $guarded = [];
}