<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoodsFieldToArtistsAndProjectsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->table("artists_moods", function (Blueprint $table) {
            $table->unsignedBigInteger("mood_id")->index("idx_mood-id")->after("artist_uuid");
            $table->uuid("mood_uuid")->index("idx_mood-uuid")->after("mood_id");
        });

        Schema::connection("mysql-music")->table("projects_moods", function (Blueprint $table) {
            $table->unsignedBigInteger("mood_id")->index("idx_mood-id")->after("project_uuid");
            $table->uuid("mood_uuid")->index("idx_mood-uuid")->after("mood_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection("mysql-music")->table("artists_moods", function (Blueprint $table) {
            $table->dropColumn(["mood_id", "mood_uuid"]);
        });

        Schema::connection("mysql-music")->table("projects_moods", function (Blueprint $table) {
            $table->dropColumn(["mood_id", "mood_uuid"]);
        });
    }
}
