<?php

namespace Lincms\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Lincms\Models\LinFile;
use Lincms\Models\LinGroup;
use Lincms\Models\LinLog;
use Lincms\Models\LinPermission;
use Lincms\Models\LinUser;
use Lincms\Requests\LinRequest;
use Pyjhyssc\Requests\BaseRequest;

class CmsController extends LinController
{
    public function login(BaseRequest $request)
    {
        $validate = [
            'username' => 'required',
            'password' => 'required'
        ];
        $request->validate($validate);

        $param = $request->all();
        $user = LinUser::query()->where('username', $param['username'])->first();

        if (!$user) {
            return $this->failed('用户不存在', 401);
        }
        if (!Hash::check($param['password'], $user->password)) {
            return $this->failed('密码错误', 401);
        }

        $token = $user->createToken('admin');

        $msg = $user['username'] . '登陆成功获取了令牌';
        LinLog::add($msg, $user);

        return ['access_token' => $token->plainTextToken];
    }

    //查询自己拥有的权限
    public function getPermissions(Request $request)
    {
        $user = $request->user();
        $permission = [];
        LinPermission::select('id', 'name as permission', 'module')
            ->get()
            ->filter(
                function ($v) use ($user) {
                    if ($user->is_admin) return true;
                    return $user->hasPermission($v);
                }
            )
            ->groupBy('module')
            ->each(function ($v, $k) use (&$permission) {
                $permission[] = [$k => $v];
            });


        $user['permissions'] = $permission;
        $user['admin'] = $user['is_admin'];
        return $user;
    }

    //更新自己密码
    public function updatePassword(LinRequest $request)
    {
        $validate = [
            'old_password' => 'required||current_password:admin',
            'new_password' => 'required',
        ];
        $request->validate($validate);

        $param = $request->all();
        $user = $request->user();

        $user->password = bcrypt($param['new_password']);
        $user->save();
        return $this->message('密码更新成功');
    }

    //更新自己
    public function update(LinRequest $request)
    {
        $param = $request->only(['nickname', 'avatar']);
        $user = $request->user();
        $user->fill($param)->save();
        return $this->message('更新成功');
    }

    //查询自己信息
    public function getInformation(Request $request)
    {
        $user = $request->user();
        $user->groups;
        return $user;
    }

    //查询所有用户
    public function getUsers(Request $request)
    {
        $param = $request->all();
        $list = LinUser::list($param)->noAdmin()->orderByDesc('id')->paginate($request->input('count', 10))->toArray();
        $data['items'] = $list['data'];
        $data['total'] = $list['total'];
        $data['groups'] = $list['total'];

        return $data;
    }


    //用户添加
    public function register(LinRequest $request, LinUser $user)
    {
        $param = $request->all();
        $param['password'] = bcrypt($param['password']);
        $uData = Arr::only($param, ['username', 'email', 'password']);
        $user->fill($uData)->save();
        if (isset($param['group_ids'])) {
            $user->groups()->sync($param['group_ids']);
        }

        return $this->message('注册成功');
    }

    //用户更新
    public function updateUser(LinRequest $request, $id)
    {
        $group_ids = $request->input('group_ids');
        $user = LinUser::query()->findOrFail($id);
        $user->groups()->sync($group_ids);

        return $this->message('更新用户成功');
    }

    //修改用户密码
    public function changeUserPassword(LinRequest $request, $id)
    {
        $user = LinUser::query()->findOrFail($id);
        if ($user['is_admin']) {
            return $this->failed('无法修改管理员用户');
        }
        $password = $request->input('new_password');
        LinUser::query()->where('id', $id)->update(['password' => bcrypt($password)]);
        return $this->message('密码修改成功');
    }

    //删除用户
    public function deleteUser($id)
    {
        $user = LinUser::query()->findOrFail($id);
        if ($user['is_admin']) {
            return $this->failed('无法删除管理员用户');
        }
        $user->delete();
        return $this->message('删除成功');
    }

    //查询所有可分配的权限
    public function getAllPermissions()
    {
        return LinPermission::all()->groupBy('module');
    }

    //查询所有权限组
    public function getAllGroup()
    {
        return LinGroup::all();
    }

    //新建权限组
    public function createGroup(LinRequest $request, LinGroup $group)
    {
        $group->fill($request->only(['info', 'name']))->save();
        $permissionIds = $request->input('permission_ids');
        if ($permissionIds) {
            $group->permission()->sync($permissionIds);
        }
        return $this->message('新建分组成功');
    }

    //查询一个权限组及其权限
    public function getGroup($id)
    {
        $data = LinGroup::query()->findOrFail($id);

        $res = $data->toArray();
        $res['permissions'] = $data->permission;
        return $res;
    }

    //删除多个权限
    public function removePermissions(Request $request)
    {
        $param = $request->all();
        $data = LinGroup::query()->findOrFail($param['group_id']);
        $data->permission()->detach($param['permission_ids']);

        return $this->message('删除权限成功');
    }

    //分配多个权限
    public function dispatchPermissions(LinRequest $request)
    {
        $param = $request->all();
        $data = LinGroup::query()->findOrFail($param['group_id']);
        $data->permission()->attach($param['permission_ids']);

        return $this->message('添加权限成功');
    }

    //删除一个权限组
    public function deleteGroup($id)
    {
        LinGroup::destroy($id);
        return $this->message('删除分组成功');
    }

    //更新一个权限组
    public function updateGroup(LinRequest $request, $id)
    {
        $model = LinGroup::query()->findOrFail($id);
        $param = $request->only(['name', 'info']);
        $model->fill($param)->save();
        return $this->message('更新分组成功');
    }

    //上传
    public function upload(Request $request)
    {
        if (!$files = $request->file()) {
            return $this->failed('没有上传文件');
        }
        $arr = [];
        foreach ($files as $key => $file) {
            $path = Storage:: disk('public')->putFile('/', $file);
            $fileMd5 = md5_file($file->path());

            $extension = $file->extension();
            $data = [
                'path' => $path,
                'type' => 'LOCAL',
                'name' => $path,
                'extension' => $extension,
                'size' => $file->getSize(),
                'md5' => $fileMd5,
            ];
            if (!LinFile::query()->where(['md5' => $fileMd5])->first()) {
                LinFile::query()->create($data);
            }
            $data['key'] = $path;
            $data['url'] = asset(Storage::url($path));
            $arr[] = $data;

        }

        return $arr;
    }

}
