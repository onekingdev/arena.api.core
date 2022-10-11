<?php

namespace App\Repositories\Core\Auth;

use Util;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use App\Models\{Core\Auth\AuthGroup, Core\Auth\AuthPermission as AuthPermissionModel, Users\User};

class AuthPermission extends BaseRepository {
    public function __construct(AuthPermissionModel $objAuthPerm) {
        $this->model = $objAuthPerm;
    }

    public function findAllWhere(array $where, string $field = "uuid") {
        if ($field == "uuid" || $field == "id") {
            return ($this->model->whereIn("permission_" . $field, $where)->get());
        } else if ($field == "name") {

            $arrWhere = Util::filterName($where);

            return ($this->model->Where(function ($query) use ($arrWhere) {
                foreach ($arrWhere as $where) {
                    if (strpos($where, "%") !== false) {
                        $query->orwhere("permission_name", "like", $where);
                    } else {
                        $query->orwhere("permission_name", $where);
                    }
                }
            })->get());

        } else {
            throw new InvalidParameterException();
        }
    }

    /**
     * @param string $strName
     * @param bool $fail
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findByName(string $strName, bool $fail = true) {
        /** @var Builder $query */
        $query = $this->model->whereRaw("lower(permission_name) = (?)", Util::lowerLabel($strName));

        if ($fail) {
            return $query->firstOrFail();
        }

        return $query->first();
    }

    /**
     * @param User $user
     * @param AuthGroup $objGroup
     * @return SupportCollection
     */
    public function findAllByUserAndGroup(User $user, AuthGroup $objGroup): SupportCollection {
        return ($user->permissionsInGroup()
                     ->select("core_auth_permissions.*", "core_auth_permissions_groups_users.permission_value")
                     ->wherePivot("group_id", $objGroup->group_id)->get());
    }
}
