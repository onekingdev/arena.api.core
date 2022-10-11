<?php

namespace App\Services\Ledger;

use Util;
use App\Models\Soundblock\Ledger as LedgerModel;
use App\Contracts\Soundblock\{Ledger\LedgerCache as LedgerCacheContract, Ledger};
use App\Repositories\Soundblock\{ContractLedger, Contract, Ledger as LedgerRepository};

class LedgerCache implements LedgerCacheContract {
    /**
     * @var Ledger
     */
    private Ledger $ledgerService;
    /**
     * @var LedgerRepository
     */
    private LedgerRepository $ledgerRepository;
    /**
     * @var Contract
     */
    private Contract $contractRepository;
    /**
     * @var ContractLedger
     */
    private ContractLedger $contractLedgerRepository;

    /**
     * LedgerCacheService constructor.
     * @param Ledger $ledgerService
     * @param LedgerRepository $ledgerRepository
     * @param Contract $contractRepository
     * @param ContractLedger $contractLedgerRepository
     */
    public function __construct(Ledger $ledgerService, LedgerRepository $ledgerRepository,
                                Contract $contractRepository, ContractLedger $contractLedgerRepository) {
        $this->ledgerService = $ledgerService;
        $this->ledgerRepository = $ledgerRepository;
        $this->contractRepository = $contractRepository;
        $this->contractLedgerRepository = $contractLedgerRepository;
    }

    /**
     * @param LedgerModel $objLedger
     * @return LedgerModel
     */
    public function updateLedgerByCache(LedgerModel $objLedger): LedgerModel {
        $arrLedgerExist = $this->ledgerService->getDocument($objLedger->qldb_table, $objLedger->qldb_id);

        if(empty($arrLedgerExist["document"])) {
            $ledgerData = $this->ledgerService->insertDocument($objLedger->qldb_table, $objLedger->qldb_data);

            $objLedger->qldb_id = $ledgerData["id"];
            $objLedger->qldb_data = $ledgerData["data"];
        } else {
            $ledgerData = $this->ledgerService->updateDocument($objLedger->qldb_table, $objLedger->qldb_id, $objLedger->qldb_data);

            $objLedger->qldb_id = $ledgerData["rid"];
        }

        $objLedger->qldb_block = $ledgerData["blockAddress"];
        $objLedger->qldb_hash = $ledgerData["hash"];
        $objLedger->qldb_metadata = $ledgerData["metadata"];
        $objLedger->save();

        return $objLedger;
    }

    /**
     * @param string $strTableName
     * @param array $arrData
     * @return LedgerModel
     * @throws \Exception
     */
    public function saveCache(string $strTableName, array $arrData): LedgerModel {
        switch($strTableName) {
            case "soundblock_contracts":
                $objContract = $this->contractRepository->find($arrData["data"]["contract_detail"]["contract_uuid"]);

                $arrTableFields = [
                    "table_name" => $this->contractLedgerRepository::MYSQL_TABLE,
                    "table_field" => $this->contractLedgerRepository::MYSQL_ID_FIELD,
                    "table_id" => $objContract->contract_id
                ];
                break;
            default:
                throw new \InvalidArgumentException("strTableName is not supported by blockchain service.");
                break;
        }

        $objLedger = $this->ledgerRepository->get($arrData["id"]);

        if(is_null($objLedger)) {
            $arrTableFields["ledger_name"] = env("LEDGER_NAME");
            $arrTableFields["ledger_memo"] = env("LEDGER_NAME");
            $arrTableFields["ledger_uuid"] = Util::uuid();
            $objLedger = $this->ledgerRepository->makeModel($arrTableFields);
        }


        $objLedger->qldb_id = $arrData["id"];
        $objLedger->qldb_table = $strTableName;
        $objLedger->qldb_block = $arrData["blockAddress"];
        $objLedger->qldb_data = $arrData["data"];
        $objLedger->qldb_hash = $arrData["hash"];
        $objLedger->qldb_metadata = $arrData["metadata"];
        $objLedger->save();

        return $objLedger;
    }
}
