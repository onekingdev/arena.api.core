<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsBetaUserColumnToCoreMailingEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("core_mailing_emails", function (Blueprint $table) {
            $table->boolean("is_beta_user")->default(false)->after("email");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("core_mailing_emails", function (Blueprint $table) {
            $table->dropColumn("is_beta_user");
        });
    }
}
