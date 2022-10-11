<?php

namespace App\Services\Soundblock;

use Log;
use Auth;
use Util;
use Client;
use Constant;
use Exception;
use Illuminate\Support\Facades\Bus;
use App\Events\Soundblock\OnHistory;
use App\Helpers\Filesystem\Soundblock;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Illuminate\Filesystem\FilesystemAdapter;
use App\Traits\Soundblock\UpdateCollectionFiles;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\{Collection as EloquentCollection};
use Symfony\Component\{HttpKernel\Exception\BadRequestHttpException};
use App\Contracts\{Core\Sox, Soundblock\Audit\Diskspace, Soundblock\Data\IsrcCodes};
use App\Services\{Common\Zip as ZipService,
    Soundblock\File as FileService,
    Soundblock\Ledger\TrackLedger as TrackLedgerService,
    Soundblock\Project as ProjectService,
    Soundblock\Artist\Artist as ArtistService,
    Soundblock\Ledger\CollectionLedger as CollectionLedgerService};
use wapmorgan\MediaFile\MediaFile;
use App\Jobs\{Soundblock\Ledger\TrackLedger,
    Zip\ExtractProject,
    Zip\Zip,
    Soundblock\Ledger\FileLedger,
    Soundblock\Projects\CopyFiles,
    Soundblock\Ledger\CollectionLedger
};
use App\Repositories\{
    Common\Notification,
    Soundblock\File as FileRepository,
    Common\QueueJob as QueueJobRepository,
    Soundblock\Project as ProjectRepository,
    Soundblock\Directory as DirectoryRepository,
    Soundblock\Collection as CollectionRepository,
    Soundblock\FileHistory as FileHistoryRepository,
    User\User as UserRepository,
    Soundblock\Data\Contributors as ContributorsRepository,
    Soundblock\Data\Genres as GenresRepository,
    Soundblock\Data\Languages as LanguagesRepository,
    Soundblock\ArtistPublisher as ArtistPublisherRepository,
    Soundblock\TrackHistory as TrackHistoryRepository
};
use App\Models\{BaseModel,
    Common\QueueJob,
    Soundblock\Files\File,
    Soundblock\Projects\Project,
    Soundblock\Files\FileHistory,
    Soundblock\Collections\Collection as SoundblockCollection,
    Users\User
};

class Collection {
    use UpdateCollectionFiles;

    const ISRC_PREFIX = "US-AEA-81-";
    const USED_ISRC_INCREMENTS = [10000, 10001, 10002, 10003, 10004, 10005];
    protected CollectionRepository $colRepo;
    protected ProjectRepository $projectRepo;
    protected ZipService $zipService;
    protected FileRepository $fileRepo;
    protected FileHistoryRepository $fileHistoryRepo;
    protected DirectoryRepository $dirRepo;
    protected QueueJobRepository $queueJobRepo;
    protected Notification $notiRepo;
    private ProjectService $projectService;
    private FilesystemAdapter $soundblockAdapter;
    private UserRepository $userRepo;
    private \App\Services\Soundblock\File $fileService;
    /** @var Diskspace */
    private Diskspace $diskspaceAuditService;
    /** @var IsrcCodes */
    private IsrcCodes $isrcServices;
    /** @var \App\Contracts\Core\Sox */
    private Sox $soxService;
    /** @var ContributorsRepository */
    private ContributorsRepository $contributorsRepo;
    /** @var ArtistService */
    private ArtistService $artistService;
    /** @var GenresRepository */
    private GenresRepository $genresRepo;
    /** @var LanguagesRepository */
    private LanguagesRepository $languagesRepo;
    /** @var ArtistPublisherRepository */
    private ArtistPublisherRepository $artistPublisherRepo;
    /** @var TrackHistoryRepository */
    private TrackHistoryRepository $trackHistoryRepo;

    /**
     * Collection constructor.
     * @param CollectionRepository $colRepo
     * @param ProjectRepository $projectRepo
     * @param FileRepository $fileRepo
     * @param FileHistoryRepository $fileHistoryRepo
     * @param DirectoryRepository $dirRepo
     * @param ZipService $zipService
     * @param QueueJobRepository $queueJobRepo
     * @param Notification $notiRepo
     * @param \App\Services\Soundblock\Project $projectService
     * @param UserRepository $userRepo
     * @param \App\Services\Soundblock\File $fileService
     * @param Diskspace $diskspaceAuditService
     * @param IsrcCodes $isrcServices
     * @param Sox $soxService
     * @param ContributorsRepository $contributorsRepo
     * @param ArtistService $artistService
     * @param GenresRepository $genresRepo
     * @param LanguagesRepository $languagesRepo
     * @param ArtistPublisherRepository $artistPublisherRepo
     * @param TrackHistoryRepository $trackHistoryRepo
     */
    public function __construct(CollectionRepository $colRepo, ProjectRepository $projectRepo, FileRepository $fileRepo,
                                FileHistoryRepository $fileHistoryRepo, DirectoryRepository $dirRepo, ZipService $zipService,
                                QueueJobRepository $queueJobRepo, Notification $notiRepo, ProjectService $projectService,
                                UserRepository $userRepo, FileService $fileService, Diskspace $diskspaceAuditService,
                                IsrcCodes $isrcServices, Sox $soxService, ContributorsRepository $contributorsRepo,
                                ArtistService $artistService, GenresRepository $genresRepo, LanguagesRepository $languagesRepo,
                                ArtistPublisherRepository $artistPublisherRepo, TrackHistoryRepository $trackHistoryRepo) {
        $this->colRepo = $colRepo;
        $this->dirRepo = $dirRepo;
        $this->userRepo = $userRepo;
        $this->notiRepo = $notiRepo;
        $this->fileRepo = $fileRepo;
        $this->zipService = $zipService;
        $this->soxService = $soxService;
        $this->genresRepo = $genresRepo;
        $this->projectRepo = $projectRepo;
        $this->fileService = $fileService;
        $this->queueJobRepo = $queueJobRepo;
        $this->isrcServices = $isrcServices;
        $this->artistService = $artistService;
        $this->languagesRepo = $languagesRepo;
        $this->projectService = $projectService;
        $this->fileHistoryRepo = $fileHistoryRepo;
        $this->contributorsRepo = $contributorsRepo;
        $this->trackHistoryRepo = $trackHistoryRepo;
        $this->artistPublisherRepo = $artistPublisherRepo;
        $this->diskspaceAuditService = $diskspaceAuditService;

        if (env("APP_ENV") == "local") {
            $this->soundblockAdapter = Storage::disk("local");
        } else {
            $this->soundblockAdapter = bucket_storage("soundblock");
        }
    }

