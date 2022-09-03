<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class JenisProduksi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'jenis_produksi';

    protected $primaryKey = 'id_jenisproduksi';

    protected $fillable = [
        'jenis',
    ];

    protected static $logFillable = true;

    protected static $logName = 'jenis_produksi';
}
