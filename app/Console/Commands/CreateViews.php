<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CreateViews extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:view
    {name : The path of view}
    {type}
    {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom view';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    protected $tpl_dir = 'commands'; //模板目录
    protected $tpl_type; //模板类型
    protected $data = []; //渲染数据
    public function withData(array $data,$key=''){
        if($key){
            $this->data = collect($this->data)->put($key,$data);
        }else{
            $this->data = collect($this->data)->merge($data);
        }
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->tpl_type = $this->argument('type'); //页面类型
        //使用数据准备
        $data['tpl_start'] = '{{';
        $data['tpl_end'] = '}}';
        $data['name'] =snake_case($this->getNameInput(),'-');
        $data['table'] = $this->argument('table'); //数据表名称
        $data['tpl_controller'] = str_replace('/','-',$this->getNameInput()).'Ctrl';
        $data['dirname'] = dirname($data['name']);
        //dd($data);

        if($data['table']){ //查询数据表信息
           $this->withData($this->getTableInfo($data['table']));
        }
        $this->withData($data);

        $path = public_path('http/'.$data['name']);
        //dd($path);
        if ($this->alreadyExists( $data['name'])) {
            $this->error($this->type.' already exists!');
            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($this->getPath($data['name']), $this->buildClass(''));

        $this->info($this->type.' created successfully.');
    }

    /**
     * 获取数据表字段信息
     * param $table
     * 返回: mixed
     */
    public function getTableInfo($table){
        $trueTable = Config::get('database.connections.mysql.prefix').$table;
        //数据表备注信息
        $data['table_comment'] =  DB::select('SELECT TABLE_COMMENT FROM information_schema.`TABLES` WHERE TABLE_SCHEMA= :db_name AND TABLE_NAME = :tname',
            [
                'db_name'=>Config::get('database.connections.mysql.database'),
                'tname'=>$trueTable
            ]);
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
                return $item;
            });
        return $data;
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

    /**
     * 数据渲染
     * param string $data
     * 返回: string
     */
    public function buildClass($data){
        //dd($this->data->toArray());
        return view($this->tpl_dir.'.view.'.$this->tpl_type,$this->data->toArray())->render();
    }



    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
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
