<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsInSoundblockServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soundblock_services', function (Blueprint $table) {
            $table->renameColumn("charge_rate", "accounting_rate");
        });
        Schema::table('soundblock_services_transactions', function (Blueprint $table) {
            $table->renameColumn("transaction_id", "row_id");
            $table->renameColumn("transaction_uuid", "row_uuid");

            $table->unique("row_id", "uidx_row-id");
            $table->renameIndex("uidx_transaction-uuid", "uidx_row-uuid");
            $table->dropIndex("uidx_transaction-id");

            $table->renameColumn("charge_type_id", "accounting_type_id");
            $table->renameColumn("charge_type_uuid", "accounting_type_uuid");
            $table->renameIndex("idx_charge-type-id", "idx_accounting-type-id");
            $table->renameIndex("idx_charge-type-uuid", "idx_accounting-type-uuid");
        });
        Schema::table('soundblock_services_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger("transaction_id")->index("idx_transaction-id");
            $table->uuid("transaction_uuid")->index("uidx_transaction-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soundblock_services', function (Blueprint $table) {
            $table->renameColumn("accounting_rate", "charge_rate");
        });
        Schema::table('soundblock_services_transactions', function (Blueprint $table) {
            $table->dropColumn("transaction_id");
            $table->dropColumn("transaction_uuid");
            $table->dropIndex("idx_transaction-id");
            $table->dropIndex("uidx_transaction-id");

            $table->renameColumn("row_id", "transaction_id");
            $table->renameColumn("row_uuid", "transaction_uuid");

            $table->unique("transaction_id", "uidx_transaction-id");
            $table->unique("transaction_uuid", "uidx_transaction-uuid");

            $table->renameColumn("accounting_type_id", "charge_type_id");
            $table->renameColumn("accounting_type_uuid", "charge_type_uuid");
            $table->renameIndex("idx_accounting-type-id", "idx_charge-type-id");
            $table->renameIndex("idx_accounting-type-uuid", "idx_charge-type-uuid");
        });
    }
}
