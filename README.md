# 1.在AUTH GUARD中添加
## 1.1 config->auth.php配置文件中添加

驱动为cas
```
    'store' =>[
        'driver' =>'cas',
        'provider' => 'store',
    ]    
```
服务的提供者为eloquent
（通过主键id来查询对应的登陆账号信息）
```
'providers' => [
    'store' => [ 
        'driver' => 'eloquent',
        'model' => App\Models\StoreAccout::class
    ]
],
```

> 中间件中使用过

```
Auth::guard('store')->check()
```

# 2.单独使用验证ticket
app('cas')->check(string $ticket);
通过返回登陆的携带信息
不通过返回false

```
[
    'login_data' => [
        'id' => 'name',
        'uname' => '全景智慧城市'
    ],
    'client' => 'store'
]
```