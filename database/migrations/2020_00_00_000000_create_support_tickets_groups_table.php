<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets_groups', function (Blueprint $table) {
            $table->bigIncrements('row_id')->index('idx_row-id');
            $table->uuid('row_uuid')->index('idx_row-uuid');

            $table->integer('group_id');
            $table->uuid('group_uuid');

            $table->integer('ticket_id');
            $table->uuid('ticket_uuid');

            $table->boolean('flag_active')->default(true);

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();

            $table->unique('row_id', 'uidx_row-id');
            $table->unique('row_uuid', 'uidx_row-uuid');

            $table->unique(['group_id', 'ticket_id'], 'uidx_group-id_ticket-id');
            $table->unique(['group_uuid', 'ticket_uuid'], 'uidx_group-uuid_ticket-uuid');
            $table->unique(['ticket_id', 'group_id'], 'uidx_ticket-id_group-id');
            $table->unique(['ticket_uuid', 'group_uuid'], 'uidx_ticket-uuid_group-uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets_groups');
    }
}
