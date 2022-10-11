<?php

namespace App\Services\Auth;

use Exception;
use Client;
use App\Contracts\Auth\Auth as AuthContract;
use App\Models\{Core\Auth\AuthGroup, Core\Auth\AuthPermission, Users\User};
use App\Repositories\Core\Auth\AuthPermission as AuthPermissionRepository;

class Auth implements AuthContract {
    /**
     * @var AuthPermissionRepository
     */
    private AuthPermissionRepository $permissionRepository;
    /**
     * @var ?User
     */
    private ?User $user = null;

    /**
     * AuthService constructor.
     * @param AuthPermissionRepository $permissionRepository
     */
    public function __construct(AuthPermissionRepository $permissionRepository) {
        $this->permissionRepository = $permissionRepository;
    }

    public function isAuthorize(User $objUser, string $strGroup, string $strPermission, ?string $app = null, bool $silentException = true, bool $flagStrict = false): bool {
        try {
            if ($objUser->is_superuser) {
                return (true);
            }

            if (isset($app) && Client::app()->app_name !== strtolower($app)) {
                throw new Exception("Invalid App.");
            }

            /** @var AuthGroup $objGroup */
            $objGroup = $objUser->groups()->where("group_name", $strGroup)->first();

            if (is_null($objGroup)) {
                throw new Exception("Group Not Found.");
            }

            /** @var AuthPermission $objPermission */
            $objPermission = $this->permissionRepository->findByName($strPermission, false);

            if (is_null($objPermission)) {
                throw new Exception("Permission Not Found.");
            }

            $checkPermission = $objUser->permissionsInGroup()->wherePivot("group_id", $objGroup->group_id)
                                       ->wherePivot("permission_id", $objPermission->permission_id)->first();

            if (isset($checkPermission)) {
                return ($checkPermission->pivot->permission_value);
            } elseif (is_null($checkPermission) && $flagStrict === true) {
                return false;
            }

            $permissionInGroup = $objGroup->permissions()
                                          ->where("core_auth_permissions.permission_id", $objPermission->permission_id)
                                          ->first();

            if (is_null($permissionInGroup)) {
                throw new Exception("Permission Not Found In Group.");
            }

             return ($permissionInGroup->pivot->permission_value);
        } catch (\Exception $exception) {
            if ($silentException) {
                return false;
            }

            throw $exception;
        }
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(User $objUser): AuthContract {
        $this->user = $objUser;
        $this->initPermissions();

        return $this;
    }

    private function initPermissions() {
        $objGroups = $this->getUser()->groupsWithPermissions()->with("permissions")->get()->makeVisible("pivot")->toArray();
        $onjPermission = $this->getUser()->permissionsInGroup->toArray();
    }
}