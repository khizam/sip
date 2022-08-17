<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class GudangProdukJadi extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'gudang_produk';

    protected $primaryKey = 'id_gudangproduk';

    protected $fillable = [
        'id_produksi',
    ];
}
