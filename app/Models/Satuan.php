<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $table = 'satuan';

    protected $primaryKey = "id_satuan";

    protected $fillable = [
        'satuan'
    ];

    protected static $logFillable = true;

    protected $casts = ['created_at','updated_at'];
}
