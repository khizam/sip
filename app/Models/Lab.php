<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;

class Lab extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'lab';

    protected $primaryKey = 'id_lab';

    protected $fillable = [
        'kode_lab',
        'id_barangmasuk',
        'satuan',
        'hasil',
        'kesimpulan',
        'grid',
        'bahan_layak',
        'bahan_tidak_layak',
        'status',
        'id_status_gudang',
    ];

    /**
     * log any attribute that has changed. spatie/laravel-acitivtylog
     */
    protected static $logFillable = true;

    /**
     * Specify $logName to make the model use another name than the default. spatie/laravel-acitivtylog
     */
    protected static $logName = 'lab';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function barang_masuk()
    {
        return $this->hasOne(Barangmasuk::class, 'id_barangmasuk', 'id_barangmasuk');
    }

    /**
     * Get all of the parameter for the Lab
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameterLab(): HasMany
    {
        return $this->hasMany(ParameterLab::class, 'id_lab');
    }

    public function status_gudang()
    {
        return $this->belongsTo(StatusGudang::class, 'id_status_gudang', 'id_status');
    }
}
