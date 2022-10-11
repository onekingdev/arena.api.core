<?php

namespace App\Jobs\Zip;

use Exception;
use App\Helpers\Builder;
use Illuminate\Bus\Queueable;
use App\Events\Common\PrivateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use App\Models\{Core\App, Soundblock\Projects\Project, Common\QueueJob};
use App\Services\{Alias, Common\Zip, Common\QueueJob as QueueJobService};

class ExtractProjectMultiple implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var QueueJob */
    public QueueJob $queueJob;
    /** @var array */
    protected array $files;
    /** @var string */
    protected string $strComment;
    /** @var Project */
    protected Project $project;
    /** @var App */
    protected ?App $app = null;

    /**
     * Create a new job instance.
     * @param QueueJob $queueJob
     * @param array $files
     * @param string $strComment
     * @param Project $project
     */
    public function __construct(QueueJob $queueJob, array $files, string $strComment, Project $project) {
        $this->queueJob = $queueJob;
        $this->files = $files;
        $this->strComment = $strComment;
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @param Zip $zipService
     * @param QueueJobService $qjService
     * @param Alias $aliasService
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function handle(Zip $zipService, QueueJobService $qjService, Alias $aliasService) {
        echo "Handling time... " . microtime(true) . PHP_EOL;

        if (!$this->job) {
            throw new Exception("Something went wrong", 417);
        }

        $queueJobParams = [
            "queue_id" => is_null($this->job) ? null : $this->job->getJobId(),
            "job_name" => is_null($this->job) ? null : $this->job->payload()["displayName"],
            "job_json" => ["project" => $this->project->project_uuid],
        ];

        $queueJob = $qjService->update($this->queueJob, $queueJobParams);

        $user = $queueJob->user;

        foreach ($this->files as $arrFile) {
            $project = $zipService->unzipProject($arrFile["fileName"], $arrFile, $this->strComment, $this->project, $user);

            if ($project && $queueJob->flag_silentalert == 0) {
                $alias = $aliasService->primary($user);

                $contents = [
                    "notification_name"   => "Extract Files",
                    "notification_memo"   => "All files are extracted.",
                    "notification_action" => Builder::notification_button("OK"),
                    "message"             => sprintf("Mr %s All files are extracted and registered successfully.", $alias->user_alias),
                    "alias"               => $alias->user_alias,
                ];

                $flags = [
                    "notification_state" => "unread",
                    "flag_canarchive"    => true,
                    "flag_candelete"     => true,
                    "flag_email"         => false,
                ];

                event(new PrivateNotification($user, $contents, $flags, $queueJob->app));
            }
        }
    }
}
