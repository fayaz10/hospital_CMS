<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clearLog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the activity log every 15 days';

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
        \DB::table(config('iSys.logTable', 'activity_log'))->truncate();
    }
}
