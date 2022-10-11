<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppsFlagsToNotificationsUsersSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications_users_settings', function (Blueprint $table) {
            $table->boolean("flag_facecoverings")->default(true);
            $table->boolean("flag_prints")->default(true);
            $table->boolean("flag_screenburning")->default(true);
            $table->boolean("flag_sewing")->default(true);
            $table->boolean("flag_tourmask")->default(true);
            $table->boolean("web")->default(true);
            $table->boolean("flag_ux")->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications_users_settings', function (Blueprint $table) {
            //
        });
    }
}
