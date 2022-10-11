<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMorphColumnsInSoundblockInvitesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->renameColumn("table_name", "model_class");
            $table->renameColumn("table_id", "model_id");

            $table->dropColumn("table_field");
            $table->float("invite_payout", 4, 2)->after("invite_role");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->renameColumn("model_path", "table_name");
            $table->renameColumn("model_id", "table_id");

            $table->string("table_field")->after("table_name");
            $table->dropColumn("invite_payout");
        });
    }
}
