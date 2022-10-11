<?php

namespace App\Services;

use Util;
use App\Repositories\User\UserAlias;
use App\Models\{Users\User, Users\Auth\UserAuthAlias};
use Illuminate\Support\Collection as SupportCollection;

class Alias {
    /** @var UserAlias */
    protected UserAlias $aliasRepo;

    /**
     * @param UserAlias $aliasRepo
     */
    public function __construct(UserAlias $aliasRepo) {
        $this->aliasRepo = $aliasRepo;
    }

    /**
     * @param string $strAlias
     * @return UserAuthAlias
     */
    public function find(string $strAlias): UserAuthAlias {
        $objAlias = UserAuthAlias::whereRaw("lower(user_alias) = (?)", Util::lowerLabel($strAlias))->firstOrFail();

        return ($objAlias);
    }

    /**
     * @param string $likeAlias
     * @return SupportCollection
     */
    public function findAliases(string $likeAlias): SupportCollection {
        return (UserAuthAlias::whereRaw("lower(user_alias) like (?)", "%" . $likeAlias . "%")->get());
    }

    /**
     * @param User $user
     * @return UserAuthAlias|null
     */
    public function primary(User $user): ?UserAuthAlias {
        return ($this->aliasRepo->findPrimary($user));
    }
}
