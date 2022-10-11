<?php

namespace App\Broadcasting\Soundblock;

use App\Models\Users\User;
use App\Services\Common\Common;
use App\Services\Soundblock\Project;

class ServiceChannel {
    /**
     * @var Common
     */
    private Common $service;

    /**
     * ServiceChannel constructor.
     * @param Common $service
     */
    public function __construct(Common $service) {
        $this->service = $service;
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param string $account
     * @return bool
     */
    public function join(User $user, string $account) {
        $objAccount = $this->service->find($account, false);

        if (is_null($objAccount)) {
            return false;
        }

        return $this->service->checkIsAccountMember($objAccount, $user);
    }
}
