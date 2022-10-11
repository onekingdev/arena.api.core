<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoundblockRevampPaymentUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_accounts_plans", function (Blueprint $objTable){
            $objTable->unsignedBigInteger("plan_type_id")->after("ledger_uuid")->index("idx_plan-type--id");
            $objTable->uuid("plan_type_uuid")->after("plan_type_id")->index("idx_plan-type-uuid");
        });

        Schema::table("soundblock_accounts_transactions", function (Blueprint $objTable){
            $objTable->dropColumn("transaction_id");
            $objTable->dropColumn("transaction_uuid");

            $objTable->float("transaction_amount", 8,2)->after("accounting_type_uuid")->index("idx_transaction-amount");
            $objTable->string("transaction_type")->after("transaction_amount")->index("idx_transaction-type");
            $objTable->string("transaction_status")->after("transaction_type")->index("idx_transaction-status");

            $objTable->renameColumn("accounting_type_id", "plan_type_id");
            $objTable->renameColumn("accounting_type_uuid", "plan_type_uuid");
        });

        Schema::table("soundblock_accounts_transactions", function (Blueprint $objTable){
            $objTable->renameColumn("row_id", "transaction_id");
            $objTable->renameColumn("row_uuid", "transaction_uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_accounts_plans", function (Blueprint $objTable){
            $objTable->dropColumn("plan_type_id");
            $objTable->dropColumn("plan_type_uuid");
        });

        Schema::table("soundblock_accounts_transactions", function (Blueprint $objTable){
            $objTable->renameColumn("transaction_id", "row_id");
            $objTable->renameColumn("transaction_uuid", "row_uuid");
        });

        Schema::table("soundblock_accounts_transactions", function (Blueprint $objTable){
            $objTable->unsignedBigInteger("transaction_id")->index("idx_transaction-id");
            $objTable->uuid("transaction_uuid")->index("uidx_transaction-uuid");

            $objTable->dropColumn("transaction_amount");
            $objTable->dropColumn("transaction_type");
            $objTable->dropColumn("transaction_status");

            $objTable->renameColumn("plan_type_id", "accounting_type_id");
            $objTable->renameColumn("plan_type_uuid", "accounting_type_uuid");
        });
    }
}
