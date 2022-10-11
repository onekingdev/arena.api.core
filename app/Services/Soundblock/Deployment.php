<?php

namespace App\Services\Soundblock;

use Util;
use App\Helpers\Filesystem\Soundblock;
use App\Events\Office\UpdateDeployment;
use App\Services\Common\Zip as ZipService;
use App\Events\Soundblock\DeploymentHistory;
use App\Jobs\Soundblock\Ledger\DeploymentLedger;
use App\Events\Soundblock\Deployment as DeploymentMail;
use App\Services\Soundblock\Ledger\DeploymentLedger as DeploymentLedgerService;
use App\Models\{
    Soundblock\Projects\Deployments\Deployment as DeploymentModel,
    Soundblock\Projects\Deployments\DeploymentStatus,
    Soundblock\Projects\Project,
    Soundblock\Collections\Collection as CollectionModel
};
use App\Repositories\{
    Common\Notification,
    Soundblock\Collection,
    Soundblock\Deployment as DeploymentRepository,
    Soundblock\DeploymentStatus as DeploymentStatusRepository,
    Soundblock\Project as ProjectRepository,
    Soundblock\Platform,
    User\User as UserRepository,
    Common\QueueJob as QueueJobRepository
};

class Deployment {

    protected int $PROCESSING = 0;
    protected int $DEPLOY = 1;

    protected Collection $colRepo;
    protected Platform $platformRepo;
    protected Notification $notiRepo;
    protected ZipService $zipService;
    protected UserRepository $userRepo;
    protected ProjectRepository $projectRepo;
    protected QueueJobRepository $queueJobRepo;
    protected DeploymentRepository $deploymentRepo;
    protected DeploymentStatusRepository $statusRepo;

    /**
     * Deployment constructor.
     * @param Collection $colRepo
     * @param Platform $platformRepo
     * @param Notification $notiRepo
     * @param ZipService $zipService
     * @param UserRepository $userRepo
     * @param ProjectRepository $projectRepo
     * @param QueueJobRepository $queueJobRepo
     * @param DeploymentRepository $deploymentRepo
     * @param DeploymentStatusRepository $statusRepo
     */
    public function __construct(DeploymentRepository $deploymentRepo, DeploymentStatusRepository $statusRepo,
                                ProjectRepository $projectRepo, Collection $colRepo, Platform $platformRepo,
                                QueueJobRepository $queueJobRepo, Notification $notiRepo, ZipService $zipService,
                                UserRepository $userRepo) {
        $this->colRepo = $colRepo;
        $this->notiRepo = $notiRepo;
        $this->userRepo = $userRepo;
        $this->zipService = $zipService;
        $this->statusRepo = $statusRepo;
        $this->projectRepo = $projectRepo;
        $this->platformRepo = $platformRepo;
        $this->queueJobRepo = $queueJobRepo;
        $this->deploymentRepo = $deploymentRepo;
    }

    /**
     * @param array $arrParams
     * @param array $arrSort
     * @return mixed
     * @throws \Exception
     */
    public function findAll(array $arrParams, array $arrSort = [], bool $bnGroupByCollection = false) {
        if (array_key_exists("statuses", $arrParams)) {
            $status = $arrParams["statuses"];
        } elseif (array_key_exists("status", $arrParams)) {
            $status = [$arrParams["status"]];
        } else {
            $status = ["Pending"];
        }

        $per_page = $arrParams["per_page"] ?? 10;

        if (isset($arrParams["user_uuids"])) {
            $arrParams["account_uuids"] = [];
            foreach ($arrParams["user_uuids"] as $user_uuid) {
                $objUser = $this->userRepo->find($user_uuid);
                array_push($arrParams["account_uuids"], $objUser->accounts()->pluck("soundblock_accounts.account_uuid"));
            }
            unset($arrParams["user_uuids"]);
        }

        [$objDeployments, $availableMetaData] = $this->deploymentRepo->findAllWithRelationsAndStatus(
            ["project", "project.account", "project.artist", "platform", "collection"],
            $status,
            $per_page,
            $arrParams,
            $arrSort,
            $bnGroupByCollection
        );

        foreach ($objDeployments as $objDeployment) {
            $colLink = "office/soundblock/collection/" . $objDeployment->collection->collection_uuid . "/download";
            $objDeployment->collection->download_link = app_url("office") . $colLink;
            $objDeployment->project->load("format", "primaryGenre", "secondaryGenre", "language");
            unset(
                $objDeployment->project->format_uuid,
                $objDeployment->project->genre_primary_uuid,
                $objDeployment->project->genre_secondary_uuid,
                $objDeployment->project->project_language_uuid,
            );
        }

        return ([$objDeployments, $availableMetaData]);
    }

