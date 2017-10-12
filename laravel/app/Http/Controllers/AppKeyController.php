<?php

namespace App\Http\Controllers;

use App\AppKeyModel;
use Illuminate\Http\Request;
use App\Http\Controllers\ErrorController;

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
            ApiLogController::ApiLog($request,'进行FindKey操作');
            return json_encode($result);
        }
        ErrorController::ErrorBack(9999);
    }

    /**
     * @param $APP_KEY
     * @return bool
     */
    public static function AppKeyIsTrue($APP_KEY)//APP_KEY验证
    {
        if (empty($APP_KEY)) {
            print_r(ErrorController::ErrorBack(1011));
            return false;
        }
        if (!is_string($APP_KEY)) {
            print_r(ErrorController::ErrorBack(1012));
            return false;
        }
        if (empty(AppKeyModel::all()->contains('key', $APP_KEY))) {
            print_r(ErrorController::ErrorBack(1012));
            return false;
        }
        return true;
    }

}
