<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTimecodesColumnsInSoundblockFilesMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files_music", function (Blueprint $table) {
            $table->dropColumn("preview_start");
            $table->dropColumn("preview_stop");
        });

        DB::statement("ALTER TABLE soundblock_files_music ADD COLUMN preview_start TIME(3) AFTER file_isrc;");
        DB::statement("ALTER TABLE soundblock_files_music ADD COLUMN preview_stop TIME(3) AFTER preview_start;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_files_music", function (Blueprint $table) {
            $table->dropColumn("preview_start");
            $table->dropColumn("preview_stop");
        });

        Schema::table("soundblock_files_music", function (Blueprint $table) {
            $table->time("preview_start")->nullable()->after("file_isrc");
            $table->time("preview_stop")->nullable()->after("preview_start");
        });
    }
}
