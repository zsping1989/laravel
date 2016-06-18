<?php

namespace App\Console\Commands;

use App\Exceptions\CreateCommand;
use Illuminate\Console\GeneratorCommand;

class CreateViews extends GeneratorCommand
{
    use CreateCommand;
    /**
     * 创建命令
     * 说明:create:view 视图路径 视图类型 数据表
     * 变量 string
     */
    protected $signature = 'create:view
    {name : The path of view}
    {type}
    {table?}';

    /**
     * 命令说明
     * 变量 string
     */
    protected $description = 'Create custom view';

    /**
     * 创建代码类型
     * 变量 string
     */
    protected $type = 'View';

    /**
     * 获取模板文件名
     * 返回: string
     */
    protected function getTplFile(){
        return 'view.'.$this->argument('type');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * 基础数据分配
     */
    protected function initData(){
        //使用数据准备
        $data['tpl_start'] = '{{';
        $data['tpl_end'] = '}}';
        $data['name'] =snake_case($this->getNameInput(),'-');
        $data['table'] = $this->argument('table'); //数据表名称
        $data['tpl_controller'] = str_replace('/','-',$this->getNameInput()).'Ctrl';
        $data['dirname'] = dirname($data['name']);
        $data['label_style'] = ['primary','success','info','warning','danger','default','primary','success','info','warning','danger','default'];
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
        return public_path('http/'.str_replace('\\', '/', $name).'.html');
    }




}
