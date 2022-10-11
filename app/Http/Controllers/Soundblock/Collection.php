<?php

namespace App\Http\Controllers\Soundblock;

use Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Facades\Core\Converter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Filesystem\Soundblock;
use App\Http\Transformers\Soundblock\OnlyFile;
use App\Contracts\Soundblock\Audit\Bandwidth;
use App\Jobs\Soundblock\{
    Ledger\TrackLedger
};
use App\Services\{
    Core\Auth\AuthGroup,
    Common\QueueJob,
    Common\Zip,
    Soundblock\File,
    Soundblock\Project as ProjectService,
    Soundblock\Payment as PaymentService,
    Soundblock\Directory as DirectoryService,
    Soundblock\Collection as CollectionService
};
use App\Http\Requests\{Soundblock\Collection\AddFileToCollection,
    Soundblock\Collection\EditFilesInCollection,
    Soundblock\Collection\File\AddTimecodes,
    Soundblock\Collection\File\SaveCover,
    Soundblock\Collection\GetFiles,
    Soundblock\Collection\OrganizeMusic,
    Soundblock\Collection\File\RevertFile,
    Soundblock\Collection\File\DeleteFile,
    Soundblock\Collection\File\RestoreFile,
    Soundblock\Directory\AddDirectory,
    Soundblock\Directory\DeleteDirectory,
    Soundblock\Directory\UpdateDirectory,
    Soundblock\Project\ConfirmMultipleFiles,
    Office\Project\Collection\ZipFile,
    Soundblock\Track\GetTrackHistory,
    Soundblock\Track\UpdateTrack};
