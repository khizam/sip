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

        'id_gradelab',
    ];

    protected static $logFillable = true;

    protected static $logName = 'gudangproduk';

    protected $casts = ['created_at', 'updated_at'];

    public function id_gradelab()
    {
        return $this->belongsTo(GradeLabProduksi::class, 'id_gradelab');
    }

}
