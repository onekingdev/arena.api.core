<?php

namespace App\Jobs\Soundblock;

use Log;
use Util;
use Constant;
use Illuminate\Bus\Queueable;
use App\Repositories\Soundblock\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\{Soundblock\Projects\Project, Users\User};
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class CleanFiles implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Project $objProject;

    protected User $objUser;

    /**
     * Create a new job instance.
     * @param $objProject
     * @param $objUser
     * @return void
     */
    public function __construct(Project $objProject, User $objUser) {
        $this->objProject = $objProject;
        $this->objUser = $objUser;
    }

    /**
     * Execute the job.
     *
     * @param File $fileRepository
     * @return void
     * @throws \Exception
     */
    public function handle(File $fileRepository) {
        $arrNoConfirmedFiles = $fileRepository->findNoConfirmed($this->objUser);

        foreach ($arrNoConfirmedFiles as $objFile) {
            $filePath = Util::project_path($this->objProject) . Constant::Separator . $objFile->file_uuid;
            $bn = Util::deleteFile($filePath);
            Log::info("result", ["file" => $bn]);
            $category = $objFile->file_category;
            $objFile->{$category}->forceDelete();
            $objFile->forceDelete();
        }
    }
}
