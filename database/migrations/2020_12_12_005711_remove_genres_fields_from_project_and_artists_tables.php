<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveGenresFieldsFromProjectAndArtistsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("projects_genres", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("project_genre");
            $table->dropColumn("project_genre");
        });

        Schema::connection("mysql-music")->table("artists_genres", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("artist_genre");
            $table->dropColumn("artist_genre");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("projects_genres", function (Blueprint $table) {
            $table->string("project_genre")->nullable()->after("project_uuid");
            $table->unique(["project_id", "project_genre"], "unique_id");
            $table->index("project_genre", "project_genre");
        });

        Schema::connection("mysql-music")->table("artists_genres", function (Blueprint $table) {
            $table->string("artist_genre")->nullable()->after("artist_uuid");
            $table->unique(["artist_id", "artist_genre"],"unique_id");
            $table->index("artist_genre","artist_genre");
        });
    }
}
