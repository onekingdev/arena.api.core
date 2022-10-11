<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameGenreAndMoodsNameFields extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection("mysql-music")->table("genres", function (Blueprint $table) {
            $table->renameColumn("genre", "genre_name");
        });

        Schema::connection("mysql-music")->table("moods", function (Blueprint $table) {
            $table->renameColumn("mood", "mood_name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::connection("mysql-music")->table("genres", function (Blueprint $table) {
            $table->renameColumn("genre_name", "genre");
        });

        Schema::connection("mysql-music")->table("moods", function (Blueprint $table) {
            $table->renameColumn("mood_name", "mood");
        });
    }
}
