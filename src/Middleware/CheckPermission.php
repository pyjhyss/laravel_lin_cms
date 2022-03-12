<?php

namespace Lincms\Middleware;

use Closure;
use Lincms\Models\LinPermission;
use Pyjhyssc\Exceptions\ApiRequestExcept;

class CheckPermission
{

    public function handle($request, Closure $next, $permission)
    {
        if (!$permission = LinPermission::query()->where('name', $permission)->first()) {
            return $next($request);
        }

        $user = $request->user();
        if (!$user['is_admin'] && !$user->hasPermission($permission)) {
            throw new ApiRequestExcept('没有权限');
        }
        return $next($request);
    }
}
