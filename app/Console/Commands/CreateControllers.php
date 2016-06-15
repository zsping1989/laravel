<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateControllers extends GeneratorCommand
{
    /**
     * create:controller 控制器名称
     *
     * @var string
     */
    protected $signature = 'create:controller
    {name : The name of controller}
    {model? : bindModel}
    {--resource : create ResourceController}
    {--verify : verify}';

    /**
     * 创建自定义代码
     *
     * @var string
     */
    protected $description = 'Create custom controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    protected $tpl_dir = 'commands';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //使用数据准备
        $data['php'] = '<?php';
        $data['name'] = $this->parseName($this->getNameInput());
        $data['namespace']  = $this->getNamespace($data['name']);
        $data['class'] = str_replace($data['namespace'].'\\', '', $data['name']);
        $data['resource'] = $this->option('resource'); //资源控制器选项
        $data['model'] =  str_replace('/','\\',$this->argument('model') ?: 'Models\\'.str_replace('Controller','',$data['class'])); //绑定模型
        $data['modelName'] = pathinfo($data['model'])['filename'];
        if($this->option('verify')){ //验证查询

        }
        //dd($data);

        $path = $this->getPath($data['name']);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($data));

        $this->info($this->type.' created successfully.');
    }

    /**
     * 数据渲染
     * param string $data
     * 返回: string
     */
    public function buildClass($data){
        return view($this->tpl_dir.'.controller',$data)->render();
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
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['resource', null, InputOption::VALUE_NONE, 'Generate a resource controller class.'],
        ];
    }


}
