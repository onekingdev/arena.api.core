<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimecodesFieldsToSoundblockFilesMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files_music", function (Blueprint $table) {
            $table->time("preview_start")->nullable()->after("file_isrc");
            $table->time("preview_stop")->nullable()->after("preview_start");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_files_music", function (Blueprint $table) {
            $table->dropColumn(["preview_start", "preview_stop"]);
        });
    }
}
