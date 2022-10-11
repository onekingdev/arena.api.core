<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BaseModel;

class SoundblockServicesNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soundblock_services_notes', function (Blueprint $objTable) {
            $objTable->bigIncrements("note_id");
            $objTable->uuid("note_uuid")->unique("uidx_note-uuid");
            $objTable->unsignedBigInteger("service_id")->index("idx_service-id");
            $objTable->uuid("service_uuid")->index("idx_service-uuid");
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id")->nullable();
            $objTable->uuid("user_uuid")->index("idx_user-uuid")->nullable();
            $objTable->text("service_notes");

            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $objTable->timestamp(BaseModel::CREATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $objTable->timestamp(BaseModel::UPDATED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
            $objTable->timestamp(BaseModel::DELETED_AT)->nullable();
            $objTable->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $objTable->unique("note_id", "uidx_note-id");

            $objTable->unique(["note_id", "service_id"], "uidx_note-id_service-id");
            $objTable->unique(["service_id", "note_id"], "uidx_service-id_note-id");
            $objTable->unique(["note_uuid", "service_uuid"], "uidx_note-uuid_service-uuid");
            $objTable->unique(["service_uuid", "note_uuid"], "uidx_service-uuid_note-uuid");

            $objTable->unique(["user_id", "note_id"], "uidx_user-id_note-id");
            $objTable->unique(["note_id", "user_id"], "uidx_note-id_user-id");
            $objTable->unique(["note_uuid", "user_uuid"], "uidx_note-uuid_user-uuid");
            $objTable->unique(["user_uuid", "note_uuid"], "uidx_user-uuid_note-uuid");

            $objTable->index(["user_id", "service_id"], "idx_user-id_service-id");
            $objTable->index(["service_id", "user_id"], "idx_service-id_user-id");
            $objTable->index(["service_uuid", "user_uuid"], "idx_service-uuid_user-uuid");
            $objTable->index(["user_uuid", "service_uuid"], "idx_user-uuid_service-uuid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soundblock_services_notes');
    }
}
