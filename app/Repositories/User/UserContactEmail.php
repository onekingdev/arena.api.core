<?php

namespace App\Repositories\User;

use Util;
use Illuminate\Support\Collection;
use App\Repositories\BaseRepository;
use App\Models\{Users\User, Users\Contact\UserContactEmail as UserContactEmailModel};

class UserContactEmail extends BaseRepository {
    public function __construct(UserContactEmailModel $objEmail) {
        $this->model = $objEmail;
    }

    /**
     * @param string $strEmail
     * @param bool $bnFailure
     * @return UserContactEmailModel
     */
    public function find($strEmail, bool $bnFailure = false) {
        $queryBuilder = $this->model->whereRaw("lower(user_auth_email) = (?)", Util::lowerLabel($strEmail));

        if ($bnFailure) {
            return ($queryBuilder->firstOrFail());
        }

        return ($queryBuilder->first());
    }


    public function findWithTrashed($strEmail) {
        return $this->model->whereRaw("lower(user_auth_email) = (?)", Util::lowerLabel($strEmail))->withTrashed()
                           ->first();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasPrimary(User $user): bool {
        return ($user->emails()->where("flag_primary", true)->exists());
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function verifiedEmails(User $user): Collection {
        return ($user->emails()->whereNotNull(UserContactEmailModel::STAMP_EMAIL)->get());
    }

    /**
     * @param User $user
     * @return UserContactEmailModel|null
     */
    public function primary(User $user): ?UserContactEmailModel {
        return ($user->emails()->where("flag_primary", true)->first());
    }

    /**
     * @param string $hash
     * @return UserContactEmailModel|null
     */
    public function getEmailByVerificationHash(string $hash): ?UserContactEmailModel {
        return ($this->model->where("verification_hash", $hash)->first());
    }

    public function verifyEmail(UserContactEmailModel $userEmail): UserContactEmailModel {
        $userEmail->verified();

        return $userEmail;
    }
}
