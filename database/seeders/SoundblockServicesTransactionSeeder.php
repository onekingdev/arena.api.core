<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounting\AccountingType;
use App\Models\Accounting\AccountingTransaction;
use App\Models\Soundblock\{Accounts\Account, Accounts\AccountTransaction};

class SoundblockServicesTransactionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $tableId = 0;
        $arrChargeTypes = AccountingType::whereIn("accounting_type_name", ["Account.Simple", "Account.Reporting", "Account.Collaboration", "Account.Enterprise"])->get();
        $begin = now()->subMonths(11);

        foreach ($begin->range(now(), 1, "month") as $date) {
            foreach (Account::all() as $key => $objAccount) {
                $tableId++;

                $objServiceTransaction = new AccountTransaction();

                $ledger = \App\Models\Soundblock\Ledger::create([
                    "ledger_uuid"      => Util::uuid(),
//                    "ledger_name"      => env("LEDGER_NAME"),
//                    "ledger_memo"      => env("LEDGER_NAME"),
                    "qldb_id"          => "transaction_id{$key}",
                    "qldb_table"       => "account_transaction",
                    "qldb_data"        => [],
                    "qldb_hash"        => [],
                    "qldb_block"       => [],
                    "qldb_metadata"    => [],
                    "table_name"       => $objServiceTransaction->getTable(),
                    "table_field"      => $objServiceTransaction->getKeyName(),
                    "table_id"         => $tableId,
                    "stamp_created_at" => $date,
                    "stamp_updated_at" => $date,
                ]);
                /** @var AccountingType */
                $objChargeType = $arrChargeTypes->random();
                $objTransaction = $objServiceTransaction->create([
                    "row_uuid"             => Util::uuid(),
                    "account_id"           => $objAccount->account_id,
                    "account_uuid"         => $objAccount->account_uuid,
                    "ledger_id"            => $ledger->ledger_id,
                    "ledger_uuid"          => $ledger->ledger_uuid,
                    "accounting_type_id"   => $objChargeType->accounting_type_id,
                    "accounting_type_uuid" => $objChargeType->accounting_type_uuid,
                    "stamp_created_at"     => $date,
                    "stamp_updated_at"     => $date,
                ]);
                $objAccountingTransaction = AccountingTransaction::create([
                    "transaction_uuid"   => Util::uuid(),
                    "app_uuid"           => $objTransaction->row_uuid,
                    "app_field"          => "row_id",
                    "app_table"          => "soundblock_accounts_transactions",
                    "app_field_id"       => $objTransaction->row_id,
                    "app_field_uuid"     => $objTransaction->row_uuid,
                    "transaction_amount" => floatval(rand(10, 1000) / 10),
                    "transaction_name"   => 'transaction name',
                    "transaction_memo"   => 'transaction memo',
                    "transaction_status" => 'not paid',
                    "stamp_created_at"   => $date,
                    "stamp_updated_at"   => $date,
                ]);

                $objTransaction->transaction_id = $objAccountingTransaction->transaction_id;
                $objTransaction->transaction_uuid = $objAccountingTransaction->transaction_uuid;
                $objTransaction->save();
            }
        }

        Model::reguard();
    }
}
