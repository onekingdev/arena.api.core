<?php


namespace App\Services\Soundblock;

use Exception;
use App\Repositories\Soundblock\Announcement as AnnouncementRepository;

class Announcement
{
    /** @var AnnouncementRepository */
    private AnnouncementRepository $announcementRepo;

    /**
     * Announcement constructor.
     * @param AnnouncementRepository $announcementRepo
     */
    public function __construct(AnnouncementRepository $announcementRepo){
        $this->announcementRepo = $announcementRepo;
    }

    public function index(array $searchParams, int $perPage){
        [$objAnnouncements, $availableMetaData] = $this->announcementRepo->findAllWhere($searchParams, $perPage);

        return ([$objAnnouncements, $availableMetaData]);
    }

    public function find(string $announcement_uuid){
        return ($this->announcementRepo->find($announcement_uuid));
    }

    /**
     * @param array $announcementData
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $announcementData){
        $insertData = [];

        $insertData["announcement_title"] = $announcementData["announcement_title"];
        $insertData["announcement_message"] = $announcementData["announcement_message"];

        if (isset($announcementData["flag_email"])) {
            $insertData["flag_email"] = $announcementData["flag_email"];
        }

        if (isset($announcementData["flag_homepage"])) {
            $insertData["flag_homepage"] = $announcementData["flag_homepage"];
        }

        if (isset($announcementData["flag_projectspage"])) {
            $insertData["flag_projectspage"] = $announcementData["flag_projectspage"];
        }

        $objAnnouncement = $this->announcementRepo->create($insertData);

        return ($objAnnouncement);
    }

    public function update(string $announcement, array $announcementData){
        $objAnnouncement = $this->find($announcement);

        if (is_null($objAnnouncement)) {
            throw new Exception("Announcement not found.", 400);
        }

        $objAnnouncement->announcement_title   = $announcementData["announcement_title"] ?? $objAnnouncement->announcement_title;
        $objAnnouncement->announcement_message = $announcementData["announcement_message"] ?? $objAnnouncement->announcement_message;
        $objAnnouncement->flag_email           = $announcementData["flag_email"] ?? $objAnnouncement->flag_email;
        $objAnnouncement->flag_homepage        = $announcementData["flag_homepage"] ?? $objAnnouncement->flag_homepage;
        $objAnnouncement->flag_projectspage    = $announcementData["flag_projectspage"] ?? $objAnnouncement->flag_projectspage;
        $objAnnouncement->save();

        return ($objAnnouncement);
    }

    public function delete(string $announcement_uuid){
        $objAnnouncement = $this->find($announcement_uuid);

        if (is_null($objAnnouncement)) {
            throw new Exception("Announcement not found.", 400);
        }

        return ($objAnnouncement->delete());
    }
}
