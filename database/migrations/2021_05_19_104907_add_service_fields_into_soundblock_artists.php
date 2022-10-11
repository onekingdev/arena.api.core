<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceFieldsIntoSoundblockArtists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("soundblock_artists", function (Blueprint $objTable){
            $objTable->unsignedBigInteger("service_id")->after("artist_uuid")->index("idx_service-id");
            $objTable->uuid("service_uuid")->after("service_id")->index("idx_service-uuid");

            $objTable->index("artist_id", "idx_artist-id");
            $objTable->index("artist_uuid", "idx_artist-uuid");
            $objTable->index("artist_name", "idx_artist-name");

            $objTable->unique(["artist_id", "service_id"], "uidx_artist-id_service-id");
            $objTable->unique(["artist_uuid", "service_uuid"], "uidx_artist-uuid_service-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("soundblock_artists", function (Blueprint $objTable){
            $objTable->dropColumn("service_id");
            $objTable->dropIndex("idx_service-id");

            $objTable->dropColumn("service_uuid");
            $objTable->dropIndex("idx_service-uuid");

            $objTable->dropIndex("idx_artist-id");
            $objTable->dropIndex("idx_artist-uuid");
            $objTable->dropIndex("idx_artist-name");

            $objTable->dropUnique("uidx_artist-id_service-id");
            $objTable->dropUnique("uidx_artist-uuid_service-uuid");
        });
    }
}
