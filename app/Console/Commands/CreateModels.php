<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model {name : The name of model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom model';

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
        //
    }
}
