<?php

namespace App\Console\Commands;

use App\Exceptions\CreateCommand;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;

class CreateModels extends GeneratorCommand
{
    use CreateCommand;

    /**
     * 创建命令
     * 说明:create:model 模型名称 数据表名称(选填)
     * 变量 string
     */
    protected $signature = 'create:model
    {name : The name of model}
    {table? : The table of database}
    {--fields}
    {--tree}
    {--softDeletes}';

    /**
     * 命令说明
     * 变量: string
     */
    protected $description = 'Create custom model.';

    /**
     * 生成的class类型
     * 变量 string
     */
    protected $type = 'Model';

    /**
     * 模板文件
     * 返回: string
     */
    protected function getTplFile(){
        return 'model';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(){
        return [
            ['fields', 'f', InputOption::VALUE_NONE, 'fields in model.'],
            ['tree', 't', InputOption::VALUE_NONE, 'tree of model.'],
            ['softDeletes', 's', InputOption::VALUE_NONE, 'softDeletes of model.']
        ];
    }


    /**
     * 基础数据分配
     */
    protected function initData(){
        //使用数据准备
        $data['php'] = '<?php';
        $data['name'] = $this->parseName($this->getNameInput());
        $data['namespace']  = $this->getNamespace($data['name']);
        $data['class'] = str_replace($data['namespace'].'\\', '', $data['name']);
        $data['table'] = $this->argument('table') ?: ''; //数据表名称

        //选项
        $data['tree'] = $this->option('tree'); //树状结构选项
        $data['softDeletes'] = $this->option('softDeletes'); //软删除模式选项
        if($data['fields'] = $this->option('fields')){ //字段生成

        }
        $this->withData($data);
    }





}
