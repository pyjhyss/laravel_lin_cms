<?php

namespace Lincms\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the lin_cms resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('开始安装');
        $this->callSilent('vendor:publish', ['--tag' => 'lin_config']);
        $this->comment('迁移数据库...');
        $this->callSilent('migrate');
        $this->comment('生成数据...');
        $this->callSilent('cms:init_user');
        $this->callSilent('cms:init_Permission');
        $this->callSilent('storage:link');
        $this->info('安装成功');
    }

}
