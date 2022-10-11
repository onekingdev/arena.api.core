<?php

namespace App\Jobs\Zip;

use App\Contracts\Soundblock\Audit\Bandwidth;
use App\Helpers\Filesystem\Soundblock;
use Storage;
use App\Helpers\Builder;
use Illuminate\Bus\Queueable;
use App\Events\Common\PrivateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use App\Models\{Common\QueueJob, Soundblock\Collections\Collection, Users\User};
use App\Services\{Alias, Common\QueueJob as QueueJobService, Common\Zip as ZipService};

class Zip implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var QueueJob $queueJob */
    protected $queueJob;
    /** @var Collection $collection */
    protected $collection;
    /** @var SupportCollection $files */
    protected $files;
    /**
     * @var User
     */
    private User $objUser;
    private bool $flag_office;

    /**
     * Create a new job instance.
     * @param QueueJob $queueJob
     * @param Collection $collection
     * @param User $objUser
     * @param SupportCollection|null $files
     * @param bool $flag_office
     */
    public function __construct(QueueJob $queueJob, Collection $collection, User $objUser, ?SupportCollection $files = null,
                                bool $flag_office = false) {
        $this->queueJob = $queueJob;
        $this->collection = $collection;
        $this->files = $files;
        $this->objUser = $objUser;
        $this->flag_office = $flag_office;
    }

    /**
     * Execute the job.
     * @param ZipService $zipService
     * @param QueueJobService $qjService
     * @param Alias $aliasService
     * @param Bandwidth $bandwidthService
     * @return void
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function handle(ZipService $zipService, QueueJobService $qjService, Alias $aliasService, Bandwidth $bandwidthService) {
        /** @var \Illuminate\Filesystem\FilesystemAdapter $soundblockAdapter*/
        if (env("APP_ENV") == "local") {
            $soundblockAdapter = Storage::disk("local");
        } else {
            $soundblockAdapter = bucket_storage("soundblock");
        }

        echo "Handling time... " . microtime(true) . PHP_EOL;

        $queueJobParams = [
            "queue_id" => is_null($this->job) ? null : $this->job->getJobId(),
            "job_name" => is_null($this->job) ? null : $this->job->payload()["displayName"],
        ];

        $queueJob = $qjService->update($this->queueJob, $queueJobParams);

        if (is_null($this->files) || $this->files->isEmpty()) {
            $zipFilePath = $zipService->zipCollection($this->collection, $this->queueJob->user);
        } else {
            $zipFilePath = $zipService->zipFiles($this->collection, $this->files, $this->queueJob->user);
        }
        $objProject = $this->collection->project;

        if (!$this->flag_office) {
            $bandwidthService->create($objProject, $this->objUser, $soundblockAdapter->getSize($zipFilePath), Bandwidth::DOWNLOAD);
        } else {
            $strArtworkPath = Soundblock::upload_project_artwork_path($objProject);
            $zipService->addFileToExistingZip($zipFilePath, "artwork.png", $strArtworkPath);
        }

        dispatch(new DeleteZipAfterDownload($zipFilePath))->delay(now()->addMinutes(15));

        $zipUrl = $soundblockAdapter->temporaryUrl($zipFilePath, now()->addMinute());
        echo "Zip URL ===> " . $zipUrl . PHP_EOL;

        if ($zipFilePath) {
            $queueJob = $qjService->update($queueJob, [
                "job_json" => [
                    "download" => $zipUrl,
                    "path" => $zipFilePath
                ],
            ]);

            $downloadLink = url("soundblock/project/collection/download/zip", ["jobUuid" => $queueJob->job_uuid]);

            echo "Download URL ===> " . $downloadLink . PHP_EOL;

            $qjService->update($queueJob, $queueJobParams);

            if ($queueJob->flag_silentalert == 0) {
                $alias = $aliasService->primary($queueJob->user);
                $contents = [
                    "notification_name"   => "Hello",
                    "notification_memo"   => "All files zipped successfully.",
                    "notification_action" => Builder::notification_link(["url" => $downloadLink, "link_name" => "Download"]),
                    "message"             => sprintf("Mr %s All files zipped.", $alias->user_alias),
                    "alias"               => $alias->user_alias,
                ];

                $flags = [
                    "notification_state" => "unread",
                    "flag_canarchive"    => true,
                    "flag_candelete"     => true,
                    "flag_email"         => false,
                ];

                event(new PrivateNotification($queueJob->user, $contents, $flags, $queueJob->app));
            }
        }
    }
}
