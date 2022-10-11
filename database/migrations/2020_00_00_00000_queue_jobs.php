<?php

use App\Models\Common\QueueJob;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QueueJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("queue_jobs");
        Schema::create("queue_jobs", function (Blueprint $objTable) {
            $objTable->bigIncrements("job_id");
            $objTable->uuid("job_uuid")->unique("uidx_job-uuid");
            $objTable->unsignedBigInteger("queue_id")->unique("uidx_queue-id")->nullable();
            $objTable->unsignedBigInteger("user_id")->index("idx_user-id");
            $objTable->uuid("user_uuid")->index("idx_user-uuid");
            $objTable->unsignedBigInteger("app_id")->index("idx_app-id")->nullable();
            $objTable->uuid("app_uuid")->index("idx_app-uuid")->nullable();
            $objTable->string("job_type", 100)->nullable();
            $objTable->string("job_name", 100)->nullable();
            $objTable->string("job_memo", 250)->nullable();
            $objTable->string("job_script", 250)->nullable();
            $objTable->json("job_json")->nullable();
            $objTable->unsignedBigInteger("job_seconds")->nullable();
            $objTable->boolean("flag_silentalert")->index("idx_flag-silentalert")->default(true);
            $objTable->string("flag_status", 10)->index("idx_flag-status")->default("Pending");
            $objTable->boolean("flag_remove_file")->index("idx_flag-remove-file")->default(false);

            $objTable->timestamp(QueueJob::START_AT)->nullable();
            $objTable->float(QueueJob::STAMP_START, 16, 4)->index(QueueJob::IDX_STAMP_START)->nullable();
            $objTable->timestamp(QueueJob::STOP_AT)->nullable();
            $objTable->float(QueueJob::STAMP_STOP, 16, 4)->index(QueueJob::IDX_STAMP_STOP)->nullable();

            $objTable->unique("job_id", "uidx_job-id");

            $objTable->unique(["job_id", "user_id"], "uidx_job-id_user-id");
            $objTable->unique(["user_id", "job_id"], "uidx_user-id_job-id");
            $objTable->unique(["job_uuid", "user_uuid"], "uidx_job-uuid_user-uuid");
            $objTable->unique(["user_uuid", "job_uuid"], "uidx_user-uuid_job-uuid");

            $objTable->unique(["queue_id", "user_id"], "uidx_queue-id_user-id");
            $objTable->unique(["user_id", "queue_id"], "uidx_user-id_queue-id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("queue_jobs");
    }
}
