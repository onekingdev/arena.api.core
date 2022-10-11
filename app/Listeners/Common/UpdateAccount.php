<?php

namespace App\Listeners\Common;

use App\Services\Core\Auth\AuthGroup;

class UpdateAccount {

    protected AuthGroup $authGroupService;

    /**
     * Create the event listener.
     *
     * @param AuthGroup $authGroupService
     */
    public function __construct(AuthGroup $authGroupService) {
        $this->authGroupService = $authGroupService;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event) {
        //
        $objAccount = $event->objAccount;
        $objNewAccount = $event->objNewAccount;
        $objAuthGroup = $this->authGroupService->findByAccount($objAccount);
    }
}
