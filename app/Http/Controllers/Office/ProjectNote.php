<?php

namespace App\Http\Controllers\Office;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\{Soundblock\Project};
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Services\Soundblock\ProjectNote as ProjectNoteService;
use App\Http\Requests\Soundblock\Project\{CreateProjectNote, UploadProjectNote};

/**
 * @group Office Soundblock
 *
 */
class ProjectNote extends Controller {
    /** @var ProjectNoteService */
    private ProjectNoteService $noteService;
    /** @var Project */
    private Project $projectService;

    /**
     * @param ProjectNoteService $noteService
     * @param Project $projectService
     */
    public function __construct(ProjectNoteService $noteService, Project $projectService) {
        $this->noteService = $noteService;
        $this->projectService = $projectService;
    }

    /**
     * @param string $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function show(string $project) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        /** @var \Illuminate\Database\Eloquent\Collection */
        $arrNote = $this->noteService->findByProject($project)->load(["user", "attachments"]);
        $arrNote = $arrNote->each(function ($note) {
            $note->user->append("avatar");
        });

        return ($this->apiReply($arrNote));
    }

    /**
     * @param CreateProjectNote $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function create(CreateProjectNote $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $note = $this->noteService->create($objRequest->all());

        return ($this->apiReply($note));
    }

    /**
     * @param UploadProjectNote $objRequest
     * @return mixed
     * @throws Exception
     */
    public function upload(UploadProjectNote $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($objRequest->project, true);
        $url = $this->noteService->upload($objProject, [$objRequest->file]);

        return ($this->apiReply($url));
    }
}