    /**
     * @param string $project
     * @param int $perPage
     * @param array $option
     *
     * @return mixed
     * @throws \Exception
     */
    public function findAllByProject(string $project, int $perPage = 10, array $option = []) {
        /** @var Project */
        $objProject = $this->projectRepo->find($project, true);

        return ($this->deploymentRepo->findAllByProject($objProject, $option, $perPage));
    }

    /**
     * @param string $project
     * @param int $perPage
     * @return mixed
     * @throws \Exception
     */
    public function findProjectDeployments(string $project, int $perPage) {
        $objDeployments = $this->deploymentRepo->findProjectDeployments($project, $perPage);

        foreach ($objDeployments as $objDeployment) {
            $colLink = "office/soundblock/collection/" . $objDeployment->collection->collection_uuid . "/download";
            $objDeployment->collection->download_link = app_url("office") . $colLink;
        }

        return ($objDeployments);
    }

    /**
     * @param mixed $id
     * @param bool $bnFailure
     * @return DeploymentModel
     * @throws \Exception
     */
    public function find($id, ?bool $bnFailure = true): DeploymentModel {
        return ($this->deploymentRepo->find($id, $bnFailure));
    }

    /**
     * @param Project $project
     * @return DeploymentModel|null
     */
    public function findLatest(Project $project): ?DeploymentModel {
        return ($this->deploymentRepo->findLatest($project));
    }

    /**
     * @param string $deployment
     * @return array
     * @throws \Exception
     */
    public function getDeploymentInfo(string $deployment) {
        $objDeployment = $this->find($deployment);

        $deploymentInfo = [];
        $deploymentInfo["deployment"] = $objDeployment->toArray();
        $deploymentInfo["project"] = $objDeployment->project;

        if (is_object($deploymentInfo["project"])) {
            $deploymentInfo["project"]["account"] = $deploymentInfo["project"]->account;
            $deploymentInfo["project"]["artist"] = $deploymentInfo["project"]->artist;
        }

        $deploymentInfo["platform"] = $objDeployment->platform;
        $deploymentInfo["status"] = $objDeployment->status;
        $deploymentInfo["collection"] = $objDeployment->collection->toArray();
        $deploymentInfo["collection"]["files"] = [];

        if (!empty($objDeployment->metadata)) {
            $deploymentInfo["collection"]["files"] = $objDeployment->metadata["metadata_json"]["files"];
        } else {
            $arrMusics = $objDeployment->collection->tracks()->with("file")->get();

            foreach ($arrMusics as $objMusic) {
                $arrFile = $objMusic->file->toArray();
                $arrFile["track_number"] = $objMusic->track_number;
                $arrFile["track_isrc"] = $objMusic->track_isrc;
                $deploymentInfo["collection"]["files"][] = $arrFile;
            }
        }

        return ($deploymentInfo);
    }

    public function getCollectionDeployments(CollectionModel $objCollection) {
        $deploymentInfo = [];

        $deploymentInfo["collection"] = $objCollection->toArray();
        $deploymentInfo["deployments"] = $objCollection->deployments()->with("platform", "status")->get();
        $deploymentInfo["project"] = $objCollection->project()
            ->with("account", "artist", "artists", "format", "primaryGenre", "secondaryGenre", "language")
            ->first();
        unset(
            $deploymentInfo["project"]->format_uuid,
            $deploymentInfo["project"]->genre_primary_uuid,
            $deploymentInfo["project"]->genre_secondary_uuid,
            $deploymentInfo["project"]->project_language_uuid,
        );

        $arrMusics = $objCollection->tracks()->with("file")->get();

        foreach ($arrMusics as $objMusic) {
            $arrFile = $objMusic->file->toArray();
            $arrFile["track_number"] = $objMusic->track_number;
            $arrFile["track_isrc"] = $objMusic->track_isrc;
            $arrFile["primary_genre"] = $objMusic->primaryGenre->data_genre;
            $arrFile["secondary_genre"] = optional($objMusic->secondaryGenre)->data_genre;
            $arrFile["language"] = optional($objMusic->language)->data_language;
            $arrFile["language_vocals"] = optional($objMusic->languageVocals)->data_language;
            $arrFile["publishers"] = $objMusic->publisher;
            $arrFile["contributors"] = $objMusic->contributors;
            $arrFile["artists"] = $objMusic->artists;

            $deploymentInfo["collection"]["files"][] = $arrFile;
        }

        $newArtistArray = [];
        foreach ($deploymentInfo["project"]["artists"] as $key => $arrArtist) {
            $newArtistArray[$key] = $arrArtist->toArray();
            $arrParsedUrlApple = parse_url($newArtistArray[$key]["url_apple"]);
            $arrUrlApple = explode("/", $arrParsedUrlApple["path"]);
            $newArtistArray[$key]["url_apple"] = end($arrUrlApple);


            $arrParsedUrlApple = parse_url($newArtistArray[$key]["url_spotify"]);
            $newArtistArray[$key]["url_spotify"] = "spotify" . str_replace("/", ":", $arrParsedUrlApple["path"]);

            $arrParsedUrlApple = parse_url($newArtistArray[$key]["url_soundcloud"]);
            $newArtistArray[$key]["url_soundcloud"] = str_replace("/", "", $arrParsedUrlApple["path"]);
        }

        unset($deploymentInfo["project"]["artists"]);
        $deploymentInfo["project"]["artists"] = $newArtistArray;

        $strDownloadLink = "Deployment zip is not ready yet.";
        $objBucket = bucket_storage("office");

        if ($objBucket->exists("public/" . Soundblock::office_deployment_project_zip_path($objCollection))) {
            $strDownloadLink = cloud_url("office") . Soundblock::office_deployment_project_zip_path($objCollection);
        }

        $deploymentInfo["download_link"] = $strDownloadLink;

        return $deploymentInfo;
    }

