<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPayoutFields extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table("soundblock_projects_contracts_users", function (Blueprint $table) {
            $table->float("user_payout", 5, 2)->change();
        });

        Schema::table("soundblock_projects_teams_users", function (Blueprint $table) {
            $table->float("user_payout", 5, 2)->change();
        });

        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->float("invite_payout", 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("soundblock_projects_contracts_users", function (Blueprint $table) {
            $table->float("user_payout", 4, 2)->change();
        });

        Schema::table("soundblock_projects_teams_users", function (Blueprint $table) {
            $table->float("user_payout", 4, 2)->change();
        });

        Schema::table("soundblock_invites", function (Blueprint $table) {
            $table->float("invite_payout", 4, 2)->change();
        });
    }
}
