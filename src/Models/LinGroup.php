<?php

namespace Lincms\Models;


class LinGroup extends Model
{
    protected $guarded = [];
    protected $table = 'lin_group';


    //用户
    public function user()
    {
        return $this->belongsToMany(LinUser::class, 'user_group', 'group_id', 'user_id');
    }

    //权限
    public function permission()
    {
        return $this->belongsToMany(LinPermission::class, 'lin_group_permission', 'group_id', 'permission_id');
    }
}
