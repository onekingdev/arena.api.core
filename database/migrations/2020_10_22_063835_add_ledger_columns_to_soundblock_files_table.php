<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLedgerColumnsToSoundblockFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files", function (Blueprint $table) {
            $table->unsignedBigInteger("ledger_id")->nullable()->after("directory_uuid")->unique("uidx_ledger-id");
            $table->uuid("ledger_uuid")->nullable()->after("ledger_id")->unique("uidx_ledger-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_files", function (Blueprint $table) {
            $table->dropColumn("ledger_id");
            $table->dropColumn("ledger_uuid");
        });
    }
}
