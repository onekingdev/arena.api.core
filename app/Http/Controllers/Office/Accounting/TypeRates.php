<?php

namespace App\Http\Controllers\Office\Accounting;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Contracts\Accounting\TypeRate as TypeRateContract;
use App\Http\{Controllers\Controller,
    Requests\Office\Finance\SaveChargeRates,
    Transformers\Office\Accounting\AccountingType,
    Requests\Accounting\UpdateTypeRate as UpdateTypeRateRepository,
};

/**
 * @group Office Accounting
 *
 */
class TypeRates extends Controller {
    private $typeRateService;

    /**
     * Accounting constructor.
     */
    public function __construct() {
        $this->typeRateService = resolve(TypeRateContract::class);
    }

    /**
     */
    public function getCharges() {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccounting = $this->typeRateService->getCharges();

        return ($this->apiReply($objAccounting, "Type rates get successfully."));
    }

    /**
     * @param SaveChargeRates $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function saveCharges(SaveChargeRates $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccounting = $this->typeRateService->saveCharges($objRequest->all());

        return $this->collection($objAccounting, new AccountingType(["accountingTypeRates"]));
    }

    /**
     * @param UpdateTypeRateRepository $request
     * @param string $typeRateUuid
     * @return mixed
     */
    public function updateTypeRate(UpdateTypeRateRepository $request, string $typeRateUuid){
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->typeRateService->updateTypeRate(
            $request->only([
                "accounting_type_uuid",
                "accounting_rate"
            ]),
            $typeRateUuid
        );

        return ($this->apiReply(null, "Type rate updated successfully.", 200));
    }

    /**
     * @param string $typeRateUuid
     * @return mixed
     */
    public function deleteTypeRate(string $typeRateUuid){
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->typeRateService->deleteTypeRate($typeRateUuid);

        return ($this->apiReply(null, "Type rate deleted successfully.", 200));
    }
}
