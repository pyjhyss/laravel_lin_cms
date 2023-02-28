<?php

namespace Lincms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LinGroup extends Model
{
    protected $guarded = [];

    protected $table = 'lin_group';

    //用户
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(LinUser::class, 'user_group', 'group_id', 'user_id');
    }

    //权限
    public function permission(): BelongsToMany
    {
        return $this->belongsToMany(LinPermission::class, 'lin_group_permission', 'group_id', 'permission_id');
    }
}
