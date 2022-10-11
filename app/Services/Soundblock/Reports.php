<?php

namespace App\Services\Soundblock;

use App\Support\Soundblock\Reports as ReportsSupport;
use App\Repositories\Soundblock\Project as ProjectRepository;
use App\Repositories\Soundblock\Platform as PlatformRepository;
use App\Repositories\Soundblock\ReportProject as ReportProjectRepository;
use App\Repositories\Soundblock\ReportProjectUser as ReportProjectUserRepository;

class Reports
{
    /** @var ReportsSupport */
    private ReportsSupport $reportsSupport;
    /** @var ReportProjectRepository */
    private ReportProjectRepository $reportProjectRepo;
    /** @var PlatformRepository */
    private PlatformRepository $platformRepo;
    /** @var ReportProjectUserRepository */
    private ReportProjectUserRepository $reportProjectUserRepo;
    /** @var ProjectRepository */
    private ProjectRepository $projectRepo;

    /**
     * Report constructor.
     * @param ReportsSupport $reportsSupport
     * @param ReportProjectRepository $reportProjectRepo
     * @param PlatformRepository $platformRepo
     * @param ReportProjectUserRepository $reportProjectUserRepo
     * @param ProjectRepository $projectRepo
     */
    public function __construct(ReportsSupport $reportsSupport, ReportProjectRepository $reportProjectRepo,
                                PlatformRepository $platformRepo, ReportProjectUserRepository $reportProjectUserRepo,
                                ProjectRepository $projectRepo){
        $this->projectRepo           = $projectRepo;
        $this->platformRepo          = $platformRepo;
        $this->reportsSupport        = $reportsSupport;
        $this->reportProjectRepo     = $reportProjectRepo;
        $this->reportProjectUserRepo = $reportProjectUserRepo;
    }

    /**
     * @param $file
     * @return bool
     * @throws \Exception
     */
    public function store($file): bool{
        $objPlatform = null;
        [$arrFIleData, $platformName] = $this->reportsSupport->readFile($file);
        $objPlatform = $this->platformRepo->findByName($platformName);

        if (!$objPlatform) {
            throw (new \Exception("Platform is missing in the database.", 400));
        }

        switch ($platformName) {
            case "Anghami":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForAnghami($arrFIleData);
                break;
            case "Apple Music":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForAppleMusic($arrFIleData);
                break;
            case "Boomplay":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForBoomplay($arrFIleData);
                break;
            case "Deezer":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForDeezer($arrFIleData);
                break;
            case "Dubset":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForDubset($arrFIleData);
                break;
            case "Google Play":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForGooglePlay($arrFIleData);
                break;
            case "iHeartRadio":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForiHeart($arrFIleData);
                break;
            case "Pandora":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForPandora($arrFIleData);
                break;
            case "Slacker Radio":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForSlacker($arrFIleData);
                break;
            case "Soundcloud":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForSoundcloud($arrFIleData);
                break;
            case "Spotify":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForSpotify($arrFIleData);
                break;
            case "Uma Music":
                [$insertData, $dateStarts, $dateEnds] = $this->prepareDataForUma($arrFIleData);
                break;
            default:
                throw (new \Exception("Platform not found.", 400));
        }

        $this->reportProjectRepo->store($insertData, $objPlatform, $dateStarts, $dateEnds);
        $this->storeProjectUsersRevenue($dateStarts, $dateEnds);

        return (true);
    }

