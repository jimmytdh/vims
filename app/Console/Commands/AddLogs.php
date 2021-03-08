<?php

namespace App\Console\Commands;

use App\Http\Controllers\LogsController;
use Illuminate\Console\Command;

class AddLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will insert description to logs';

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
     * @return int
     */
    public function handle()
    {
        LogsController::createLog('Create something');
        echo 'Operation complete!';
    }
}
