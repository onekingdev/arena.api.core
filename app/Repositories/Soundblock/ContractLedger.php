<?php


namespace App\Repositories\Soundblock;

use Disaster;
use App\Contracts\Soundblock\Ledger as LedgerContract;
use App\Exceptions\Core\Disaster\LedgerMicroserviceException;
use App\Models\{Soundblock\Projects\Contracts\Contract, Soundblock\Ledger as LedgerModel};

class ContractLedger {
    /* QLDB Contract table name */
    const TABLE = "soundblock_contracts";

    /* MySQL Contract Table */
    const MYSQL_TABLE = "soundblock_contracts";

    /* MySQL Contract Table Primary Field */
    const MYSQL_ID_FIELD = "contract_id";
    /**
     * @var LedgerContract
     */
    private LedgerContract $ledger;
    /**
     * @var Ledger
     */
    private Ledger $ledgerRepo;

    /**
     * ContractLedgerRepository constructor.
     * @param LedgerContract $ledger
     * @param Ledger $ledgerRepo
     */
    public function __construct(LedgerContract $ledger, Ledger $ledgerRepo) {
        $this->ledger = $ledger;
        $this->ledgerRepo = $ledgerRepo;
    }

    /**
     * @param Contract $contract
     * @return array|null
     */
    public function createDocument(Contract $contract): ?array {
        try {
            /** @var LedgerModel $objLedger */
            $objLedger = $contract->ledger;
            $arrLedgerUsers = [];
            $arrContractUsers = $contract->users()->wherePivot("contract_version", $contract->contract_version)
                                         ->withPivot(["contract_status", "user_payout"])->get();

            foreach ($arrContractUsers as $objUser) {
                $arrLedgerUsers[] = [
                    "uuid"   => $objUser->user_uuid,
                    "name"   => $objUser->name,
                    "payout" => $objUser->pivot->user_payout,
                    "status" => $objUser->pivot->contract_status,
                ];
            }

            $data = [
                "contract"         => $contract->contract_uuid,
                "contract_version" => $contract->contract_version,
                "contract_status"  => $contract->flag_status,
                "users"            => $arrLedgerUsers,
                "epoch"            => time(),
            ];

            if (isset($objLedger)) {
                $arrLedgerData = $this->ledger->updateDocument(self::TABLE, $objLedger->qldb_id, $data);
                $objLedger->qldb_data = $data;
            } else {
                $arrLedgerData = $this->ledger->insertDocument(self::TABLE, $data);
                $objLedger = $this->ledgerRepo->create([
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
                    "table_id"      => $contract->contract_id,
                ]);

                $contract->ledger()->associate($objLedger);
                $contract->ledger_uuid = $objLedger->ledger_uuid;
                $contract->save();
            }
        } catch (LedgerMicroserviceException $exception) {
            Disaster::handleDisaster($exception);

            return null;
        }

        return $arrLedgerData;
    }
}
