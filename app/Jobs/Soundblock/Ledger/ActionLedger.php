<?php

namespace App\Jobs\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ActionLedger implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private User $objUser;
    private string $actionType;
    private array $actionParams;

    /**
     * Create a new job instance.
     *
     * @param User $objUser
     * @param string $actionType
     * @param array $actionParams
     */
    public function __construct(User $objUser, string $actionType, array $actionParams = []) {
        $this->objUser = $objUser;
        $this->actionType = $actionType;
        $this->actionParams = $actionParams;
    }

    /**
     * Execute the job.
     *
     * @param Ledger $ledgerService
     * @return void
     */
    public function handle(Ledger $ledgerService) {
        $ledgerService->insertDocument("soundblock_actions", [
            "user_uuid"     => $this->objUser->user_uuid,
            "action_type"   => $this->actionType,
            "action_params" => $this->actionParams,
            "action_epoch"  => time(),
        ]);
    }
}
