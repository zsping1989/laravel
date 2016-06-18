<?php

namespace App\Console\Commands;

use App\Exceptions\CreateCommand;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\DB;

class ConvertMigrations extends GeneratorCommand
{
    //创建代码扩展类
    use CreateCommand;

    /**
     * 创建命令
     * 说明:convert:migration 数据表名
     * 变量 string
     */
    protected $signature = 'convert:migration
    {name : The name of table}';


    /**
     * 命令描述
     * 变量 string
     */
    protected $description = 'Convert migration';


    /**
     * 生成的class类型
     * 变量 string
     */
    protected $type = 'Migration';

    /**
     * 获取模板文件名
     * 返回: string
     */
    protected function getTplFile(){
        return 'migration';
    }


    /**
     * 基础数据分配
     */
    protected function initData(){
        $data['php'] = '<?php';
        $data['name'] = $this->getNameInput();
        $data['table'] = snake_case($this->getNameInput());
        $data['class'] = ucfirst(camel_case($this->getNameInput()));
        //查询数据表创建sql
        $table_info = DB::select('SHOW CREATE TABLE `'.config('database.connections.mysql.prefix').$data['table'].'`')[0];
        foreach($table_info as $key=>$value){
            if($key=='Table'){
                $data['true_table'] = $value;
            }else{
                $prefix = config('database.connections.mysql.prefix');
                $data['create'] = $prefix ? str_replace('CREATE TABLE `'.$prefix,
                    'CREATE TABLE `".config(\'database.connections.mysql.prefix\')."',
                    $value) : $value;
            }
        }
        //dd($data);
        $this->withData($data);
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name){
        $name = str_replace($this->laravel->getNamespace(), '', $name);
        return database_path('migrations/create_'.$name.'_table.php');
    }


    /**
     * 创建命令选项
     * 返回: array
     */
    protected function getOptions()
    {
        return [];
    }


}
