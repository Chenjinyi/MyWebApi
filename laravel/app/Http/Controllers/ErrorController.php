<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
    /**
     * KEY ERROR
     * 1001 = Key值为NUL
     * 1002 = Key类型错误
     * 1003 = Key长度错误
     * 1004 = Key不存在
     *
     * 1005 = Num值为NULL
     * 1006 = Num数值错误
     *
     * 1007 = Action值为NULL
     * 1008 = Action错误
     *
     * 1009 = Status为空
     * 1010 = Status错误
     *
     * APP_KEY ERROR
     * 1011 = APP_KEY为空
     * 1012 = APP_KEY错误

     * 1021 Image为NULL
     * 1022 Image错误
     * 1023 Image不存在
     *
     * 1024 Name为NULL
     * 1025 Name错误
     *
     */
{
    /***
     * @param $ErrorNumber
     * @return string
     */
    public static function ErrorBack($ErrorNumber)//报错
    {
        switch ($ErrorNumber) {
            case 1001:
                $Error = "1001";
                $Content = "KEY值为NULL";
                break;
            case 1002:
                $Error = "1002";
                $Content = "KEY类型错误";
                break;
            case 1003:
                $Error = "1003";
                $Content = "KEY长度错误";
                break;
            case 1004:
                $Error = "1004";
                $Content = "KEY不存在";
                break;
            case 1005:
                $Error = "1005";
                $Content = "NUM值为NULL";
                break;
            case 1006:
                $Error = "1006";
                $Content = "NUM数值错误";
                break;
            case 1007:
                $Error = "1007";
                $Content = "Action值为NULL";
                break;
            case 1008:
                $Error = "1008";
                $Content = "Action数值错误";
                break;
            case 1009:
                $Error = "1009";
                $Content = "Status值为NULL";
                break;
            case 1010:
                $Error = "1010";
                $Content = "Status数值错误";
                break;
            case 1011:
                $Error = "1011";
                $Content = "APP_KEY值为NULL";
                break;
            case 1012:
                $Error = "1012";
                $Content = "APP_KEY错误";
                break;
            case 1021:
                $Error = "1021";
                $Content = "Image值为NULL";
                break;
            case 1022:
                $Error = "1022";
                $Content = "Image错误";
                break;
            case 1023:
                $Error = "1023";
                $Content = "Image不存在";
                break;
            case 1024:
                $Error = "1024";
                $Content = "Name值为NULL";
                break;
            case 1025:
                $Error = "1025";
                $Content = "Name错误";
                break;
            case 1011:
                $Error = "1011";
                $Content = "APP_KEY值为NULL";
                break;
            case 1012:
                $Error = "1012";
                $Content = "APP_KEY错误";
                break;
            case 9999:
                $Error = "9999";
                $Content = " 未知错误";
                break;
            default:
                $Error = "9999";
                $Content = " 未知错误";
                break;
        }

        return json_encode([
            'Error' => $Error,
            'Content' => $Content
        ], JSON_UNESCAPED_UNICODE);
    }
}
