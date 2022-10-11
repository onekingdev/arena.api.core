<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMusicProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("projects", function (Blueprint $objTable) {
            $objTable->boolean("flag_office_hide")->after("flag_allmusic")->default(0);
            $objTable->boolean("flag_office_complete")->after("flag_office_hide")->default(0);
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
            $objTable->dropColumn("flag_office_hide");
            $objTable->dropColumn("flag_office_complete");
        });
    }
}
