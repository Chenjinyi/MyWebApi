<?php

namespace App\Http\Controllers;

use App\ImageModel;
use App\KeysModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\AppKeyModel;
use App\ApiLogModel;
use App\Http\Controllers\ErrorController;

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
        if (AppKeyController::AppKeyIsTrue($request['app_key'])) {
            if (empty($request['name'])) {
                return ErrorController::ErrorBack(1024);
            }
            if (!is_string($request['name'])) {
                return ErrorController::ErrorBack(1025);
            }
            if (empty(ImageModel::all()->contains('name',$request['name']))){
                return ErrorController::ErrorBack(1023);
            }
            $name = $request['name'];
            $result = ImageModel::where('name',$request['name'])->get();
            ApiLogController::ApiLog($request,"Name:".$name. "进行NameFindImage操作");
            return json_encode($result);

        }
    }

    /***
     * @param Request $request
     * @return string
     */
    public function Upload(Request $request)
    {
        if (AppKeyController::AppKeyIsTrue($request['app_key'])) {
            if (!$request->hasFile('image')) {
                return ErrorController::ErrorBack(1021);
            }
            if (!$request->file('image')->isValid()) {
                return ErrorController::ErrorBack(1022);
            }
            if (empty($request['name'])) {
                return ErrorController::ErrorBack(1024);
            }
            if (!is_string($request['name'])) {
                return ErrorController::ErrorBack(1025);
            }
            $path = $request->image->store('public/image/' . date('ymd'));
            ImageModel::create(
                [
                    'name' => $request['name'],
                    'url' => Storage::url($path),
                    'path' => $path,
                ]
            );
            ApiLogController::ApiLog($request,"上传".Storage::url($path). "进行Upload操作");
            return json_encode(['url' => url(Storage::url($path))], JSON_UNESCAPED_UNICODE);
        }
    }
}
