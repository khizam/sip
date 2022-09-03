<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;

class ParameterLab extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'parameter_lab';

    protected $primaryKey = 'id_parameterlab';

    protected $fillable = [
        'id_lab',
        'id_parameter'
    ];

    protected $with = ['parameters'];

    protected static $logFillable = true;

    protected static $logName = 'parameter_lab';

    public function parameters(): BelongsTo
    {
        return $this->belongsTo(Parameter::class, 'id_parameter');
    }
}
