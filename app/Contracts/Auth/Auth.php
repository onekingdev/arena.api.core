<?php

namespace App\Contracts\Auth;

use App\Models\Users\User;

interface Auth {
    public function isAuthorize(User $objUser, string $strGroup, string $strPermission, ?string $app = null, bool $silentException = true, bool $flagStrict = false) : bool;
}