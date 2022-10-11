<?php

namespace App\Http\Controllers\Soundblock;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Soundblock\Ledger\LedgerDataProvider;
use App\Contracts\Soundblock\Ledger as LedgerService;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Blockchain extends Controller {
    /** @var LedgerDataProvider */
    private LedgerDataProvider $ledgerDataProvider;
    /** @var LedgerService */
    private LedgerService $ledgerService;

    /**
     * Blockchain constructor.
     * @param LedgerDataProvider $ledgerDataProvider
     * @param LedgerService $ledgerService
     */
    public function __construct(LedgerDataProvider $ledgerDataProvider, LedgerService $ledgerService) {
        $this->ledgerDataProvider = $ledgerDataProvider;
        $this->ledgerService = $ledgerService;
    }

    /**
     * @param string $ledger
     * @param Request $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function getPrivate(string $ledger, Request $objRequest) {
        $intPerPage = $objRequest->input("per_page", 10);
        $intPage = $objRequest->input("page", 1);

        $objLedger = $this->ledgerDataProvider->find($ledger);
        $isAuth = $this->ledgerDataProvider->checkAccess($objLedger, Auth::user());

        if (!$isAuth) {
            return $this->apiReject(null, "Not Authorized.", Response::HTTP_FORBIDDEN);
        }

        $arrData = $this->ledgerService->getDocument($objLedger->qldb_table, $objLedger->qldb_id);

        $offset = ($intPage - 1) * $intPerPage;
        $arrHistory = array_slice($arrData["history"], $offset, $intPerPage);
        $arrPaginator = (new LengthAwarePaginator($arrHistory, count($arrData["history"]), $intPerPage, $intPage))->toArray();

        $arrData["meta"] = [
            "current_page" => $arrPaginator["current_page"],
            "from"         => $arrPaginator["from"],
            "last_page"    => $arrPaginator["last_page"],
            "links"        => $arrPaginator["links"],
            "path"         => $arrPaginator["path"],
            "per_page"     => $arrPaginator["per_page"],
            "to"           => $arrPaginator["to"],
            "total"        => $arrPaginator["total"],
        ];
        $arrData["history"] = $arrHistory;

        return $this->apiReply($arrData);
    }
}
