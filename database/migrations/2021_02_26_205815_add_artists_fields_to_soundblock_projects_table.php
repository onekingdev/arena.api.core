<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArtistsFieldsToSoundblockProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_projects", function (Blueprint $table) {
            $table->unsignedBigInteger("artist_id")->after("service_uuid")->nullable()->index("idx_artist-id");
            $table->uuid("artist_uuid")->after("artist_id")->nullable()->index("idx_artist-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_projects", function (Blueprint $table) {
            $table->dropColumn("artist_id");
            $table->dropColumn("artist_uuid");
        });
    }
}
