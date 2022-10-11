<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Platform as PlatformModel;
use App\Repositories\Soundblock\File as FileRepository;
use App\Models\Soundblock\Reports\Project as ReportProjectModel;

class ReportProject extends BaseRepository {
    /** @var File */
    private File $fileRepo;

    public function __construct(ReportProjectModel $objReportProject, FileRepository $fileRepo) {
        $this->model = $objReportProject;
        $this->fileRepo = $fileRepo;
    }

    /**
     * @param string $dateStarts
     * @param string $dateEnds
     * @return mixed
     */
    public function findProjectsByDate(string $dateStarts, string $dateEnds){
        return ($this->model->where("date_starts", $dateStarts)->where("date_ends", $dateEnds)->groupBy("project_id")->pluck("project_id"));
    }

    /**
     * @param string $projectUuid
     * @param string $dateStarts
     * @param string $dateEnds
     * @return mixed
     */
    public function findProjectsByProjectAndDate(string $projectUuid, string $dateStarts, string $dateEnds){
        return (
            $this->model->where("date_starts", $dateStarts)
                ->where("date_ends", $dateEnds)
                ->where("project_uuid", $projectUuid)
                ->get()
        );
    }

    /**
     * @param array $insertData
     * @param PlatformModel $objPlatform
     * @param string $dateStarts
     * @param string $dateEnds
     * @return bool
     * @throws \Exception
     */
    public function store(array $insertData, PlatformModel $objPlatform, string $dateStarts, string $dateEnds): bool{
        foreach ($insertData as $isrc => $trackMeta) {
            $objFileMusic = $this->fileRepo->findFileByISRC($isrc);

            if (!empty($objFileMusic)) {
                $objCollections = $objFileMusic->collections;
                foreach ($trackMeta as $curr => $track) {
                    $this->create([
                        "row_uuid"        => Util::uuid(),
                        "project_id"      => $objCollections[0]->project_id,
                        "project_uuid"    => $objCollections[0]->project_uuid,
                        "track_id"        => $objFileMusic->file_id,
                        "track_uuid"      => $objFileMusic->file_uuid,
                        "platform_id"     => $objPlatform->platform_id,
                        "platform_uuid"   => $objPlatform->platform_uuid,
                        "date_starts"     => $dateStarts,
                        "date_ends"       => $dateEnds,
                        "report_plays"    => $track["quantity"],
                        "report_revenue"  => $track["revenue"],
                        "report_currency" => $curr,
                    ]);
                }
            }
        }

        return (true);
    }
}
