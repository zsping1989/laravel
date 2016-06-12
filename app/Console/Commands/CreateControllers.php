<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateControllers extends Command
{
    /**
     * create:controller 控制器名称
     *
     * @var string
     */
    protected $signature = 'create:controller {name : The name of controller}';

    /**
     * 创建自定义代码
     *
     * @var string
     */
    protected $description = 'Create custom controller';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dd($this->argument('name'));
    }
}
