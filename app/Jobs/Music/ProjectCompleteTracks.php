<?php

namespace App\Jobs\Music;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Music\Project\Project as ProjectModel;

class ProjectCompleteTracks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ProjectModel
     */
    private ProjectModel $objProject;

    /**
     * Create a new job instance.
     *
     * @param ProjectModel $objProject
     */
    public function __construct(ProjectModel $objProject)
    {
        $this->objProject = $objProject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $arrDirs = [];
        $arrPaths = bucket_storage("music")->directories("projects/{$this->objProject->project_uuid}/tracks");

        foreach ($arrPaths as $path) {
            $parts = explode("/", $path);
            $arrDirs[] = end($parts);
        }

        $arrTracks = $this->objProject->tracks->pluck("track_uuid")->toArray();

        if (count(array_intersect($arrDirs, $arrTracks)) == count($arrTracks)) {
            $this->objProject->update([
                "flag_office_complete" => true
            ]);
        }
    }
}
