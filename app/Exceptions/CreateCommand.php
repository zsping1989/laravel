<?php
/**
 * 创建命令扩展类
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/17
 * 时间: 10:06
 */

namespace App\Exceptions;
use Illuminate\Support\Facades\DB;


trait CreateCommand
{
    /**
     * 获取模板文件
     */
    abstract protected function getTplFile();


    /**
     * 获取模板目录
     * 返回: string
     */
    protected function getTplDir (){
        return config('command.template_directory');
    }

    /**
     * 数据存放
     * 参数: array $data
     * 参数: string $key
     */
    public function withData(array $data,$key=''){
        if(!isset($this->data)){
            $this->data = [];
        }
        if($key){
            $this->data = collect($this->data)->put($key,$data);
        }else{
            $this->data = collect($this->data)->merge($data);
        }
    }

    /**
     * 数据渲染
     * param string $data
     * 返回: string
     */
    public function buildClass($data){
        return view($this->getTplDir().'.'.$this->getTplFile(),$this->data->toArray())->render();
    }


    /**
     * 执行代码生成
     * 返回 mixed
     */
    public function handle()
    {
        //生成代码的存放路径
        $path = $this->getPath($this->parseName($this->getNameInput()));
        //检查要生成的代码是否已经存在
        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');
            return false;
        }
        //创建目录
        $this->makeDirectory($path);
        //创建代码需要的基础数据
        $this->initData();
        //生成代码文件
        $this->files->put($path, $this->buildClass(null));
        $this->addAutoload();
        //结果提示输出
        $this->info($this->type.' created successfully.');
    }

    /**
     * 获取数据表字段信息
     * param $table
     * 返回: mixed
     */
    public function getTableInfo($table){
        $trueTable = config('database.connections.mysql.prefix').$table;
        //数据表备注信息
        $data['table_comment'] =  DB::select('SELECT TABLE_COMMENT FROM information_schema.`TABLES` WHERE TABLE_SCHEMA= :db_name AND TABLE_NAME = :tname',
            [
                'db_name'=>config('database.connections.mysql.database'),
                'tname'=>$trueTable
            ])[0]->TABLE_COMMENT;
        //字段信息
        $data['table_fields'] = collect(DB::select('show full COLUMNS from `'.$trueTable.'`'))
            ->map(function($item){
                $comment = explode('@',$item->Comment);
                $item->validator = array_get($comment,'1',''); //字段验证
                $comment = explode('$',$comment[0]);
                $item->showType = in_array($item->Field,['created_at','updated_at']) ? 'time' : array_get($comment,'1',''); //字段显示类型
                $item->showType = in_array($item->Field,['deleted_at','left_margin','right_margin','level','remember_token']) ? 'hidden' :  $item->showType;
                $comment = explode(':',$comment[0]);
                $info = ['created_at'=>'创建时间','updated_at'=>'修改时间'];
                $item->info = isset($info[$item->Field]) ? $info[$item->Field]: $comment[0]; //字段说明
                $item->info =  $item->info ?: $item->Field;
                $comment = explode(',',array_get($comment,'1',''));
                //dd($comment);
                $item->values = collect($comment)->map(function($item){
                    return explode('-',$item);
                })->pluck('1','0')->filter(function($item){
                    return $item;
                })->toArray(); //字段值
                $item->showType = (!$item->showType && $item->values) ? 'radio' : $item->showType;
                $item->showType = !$item->showType ? 'text' : $item->showType;
                return $item;
            });
        return $data;
    }


    /**
     * 获取sub模板,不需要使用
     * 返回 string
     */
    protected function getStub(){

    }

    /**
     * 生成文件加入自动加载
     */
    protected function addAutoload(){

    }

}