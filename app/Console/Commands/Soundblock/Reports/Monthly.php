<?php

namespace App\Console\Commands\Soundblock\Reports;

use App\Contracts\Soundblock\Audit\Diskspace;
use App\Contracts\Soundblock\Audit\Bandwidth;
use App\Contracts\Soundblock\Reports\Bandwidth as BandwidthReport;
use App\Contracts\Soundblock\Reports\DiskSpace as DiskSpaceReportService;
use App\Services\Soundblock\Project;
use Illuminate\Console\Command;

class Monthly extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'soundblock:report:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Bandwidth $objBandwidthService
     * @param BandwidthReport $objBandwidthReportService
     * @param Project $objProjectService
     * @param Diskspace $objDiskSpaceAuditService
     * @param DiskSpaceReportService $objDiskSpaceReportService
     * @return int
     * @throws \Exception
     */
    public function handle(Bandwidth $objBandwidthService, BandwidthReport $objBandwidthReportService, Project $objProjectService,
                           Diskspace $objDiskSpaceAuditService, DiskSpaceReportService $objDiskSpaceReportService): int {
        $objMonth = now()->subMonth();
        $strStartMonth = $objMonth->startOfMonth()->toDateString();
        $strEndMonth = $objMonth->endOfMonth()->toDateString();

        $arrBandwidth = $objBandwidthService->getSumByDaysRange($strStartMonth, $strEndMonth);

        foreach ($arrBandwidth as $objBandwidth) {
            $objProject = $objProjectService->find($objBandwidth->project_uuid);
            $objBandwidthReportService->createMonthly($objProject, $objBandwidth->sum_file_size, $strEndMonth);
        }

        $arrDiskSpace = $objDiskSpaceAuditService->getSumByDateRange($strStartMonth, $strEndMonth);

        foreach ($arrDiskSpace as $objDiskSpace) {
            $objProject = $objProjectService->find($objDiskSpace->project_uuid);
            $objDiskSpaceReportService->createMonthly($objProject, $objDiskSpace->sum_file_size, $strEndMonth);
        }

        return 0;
    }
}
