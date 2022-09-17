<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'batch';

    protected $primaryKey = 'id_batch';

    protected $fillable = [
        'id_produksi',
        'nama_batch',
        'id_status',
        'jumlah_batch'
    ];

    protected static $logFillable = true;

    protected static $logName = 'batch';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];
}
