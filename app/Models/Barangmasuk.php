<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangmasuk extends Model
{
    use HasFactory;

    protected $table = 'barangmasuk';
    protected $primaryKey = 'id_barangmasuk';
    protected $guarded = [];

    public function bahan(){
        return $this->belongsTo(Bahan::class,'id_bahan','id_bahan');
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class,'id_kategori','id_kategori');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'id_supplier','id_supplier');
    }
}
