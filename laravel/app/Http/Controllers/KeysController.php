<?php

namespace App\Http\Controllers;

use App\ActionModel;
use App\AppKeyModel;
use App\Http\Requests\PostKeyRequest;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\KeysModel;
use PhpParser\Error;
use PhpParser\Node\Expr\Cast\Int_;
use App\ApiLogModel;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class KeysController extends Controller
    /***
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
     *
     */
{
    /***
     * @param Request $request
     * @return string
     */
    public function IsTrue(Request $request) //Key是否存在
    {
        if (AppKeyController::AppKeyIsTrue($request['app_key'])) {
            $key = $request['key'];
            if ($this->KeyIsTrue($key)) {
                $result = KeysModel::where('key', $key)->get();
                $result = $result[0];
                ApiLogController::ApiLog($request, "使用KEY:" . $key . "进行IsTrue验证");
                return $result;
            }
        }
    }

    /***
     * @param Request $request
     * @return string
     */
    public function DelKey(Request $request) //删除Key
    {
        if (AppKeyController::AppKeyIsTrue($request['app_key'])) {
            $key = $request['key'];
            if ($this->KeyIsTrue($key)) {
                $del = KeysModel::where('key', $key);
                if ($del->delete()) {
                    ApiLogController::ApiLog($request, "使用KEY:" . $key. "进行DelKey操作");
                    return json_encode('Success');
                } else {
                    ErrorController::ErrorBack(9999);
                }
            }
        }
    }

    /***
     * @param Request $request
     * @return string
     */
    public function UpdateKey(Request $request)
    {
        if (AppKeyController::AppKeyIsTrue($request['app_key'])) {
            if ($this->KeyIsTrue($request['key'])) {

                $status = $request['status'];
                if (empty($status)) {
                    return ErrorController::ErrorBack(1009);
                }
                if (!is_string($status)) {
                    return ErrorController::ErrorBack(1010);
                }
                settype($status, 'int');
                if (!(bool)$status) {
                    return ErrorController::ErrorBack(1010);
                }
                if ($status < -1) {
                    return ErrorController::ErrorBack(1010);
                }
                if ($status > 10) {
                    return ErrorController::ErrorBack(1010);
                }
                $update = KeysModel::where('key', $request['key']);
                if ($update->update(['status' => $request['status']])) {
                    ApiLogController::ApiLog($request,"KEY:".$request['key']."Status:".$status. "进行UpdateKey操作");
                    return json_encode('Success');
                } else {
                    ErrorController::ErrorBack(9999);
                }

            }
        }
    }

    /***
     * @param Request $request
     * @return string
     */
    public function NewKey(Request $request)//生成Key
    {
        if (AppKeyController::AppKeyIsTrue($request['app_key'])) {

            $num = $request['num'];
            $action = $request['action'];

            if (empty($action)) {
                return ErrorController::ErrorBack(1007);
            }
            if (!is_string($action)) {
                return ErrorController::ErrorBack(1008);
            }
            if (empty(ActionModel::all()->contains('id', $action))) {
                return ErrorController::ErrorBack(1008);
            }


            if (empty($num)) {
                return ErrorController::ErrorBack(1005);
            }
            if (!is_string($num)) {
                return ErrorController::ErrorBack(1006);
            }
            settype($num, 'int');
            if (!(bool)$num) {
                return ErrorController::ErrorBack(1006);
            }
            if ($num >= 600) {
                return ErrorController::ErrorBack(1006);
            }
            if ($num <= 0){
                return ErrorController::ErrorBack(1006);
            }
            for ($i = 1; $i <= $num; $i++) {
                $NewKey = strtoupper(md5(uniqid('F')));
                KeysModel::create(
                    [
                        'key' => $NewKey,
                        'action' => $action
                    ]
                );
                $result[$i] = $NewKey;
            }
            ApiLogController::ApiLog($request, "创建数量:" . $num . "Action:" . $action . "进行NewKey操作");
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    /***
     * @param $key
     * @return bool
     */
    public function KeyIsTrue($key)//key验证
    {
        if (empty($key)) {
            print_r(ErrorController::ErrorBack(1001));
            return false;
        }
        if (!is_string($key)) {
            print_r(ErrorController::ErrorBack(1002));
            return false;
        }
        if (strlen($key) !== 32) {
            print_r(ErrorController::ErrorBack(1003));
            return false;
        }
        if (empty(KeysModel::all()->contains('key', $key))) {
            print_r(ErrorController::ErrorBack(1004));
            return false;
        }
        return true;
    }
}
