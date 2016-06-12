<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateCodes extends Command
{
    /**
     * create:code 代码类型  代码名称
     *
     * @var string
     */
    protected $signature = 'create:code {type : The type of create code} {name : The name of code file}';

    /**
     * 创建自定义代码
     *
     * @var string
     */
    protected $description = 'Create custom code';

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
        dd($this->argument('type'));
    }
}
