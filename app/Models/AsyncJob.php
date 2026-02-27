<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsyncJob extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'type',
        'status',
        'result_url',
        'error',
    ];
}
