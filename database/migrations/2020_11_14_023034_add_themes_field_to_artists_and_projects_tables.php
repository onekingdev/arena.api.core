<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThemesFieldToArtistsAndProjectsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("artists_themes", function (Blueprint $table) {
            $table->unsignedBigInteger("theme_id")->index("idx_theme-id")->after("artist_uuid");
            $table->uuid("theme_uuid")->index("idx_theme-uuid")->after("theme_id");
        });

        Schema::connection("mysql-music")->table("projects_themes", function (Blueprint $table) {
            $table->unsignedBigInteger("theme_id")->index("idx_theme-id")->after("project_uuid");
            $table->uuid("theme_uuid")->index("idx_theme-uuid")->after("theme_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("artists_themes", function (Blueprint $table) {
            $table->dropColumn(["theme_id", "theme_uuid"]);
        });

        Schema::connection("mysql-music")->table("projects_themes", function (Blueprint $table) {
            $table->dropColumn(["theme_id", "theme_uuid"]);
        });
    }
}
