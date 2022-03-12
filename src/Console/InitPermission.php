<?php

namespace Lincms\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Lincms\Models\LinPermission;

class InitPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:init_Permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化数据库';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->InitPermissionS();

    }


    public function InitPermissionS()
    {
        $this->comment('开始更新');
        $config = config('permission.permission');
        if (!$config) {
            $req = require(__DIR__ . '/../../config/permission.php');
            $config = $req['permission'];
        }
        $data = [];
        $time = date('Y-m-d H:i:s');
        foreach ($config as $k => $v) {
            foreach ($v as $vv) {
                $arr['name'] = $vv;
                $arr['module'] = $k;
                $arr['created_at'] = $time;
                $arr['updated_at'] = $time;
                $data[] = $arr;
            }
        }
        LinPermission::query()->truncate();
        DB::table('lin_group_permission')->truncate();
        LinPermission::query()->insert($data);
        $this->info('更新成功');
    }

}
