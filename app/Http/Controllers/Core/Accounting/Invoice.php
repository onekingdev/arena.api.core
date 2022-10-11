<?php

namespace App\Http\Controllers\Core\Accounting;

use Auth;
use Client;
use App\Http\Requests\{
    Accounting\GetInvoices,
    Accounting\CreateInvoice,
    Accounting\CreateInvoiceType as CreateInvoiceTypeRequest,
    Accounting\UpdateInvoiceType as UpdateInvoiceTypeRequest
};
use App\Http\Controllers\Controller;
use App\Models\Soundblock\Accounts\Account;
use App\Facades\Accounting\Invoice as InvoiceFacade;
use App\Contracts\Accounting\Invoice as InvoiceContract;
use App\Http\Transformers\Account\Invoice as InvoiceTransformer;
use Illuminate\{Http\Request, Http\Response, Support\Collection};
use App\Services\{User, Common\Common, Soundblock\AccountTransaction};
use App\Http\Transformers\Accounting\{AccountingInvoice, AccountingInvoiceType};

/**
 * @group Core Accounting
 *
 */
class Invoice extends Controller {
    private $invoiceService;

    /**
     * Invoice constructor.
     */
    public function __construct() {
        $this->invoiceService = resolve(InvoiceContract::class);
    }

    /**
     * @param GetInvoices $objRequest
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\Paginator
     * @throws \Exception
     */
    public function index(GetInvoices $objRequest) {
        try {
            if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
                return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
            }

            return ($this->invoiceService->findAll([], $objRequest->input("per_page")));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInvoices(Request $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $perPage = $request->input('per_page', 10);

        $objInvoices = $this->invoiceService->getUserInvoices(Auth::user()->user_uuid, $perPage);

        return ($this->paginator($objInvoices, new AccountingInvoice(["app"])));
    }

    /**
     * @param string $strInvoiceUUID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceByUuid(string $strInvoiceUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objInvoice = $this->invoiceService->getInvoiceByUuid($strInvoiceUUID);

        return ($this->item($objInvoice, new InvoiceTransformer(["app"])));
    }

    /**
     * @param string $strInvoiceUUID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceType(string $strInvoiceUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objInvoice = $this->invoiceService->getInvoiceByUuid($strInvoiceUUID);

        return ($this->item($objInvoice->invoiceType, new AccountingInvoiceType));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getInvoiceTypes() {
        try {
            if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
                return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
            }

            $arrInvoiceType = $this->invoiceService->getInvoiceTypes();

            return ($this->collection($arrInvoiceType, new AccountingInvoiceType));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param string $typeUuid
     * @return mixed
     */
    public function getTypeByUuid(string $typeUuid){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objInvoiceType = $this->invoiceService->findInvoiceType($typeUuid);

        return ($this->apiReply($objInvoiceType, "Invoice type get successfully.", 200));
    }

    /**
     * @param CreateInvoice $objRequest
     * @param User $userService
     * @param Common $commonService
     * @param AccountTransaction $transactionService
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function store(CreateInvoice $objRequest, User $userService, Common $commonService, AccountTransaction $transactionService) {
        //TODO: Refactor to New Payment System
//        try {
//            if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
//                return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
//            }
//
//            $chargeTypeName = $objRequest->charge_type;
//            if ($objRequest->has("user")) {
//                $objReceiver = $userService->find($objRequest->user, true);
//                return ($this->apiReply());
//            } else {
//                /** @var Account */
//                $objAccount = $commonService->find($objRequest->account);
//                $objReceiver = $objAccount->user;
//                // Create a Account Transaction
//                $objAccountTransaction = $transactionService->create($objAccount, $chargeTypeName);
//                /** @var array */
//                $arrLineItem = $objRequest->line_items;
//                $discountTotal = intval($objRequest->discount);
//                foreach ($arrLineItem as $lineItem) {
//                    $unitAmount = intval(floatval($lineItem["cost"]) * 100);
//                    InvoiceFacade::createInvoiceItem($objReceiver, $lineItem["name"], $unitAmount, intval($lineItem["quantity"]), intval($lineItem["discount"]), $discountTotal);
//                }
//                $options = (new Collection($objRequest->all()))->only(["coupon", "discount"])->toArray();
//                /** @var \App\Models\Accounting\AccountingInvoice */
//                $objInvoice = InvoiceFacade::createInvoiceFor($objReceiver, $objAccountTransaction, Client::app(), $objRequest->invoice_type, $objRequest->line_items, Auth::user(), $options);
//
//                return ($this->apiReply($objInvoice->load(["invoiceType.app", "transactions.transactionType"])));
//            }
//        } catch (\Exception $e) {
//            throw $e;
//        }
    }

    /**
     * @param CreateInvoiceTypeRequest $request
     * @return mixed
     */
    public function createInvoiceType(CreateInvoiceTypeRequest $request){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objInvoiceType = $this->invoiceService->createInvoiceType($request->only([
            "accounting_type_name",
            "accounting_type_memo"
        ]));

        return ($this->apiReply($objInvoiceType, "New type created successfully.", 200));
    }

    /**
     * @param UpdateInvoiceTypeRequest $request
     * @param string $typeUuid
     * @return mixed
     */
    public function updateType(UpdateInvoiceTypeRequest $request, string $typeUuid){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $this->invoiceService->updateInvoiceType(
            $request->only([
                "accounting_type_name",
                "accounting_type_memo"
            ]),
            $typeUuid
        );

        return ($this->apiReply(null, "Invoice type updated successfully.", 200));
    }

    /**
     * @param string $typeUuid
     * @return mixed
     */
    public function deleteType(string $typeUuid){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $this->invoiceService->deleteInvoiceType($typeUuid);

        return ($this->apiReply(null, "Invoice type deleted successfully.", 200));
    }
}
