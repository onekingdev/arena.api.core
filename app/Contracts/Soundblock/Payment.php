<?php

namespace App\Contracts\Soundblock;

use App\Models\Soundblock\Accounts\Account;

interface Payment {
    public function calculateBucketTransfer(Account $objAccount, string $dateStart, string $dateEnd);
    public function calculateBucketStorageFreeSize(Account $objAccount);
}
