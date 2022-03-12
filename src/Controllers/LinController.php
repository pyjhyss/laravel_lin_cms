<?php

namespace Lincms\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Pyjhyssc\Traits\ApiResponse;

class LinController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:admin')->except('login');
        $this->middleware('linLog');

        //动态设置权限
        $className = get_class($this);
        $action = request()->route()->getActionMethod();
        $config = config('permission.url_permission');
        if (array_key_exists($className, $config) && array_key_exists($action, $config[$className])) {
            $this->middleware('checkPermission:' . $config[$className][$action])->only($action);
        }
    }

}
