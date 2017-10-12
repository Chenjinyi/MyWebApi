<?php

namespace App\Http\Controllers;

use App\AppKeyModel;
use Illuminate\Http\Request;

class AppKeyController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function FindKey(Request $request)
    {
        if ($this->AppKeyIsTrue($request['app_key'])){
            $result = AppKeyModel::where('key',$request['app_key'])->get();
            return json_encode($result);
        }
        return $this->ErrorBack(9999);
    }
    
    /**
     * @param $APP_KEY
     * @return bool
     */
    public function AppKeyIsTrue($APP_KEY)//APP_KEY验证
    {
        if (empty($APP_KEY)) {
            print_r($this->ErrorBack(1011));
            return false;
        }
        if (!is_string($APP_KEY)) {
            print_r($this->ErrorBack(1012));
            return false;
        }
        if (empty(AppKeyModel::all()->contains('key', $APP_KEY))) {
            print_r($this->ErrorBack(1012));
            return false;
        }
        return true;
    }

    /***
     * @param $ErrorNumber
     * @return string
     */
    public function ErrorBack($ErrorNumber)//报错
    {
        switch ($ErrorNumber) {
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