    /**
     * @param array $arrParams
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function createMultiple(array $arrParams) {
        $deployments = collect();

        foreach ($arrParams["deployments"] as $param) {
            $deployments->push($this->create($this->projectRepo->find($param["project"]), [$param["platform"]]));
        }

        return ($deployments);
    }

    /**
     * @param Project $project
     * @param array $arrPlatforms
     * @param string|null $collectionUuid
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function create(Project $project, array $arrPlatforms, ?string $collectionUuid = null): \Illuminate\Support\Collection {
        $arrPlatformsModels = $this->platformRepo->findMany($arrPlatforms);
        $colDeployments = collect();
        $flagMusic = false;

        /** @var \App\Models\Soundblock\Collections\Collection $objCollection */
        if (is_null($collectionUuid)) {
            $objCollection = $this->colRepo->findLatestByProject($project);
        } else {
            $objCollection = $this->colRepo->find($collectionUuid);
        }

        if (is_null($objCollection)) {
            throw new \Exception("This Project Doesn't Have Any Collection.");
        }

        foreach ($arrPlatformsModels as $objPlatform) {
            if ($objPlatform->flag_music == 1) {
                $flagMusic = true;
                break;
            }
        }

        $objTracksVolumes = $objCollection->tracks->groupBy("track_volume_number");

        if ($objTracksVolumes->count() < $objCollection->project->project_volumes) {
            throw new \Exception("This project doesn't have tracks for each volume.");
        }

        foreach ($arrPlatformsModels as $objPlatform) {
            $arrDeployment = [];

            if (!$this->deploymentRepo->canDeployOnPlatform($objCollection, $objPlatform)) {
                throw new \Exception("Project {$project->project_uuid} is deployed on platform {$objPlatform->name}");
            }

            $arrDeployment["platform_id"] = $objPlatform->platform_id;
            $arrDeployment["platform_uuid"] = $objPlatform->platform_uuid;
            $arrDeployment["collection_id"] = $objCollection->collection_id;
            $arrDeployment["collection_uuid"] = $objCollection->collection_uuid;
            $arrDeployment["project_id"] = $project->project_id;
            $arrDeployment["project_uuid"] = $project->project_uuid;

            $objDeployment = $this->deploymentRepo->createModel($arrDeployment);

            $this->createDeploymentTracks($objDeployment, $objCollection);
            $this->createDeploymentStatus($objDeployment);

            $colDeployments->push($objDeployment->load(["platform", "status"]));

            dispatch(new DeploymentLedger($objDeployment, DeploymentLedgerService::NEW_DEPLOYMENT))->onQueue("ledger");
            event(new DeploymentHistory($objDeployment, "create_deployment"));
        }

