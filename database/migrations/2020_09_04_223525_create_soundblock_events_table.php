<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundblockEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("soundblock_events", function (Blueprint $table) {
            $table->bigIncrements("event_id")->index("idx_event-id")->unique("uidx_event-id");
            $table->uuid("event_uuid")->index("idx_event-uuid")->unique("uidx_event-uuid");

            $table->unsignedBigInteger("user_id")->index("idx_user-id");
            $table->uuid("user_uuid")->index("idx_user-uuid");

            $table->nullableMorphs("eventable");

            $table->string("event_memo");
            $table->boolean("flag_processed")->default(false);

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->index(["event_id", "stamp_deleted_at"], "idx_event-id_stamp-deleted-at");
            $table->index(["event_uuid", "stamp_deleted_at"], "idx_event-uuid_stamp-deleted-at");
            $table->index(["user_id", "stamp_deleted_at"], "idx_user-id_stamp-deleted-at");
            $table->index(["user_uuid", "stamp_deleted_at"], "idx_user-uuid_stamp-deleted-at");
            $table->index(["event_id", "user_id", "stamp_deleted_at"], "idx_event-id_user-id_stamp-deleted-at");
            $table->index(["event_uuid", "user_uuid", "stamp_deleted_at"], "idx_event-uuid_user-uuid_stamp-deleted-at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("soundblock_events");
    }
}
