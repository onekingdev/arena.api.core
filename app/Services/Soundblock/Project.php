<?php

namespace App\Services\Soundblock;

use Util;
use Auth;
use Client;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use App\Helpers\Filesystem\Soundblock;
use League\Flysystem\FileNotFoundException;
use Illuminate\Support\Collection as SupportCollection;
use App\Contracts\Soundblock\{
    Contracts\SmartContracts,
    Data\UpcCodes,
    Artist\Artist
};
use App\Services\{
    Core\Auth\AuthPermission as AuthPermissionService,
    Core\Auth\AuthGroup as AuthGroupService,
    Soundblock\ProjectDraft as ProjectDraftService,
    Soundblock\Team as TeamService,
    Common\Zip
};
use App\Events\Soundblock\CreateProject;
use App\Repositories\{
    Core\Auth\AuthGroup,
    Common\Notification,
    Common\QueueJob as QueueJobRepository,
    Common\Account as AccountRepository,
    Soundblock\Data\ProjectsRoles,
    Soundblock\Data\ProjectsFormats,
    Soundblock\Data\Languages,
    Soundblock\Data\Genres,
    Soundblock\File,
    Soundblock\Project as ProjectRepository,
    Soundblock\Reports\Bandwidth,
    Soundblock\Reports\DiskSpace,
    Soundblock\Team,
    User\UserContactEmail,
    User\User as UserRepository,
    Core\Auth\AuthGroup as AuthGroupRepository,
    Soundblock\ProjectsBandwidth as ProjectsBandwidthRepository
};
use App\Models\{Common\QueueJob,
    Users\User,
    Soundblock\Projects\Project as ProjectModel,
    Soundblock\Accounts\Account
};

class Project {

    const UPC_PREFIX = 802061;
    /** @var ProjectRepository */
    protected ProjectRepository $projectRepo;
    /** @var Zip */
    protected Zip $zipService;
    /** @var AuthGroup */
    protected AuthGroup $groupRepo;
    /** @var AccountRepository */
    protected AccountRepository $accountRepo;
    /** @var File */
    protected $fileRepo;
    /** @var UserContactEmail */
    protected $emailRepo;
    /** @var UserRepository */
    protected UserRepository $userRepo;
    /** @var Team */
    protected Team $teamRepo;
    /** @var QueueJobRepository */
    protected QueueJobRepository $queueJobRepo;
    /** @var Notification */
    protected Notification $notiRepo;
    /** @var TeamService */
    private TeamService $teamService;
    /** @var SmartContracts */
    private SmartContracts $smartContract;
    /** @var ProjectDraft */
    private ProjectDraft $projectDraftService;
    /** @var UpcCodes */
    private UpcCodes $upcService;
    /** @var Artist */
    private Artist $artistService;
    /** @var Bandwidth */
    private Bandwidth $bandwidthRepository;
    /** @var DiskSpace */
    private DiskSpace $diskSpaceRepository;
    /** @var \App\Repositories\Soundblock\Data\ProjectsRoles */
    private ProjectsRoles $projectsRolesRepository;
    /** @var \App\Repositories\Soundblock\Data\ProjectsFormats */
    private ProjectsFormats $projectsFormatsRepository;
    /** @var Languages */
    private Languages $languagesRepo;
    /** @var Genres */
    private Genres $genresRepo;
    /**
     * @var ProjectsBandwidthRepository
     */
    private ProjectsBandwidthRepository $projectsBandwidthRepo;

