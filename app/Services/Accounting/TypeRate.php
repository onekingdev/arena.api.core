<?php

namespace App\Services\Accounting;

use App\Repositories\Accounting\AccountingTypeRate as AccountingTypeRateRepository;

class TypeRate {

    /** @var AccountingTypeRateRepository */
    private AccountingTypeRateRepository $typeRateRepo;

    public function __construct(AccountingTypeRateRepository $accountingTypeRate) {
        $this->typeRateRepo = $accountingTypeRate;
    }

    /**
     * @return mixed
     */
    public function getCharges(){
        $objTypeRates = $this->typeRateRepo->all();

        return ($objTypeRates);
    }

    /**
     * @param array $requestData
     * @return mixed
     * @throws \Exception
     */
    public function saveCharges(array $requestData){
        $objAccounting = $this->typeRateRepo->saveRates($requestData);

        if(is_null($objAccounting)){
            abort(404, "Something goes wrong.");
        }

        return ($objAccounting);
    }

    /**
     * @param array $requestData
     * @param string $typeRateUuid
     * @return mixed
     */
    public function updateTypeRate(array $requestData, string $typeRateUuid){
        $boolResult = $this->typeRateRepo->updateTypeRate($requestData, $typeRateUuid);

        if(!$boolResult){
            abort(404, "Type rate hasn't updated.");
        }

        return ($boolResult);
    }

    /**
     * @param string $typeRateUuid
     * @return mixed
     */
    public function deleteTypeRate(string $typeRateUuid){
        $boolResult = $this->typeRateRepo->deleteTypeRate($typeRateUuid);

        if(!$boolResult){
            abort(404, "Type rate hasn't deleted.");
        }

        return ($boolResult);
    }
}
