<?php

use Illuminate\Support\Facades\Route;
use Lincms\Controllers\CmsController;

Route::group(['prefix' => 'cms'], function () {
    Route::post('user/login', [CmsController::class, 'login']); //登录

    //用户
    Route::get('admin/users', [CmsController::class, 'getUsers']); //查所有用户
    Route::post('user/register', [CmsController::class, 'register']); //用户添加
    Route::put('admin/user/{id}', [CmsController::class, 'updateUser']); //更新用户
    Route::put('admin/user/{id}/password', [CmsController::class, 'changeUserPassword']); //修改用户密码
    Route::delete('admin/user/{id}', [CmsController::class, 'deleteUser']); //删除用户

    //权限
    Route::get('admin/permission', [CmsController::class, 'getAllPermissions']); //查所有权限
    Route::get('user/permissions', [CmsController::class, 'getPermissions']); //查询自己拥有的权限
    Route::post('admin/permission/remove', [CmsController::class, 'removePermissions']); //删除多个权限
    Route::post('admin/permission/dispatch/batch', [CmsController::class, 'dispatchPermissions']); //添加多个权限

    //分组
    Route::get('admin/group/all', [CmsController::class, 'getAllGroup']); //所有分组
    Route::post('admin/group', [CmsController::class, 'createGroup']); //新建权限组
    Route::get('admin/group/{id}', [CmsController::class, 'getGroup']); //查询一个权限组及其权限
    Route::put('admin/group/{id}', [CmsController::class, 'updateGroup']); //更新一个权限组
    Route::delete('admin/group/{id}', [CmsController::class, 'deleteGroup']); //删除一个权限组

    //自己
    Route::get('user/information', [CmsController::class, 'getInformation']); //查询自己信息
    Route::put('user/change_password', [CmsController::class, 'updatePassword']); //修改自己密码
    Route::put('user', [CmsController::class, 'update']); //修改自己信息

    //上传
    Route::post('file', [CmsController::class, 'upload']);
});
