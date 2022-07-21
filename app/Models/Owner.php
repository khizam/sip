<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'produksi_barang';
    protected $primaryKey = 'id_produksi';
    protected $fillable = [
        'id_produksi',
        'id_produk',
        'id_status',
        'jumlah',
        'id_user',
    ];
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function produk(){
        return $this->belongsTo(Produk::class,'id_produk','id_produk');
    }

    public function status_produksi(){
        return $this->belongsTo(Status_produksi::class, 'id_status','id_status');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user','id_user');
    }
}
