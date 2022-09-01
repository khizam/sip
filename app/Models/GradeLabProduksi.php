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
        'id_produksi',
        'id_grade',
        'id_produk',
        'jumlah_produk',
        'stok',
    ];

    protected static $logName = 'grade_lab_produksi';

    protected $casts = ['created_at','updated_at'];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'id_grade');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function produksi()
    {
        return $this->belongsTo(ProduksiBarang::class, 'id_produksi');
    }
}
