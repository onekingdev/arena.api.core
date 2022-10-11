<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConnectTwoSoundblockProjectsArtistsTableIntoOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("soundblock_projects_artists_secondary");

        Schema::table("soundblock_projects_artists_primary", function (Blueprint $objTable){
            $objTable->string("artist_type")->after("artist_uuid");
        });

        Schema::rename("soundblock_projects_artists_primary", "soundblock_projects_artists");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create("soundblock_projects_artists_secondary", function (Blueprint $objTable) {
            $objTable->bigIncrements("row_id");
            $objTable->uuid("row_uuid");

            $objTable->unsignedBigInteger("project_id")->index("idx_project-id");
            $objTable->uuid("project_uuid")->index("idx_project-uuid");

            $objTable->unsignedBigInteger("artist_id")->index("idx_artist-id");
            $objTable->uuid("artist_uuid")->index("idx_artist-uuid");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->index(["row_id", "stamp_deleted_at"], "idx_row-id_stamp-deleted-at");
            $objTable->index(["row_uuid", "stamp_deleted_at"], "idx_row-uuid_stamp-deleted-at");

            $objTable->index(["project_id", "stamp_deleted_at"], "idx_project-id_stamp-deleted-at");
            $objTable->index(["project_uuid", "stamp_deleted_at"], "idx_project-uuid_stamp-deleted-at");

            $objTable->index(["artist_id", "stamp_deleted_at"], "idx_artist-id_stamp-deleted-at");
            $objTable->index(["artist_uuid", "stamp_deleted_at"], "idx_artist-uuid_stamp-deleted-at");

            $objTable->unique(["project_id", "artist_id"], "uidx_project-id_artist-id");
            $objTable->unique(["project_uuid", "artist_uuid"], "uidx_project-uuid_artist-uuid");
        });

        Schema::table("soundblock_projects_artists", function (Blueprint $objTable){
            $objTable->dropColumn("artist_type");
        });

        Schema::rename("soundblock_projects_artists", "soundblock_projects_artists_primary");
    }
}