    /**
     * @param string $dateStarts
     * @param string $dateEnds
     * @return bool
     * @throws \Exception
     */
    public function storeProjectUsersRevenue(string $dateStarts, string $dateEnds): bool{
        $arrProjects = $this->reportProjectRepo->findProjectsByDate($dateStarts, $dateEnds);

        foreach($arrProjects as $projectId) {
            $objProject = $this->projectRepo->find($projectId);
            $objContract = $objProject->contracts()->where("flag_status", "Active")->orderBy("contract_version", "desc")->first();
            $objUsers = $objContract->users;
            $this->reportProjectUserRepo->storeUserRevenueByProjectAndDates($objProject, $dateStarts, $dateEnds, $objUsers);
        }

        return (true);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForAnghami(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("d/m/Y", $fileData[1][1], $fileData[1][2]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[10]][$item[17]]["quantity"] ?? 0;
            $currRevenue = $insertData[$item[10]][$item[17]]["revenue"] ?? 0;
            $insertData[$item[10]][$item[17]]["quantity"] = $currQuantity + $item[16];
            $insertData[$item[10]][$item[17]]["revenue"] = $currRevenue + $item[18];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForAppleMusic(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("m/d/Y", $fileData[1][15]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[4]][$item[19]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[4]][$item[19]]["revenue"] ?? 0;
            $insertData[$item[4]][$item[19]]["quantity"] = $currQuantity + $item[9];
            $insertData[$item[4]][$item[19]]["revenue"]  = $currRevenue + ($item[9] * $item[10]);
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForBoomplay(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("Ymd", $fileData[1][1], $fileData[1][2]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[11]]["USD"]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[11]]["USD"]["revenue"] ?? 0;
            $insertData[$item[11]]["USD"]["quantity"] = $currQuantity + $item[22];
            $insertData[$item[11]]["USD"]["revenue"]  = $currRevenue + $item[24];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForDeezer(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("d-m-Y", $fileData[1][0], $fileData[1][1]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[2]]["USD"]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[2]]["USD"]["revenue"] ?? 0;
            $insertData[$item[2]]["USD"]["quantity"] = $currQuantity + $item[8];
            $insertData[$item[2]]["USD"]["revenue"]  = $currRevenue + $item[9];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForDubset(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("Ymd", $fileData[1][0], $fileData[1][1]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[6]][$item[20]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[6]][$item[20]]["revenue"] ?? 0;
            $insertData[$item[6]][$item[20]]["quantity"] = $currQuantity + intval($item[13]);
            $insertData[$item[6]][$item[20]]["revenue"]  = $currRevenue + $item[19];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForGooglePlay(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("Y-m-d", $fileData[3][1], $fileData[3][2]);
        unset($fileData[0], $fileData[1], $fileData[2]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[5]][$item[23]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[5]][$item[23]]["revenue"] ?? 0;
            $insertData[$item[5]][$item[23]]["quantity"] = $currQuantity + intval($item[21]);
            $insertData[$item[5]][$item[23]]["revenue"]  = $currRevenue + $item[22];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForiHeart(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("m/d/Y", $fileData[1][0], $fileData[1][1]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[11]][$item[17]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[11]][$item[17]]["revenue"] ?? 0;
            $insertData[$item[11]][$item[17]]["quantity"] = $currQuantity + intval($item[12]);
            $insertData[$item[11]][$item[17]]["revenue"]  = $currRevenue + $item[16];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForPandora(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("Y-m-d", $fileData[1][4], $fileData[1][5]);
        unset($fileData[0], $fileData[1], $fileData[2]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[2]][$item[9]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[2]][$item[9]]["revenue"] ?? 0;
            $insertData[$item[2]][$item[9]]["quantity"] = $currQuantity + intval($item[7]);
            $insertData[$item[2]][$item[9]]["revenue"]  = $currRevenue + $item[10];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForSlacker(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("Y-m-d", str_replace('"', '', $fileData[1][0]));
        unset($fileData[0], $fileData[1], $fileData[2]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[2]][$item[12]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[2]][$item[12]]["revenue"] ?? 0;
            $insertData[$item[2]][$item[12]]["quantity"] = $currQuantity + intval($item[9]);
            $insertData[$item[2]][$item[12]]["revenue"]  = $currRevenue + $item[11];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForSoundcloud(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("m-Y", $fileData[1][12]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[10]][$item[16]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[10]][$item[16]]["revenue"] ?? 0;
            $insertData[$item[10]][$item[16]]["quantity"] = $currQuantity + intval($item[14]);
            $insertData[$item[10]][$item[16]]["revenue"]  = $currRevenue + $item[15];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForSpotify(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("Y-m-d", $fileData[1][1], $fileData[1][2]);
        unset($fileData[0], $fileData[1], $fileData[2]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[6]][$item[12]]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[6]][$item[12]]["revenue"] ?? 0;
            $insertData[$item[6]][$item[12]]["quantity"] = $currQuantity + intval($item[11]);
            $insertData[$item[6]][$item[12]]["revenue"]  = $currRevenue + $item[13];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }

    /**
     * @param array $fileData
     * @return array
     */
    private function prepareDataForUma(array $fileData): array{
        $insertData = [];
        [$dateStarts, $dateEnds] = $this->reportsSupport->getDateStartAndEnd("d/m/Y", $fileData[1][1], $fileData[1][2]);
        unset($fileData[0]);

        foreach($fileData as $item){
            $currQuantity = $insertData[$item[9]]["USD"]["quantity"] ?? 0;
            $currRevenue  = $insertData[$item[9]]["USD"]["revenue"] ?? 0;
            $insertData[$item[9]]["USD"]["quantity"] = $currQuantity + intval($item[12]);
            $insertData[$item[9]]["USD"]["revenue"]  = $currRevenue + $item[19];
        }

        return ([$insertData, $dateStarts, $dateEnds]);
    }
}
