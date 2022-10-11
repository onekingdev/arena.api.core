<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("log_errors", function (Blueprint $table) {
            $table->bigIncrements("row_id")->index("idx_row-id");
            $table->uuid("row_uuid")->index("idx_row-uuid");

            $table->unsignedBigInteger("user_id")->index("idx_user-id")->nullable();
            $table->uuid("user_uuid")->index("idx_user-uuid")->nullable();

            $table->unsignedBigInteger("log_id")->index("idx_log-id")->nullable();
            $table->uuid("log_uuid")->index("idx_log-uuid")->nullable();

            $table->string("log_url")->nullable();
            $table->string("log_method")->nullable();
            $table->string("log_command")->nullable();
            $table->string("log_instance")->nullable();

            $table->string("exception_class")->nullable();
            $table->string("exception_message");
            $table->json("exception_trace");
            $table->integer("exception_code");

            $table->json("log_request")->nullable();

            $table->boolean("flag_slack_notified")->default(false);
            $table->boolean("flag_email_notified")->default(false);

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->index(BaseModel::IDX_STAMP_CREATED)->nullable();
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->index(BaseModel::IDX_STAMP_UPDATED)->nullable();
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->index(BaseModel::IDX_STAMP_DELETED)->nullable();
            $table->timestamp(BaseModel::DELETED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_DELETED_BY)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("log_errors");
    }
}
