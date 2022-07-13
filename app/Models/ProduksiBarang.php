<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiBarang extends Model
{
    use HasFactory;

    protected $table = 'produksi_barang';

    protected $primaryKey = "id_produksi";

    protected $fillable = [
        'id_produk',
        'id_status',
        'jumlah',
        'id_user',
    ];

    protected $casts = ['created_at','updated_at'];
}
