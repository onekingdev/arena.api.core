<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsInAccountingInvoicesTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_invoices_transactions', function (Blueprint $table) {
            $table->renameColumn("transaction_id", "row_id");
            $table->renameColumn("transaction_uuid", "row_uuid");
            $table->renameIndex("uidx_transaction-uuid", "uidx_row-uuid");
            $table->unique("row_id", "uidx_row-id");

            $table->renameIndex("uidx_transaction-id_invoice_id", "uidx_row-id_invoice_id");
            $table->renameIndex("uidx_transaction-uuid_invoice-uuid", "uidx_row-uuid_invoice-uuid");
        });
        Schema::table('accounting_invoices_transactions', function (Blueprint $table) {
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
        Schema::table('accounting_invoices_transactions', function (Blueprint $table) {
            $table->dropColumn("transaction_id");
            $table->dropColumn("transaction_uuid");
            $table->dropIndex("idx_transaction-id");
            $table->dropIndex("uidx_transaction-uuid");

            $table->renameColumn("row_id", "transaction_id");
            $table->renameColumn("row_uuid", "transaction_uuid");
            $table->renameIndex("uidx_row-uuid", "uidx_transaction-uuid");
            $table->unique("transaction_id", "uidx_transaction-id");

            $table->renameIndex("uidx_row-id_invoice_id", "uidx_transaction-id_invoice_id");
            $table->renameIndex("uidx_row-uuid_invoice-uuid", "uidx_transaction-uuid_invoice-uuid");

        });
    }
}
