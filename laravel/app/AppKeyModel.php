<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppKeyModel extends Model
{
    protected $table='app_key';

    protected $fillable=
        [
          'name'.'url','key'
        ];
}
