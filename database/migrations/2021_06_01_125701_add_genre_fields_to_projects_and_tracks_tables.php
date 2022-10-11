<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenreFieldsToProjectsAndTracksTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects", function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("genre_primary_id")->after("project_language_uuid")->index("idx_genre-primary-id");
            $objTable->uuid("genre_primary_uuid")->after("genre_primary_id")->index("idx_genre-primary-uuid");

            $objTable->unsignedBigInteger("genre_secondary_id")->after("genre_primary_uuid")->index("idx_genre-secondary-id");
            $objTable->uuid("genre_secondary_uuid")->after("genre_secondary_id")->index("idx_genre-secondary-uuid");
        });
        Schema::table("soundblock_tracks", function (Blueprint $objTable) {
            $objTable->unsignedBigInteger("genre_primary_id")->after("track_preview_stop")->index("idx_genre-primary-id");
            $objTable->uuid("genre_primary_uuid")->after("genre_primary_id")->index("idx_genre-primary-uuid");

            $objTable->unsignedBigInteger("genre_secondary_id")->after("genre_primary_uuid")->index("idx_genre-secondary-id");
            $objTable->uuid("genre_secondary_uuid")->after("genre_secondary_id")->index("idx_genre-secondary-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects", function (Blueprint $objTable) {
            $objTable->dropColumn("genre_primary_id");
            $objTable->dropColumn("genre_primary_uuid");
            $objTable->dropColumn("genre_secondary_id");
            $objTable->dropColumn("genre_secondary_uuid");
        });
        Schema::table("soundblock_tracks", function (Blueprint $objTable) {
            $objTable->dropColumn("genre_primary_id");
            $objTable->dropColumn("genre_primary_uuid");
            $objTable->dropColumn("genre_secondary_id");
            $objTable->dropColumn("genre_secondary_uuid");
        });
    }
}
