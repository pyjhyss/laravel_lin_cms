<?php

namespace Lincms\Models;


use Illuminate\Support\Facades\Auth;

class LinLog extends Model
{
    protected $guarded = [];
    protected $table = 'lin_log';

    public static function add($msg, $user = [])
    {
        $request = request();
        if (!$user) {
            $user = Auth::user();
        }
        $data['user_id'] = $user['id'];
        $data['message'] = $msg;
        $data['username'] = $user['username'];
        $data['method'] = $request->method();
        $data['path'] = $request->path();

        self::query()->create($data);
    }

    public static function list($param)
    {
        $where = [];
        if (isset($param['keyword'])) {
            $where[] = ['message', 'like', "%$param[keyword]%"];
        }

        if (isset($param['name'])) {
            $where[] = ['username', '=', $param['name']];
        }

        return self::query()->where($where);
    }
}
