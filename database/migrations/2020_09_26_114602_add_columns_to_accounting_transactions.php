<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAccountingTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("accounting_transactions", function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("accounting_type_id")->after("transaction_type");
            $objTable->string("accounting_type_uuid")->after("accounting_type_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("accounting_transactions", function (Blueprint $objTable) {
            $objTable->dropColumn("accounting_type_id");
            $objTable->dropColumn("accounting_type_uuid");
        });
    }
}
