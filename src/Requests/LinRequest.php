<?php

namespace Lincms\Requests;

use Pyjhyssc\Requests\BaseRequest;

class LinRequest extends BaseRequest
{
    public array $rules = [
        'username' => 'required|unique:lin_user',
        'password' => 'required',
        'nickname' => 'required',
        'old_password' => 'required|current_password:admin',
        'new_password' => 'required',
        'email' => 'email',
        'confirm_password' => 'required',
        'info' => 'required',
        'name' => 'required',
        'permission_ids' => 'array',
        'group_id' => 'required',
        'group_ids' => 'array',
    ];
    public array $scene = [
        //更新自己密码
        'updatePassword' => ['old_password', 'new_password', 'confirm_password'],
        //创建权限组
        'createGroup' => ['info', 'name', 'permission_ids'],
        //更新权限组
        'updateGroup' => ['info', 'name'],
        //更新权限组对应权限
        'dispatchPermissions' => ['group_id', 'permission_ids'],
        //添加用户
        'register' => ['username', 'password', 'confirm_password', 'email', 'group_ids'],
        //修改用户密码
        'changeUserPassword' => ['new_password', 'confirm_password'],
        //更新用户
        'updateUser' => ['group_ids'],

    ];

}