    /**
     * @param array $a
     * @param array $b
     * @return int
     */
    public static function isVideo(array $a, array $b): int {
        if (isset($a["music"]) && isset($b["music"]))
            return (0);
        return (isset($a["music"]) ? -1 : 1);
    }

    /**
     * @param string $project
     * @param int $perPage
     * @param string $type
     * @param string|null $changedEntity
     * @return LengthAwarePaginator|EloquentCollection
     * @throws Exception
     */
    public function findAllByProject(string $project, int $perPage = 4, string $type = "soundblock", $changedEntity = null) {
        $objProject = $this->projectRepo->find($project, true);

        return ($this->colRepo->findAllByProject($objProject, $type, $perPage, $changedEntity));
    }

    /**
     * @param string $collection
     * @return array
     * @throws Exception
     */
    public function getTreeStructure(string $collection) {
        $objCol = $this->colRepo->find($collection);

        return ($this->colRepo->getTreeStructure($objCol));
    }

    /**
     * @param $id
     * @param bool $bnFaillure
     * @return mixed
     * @throws Exception
     */
    public function find($id, bool $bnFaillure = true) {
        return ($this->colRepo->find($id, $bnFaillure));
    }

    /**
     * @param SoundblockCollection $collection
     * @return EloquentCollection
     */
    public function getOrderedTracks($collection) {
        return ($this->colRepo->getOrderedTracks($collection));
    }

    /**
     * @param string $collection
     * @param string|null $path
     * @return array
     * @throws Exception
     */
    public function getResources(string $collection, ?string $path = null) {
        /** @var SoundblockCollection */
        $objCollection = $this->find($collection, true);
        $objResources = $this->colRepo->getResources($objCollection, $path)->toArray();
        $objResources["files"] = is_array($objResources["files"]) ? $objResources["files"] : $objResources["files"]->toArray();

        if (!empty($objResources["files"])) {
            foreach ($objResources["files"] as $key => $value) {
                $objUserCreate = $this->userRepo->find($value["stamp_created_by"]["uuid"]);
                $objUserUpdate = $this->userRepo->find($value["stamp_updated_by"]["uuid"]);

                $objResources["files"][$key]["stamp_created_by"]["avatar"] = $objUserCreate->avatar;
                $objResources["files"][$key]["stamp_updated_by"]["avatar"] = $objUserUpdate->avatar;
            }
        }

        if (!empty($objResources["directories"])) {
            foreach ($objResources["directories"] as $key => $value) {
                $objUserCreate = $this->userRepo->find($value["stamp_created_by"]["uuid"]);
                $objUserUpdate = $this->userRepo->find($value["stamp_updated_by"]["uuid"]);

                $objResources["directories"][$key]["stamp_created_by"]["avatar"] = $objUserCreate->avatar;
                $objResources["directories"][$key]["stamp_updated_by"]["avatar"] = $objUserUpdate->avatar;
            }
        }

        return ($objResources);
    }

    public function getCollectionTracks(string $collection){
        $objCollection = $this->find($collection, true);
        $objCollection = $this->colRepo->getCollectionOrderedTracks($objCollection)->toArray();

        return ($objCollection);
    }

    /**
     * @param string $file
     * @return array
     * @throws Exception
     */
    public function getFilesHistory(string $file) {
        /** @var File */
        $objFile = $this->fileRepo->find($file, true);
        $latestHistory = $this->fileHistoryRepo->getLatestHistoryByFile($objFile);
        $arrNeedField = ["file_uuid", "file_action", FileHistory::STAMP_CREATED, FileHistory::STAMP_CREATED_BY, FileHistory::STAMP_UPDATED, FileHistory::STAMP_UPDATED_BY];
        $arrHistory = [];
        $arrLastCollections = [];
        array_push($arrHistory, $latestHistory->only($arrNeedField));

        while ($latestHistory->parent) {
            $arrLastCollections[] = $latestHistory->collection_id;
            /** @var FileHistory */
            $latestHistory = $latestHistory->parent()->whereNotIn("collection_id", $arrLastCollections)->latest()
                ->first();
            array_push($arrHistory, $latestHistory->only($arrNeedField));
        }

        return ($arrHistory);
    }

    /**
     * @param string $collection
     *
     * @return EloquentCollection
     * @throws Exception
     */
    public function getCollectionFilesHistory(string $collection) {
        return ($this->colRepo->getCollectionFilesHistory($collection));
    }

    /**
     * @param int $lastIsrc
     * @return string
     */
    public function generateIsrc(int $lastIsrc) {
        $isrc = self::ISRC_PREFIX . str_pad(++$lastIsrc, 5, 0, STR_PAD_LEFT);

        if (array_search($isrc, self::USED_ISRC_INCREMENTS) !== false) {
            return $this->generateIsrc(++$lastIsrc);
        }

        return ($isrc);
    }

    /**
     * @param array $fileUuids
     * @return mixed
     */
    public function getFileCategory(array $fileUuids) {
        return ($this->fileRepo->getFilesCategories($fileUuids));
    }

    /**
     * @param string $collection
     *
     * @return EloquentCollection
     * @throws Exception
     */
    public function getTracks($collection) {
        /** @var SoundblockCollection */
        $objCol = $this->find($collection);

        return ($this->fileRepo->getTracks($objCol));
    }

    /**
     * @param Project $objProject
     * @return null|SoundblockCollection
     */
    public function findLatestByProject(Project $objProject): ?SoundblockCollection {
        return ($this->colRepo->findLatestByProject($objProject));
    }

