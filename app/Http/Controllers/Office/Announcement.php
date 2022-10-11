<?php

namespace App\Http\Controllers\Office;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Common\BaseResource;
use App\Services\Soundblock\Announcement as AnnouncementService;
use App\Http\Requests\{
    Soundblock\Announcement\Get as GetAnnouncementRequest,
    Soundblock\Announcement\Create as CreateAnnouncementRequest,
    Soundblock\Announcement\Update as UpdateAnnouncementRequest
};

/**
 * @group Office Soundblock
 *
 */
class Announcement extends Controller
{
    /** @var AnnouncementService */
    private AnnouncementService $announcementService;

    /**
     * Announcement constructor.
     * @param AnnouncementService $announcementService
     */
    public function __construct(AnnouncementService $announcementService){
        $this->announcementService = $announcementService;
    }

    public function index(GetAnnouncementRequest $objRequest, ?string $announcement = null){
        if ($announcement) {
            $objAnnouncements = $this->announcementService->find($announcement);

            if (is_null($objAnnouncements)) {
                return $this->apiReject(null, "Announcement Not Found.", Response::HTTP_NOT_FOUND);
            }

            return ($this->apiReply(new BaseResource($objAnnouncements)));
        }

        [$objAnnouncements, $availableMetaData] = $this->announcementService->index($objRequest->except("per_page"), $objRequest->input("per_page", 10));

        return ($this->apiReply($objAnnouncements, "", Response::HTTP_OK, $availableMetaData));
    }

    public function store(CreateAnnouncementRequest $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAnnouncement = $this->announcementService->store($objRequest->all());

        return ($this->apiReply($objAnnouncement, "Announcement created successfully.", Response::HTTP_OK));
    }

    public function update(UpdateAnnouncementRequest $objRequest, string $announcement){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAnnouncement = $this->announcementService->update($announcement, $objRequest->all());

        return ($this->apiReply($objAnnouncement, "Announcement created successfully.", Response::HTTP_OK));
    }

    public function delete(string $announcement){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->announcementService->delete($announcement);

        if ($boolResult) {
            return ($this->apiReply(null, "Announcement deleted.", Response::HTTP_OK));
        }

        return ($this->apiReject(null, "Announcement deleted.", Response::HTTP_BAD_REQUEST));
    }
}
