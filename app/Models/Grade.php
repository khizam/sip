<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grade';

    protected $primarykey = "id_grade";

    protected $fillable = [
        'nama_grade'
    ];

    protected static $logFillable = true;


    protected $casts = ['created_at','updated_at'];
}
