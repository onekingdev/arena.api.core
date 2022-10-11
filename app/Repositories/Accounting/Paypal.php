<?php

namespace App\Repositories\Accounting;

use App\Models\Users\Accounting\AccountingPaypal;
use App\Repositories\BaseRepository;

class Paypal extends BaseRepository {

    protected \Illuminate\Database\Eloquent\Model $model;

    public function __construct(AccountingPaypal $objPaypal) {
        $this->model = $objPaypal;
    }
}
