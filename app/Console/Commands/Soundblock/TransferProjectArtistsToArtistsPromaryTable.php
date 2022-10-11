<?php

namespace App\Console\Commands\Soundblock;

use Util;
use Illuminate\Console\Command;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Projects\Artists as ProjectsArtistsModel;

class TransferProjectArtistsToArtistsPromaryTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:artists_from_projects_to_primary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ProjectModel $objProjectModel
     * @param ProjectsArtistsModel $projectsArtistsModel
     * @return int
     */
    public function handle(ProjectModel $objProjectModel, ProjectsArtistsModel $projectsArtistsModel)
    {
        $objProjects = $objProjectModel->whereNotNull("artist_id")->get();

        foreach ($objProjects as $objProject) {
            $projectsArtistsModel->create([
                "row_uuid" => Util::uuid(),
                "project_id" => $objProject->project_id,
                "project_uuid" => $objProject->project_uuid,
                "artist_id" => $objProject->artist_id,
                "artist_uuid" => $objProject->artist_uuid,
                "artist_type" => "primary"
            ]);
        }

        return 0;
    }
}
