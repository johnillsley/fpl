<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\ExternalData;

class ImportUnderstats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:understats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import player understat data from external web site';

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
        ExternalData::import_understats();
    }
}
