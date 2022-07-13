<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabProduksi extends Model
{
    use HasFactory;

    protected $table = 'lab_produksi';

    protected $primaryKey = "id_labproduksi";

    protected $fillable = [
        'id_status',
        'stok'
    ];

    protected $casts = ['created_at','updated_at'];
}
