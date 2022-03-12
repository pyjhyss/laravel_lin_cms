<?php

namespace Lincms\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LinLog
{

    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $statusCode = $response->getStatusCode();
        $user = Auth::user();
        if ($statusCode != 200 || !$user) {
            return;
        }

        $controller = $request->route()->getAction()['controller'];
        $username = $user['username'];
        switch ($controller) {
            case 'Lincms\Controllers\CmsController@register':
                $msg = $username . '新建了用户' . $request->input(['username']);
                break;

            case 'Lincms\Controllers\BookController@store':
                $msg = $username . '新建了一编文章:' . $request->input(['title']);
                break;

            case 'Lincms\Controllers\BookController@destroy':
                $msg = $username . '删除了id为' . $request->route()->parameters()['book'] . '的文章';
                break;
            default:
                return;
        }

        \Lincms\Models\LinLog::add($msg);
    }

}
