<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;

class CreateModels extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model
    {name : The name of model}
    {table? : The table of database}
    {--fields}
    {--tree}
    {--softDeletes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

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
        $data['table'] = $this->argument('table') ? Config::get('database.connections.mysql.prefix').$this->argument('table') : ''; //数据表名称

        //选项
        $data['tree'] = $this->option('tree'); //树状结构选项
        $data['softDeletes'] = $this->option('softDeletes'); //软删除模式选项
        if($data['fields'] = $this->option('fields')){ //字段生成

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
        return view($this->tpl_dir.'.model',$data)->render();
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
