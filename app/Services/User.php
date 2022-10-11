<?php

namespace App\Services;

use Hash;
use Util;
use Constant;
use Exception;
use App\Facades\Cache\AppCache;
use App\Events\Common\VerifyEmail;
use App\Models\Users\Auth\LoginSecurity;
use Illuminate\Database\Eloquent\Collection;
use App\Models\{
    Core\Auth\AuthPermission,
    Users\User as UserModel,
    Users\Auth\UserAuthAlias,
    Users\Contact\UserContactEmail,
    Core\App as AppModel
};
use App\Repositories\User\{UserAlias, UserContactEmail as UserContactEmailRepository, User as UserRepository};

class User {
    /** @var UserRepository */
    protected UserRepository $userRepo;
    /** @var UserAlias */
    protected UserAlias $aliasRepo;
    /** @var UserContactEmailRepository */
    protected UserContactEmailRepository $emailRepo;

    /**
     * @param UserRepository $userRepo
     * @param UserAlias $aliasRepo
     * @param UserContactEmailRepository $emailRepo
     */
    public function __construct(UserRepository $userRepo, UserAlias $aliasRepo, UserContactEmailRepository $emailRepo) {
        $this->userRepo = $userRepo;
        $this->aliasRepo = $aliasRepo;
        $this->emailRepo = $emailRepo;
    }

    /**
     * @param mixed $where
     * @param $field string
     * @param Collection
     * @return Collection
     * @throws Exception
     *
     */
    public function findAllWhere($where, string $field = "uuid"): Collection {
        return ($this->userRepo->findAllWhere($where, $field));
    }

    public function findByEmailOrAlias($param) {
        $objAuthEmail = $this->emailRepo->find($param);
        if ($objAuthEmail) {
            return ($objAuthEmail->user);
        }

        return ($this->aliasRepo->find($param, true)->user);
    }

    public function findAllByPermission(AuthPermission $objAuthPerm, int $perPage = 10) {
        return ($this->userRepo->findAllByPermission($objAuthPerm, $perPage));
    }

    public function find($id, $bnFailure = false): UserModel {
        return ($this->userRepo->find($id, $bnFailure));
    }

