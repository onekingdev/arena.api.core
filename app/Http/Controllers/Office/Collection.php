<?php

namespace App\Http\Controllers\Office;

use Auth;
use Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Soundblock\File;
use App\Http\Controllers\Controller;
use App\Services\Soundblock\Project as ProjectService;
use App\Services\Soundblock\Collection as CollectionService;
use App\Http\Requests\Soundblock\Collection\File\AddTimecodes;
use App\Http\Requests\Office\Project\Collection\GetCollection;

/**
 * @group Office Soundblock
 *
 */
class Collection extends Controller
{
    /** @var CollectionService */
    private CollectionService $colService;
    /** @var ProjectService */
    private ProjectService $projectService;
    /** @var File */
    private File $fileService;

    /**
     * Collection constructor.
     * @param CollectionService $colService
     * @param ProjectService $projectService
     * @param File $fileService
     */
    public function __construct(CollectionService $colService, ProjectService $projectService, File $fileService){
        $this->colService     = $colService;
        $this->fileService    = $fileService;
        $this->projectService = $projectService;
    }

    /**
     * @param string $project
     * @param Request $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function index(string $project, Request $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objCollections = $this->colService->findAllByProject($project, $objRequest->input("per_page", 10), "office");

        return ($this->apiReply($objCollections));
    }

    /**
     * @param GetCollection $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function showCollection(GetCollection $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrResults = $this->colService->getTreeStructure($objRequest->collection);

        return ($this->apiReply($arrResults));
    }

    public function getTimecodes(string $project, string $file) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $objFile = $this->fileService->find($file);

        if (is_null($objFile)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($objFile->file_category !== Constant::MusicCategory) {
            return $this->apiReject(null, "Not A Music File.", Response::HTTP_BAD_REQUEST);
        }

        $arrayTimecodes = $this->fileService->getTimecodes($objFile);

        return $this->apiReply($arrayTimecodes);
    }

    /**
     * @param string $project
     * @param string $file
     * @param AddTimecodes $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function addFileTimecodes(string $project, string $file, AddTimecodes $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $objFile = $this->fileService->find($file);

        if (is_null($objFile)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($objFile->file_category !== Constant::MusicCategory) {
            return $this->apiReject(null, "Not A Music File.", Response::HTTP_BAD_REQUEST);
        }

        $arrStartTime = $objRequest->input("preview_start");
        $arrStopTime =$objRequest->input("preview_stop");

        if (intval($arrStopTime) > intval($objFile->track->track_duration)) {
            return $this->apiReject(null, "Preview Stop Time Can't be Greater Than File Duration.", Response::HTTP_BAD_REQUEST);
        }

        $objFile = $this->fileService->addTimeCodes($objFile, $arrStartTime, $arrStopTime);

        return $this->apiReply($objFile);
    }
}
