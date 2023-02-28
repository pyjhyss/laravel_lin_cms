<?php

namespace Lincms;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Lincms\Console\InitPermission;
use Lincms\Console\InitUser;
use Lincms\Middleware\CheckPermission;

class LinServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            //发布命令
            $this->commands([Console\InstallCommand::class, InitUser::class, InitPermission::class]);
            //发布配置文件
            $this->publishes([__DIR__.'/../config/permission.php' => config_path('permission.php')], 'lin_config');
        }
        //注册中间件
        Route::aliasMiddleware('checkPermission', CheckPermission::class);

        //发布路由
        $this->loadRoutesFrom(__DIR__.'/../routes/cms.php');
        //发布迁移
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
