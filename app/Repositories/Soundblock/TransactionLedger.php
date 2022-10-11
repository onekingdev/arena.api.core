<?php

namespace App\Repositories\Soundblock;

use App\Contracts\Soundblock\Ledger;
use App\Repositories\BaseRepository;
use App\Repositories\Soundblock\Ledger as LedgerRepo;
use Disaster;
use App\Models\Soundblock\Ledger as LedgerModel;
use App\Models\Soundblock\Accounts\AccountTransaction;
use App\Exceptions\Core\Disaster\LedgerMicroserviceException;

class TransactionLedger extends BaseRepository {
    /* QLDB Transaction table name */
    const TABLE = "soundblock_transactions";

    /* MySQL Transaction Table */
    const MYSQL_TABLE = "soundblock_service_transactions";

    /* MySQL Transaction Table Primary Field */
    const MYSQL_ID_FIELD = "row_id";
    /**
     * @var Ledger
     */
    private Ledger $ledgerService;
    /**
     * @var LedgerRepo
     */
    private LedgerRepo $ledgerRepository;

    /**
     * TransactionLedgerRepository constructor.
     * @param Ledger $ledgerService
     * @param LedgerRepo $ledgerRepository
     */
    public function __construct(Ledger $ledgerService, LedgerRepo $ledgerRepository) {
        $this->ledgerService = $ledgerService;
        $this->ledgerRepository = $ledgerRepository;
    }

    /**
     * @param AccountTransaction $accountTransaction
     * @return array|null
     * @throws \Exception
     */
    public function createDocument(AccountTransaction $accountTransaction) {
        try {
            /** @var LedgerModel $objLedger */
            $objLedger = $accountTransaction->ledger;
            $objTransactionUser = $accountTransaction->account->user;
            $objAccountingTransaction = $accountTransaction->accountingTransaction;

            $data = [
                "user"               => $objTransactionUser->user_uuid,
                "user_name"          => $objTransactionUser->name,
                "transaction_amount" => $objAccountingTransaction->transaction_amount,
                "transaction_name"   => $objAccountingTransaction->transaction_name,
                "transaction_status" => $objAccountingTransaction->transaction_status,
                "epoch"              => time(),
            ];

            if (isset($objLedger)) {
                $arrLedgerData = $this->ledgerService->updateDocument(self::TABLE, $objLedger->qldb_id, $data);
                $objLedger->qldb_data = $data;
            } else {
                $arrLedgerData = $this->ledgerService->insertDocument(self::TABLE, $data);

                $objLedger = $this->ledgerRepository->create([
                    "ledger_name"   => env("LEDGER_NAME"),
                    "ledger_memo"   => env("LEDGER_NAME"),
                    "qldb_id"       => $arrLedgerData["document"]["id"],
                    "qldb_table"    => self::TABLE,
                    "qldb_data"     => $data,
                    "qldb_hash"     => $arrLedgerData["document"]["hash"],
                    "qldb_block"    => $arrLedgerData["document"]["blockAddress"],
                    "qldb_metadata" => $arrLedgerData["document"]["metadata"],
                    "table_name"    => self::MYSQL_TABLE,
                    "table_field"   => self::MYSQL_ID_FIELD,
                    "table_id"      => $accountTransaction->transaction_id,
                ]);

                $accountTransaction->ledger()->associate($objLedger);
                $accountTransaction->ledger_uuid = $objLedger->ledger_uuid;
                $accountTransaction->save();
            }
        } catch (LedgerMicroserviceException $exception) {
            Disaster::handleDisaster($exception);

            return null;
        }

        return $arrLedgerData;
    }
}
