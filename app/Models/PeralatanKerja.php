<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeralatanKerja extends Model
{
    use HasFactory;

    protected $table = 'peralatan_kerja';

    protected $primaryKey = "id_peralatan_kerja";

    protected $fillable = [
        'alat',
        'jumlah_alat'
    ];
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];
}
