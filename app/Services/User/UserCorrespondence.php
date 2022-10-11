<?php

namespace App\Services\User;

use Log;
use Util;
use Exception;
use App\Repositories\User\UserCorrespondence as UserCorrespondenceRepository;
use App\Models\{Core\App, Users\User, Users\UserCorrespondence as UserCorrespondenceModel};

class UserCorrespondence {
    /** @var UserCorrespondenceRepository */
    protected UserCorrespondenceRepository $correspondenceRepo;

    /**
     * @param UserCorrespondenceRepository $correspondenceRepo
     *
     * @return void
     */
    public function __construct(UserCorrespondenceRepository $correspondenceRepo) {
        $this->correspondenceRepo = $correspondenceRepo;
    }

    /**
     * @param string $emailId
     * @return UserCorrespondenceModel|null
     */
    public function findByEmail(string $emailId): ?UserCorrespondenceModel {
        return ($this->correspondenceRepo->findByEmail($emailId));
    }

    /**
     * @param array $params
     * @param User $user
     * @param App $app
     * @return UserCorrespondenceModel
     * @throws Exception
     *
     */
    public function create(array $params, User $user, App $app): UserCorrespondenceModel {
        if (!Util::array_keys_exists(["email_id", "email_uuid", "email_subject", "email_from", "email_text", "email_html"], $params))
            throw new Exception("Invalid Parameter.", 400);

        $params = array_merge($params, ["user_id" => $user->user_id, "user_uuid" => $user->user_uuid, "app_id" => $app->app_id, "app_uuid" => $app->app_uuid, "flag_read" => false, "flag_received" => false]);
        Log::info('Call');
        return ($this->correspondenceRepo->create($params));
    }

    /**
     * @param UserCorrespondenceModel $correspondence
     * @param array $params
     * @return UserCorrespondenceModel
     * @throws Exception
     */
    public function update(UserCorrespondenceModel $correspondence, array $params): UserCorrespondenceModel {
        if (!isset($params["flag_read"]) && !isset($params["flag_received"]))
            throw new Exception("Invalid Paramter.", 400);

        return ($this->correspondenceRepo->update($correspondence, $params));
    }
}
