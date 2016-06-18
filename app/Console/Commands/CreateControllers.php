<?php

namespace App\Console\Commands;

use App\Exceptions\CreateCommand;
use Illuminate\Console\GeneratorCommand;

class CreateControllers extends GeneratorCommand
{
    //创建代码扩展类
    use CreateCommand;

    /**
     * 创建命令
     * 说明:create:controller 控制器名称 模型名称(选填)
     * 变量 string
     */
    protected $signature = 'create:controller
    {name : The name of controller}
    {model? : bindModel}
    {--resource : create ResourceController}
    {--verify : verify}';


    /**
     * 命令描述
     * 变量 string
     */
    protected $description = 'Create custom controller';


    /**
     * 生成的class类型
     * 变量 string
     */
    protected $type = 'Controller';

    /**
     * 获取模板文件名
     * 返回: string
     */
    protected function getTplFile(){
        return 'controller';
    }


    /**
     * 基础数据分配
     */
    protected function initData(){
        $data['php'] = '<?php';
        $data['name'] = $this->parseName($this->getNameInput());
        $data['namespace']  = $this->getNamespace($data['name']);
        $data['class'] = str_replace($data['namespace'].'\\', '', $data['name']);
        $data['resource'] = $this->option('resource'); //资源控制器选项
        $data['model'] =  str_replace('/','\\',$this->argument('model') ?: 'Models\\'.str_replace('Controller','',$data['class'])); //绑定模型
        $data['modelName'] = pathinfo($data['model'])['filename'];
        if($this->option('verify')){ //验证查询
            $tableInfo = $this->getTableInfo(snake_case($data['modelName']).'s');
            $this->withData($tableInfo);
            $data['validates'] = $tableInfo['table_fields']->map(function($item){
                if($item->validator){
                    return "'".$item->Field."'=>'".$item->validator."'";
                }
            })->filter(function($item){
                return $item;
            })->implode(",");
            //dd($data);
        }
        $this->withData($data);
    }


    /**
     * Get the default namespace for the class.
     *
     * 参数  string  $rootNamespace
     * 返回 string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }


    /**
     * 创建命令选项
     * 返回: array
     */
    protected function getOptions()
    {
        return [
            ['resource', null, InputOption::VALUE_NONE, 'Generate a resource controller class.'],
            ['verify', null, InputOption::VALUE_NONE, 'verify parameters']
        ];
    }


}
