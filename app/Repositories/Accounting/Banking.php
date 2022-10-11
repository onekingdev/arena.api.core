<?php

namespace App\Repositories\Accounting;

use App\Models\Users\Accounting\AccountingBanking;
use App\Repositories\BaseRepository;

class Banking extends BaseRepository {

    protected \Illuminate\Database\Eloquent\Model $model;

    public function __construct(AccountingBanking $objBanking) {
        $this->model = $objBanking;
    }
}
