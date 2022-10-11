<?php

namespace App\Services\Soundblock;

use Auth;
use Util;
use App\Services\Common\Zip;
use App\Events\Soundblock\ProjectNoteAttach;
use App\Models\Soundblock\{Projects\Project, Projects\ProjectNote as ProjectNoteModel};
use App\Repositories\{
    Soundblock\ProjectNote as ProjectNoteRepository,
    Soundblock\Project as ProjectRepository,
    User\User
};

class ProjectNote {

    protected ProjectNoteRepository $noteRepo;
    protected ProjectRepository $projectRepo;
    protected User $userRepo;
    protected Zip $zipService;

    /**
     * ProjectNoteService constructor.
     * @param ProjectNoteRepository $noteRepo
     * @param ProjectRepository $projectRepo
     * @param User $userRepo
     * @param Zip $zipService
     */
    public function __construct(ProjectNoteRepository $noteRepo, ProjectRepository $projectRepo, User $userRepo,
                                Zip $zipService) {
        $this->noteRepo    = $noteRepo;
        $this->userRepo    = $userRepo;
        $this->zipService  = $zipService;
        $this->projectRepo = $projectRepo;
    }

    /**
     * @param $note
     * @param bool $bnFailure
     * @return mixed
     * @throws \Exception
     */
    public function find($note, bool $bnFailure = true) {
        return ($this->noteRepo->find($note, $bnFailure));
    }

    /**
     * @param $project
     * @return mixed
     * @throws \Exception
     */
    public function findByProject($project) {
        $objProject = $this->projectRepo->find($project, true);

        return ($objProject->notes);
    }

    /**
     * @param array $arrParams
     * @return ProjectNoteModel
     * @throws \Exception
     */
    public function create(array $arrParams): ProjectNoteModel {
        $arrNotes = [];
        $objProject = $this->projectRepo->find($arrParams["project"], true);
        if (isset($arrParams["user"])) {
            $objUser = $this->userRepo->find($arrParams["user"], true);
        } else {
            $objUser = Auth::user();
        }

        $arrNotes["project_id"]    = $objProject->project_id;
        $arrNotes["project_uuid"]  = $objProject->project_uuid;
        $arrNotes["user_id"]       = $objUser->user_id;
        $arrNotes["user_uuid"]     = $objUser->user_uuid;
        $arrNotes["project_notes"] = $arrParams["project_notes"];

        $objNote = $this->noteRepo->create($arrNotes);
        if (isset($arrParams["files"])) {
            $urls = $this->upload($objProject, $arrParams["files"]);
            event(new ProjectNoteAttach($objNote, $urls));
        }

        return ($objNote);
    }

    /**
     * @param Project $objProject
     * @param array $files
     * @return array
     */
    public function upload(Project $objProject, array $files) {
        $urls = [];
        foreach ($files as $file) {
            $notePath = Util::project_note_path($objProject);
            $url = $this->zipService->upload($notePath, $file);
            array_push($urls, $url);
        }

        return ($urls);
    }
}