use App\Repositories\Soundblock\TrackHistory as TrackHistoryRepository;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Collection extends Controller {
    /** @var AuthGroup */
    protected AuthGroup $authGroupService;
    /** @var QueueJob */
    private QueueJob $jobService;
    /** @var Zip */
    private Zip $zipService;
    /** @var CollectionService */
    private CollectionService $colService;
    /** @var DirectoryService */
    private DirectoryService $directoryService;
    /** @var ProjectService */
    private ProjectService $projectService;
    /** @var File */
    private File $fileService;
    /** @var Bandwidth */
    private Bandwidth $bandwidthService;
    /** @var PaymentService */
    private PaymentService $paymentService;
    /** @var TrackHistoryRepository */
    private TrackHistoryRepository $trackHistoryRepo;

    /**
     * @param AuthGroup $authGroupService
     * @param Zip $zipService
     * @param DirectoryService $directoryService
     * @param QueueJob $jobService
     * @param CollectionService $colService
     * @param ProjectService $projectService
     * @param File $fileService
     * @param Bandwidth $bandwidthService
     * @param PaymentService $paymentService
     * @param TrackHistoryRepository $trackHistoryRepo
     */
    public function __construct(AuthGroup $authGroupService, Zip $zipService, DirectoryService $directoryService,
                                QueueJob $jobService, CollectionService $colService, ProjectService $projectService,
                                File $fileService, Bandwidth $bandwidthService, PaymentService $paymentService,
                                TrackHistoryRepository $trackHistoryRepo) {
        $this->authGroupService = $authGroupService;
        $this->jobService = $jobService;
        $this->zipService = $zipService;
        $this->colService = $colService;
        $this->directoryService = $directoryService;
        $this->projectService = $projectService;
        $this->fileService = $fileService;
        $this->bandwidthService = $bandwidthService;
        $this->paymentService = $paymentService;
        $this->trackHistoryRepo = $trackHistoryRepo;
    }

    /**
     * @param string $project
     * @param Request $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function index(string $project, Request $objRequest) {
        $objGroup = $this->authGroupService->findByProject($project);

        if (!$this->authGroupService->checkIfUserExists(Auth::user(), $objGroup)) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objRequest->validate([
            "per_page" => ["required", "integer"],
        ]);

        $objCollections = $this->colService->findAllByProject(
            $project,
            $objRequest->input("per_page"),
            "soundblock",
            $objRequest->input("category")
        );

        return ($this->apiReply($objCollections, "", Response::HTTP_OK));
    }

    /**
     * @param string $collection
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function getTrackInCollection(string $collection) {
        $strGroupName = $this->authGroupService->findByCollection($collection)->group_name;

        if (!is_authorized(Auth::user(), $strGroupName, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrFiles = $this->colService->getTracks($collection);

        return ($this->collection($arrFiles, new OnlyFile));
    }

    /**
     * @param string $collection
     * @param GetFiles $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function showResources(string $collection, GetFiles $objRequest) {
        $strGroupName = $this->authGroupService->findByCollection($collection)->group_name;

        if (!is_authorized(Auth::user(), $strGroupName, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if ($objRequest->input("file_path") == "Music") {
            $arrFile = $this->colService->getCollectionTracks($collection);
        } else {
            $arrFile = $this->colService->getResources($collection, $objRequest->file_path);
        }

        return ($this->apiReply($arrFile));
    }

    /**
     * @param string $file
     * @return mixed
     * @throws \Exception
     */
    public function getFileHistory(string $file) {
        $arrHistory = $this->colService->getFilesHistory($file);

        return ($this->apiReply($arrHistory));
    }

    /**
     * @param string $collection
     * @return mixed
     * @throws \Exception
     */
    public function getCollectionFilesHistory(string $collection) {
        $strGroupName = $this->authGroupService->findByCollection($collection)->group_name;

        if (!is_authorized(Auth::user(), $strGroupName, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        return ($this->apiReply($this->colService->getCollectionFilesHistory($collection)));
    }

    public function getTrackCover(string $project, string $file) {
        $objProject = $this->projectService->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $objFile = $this->fileService->find($file);

        if (is_null($objFile)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($objFile->file_category !== Constant::MusicCategory) {
            return $this->apiReject(null, "Not A Music File.", Response::HTTP_BAD_REQUEST);
        }

        $strPath = Soundblock::project_track_artwork($objProject, $objFile);

        if (!bucket_storage("soundblock")->exists($strPath)) {
            $strPath = Soundblock::upload_project_artwork_path($objProject);
        }

        return bucket_storage("soundblock")->download($strPath);
    }

    public function getTimecodes(string $project, string $file) {
        $objProject = $this->projectService->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $objFile = $this->fileService->find($file);

        if (is_null($objFile)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($objFile->file_category !== Constant::MusicCategory) {
            return $this->apiReject(null, "Not A Music File.", Response::HTTP_BAD_REQUEST);
        }

        $arrayTimecodes = $this->fileService->getTimecodes($objFile);

        return $this->apiReply($arrayTimecodes);
    }

    public function getTrackHistory(GetTrackHistory $objRequest){
        $bnSoundblock = is_authorized(
            Auth::user(),
            $this->authGroupService->findByProject($objRequest->input("project"))->group_name,
            "App.Soundblock.Project.File.Music.Update",
            "soundblock"
        );

        if (!$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objFile = $this->fileService->find($objRequest->input("file_uuid"));

        if (is_null($objFile) || is_null($objFile->track)) {
            return ($this->apiReject("", "Track not found.", Response::HTTP_BAD_REQUEST));
        }

        $objTrackHistory = $this->fileService->getTrackHistory($objFile->track);

        return ($this->apiReply($objTrackHistory->values(), "", Response::HTTP_OK));
    }

    /**
     * @param $jobUuid
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function downloadZipFile($jobUuid) {
        try {
            $objJob = $this->jobService->find($jobUuid);
            $objUser = Auth::user();

            if ($objJob->user_id !== $objUser->user_id) {
                abort(403, "You have not access to this resource.");
            }

            $objJob->flag_remove_file = true;
            $objJob->save();

            return redirect()->to($objJob->job_json["download"]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function directoryFiles(string $collection, string $directory) {
        $objCollection = $this->colService->find($collection);
        $objUser = Auth::user();

        if (is_null($objCollection)) {
            return $this->apiReject(null, "Collection Not Found", Response::HTTP_NOT_FOUND);
        }

        $strSoundGroup = $this->authGroupService->findByProject($objCollection->project_uuid)->group_name;
        $arrayResult = $this->directoryService->prepareDownloadDirectoryFiles($objCollection, $directory);
        $filesUuuids = collect($arrayResult["files"])->pluck("file_uuid")->toArray();

        $fileCategories = $this->colService->getFileCategory($filesUuuids);
        $bnSoundblock = false;

        if (!empty($fileCategories)) {
            $bnSoundblock = true;

            foreach ($fileCategories as $category) {
                switch ($category) {
                    case Constant::MusicCategory:
                        $strPermission = "App.Soundblock.Project.File.Music.Download";
                        break;
                    case Constant::VideoCategory:
                        $strPermission = "App.Soundblock.Project.File.Video.Download";
                        break;
                    case Constant::MerchCategory:
                        $strPermission = "App.Soundblock.Project.File.Merch.Download";
                        break;
                    default:
                        $strPermission = "App.Soundblock.Project.File.Files.Download";
                        break;
                }

                $bnSoundblock = $bnSoundblock && is_authorized($objUser, $strSoundGroup, $strPermission, "soundblock");
            }
        }

        if (!is_authorized($objUser, "App.Office", "App.Office.Access", "office") && !$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        return ($this->apiReply($arrayResult, "", 200));
    }

    public function playMusicFile(string $project, string $file) {
        $objProject = $this->projectService->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $objFile = $this->fileService->find($file);

        if (is_null($objFile)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($objFile->file_category !== Constant::MusicCategory) {
            return $this->apiReject(null, "Not A Music File.", Response::HTTP_BAD_REQUEST);
        }

        $filePath = Soundblock::project_file_path($objProject, $objFile);

        if (!bucket_storage("soundblock")->exists($filePath)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        $this->bandwidthService->create($objProject, Auth::user(), bucket_storage("soundblock")->size($filePath),
            Bandwidth::DOWNLOAD);

        return bucket_storage("soundblock")->download($filePath);
    }

    /**
     * @param ZipFile $objRequest
     * @param string $collection
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function zipFiles(ZipFile $objRequest, string $collection) {
        $objCollection = $this->colService->find($collection);
        $objUser = Auth::user();

        if (is_null($objCollection)) {
            return $this->apiReject(null, "Collection Not Found", Response::HTTP_NOT_FOUND);
        }

        $strSoundGroup = $this->authGroupService->findByProject($objCollection->project_uuid)->group_name;

        $filesUuuids = collect($objRequest->input("files"))->pluck("file_uuid")->toArray();

        $fileCategories = $this->colService->getFileCategory($filesUuuids);
        $bnSoundblock = false;

        if (!empty($fileCategories)) {
            $bnSoundblock = true;

            foreach ($fileCategories as $category) {
                switch ($category) {
                    case Constant::MusicCategory:
                        $strPermission = "App.Soundblock.Project.File.Music.Download";
                        break;
                    case Constant::VideoCategory:
                        $strPermission = "App.Soundblock.Project.File.Video.Download";
                        break;
                    case Constant::MerchCategory:
                        $strPermission = "App.Soundblock.Project.File.Merch.Download";
                        break;
                    default:
                        $strPermission = "App.Soundblock.Project.File.Files.Download";
                        break;
                }

                $bnSoundblock = $bnSoundblock && is_authorized($objUser, $strSoundGroup, $strPermission, "soundblock");
            }
        }


        $bnOffice = is_authorized($objUser, "App.Office", "App.Office.Access", "office");

        if (!$bnOffice && !$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        /** @var \App\Models\Common\QueueJob */
        $queueJob = $this->colService->zipFiles($collection, $objRequest->all(), $objUser);

        return ($this->apiReply($this->jobService->getStatus($queueJob->job_uuid)));
    }

    /**
     * @param string $project
     * @param string $file
     * @param AddTimecodes $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function addFileTimecodes(string $project, string $file, AddTimecodes $objRequest) {
        $objProject = $this->projectService->find($project);

        if ($objRequest->input("preview_start") >= $objRequest->input("preview_stop")) {
            return $this->apiReject(null, "Preview Stop Time Must be Greater Than Preview Start.", Response::HTTP_NOT_FOUND);
        }

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $objFile = $this->fileService->find($file);

        if (is_null($objFile)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($objFile->file_category !== Constant::MusicCategory) {
            return $this->apiReject(null, "Not A Music File.", Response::HTTP_BAD_REQUEST);
        }

        $arrStartTime = $objRequest->input("preview_start");
        $arrStopTime = $objRequest->input("preview_stop");

        if (intval($arrStopTime) > intval($objFile->track->track_duration)) {
            return $this->apiReject(null, "Preview Stop Time Can't be Greater Than Track Duration.", Response::HTTP_BAD_REQUEST);
        }

        $oldPreviewStart = $objFile->track->preview_start;
        $oldPreviewStop = $objFile->track->preview_stop;

        $objFile = $this->fileService->addTimeCodes($objFile, $arrStartTime, $arrStopTime);

        $arrHistory["preview_start"] = ["old" => $oldPreviewStart, "new" => $objFile->track->preview_start];
        $arrHistory["preview_stop"] = ["old" => $oldPreviewStop,  "new" => $objFile->track->preview_stop];

        foreach ($arrHistory as $column => $value) {
            $this->trackHistoryRepo->create([
                "track_id" => $objFile->track->track_id,
                "track_uuid" => $objFile->track->track_uuid,
                "field_name" => $column,
                "old_value" => $value["old"],
                "new_value" => $value["new"],
            ]);
        }

        dispatch(new TrackLedger($objFile->track, "Update Track Meta"))->onQueue("ledger");

        return $this->apiReply($objFile);
    }

    public function saveTrackCover(string $project, string $file, SaveCover $objRequest) {
        /** @var \App\Models\Soundblock\Projects\Project $objProject */
        $objProject = $this->projectService->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }
        /** @var \App\Models\Soundblock\Files\File $objFile */
        $objFile = $this->fileService->find($file);

        if (is_null($objFile)) {
            return $this->apiReject(null, "File Not Found.", Response::HTTP_NOT_FOUND);
        }

        if ($objFile->file_category !== Constant::MusicCategory) {
            return $this->apiReject(null, "Not A Music File.", Response::HTTP_BAD_REQUEST);
        }

        $objUploadedFile = $objRequest->file("file");
        $strPath = $objUploadedFile->getRealPath();

        if ($objUploadedFile->getClientOriginalExtension() !== "png") {
            $strPath = Converter::convertImageToPng($strPath);
        }

        $this->bandwidthService->create($objProject, Auth::user(), $objRequest->file("file")->getSize(), Bandwidth::UPLOAD);

        $objFile = $this->fileService->saveCoverImage($objProject, $objFile, $strPath);

        return $this->apiReply($objFile);
    }

    /**
     * @param AddDirectory $objRequest
     * @return object
     * @throws \Exception
     */
    public function addDirectory(AddDirectory $objRequest) {
        $strSoundGroup = sprintf("App.Soundblock.Project.%s", $objRequest->project);

        $bnOffice = is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office");
        $bnSoundblock = is_authorized(Auth::user(), $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock");

        if (!$bnOffice && !$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->colService->addDirectory($objRequest->all());
        $objDirectories = $this->colService->findAllByProject($objRequest->project);

        return ($this->apiReply($objDirectories, "Directory added successfully.", Response::HTTP_OK));
    }

    /**
     * @param AddFileToCollection $objRequest
     * @return mixed
     * @throws \Exception
     */
    public function uploadFiles(AddFileToCollection $objRequest) {
        $arrFiles = $objRequest->has("files") ? $objRequest->file("files") : [$objRequest->file("file")];

        $uploadedFileNames = [];
        $uploadedFilesSize = 0;
        $strGroupName = $this->authGroupService->findByProject($objRequest->input("project"))->group_name;
        $objProject = $this->projectService->find($objRequest->input("project"));
        $objUser = Auth::user();

        foreach ($arrFiles as $objFile) {
            $uploadedFilesSize += $objFile->getSize();
        }

        $boolResult = $this->paymentService->calculateBucketStorageFreeSize($objProject->account, $uploadedFilesSize);

        if (!$boolResult) {
            return ($this->apiReject(null, "File have reached your storage transaction limit.", 400));
        }

        foreach ($arrFiles as $objFile) {
            $strPermissionName = "App.Soundblock.Account.Project.Create";
            $strFileExt = $objFile->getClientOriginalExtension();
            $strCategory = $this->zipService->getFileCategory($strFileExt);

            if ($strFileExt !== "zip") {
                switch ($strCategory) {
                    case Constant::MusicCategory:
                        $strPermissionName = "App.Soundblock.Project.File.Music.Add";
                        break;
                    case Constant::VideoCategory:
                        $strPermissionName = "App.Soundblock.Project.File.Video.Add";
                        break;
                    case Constant::MerchCategory:
                        $strPermissionName = "App.Soundblock.Project.File.Merch.Add";
                        break;
                    default:
                        $strPermissionName = "App.Soundblock.Project.File.Files.Add";
                        break;
                }
            }

            if (!is_authorized($objUser, $strGroupName, $strPermissionName, "soundblock")) {
                return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
            }
        }

        foreach ($arrFiles as $key => $objFile) {
            [$uploadedFileNames[$objFile->getClientOriginalName()], $strFilePath] = $this->colService->uploadFile(["file" => $objFile]);
            $this->bandwidthService->create($objProject, $objUser, bucket_storage("soundblock")->size($strFilePath), Bandwidth::UPLOAD);
        }

        if ($objRequest->has("file")) {
            return ($this->apiReply($uploadedFileNames[$objRequest->file("file")
                                                                  ->getClientOriginalName()], "Files have been uploaded.", 200));
        }

        return ($this->apiReply($uploadedFileNames, "Files have been uploaded.", 200));
    }

    /**
     * @param ConfirmMultipleFiles $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function confirmFiles(ConfirmMultipleFiles $objRequest) {
        $objFilesCollection = collect($objRequest->input("files"));
        $arrZip = $objFilesCollection->where("is_zip", 1)->first();

        $strSoundGroup = $this->authGroupService->findByProject($objRequest->project)->group_name;
        $objProject = $this->projectService->find($objRequest->project);
        $bnOffice = is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office");

        foreach ($objRequest->input("files") as $file) {
            $strExtension = pathinfo($file["file_name"], PATHINFO_EXTENSION);
            $strCategory = $this->zipService->getFileCategory($strExtension);

            if ($file["is_zip"]) {
                $strPermissionName = "App.Soundblock.Account.Project.Create";
            } else {
                switch ($strCategory) {
                    case Constant::MusicCategory:
                        $strPermissionName = "App.Soundblock.Project.File.Music.Add";
                        break;
                    case Constant::VideoCategory:
                        $strPermissionName = "App.Soundblock.Project.File.Video.Add";
                        break;
                    case Constant::MerchCategory:
                        $strPermissionName = "App.Soundblock.Project.File.Merch.Add";
                        break;
                    default:
                        $strPermissionName = "App.Soundblock.Project.File.Files.Add";
                        break;
                }
            }

            $bnSoundblock = is_authorized(Auth::user(), $strSoundGroup, $strPermissionName, "soundblock");

            if (!$bnOffice && !$bnSoundblock) {
                return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
            }
        }

        if (is_array($arrZip)) {
            /** @var \App\Models\Common\QueueJob */
            $queueJob = $this->colService->confirm([
                "file"               => $arrZip,
                "project"            => $objRequest->project,
                "collection_comment" => $objRequest->collection_comment,
            ]);
        } else {
            $queueJob = $this->colService->processFilesJob($objProject, $objRequest->input("collection_comment"), $objRequest->input("files"));
        }

        return $this->apiReply($this->jobService->getStatus($queueJob->job_uuid));
    }

    /**
     * @param EditFilesInCollection $objRequest
     * @return object
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function editFiles(EditFilesInCollection $objRequest) {
        $objUser = Auth::user();
        $strSoundGroup = $this->authGroupService->findByProject($objRequest->project)->group_name;
        $filesUuuids = collect($objRequest->input("files"))->pluck("file_uuid")->toArray();
        $fileCategories = $this->colService->getFileCategory($filesUuuids);
        $bnSoundblock = false;

        if (!empty($fileCategories)) {
            $bnSoundblock = true;

            foreach ($fileCategories as $category) {
                switch ($category) {
                    case Constant::MusicCategory:
                        $strPermission = "App.Soundblock.Project.File.Music.Update";
                        break;
                    case Constant::VideoCategory:
                        $strPermission = "App.Soundblock.Project.File.Video.Update";
                        break;
                    case Constant::MerchCategory:
                        $strPermission = "App.Soundblock.Project.File.Merch.Update";
                        break;
                    default:
                        $strPermission = "App.Soundblock.Project.File.Files.Update";
                        break;
                }

                $bnSoundblock = $bnSoundblock && is_authorized($objUser, $strSoundGroup, $strPermission, "soundblock");
            }
        }

        $bnOffice = is_authorized($objUser, "App.Office", "App.Office.Access", "office");

        if (!$bnOffice && !$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->colService->editFile($objRequest->all());
        $objCollections = $this->colService->findAllByProject($objRequest->project);

        return ($this->apiReply($objCollections, "Files were edited successfully.", Response::HTTP_OK));
    }

    public function updateTrackMeta(UpdateTrack $objRequest){
        $objUser = Auth::user();
        $bnSoundblock = is_authorized(
            $objUser,
            $this->authGroupService->findByProject($objRequest->project)->group_name,
            "App.Soundblock.Project.File.Music.Update",
            "soundblock"
        );

        if (!$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objFile = $this->fileService->find($objRequest->input("file_uuid"));

        if (is_null($objFile) || is_null($objFile->track)) {
            return ($this->apiReject("", "Track not found.", Response::HTTP_BAD_REQUEST));
        }

        $objTrack = $this->colService->updateTrackMeta($objFile->track, $objRequest->except("file_uuid", "track_uuid"), $objUser->user_id);

        return (
            $this->apiReply(
                $objTrack->load(
                    "language",
                    "languageVocals",
                    "primaryGenre",
                    "secondaryGenre",
                    "artists",
                    "contributors",
                    "lyrics",
                    "notes",
                    "publisher"
                ),
                "Track updated successfully.",
                Response::HTTP_OK
            )
        );
    }

    /**
     * @param OrganizeMusic $objRequest
     * @return object
     * @throws \Exception
     */
    public function organizeMusics(OrganizeMusic $objRequest) {
        $objUser = Auth::user();

        $strSoundGroup = $this->authGroupService->findByProject($objRequest->project)->group_name;
        $filesUuuids = collect($objRequest->input("files"))->pluck("file_uuid")->toArray();
        $fileCategories = $this->colService->getFileCategory($filesUuuids);
        $bnSoundblock = false;

        if (!empty($fileCategories)) {
            $bnSoundblock = true;

            foreach ($fileCategories as $category) {
                switch ($category) {
                    case Constant::MusicCategory:
                        $strPermission = "App.Soundblock.Project.File.Music.Update";
                        break;
                    case Constant::VideoCategory:
                        $strPermission = "App.Soundblock.Project.File.Video.Update";
                        break;
                    case Constant::MerchCategory:
                        $strPermission = "App.Soundblock.Project.File.Merch.Update";
                        break;
                    default:
                        $strPermission = "App.Soundblock.Project.File.Files.Update";
                        break;
                }

                $bnSoundblock = $bnSoundblock && is_authorized($objUser, $strSoundGroup, $strPermission, "soundblock");
            }
        }

        $bnOffice = is_authorized($objUser, "App.Office", "App.Office.Access", "office");

        if (!$bnOffice && !$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objCollection = $this->colService->organizeMusics($objRequest->all());
        $project = $objCollection->project->project_uuid;
        $objCollections = $this->colService->findAllByProject($project);

        return ($this->apiReply($objCollections, "Music were organized successfully.", Response::HTTP_OK));
    }

    /**
     * @param UpdateDirectory $objRequest
     * @return object
     * @throws \Exception
     */
    public function editDirectory(UpdateDirectory $objRequest) {
        $strGroupName = sprintf("App.Soundblock.Project.%s", $objRequest->input("project"));

        if (!is_authorized(Auth::user(), $strGroupName, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->colService->editDirectory($objRequest->all());
        $objCollections = $this->colService->findAllByProject($objRequest->project);

        return ($this->apiReply($objCollections, "Directory was edited successfully.", Response::HTTP_OK));
    }

    /**
     * @param RevertFile $objRequest
     * @return \Illuminate\Pagination\Paginator
     * @throws \Exception
     */
    public function revert(RevertFile $objRequest) {
        /** @var \App\Models\Soundblock\Collections\Collection */
        $collection = $this->colService->find($objRequest->collection, true);
        /** @var string */
        $strProject = $collection->project->project_uuid;

        $strGroupName = sprintf("App.Soundblock.Project.%s", $strProject);

        if (!is_authorized(Auth::user(), $strGroupName, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->colService->revert($objRequest->all());

        return ($this->colService->findAllByProject($strProject));
    }

    /**
     * @param RestoreFile $objRequest
     * @return object
     * @throws \Exception
     */
    public function restore(RestoreFile $objRequest) {
        $objUser = Auth::user();
        /** @var \App\Models\Soundblock\Collections\Collection */
        $collection = $this->colService->find($objRequest->collection, true);

        $strProject = $collection->project->project_uuid;
        $strGroupName = sprintf("App.Soundblock.Project.%s", $strProject);
        $filesUuuids = collect($objRequest->input("files"))->pluck("file_uuid")->toArray();
        $fileCategories = $this->colService->getFileCategory($filesUuuids);
        $bnSoundblock = false;

        if (!empty($fileCategories)) {
            $bnSoundblock = true;

            foreach ($fileCategories as $category) {
                switch ($category) {
                    case Constant::MusicCategory:
                        $strPermission = "App.Soundblock.Project.File.Music.Restore";
                        break;
                    case Constant::VideoCategory:
                        $strPermission = "App.Soundblock.Project.File.Video.Restore";
                        break;
                    case Constant::MerchCategory:
                        $strPermission = "App.Soundblock.Project.File.Merch.Restore";
                        break;
                    default:
                        $strPermission = "App.Soundblock.Project.File.Files.Restore";
                        break;
                }

                $bnSoundblock = $bnSoundblock && is_authorized($objUser, $strGroupName, $strPermission, "soundblock");
            }
        }

        if (!$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->colService->restore($objRequest->all());
        $objCollections = $this->colService->findAllByProject($strProject);

        return ($this->apiReply($objCollections, "", Response::HTTP_OK));
    }

    /**
     * @param DeleteFile $objRequest
     * @return object
     * @throws \Exception
     */
    public function deleteFiles(DeleteFile $objRequest) {
        $objUser = Auth::user();

        $strSoundGroup = sprintf("App.Soundblock.Project.%s", $objRequest->project);
        $filesUuuids = collect($objRequest->input("files"))->pluck("file_uuid")->toArray();
        $fileCategories = $this->colService->getFileCategory($filesUuuids);
        $bnSoundblock = false;

        if (!empty($fileCategories)) {
            $bnSoundblock = true;

            foreach ($fileCategories as $category) {
                switch ($category) {
                    case Constant::MusicCategory:
                        $strPermission = "App.Soundblock.Project.File.Music.Delete";
                        break;
                    case Constant::VideoCategory:
                        $strPermission = "App.Soundblock.Project.File.Video.Delete";
                        break;
                    case Constant::MerchCategory:
                        $strPermission = "App.Soundblock.Project.File.Merch.Delete";
                        break;
                    default:
                        $strPermission = "App.Soundblock.Project.File.Files.Delete";
                        break;
                }

                $bnSoundblock = $bnSoundblock && is_authorized($objUser, $strSoundGroup, $strPermission, "soundblock");
            }
        }

        $bnOffice = is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office");

        if (!$bnOffice && !$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->colService->deleteFiles($objRequest->all());
        $objCollections = $this->colService->findAllByProject($objRequest->project);

        return ($this->apiReply($objCollections, "Files deleted successfully.", Response::HTTP_OK));
    }

    /**
     * @param DeleteDirectory $objRequest
     * @param string $project
     * @param string $dir
     * @return object
     * @throws \Exception
     */
    public function deleteDirectory(DeleteDirectory $objRequest, string $project, string $dir) {
        $strSoundGroup = sprintf("App.Soundblock.Project.%s", $objRequest->project);

        $bnOffice = is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office");
        $bnSoundblock = is_authorized(Auth::user(), $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock");

        if (!$bnOffice && !$bnSoundblock) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objRequest->request->add(["project" => $project, "directory" => $dir]);
        $this->colService->deleteDirectory($objRequest->all());
        $objCollections = $this->colService->findAllByProject($objRequest->project);

        return ($this->apiReply($objCollections, "Directory was deleted successfully.", Response::HTTP_OK));
    }
}
