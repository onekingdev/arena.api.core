<?php

namespace App\Http\Controllers\Office\Music;

use Illuminate\Http\Response;
use App\Jobs\Music\UnzipProjectZip;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Music\Project\{Index, Update};
use App\Contracts\Music\Projects\Projects as ProjectsContract;

/**
 * @group Office Music
 *
 */
class Projects extends Controller {
    /** @var ProjectsContract */
    private ProjectsContract $objProjects;

    /**
     * Projects constructor.
     * @param ProjectsContract $objProjects
     */
    public function __construct(ProjectsContract $objProjects) {
        $this->objProjects = $objProjects;
    }

    public function index(Index $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        [$objData, $availableMetaData] = $this->objProjects->findAll($objRequest->input("per_page", 10), $objRequest->except("per_page"));

        return ($this->apiReply($objData, "", Response::HTTP_OK, $availableMetaData));
    }

    public function get(string $project) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->objProjects->getUploadTracksInfo($this->objProjects->find($project, true));

        return $this->apiReply($objProject);
    }

    public function update(string $project, Update $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->objProjects->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $objProject = $this->objProjects->update($objProject, $objRequest->all());

        if ($objRequest->hasFile("file") && $objRequest->has("tracks")) {
            ["tracks" => $arrTracks, "path" => $strPath] = $this->objProjects->saveProjectTrack($objProject,
                $objRequest->file("file"), $objRequest->input("tracks"));
            dispatch(new UnzipProjectZip($objProject, $strPath, $arrTracks));
        }

        return ($this->apiReply($objProject, "Project updated successfully.", 200));
    }

    public function delete(string $project) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->objProjects->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $this->objProjects->deleteProject($objProject);

        return $this->apiReply(null, "Project Was Successfully Deleted.");
    }
}
