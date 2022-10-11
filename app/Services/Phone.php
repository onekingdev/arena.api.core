<?php

namespace App\Services;

use Auth;
use Util;
use App\Repositories\User\Phone as PhoneRepository;
use App\Models\{Users\User, Users\Contact\UserContactPhone};
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Phone {
    /** @var PhoneRepository */
    protected PhoneRepository $phoneRepo;

    /**
     * @param PhoneRepository $phoneRepo
     * @return void
     */
    public function __construct(PhoneRepository $phoneRepo) {
        $this->phoneRepo = $phoneRepo;
    }

    /**
     * @param string $phone
     * @param User|null $objUser
     * @param bool $bnFailure
     * @return UserContactPhone
     */
    public function find(string $phone, ?User $objUser = null, ?bool $bnFailure = false) {
        if (!$objUser) {
            $objUser = Auth::user();
        }
        return ($this->phoneRepo->findByUser($phone, $objUser, $bnFailure));
    }

    /**
     * @param User|null $user
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByUser(?User $user = null, ?int $perPage = 5) {
        if (!$user) {
            /** @var User */
            $user = Auth::user();
        }

        return ($user->phones()->orderBy("flag_primary", "desc")->paginate($perPage));
    }

    /**
     * @param string $strPhoneNumber
     * @return mixed
     */
    public function findByPhone(string $strPhoneNumber) {
        $objPhoneNumber = $this->phoneRepo->findByPhone($strPhoneNumber);

        return ($objPhoneNumber);
    }

    /**
     * @param User $objUser
     * @param string $strPhoneNumber
     * @return bool
     */
    public function userHasPhone(User $objUser, string $strPhoneNumber): bool {
        return ($objUser->phones()->where("phone_number", $strPhoneNumber)->exists());
    }

    /**
     * @param array $arrParams
     * @param User|null $objUser
     * @return UserContactPhone
     */
    public function create(array $arrParams, ?User $objUser = null): UserContactPhone {
        $arrPhone = [];
        if (is_null($objUser)) {
            $objUser = Auth::user();
        }

        $objPhone = $this->phoneRepo->findByUser($arrParams["phone_number"], $objUser);

        if ($objPhone) {
            throw new BadRequestHttpException("User already has this phone.");
        }

        $arrPhone["user_id"] = $objUser->user_id;
        $arrPhone["user_uuid"] = $objUser->user_uuid;
        $arrPhone["phone_type"] = Util::ucfLabel($arrParams["phone_type"]);
        $arrPhone["phone_number"] = $arrParams["phone_number"];

        if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
            $this->initForPrimary($objUser);
            $arrPhone["flag_primary"] = true;
        } else {
            $arrPhone["flag_primary"] = false;
        }

        return ($this->phoneRepo->create($arrPhone));
    }

    /**
     * @param User $objUser
     * @return void
     */
    public function initForPrimary(User $objUser) {
        $arrObjPhones = $objUser->phones;

        $arrObjPhones->transform(function ($objPhone) {
            $objPhone->update(["flag_primary" => false]);
        });
    }

    /**
     * @param UserContactPhone $objPhone
     * @param User $objUser
     * @param array $arrParams
     * @return UserContactPhone
     */
    public function update(UserContactPhone $objPhone, User $objUser, array $arrParams): UserContactPhone {
        $arrPhone = [];
        if (isset($arrParams["phone_type"])) {
            $arrPhone["phone_type"] = Util::ucfLabel($arrParams["phone_type"]);
        }

        if (isset($arrParams["phone_number"])) {
            $arrPhone["phone_number"] = $arrParams["phone_number"];
        }

        if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
            $this->initForPrimary($objUser);
            $arrPhone["flag_primary"] = true;
        } else if (isset($arrParams["flag_primary"])) {
            $arrPhone["flag_primary"] = false;
        }

        return ($this->phoneRepo->update($objPhone, $arrPhone));
    }

    /**
     * @param string $strPhone
     * @param User $objUser
     * @return bool
     * @throws \Exception
     */
    public function delete(string $strPhone, User $objUser): bool {
        if (!$this->userHasPhone($objUser, $strPhone))
            throw new BadRequestHttpException("User has n't this phone");
        $objPhone = $this->find($strPhone, $objUser);

        return ($objPhone->delete());
    }
}
