# 快速开始

## 安装

```shell
$ composer require pyjhyssc/laravel_lin_cms 
```

## 使用

- 执行以下命令初始化

```shell
php artisan cms:install
```

- 运行上面命令后，修改config/auth.php配置文件,在guards里追加admin配置,在providers数组里追加Admins配置

```
'guards' => [

    ...
    
    'admin' => [
        'driver' => 'sanctum',
        'provider' => 'admins',
        ]
    ],

...

'providers' => [
        
        ...
        
        'admins' => [
            'driver' => 'eloquent',
            'model' => \Lincms\Models\LinUser::class,
        ],
    ],
```

- 权限配置文件在config/permission,修改里面permission数组需执行```php artisan cms:init_Permission```
  才能生效，注意（分组权限中间表会清空，需重新关联分组权限）;要为路由设置权限只需修改url_permission数组,格式：控制器=>[方法=>权限]，
- 例：

```
'url_permission' => [
        BookController::class => ['index' => '图书管理', 'store' => '添加图书', 'update' => '编辑图书', 'destroy' => '删除图书']
    ],
];
```

- 修改env里APP_URL、FILESYSTEM_DISK

```
APP_URL=http://laravel10.test
FILESYSTEM_DISK=public
```