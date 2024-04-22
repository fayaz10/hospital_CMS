<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dailyBackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Backup at midnight.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $process;

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
        try {
            $this->process->mustRun();

            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            echo $exception->getMessage();
            $this->error('The backup process has been failed.');
        }
    }
}
