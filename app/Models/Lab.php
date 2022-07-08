<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $table = 'lab';
    protected $primaryKey = 'id_lab';
    protected $fillable = ['kode_lab','id_barangmasuk','satuan','parameter','hasil','kesimpulan','grid','bahan_layak','bahan_tidak_layak', 'status'];
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function barang_masuk() {
        return $this->hasOne(Barangmasuk::class,'id_barangmasuk','id_barangmasuk');
    }
}