    /**
     * Minus match from $arrFiles
     * @param EloquentCollection|\Illuminate\Support\Collection $existFiles
     * @param array|EloquentCollection|\Illuminate\Support\Collection $arrFiles
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFilesToAdd($existFiles, $arrFiles) {
        $existFiles = $existFiles->reject(function ($value) use ($arrFiles) {
            $flag = false;
            if (is_array($arrFiles)) {
                foreach ($arrFiles as $item) {
                    if (isset($item["file_uuid"])) {
                        if ($value->file_uuid === $item["file_uuid"])
                            $flag = true;
                    } else if (is_string($item)) {
                        if ($value->file_uuid === $item)
                            $flag = true;
                    } else {
                        throw new Exception("Invalid Parameter");
                    }
                }

            } else if ($arrFiles instanceof EloquentCollection || $arrFiles instanceof \Illuminate\Support\Collection) {
                foreach ($arrFiles as $item) {
                    if ($value->file_uuid === $item->file_uuid)
                        $flag = true;
                }
            } else {
                throw new Exception("Invalid Parameter");
            }
            return $flag;
        });

        return ($existFiles);
    }

    /**
     * Minus match from $arrDirs
     * @param EloquentCollection $arrExistDirs .
     * @param array/EloquentCollection $arrDirs
     * @return EloquentCollection
     * @throws Exception
     */
    public function getDirsToAdd(EloquentCollection $arrExistDirs, $arrDirs): EloquentCollection {
        if (!$arrExistDirs instanceof EloquentCollection)
            throw new Exception();

        $arrExistDirs = $arrExistDirs->reject(function ($value) use ($arrDirs) {
            $flag = false;
            if (is_array($arrDirs)) {
                foreach ($arrDirs as $item) {
                    if (isset($item["directory_uuid"])) {
                        if ($value->directory_uuid === $item["directory_uuid"])
                            $flag = true;
                    } else if (is_string($item)) {
                        if ($value->directory_uuid === $item)
                            $flag = true;
                    } else {
                        throw new Exception();
                    }
                }

            } else if ($arrDirs instanceof EloquentCollection) {
                foreach ($arrDirs as $item) {
                    if ($value->directory_uuid === $item->directory_uuid)
                        $flag = true;
                }
            } else {
                throw new Exception();
            }

            return $flag;
        });
        return $arrExistDirs;
    }

    /**
     * @param Project $objProject
     * @param string $strCollectionComment
     * @param array $arrFiles
     * @return QueueJob
     * @throws Exception
     */
    public function processFilesJob(Project $objProject, string $strCollectionComment, array $arrFiles): QueueJob {
        $queueJob = $this->createQueueJobAndSilentAlert();
        dispatch(new CopyFiles($queueJob, $objProject, $strCollectionComment, $arrFiles));

        return $queueJob;
    }

    /**
     * @param array $arrParams
     * @return array
     * @throws Exception
     */
    public function uploadFile(array $arrParams): array {
        /** @var string $ext */
        $ext = $arrParams["file"]->getClientOriginalExtension();

        if (Util::lowerLabel($ext) == "zip") {
            $fileName = sprintf("%s.zip", Util::uuid());
            $uploadedFileName = $this->zipService->putFile($arrParams["file"], $fileName, Soundblock::upload_path());
        } else {
            $fileName = sprintf("%s.%s", Util::uuid(), $ext);
            $uploadedFileName = $this->zipService->putFile($arrParams["file"], $fileName, Soundblock::upload_path());
        }

        return ($uploadedFileName);
    }

    /**
     * Create a new Collection
     * @param Project $objProject
     * @param array $arrParams
     * @return SoundblockCollection
     * @property
     * collection_comment
     * project_uuid
     */
    public function create(Project $objProject, array $arrParams, ?User $objCreatedBy = null): SoundblockCollection {
        $arrCollection = [];

        $arrCollection["project_id"] = $objProject->project_id;
        $arrCollection["project_uuid"] = $objProject->project_uuid;
        $arrCollection["collection_comment"] = $arrParams["collection_comment"];

        if (is_object($objCreatedBy)) {
            $arrCollection[BaseModel::STAMP_CREATED_BY] = $objCreatedBy->user_id;
            $arrCollection[BaseModel::STAMP_UPDATED_BY] = $objCreatedBy->user_id;
        }

        return ($this->colRepo->create($arrCollection));
    }

