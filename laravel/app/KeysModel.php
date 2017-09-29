<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeysModel extends Model
{
    protected $table='keys';

    protected $fillable=
        [
            'key','status','action'
        ];
}
