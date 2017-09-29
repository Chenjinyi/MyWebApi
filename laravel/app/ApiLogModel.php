<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiLogModel extends Model
{
    protected $table='api_log';

    protected $fillable=
        [
        'content'
        ];

    const UPDATED_AT = 'created_at';
}

