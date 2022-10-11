<?php

use App\Models\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranscoderJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("mysql-music")->create('transcoder_jobs', function (Blueprint $table) {
            $table->bigIncrements("job_id")->index("idx_job-id")->unique("uidx_job-id");
            $table->uuid("job_uuid")->index("idx_job-uuid")->unique("uidx_job-uuid");

            $table->unsignedBigInteger("project_id")->index("idx_project-id");
            $table->uuid("project_uuid")->index("idx_project-uuid");

            $table->string("aws_job_id")->index("idx_aws-job-id")->unique("uidx_aws-job-id");

            $table->json("job_input");
            $table->json("job_output");

            $table->string("job_status")->index("idx_job-status");

            $table->unsignedBigInteger(BaseModel::STAMP_CREATED)->nullable()->index(BaseModel::STAMP_CREATED);
            $table->timestamp(BaseModel::CREATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_CREATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED)->nullable()->index(BaseModel::STAMP_UPDATED);
            $table->timestamp(BaseModel::UPDATED_AT)->nullable();
            $table->unsignedBigInteger(BaseModel::STAMP_UPDATED_BY)->nullable();

            $table->unsignedBigInteger(BaseModel::STAMP_DELETED)->nullable()->index(BaseModel::STAMP_DELETED);
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
        Schema::connection("mysql-music")->dropIfExists('transcoder_jobs');
    }
}
