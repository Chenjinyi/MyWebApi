# Api Web

 基于laravel框架开发的个人网站api系统

### 目前版本 Beta Version 0.1.6

#### 请求地址

```
POST
	Key:
	http://url/api/key/IsTrue
		app_key:
		key:
	http://url/api/key/NewKey
		app_key:
		num:
		action:
	http://url/api/key/DelKey
		app_key:
		key:
	http://url/api/key/UpdateKey
		app_key:
		key:
		status:
		
	Image:
	http://url/api/image/Upload
		app_key:
		name:
		image: file
		
	http://url/api/image/NameFindImage
		app_key:
		name:
		
	AppKey
	http://url/api/app/FindKey
		app_key:
```

#### Key错误返回码

```
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
```

#### Key Status

```
	* -1 已删除
	* 0 未使用
	* 1 已使用
	* 2 异常
	* 3 暂停使用
	* 4～9 待定
	* 10 未知错误
```

#### Image Status

```
	* -1 已删除
	* 0 正常
	* 1 异常
```

#### 文件目录（功能部分实现）

```
app
├── Http
│   ├── Controllers
│   │   ├── ApiLogController.php Log控制器
│   │   ├── AppKeyController.php Appkey控制器
│   │   ├── ErrorController.php 错误控制器
│   │   ├── ImageController.php 图片控制器
│   │   ├── IndexController.php 首页控制器
│   │   ├── KeysController.php  Key控制器
│   │   └── PostController.php Post控制器（待定）
├── ActionModel.php 操作模型
├── ApiLogModel.php	Log模型
├── AppKeyModel.php	AppKey模型
├── ImageModel.php	Image模型
└── KeysModel.php	Key模型
routes
├── api.php API路由
└── web.php 网站路由
```

#### 更新记录

```
0.1.0 KEY功能实现 
0.1.1 Log功能实现
0.1.2 Image功能实现
0.1.3 轻微优化
0.1.4 App_Key功能实现
0.1.5 重做ErrorBack方法
0.1.6 重做ApiLog方法
```

