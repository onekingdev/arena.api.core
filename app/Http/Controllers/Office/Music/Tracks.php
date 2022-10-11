<?php

namespace App\Http\Controllers\Office\Music;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Music\Project\Tracks\Store;
use App\Http\Requests\Music\Project\Tracks\Update;
use App\Http\Requests\Music\Project\Tracks\Upload;
use App\Http\Requests\Music\Project\Tracks\Autocomplete;
use App\Contracts\Music\Projects\Tracks as TracksContract;
use App\Services\Music\Projects\Projects as ProjectsService;

/**
 * @group Office Music
 *
 */
class Tracks extends Controller
{
    /** @var ProjectsService */
    private ProjectsService $projectsService;
    /** @var TracksContract */
    private TracksContract $tracksService;

    /**
     * Tracks constructor.
     * @param ProjectsService $projectsService
     * @param TracksContract $tracksService
     */
    public function __construct(ProjectsService $projectsService, TracksContract $tracksService){
        $this->projectsService = $projectsService;
        $this->tracksService = $tracksService;
    }

    /**
     * @param string $project
     * @param string $track
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function show(string $project, string $track){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objTrack = $this->tracksService->show($track);

        return ($this->apiReply($objTrack, "", 200));
    }

    /**
     * @param string $track
     * @param Autocomplete $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function composersAutocomplete(string $track, Autocomplete $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objComposers = $this->projectsService->tracksComposersAutocomplete($track, $objRequest->input("name"));

        return ($this->apiReply($objComposers, "", 200));
    }

    /**
     * @param string $track
     * @param Autocomplete $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function performersAutocomplete(string $track, Autocomplete $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objComposers = $this->projectsService->tracksPerformersAutocomplete($track, $objRequest->input("name"));

        return ($this->apiReply($objComposers, "", 200));
    }

    /**
     * @param string $project
     * @param Store $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function store(string $project, Store $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectsService->find($project);
        $objTrack = $this->tracksService->store($objProject, $objRequest->all());

        return ($this->apiReply($objTrack, "Track stored successfully.", 200));
    }

    /**
     * @param string $project
     * @param string $track
     * @param Upload $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function uploadTrack(string $project, string $track, Upload $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->tracksService->uploadProjectTrackFile($project, $track, $objRequest->file("file"));

        if ($boolResult) {
            return ($this->apiReply(null, "File uploaded successfully.", 200));
        }

        return ($this->apiReject(null, "Something went wrong.", 400));
    }

    /**
     * @param string $project
     * @param string $track
     * @param Update $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function update(string $project, string $track, Update $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objTrack = $this->tracksService->show($track);

        if ($objTrack->project_uuid != $project) {
            return ($this->apiReject(null, "Project doesn't have this track.", 400));
        }

        $objTrack = $this->tracksService->update(
            $objTrack,
            $objRequest->except(["composers", "features", "performers", "genres", "moods", "styles", "themes"]),
            $objRequest->only(["composers", "features", "performers", "genres", "moods", "styles", "themes"])
        );

        return ($this->apiReply($objTrack, "Track updated successfully.", 200));
    }

    /**
     * @param string $project
     * @param string $track
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function delete(string $project, string $track){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        [$boolResult, $message] = $this->tracksService->delete($project, $track);

        if ($boolResult) {
            return ($this->apiReply(null, $message, 200));
        }

        return ($this->apiReject(null, $message, 400));
    }
}