    /**
     * @param ProjectRepository $projectRepo
     * @param Zip $zipService
     * @param Languages $languagesRepo
     * @param AuthGroup $groupRepo
     * @param AccountRepository $accountRepo
     * @param File $fileRepo
     * @param Team $teamRepo
     * @param UserContactEmail $emailRepo
     * @param UserRepository $userRepo
     * @param QueueJobRepository $queueJobRepo
     * @param Notification $notiRepo
     * @param \App\Services\Soundblock\Team $teamService
     * @param SmartContracts $smartContract
     * @param ProjectDraft $projectDraftService
     * @param UpcCodes $upcService
     * @param Artist $artistService
     * @param Bandwidth $bandwidthRepository
     * @param DiskSpace $diskSpaceRepository
     * @param Genres $genresRepo
     * @param \App\Repositories\Soundblock\Data\ProjectsRoles $projectsRolesRepository
     * @param \App\Repositories\Soundblock\Data\ProjectsFormats $projectsFormatsRepository
     * @param ProjectsBandwidthRepository $projectsBandwidthRepo
     */
    public function __construct(ProjectRepository $projectRepo, Zip $zipService, Languages $languagesRepo,
                                AuthGroup $groupRepo, AccountRepository $accountRepo, File $fileRepo, Team $teamRepo,
                                UserContactEmail $emailRepo, UserRepository $userRepo, QueueJobRepository $queueJobRepo,
                                Notification $notiRepo, TeamService $teamService, SmartContracts $smartContract,
                                ProjectDraftService $projectDraftService, UpcCodes $upcService, Artist $artistService,
                                Bandwidth $bandwidthRepository, DiskSpace $diskSpaceRepository, Genres $genresRepo,
                                ProjectsRoles $projectsRolesRepository, ProjectsFormats $projectsFormatsRepository,
                                ProjectsBandwidthRepository $projectsBandwidthRepo) {
        $this->notiRepo = $notiRepo;
        $this->teamRepo = $teamRepo;
        $this->fileRepo = $fileRepo;
        $this->userRepo = $userRepo;
        $this->groupRepo = $groupRepo;
        $this->emailRepo = $emailRepo;
        $this->zipService = $zipService;
        $this->genresRepo = $genresRepo;
        $this->upcService = $upcService;
        $this->accountRepo = $accountRepo;
        $this->teamService = $teamService;
        $this->projectRepo = $projectRepo;
        $this->queueJobRepo = $queueJobRepo;
        $this->languagesRepo = $languagesRepo;
        $this->smartContract = $smartContract;
        $this->artistService = $artistService;
        $this->projectDraftService = $projectDraftService;
        $this->bandwidthRepository = $bandwidthRepository;
        $this->diskSpaceRepository = $diskSpaceRepository;
        $this->projectsRolesRepository = $projectsRolesRepository;
        $this->projectsFormatsRepository = $projectsFormatsRepository;
        $this->projectsBandwidthRepo = $projectsBandwidthRepo;
    }

    /**
     * @param array $arrData
     * @param int $perPage
     * @param string|null $searchParam
     * @param string|null $account
     * @param array $arrSort
     * @return array
     */
    public function findAll(array $arrData, int $perPage = 10, array $arrSort = []) {
        [$objProjects, $availableMetaData] = $this->projectRepo->findAll($arrData, $perPage, $arrSort);

        return ([$objProjects, $availableMetaData]);
    }

    /**
     * @param mixed $project
     * @param bool $bnFailure
     * @return ProjectModel
     * @throws Exception
     */
    public function find($project, ?bool $bnFailure = true): ?ProjectModel {
        return ($this->projectRepo->find($project, $bnFailure));
    }

    /**
     * @param int $perPage
     * @param User|null $objUser
     * @param string $strSortBy
     * @return Paginator
     * @throws Exception
     */
    public function findAllByUser(int $perPage = 10, ?User $objUser = null, string $strSortBy = "last_updated") {
        if (!$objUser) {
            /** @var User $objUser*/
            $objUser = Auth::user();
        }
        $reqGroupName = "App.Soundblock.Project.%";
        $arrProjectGroup = $this->groupRepo->getLikelyByUser($objUser, $reqGroupName)->pluck("group_name")->toArray();
        // Group Array to UUID array.
        $arrProjectGroup = array_map([Util::class, "uuid"], $arrProjectGroup);
        $arrAccounts = $objUser->accounts()->where("flag_accepted", false)
            ->pluck("soundblock_accounts.account_uuid")->toArray();
        $arrProjects = $this->projectRepo->findAllWhere($arrProjectGroup, "uuid", $perPage, $strSortBy, $arrAccounts);

        $arrProjects->each(function ($project) use ($objUser) {
            $project->account;
            $teamRole = null;

            $project->platforms = $project->deployments->sortBy(function ($deployment) {
                return $deployment->platform->name;
            })->pluck("platform");

            $objTeam = $project->team;

            if (is_object($objTeam)) {
                $objTeamUser = $objTeam->users()->find($objUser->user_id);
                if ($objTeamUser->pivot->role_uuid) {
                    $objRole = $this->projectsRolesRepository->find($objTeamUser->pivot->role_uuid);
                }
                $teamRole = isset($objRole) ? $objRole->data_role : "";
            }

            $project->team_role = $teamRole;
            $project->load("format", "primaryGenre", "secondaryGenre", "language");

            unset(
                $project->deployments,
                $project->team,
                $project->format_uuid,
                $project->genre_primary_uuid,
                $project->genre_secondary_uuid,
                $project->project_language_uuid,
            );
        });

        return ($arrProjects);
    }