        return ($colDeployments);
    }

    /**
     * @param DeploymentModel $objDeployment
     * @param CollectionModel $objCollection
     * @return mixed
     * @throws \Exception
     */
    public function createDeploymentTracks(DeploymentModel $objDeployment, CollectionModel $objCollection){
        $arrData = [];

        if ($objDeployment->platform->flag_music) {
            $objMusicFiles = $objCollection->tracks;

            foreach ($objMusicFiles as $key => $item) {
                if ($item->track_number != $key+1) {
                    $item->track_number = $key+1;
                }

                $arrMeta = $item->file->meta;

                $arrMeta["preview_start"] = $this->prepareMetaTime($arrMeta["preview_start"] ?? "00:00");
                $arrMeta["preview_stop"] = $this->prepareMetaTime($arrMeta["preview_stop"] ?? "00:00");

                $arrData["files"][$key]["file_uuid"] = $item->file_uuid;
                $arrData["files"][$key]["file_name"] = $item->file->file_name;
                $arrData["files"][$key]["file_title"] = $item->file->file_title;
                $arrData["files"][$key]["file_size"] = $item->file->file_size;
                $arrData["files"][$key]["track_number"] = $item->track_number;
                $arrData["files"][$key]["meta"] = $arrMeta;
            }
        }

        $objDeploymentMetadata = $objDeployment->metadata()->create([
            "row_uuid" => Util::uuid(),
            "deployment_uuid" => $objDeployment->deployment_uuid,
            "metadata_json" => $arrData
        ]);

        return ($objDeploymentMetadata);
    }

    /**
     * @param DeploymentModel $objDeployment
     * @return DeploymentStatus
     */
    public function createDeploymentStatus(DeploymentModel $objDeployment) {
        $arrStatus = $this->fillDeploymentStatusFields($objDeployment);

        return ($this->statusRepo->createModel($arrStatus));
    }

    private function fillDeploymentStatusFields(DeploymentModel $objDeployment) {
        $arrStatus = [];

        $arrStatus["deployment_id"] = $objDeployment->deployment_id;
        $arrStatus["deployment_uuid"] = $objDeployment->deployment_uuid;
        $arrStatus["deployment_status"] = $objDeployment->deployment_status;
        $arrStatus["deployment_memo"] = sprintf("The collection (%s) of project (%s) is deployed",
            $objDeployment->collection->collection_uuid, $objDeployment->project->project_uuid);

        return ($arrStatus);
    }

    /**
     * @param DeploymentStatus $objStatus
     * @param DeploymentModel $objDeployment
     * @return mixed
     */
    public function updateDeploymentStatus(DeploymentStatus $objStatus, DeploymentModel $objDeployment) {
        $arrStatus = $this->fillDeploymentStatusFields($objDeployment);

        return ($this->statusRepo->update($objStatus, $arrStatus));
    }

    /**
     * @param DeploymentModel $objDeployment
     * @param array $arrParams
     * @return DeploymentModel
     * @throws \Exception
     */
    public function update(DeploymentModel $objDeployment, array $arrParams): DeploymentModel {
        $flagStatus = false;
        $arrDeployment = [];

        if (isset($arrParams["platform"])) {
            $objPlatform = $this->platformRepo->find($arrParams["platform"], true);
            $arrDeployment["platform_id"] = $objPlatform->platform_id;
            $arrDeployment["platform_uuid"] = $objPlatform->platform_uuid;
        }

        if (isset($arrParams["collection"])) {
            $objCol = $this->colRepo->find($arrParams["collection"], true);
            $objProject = $objCol->project;
            $arrDeployment["project_id"] = $objProject->project_id;
            $arrDeployment["project_uuid"] = $objProject->project_uuid;
            $arrDeployment["collection_id"] = $objCol->collection_id;
            $arrDeployment["collection_uuid"] = $objCol->collection_uuid;
        }

        if (isset($arrParams["deployment_status"])) {
            $flagStatus = true;
            $arrDeployment["deployment_status"] = $arrParams["deployment_status"];
        }

        $objDeployment = $this->deploymentRepo->update($objDeployment, $arrDeployment);
        event(new UpdateDeployment($objDeployment));

        if (isset($arrParams["deployment_status"]) && $arrParams["deployment_status"] == "Pending takedown") {
            event(new DeploymentHistory($objDeployment, "takedown"));
        } elseif (isset($arrParams["deployment_status"]) && $arrParams["deployment_status"] == "Redeploy") {
            event(new DeploymentHistory($objDeployment, "redeploy"));
        } else {
            event(new DeploymentHistory($objDeployment, "update_deployment"));
        }

        if ($flagStatus) {
            event(new DeploymentMail($objDeployment));
        }

        return ($objDeployment);
    }

    private function prepareMetaTime(string $strTime) {
        $arrParsed = explode(":", $strTime);
        $strSeconds = $arrParsed[0] % 60;
        $strMinutes = str_pad(($arrParsed[0] - $strSeconds) / 60, 2, "0", STR_PAD_LEFT);
        $strSeconds = str_pad($strSeconds, 2, "0", STR_PAD_LEFT);

        return  "$strMinutes:$strSeconds";
    }

    public function updateCollectionDeployments(CollectionModel $collection, array $arrParams) {
        if (isset($arrParams["deployment"]) || isset($arrParams["deployments"])) {
            $arrDeployments = isset($arrParams["deployment"]) ? [$arrParams["deployment"]] : $arrParams["deployments"];

            $objDeployments = $collection->deployments()->whereIn("deployment_uuid", $arrDeployments)->get();
        } else {
            $objDeployments = $collection->deployments()->where("deployment_status", "!=", $arrParams["deployment_status"])->get();
        }

        foreach ($objDeployments as $objDeployment) {
            $this->update($objDeployment, ["deployment_status" => $arrParams["deployment_status"] ?? "Pending"]);
        }

        return $objDeployments;
    }
}
