<?php

namespace App\Console\Commands\Soundblock;

use Illuminate\Console\Command;
use App\Jobs\Soundblock\Data\UpdateExchangeRates as UpdateExchangeRatesJob;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:exchange:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        dispatch(new UpdateExchangeRatesJob);
    }
}
