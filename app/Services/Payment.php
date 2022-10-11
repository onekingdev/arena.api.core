<?php

namespace App\Services;

use Auth;
use Util;
use App\Repositories\{Accounting\Banking, Accounting\Paypal};
use App\Models\{Users\User, Users\Accounting\AccountingPaypal, Users\Accounting\AccountingBanking};
use Symfony\Component\{HttpKernel\Exception\BadRequestHttpException, Routing\Exception\InvalidParameterException};

class Payment {
    /** @var  Banking */
    protected Banking $bankingRepo;
    /** @var Paypal */
    protected Paypal $paypalRepo;

    /**
     * @param Banking $bankingRepo
     * @param Paypal $paypalRepo
     * @return void
     */
    public function __construct(Banking $bankingRepo, Paypal $paypalRepo) {
        $this->bankingRepo = $bankingRepo;
        $this->paypalRepo = $paypalRepo;
    }

    /**
     * @param string $bank
     * @param bool $bnFailure
     * @return AccountingBanking
     * @throws \Exception
     */
    public function findBanking(string $bank, bool $bnFailure = false): AccountingBanking {
        return ($this->bankingRepo->find($bank, $bnFailure));
    }

    /**
     * @param string $paypal
     * @param bool $bnFailure
     * @return AccountingPaypal
     * @throws \Exception
     */
    public function findPaypal(string $paypal, ?bool $bnFailure = false): AccountingPaypal {
        return ($this->paypalRepo->find($paypal, $bnFailure));
    }

    /**
     * @param User $objUser
     * @param AccountingBanking $objBank
     * @return bool
     */
    public function userHasBankAccount(User $objUser, AccountingBanking $objBank): bool {
        return ($objUser->bankings()->where("row_uuid", $objBank->row_uuid)->exists());
    }

    /**
     * @param User $objUser
     * @param AccountingPaypal $objPaypal
     * @return bool
     */
    public function userHasPaypal(User $objUser, AccountingPaypal $objPaypal): bool {
        return ($objUser->paypals()->where("row_uuid", $objPaypal->row_uuid)->exists());
    }

    /**
     * @param array $arrParams
     * @param User|null $objUser
     * @return AccountingBanking
     */
    public function createBanking(array $arrParams, ?User $objUser = null): AccountingBanking {
        if (is_null($objUser))
            $objUser = Auth::user();

        $arrBanking = [];
        if (is_null($objUser))
            $objUser = Auth::user();

        $arrBanking["user_id"] = $objUser->user_id;
        $arrBanking["user_uuid"] = $objUser->user_uuid;
        if ($objUser->paypals->count() == 0 && $objUser->bankings->count() == 0) {
            $arrBanking["flag_primary"] = true;
        } else {
            if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
                $this->initForPrimary($objUser);
                $arrBanking["flag_primary"] = true;
            } else {
                $arrBanking["flag_primary"] = false;
            }
        }
        $arrBanking["bank_name"] = $arrParams["bank_name"];
        $arrBanking["account_type"] = Util::ucfLabel($arrParams["account_type"]);
        $arrBanking["account_number"] = $arrParams["account_number"];
        $arrBanking["routing_number"] = $arrParams["routing_number"];

