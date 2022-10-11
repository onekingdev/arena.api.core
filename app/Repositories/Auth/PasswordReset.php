<?php

namespace App\Repositories\Auth;

use App\Models\Users\Auth\PasswordReset as PasswordResetModel;
use App\Repositories\BaseRepository;

class PasswordReset extends BaseRepository {
    /**
     * @param PasswordResetModel $passwordRest
     *
     * @return void
     */
    public function __construct(PasswordResetModel $passwordRest) {
        $this->model = $passwordRest;
    }

    /**
     * @param $resetToken
     *
     * @return PasswordResetModel
     */
    public function findByResetToken(string $resetToken) {
        return $this->model->where("reset_token", $resetToken)->first();
    }
}
