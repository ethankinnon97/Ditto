<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeneratePaymentDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates payment schedules for sales staff';

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
         $this->info('test');
    }
}
