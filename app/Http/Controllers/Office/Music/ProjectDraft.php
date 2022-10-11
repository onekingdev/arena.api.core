<?php

namespace App\Http\Controllers\Office\Music;

use App\Models\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Music\Projects\Draft;
use Illuminate\Http\{Request, Response};
use App\Jobs\Music\{UnzipDraft, TranscodeMusic};
use App\Http\Requests\Music\Project\Draft\{Create, Publish};

/**
 * @group Office Music
 *
 */
class ProjectDraft extends Controller {
    /** @var Draft */
    private Draft $objDraft;

    /**
     * ProjectDraft constructor.
     * @param Draft $objDraft
     */
    public function __construct(Draft $objDraft) {
        $this->objDraft = $objDraft;
    }

    public function getDrafts(Request $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDrafts = $this->objDraft->getDrafts($objRequest->input("per_page", 10));

        return ($this->apiReply($objDrafts, "", Response::HTTP_OK));
    }

    public function getDraft(string $draft) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDraft = $this->objDraft->findDraft($draft);

        if (is_null($objDraft)) {
            return $this->apiReject("", "Draft Not Found.", Response::HTTP_BAD_REQUEST);
        }

        $objDraft->load("versions");

        return $this->apiReply($objDraft);
    }

    public function saveDraft(Create $objRequest) {
        /** @var User $objUser */
        $objUser = Auth::user();

        if (!is_authorized($objUser, "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objParentDraft = null;

        $objDraft = $this->objDraft->saveDraft($objRequest->except(["file"]), $objUser);

        if ($objRequest->hasFile("file")) {
            $this->objDraft->saveDraftFile($objDraft["draft"], $objDraft["version"], $objRequest->file("file"));

            dispatch(new UnzipDraft($objDraft["version"]));
        }

        return $this->apiReply($objDraft["draft"]);
    }

    public function updateDraft(string $draft, Create $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDraft = $this->objDraft->findDraft($draft);

        if (is_null($objDraft)) {
            return $this->apiReject("", "Draft Not Found.", Response::HTTP_BAD_REQUEST);
        }

        $objUpdatedDraft = $this->objDraft->saveDraftVersion($objDraft, $objRequest->all());

        if ($objRequest->hasFile("file")) {
            $this->objDraft->saveDraftFile($objDraft["draft"], $objDraft["version"], $objRequest->file("file"));

            dispatch(new UnzipDraft($objDraft["version"]));
        }

        return $this->apiReply($objUpdatedDraft);
    }


    public function publishDraft(string $draft, Publish $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDraft = $this->objDraft->findDraft($draft);

        if (is_null($objDraft)) {
            throw new \Exception("Draft Not Found.");
        }

        $objVersion = $this->objDraft->findDraftVersion($objDraft, $objRequest->input("version"));

        if (is_null($objVersion)) {
            throw new \Exception("Draft Version Not Found.");
        }

        $objProject = $this->objDraft->publishDraft($objDraft, $objVersion);

        dispatch(new TranscodeMusic($objProject, $objDraft, $objVersion));

        return $this->apiReply($objProject);
    }

    public function removeDraft(string $draft) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDraft = $this->objDraft->findDraft($draft);

        if (is_null($objDraft)) {
            $this->apiReject(null, "Draft Not Found.", Response::HTTP_NOT_FOUND);
        }

        $this->objDraft->deleteDraft($objDraft);

        return $this->apiReply(null, "Draft Was Successfully Deleted.");
    }
}
