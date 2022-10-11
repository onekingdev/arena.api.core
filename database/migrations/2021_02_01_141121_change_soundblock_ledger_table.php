<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSoundblockLedgerTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("soundblock_ledger", function (Blueprint $table) {
            $table->dropColumn(["ledger_name", "ledger_memo"]);
            $table->string("qldb_event")->after("qldb_table");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("soundblock_ledger", function (Blueprint $table) {
            $table->dropColumn("qldb_event");
            $table->string("ledger_name")->after("ledger_uuid");
            $table->string("ledger_memo")->after("ledger_name");
        });
    }
}
