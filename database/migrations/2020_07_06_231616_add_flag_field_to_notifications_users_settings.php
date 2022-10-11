<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagFieldToNotificationsUsersSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications_users_settings', function (Blueprint $objTable) {
            $objTable->boolean("flag_embroidery")->default(false)->after("flag_account");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications_users_settings', function (Blueprint $objTable) {
            $objTable->dropColumn("flag_embroidery");
        });
    }
}
