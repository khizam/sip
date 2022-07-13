<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduksi extends Model
{
    use HasFactory;

    protected $table = 'detail_produksi';

    protected $primaryKey = "id_detail";

    protected $fillable = [
        'id_bahan',
        'id_produksi',
    ];

    protected $casts = ['created_at','updated_at'];
}
