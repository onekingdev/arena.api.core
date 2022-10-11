<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixIsrcColumnInSoundblockFilesMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_files_music", function (Blueprint $table) {
            $table->string("file_isrc", 20)->change();
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
            $table->string("file_isrc", 12)->change();
        });
    }
}
