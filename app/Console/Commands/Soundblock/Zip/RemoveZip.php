<?php

namespace App\Console\Commands\Soundblock\Zip;

use App\Services\Common\QueueJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RemoveZip extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "soundblock:zip:remove";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Command description";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param QueueJob $jobService
     * @return mixed
     */
    public function handle(QueueJob $jobService) {
        $jobs = $jobService->getJobsForRemove();

        foreach ($jobs as $job) {
            if (isset($job->job_json["path"])) {
                bucket_storage("soundblock")->delete($job->job_json["path"]);
            }

            $job->flag_remove_file = false;
            $job->save();
        }
    }
}
