<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Reports\ProjectUser as ReportProjectUserModel;
use App\Repositories\Soundblock\ReportProject as ReportProjectRepository;

class ReportProjectUser extends BaseRepository {

    /** @var ReportProject */
    private ReportProject $reportProjectRepo;

    /**
     * ReportProjectUser constructor.
     * @param ReportProjectUserModel $objReportProjectUser
     * @param ReportProject $reportProjectRepo
     */
    public function __construct(ReportProjectUserModel $objReportProjectUser, ReportProjectRepository $reportProjectRepo) {
        $this->model = $objReportProjectUser;
        $this->reportProjectRepo = $reportProjectRepo;
    }

    /**
     * @param ProjectModel $objProject
     * @param string $dateStarts
     * @param string $dateEnds
     * @param $objUsers
     * @return bool
     * @throws \Exception
     */
    public function storeUserRevenueByProjectAndDates(ProjectModel $objProject, string $dateStarts, string $dateEnds, $objUsers): bool{
        $objReports = $this->reportProjectRepo->findProjectsByProjectAndDate($objProject->project_uuid, $dateStarts, $dateEnds);
        $objReports = $objReports->groupBy("report_currency");

        foreach ($objUsers as $objUser) {
            foreach ($objReports as $curr => $report) {
                $objModel = $this->model->where("date_starts", $dateStarts)
                    ->where("date_ends", $dateEnds)
                    ->where("project_id", $objProject->project_id)
                    ->where("user_id", $objUser->user_id)
                    ->where("report_currency", $curr)
                    ->first();

                if (is_null($objModel)) {
                    $this->model->create([
                        "row_uuid"        => Util::uuid(),
                        "project_id"      => $objProject->project_id,
                        "project_uuid"    => $objProject->project_uuid,
                        "user_id"         => $objUser->user_id,
                        "user_uuid"       => $objUser->user_uuid,
                        "date_starts"     => $dateStarts,
                        "date_ends"       => $dateEnds,
                        "report_currency" => $curr,
                        "report_revenue"  => ($objUser->pivot->user_payout / 100) * $report->sum("report_revenue")
                    ]);
                } else {
                    $objModel->update([
                        "report_revenue"  => ($objUser->pivot->user_payout / 100) * $report->sum("report_revenue")
                    ]);
                }
            }
        }

        return (true);
    }
}
