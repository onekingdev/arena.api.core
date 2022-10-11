<?php

namespace App\Services\Common;

use App\Repositories\User\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache as CacheFacade;

class Cache {
    /** @var User */
    protected User $userRepo;

    /**
     * @param User $userRepo
     */
    public function __construct(User $userRepo) {
        $this->userRepo = $userRepo;
    }

    /**
     * @param int $lastUserId
     * @return void
     */
    public function cache(int $lastUserId) {
        $arrUsers = $this->userRepo->findAllAfter($lastUserId);

        $this->cachingUsers($arrUsers);
    }

    /**
     * @param Collection $arrUsers
     * @return void
     */
    public function cachingUsers(Collection $arrUsers) {
        foreach ($arrUsers as $objUser) {
            CacheFacade::rememberForever("users.user_id." . $objUser->user_id, function () use ($objUser) {
                return ([
                    "uuid" => $objUser->user_uuid,
                    "name" => $objUser->name,
                ]);
            });
        }

        $objLastUser = $this->userRepo->getLast();
        $lastUserId = $objLastUser ? $objLastUser->user_id : 0;

        CacheFacade::rememberForever("job.users.user_id", function () use ($lastUserId) {
            return ($lastUserId);
        });
    }
}
