<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStyleFieldToArtistsAndProjectsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("artists_styles", function (Blueprint $table) {
            $table->unsignedBigInteger("style_id")->index("idx_style-id")->after("artist_uuid");
            $table->uuid("style_uuid")->index("idx_style-uuid")->after("style_id");
        });

        Schema::connection("mysql-music")->table("projects_styles", function (Blueprint $table) {
            $table->unsignedBigInteger("style_id")->index("idx_style-id")->after("project_uuid");
            $table->uuid("style_uuid")->index("idx_style-uuid")->after("style_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("artists_styles", function (Blueprint $table) {
            $table->dropColumn(["style_id", "style_uuid"]);
        });

        Schema::connection("mysql-music")->table("projects_styles", function (Blueprint $table) {
            $table->dropColumn(["style_id", "style_uuid"]);
        });
    }
}
