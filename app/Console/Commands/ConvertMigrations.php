<?php
/**
 *  通过数据库表->生成迁徙文件
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:migrations
    {database? : The name of the Database}
    {--ignore= : Table name of Database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts an existing MySQL database to migrations.';

    protected $handleTables = array();//需要处理的表
    protected $database; //数据库

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
        $this->database = $this->argument('database') ?: env('DB_DATABASE'); //数据库
        $ignoreInput = str_replace(' ', '', $this->option('ignore')); //选项数据表
        dd(122);
        $this->appointTable($ignoreInput);

        $this->info('Migration Created Successfully');
    }

    /**
     * 指定需要转换的数据表
     * @param string $tables
     */
    protected function appointTable($tables=''){
        $this->handleTables = $tables ? explode(',',$tables) : $this->notExistTable(); //需要生成的迁徙文件表

    }

    /**
     * 获取数据库中所有表
     * 返回: mixed
     */
    protected function getAllTables(){
        $TABLE_SCHEMA = $this->database;
        return DB::select('SELECT `TABLE_NAME` FROM information_schema.`TABLES` WHERE TABLE_SCHEMA = ?',[$TABLE_SCHEMA]);
    }

    /**
     * 差异比较已有的迁徙表
     * 返回: mixed
     */
    protected function notExistTable(){

        dd($this->getAllTables());

    }

}

