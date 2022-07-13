<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusProduksi extends Model
{
    use HasFactory;

    protected $table = 'status_produksi';

    protected $primaryKey = "id_status";

    protected $fillable = [
        'status'
    ];

    protected $casts = ['created_at','updated_at'];
}
