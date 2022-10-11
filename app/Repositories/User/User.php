<?php

namespace App\Repositories\User;

use Util;
use Exception;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{Users\User as UserModel, Core\Auth\AuthPermission};

class User extends BaseRepository {
    public function __construct(UserModel $objUser) {
        $this->model = $objUser;
    }

    public function findAllWhere(array $where, $field = "uuid") {
        if ($field == "uuid" || $field == "id") {
            return ($this->model->whereIn("user_" . $field, $where)->get());
        } else {
            throw new Exception("$field is invalid parameter");
        }
    }

    public function findAllByPermission(AuthPermission $objAuthPerm, int $perPage = null) {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $queryBuilder = $this->model->with(["groupsWithPermissions" => function ($query) use ($objAuthPerm) {
            $query->where("permission_id", $objAuthPerm->permission_id);
        }])->whereHas("permissionsInGroup", function ($query) use ($objAuthPerm) {
            $query->where("core_auth_permissions_groups_users.permission_id", $objAuthPerm->permission_id);
        });
        if ($perPage) {
            return ($queryBuilder->paginate($perPage));
        } else {
            return ($queryBuilder->get());
        }
    }

    public function findAllAfter(?int $lastId = 0): Collection {
        return ($this->model->where("user_id", ">", $lastId)->get());
    }

    /**
     * @param string $search
     * @return mixed
     */
    public function findByName(string $search){
        $result = $this->model->whereRaw("lower(name_first) like (?)", "%" . Util::lowerLabel($search) . "%")
            ->orWhereRaw("lower(name_last) like (?)", "%" . Util::lowerLabel($search) . "%")
            ->orWhereHas("aliases", function ($query) use ($search) {
                $query->whereRaw("lower(user_alias) like (?)", "%" . Util::lowerLabel($search) . "%");
            })->get();

        return ($result);
    }

    /**
     * @param array $params
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllWithFilters(array $params, int $perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->model->with(["aliases", "emails", "phones"]);

        if (isset($params["filter_name"])) {
            $query = $query->whereRaw("lower(concat(name_first, IF(name_middle IS NULL, '', CONCAT(' ', name_middle)),
                IF(name_last IS NULL, '', CONCAT(' ', name_last)))) like ?", ["%" . strtolower($params["filter_name"]) . "%"]);
        }

        if (isset($params["sort_date"])) {
            $query = $query->orderBy("stamp_created_at", $params["sort_date"]);
        }

        $objUsers = $query->paginate($perPage);
        $objUsers->getCollection()->transform(function ($user) {
            $user->avatar = $user->avatar;
            return $user;
        });

        return ($objUsers);
    }

    public function search(array $arrParams) {
        $userQuery = $this->model;
        if (isset($arrParams["user"])) {
            $userQuery = $userQuery->whereHas("emails", function ($q) use ($arrParams) {
                $q->whereRaw("lower(user_auth_email) like (?)", "%" . Util::lowerLabel($arrParams["user"]) . "%");
            })->orWhereHas("aliases", function ($q) use ($arrParams) {
                $q->whereRaw("lower(user_alias) like (?)", "%" . Util::lowerLabel($arrParams["user"]) . "%");
            });
        }

        return $userQuery->get();
    }

    public function getLast(): ?UserModel {
        return ($this->model->latest("user_id")->first());
    }

    /**
     * @param UserModel $user
     * @param array $load
     *
     * @return UserModel
     */
    public function getPrimary(UserModel $user) {
        return ($user->setAppends(["avatar", "name", "primary_email", "primary_phone"]));
    }

    /**
     * @param string $strUUID
     * @return mixed
     */
    public function getUserByUuid(string $strUUID) {
        $objUser = $this->model->where("user_uuid", $strUUID)->first();

        return ($objUser);
    }

    /**
     * @param UserModel $user
     * @param string $avatarName
     * @return UserModel
     */
    public function updateUserAvatar(UserModel $user, string $avatarName): UserModel {
        $user->update([
            "avatar_name" => $avatarName,
        ]);

        return ($user);
    }
}
