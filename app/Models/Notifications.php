<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notifications extends DatabaseNotification
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d-m-y',
        'updated_at' => 'datetime:d-m-y',
    ];

    public function getDataToCollectionAttribute()
    {
        return collect($this->data);
    }
}
