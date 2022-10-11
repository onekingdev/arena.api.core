<?php

namespace App\Repositories\User;

use App\Models\Users\UserCorrespondence as UserCorrespondenceModel;
use App\Repositories\BaseRepository;

class UserCorrespondence extends BaseRepository {
    public function __construct(UserCorrespondenceModel $correspondence) {
        $this->model = $correspondence;
    }

    /**
     * @param string $emailId
     * @return UserCorrespondenceModel|null
     */
    public function findByEmail(string $emailId): ?UserCorrespondenceModel {
        return ($this->model->where("email_id", $emailId)->first());
    }
}
