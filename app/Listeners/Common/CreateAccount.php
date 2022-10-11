<?php

namespace App\Listeners\Common;

use Util;
use App\Events\Common\CreateAccount as CreateServiceEvent;
use Client;
use App\Services\Core\Auth\AuthGroup;
use App\Services\Core\Auth\AuthPermission;
use Constant;
use App\Models\Core\App as AppModel;

class CreateAccount {

    protected AuthGroup $authGroupService;

    protected AuthPermission $authPermService;

    protected $arrAuthGroup;

    /**
     * Create the event listener.
     *
     * @param AuthGroup $authGroupService
     * @param AuthPermission $authPermService
     */
    public function __construct(AuthGroup $authGroupService, AuthPermission $authPermService) {
        $this->authGroupService = $authGroupService;
        $this->authPermService = $authPermService;
    }

    /**
     * Handle the event.
     *
     * @param CreateServiceEvent $event
     * @return void
     */
    public function handle(CreateServiceEvent $event) {
        $this->arrAuthGroup = $event->arrAuthGroup;

        $objApp = AppModel::where("app_name", "soundblock")->first();
        $objAuth = Util::makeAuth($objApp);
        $objAuthGroup = $this->authGroupService->createGroup($this->arrAuthGroup, true, $objApp, $objAuth);

        $arrAccount = Constant::account_level_permissions();

        $this->authPermService->attachGroupPermissions($arrAccount, $objAuthGroup);
        $this->authPermService->attachUserPermissions(Constant::user_level_permissions(), $this->arrAuthGroup["user"], $objAuthGroup);
        $this->authPermService->attachUserPermissions($arrAccount, $this->arrAuthGroup["user"], $objAuthGroup);
    }
}
