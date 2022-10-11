<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLedgerFieldsToSoundblockTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_tracks", function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("ledger_id")->after("file_uuid")->index("idx_ledger-id")->nullable();
            $objTable->uuid("ledger_uuid")->after("ledger_id")->index("idx_ledger-uuid")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_tracks", function (Blueprint $objTable) {
            $objTable->dropColumn("ledger_id");
            $objTable->dropColumn("ledger_uuid");
            $objTable->dropIndex("idx_ledger-id");
            $objTable->dropIndex("idx_ledger-uuid");
        });
    }
}
