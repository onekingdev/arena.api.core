<?php

namespace App\Http\Transformers;

use App\Models\BaseModel;
use App\Traits\StampCache;
use App\Http\Transformers\User\User;
use App\Http\Transformers\Soundblock\Transaction;
use App\Http\Transformers\Soundblock\AccountPlan;
use App\Models\Soundblock\Accounts\Account as AccountModel;

class Account extends BaseTransformer {
    /**
     * @var bool
     */
    private $bnPlanActive;
    /**
     * @var bool
     */
    private $bnIncludePayment;

    /**
     * AccountTransformer constructor.
     * @param array|null $arrIncludes
     * @param bool $bnPlanActive
     * @param bool $bnIncludePayment
     */
    public function __construct(array $arrIncludes = null, $bnPlanActive = false, $bnIncludePayment = false) {
        parent::__construct($arrIncludes, "soundblock");
        $this->bnPlanActive = $bnPlanActive;
        $this->bnIncludePayment = $bnIncludePayment;
    }

    use StampCache;

    public function transform(AccountModel $objAccount) {
        $response = [
            "account_uuid" => $objAccount->account_uuid,
            "account_name" => $objAccount->account_name,
            "ledger_uuid"  => $objAccount->ledger_uuid,
        ];

        switch ($this->resType) {
            case "soundblock":
            {
                break;
            }
            case "office":
            {
                $response["downloads"] = $objAccount->downloads();
                break;
            }
            default:
                break;
        }


        return (array_merge($response, $this->stamp($objAccount)));
    }

    public function includeUser(AccountModel $objAccount) {
        return ($this->item($objAccount->user, new User()));
    }

    public function includeTransactions(AccountModel $objAccount) {
        return ($this->collection($objAccount->transactions, new Transaction()));
    }

    public function includePlans(AccountModel $objAccount) {
        if ($this->bnPlanActive) {
            $objPlan = $objAccount->plans()->active()->first();

            if (is_null($objPlan)) {
                return null;
            }

            return ($this->item($objPlan, new AccountPlan()));
        }

        return ($this->item($objAccount->plans()->orderBy(BaseModel::STAMP_CREATED, "desc")
                                       ->first(), new AccountPlan()));
    }

    public function includeActivePlan(AccountModel $objAccount) {
        return ($this->item($objAccount->activePlan, new AccountPlan()));
    }

}
