<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\ExternalData;
use App\Week;

class ImportPerformances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:performances {week?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import player performance data from external web service';

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
        if (!empty($this->argument('week'))) {
            $week = $this->argument('week');
        } else {
            // Get current week.
            $week = Week::where('is_current', '=', 1)->first()->id;
        }
        ExternalData::import_performances($week);
    }
}
