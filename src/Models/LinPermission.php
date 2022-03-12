<?php

namespace Lincms\Models;


class LinPermission extends Model
{
    protected $table = 'lin_permission';

    //分组
    public function group()
    {
        return $this->belongsToMany(LinGroup::class, 'lin_group_permission', 'permission_id', 'group_id');
    }

}
