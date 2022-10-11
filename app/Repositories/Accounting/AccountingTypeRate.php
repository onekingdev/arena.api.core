<?php

namespace App\Repositories\Accounting;

use Util;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Repositories\Accounting\AccountingType as AccountingTypeRepository;
use App\Models\Accounting\{AccountingType, AccountingTypeRate as AccountingTypeRateModel};

class AccountingTypeRate extends BaseRepository {
    /**
     * @var AccountingTypeRateModel
     */
    protected \Illuminate\Database\Eloquent\Model $model;
    /**
     * @var AccountingTypeRepository
     */
    private AccountingTypeRepository $accountingTypeRepository;

    /**
     * AccountingTypeRateRepository constructor.
     * @param AccountingTypeRateModel $accountingTypeRate
     * @param AccountingTypeRepository $accountingTypeRepository
     */
    public function __construct(AccountingTypeRateModel $accountingTypeRate, AccountingTypeRepository $accountingTypeRepository) {
        $this->model = $accountingTypeRate;
        $this->accountingTypeRepository = $accountingTypeRepository;
    }

    /**
     * @param AccountingType $accountingType
     * @param int $version
     * @return AccountingTypeRateModel
     */
    public function getRateByVersion(AccountingType $accountingType, int $version): AccountingTypeRateModel {
        return $accountingType->accountingTypeRates()->where("accounting_version", $version)->first();
    }

    public function saveRates(array $arrParams) {
        $version = $this->getLastRateVersion() + 1;

        if (isset($arrParams["rates"])) {
            try {
                DB::beginTransaction();

                foreach ($arrParams["rates"] as $rateTypeName => $rate) {
                    $objAccounting = $this->accountingTypeRepository->findByName($rateTypeName);

                    if (is_null($objAccounting)) {
                        continue;
                    }

                    $objAccounting->accountingTypeRates()->create([
                        "row_uuid"             => Util::uuid(),
                        "accounting_type_id"   => $objAccounting->accounting_type_id,
                        "accounting_type_uuid" => $objAccounting->accounting_type_uuid,
                        "accounting_version"   => $version,
                        "accounting_rate"      => $rate,
                    ]);
                }

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();

                throw $exception;
            }

        }


        return $this->accountingTypeRepository->all();
    }

    public function getLastRateVersion(): int {
        return $this->model->max("accounting_version");
    }

    /**
     * @param AccountingType $objAccountingType
     *
     * @return AccountingTypeRateModel
     */
    public function findLatestByType(AccountingType $objAccountingType): AccountingTypeRateModel {
        return ($objAccountingType->accountingTypeRates()->orderBy("accounting_version", "desc")->firstOrFail());
    }

    public function updateTypeRate(array $updateData, string $typeRateUuid){
        return ($this->model->where("row_uuid", $typeRateUuid)->update($updateData));
    }

    public function deleteTypeRate(string $typeRate){
        return ($this->model->where("row_uuid", $typeRate)->delete());
    }
}