    /**
     * @param User $objUser
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllByUserWithAccounts(User $objUser){
        $arrProjectGroup = $this->groupRepo->getLikelyByUser($objUser, "App.Soundblock.Project.%")->pluck("group_name")->toArray();
        $arrProjectUuids = array_map([Util::class, "uuid"], $arrProjectGroup);

        return ($this->accountRepo->getUsersAccountsProjects($objUser, $arrProjectUuids));
    }

    /**
     * @param mixed $deploymentStatus
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function __getAllByDeploymentStatus(...$deploymentStatus) {
        /** @var \Illuminate\Database\Eloquent\Collection projects belong to the user */
        $arrProject = $this->__getAllByUser();
        return $this->projectRepo->__getAllByDeploymentStatus($arrProject->pluck("project_id")
            ->toArray(), $deploymentStatus);
    }

    /**
     * @param User|null $objUser
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function __getAllByUser(?User $objUser = null) {
        if (is_null($objUser)) {
            /** @var User */
            $objUser = Auth::user();
        }
        $reqGroupName = "App.Soundblock.Project.%";
        $arrProjectGroups = $this->groupRepo->getLikelyByUser($objUser, $reqGroupName)->pluck("group_name")->toArray();
        $arrUuids = array_map([Util::class, "uuid"], $arrProjectGroups);

        return ($this->projectRepo->findAllWhere($arrUuids, "uuid"));
    }

    /**
     * @param string $projectId
     * @return mixed
     * @throws Exception
     */
    public function getUsers(string $projectId) {
        $strProjectGroup = sprintf("App.Soundblock.Project.%s", $projectId);
        /** @var AuthGroup $objGroup */
        $objGroup = $this->groupRepo->findByName($strProjectGroup);
        $objUsers = $objGroup->users;
        $objProject = $this->projectRepo->find($projectId);
        $contract = $this->smartContract->findLatest($objProject, false);

        foreach ($objUsers as $key => $objUser) {
            $isContractMember = false;

            if (isset($contract) && $objUser->contracts()->where("soundblock_projects_contracts_users.contract_uuid", $contract->contract_uuid)->first()) {
                $isContractMember = true;
            }

            $objUsers[$key]["contract_member"] = $isContractMember;
        }

        return ($objUsers);
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function autocomplete(string $name) {
        $returnData = [];
        $objProjects = $this->projectRepo->findAllLikeName($name);

        if ($objProjects) {
            foreach ($objProjects as $project) {
                $returnData[] = ["name" => $project->project_title, "project_uuid" => $project->project_uuid];
            }

            return ($returnData);
        }

        return (null);
    }

    public function typeahead(array $arrData) {
        return $this->projectRepo->typeahead($arrData);
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function autocompleteWithAccounts(string $name){
        $returnData = [];
        $objProjects = $this->projectRepo->findAllWithAccountsLikeName($name);

        if ($objProjects) {
            foreach ($objProjects as $project) {
                $returnData[] = ["name" => $project->project_title . " ( " . $project->account->account_name . " )", "project_uuid" => $project->project_uuid];
            }

            return ($returnData);
        }

        return (null);
    }

    public function findByAccountAndUser(Account $objAccount, User $objUser) {
        return $this->projectRepo->findByAccountAndUser($objAccount, $objUser);
    }

    public function getRoles() {
        return $this->projectsRolesRepository->all();
    }

    public function getFormats() {
        return $this->projectsFormatsRepository->all();
    }

    /**
     * @param string $projectUuid
     * @param User $user
     * @return bool
     */
    public function checkUserInProject(string $projectUuid, User $user) {
        $strProjectGroup = sprintf("App.Soundblock.Project.%s", $projectUuid);

        return ($this->groupRepo->checkUserInGroupByName($strProjectGroup, $user));
    }

    /**
     * @param array $arrParams
     * @return ProjectModel
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function create(array $arrParams): ProjectModel {
        $objUser = Auth::user();
        $arrProject = [];

        /** @var Account $account */
        $account = $this->accountRepo->find($arrParams["account"], true);
        $objServiceOwner = $account->user;

        if (!Util::array_keys_exists(["account", "project_title", "project_date"], $arrParams)) {
            throw new Exception("Invalid Parameter.", 417);
        }

        if (intval($arrParams["project_volumes"]) < 1) {
            $arrParams["project_volumes"] = 1;
        }

        $arrProject["account_id"] = $account->account_id;
        $arrProject["account_uuid"] = $account->account_uuid;
        $arrProject["project_title"] = $arrParams["project_title"];
        $arrProject["project_date"] = $arrParams["project_date"];
        $arrProject["project_label"] = $arrParams["project_label"] ?? "";
        $arrProject["project_artist"] = $arrParams["project_artist"] ?? "";
        $arrProject["project_title_release"] = $arrParams["project_title_release"] ?? "";
        $arrProject["project_volumes"] = $arrParams["project_volumes"];
        $arrProject["project_recording_location"] = $arrParams["project_recording_location"] ?? "";
        $arrProject["project_recording_year"] = $arrParams["project_recording_year"] ?? "";
        $arrProject["project_copyright_name"] = $arrParams["project_copyright_name"];
        $arrProject["project_copyright_year"] = $arrParams["project_copyright_year"];
        $arrProject["flag_project_compilation"] = $arrParams["flag_project_compilation"];
        $arrProject["flag_project_explicit"] = $arrParams["flag_project_explicit"];

        if (isset($arrParams["project_type"])) {
            $arrProject["project_type"] = strtoupper($arrParams["project_type"]) == "EP" ? strtoupper($arrParams["project_type"]) : Util::ucfLabel($arrParams["project_type"]);
        }

        if (isset($arrParams["format_id"])) {
            $objProjectFormat = $this->projectsFormatsRepository->findProjectFormat($arrParams["format_id"]);

            if (is_null($objProjectFormat)) {
                throw new \Exception("Invalid Project Type.");
            }

            $arrProject["format_id"] = $objProjectFormat->data_id;
            $arrProject["format_uuid"] = $objProjectFormat->data_uuid;
        }

        if (isset($arrParams["project_upc"]) && strlen($arrParams["project_upc"]) > 0) {
            $objUpc = $this->upcService->find($arrParams["project_upc"]);

            if (is_object($objUpc)) {
                if ($objUpc->flag_assigned === true) {
                    throw new \Exception("Provided UPC Is Using Right Now.");
                }

                $this->upcService->useUpc($objUpc);
            }

            $arrProject["project_upc"] = $arrParams["project_upc"];
        } else {
            $objUpc = $this->upcService->getUnused();
            $arrProject["project_upc"] = $objUpc->data_upc;
            $this->upcService->useUpc($objUpc);
        }

        $objLanguage = $this->languagesRepo->find($arrParams["project_language"]);

        if (is_null($objLanguage)) {
            throw new \Exception("Invalid project language.");
        } else {
            $arrProject["project_language_id"] = $objLanguage->data_id;
            $arrProject["project_language_uuid"] = $objLanguage->data_uuid;
        }

        if (isset($arrParams["genre_primary"])) {
            $objPrimaryGenre = $this->genresRepo->findByUuid($arrParams["genre_primary"], true, false);

            if (is_null($objPrimaryGenre)) {
                throw new \Exception("Genre is not primary.");
            }

            $arrProject["genre_primary_id"] = $objPrimaryGenre->data_id;
            $arrProject["genre_primary_uuid"] = $objPrimaryGenre->data_uuid;
        } else {
            throw new \Exception("Primary genre field is required.");
        }

        if (isset($arrParams["genre_secondary"])) {
            $objSecondaryGenre = $this->genresRepo->findByUuid($arrParams["genre_secondary"], false, true);

            if (is_null($objSecondaryGenre)) {
                throw new \Exception("Genre is not secondary.");
            }

            $arrProject["genre_secondary_id"] = $objSecondaryGenre->data_id;
            $arrProject["genre_secondary_uuid"] = $objSecondaryGenre->data_uuid;
        }

        $objProject = $this->projectRepo->create($arrProject);

        if (isset($arrParams["artists"])) {
            foreach ($arrParams["artists"] as $artist) {
                $objArtist = $this->artistService->find($artist["artist"]);

                if (is_null($objArtist)) {
                    $objArtist = $this->artistService->create($artist["artist"], $account);
                }

                $objProject->artists()->attach($objArtist->artist_id, [
                    "row_uuid" => Util::uuid(),
                    "artist_id" => $objArtist->artist_id,
                    "artist_uuid" => $objArtist->artist_uuid,
                    "project_uuid" => $objProject->project_uuid,
                    "artist_type" => $artist["type"]
                ]);

                $size = $this->zipService->moveArtistAvatar($objArtist);

                if ($size) {
                    $this->projectsBandwidthRepo->store($objProject, $objUser, intval($size), \App\Contracts\Soundblock\Audit\Bandwidth::UPLOAD);
                }
            }
        }

        if (isset($arrParams["artwork"])) {
            $this->zipService->moveArtwork($objProject, $arrParams["artwork"]);
        }

        $objTeam = $this->teamService->create($objProject);

        $objTeam->users()->attach($objUser->user_id, [
            "user_uuid"   => $objUser->user_uuid,
            "team_uuid"   => $objTeam->team_uuid,
            "row_uuid"    => Util::uuid(),
            "user_role"   => "Owner",
            "user_payout" => 0,
        ]);

        $arrProjectUsers = [$objUser];

        if ($objUser->user_uuid !== $objServiceOwner->user_uuid) {
            $objTeam->users()->attach($objServiceOwner->user_id, [
                "user_uuid"   => $objServiceOwner->user_uuid,
                "team_uuid"   => $objTeam->team_uuid,
                "row_uuid"    => Util::uuid(),
                "user_role"   => "Owner",
                "user_payout" => 0,
            ]);

            $arrProjectUsers[] = $objServiceOwner;
        }

        event(new CreateProject($objProject, $arrProjectUsers));

        if (isset($arrParams["project_draft"])) {
            $this->projectDraftService->deleteDraft($arrParams["project_draft"]);
        }

        return ($objProject->load("artist", "format", "artists", "primaryGenre", "secondaryGenre"));
    }

    /**
     * @param ProjectModel $objProject
     * @param UploadedFile $objFile
     * @return ProjectModel
     */
    public function uploadArtwork(ProjectModel $objProject, $objFile) {
        $this->zipService->putArtwork($objProject, $objFile);

        return ($objProject);
    }

    /**
     * @param array $arrParams
     * @return SupportCollection
     * @throws FileNotFoundException
     */
    public function pingExtractingZip(array $arrParams) {
        $objProject = $this->find($arrParams["project"]);

        $zipPath = Soundblock::download_zip_path($objProject->project_uuid);

        if (bucket_storage("soundblock")->exists($zipPath)) {
            $arrFiles = bucket_storage("soundblock")->allFiles($zipPath);
            $arrWhere = [];
            foreach ($arrFiles as $file) {
                $filename = pathinfo($file, PATHINFO_BASENAME);
                array_push($arrWhere, $filename);
            }

            if (count($arrWhere) > 0) {
                $arrObjFiles = $this->fileRepo->findWhere($arrWhere);

                return ($arrObjFiles);
            } else {
                throw new FileNotFoundException($zipPath, 417);
            }
        } else {
            throw new FileNotFoundException($zipPath, 417);
        }
    }

    /**
     * @param array $arrParams
     * @return ProjectModel
     * @throws Exception
     */
    public function addFile(array $arrParams): string {
        $objProject = $this->find($arrParams["project"]);
        $strExtension = $arrParams["files"]->getClientOriginalExtension();

        $arrCollection = [];
        $arrCollection["project_id"] = $objProject->project_id;
        $arrCollection["project_uuid"] = $objProject->project_uuid;
        $uploadedFileName = Util::uploaded_file_path(Util::uuid() . "." . $strExtension);
        $this->zipService->putFile($arrParams["files"], $uploadedFileName);
        // $objQueueJob = $this->extractFiles($uploadedFileName, $arrParams["files"], $objProject);
        return ($uploadedFileName);
    }

    /**
     * @param array $arrParams
     * @return QueueJob
     * @throws Exception
     */
    public function confirm(array $arrParams): QueueJob {
        $arrFiles = $arrParams["files"];
        usort($arrFiles, [ProjectModel::class, "isVideo"]);
        $objProject = $this->find($arrParams["project"]);
        $objQueueJob = $this->extractFiles($arrFiles, $objProject);

        return ($objQueueJob);
    }

    /**
     * @param array $arrFiles
     * @param ProjectModel $objProject
     * @return QueueJob
     * @throws Exception
     */
    protected function extractFiles(array $arrFiles, ProjectModel $objProject): QueueJob {
        $objQueueJob = $this->queueJobRepo->createModel([
            "user_id"   => Auth::id(),
            "user_uuid" => Auth::uuid(),
        ]);
        $objApp = Client::app();

        $arrNotiParams = [
            "app_id"              => $objApp->app_id,
            "app_uuid"            => $objApp->app_uuid,
            "notification_name"   => "Silent Alert",
            "notification_memo"   => "This notification is silent alert",
            "notification_action" => "",
        ];
        $arrUserNotiParams = [
            "notification_state" => "Read",
            "flag_canarchieve"   => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];

        $objNoti = $this->notiRepo->create($arrNotiParams);
        $this->notiRepo->attachUser($objNoti, Auth::user(), $arrUserNotiParams);
//         dispatch(new ExtractProjectJob($objQueueJob, Client::app(), $arrFiles, "Collection Comment", $objProject));

        return ($objQueueJob);
    }

    /**
     * @param ProjectModel $objProject
     * @param array $arrParams
     * @return ProjectModel
     * @throws Exception
     */
    public function update(ProjectModel $objProject, array $arrParams) {
        $arrProject = [];
        $objUpc = null;
        $bnUpdatingUpc = false;
        $strOldUpc = $objProject->project_upc;

        if (isset($arrParams["title"])) {
            $arrProject["project_title"] = $arrParams["title"];
        }

        if (isset($arrParams["format_id"])) {
            $objProjectFormat = $this->projectsFormatsRepository->findProjectFormat($arrParams["format_id"]);

            if (is_null($objProjectFormat)) {
                throw new \Exception("Invalid Project Type.");
            }

            $arrProject["format_id"] = $objProjectFormat->data_id;
            $arrProject["format_uuid"] = $objProjectFormat->data_uuid;
        }

        if (isset($arrParams["label"])) {
            $arrProject["project_label"] = trim($arrParams["label"]);
        }

        if (isset($arrParams["project_artist"])) {
            $arrProject["project_artist"] = trim($arrParams["project_artist"]);
        }

        if (isset($arrParams["date"])) {
            $arrProject["project_date"] = $arrParams["date"];
        }

        if (isset($arrParams["artwork"])) {
            $arrProject["artwork_name"] = $this->zipService->generateRandomCode();

            $artworkPath = Soundblock::project_files_path($objProject);

            $this->zipService->saveAvatar($artworkPath, $arrParams["artwork"], $arrProject["artwork_name"]);
        }

        if (array_key_exists("project_title_release", $arrParams)) {
            $arrProject["project_title_release"] = $arrParams["project_title_release"];
        }

        if (array_key_exists("project_volumes", $arrParams)) {
            $objCollection = $objProject->collections()->latest()->first();

            if (!empty(optional($objCollection)->tracks)) {
                $objTrack = $objCollection->tracks()->where("track_volume_number", ">", $arrParams["project_volumes"])->first();

                if ($objTrack) {
                    throw new \Exception("Project can't have the total volumes less than the highest volume of a track.");
                }
            }

            $arrProject["project_volumes"] = $arrParams["project_volumes"];
        }

        if (array_key_exists("project_recording_location", $arrParams)) {
            $arrProject["project_recording_location"] = $arrParams["project_recording_location"];
        }

        if (array_key_exists("project_recording_year", $arrParams)) {
            $arrProject["project_recording_year"] = $arrParams["project_recording_year"];
        }

        if (isset($arrParams["project_copyright_name"])) {
            $arrProject["project_copyright_name"] = $arrParams["project_copyright_name"];
        }

        if (isset($arrParams["project_copyright_year"])) {
            $arrProject["project_copyright_year"] = $arrParams["project_copyright_year"];
        }

        if (isset($arrParams["flag_project_compilation"])) {
            $arrProject["flag_project_compilation"] = $arrParams["flag_project_compilation"];
        }

        if (isset($arrParams["flag_project_explicit"])) {
            $arrProject["flag_project_explicit"] = $arrParams["flag_project_explicit"];
        }

        if (array_key_exists("artists", $arrParams)) {
            $objProject->artists()->detach();

            if (!empty($arrParams["artists"])) {
                foreach ($arrParams["artists"] as $artist) {
                    $objArtist = $this->artistService->find($artist["artist"]);

                    if (is_null($objArtist)) {
                        $objArtist = $this->artistService->create($artist["artist"], $objProject->account);
                    }

                    $objProject->artists()->attach($objArtist->artist_id, [
                        "row_uuid" => Util::uuid(),
                        "artist_id" => $objArtist->artist_id,
                        "artist_uuid" => $objArtist->artist_uuid,
                        "project_uuid" => $objProject->project_uuid,
                        "artist_type" => $artist["type"]
                    ]);
                }
            }
        }

        if (isset($arrParams["upc"]) && strlen($arrParams["upc"]) > 0 && $objProject->project_upc !== $arrParams["upc"]) {
            $objUpc = $this->upcService->find($arrParams["upc"]);

            if (is_object($objUpc) && $objUpc->flag_assigned === true) {
                throw new \Exception("Provided UPC Is Using Right Now.");
            }

            $arrProject["project_upc"] = $arrParams["upc"];
            $bnUpdatingUpc = true;
        }

        if (isset($arrParams["project_language"])) {
            $objLanguage = $this->languagesRepo->find($arrParams["project_language"]);

            if (is_null($objLanguage)) {
                throw new \Exception("Invalid project language.");
            } else {
                $arrProject["project_language_id"] = $objLanguage->data_id;
                $arrProject["project_language_uuid"] = $objLanguage->data_uuid;
            }
        }

        if (isset($arrParams["genre_primary"])) {
            $objPrimaryGenre = $this->genresRepo->findByUuid($arrParams["genre_primary"], true, false);

            if (is_null($objPrimaryGenre)) {
                throw new \Exception("Genre is not primary.");
            }

            $arrProject["genre_primary_id"] = $objPrimaryGenre->data_id;
            $arrProject["genre_primary_uuid"] = $objPrimaryGenre->data_uuid;
        }

        if (array_key_exists("genre_secondary", $arrParams)) {
            $objSecondaryGenre = $this->genresRepo->findByUuid($arrParams["genre_secondary"], false, true);

            $arrProject["genre_secondary_id"] = optional($objSecondaryGenre)->data_id;
            $arrProject["genre_secondary_uuid"] = optional($objSecondaryGenre)->data_uuid;
        }

        $objProject = $this->projectRepo->update($objProject, $arrProject);

        if ($bnUpdatingUpc) {
            $objOldUpc = $this->upcService->find($strOldUpc);

            if (is_object($objOldUpc)) {
                $this->upcService->freeUpc($objOldUpc);
            }

            if (is_object($objUpc)) {
                $this->upcService->useUpc($objUpc);
            }
        }

        return ($objProject->load("artist", "format", "artists", "primaryGenre", "secondaryGenre"));
    }

    /**
     * @param UploadedFile
     * @return string
     * @throws Exception
     */
    public function uploadArtworkForDraft($uploadedFile) {
        return ($this->zipService->putDraftArtwork($uploadedFile));
    }

    /**
     * @param int $lastIncrementPart
     * @return string
     */
    public function generateUpc(int $lastIncrementPart): string {
        $upc = self::UPC_PREFIX . ++$lastIncrementPart;

        $oddVal = 0;
        $evenVal = 0;

        for ($i = 0; $i < strlen($upc); $i++) {
            if ($i % 2 == 0) {
                $oddVal += intval($upc[$i]);
            } else {
                $evenVal += intval($upc[$i]);
            }
        }

        $oddVal *= 3;

        $sum = $oddVal + $evenVal;
        $checkNum = 10 - ($sum % 10);

        if ($checkNum == 10) {
            $checkNum = 0;
        }

        return $upc . $checkNum;
    }

    public function createJob(string $strName, ?User $user = null, $app = null) {
        return $this->queueJobRepo->createModel([
            "user_id"          => isset($user) ? $user->user_id : null,
            "user_uuid"        => isset($user) ? $user->user_uuid : null,
            "app_id"           => isset($app) ? $app->app_id : null,
            "app_uuid"         => isset($app) ? $app->app_uuid : null,
            "job_type"         => $strName,
            "flag_status"      => "Pending",
            "flag_silentalert" => 1,
        ]);
    }

    public function buildProjectReport(ProjectModel $objProject, string $strDateStart, string $strDateEnd) {
        $arrReport = [];

        $objDateStart = Carbon::parse($strDateStart)->startOfDay();
        $objDateEnd = Carbon::parse($strDateEnd)->startOfDay();

        if ($objDateEnd->gt(Carbon::now()->startOfDay())) {
            $objDateEnd = Carbon::now()->startOfDay();
        }

        $objBandwidthReport = $this->bandwidthRepository->getBandwidthReport($objProject, $strDateStart, $strDateEnd);
        $objDiskspaceReport = $this->diskSpaceRepository->getDiskspaceReport($objProject, $strDateStart, $strDateEnd);

        $arrBandwidthReport = $objBandwidthReport->keyBy("report_date");
        $arrDiskspaceReport = $objDiskspaceReport->keyBy("report_date");

        foreach ($objDateStart->range($objDateEnd, 1, "day") as $objDay) {
            $strDay = $objDay->format("Y-m-d");

            $arrReport[$strDay] = [
                "diskspace" => isset($arrDiskspaceReport[$strDay]) ?
                    floatval(number_format($arrDiskspaceReport[$strDay]->report_value / 1e+6, 2)) : 0,
                "bandwidth" => isset($arrBandwidthReport[$strDay]) ?
                    floatval(number_format($arrBandwidthReport[$strDay]->report_value / 1e+6, 2)) : 0
            ];
        }

        return $arrReport;
    }

    /**
     * @param User $objUser
     * @param string $account
     * @param array $projects
     * @return bool
     * @throws Exception
     */
    public function detachUserFromProjects(User $objUser, string $account, array $projects): bool {
        $authGroupService = resolve(AuthGroupService::class);
        $authPermissionService = resolve(AuthPermissionService::class);
        $authGroupRepo = resolve(AuthGroupRepository::class);
        $objAccount = $this->accountRepo->find($account);
        $boolResult = $this->accountRepo->checkUserAccount($objAccount, $objUser->user_uuid);

        if (!$boolResult) {
            throw new Exception("User hasn't this account.", 400);
        }

        $objProjects = $this->accountRepo->checkAccountsProjects($objAccount, $projects);

        if (count($objProjects) != count($projects)) {
            throw new Exception("Project is not part of account.", 400);
        }

        foreach ($objProjects as $objProject) {
            $objContractUser = $this->projectRepo->checkUserPartOfContract($objProject, $objUser->user_uuid);

            if ($objContractUser) {
                if ($objContractUser->pivot->contract_status == "Pending") {
                    $this->smartContract->rejectContract($this->smartContract->findLatest($objProject, false), $objUser);
                } else {
                    throw new Exception("User is part of '" . $objProject->project_title . "' project contract.", 400);
                }
            }

            $objTeam = $objProject->team;

            $objTeam->users()->detach($objUser->user_id);
            $objGroup = $authGroupRepo->findByProject($objProject);
            $authGroupService->detachUsersFromGroup(collect([$objUser]), $objGroup);
            $authPermissionService->detachUserPermissionByGroup($objGroup, $objUser);
        }

        return (true);
    }
}
