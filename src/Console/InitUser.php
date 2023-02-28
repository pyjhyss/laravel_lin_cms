<?php

namespace Lincms\Console;

use Illuminate\Console\Command;
use Lincms\Models\LinUser;

class InitUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:init_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化数据库';

    public function handle()
    {
        $this->InitUser();
    }

    public function InitUser()
    {
        LinUser::query()->firstOrCreate(
            ['id' => 1],
            [
                'username' => 'root',
                'nickname' => '超级管理员',
                'avatar' => '',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'is_admin' => 1,
            ]
        );
    }
}
