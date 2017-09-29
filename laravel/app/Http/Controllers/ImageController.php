<?php

namespace App\Http\Controllers;

use App\ImageModel;
use App\KeysModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\AppKeyModel;
use App\ApiLogModel;

class ImageController extends Controller
    /***
     * IMAGE ERROR
     * 1021 Image为NULL
     * 1022 Image错误
     * 1023 Image不存在
     *
     * 1024 Name为NULL
     * 1025 Name错误
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
    public function NameFindImage(Request $request)
    {
        if ($this->AppKeyIsTrue($request['app_key'])) {
            if (empty($request['name'])) {
                return $this->ErrorBack(1024);
            }
            if (!is_string($request['name'])) {
                return $this->ErrorBack(1025);
            }
            if (empty(ImageModel::all()->contains('name',$request['name']))){
                return $this->ErrorBack(1023);
            }
            $name = $request['name'];
            $result = ImageModel::where('name',$request['name'])->get();
            $this->KeyApiLog("IP:" . $request->ip()."Name:".$name."使用APP_KEY:" . $request['app_key'] . "进行NameFindImage操作");
            return json_encode($result);

        }
    }
    /***
     * @param Request $request
     * @return string
     */
    public function Upload(Request $request)
    {
        if ($this->AppKeyIsTrue($request['app_key'])) {
            if (!$request->hasFile('image')) {
                return $this->ErrorBack(1021);
            }
            if (!$request->file('image')->isValid()) {
                return $this->ErrorBack(1022);
            }
            if (empty($request['name'])) {
                return $this->ErrorBack(1024);
            }
            if (!is_string($request['name'])) {
                return $this->ErrorBack(1025);
            }
            $path = $request->image->store('public/image/' . date('ymd'));
            ImageModel::create(
                [
                    'name' => $request['name'],
                    'url' => Storage::url($path),
                    'path' => $path,
                ]
            );
            $this->KeyApiLog("IP:" . $request->ip()."上传".Storage::url($path)."使用APP_KEY:" . $request['app_key'] . "进行Upload操作");
            return json_encode(['url' => url(Storage::url($path))], JSON_UNESCAPED_UNICODE);
        }
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
     * @param $content
     */
    public function KeyApiLog($content)//LOG记录
    {
        ApiLogModel::create(['content' => $content]);
    }
}
