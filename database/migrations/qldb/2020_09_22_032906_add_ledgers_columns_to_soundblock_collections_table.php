<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLedgersColumnsToSoundblockCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_collections", function (Blueprint $table) {
            $table->unsignedBigInteger("ledger_id")->index("idx_ledger-id")->nullable()->after("flag_changed_other");
            $table->uuid("ledger_uuid")->index("idx_ledger-uuid")->nullable()->after("ledger_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_collections_column", function (Blueprint $table) {
            $table->dropColumn("ledger_id");
            $table->dropColumn("ledger_uuid");
        });
    }
}
