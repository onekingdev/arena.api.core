<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStylesFieldsFromProjectAndArtistsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("projects_styles", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("project_style");
            $table->dropColumn("project_style");
        });

        Schema::connection("mysql-music")->table("artists_styles", function (Blueprint $table) {
            $table->dropIndex("unique_id");
            $table->dropIndex("artist_style");
            $table->dropColumn("artist_style");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("projects_styles", function (Blueprint $table) {
            $table->string("project_style")->nullable()->after("project_uuid");
            $table->unique(["project_id", "project_style"], "unique_id");
            $table->index("project_style", "project_style");
        });

        Schema::connection("mysql-music")->table("artists_styles", function (Blueprint $table) {
            $table->string("artist_style")->nullable()->after("artist_uuid");
            $table->unique(["artist_id", "artist_style"],"unique_id");
            $table->index("artist_style","artist_style");
        });
    }
}
