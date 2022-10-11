<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveMoodsFieldsFromProjectAndArtistsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("projects_moods", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("project_mood");
            $table->dropColumn("project_mood");
        });

        Schema::connection("mysql-music")->table("artists_moods", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("artist_mood");
            $table->dropColumn("artist_mood");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("projects_moods", function (Blueprint $table) {
            $table->string("project_mood")->nullable()->after("project_uuid");
            $table->unique(["project_id", "project_mood"], "unique_id");
            $table->index("project_mood", "project_mood");
        });

        Schema::connection("mysql-music")->table("artists_moods", function (Blueprint $table) {
            $table->string("artist_mood")->nullable()->after("artist_uuid");
            $table->unique(["artist_id", "artist_mood"],"unique_id");
            $table->index("artist_mood","artist_mood");
        });
    }
}
