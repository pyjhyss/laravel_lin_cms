<?php

use Lincms\Controllers\BookController;
use Lincms\Controllers\LogController;

return [
    //格式：分组=>[权限]
    //注意：1、修改后需执行php artisan cms:init_Permission更新数据库
    //     2、更新数据库后分组权限表会清空，需重新关联权限组
    'permission' => [
        '日志' => ['查询所有日志', '查询日志记录的用户'],
        '图书' => ['图书管理', '添加图书', '编辑图书', '删除图书']
    ],
    //格式：控制器=>[方法=>权限]
    'url_permission' => [
        LogController::class => ['index' => '查询所有日志', 'users' => '查询日志记录的用户'],
        BookController::class => ['index' => '图书管理', 'store' => '添加图书', 'update' => '编辑图书', 'destroy' => '删除图书']
    ],
];