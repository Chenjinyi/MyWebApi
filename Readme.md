# Api Web

 基于laravel框架开发的个人网站api系统



请求地址

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
```

Key错误返回码

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

Key Status

```
	* -1 已删除
	* 0 未使用
	* 1 已使用
	* 2 异常
	* 3 暂停使用
	* 4～9 待定
	* 10 未知错误
```

Image Status

```
	* -1 已删除
	* 0 正常
	* 1 异常
```

