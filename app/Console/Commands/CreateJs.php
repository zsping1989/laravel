<?php

namespace App\Console\Commands;

use App\Exceptions\CreateCommand;
use Illuminate\Console\GeneratorCommand;

class CreateJs extends GeneratorCommand
{
    use CreateCommand;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:js
    {name : The path of js}
    {type}
    {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom js';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Js';

    /**
     * 获取模板文件名
     * 返回: string
     */
    protected function getTplFile(){
        return 'js.'.$this->argument('type');
    }

    /**
     * 基础数据分配
     */
    protected function initData(){
        //使用数据准备
        $data['name'] =snake_case($this->getNameInput(),'-');
        $data['table'] = $this->argument('table'); //数据表名称
        $data['tpl_controller'] = str_replace('/','-',$this->getNameInput()).'Ctrl';
        $data['dirname'] = dirname($data['name']);
        //dd($data);

        if($data['table']){ //查询数据表信息
            $this->withData($this->getTableInfo($data['table']));
        }
        $this->withData($data);
    }



    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);
        return public_path('http/'.str_replace('\\', '/', $name).'Controller.js');
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model.'],
        ];
    }
}
