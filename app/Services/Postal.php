<?php

namespace App\Services;

use Auth;
use Util;
use App\Repositories\User\Postal as PostalRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\{Users\User, Users\Contact\UserContactPostal};
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Postal {
    protected PostalRepository $postalRepo;

    public function __construct(PostalRepository $postalRepo) {
        $this->postalRepo = $postalRepo;
    }

    public function find($postal, bool $bnFailure = false) {
        return ($this->postalRepo->find($postal, $bnFailure));
    }

    public function findByUser(User $objUser, int $perPage = 5) {
        return ($objUser->postals()->paginate($perPage));
    }

    public function userHasPostal(User $objUser, UserContactPostal $objPostal) {
        return ($objUser->postals()->where("row_id", $objPostal->row_id)->exists());
    }

    public function create(array $arrParams, User $objUser = null) {
        $arrPostal = [];
        if (is_null($objUser)) {
            $objUser = Auth::user();
        }

        $arrPostal["user_id"] = $objUser->user_id;
        $arrPostal["user_uuid"] = $objUser->user_uuid;
        $arrPostal["postal_type"] = Util::ucfLabel($arrParams["postal_type"]);
        $arrPostal["postal_street"] = $arrParams["postal_street"];
        $arrPostal["postal_city"] = $arrParams["postal_city"] ?? null;
        $arrPostal["postal_zipcode"] = $arrParams["postal_zipcode"] ?? null;
        $arrPostal["postal_country"] = $arrParams["postal_country"] ?? null;

        if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
            $this->initForPrimary($objUser);
            $arrPostal["flag_primary"] = true;
        } else {
            $arrPostal["flag_primary"] = false;
        }

        return ($this->postalRepo->create($arrPostal));
    }

    public function initForPrimary(User $objUser) {
        $arrObjPostals = $objUser->postals;
        $arrObjPostals->transform(function ($objPostal) {
            $objPostal->update(["flag_primary" => false]);
        });
    }

    public function update(UserContactPostal $objPostal, User $objUser, array $arrParams): UserContactPostal {
        $arrPostal = [];
        if (!$this->userHasPostal($objUser, $objPostal))
            throw new BadRequestHttpException("User has n't requested postal");

        if (isset($arrParams["postal_type"])) {
            $arrPostal["postal_type"] = Util::ucfLabel($arrParams["postal_type"]);
        }

        if (isset($arrParams["postal_street"])) {
            $arrPostal["postal_street"] = Util::ucfLabel($arrParams["postal_street"]);
        }

        if (isset($arrParams["postal_city"])) {
            $arrPostal["postal_city"] = Util::ucfLabel($arrParams["postal_city"]);
        }

        if (isset($arrParams["postal_zipcode"])) {
            $arrPostal["postal_zipcode"] = $arrParams["postal_zipcode"];
        }

        if (isset($arrParams["postal_country"])) {
            $arrPostal["postal_country"] = Util::ucfLabel($arrParams["postal_country"]);
        }

        if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
            $this->initForPrimary($objUser);
            $arrPostal["flag_primary"] = true;
        } else if (isset($arrParams["flag_primary"])) {
            $arrPostal["flag_primary"] = false;
        }

        return ($this->postalRepo->update($objPostal, $arrPostal));
    }

    public function delete($postal, User $objUser) {
        $objPostal = $this->find($postal, true);
        if (!$objPostal)
            throw new ModelNotFoundException("Postal not found");
        if ($this->userHasPostal($objUser, $objPostal)) {
            return ($objPostal->delete());
        } else {
            throw new BadRequestHttpException("User has n't this postal.");
        }
    }
}
