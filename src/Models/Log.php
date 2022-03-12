<?php

namespace Lincms\Models;


class Log extends Model
{
    protected $guarded = [];
    protected $table = 'lin_log';

    public static function list($param)
    {
        $query = self::query();
        $where = [];
        if (isset($param['name'])) {
            $where[] = ['username', '=', $param['name']];
        }

        if (isset($param['keyword'])) {
            $where[] = ['message', 'like', "%$param[keyword]%"];
        }

        if (isset($param['start']) && isset($param['end'])) {
            $query = $query->whereBetween('created_at', [$param['start'], $param['end']]);
        }

        return $query->where($where);
    }
}
