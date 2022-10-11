<?php

namespace App\Console\Commands\Health;

use App\Contracts\Core\Slack;
use Illuminate\Console\Command;

class Supervisor extends Command {
    const QUEUES = [
        "laravel-worker"        => [
            "queue"   => "default",
            "command" => "artisan queue:work --sleep=3 --tries=1 --timeout=3600",
        ],
        "laravel-ledger-worker" => [
            "queue"   => "ledger",
            "command" => "artisan queue:work --queue=ledger --once --sleep=3 --tries=3 --timeout=3600",
        ],
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health:supervisor';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var \App\Contracts\Core\Slack
     */
    private Slack $slackService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Slack $slackService) {
        parent::__construct();
        $this->slackService = $slackService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        foreach (self::QUEUES as $strWorkerName => $arrQueue) {
            $output = null;

            exec("ps aux | grep '{$arrQueue["command"]}'", $output);

            if (count($output) < 3) {
                exec("sudo -E /usr/bin/supervisorctl start $strWorkerName:*");

                $arrCheckOutput = null;
                exec("ps aux | grep '{$arrQueue["command"]}'", $arrCheckOutput);

                if (count($arrCheckOutput) < 3) {
                    $this->slackService->supervisorNotification(ucfirst($arrQueue["queue"]), "notify-urgent");
                }
            }
        }

        return 0;
    }
}
