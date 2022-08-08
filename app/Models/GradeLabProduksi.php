<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLabProduksi extends Model
{
    use HasFactory;

    protected $table = 'grade_lab_produksi';

    protected $primaryKey = "id_gradelab";

    protected $fillable = [
        'id_labproduksi',
        'jumlah_produk',
        'stok',
    ];

    protected $casts = ['created_at','updated_at'];
}
