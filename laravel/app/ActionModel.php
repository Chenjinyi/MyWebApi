<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionModel extends Model
{
    protected $table='action';

    protected $fillable=
        [
          'name','status'
        ];
}
