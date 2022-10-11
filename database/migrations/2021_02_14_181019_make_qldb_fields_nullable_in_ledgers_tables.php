<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeQldbFieldsNullableInLedgersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_ledger", function (Blueprint $table) {
            $table->string("qldb_hash")->nullable()->change();
            $table->json("qldb_data")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_ledger", function (Blueprint $table) {
            $table->json("qldb_data")->nullable(false)->change();
        });
    }
}
