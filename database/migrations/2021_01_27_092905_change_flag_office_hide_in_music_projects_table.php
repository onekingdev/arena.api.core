<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFlagOfficeHideInMusicProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("projects", function (Blueprint $objTable) {
            $objTable->string("flag_office_hide")->change()->default("purchased");
            $objTable->boolean("flag_dead")->after("flag_office_complete")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("projects", function (Blueprint $objTable) {
            $objTable->boolean("flag_office_hide")->change()->default(0);
            $objTable->dropColumn("flag_dead");
        });
    }
}
