<?php

namespace App\Repositories\Auth;

use Util;
use App\Repositories\BaseRepository;
use App\Models\{Users\Auth\LoginSecurity as LoginSecurityModel, Users\User};

class LoginSecurity extends BaseRepository {
    protected $google2fa;

    /**
     * @param LoginSecurityModel $loginSecurity
     * @return void
     */
    public function __construct(LoginSecurityModel $loginSecurity) {
        $this->model = $loginSecurity;
        // $this->google2fa = new Google2FA();
    }

    /**
     * @param User $user
     * @param bool $bnFailure
     * @return LoginSecurityModel
     */
    public function findByUser(User $user, ?bool $bnFailure = false): LoginSecurityModel {
        $queryBuilder = $this->model->where("user_id", $user->user_id);
        if ($bnFailure) {
            return ($queryBuilder->firstOrFail());
        } else {
            return ($queryBuilder->first());
        }

    }

    /**
     * @param User $user
     * @return LoginSecurityModel
     */
    public function findOrNewByUser(User $user): LoginSecurityModel {
        $loginSecurity = $this->model->where("user_id", $user->user_id)->first();
        if (is_null($loginSecurity)) {
            $arrLoginSecurity = [
                "row_uuid"         => Util::uuid(),
                "user_id"          => $user->user_id,
                "user_uuid"        => $user->user_uuid,
                "google2fa_enable" => false,
                "google2fa_secret" => $this->google2fa->generateSecretKey(),
            ];
            $loginSecurity = $this->create($arrLoginSecurity);
        }

        return ($loginSecurity);
    }

    /**
     * @param LoginSecurityModel $loginSecurity
     * @return LoginSecurityModel
     */
    public function enableGoogle2FA(LoginSecurityModel $loginSecurity): LoginSecurityModel {
        return ($this->update($loginSecurity, ["google2fa_enable" => true]));
    }

    public function disableGoogle2FA(LoginSecurityModel $loginSecurity): LoginSecurityModel {
        return ($this->update($loginSecurity, ["google2fa_enable" => false]));
    }
}
