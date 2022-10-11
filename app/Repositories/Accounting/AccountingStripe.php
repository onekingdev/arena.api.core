<?php

namespace App\Repositories\Accounting;

use App\Repositories\BaseRepository;
use App\Models\Users\Accounting\UserAccountingStripe;

class AccountingStripe extends BaseRepository {

    protected \Illuminate\Database\Eloquent\Model $model;

    /**
     * @param UserAccountingStripe $model
     * @return void
     */
    public function __construct(UserAccountingStripe $model) {
        $this->model = $model;
    }
}
