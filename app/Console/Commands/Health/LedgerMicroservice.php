<?php

namespace App\Console\Commands\Health;

use App\Contracts\Core\Slack;
use App\Contracts\Soundblock\Ledger;
use Illuminate\Console\Command;

class LedgerMicroservice extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "health:ledger";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Check Ledger MicroService Health";
    /**
     * @var Ledger
     */
    private Ledger $ledgerService;
    /**
     * @var Slack
     */
    private Slack $slackService;

    /**
     * Create a new command instance.
     *
     * @param Ledger $ledgerService
     * @param Slack $slackService
     */
    public function __construct(Ledger $ledgerService, Slack $slackService) {
        parent::__construct();

        $this->ledgerService = $ledgerService;
        $this->slackService = $slackService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $bnStatus = $this->ledgerService->ping();

        if (!$bnStatus) {
            $this->slackService->qldbNotification("QLDB Microservice Is Not Responding.", $this->ledgerService->getHost(), "notify-urgent");
        }

        return 0;
    }
}
