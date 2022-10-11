<?php

namespace App\Contracts\Core\Auth;

use App\Models\Users\User;

interface TwoFactor {
    public function generateSecrets(User $objUser): array;
    public function getSecrets(User $objUser): array;
    public function removeSecrets(User $objUser);

    public function verify(User $objUser, int $intCode): bool;
    public function enableTwoFactor(User $objUser);
}