        return ($this->bankingRepo->create($arrBanking));
    }

    /**
     * @param array $arrParams
     * @param User|null $objUser
     * @return AccountingPaypal
     */
    public function createPaypal(array $arrParams, ?User $objUser = null): AccountingPaypal {
        if (is_null($objUser))
            $objUser = Auth::user();

        $arrPaypal = [];
        $arrPaypal["user_id"] = $objUser->user_id;
        $arrPaypal["user_uuid"] = $objUser->user_uuid;
        $arrPaypal["paypal"] = $arrParams["paypal_email"];

        if ($objUser->paypals->count() == 0 && $objUser->bankings->count() == 0) {
            $arrPaypal["flag_primary"] = true;
        } else {
            if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
                $this->initForPrimary($objUser);
            } else {
                $arrPaypal["flag_primary"] = false;
            }
        }

        return ($this->paypalRepo->create($arrPaypal));
    }

    /**
     * @param User $objUser
     * @return bool
     */
    public function initForPrimary(User $objUser): bool {
        return ($this->initBankingForPrimary($objUser) && $this->initPaypalForPrimary($objUser));
    }

    /**
     * @param User $objUser
     * @return bool
     */
    public function initBankingForPrimary(User $objUser) {
        $arrObjBankings = $objUser->bankings;

        $arrObjBankings->transform(function ($objBanking) {
            $objBanking->update(["flag_primary" => false]);
        });

        return (true);
    }

    /**
     * @param User $objUser
     * @return bool
     */
    public function initPaypalForPrimary(User $objUser) {

        $arrObjPaypals = $objUser->paypals;
        $arrObjPaypals->transform(function ($objPaypal) {
            $objPaypal->update(["flag_primary" => false]);
        });

        return (true);
    }

    /**
     * @param array $arrParams
     * @param User $objUser
     * @return mixed
     * @throws \Exception
     */
    public function setPrimary(array $arrParams, User $objUser) {
        if (Util::lowerLabel($arrParams["type"]) === "bank") {
            return ($this->setPrimaryBanking($arrParams, $objUser));
        } else if (Util::lowerLabel($arrParams["type"]) === "paypal") {
            return ($this->setPrimaryPaypal($arrParams, $objUser));
        } else {
            throw new InvalidParameterException();
        }
    }

    /**
     * @param array $arrParams
     * @param User $objUser
     * @return AccountingBanking
     * @throws \Exception
     */
    public function setPrimaryBanking(array $arrParams, User $objUser): AccountingBanking {
        $objBanking = $this->findBanking($arrParams["bank"], true);
        if (!$this->userHasBankAccount($objUser, $objBanking))
            abort(400, "The user has not this bank account.");
        $arrBanking = [];
        if ($arrParams["flag_primary"]) {
            $this->initForPrimary($objBanking->user);
            $arrBanking["flag_primary"] = true;

            return ($this->bankingRepo->update($objBanking, $arrBanking));
        } else {
            throw new InvalidParameterException();
        }
    }

    /**
     * @param array $arrParams
     * @param User $objUser
     * @return AccountingPaypal
     * @throws \Exception
     */
    public function setPrimaryPaypal(array $arrParams, User $objUser): AccountingPaypal {
        $objPaypal = $this->findPaypal($arrParams["paypal"], true);
        if (!$this->userHasPaypal($objUser, $objPaypal))
            abort(400, "The user has not this paypal.");
        $arrPaypal = [];
        if ($arrParams["flag_primary"]) {
            $this->initForPrimary($objPaypal->user);
            $arrPaypal["flag_primary"] = true;

            return ($this->paypalRepo->update($objPaypal, $arrPaypal));
        } else {
            throw new InvalidParameterException();
        }
    }

    /**
     * @param AccountingBanking $objBanking
     * @param User $objUser
     * @param array $arrParams
     * @return AccountingBanking
     */
    public function updateBanking(AccountingBanking $objBanking, User $objUser, array $arrParams): AccountingBanking {
        $arrBanking = [];
        if (!$this->userHasBankAccount($objUser, $objBanking))
            throw new BadRequestHttpException("User hasn't this account.");

        if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
            $this->initForPrimary($objUser);
            $arrBanking["flag_primary"] = true;
        } else {
            $arrBanking["flag_primary"] = false;
        }

        if (isset($arrParams["bank_name"]))
            $arrBanking["bank_name"] = $arrParams["bank_name"];

        if (isset($arrParams["account_type"]))
            $arrBanking["account_type"] = Util::ucfLabel($arrParams["account_type"]);

        if (isset($arrParams["account_number"]))
            $arrBanking["account_number"] = $arrParams["account_number"];

        if (isset($arrParams["routing_number"]))
            $arrBanking["routing_number"] = $arrParams["routing_number"];

        return ($this->bankingRepo->update($objBanking, $arrBanking));
    }

    /**
     * @param AccountingPaypal $objPaypal
     * @param User $objUser
     * @param array $arrParams
     * @return AccountingPaypal
     */
    public function updatePaypal(AccountingPaypal $objPaypal, User $objUser, array $arrParams): AccountingPaypal {
        $arrPaypal = [];

        if (isset($arrParams["paypal_email"]))
            $arrPaypal["paypal"] = $arrParams["paypal_email"];

        if (isset($arrParams["flag_primary"]) && $arrParams["flag_primary"]) {
            $this->initForPrimary($objUser);
            $arrPaypal["flag_primary"] = true;
        } else {
            $arrPaypal["flag_primary"] = false;
        }

        return ($this->paypalRepo->update($objPaypal, $arrPaypal));
    }

    /**
     * @param string $paypal
     * @param User|null $objUser
     * @return bool
     * @throws \Exception
     */
    public function deletePaypal(string $paypal, User $objUser = null) {
        if (is_null($objUser))
            $objUser = Auth::user();

        $objPaypal = $this->findPaypal($paypal, true);
        if ($this->userHasPaypal($objUser, $objPaypal)) {
            return ($objPaypal->delete());
        } else {
            throw new BadRequestHttpException("User has n't this paypal.");
        }
    }

    /**
     * @param string $bank
     * @param User|null $objUser
     * @return bool
     * @throws \Exception
     */
    public function deleteBanking(string $bank, ?User $objUser = null): bool {
        if (is_null($objUser))
            $objUser = Auth::user();

        $objBanking = $this->findBanking($bank, true);
        if ($this->userHasBankAccount($objUser, $objBanking)) {
            return ($objBanking->delete());
        } else {
            abort(400, "The user has n't this bank account.");
        }
    }
}
