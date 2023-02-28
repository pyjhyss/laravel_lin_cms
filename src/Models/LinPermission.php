<?php

namespace Lincms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LinPermission extends Model
{
    protected $table = 'lin_permission';

    //分组
    public function group(): BelongsToMany
    {
        return $this->belongsToMany(LinGroup::class, 'lin_group_permission', 'permission_id', 'group_id');
    }
}
