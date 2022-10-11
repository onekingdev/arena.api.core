<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagActionToSoundblockProjectsContractsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects_contracts_users", function (Blueprint $table) {
            $table->string("flag_action")->after("contract_version");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects_contracts_users", function (Blueprint $table) {
            $table->dropColumn("flag_action");
        });
    }
}
