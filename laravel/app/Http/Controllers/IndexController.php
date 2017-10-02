<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function Index()
    {
        return json_encode(
          [
              'API'=>"Success",
              'STATUS'=>"Success",
              'TIME'=>date('Y-m-d H:i:s'),
              'FORM'=>'Get',
              'IP'=>\request()->ip()
          ]
        );
    }

    public function Api()
    {
        return json_encode(
            [
                'API'=>"Success",
                'STATUS'=>"Success",
                'TIME'=>date('Y-m-d H:i:s'),
                'FORM'=>'GET/POST',
                'IP'=>\request()->ip()
            ]
        );
    }

}
