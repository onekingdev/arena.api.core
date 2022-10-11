<?php

namespace App\Http\Controllers\Account;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\{Http\Request, Http\Response};
use App\Contracts\Accounting\Invoice as InvoiceContract;
use App\Http\Transformers\Account\Invoice as InvoiceTransformer;
use App\Http\Transformers\Accounting\{AccountingInvoice, AccountingInvoiceType};

/**
 * @group Account
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
}
