<?php

namespace App\Http\Controllers\Soundblock;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Soundblock\Announcement as AnnouncementService;
use App\Http\Requests\Soundblock\Announcement\Get as GetAnnouncementRequest;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Announcement extends Controller {
    /** @var AnnouncementService */
    private AnnouncementService $announcementService;

    /**
     * Announcement constructor.
     * @param AnnouncementService $announcementService
     */
    public function __construct(AnnouncementService $announcementService) {
        $this->announcementService = $announcementService;
    }

    /**
     * @param GetAnnouncementRequest $objRequest
     * @param string|null $announcement
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function index(GetAnnouncementRequest $objRequest, ?string $announcement = null) {
        if ($announcement) {
            [$objAnnouncements, $availableMetaData] = $this->announcementService->find($announcement);
        } else {
            [$objAnnouncements, $availableMetaData] = $this->announcementService->index($objRequest->except("per_page"), $objRequest->input("per_page", 10));
        }

        return ($this->apiReply($objAnnouncements, "", Response::HTTP_OK, $availableMetaData));
    }

    /**
     * @param Request $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function homepage(Request $objRequest) {
        [$objAnnouncements, $availableMetaData] = $this->announcementService->index(["flag_homepage" => true], $objRequest->input("per_page", 10));

        return ($this->apiReply($objAnnouncements, "", Response::HTTP_OK));
    }
}
