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
        if ($this->AppKeyIsTrue($request['app_key'])) {
            $key = $request['key'];
            if ($this->KeyIsTrue($key)) {
                $result = KeysModel::where('key', $key)->get();
                $result = $result[0];
                $this->KeyApiLog("IP:" . $request->ip() . "使用KEY:" . $key . "使用APP_KEY:" . $request['app_key'] . "进行IsTrue验证");
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
        if ($this->AppKeyIsTrue($request['app_key'])) {
            $key = $request['key'];
            if ($this->KeyIsTrue($key)) {
                $del = KeysModel::where('key', $key);
                if ($del->delete()) {
                    $this->KeyApiLog("IP:" . $request->ip() . "使用KEY:" . $key . "使用APP_KEY:" . $request['app_key'] . "进行DelKey操作");
                    return json_encode('Success');
                } else {
                    $this->ErrorBack(9999);
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
        if ($this->AppKeyIsTrue($request['app_key'])) {
            if ($this->KeyIsTrue($request['key'])) {

                $status = $request['status'];
                if (empty($status)) {
                    return $this->ErrorBack(1009);
                }
                if (!is_string($status)) {
                    return $this->ErrorBack(1010);
                }
                settype($status, 'int');
                if (!(bool)$status) {
                    return $this->ErrorBack(1010);
                }
                if ($status < -1) {
                    return $this->ErrorBack(1010);
                }
                if ($status > 10) {
                    return $this->ErrorBack(1010);
                }
                $update = KeysModel::where('key', $request['key']);
                if ($update->update(['status' => $request['status']])) {
                    $this->KeyApiLog("IP:" . $request->ip() ."KEY:".$request['key']."Status:".$status."使用APP_KEY:" . $request['app_key'] . "进行UpdateKey操作");
                    return json_encode('Success');
                } else {
                    $this->ErrorBack(9999);
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
        if ($this->AppKeyIsTrue($request['app_key'])) {

            $num = $request['num'];
            $action = $request['action'];

            if (empty($action)) {
                return $this->ErrorBack(1007);
            }
            if (!is_string($action)) {
                return $this->ErrorBack(1008);
            }
            if (empty(ActionModel::all()->contains('id', $action))) {
                return $this->ErrorBack(1008);
            }


            if (empty($num)) {
                return $this->ErrorBack(1005);
            }
            if (!is_string($num)) {
                return $this->ErrorBack(1006);
            }
            settype($num, 'int');
            if (!(bool)$num) {
                return $this->ErrorBack(1006);
            }
            if ($num >= 600) {
                return $this->ErrorBack(1006);
            }
            if ($num <= 0){
                return $this->ErrorBack(1006);
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
            $this->KeyApiLog("IP:" . $request->ip() . "创建数量:" . $num . "Action:" . $action . "使用APP_KEY:" . $request['app_key'] . "进行NewKey操作");
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * @param $ErrorNumber
     * @return string
     */
    public function ErrorBack($ErrorNumber)//报错
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
     * @param $key
     * @return bool
     */
    public function KeyIsTrue($key)//key验证
    {
        if (empty($key)) {
            print_r($this->ErrorBack(1001));
            return false;
        }
        if (!is_string($key)) {
            print_r($this->ErrorBack(1002));
            return false;
        }
        if (strlen($key) !== 32) {
            print_r($this->ErrorBack(1003));
            return false;
        }
        if (empty(KeysModel::all()->contains('key', $key))) {
            print_r($this->ErrorBack(1004));
            return false;
        }
        return true;
    }

    /***
     * @param $content
     */
    public function KeyApiLog($content)//LOG记录
    {
        ApiLogModel::create(['content' => $content]);
    }
}
