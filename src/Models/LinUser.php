<?php

namespace Lincms\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class LinUser extends Authenticatable
{
    use HasApiTokens, SoftDeletes;

    protected $table = 'lin_user';

    protected $guarded = [];

    protected $hidden = ['password'];

    public static function list($param)
    {
        $where = [];
        if (isset($param['group_id'])) {
            $where[] = ['group_id', '=', $param['group_id']];

            return self::with('groups')->whereHas('groups', function ($q) use ($where) {
                $q->where($where);
            });
        }

        return self::with('groups');
    }

    //不是超级管理员
    public function scopeNoAdmin($query)
    {
        return $query->where('is_admin', '<>', 1);
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ? asset(Storage::url($value)) : '',
        );
    }

    //分组
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(LinGroup::class, 'lin_user_group', 'user_id', 'group_id');
    }

    //判断是否包含分组
    public function hasPermission($permission)
    {
        return $this->hasGroup($permission->group);
    }

    //判断是否包含某个权限
    public function hasGroup($group)
    {
        return $group->intersect($this->groups)->count();
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
