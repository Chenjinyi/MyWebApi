<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    protected $table='image';

    protected $fillable=
        [
          'name','url','path','status'
        ];
}