    /**
     * @param SoundblockCollection $objCollection
     * @param array $arrFileInfo
     * @param User|null $objUser
     * @return SoundblockCollection
     * @throws \Throwable
     */
    public function addFiles(SoundblockCollection $objCollection, array $arrFileInfo, ?User $objUser = null) {
        try {
            \DB::beginTransaction();

            $arrHistory = [];
            $objProject = $objCollection->project;
            $strProjectPath = Soundblock::project_files_path($objProject);

            $arrFile = $this->getFileParameters($objCollection, $arrFileInfo, $strProjectPath, Soundblock::upload_path($arrFileInfo["file_name"]));

            if ($arrFile["file_category"] === Constant::MusicCategory) {
                $objCollection->flag_changed_music = true;
            } else if ($arrFile["file_category"] === Constant::VideoCategory) {
                $objCollection->flag_changed_video = true;
            } else if ($arrFile["file_category"] === Constant::MerchCategory) {
                $objCollection->flag_changed_merchandising = true;
            } else {
                $objCollection->flag_changed_other = true;
            }

            $objCollection->save();

            if (!empty($arrFile["file_path"])) {
                $objDirectory = $objCollection->directories()->where("directory_sortby", $arrFile["file_path"])
                                              ->first();
                $arrFile["directory_id"] = $objDirectory ? $objDirectory->directory_id : null;
                $arrFile["directory_uuid"] = $objDirectory ? $objDirectory->directory_uuid : null;
            }

            $objFile = $this->fileRepo->createInCollection($arrFile, $objCollection, $objUser);

            $this->diskspaceAuditService->save($objProject, $arrFile["file_size"]);

            if ($objFile->file_category == "music") {
                if ($arrFile["track_duration"] <= 30) {
                    $arrCodes = [0, $arrFile["track_duration"]];
                } else if ($arrFile["track_duration"] >= 60) {
                    $arrCodes = [30, 60];
                } else {
                    $arrCodes = [$arrFile["track_duration"] - 30, $arrFile["track_duration"]];
                }

                $this->fileService->addTimeCodes($objFile, ...$arrCodes);
            }

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        if ($objFile->file_category === Constant::MusicCategory) {
            $objTrack = $objFile->track;

            if (is_object($objTrack)) {
                $objIsrc = $this->isrcServices->getUnused();

                $objTrack->track_isrc = $objIsrc->data_isrc;
                $objTrack->save();

                $this->isrcServices->useIsrc($objIsrc);
            }

            $arrHistory["track_isrc"] = $objTrack->track_isrc;
            $arrHistory["preview_start"] = $objTrack->preview_start;
            $arrHistory["preview_stop"] = $objTrack->preview_stop;

            foreach ($arrHistory as $column => $value) {
                $this->trackHistoryRepo->create([
                    "track_id" => $objTrack->track_id,
                    "track_uuid" => $objTrack->track_uuid,
                    "field_name" => $column,
                    "old_value" => null,
                    "new_value" => $value,
                ]);
            }
        }

        return ($objFile);
    }

    public function createNewCollection(Project $objProject, string $strComment, ?User $objUser = null) {
        $objLatestCol = $this->colRepo->findLatestByProject($objProject);

        $arrCollection = [
            "project_id"         => $objProject->project_id,
            "project_uuid"       => $objProject->project_uuid,
            "collection_comment" => $strComment,
        ];

        $objNew = $this->create($objProject, $arrCollection, $objUser);


        if ($objLatestCol) {
            $objNew = $this->colRepo->attachResources($objNew, $objLatestCol, null, null, $objUser);
        }

        return $objNew;
    }

    /**
     * @param array $arrParams
     * @return QueueJob
     * @throws Exception
     */
    public function confirm(array $arrParams): QueueJob {
        $arrZip = $arrParams["file"];
        $arrFiles = $arrZip["zip_content"];

        usort($arrFiles, [Collection::class, "isVideo"]);
        $objProject = $this->projectRepo->find($arrParams["project"], true);
        $queueJob = $this->createQueueJobAndSilentAlert();
        $this->extractFiles($queueJob, $arrZip["file_name"], $arrFiles, $arrParams["collection_comment"], $objProject);

        return ($queueJob);
    }

    /**
     * @param array $arrParams
     * @return SoundblockCollection
     * @throws FileNotFoundException
     */
    public function editFile(array $arrParams): SoundblockCollection {
        $arrJobs = [];

        try {
            \DB::beginTransaction();

            $objProject = $this->projectRepo->find($arrParams["project"], true);
            $objCol = $this->colRepo->findLatestByProject($objProject);

            if (!$objCol) {
                throw new BadRequestHttpException("Project({$arrParams["project"]}) has n't any collection", null, 400);
            }

            $objNew = $this->create($objProject, $arrParams);
            $curArrFiles = $objCol->files;
            $arrFiles = $arrParams["files"];

            $objNew = $this->colRepo->attachResources($objNew, $objCol, null, $curArrFiles);
            $prjPath = Soundblock::project_files_path($objProject);
            $arrHistoryFiles = collect();
            $arrChanges = [];

            foreach ($arrFiles as $itemFile) {
                $objParentFile = $this->fileRepo->find($itemFile["file_uuid"], true);
                $objUpdated = clone $objParentFile;
                $arrChanges[$itemFile["file_uuid"]]["File title"] = [
                    "Previous value" => $objUpdated->file_title,
                    "Changed to" => $itemFile["file_title"]
                ];
                $objUpdated->file_title = $itemFile["file_title"];
                $objUpdated->save();

                if ($objParentFile->file_category == "music") {
                    [$objTrack, $arrChanges, $arrHistory] = $this->updateTrackFileData($objUpdated->track, $itemFile, $objNew, $arrChanges);
                }

                $arrHistoryFiles->push([
                    "parent" => $objParentFile,
                    "new"    => $objUpdated,
                ]);

                $arrJobs[] = new FileLedger($objUpdated, $prjPath . $objUpdated->file_uuid);

                $objUpdated->modified();
            }

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        event(new OnHistory($objNew, "Modified", $arrHistoryFiles));

        foreach ($arrHistoryFiles as $arrHistory) {
            $arrJobs[] = new FileLedger($arrHistory["parent"], Soundblock::project_file_path($objProject, $arrHistory["parent"]));
        }

        $arrJobs[] = new CollectionLedger($objNew, CollectionLedgerService::CREATE_EVENT, ["changes" => $arrChanges]);

        Bus::chain($arrJobs)->onQueue("ledger")->dispatch();

        return ($objNew);
    }

    public function updateTrackMeta($objTrack, array $arrTrackMeta, int $user_id){
        $objProject = $this->projectRepo->find($arrTrackMeta["project"], true);
        $objCollection = $this->colRepo->findLatestByProject($objProject);

        [$objTrack, $arrChanges, $arrHistory] = $this->updateTrackFileData($objTrack, $arrTrackMeta, $objCollection, []);

        if (isset($arrTrackMeta["file_title"]) && ($objTrack->file->file_title != $arrTrackMeta["file_title"])) {
            $objFile = $objTrack->file;
            $prjPath = Soundblock::project_files_path($objProject);
            $strOldTitle = $objFile->file_title;
            $objFile->file_title = $arrTrackMeta["file_title"];
            $objFile->save();
            $objFile->refresh();

            $arrChanges["Track title"] = [
                "Previous value" => $strOldTitle,
                "Changed to" => $objFile->file_title
            ];
            $arrHistory["file_title"] = [
                "old" => $strOldTitle,
                "new" => $objFile->file_title
            ];

            dispatch(new FileLedger($objFile, $prjPath . $objFile->file_uuid))->onQueue("ledger");
        }

        if (array_key_exists("artists", $arrTrackMeta)) {
            $oldArtists = $objTrack->artists;
            $objTrack->artists()->detach();

            if (!empty($arrTrackMeta["artists"])) {
                foreach ($arrTrackMeta["artists"] as $arrArtist) {
                    $objArtist = $this->artistService->findByUuid($arrArtist["artist"]);

                    if (!is_null($objArtist)) {
                        $objTrack->artists()->attach($objArtist->artist_id, [
                            "row_uuid" => Util::uuid(),
                            "file_id" => $objTrack->file_id,
                            "file_uuid" => $objTrack->file_uuid,
                            "track_uuid" => $objTrack->track_uuid,
                            "artist_uuid" => $objArtist->artist_uuid,
                            "artist_type" => $arrArtist["type"],
                            BaseModel::STAMP_CREATED    => Util::current_time(),
                            BaseModel::STAMP_CREATED_BY => $user_id,
                            BaseModel::STAMP_UPDATED    => Util::current_time(),
                            BaseModel::STAMP_UPDATED_BY => $user_id,
                        ]);
                    }
                }
            }

            $objTrack->refresh();

            if ($oldArtists->toArray() != $objTrack->artists->toArray()) {
                $arrChanges["Track artists"] = [
                    "Previous value" => json_encode($oldArtists),
                    "Changed to" => json_encode($objTrack->artists)
                ];
                $arrHistory["artists"] = [
                    "old" => json_encode($oldArtists),
                    "new" => json_encode($objTrack->artists)
                ];
            }
        }

        if (array_key_exists("contributors", $arrTrackMeta)) {
            $oldContributors = $objTrack->contributors;
            $objTrack->contributors()->detach();

            if (!empty($arrTrackMeta["contributors"])) {
                foreach ($arrTrackMeta["contributors"] as $arrContributor) {
                    $objContributor = $this->contributorsRepo->find($arrContributor["type"]);

                    if (!is_null($objContributor)) {
                        $objTrack->contributors()->attach($objContributor->data_id, [
                            "row_uuid" => Util::uuid(),
                            "file_id" => $objTrack->file_id,
                            "file_uuid" => $objTrack->file_uuid,
                            "track_uuid" => $objTrack->track_uuid,
                            "contributor_uuid" => $objContributor->data_uuid,
                            "contributor_name" => $arrContributor["contributor"],
                            BaseModel::STAMP_CREATED => Util::current_time(),
                            BaseModel::STAMP_CREATED_BY => $user_id,
                            BaseModel::STAMP_UPDATED => Util::current_time(),
                            BaseModel::STAMP_UPDATED_BY => $user_id,
                        ]);
                    }
                }
            }

            $objTrack->refresh();

            if ($oldContributors->toArray() != $objTrack->contributors->toArray()) {
                $arrChanges["Track contributors"] = [
                    "Previous value" => json_encode($oldContributors),
                    "Changed to" => json_encode($objTrack->contributors)
                ];
                $arrHistory["contributors"] = [
                    "old" => json_encode($oldContributors),
                    "new" => json_encode($objTrack->contributors)
                ];
            }
        }

        if (array_key_exists("publishers", $arrTrackMeta)) {
            $oldPublishers = $objTrack->publisher;
            $objTrack->publisher()->detach();

            if (!empty($arrTrackMeta["publishers"])) {
                foreach ($arrTrackMeta["publishers"] as $arrPublisher) {
                    $objArtistPublisher = $this->artistPublisherRepo->find($arrPublisher["publisher"]);

                    if (!is_null($objArtistPublisher)) {
                        $objTrack->publisher()->attach($objArtistPublisher->publisher_id, [
                            "row_uuid" => Util::uuid(),
                            "file_id" => $objTrack->file_id,
                            "file_uuid" => $objTrack->file_uuid,
                            "track_uuid" => $objTrack->track_uuid,
                            "publisher_uuid" => $objArtistPublisher->publisher_uuid,
                            BaseModel::STAMP_CREATED => Util::current_time(),
                            BaseModel::STAMP_CREATED_BY => $user_id,
                            BaseModel::STAMP_UPDATED => Util::current_time(),
                            BaseModel::STAMP_UPDATED_BY => $user_id,
                        ]);
                    }
                }
            }

            $objTrack->refresh();

            if ($oldPublishers->toArray() != $objTrack->publisher->toArray()) {
                $arrChanges["Track publishers"] = [
                    "Previous value" => json_encode($oldPublishers),
                    "Changed to" => json_encode($objTrack->publisher)
                ];
                $arrHistory["publishers"] = [
                    "old" => json_encode($oldPublishers),
                    "new" => json_encode($objTrack->publisher)
                ];
            }
        }

        if (!empty($arrHistory)) {
            foreach ($arrHistory as $field_name => $arrItem) {
                $this->trackHistoryRepo->create([
                    "track_id" => $objTrack->track_id,
                    "track_uuid" => $objTrack->track_uuid,
                    "field_name" => $field_name,
                    "old_value" => $arrItem["old"],
                    "new_value" => $arrItem["new"],
                ]);
            }

            dispatch(new TrackLedger($objTrack, TrackLedgerService::UPDATE_EVENT, $arrChanges))->onQueue("ledger");
        }

        return ($objTrack);
    }

    /**
     * @param array $arrParams
     * @return SoundblockCollection
     * @throws Exception
     */
    public function organizeMusics(array $arrParams): SoundblockCollection {
        $arrJobs = [];
        $changes = [];

        try {
            \DB::beginTransaction();

            $objCol = $this->find($arrParams["collection"]);
            $organizeMusics = $arrParams["files"];
            $objGroupedTracks = $objCol->tracks->groupBy("track_volume_number");

            if (count($organizeMusics) != $objGroupedTracks[$arrParams["volume_number"]]->count()) {
                throw new Exception("This track cannot be moved in that direction without first changing the volume number.", 400);
            }

            foreach ($objGroupedTracks[$arrParams["volume_number"]] as $objTrack) {
                $key = array_search($objTrack->file_uuid, array_column($organizeMusics, "file_uuid"));

                if (!$key) {
                    throw new Exception("Volume track can not be found in new order array.", 400);
                }

                $intNewNumber = $organizeMusics[$key]["track_number"];
                $intOldNumber = $objTrack->track_number;

                $objTrack->track_number = $intNewNumber;
                $objTrack->save();

                if ($intOldNumber !== $intNewNumber) {
                    $this->trackHistoryRepo->create([
                        "track_id" => $objTrack->track_id,
                        "track_uuid" => $objTrack->track_uuid,
                        "field_name" => "track_number",
                        "old_value" => $intOldNumber,
                        "new_value" => $intNewNumber,
                    ]);
                    $changes["Track Number"] = [
                        "Previous value" => $intOldNumber,
                        "Changed to" => $intNewNumber
                    ];

                    $arrJobs[] = new TrackLedger($objTrack, TrackLedgerService::UPDATE_EVENT, $changes);
                }
            }

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        Bus::chain($arrJobs)->onQueue("ledger")->dispatch();

        return ($objCol);
    }

    /**
     * Add new directory
     * @param array $arrParams
     * @return SoundblockCollection
     * @throws Exception
     */
    public function addDirectory($arrParams): SoundblockCollection {
        $objProject = $this->projectRepo->find($arrParams["project"]);
        $objLatestCol = $this->colRepo->findLatestByProject($objProject);
        $newCollection = $this->create($objProject, $arrParams);
        $this->dirRepo->createModel($arrParams, $newCollection);

        event(new OnHistory($newCollection, "Created", null, Auth::user(), $arrParams["directory_category"]));

        if (!$objLatestCol) {
            return ($newCollection);
        }

        $newCollection = $this->colRepo->attachResources($newCollection, $objLatestCol);

        dispatch(new CollectionLedger($newCollection, CollectionLedgerService::CREATE_EVENT))->onQueue("ledger");

        return ($newCollection);
    }

    /**
     * Edit the name of directory and collection comment.
     * @param array $arrParams
     * @return SoundblockCollection
     * @throws Exception
     */
    public function editDirectory(array $arrParams) {
        try {
            \DB::beginTransaction();

            $project = $this->projectRepo->find($arrParams["project"], true);
            $collection = $this->colRepo->findLatestByProject($project);

            if (!$collection) {
                throw new Exception("Project has n't any collection", 400);
            }

            $directory = $this->dirRepo->findByPath($collection, $arrParams["directory_sortby"]);
            Log::info('test', ["Test" => $directory, "param" => $arrParams["directory_sortby"]]);

            if (!$directory) {
                throw new Exception("Directory not exists.", 400);
            }

            $directoriesUnderPath = $this->dirRepo->findAllUnderPath($collection, $directory->directory_sortby);
            $directoryParam = [
                "directory_path"   => $arrParams["new_directory_path"],
                "directory_sortby" => $directory->directory_category . DIRECTORY_SEPARATOR . $arrParams["new_directory_path"],
                "directory_name"   => $arrParams["new_directory_name"],
            ];
            $filesInDirectory = $this->dirRepo->getFilesInDir($directory, $collection);
            $filesToAdd = $this->getFilesToAdd($collection->files, $filesInDirectory);
            $directoriesToAdd = $this->getDirsToAdd($collection->directories,
                $this->dirRepo->findAllByPath($collection, $directory->directory_sortby));
            $newCollection = $this->create($collection->project, $arrParams);
            $newCollection = $this->colRepo->attachResources($newCollection, $collection, $directoriesToAdd, $filesToAdd);
            $newDirectory = $this->dirRepo->createModel($directoryParam, $newCollection);

            foreach ($directoriesUnderPath as $item) {
                $itemDirectoryParam = $this->dirRepo->getParams($item);
                $itemDirectoryParam["directory_path"] = Util::replace($directory->directory_sortby, $newDirectory->directory_sortby, $itemDirectoryParam["directory_path"]);
                $itemDirectoryParam["directory_sortby"] = Util::replace($directory->directory_sortby, $newDirectory->directory_sortby, $itemDirectoryParam["directory_sortby"]);
                $this->dirRepo->createModel($itemDirectoryParam, $newCollection);
            }

            foreach ($filesInDirectory as $item) {
                $itemFileParam = $this->fileRepo->getParams($item);
                $itemFileParam["file_uuid"] = Util::uuid();
                $itemFileParam["file_path"] = Util::replace($directory->directory_sortby, $newDirectory->directory_sortby, $itemFileParam["file_path"]);
                $itemFileParam["file_sortby"] = Util::replace($directory->directory_sortby, $newDirectory->directory_sortby, $itemFileParam["file_sortby"]);

                foreach ($itemFileParam["meta"] as $metaKey => $metaField) {
                    $itemFileParam[$metaKey] = $metaField;
                }

                unset($itemFileParam["meta"]);
                // create the new file.
                $this->fileRepo->createInCollection($itemFileParam, $newCollection);
            }

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        event(new OnHistory($newCollection, "modified", null, null, $arrParams["file_category"]));
        dispatch(new CollectionLedger($newCollection, CollectionLedgerService::CREATE_EVENT))->onQueue("ledger");


        return ($newCollection);
    }

    /**
     * Restore old version file
     * @param array $arrParams
     * @return SoundblockCollection|CollectionRepository
     * @throws Exception
     */
    public function restore(array $arrParams) {
        try {
            \DB::beginTransaction();

            $arrRestoreFiles = $this->fileRepo->findWhere($arrParams["files"]);

            if ($arrRestoreFiles->count() === 0) {
                abort(400, "No files to restore.");
            }

            /** @var SoundblockCollection $collection */
            $collection = $this->find($arrParams["collection"]);
            /** @var Project $objProject */
            $objProject = $collection->project;
            $objLatestCol = $this->colRepo->findLatestByProject($objProject);
            $objNewCol = $this->create($objProject, $arrParams);
            $arrHistoryFiles = collect();

            foreach ($arrRestoreFiles as $objFile) {
                $arrHistoryFiles->push([
                    "parent" => $objFile,
                    "new"    => $objFile,
                ]);
            }
            $arrFilesToAttach = $this->getFilesToAdd($objLatestCol->files, $arrRestoreFiles);
            $objNewCol = $this->colRepo->attachResources($objNewCol, $objLatestCol, null, $arrFilesToAttach);
            $trackFiles = $arrRestoreFiles->where("file_category", "music");

            if (!empty($trackFiles)) {
                $intCollectionFilesCount = $objNewCol->tracks()->count();

                foreach ($trackFiles as $index => $objFile) {
                    $objFile->track->track_number = $intCollectionFilesCount + $index + 1;
                }
            }

            $objNewCol = $this->colRepo->attachFiles($objNewCol, $arrRestoreFiles);


            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        event(new OnHistory($objNewCol, "Restored", $arrHistoryFiles));

        foreach ($arrRestoreFiles as $objFile) {
            dispatch(new FileLedger($objFile, Soundblock::project_file_path($objProject, $objFile)))->onQueue("ledger");
        }

        dispatch(new CollectionLedger($objNewCol, CollectionLedgerService::CREATE_EVENT))->onQueue("ledger");

        return ($objNewCol);
    }

    /**
     * Revert the file
     * @param array $arrParams
     * @return SoundblockCollection|CollectionRepository
     * @throws Exception
     */
    public function revert(array $arrParams) {
        try {
            \DB::beginTransaction();

            $arrRevertFiles = $this->fileRepo->findWhere($arrParams["files"]);
            /** @var SoundblockCollection */
            $collection = $this->find($arrParams["collection"], true);
            if ($arrRevertFiles->count() == 0)
                throw new Exception("No files to revert.");

            $arrChildFiles = collect();

            foreach ($arrRevertFiles as $revertFile) {
                $childFile = $this->fileHistoryRepo->findChild($revertFile);

                if (is_object($childFile)) {
                    $arrChildFiles->push($childFile);
                }
            }
            $objProject = $collection->project;
            $objLatestCol = $this->findLatestByProject($objProject);
            $arrHistoryFiles = collect();

            foreach ($arrRevertFiles as $objFile) {
                $arrHistoryFiles->push([
                    "new"    => $objFile,
                    "parent" => $objFile,
                ]);
            }
            $arrFilesToAttach = $this->getFilesToAdd($objLatestCol->files, $arrChildFiles);
            $objNewCol = $this->create($objProject, $arrParams);
            $objNewCol = $this->colRepo->attachResources($objNewCol, $objLatestCol, null, $arrFilesToAttach);
            $objNewCol = $this->colRepo->attachFiles($objNewCol, $arrRevertFiles);

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        event(new OnHistory($objNewCol, "Reverted", $arrHistoryFiles));

        dispatch(new CollectionLedger($objNewCol, CollectionLedgerService::CREATE_EVENT))->onQueue("ledger");

        return ($objNewCol);
    }

    /**
     * @param array $arrParams
     * @return SoundblockCollection
     * @throws Exception
     */
    public function deleteFiles(array $arrParams): SoundblockCollection {
        try {
            \DB::beginTransaction();

            $objProject = $this->projectRepo->find($arrParams["project"], true);
            $objCol = $this->findLatestByProject($objProject);

            if (!$objCol) {
                throw new BadRequestHttpException("Project({$arrParams["project"]}) has n't any collection", null, 400);
            }

            if (!$this->colRepo->hasFiles($objCol, collect($arrParams["files"])->pluck("file_uuid")->toArray())) {
                throw new Exception("Collection {$objCol->collection_uuid} has n't these files.");
            }

            $arrFilesToDel = $arrParams["files"];
            $arrToAddFiles = $this->getFilesToAdd($objCol->files, $arrFilesToDel);
            $objNew = $this->create($objCol->project, $arrParams);
            $objNew = $this->colRepo->attachResources($objNew, $objCol, null, $arrToAddFiles);
            $arrParentFiles = $this->fileRepo->findWhere($arrFilesToDel);
            $arrHistoryFiles = collect();

            foreach ($arrParentFiles as $objFile) {
                $arrHistoryFiles->push([
                    "new"    => $objFile,
                    "parent" => $objFile,
                ]);
            }

            $objCollectionTracks = $objNew->tracks;

            foreach ($objCollectionTracks as $index => $objTrack) {
                $objTrack->update(["track_number" => $index + 1]);
            }
            
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        event(new OnHistory($objNew, "Deleted", $arrHistoryFiles));

        foreach ($arrParentFiles as $objFile) {
            dispatch(new FileLedger($objFile, Soundblock::project_file_path($objProject, $objFile)))->onQueue("ledger");
        }

        dispatch(new CollectionLedger($objNew, CollectionLedgerService::CREATE_EVENT, ["deleted" => $arrParentFiles]))->onQueue("ledger");

        return ($objNew);
    }

    /**
     * @param string $strCollection
     * @param array $arrParam
     * @param User $objUser
     * @return QueueJob
     * @throws Exception
     */
    public function zipFiles(string $strCollection, array $arrParam, User $objUser): QueueJob {
        /** @var SoundblockCollection */
        $collection = $this->find($strCollection, true);

        if (!$this->colRepo->hasFiles($collection, collect($arrParam["files"])->pluck("file_uuid")->toArray())) {
            throw new BadRequestHttpException("Collection ({$collection->collection_uuid}) has not these files", null, 400);
        }

        $queueJob = $this->createQueueJobAndAlertForZip();
        $files = $this->fileRepo->findWhere($arrParam["files"]);

        dispatch(new Zip($queueJob, $collection, $objUser, $files));

        return ($queueJob);
    }

    /**
     * @param array $arrParams
     * @return SoundblockCollection
     * @throws Exception
     */
    public function deleteDirectory(array $arrParams): SoundblockCollection {
        try {
            \DB::beginTransaction();
            $objProject = $this->projectRepo->find($arrParams["project"], true);
            $objCol = $this->findLatestByProject($objProject);
            $objDir = $this->dirRepo->find($arrParams["directory"]);
            $arrFilesInDir = $this->dirRepo->getFilesInDir($objDir, $objCol);

            $objNew = $this->create($objCol->project, $arrParams);
            $arrExistFiles = $objCol->files;
            $arrToAddFiles = $this->getFilesToAdd($arrExistFiles, $arrFilesInDir);

            $arrDirsToRmv = [[
                "directory_uuid" => $objDir->directory_uuid,
            ]];
            $arrExistDirs = $objCol->directories;
            $arrDirsToAdd = $this->getDirsToAdd($arrExistDirs, $arrDirsToRmv);

            $objNew = $this->colRepo->attachResources($objNew, $objCol, $arrDirsToAdd, $arrToAddFiles);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

            throw $e;
        }

        $arrHistoryFiles = collect();

        foreach ($arrFilesInDir as $objFile) {
            $arrHistoryFiles->push([
                "parent" => $objFile,
                "new"    => $objFile,
            ]);
        }

        if ($arrHistoryFiles->count() == 0) {
            event(new OnHistory($objNew, "Deleted", $arrHistoryFiles));
        } else {
            event(new OnHistory($objNew, "Deleted", $arrHistoryFiles, null, $arrParams["file_category"]));
        }

        dispatch(new CollectionLedger($objNew, CollectionLedgerService::CREATE_EVENT))->onQueue("ledger");

        return ($objNew);
    }

    /**
     * @return QueueJob
     * @throws Exception
     */
    protected function createQueueJobAndAlertForZip(): QueueJob {
        $app = Client::app();
        /** @var User $objUser */
        $objUser = Auth::user();

        $queueJobParams = [
            "user_id"   => $objUser->user_id,
            "user_uuid" => $objUser->user_uuid,
            "app_id"    => $app->app_id,
            "app_uuid"  => $app->app_uuid,
        ];
        switch ($app->app_name) {
            case "soundblock" :
            {
                $queueJobParams = array_merge($queueJobParams, ["job_type" => "Job.Soundblock.Project.Download"]);
                break;
            }
            case "office" :
            {
                $queueJobParams = array_merge($queueJobParams, ["job_type" => "Job.Office.Project.Download"]);
                break;
            }
            default:
                break;
        }
        $queueJob = $this->queueJobRepo->createModel($queueJobParams);
        $notificationParams = [
            "app_id"              => $app->app_id,
            "app_uuid"            => $app->app_uuid,
            "notification_name"   => "Silent Alert",
            "notification_memo"   => "This notification is silent alert",
            "notification_action" => "Not Triggered",
        ];
        $userNotificationParams = [
            "notification_state" => "read",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];
        $notification = $this->notiRepo->createModel($notificationParams);
        $this->notiRepo->attachUser($notification, $objUser, $userNotificationParams);

        return ($queueJob);
    }

    /**
     * @return QueueJob
     * @throws Exception
     */
    protected function createQueueJobAndSilentAlert(): QueueJob {
        $app = Client::app();
        $queueJob = $this->queueJobRepo->createModel([
            "user_id"          => Auth::id(),
            "user_uuid"        => Auth::user()->user_uuid,
            "app_id"           => $app->app_id,
            "app_uuid"         => $app->app_uuid,
            "job_type"         => "Job.Soundblock.Project.Collection.Extract",
            "flag_status"      => "Pending",
            "flag_silentalert" => 1,
        ]);

        $arrNotiParams = [
            "app_id"              => $app->app_id,
            "app_uuid"            => $app->app_uuid,
            "notification_name"   => "Silent Alert",
            "notification_memo"   => "This notification is silent alert",
            "notification_action" => "Not Triggered",
        ];
        $arrUserNotiParams = [
            "notification_state" => "read",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];
        $notification = $this->notiRepo->createModel($arrNotiParams);
        $this->notiRepo->attachUser($notification, Auth::user(), $arrUserNotiParams);

        return ($queueJob);
    }

    /**
     * @param QueueJob $queueJob
     * @param string $uploadedFileName
     * @param array $files
     * @param string $strComment
     * @param Project $project
     */
    protected function extractFiles(QueueJob $queueJob, string $uploadedFileName, array $files, string $strComment, Project $project): void {
        dispatch(new ExtractProject($queueJob, $uploadedFileName, $files, $strComment, $project));
    }

    /**
     * Create an array parameters
     * @param SoundblockCollection $collection
     * @param array $arrFile
     * @param string $dest
     * @param string $savePath
     * @return array
     * @throws Exception
     */
    private function getFileParameters(SoundblockCollection $collection, array $arrFile, string $dest, string $savePath): array {
        if (!$this->soundblockAdapter->exists($savePath)) {
            throw new Exception("File not uploaded.", 400);
        }

        $ext = pathinfo($arrFile["file_name"], PATHINFO_EXTENSION);
        $physicalName = Util::uuid();
        $strProjectFilePath = $dest . $physicalName . "." . $ext;
        $this->soundblockAdapter->move($savePath, $strProjectFilePath);

        if ($this->soundblockAdapter->getDriver()->getAdapter() instanceof AwsS3Adapter) {
            Storage::disk("local")->writeStream($strProjectFilePath, $this->soundblockAdapter->readStream($strProjectFilePath));
            $strPath = Storage::disk("local")->path($strProjectFilePath);
        } else {
            $strPath = $this->soundblockAdapter->path($strProjectFilePath);
        }

        $md5File = md5_file($strPath);

        $size = $this->soundblockAdapter->size($dest . $physicalName . "." . $ext);

        $arrFile = array_merge($arrFile, [
            "file_uuid"     => $physicalName,
            "file_category" => $arrFile["file_category"],
            "file_size"     => $size,
            "file_md5"      => $md5File,
            "file_ext"      => $ext,
        ]);

        if ($arrFile["file_category"] == "music") {
            try {
                $media = MediaFile::open($strPath);
                if ($media->isAudio()) {
                    $audio = $media->getAudio();
                    $duration = intval($audio->getLength());
                }
            } catch (\Exception $exception) {
                info($exception->getMessage());
//                throw $exception;
            }

            $arrFile["track_duration"] = isset($duration) ? floor($duration) : 0;

            try {
                $strProcessedPath = $this->soxService->convert($strPath);

                if ($strProcessedPath !== $strPath) {
                    $this->soundblockAdapter->delete($strProjectFilePath);
                    $this->soundblockAdapter->writeStream($strProjectFilePath, Storage::disk("local")
                        ->readStream($dest . $physicalName . "_processed.$ext"));
                }
            } catch (\Exception $exception) {
                info($exception);
            }
        }

        if (!isset($arrFile["track_number"]) && $arrFile["file_category"] == "music") {
            $arrFile["track_number"] = $this->colRepo->getTracks($collection)->count() + 1;
        }

        if (!isset($arrFile["file_path"])) {
            $arrFile["file_path"] = Util::ucfLabel($arrFile["file_category"]);
        } else {
            $arrPath = explode("/", $arrFile["file_path"]);
            $arrPath[0] = strtolower($arrPath[0]) === strtolower($arrFile["file_category"]) ? $arrPath[0] : ucfirst($arrFile["file_category"]);
            $arrFile["file_path"] = implode("/", $arrPath);
        }

        $arrFile["file_sortby"] = $arrFile["file_path"] . DIRECTORY_SEPARATOR . $arrFile["file_name"];

        if (isset($arrFile["track"]["file_uuid"]) && $arrFile["file_category"] == "video") {
            $objFileMusic = $this->fileRepo->find($arrFile["track"]["file_uuid"], true);
            $arrFile["music_id"] = $objFileMusic->file_id;
            $arrFile["music_uuid"] = $objFileMusic->file_uuid;
        }

        $arrFile = Util::rename_file($collection, $arrFile);

        return ($arrFile);
    }
}
