<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PaymentDone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'isys:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment has been done.';

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
        $dates = json_decode(file_get_contents(storage_path() . "\\dates.json"), true);
        $thisMonth = $dates[0] ?? null;

        if(!$thisMonth){
            $this->error('Payment dates not specified in file.');
            return false;
        } 

        $password = $this->secret('Please enter the cipher');

        if($password != 'hosys@isys2020'){
            $this->error('Wrong cipher.');
            return false;
        }

        $pattern = $this->secret('Please enter month\'s pattern');
        $thisMonth = \Carbon\Carbon::createFromFormat('Y-m-d', $thisMonth);

        if( $thisMonth->format('nd\i\s\y\sy') != $pattern){
            $this->error('Wrong pattern.');
            return false;
        }

        $dates = array_slice($dates, 1);

        file_put_contents(storage_path() . "\\dates.json", json_encode($dates));
        
        $this->info('Payment has successfully done.');
    }
}
