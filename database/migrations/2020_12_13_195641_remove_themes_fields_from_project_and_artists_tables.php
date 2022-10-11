<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveThemesFieldsFromProjectAndArtistsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("projects_themes", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("project_theme");
            $table->dropColumn("project_theme");
        });

        Schema::connection("mysql-music")->table("artists_themes", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("artist_theme");
            $table->dropColumn("artist_theme");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("projects_themes", function (Blueprint $table) {
            $table->string("project_theme")->nullable()->after("project_uuid");
            $table->unique(["project_id", "project_theme"], "unique_id");
            $table->index("project_theme", "project_theme");
        });

        Schema::connection("mysql-music")->table("artists_themes", function (Blueprint $table) {
            $table->string("artist_theme")->nullable()->after("artist_uuid");
            $table->unique(["artist_id", "artist_theme"],"unique_id");
            $table->index("artist_theme","artist_theme");
        });
    }
}
