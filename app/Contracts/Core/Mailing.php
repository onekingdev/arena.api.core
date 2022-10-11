<?php

namespace App\Contracts\Core;

use App\Models\Core\Mailing\Email as EmailModel;

interface Mailing {
    public function addEmail(string $email, bool $isBetaUser = false): EmailModel;
    public function deleteEmailByUuid(string $emailUuid);
}
