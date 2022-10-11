<?php

namespace App\Repositories\Common;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Accounts\AccountPlan as AccountPlanModel;

class AccountPlan extends BaseRepository {
    /**
     * @param AccountPlanModel $accountPlan
     * @return void
     */
    public function __construct(AccountPlanModel $accountPlan) {
        $this->model = $accountPlan;
    }
}
