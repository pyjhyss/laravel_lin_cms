<?php

namespace Lincms\Middleware;

use Closure;
use Lincms\Common\Api;
use Lincms\Models\LinPermission;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (! $permission = LinPermission::query()->where('name', $permission)->first()) {
            return $next($request);
        }

        $user = $request->user();

        if ($user['is_admin'] && ! $user->hasPermission($permission)) {
            return Api::failed('没有权限');
        }

        return $next($request);
    }
}
