<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiLogModel;

class ApiLogController extends Controller
{
    /***
     * @param $content
     */
    public static function ApiLog($request,$content)//LOG记录
    {
        $content = "IP:".$request->ip(). "使用APP_KEY:".$request['app_key'].$content;
        ApiLogModel::create(['content' => $content]);
    }
}