    public function search(array $arrParams) {
        return ($this->userRepo->search($arrParams));
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function findByName(string $name){
        $returnData = [];
        $objUsers = $this->userRepo->findByName($name);

        if ($objUsers) {
            foreach ($objUsers as $user) {
                $returnData[] = ["name" => $user->name, "user_uuid" => $user->user_uuid];
            }

            return ($returnData);
        }

        return (null);
    }

    /**
     * @param UserModel $user
     * @return UserModel
     */
    public function getPrimary(UserModel $user) {
        return ($this->userRepo->getPrimary($user));
    }

    /**
     * @param string $strUserUuid
     * @return array
     * @throws Exception
     */
    public function getAvatarByUuid(string $strUserUuid) {
        AppCache::setCacheKey(self::class . ".getAvatarByUuid.User.Avatar.{$strUserUuid}");

        if (AppCache::isCached()) {
            return ([true, null]);
        }

        $objUser = $this->userRepo->getUserByUuid($strUserUuid);
        $path = $objUser->flag_avatar ?
            "users" . Constant::Separator . "avatars" . Constant::Separator . $strUserUuid . ".png" :
            "users" . Constant::Separator . "avatars" . Constant::Separator . "default.png";

        return ([false, $path]);
    }

    /**
     * @param array $arrParams
     * @return UserModel
     * @throws Exception
     */
    public function createAccount(array $arrParams): UserModel {
        $fieldsAlias = config("constant.user.fields_alias");
        $arrUser = [];
        foreach ($fieldsAlias as $key => $value) {
            $arrUser[$value] = $arrParams[$key];
        }

        $arrUser[UserModel::STAMP_CREATED_BY] = 1;
        $arrUser[UserModel::STAMP_UPDATED_BY] = 1;
        $user = $this->create($arrUser);
        $this->createEmail($user, $arrUser["user_auth_email"]);
        $this->createAlias($user, $arrUser["user_alias"]);

        return ($user);
    }

    /**
     * @param array $arrParams
     * @return UserModel
     * @throws Exception
     */
    public function create(array $arrParams): UserModel {
        if (empty($arrParams["name_middle"]) && empty($arrParams["name_last"])) {
            $fullName = explode(" ", $arrParams["name_first"]);

            switch (count($fullName)) {
                case 1 :
                {
                    $name["name_first"] = array_pop($fullName);
                    break;
                }
                case 2 :
                {
                    $arrParams["name_last"] = array_pop($fullName);
                    $arrParams["name_first"] = implode(" ", $fullName);
                    break;
                }
                case (count($fullName) >= 3) :
                {
                    $arrParams["name_last"] = array_pop($fullName);
                    $arrParams["name_middle"] = array_pop($fullName);
                    $arrParams["name_first"] = implode(" ", $fullName);
                    break;
                }
                default:
                    throw new Exception("Invalid Parameter.");
            }
        }

        if (!isset($arrParams["name_last"])) {
            throw new Exception("Last Name is Required.");
        }

        $objApp = AppModel::where("app_name", "soundblock")->first();
        $arrUser = [];
        $arrUser["user_password"] = Hash::make($arrParams["user_password"]);

        if (isset($arrParams["name_first"])) {
            $arrUser["name_first"] = ucfirst(strtolower($arrParams["name_first"]));
        }
        if (isset($arrParams["name_middle"])) {
            $arrUser["name_middle"] = ucfirst(strtolower($arrParams["name_middle"]));
        }
        if (isset($arrParams["name_last"])) {
            $arrUser["name_last"] = ucfirst(strtolower($arrParams["name_last"]));
        }

        $objUser = $this->userRepo->create($arrUser);
        $objUser->notificationSettings()->create([
            "row_uuid" => Util::uuid(),
            "user_uuid" => $objUser->user_uuid,
            "app_id"   => $objApp->app_id,
            "app_uuid" => $objApp->app_uuid,
            "user_setting" => [
                "per_page" => 10,
                "position" => [
                    "web" => "top-left",
                    "mobile" => "top"
                ],
                "show_time" => 5,
                "play_sound" => true,
            ]
        ]);

        return ($objUser);
    }

    /**
     * @param UserModel $user
     * @param string $email
     * @return UserContactEmail
     * @throws Exception
     */
    protected function createEmail(UserModel $user, string $email): UserContactEmail {
        if ($this->emailRepo->find($email))
            throw new Exception("This email already exists.", 400);
        $arrEmail = [];
        $arrEmail["user_id"] = $user->user_id;
        $arrEmail["user_uuid"] = $user->user_uuid;
        $arrEmail["user_auth_email"] = $email;
        $arrEmail["flag_primary"] = true;
        $arrEmail[UserContactEmail::STAMP_CREATED_BY] = $user->user_id;
        $arrEmail[UserContactEmail::STAMP_UPDATED_BY] = $user->user_id;
        $email = $this->emailRepo->create($arrEmail);
        event(new VerifyEmail($email));

        return ($email);
    }

    /**
     * @param UserModel $user
     * @param string $alias
     * @return UserAuthAlias
     * @throws Exception
     */
    protected function createAlias(UserModel $user, string $alias): UserAuthAlias {
        if ($this->aliasRepo->find($alias))
            throw new Exception("This alias already exists.", 400);
        $arrAlias = [];
        $arrAlias["user_id"] = $user->user_id;
        $arrAlias["user_uuid"] = $user->user_uuid;
        $arrAlias["flag_primary"] = true;
        $arrAlias["user_alias"] = $alias;
        $arrAlias[UserAuthAlias::STAMP_CREATED_BY] = $user->user_id;
        $arrAlias[UserAuthAlias::STAMP_UPDATED_BY] = $user->user_id;

        return ($this->aliasRepo->create($arrAlias));
    }

    /**
     * @param UserModel $objUser
     * @param string $alias
     * @return UserAuthAlias|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object
     * @throws Exception
     */
    public function addAlias(UserModel $objUser, string $alias) {
        $objAlias = $objUser->aliases()->where("users_auth_aliases.user_alias", $alias)->first();

        if (!$objAlias) {
            $objAlias = $objUser->aliases()->create([
                "alias_uuid"   => Util::uuid(),
                "user_uuid"    => $objUser->user_uuid,
                "user_alias"   => $alias,
                "flag_primary" => false,
            ]);
        }

        return ($objAlias);
    }

    /**
     * @param $objUser
     * @param $objFile
     * @return string
     * @throws Exception
     */
    public function addAvatar($objUser, $objFile) {
        try {
            $randomName = Util::generateRandomCode();
            $fileName = $randomName . ".png";
            $temp = tempnam(null, null);
            $path = "public" . Constant::Separator . "users" . Constant::Separator . $objUser->user_uuid . Constant::Separator . "avatars";

            imagepng(imagecreatefromstring(file_get_contents($objFile)), $temp);

            bucket_storage("account")->putFileAs($path, $temp, $fileName, "public");

            return ($randomName);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function update(UserModel $objUser, array $arrParams): UserModel {
        $arrUser = [];

        if (isset($arrParams["user_password"])) {
            $arrUser["user_password"] = Hash::make($arrParams["user_password"]);
        }

        if (isset($arrParams["remember_token"])) {
            $arrUser["remember_token"] = Util::remember_token();
        }

        if (isset($arrParams["name_first"])) {
            $arrUser["name_first"] = $arrParams["name_first"];
        }

        if (isset($arrParams["name_middle"])) {
            $arrUser["name_middle"] = $arrParams["name_middle"];
        } else {
            $arrUser["name_middle"] = "";
        }

        if (isset($arrParams["name_last"])) {
            $arrUser["name_last"] = $arrParams["name_last"];
        }

        return ($this->userRepo->update($objUser, $arrUser));
    }

    /**
     * Enable/Disable 2FA
     *
     * @param UserModel $objUser
     * @param bool $g2faStatus
     * @return LoginSecurity|null
     * @throws Exception
     */
    public function toggle2FA(UserModel $objUser, bool $g2faStatus): ?LoginSecurity {
        /** @var LoginSecurity $objSecurity */
        $objSecurity = $objUser->loginSecurity;

        if ($g2faStatus) {
            if (is_null($objSecurity)) {
                $google2fa = app("pragmarx.google2fa");

                $objUser->passwordsecurity()->create([
                    "row_uuid"         => Util::uuid(),
                    "user_id"          => $objUser->user_id,
                    "user_uuid"        => $objUser->user_uuid,
                    "flag_enabled" => true,
                    "google2fa_secret" => $google2fa->generateSecretKey(),
                ]);
            } else {
                $objSecurity->update([
                    "flag_enabled" => true,
                ]);
            }
        } else {
            if (isset($objSecurity)) {
                $objSecurity->update([
                    "flag_enabled" => false,
                ]);
            }
        }


        return $objSecurity;
    }

    /**
     * @param UserModel $objUser
     * @param string $alias
     * @return bool
     */
    public function deleteAlias(UserModel $objUser, string $alias): bool {
        $objUser->aliases()->where("users_auth_aliases.user_alias", $alias)->delete();

        return (true);
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function delete($id): bool {
        return ($this->userRepo->destroy($id));
    }
}
