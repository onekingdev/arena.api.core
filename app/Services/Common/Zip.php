<?php

namespace App\Services\Common;

use Log;
use Util;
use Constant;
use Exception;
use ZipArchive;
use ArrayObject;
use App\Models\Users\User;
use App\Contracts\Core\Sox;
use App\Facades\Core\Converter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use App\Events\Soundblock\OnHistory;
use App\Helpers\Filesystem\Filesystem;
use App\Helpers\Filesystem\Soundblock;
use Illuminate\Support\Facades\Storage;
use App\Jobs\Soundblock\Ledger\FileLedger;
use App\Jobs\Soundblock\Ledger\TrackLedger;
use App\Contracts\Soundblock\Data\IsrcCodes;
use App\Contracts\Soundblock\Audit\Diskspace;
use App\Jobs\Soundblock\Projects\TrackHistory;
use App\Jobs\Soundblock\Ledger\CollectionLedger;
use App\Services\Soundblock\File as FileService;
use App\Services\Soundblock\Ledger\TrackLedger as TrackLedgerService;
use App\Services\Soundblock\Ledger\CollectionLedger as CollectionLedgerService;
use League\Flysystem\{AwsS3v3\AwsS3Adapter, FileNotFoundException, UnreadableFileException};
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;
use App\Models\Soundblock\{Collections\Collection, Files\File, Projects\Project, Artist as ArtistModel};
use App\Repositories\{
    Soundblock\Collection as CollectionRepository,
    Soundblock\File as FileRepository,
    Soundblock\TrackHistory as TrackHistoryRepository
};

class Zip {
    protected $ffprobe;

    protected $ProjectImage = "artwork.png";

    protected $availableExtensions = [
        "(jpg)", "(bmp)", "(jpeg)", "(gif)",
    ];
    protected $track = 0;
    protected $fileRepo;
    protected $colRepo;
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    private \Illuminate\Filesystem\FilesystemAdapter $soundblockAdapter;
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    private \Illuminate\Filesystem\FilesystemAdapter $officeAdapter;
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    private \Illuminate\Filesystem\FilesystemAdapter $localAdapter;
    /** @var FileService */
    private FileService $fileService;
    /** @var Diskspace */
    private Diskspace $diskspaceAuditService;
    /** @var IsrcCodes */
    private IsrcCodes $isrcServices;
    /** @var \App\Contracts\Core\Sox */
    private Sox $soxService;
    /**
     * @var TrackHistoryRepository
     */
    private TrackHistoryRepository $trackHistoryRepo;

    /**
     * @param FileRepository $fileRepo
     * @param CollectionRepository $colRepo
     * @param FileService $fileService
     * @param Sox $soxService
     * @param Diskspace $diskspaceAuditService
     * @param IsrcCodes $isrcServices
     * @param TrackHistoryRepository $trackHistoryRepo
     */
    public function __construct(FileRepository $fileRepo, CollectionRepository $colRepo, FileService $fileService,
                                Sox $soxService, Diskspace $diskspaceAuditService, IsrcCodes $isrcServices,
                                TrackHistoryRepository $trackHistoryRepo) {
        $this->initFileSystemAdapter();

        $this->track = 0;
        $this->fileRepo = $fileRepo;
        $this->colRepo = $colRepo;
        $this->fileService = $fileService;
        $this->soxService = $soxService;
        $this->isrcServices = $isrcServices;
        $this->diskspaceAuditService = $diskspaceAuditService;
        $this->trackHistoryRepo = $trackHistoryRepo;
    }

    /**
     * @return void
     */
    private function initFileSystemAdapter() {
        if (env("APP_ENV") == "local") {
            $this->soundblockAdapter = Storage::disk("local");
            $this->officeAdapter = Storage::disk("local");
        } else {
            $this->soundblockAdapter = bucket_storage("soundblock");
            $this->officeAdapter = bucket_storage("office");
        }

        $this->localAdapter = Storage::disk("local");
    }

    /**
     * Get the path of file uploaded.
     * @param UploadedFile $file
     * @param string $name
     * @param string|null $path
     *
     * @return array|null $path
     */
    public function putFile(UploadedFile $file, string $name, ?string $path = null): ?array {
        if (is_null($path)) {
            $path = Soundblock::upload_path();
        }

        if ($this->soundblockAdapter->exists($path . Constant::Separator . $name)) {
            $this->soundblockAdapter->delete($path . Constant::Separator . $name);
        }

        $storagePath = $this->soundblockAdapter->putFileAs($path, $file, $name);

        return ($storagePath !== false ? [$name, $storagePath] : null);
    }

    /**
     * @param string $src
     * @param string $dest
     *
     * @return bool
     */
    public function moveFile($src, $dest): bool {
        if ($this->soundblockAdapter->exists($src)) {
            $this->soundblockAdapter->move($src, $dest);
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * @param string $path
     * @param UploadedFile $objFile
     * @param bool $bnChg
     * @return string
     */
    public function upload(string $path, UploadedFile $objFile, bool $bnChg = false): string {
        $path = $this->saveFile($path, $objFile, $bnChg);

        return ($this->soundblockAdapter->url($path));
    }

    /**
     * @param string $path
     * @param UploadedFile $objFile
     * @param bool $bnChg
     * @return string
     */
    public function saveFile(string $path, UploadedFile $objFile, bool $bnChg = false): string {
        if ($this->soundblockAdapter->exists($path)) {
            $this->soundblockAdapter->delete($path);
        }

        if ($bnChg) {
            $fileName = Util::random_str() . "." . $objFile->getClientOriginalExtension();
            $this->soundblockAdapter->putFileAs($path, $objFile, $fileName);
        } else {
            $fileName = $objFile->getClientOriginalName();
            $this->soundblockAdapter->putFileAs($path, $objFile, $objFile->getClientOriginalName());
        }

        return ($path . Constant::Separator . $fileName);
    }

    public function putArtwork(Project $objProject, $objFile) {
        $artworkCode = $this->generateRandomCode();
        $objProject->artwork_name = $artworkCode;
        $objProject->save();

        $artworkPath = Soundblock::project_path($objProject);

        return ($this->saveAvatar("public/" . $artworkPath, $objFile));
    }

    public function generateRandomCode(int $length = 5) {
        $intCode = hexdec(bin2hex(random_bytes($length)));

        if ($intCode < PHP_INT_MIN && $intCode > PHP_INT_MAX) {
            if ($length === 1) {
                return rand(0, PHP_INT_MAX);
            }

            return $this->generateRandomCode(--$length);
        }

        return $intCode;
    }

    /**
     * @param string $path
     * @param UploadedFile $uploadedFile
     * @param string $saveName
     * @return string|null
     */
    public function saveAvatar(string $path, UploadedFile $uploadedFile, string $saveName = null): ?string {
        $fileName = $saveName ? (strpos($saveName, ".png") !== false ? $saveName : $saveName . ".png") :
            config("constant.soundblock.project_avatar");

        $ext = $uploadedFile->getClientOriginalExtension();

        if (Util::lowerLabel($ext) !== "png") {
            $uploadedFile = Converter::convertImageToPng($uploadedFile->getPathname());
        }

        if ($this->soundblockAdapter->exists($path . "/" . $fileName)) {
            $this->soundblockAdapter->delete($path . "/" . $fileName);
        }

        if ($this->soundblockAdapter->putFileAs($path, $uploadedFile, $fileName, "public")) {
            return ($fileName);
        }

        return null;
    }

    /**
     * @param Project $project
     * @param string $artwork
     * @return string
     * @throws FileNotFoundException
     */
    public function moveArtwork(Project $project, string $artwork): string {
        $srcPath = Util::draft_artwork_path_from_url($artwork);
        $project->artwork_name = Util::generateRandomCode();
        $project->save();

        if (!$this->soundblockAdapter->exists($srcPath)) {
            throw new FileNotFoundException($srcPath);
        }

        $destPath = Soundblock::upload_project_artwork_path($project);

        if ($this->soundblockAdapter->exists($destPath)) {
            $this->soundblockAdapter->delete($destPath);
        }

        $this->soundblockAdapter->move($srcPath, $destPath);

        return ($destPath);
    }

    /**
     * @param ArtistModel $objArtist
     * @return string
     * @throws FileNotFoundException
     */
    public function moveArtistAvatar(ArtistModel $objArtist): string {
        $avatarDraftPath = "public/" . Soundblock::artists_draft_avatar_path($objArtist);

        if (!$this->soundblockAdapter->exists($avatarDraftPath)) {
            return false;
        }

        $avatarPath = "public/" . Soundblock::artists_avatar_path($objArtist);

        if ($this->soundblockAdapter->exists($avatarPath)) {
            $this->soundblockAdapter->delete($avatarPath);
        }

        $this->soundblockAdapter->move($avatarDraftPath, $avatarPath);
        $size = $this->soundblockAdapter->getSize($avatarPath);

        return ($size);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     *
     * @return string
     * @throws Exception
     */
    public function putDraftArtwork($uploadedFile) {
        $artworkPath = Util::draft_artwork_path();

        return ($this->saveAvatar($artworkPath, $uploadedFile, Util::uuid()));
    }

    /**
     * @param string $fileName
     * @param array $arrFiles
     * @param string $strComment
     * @param Project $project
     * @param User $user
     * @return Collection
     * @throws FileNotFoundException
     */
    public function unzipProject(string $fileName, array $arrFiles, string $strComment, Project $project, User $user): Collection {
        if (!$this->soundblockAdapter->exists(Soundblock::upload_path($fileName))) {
            throw new FileNotFoundException(Soundblock::upload_path($fileName), 400);
        }

        $extractPath = $this->extract($fileName);
        $collection = $this->handleProjectFiles($extractPath, $arrFiles, $strComment, $project, $user);
        $this->soundblockAdapter->deleteDirectory($extractPath);
        $this->localAdapter->deleteDirectory($extractPath);

        return ($collection);
    }

    /**
     * @param string $fileName
     * @return string
     * @throws Exception
     */
    public function extract(string $fileName): string {
        $extension = Util::file_extension($fileName);

        if ($extension !== "zip") {
            throw new Exception("Not zip file", 400);
        }

        $zip = new ZipArchive();

        $uploadedFilePath = Soundblock::upload_path($fileName);
        $readStream = $this->soundblockAdapter->readStream($uploadedFilePath);
        $writeStream = $this->localAdapter->writeStream($uploadedFilePath, $readStream);

        if (!$writeStream) {
            throw new \Exception("Local Copy Wasn't Created.");
        }

        $uploadZipFile = $this->localAdapter->path($uploadedFilePath);

        $extractPath = Soundblock::unzip_path();

        if ($zip->open($uploadZipFile) !== true) {
            throw new UnreadableFileException();
        }

        $zip->extractTo($this->localAdapter->path($extractPath));
        $zip->close();

        // Remove Uploaded Zip File
        $this->localAdapter->delete($uploadedFilePath);
        $this->soundblockAdapter->delete($uploadedFilePath);

        //remove __MACOSX folder
        if ($this->localAdapter->exists($extractPath . Constant::Separator . Constant::__MACOSX)) {
            $this->localAdapter->deleteDirectory($extractPath . Constant::Separator . Constant::__MACOSX);
        }

        $arrLocalFiles = $this->localAdapter->allFiles($extractPath);

        foreach ($arrLocalFiles as $localFile) {
            $localProcessedFile = $localFile;
            $strFileExtension = pathinfo($localFile, PATHINFO_EXTENSION);

            if ($strFileExtension === "wav") {
                try {
                    $localProcessedFile = $this->soxService->convert($this->localAdapter->path($localFile));
                } catch (\Exception $exception) {
                    info($exception->getMessage());
                }
            }

            if ($localProcessedFile !== $localFile) {
                $localProcessedFile = substr($localFile, 0, strpos($localFile, ".$strFileExtension")) . "_processed.$strFileExtension";
            }

            $this->soundblockAdapter->writeStream($localFile, $this->localAdapter->readStream($localProcessedFile));
        }

        $this->soundblockAdapter->delete($uploadedFilePath);

        Log::info("extract-path", [$extractPath]);

        return ($extractPath);
    }

    /**
     * @param string $extractPath
     * @param array $arrFiles
     * @param string $strComment
     * @param Project $project
     * @param User $user
     * @return Collection
     * @throws FileNotFoundException
     *
     */
    protected function handleProjectFiles(string $extractPath, array $arrFiles, string $strComment, Project $project, User $user): Collection {
        $arrStampChanged = [
            "flag_changed_music"         => false,
            "flag_changed_video"         => false,
            "flag_changed_merchandising" => false,
            "flag_changed_other"         => false,
        ];

        $arrPreSaved = [];
        $collection = $this->processRefCollection($project, $user, $strComment);
        $arrCollectionFile = collect();

        foreach ($arrFiles as $arrFile) {
            if ((isset($arrFile["track"]["org_file_sortby"]) || isset($arrFile["track"]["file_uuid"])) && $arrFile["file_category"] == "video") {
                if (isset($arrFile["track"]["org_file_sortby"])) {
                    $musicFile = $this->findFileByRelativePath($arrFile["track"]["org_file_sortby"], $arrFiles);
                    if (!is_null($musicFile)) {
                        $arrPreSaved [] = $musicFile;
                        $arrMusicParam = $this->handleFile($extractPath, $musicFile, $project, $collection);
                        $music = $this->fileRepo->createInCollection($arrMusicParam, $collection, $user);
                        $arrCollectionFile->push($music);
                        $arrFileParam = $this->handleFile($extractPath, $arrFile, $project, $collection, $music);
                    } else {
                        $arrFileParam = $this->handleFile($extractPath, $arrFile, $project, $collection);
                    }
                } else {
                    $music = $this->fileRepo->find($arrFile["track"]["file_uuid"], true);
                    $arrFileParam = $this->handleFile($extractPath, $arrFile, $project, $collection, $music);
                }
            } else {
                if (!is_null($this->findFileByRelativePath($arrFile["org_file_sortby"], $arrPreSaved)))
                    continue;
                $arrFileParam = $this->handleFile($extractPath, $arrFile, $project, $collection);
            }

            switch ($arrFile["file_category"]) {
                case Constant::MusicCategory:
                    $arrStampChanged["flag_changed_music"] = true;
                    break;
                case Constant::VideoCategory:
                    $arrStampChanged["flag_changed_video"] = true;
                    break;
                case Constant::MerchCategory:
                    $arrStampChanged["flag_changed_merchandising"] = true;
                    break;
                case Constant::FilesCategory:
                default:
                    $arrStampChanged["flag_changed_other"] = true;
            }

            $file = $this->fileRepo->createInCollection($arrFileParam, $collection, $user);

            $this->diskspaceAuditService->save($project, $arrFileParam["file_size"]);

            if ($arrFile["file_category"] === Constant::MusicCategory) {
                $arrHistory = [];
                $objTrack = $file->track;
                $objIsrc = $this->isrcServices->getUnused();

                $objTrack->track_isrc = $objIsrc->data_isrc;
                $objTrack->save();

                $this->isrcServices->useIsrc($objIsrc);

                if ($arrFileParam["track_duration"] <= 30) {
                    $arrCodes = [0, $arrFileParam["track_duration"]];
                } elseif ($arrFileParam["track_duration"] >= 60) {
                    $arrCodes = [30, 60];
                } else {
                    $arrCodes = [$arrFileParam["track_duration"] - 30, $arrFileParam["track_duration"]];
                }

                $this->fileService->addTimeCodes($file, ...$arrCodes);

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

                dispatch(new TrackLedger($objTrack, TrackLedgerService::CREATE_EVENT))->onQueue("ledger");
            }

            dispatch(new FileLedger($file, Soundblock::project_file_path($project, $file)))->onQueue("ledger");

            $arrCollectionFile->push($file);
        }

        $collection->update($arrStampChanged);
        $collection = $this->processRefCollectionFiles($collection, $user, $arrCollectionFile);

        dispatch(new CollectionLedger($collection, CollectionLedgerService::CREATE_EVENT))->onQueue("ledger");

        return ($collection);
    }

    /**
     * @param Project $objProject
     * @param string $strComment
     * @return Collection
     * @return Collection
     */
    protected function processRefCollection(Project $objProject, User $user, string $strComment): Collection {
        $latestCollection = $this->colRepo->findLatestByProject($objProject);
        $newCollection = $this->colRepo->create([
            "project_id"                 => $objProject->project_id,
            "project_uuid"               => $objProject->project_uuid,
            "collection_comment"         => $strComment,
            Collection::STAMP_CREATED_BY => $user->user_id,
            Collection::STAMP_UPDATED_BY => $user->user_id,
        ]);
        if ($latestCollection) {
            //attach old resources of old collection.
            $newCollection = $this->colRepo->attachResources($newCollection, $latestCollection, null, null, $user);
        }

        return ($newCollection);
    }

    /**
     * @param string $strExt
     * @return string
     */
    public function getFileCategory(string $strExt): string {
        $strExt = strtolower($strExt);
        if (array_search($strExt, Constant::MusicExtension) !== false) {
            return (Constant::MusicCategory);
        } else if (array_search($strExt, Constant::VideoExtension) !== false) {
            return (Constant::VideoCategory);
        } else if (array_search($strExt, Constant::MerchExtension) !== false) {
            return (Constant::MerchCategory);
        }

        return (Constant::FilesCategory);
    }

    /**
     * @param string $path
     * @param array $arrFiles
     * @return array
     */
    protected function findFileByRelativePath(string $path, array $arrFiles): ?array {
        foreach ($arrFiles as $arrFile) {
            if ($arrFile["org_file_sortby"] == $path)
                return ($arrFile);
        }
        return (null);
    }

    /**
     * @param string $extractPath
     * @param array $arrParam
     * @param Project $project
     * @param Collection $collection
     * @param File|null $objMusic
     * @return array
     * @throws FileNotFoundException
     */
    protected function handleFile(string $extractPath, array $arrParam, Project $project, Collection $collection, ?File $objMusic = null): ?array {
        $filePath = $extractPath . Constant::Separator . $arrParam["org_file_sortby"];

        if (!$this->soundblockAdapter->exists($filePath)) {
            throw new FileNotFoundException($filePath, 417);
        }

        $dest = Soundblock::project_files_path($project);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $physicalName = Util::uuid();

        if ($this->soundblockAdapter->getDriver()->getAdapter() instanceof AwsS3Adapter) {
            $md5File = md5_file($this->soundblockAdapter->temporaryUrl($filePath, now()->addMinute()));
        } else {
            $md5File = md5_file($this->soundblockAdapter->path($filePath));
        }

        $this->soundblockAdapter->move($filePath, $dest . Constant::Separator . $physicalName . "." . $extension);

        $fileExt = pathinfo($arrParam["file_name"], PATHINFO_EXTENSION);
        $arrParam["file_name"] = Util::uuid() . "." . $fileExt;

        $arrFile = [
            "file_uuid"      => $physicalName,
            "file_name"      => $arrParam["file_name"],
            "file_path"      => Util::ucfLabel($arrParam["file_category"]),
            "file_title"     => $arrParam["file_title"],
            "file_sortby"    => Util::ucfLabel($arrParam["file_category"]) . Constant::Separator . $arrParam["file_name"],
            "file_category"  => $arrParam["file_category"],
            "file_size"      => $this->soundblockAdapter->size($dest . Constant::Separator . $physicalName . "." . $extension),
            "file_md5"       => $md5File,
            "file_extension" => $extension,
        ];

        switch ($arrParam["file_category"]) {
            case Constant::MusicCategory:
            {
                $this->track++;
                $duration = rand(200, 350);
                if (isset($arrParam["track_number"])) {
                    $arrFile["track_number"] = intval($arrParam["track_number"]);
                    $this->track = $arrParam["track_number"];
                } else {
                    $arrFile["track_number"] = $this->colRepo->getTracks($collection)->count() + 1;
                }
                $arrFile["track_duration"]              = $duration;
                $arrFile["copyright_name"]              = $arrParam["copyright_name"] ?? null;
                $arrFile["copyright_year"]              = $arrParam["copyright_year"] ?? null;
                $arrFile["recording_location"]          = $arrParam["recording_location"] ?? null;
                $arrFile["track_language"]              = $arrParam["track_language"] ?? null;
                $arrFile["track_language_vocals"]       = $arrParam["track_language_vocals"] ?? null;
                $arrFile["track_volume_number"]         = $arrParam["track_volume_number"] ?? null;
                $arrFile["track_release_date"]          = $arrParam["track_release_date"] ?? null;
                $arrFile["track_artist"]                = $arrParam["track_artist"] ?? null;
                $arrFile["track_version"]               = $arrParam["track_version"] ?? null;
                $arrFile["country_recording"]           = $arrParam["country_recording"] ?? null;
                $arrFile["country_commissioning"]       = $arrParam["country_commissioning"] ?? null;
                $arrFile["rights_holder"]               = $arrParam["rights_holder"] ?? null;
                $arrFile["rights_owner"]                = $arrParam["rights_owner"] ?? null;
                $arrFile["rights_contract"]             = $arrParam["rights_contract"] ?? null;
                $arrFile["flag_track_explicit"]         = $arrParam["flag_track_explicit"] ?? null;
                $arrFile["flag_track_instrumental"]     = $arrParam["flag_track_instrumental"] ?? null;
                $arrFile["flag_allow_preorder"]         = $arrParam["flag_allow_preorder"] ?? null;
                $arrFile["flag_allow_preorder_preview"] = $arrParam["flag_allow_preorder_preview"] ?? null;
                $arrFile["preview_start"]               = $arrParam["preview_start"] ?? null;
                $arrFile["preview_stop"]                = $arrParam["preview_stop"] ?? null;
                $arrFile["artists"]                     = $arrParam["artists"] ?? null;
                $arrFile["contributors"]                = $arrParam["contributors"] ?? null;
                $arrFile["publishers"]                  = $arrParam["publishers"] ?? null;
                $arrFile["genre_primary"]               = $arrParam["genre_primary"] ?? null;
                $arrFile["genre_secondary"]             = $arrParam["genre_secondary"] ?? null;

                break;
            }
            case Constant::VideoCategory:
            {
                if (!is_null($objMusic)) {
                    $arrFile["music_id"] = $objMusic->file_id;
                    $arrFile["music_uuid"] = $objMusic->file_uuid;
                }
                break;
            }
            default:
                break;
        }

        return ($arrFile);
    }

    /**
     * @param Collection $collection
     * @param User $user
     * @param \Illuminate\Database\Eloquent\Collection $arrFile
     *
     * @return Collection
     */
    private function processRefCollectionFiles(Collection $collection, User $user, $arrFile): Collection {
        $historyFiles = $arrFile->map(function ($file) {
            return ([
                "new" => $file,
            ]);
        });
        event(new OnHistory($collection, "Created", $historyFiles, $user));

        return ($collection);
    }

    public function downloadProject(Collection $collection) {
        $zipFilePath = "";

        return ($this->download($zipFilePath));
    }

    /**
     * @param string $path
     * @return mixed
     * @throws FileNotFoundException
     */
    protected function download(string $path) {
        if (!$this->soundblockAdapter->exists($path)) {
            throw new FileNotFoundException($path, 400);
        }

        return ($this->soundblockAdapter->download($path));
    }

    /**
     * @param Collection $collection
     * @param User|null $objUser
     * @return string
     * @throws Exception
     */
    public function zipCollection(Collection $collection, ?User $objUser = null): string {
        /** @var \Illuminate\Database\Eloquent\Collection */
        $files = $collection->files;
        /** @var \Illuminate\Database\Eloquent\Collection */
        $directories = $collection->directories;
        $srcPath = Soundblock::project_files_path($collection->project);

        $arrDirectories = [];
        if ($directories->count() > 0) {
            $arrDirectories = $this->getDirectoryParams($directories);
        }
        $arrFiles = $this->getFileParams($srcPath, $files);

        if (empty($arrDirectories) && empty($arrFiles))  {
            throw new Exception("Any files or directory not exists on storage.", 417);
        }

        return ($this->zip(Soundblock::download_zip_path(Util::uuid(), $objUser), $arrFiles, $arrDirectories));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $directories
     * @return array
     * @throws Exception
     *
     */
    protected function getDirectoryParams($directories): array {
        $collectionDirectories = collect();
        $arrDirectories = collect();
        foreach ($directories as $directory) {
            if ($collectionDirectories->isEmpty()) {
                $collectionDirectories->push($directory);
                $arrDirectories->push();
            } else {
                $directoryParam = Util::make_directory_suffix($directory->toArray(), $collectionDirectories);
                $arrDirectories->push($directoryParam);
            }
        }

        return ($arrDirectories->all());
    }

    /**
     * @param string $src
     * @param \Illuminate\Database\Eloquent\Collection $files
     * @return array $arrFiles
     * @throws Exception
     *
     */
    protected function getFileParams(string $src, $files): array {
        $collectionFiles = collect();
        $arrFiles = collect();
        $files = $files->reject(function ($item) use ($src) {
            $objFile = $this->fileRepo->find($item->file_uuid);

            if (is_null($objFile)) {
                return false;
            }

            $strExtension = Util::file_extension($objFile->file_name);

            return (!$this->soundblockAdapter->exists($src . Constant::Separator . $item->file_uuid . "." . $strExtension));
        });

        foreach ($files as $file) {
            if ($collectionFiles->isEmpty()) {
                $collectionFiles->push($file);
                $arrFiles->push($file->toArray());
            } else {
                $param = Util::make_suffix($file->toArray(), $collectionFiles);
                $arrFiles->push($param);
            }
        }

        $arrFiles = $arrFiles->map(function ($item) use ($src) {
            $objFile = $this->fileRepo->find($item["file_uuid"]);
            $strPath = $src . Constant::Separator . $item["file_uuid"];

            if (is_object($objFile)) {
                $strExtension = Util::file_extension($objFile->file_name);
                $strPath .= ".{$strExtension}";
            }

            $item = array_merge($item, ["real_path" => $strPath]);
            return ($item);
        });

        return ($arrFiles->all());
    }

    /**
     * @param string $zipPath
     * @param array $arrFiles
     * @param array|null $arrDirectories
     * @return string
     */
    public function zip(string $zipPath, array $arrFiles, ?array $arrDirectories = null): ?string {
        $zip = new ZipArchive();

        if ($this->localAdapter->exists($zipPath)) {
            $this->localAdapter->delete($zipPath);
        }

        if (!$this->localAdapter->exists(Soundblock::download_path())) {
            $this->localAdapter->makeDirectory(Soundblock::download_path());
        }

        if ($zip->open($this->localAdapter->path($zipPath),ZipArchive::CREATE)) {
            if (!is_null($arrDirectories)) {
                //Add empty directory
                foreach ($arrDirectories as $directory) {
                    $zip->addEmptyDir($directory["directory_sortby"]);
                }
            }

            $arrDeletePath = [];

            foreach ($arrFiles as $file) {
                if ($this->soundblockAdapter->exists($file["real_path"])) {
                    $this->localAdapter->delete($file["real_path"]);
                    $this->localAdapter->writeStream($file["real_path"], $this->soundblockAdapter->readStream($file["real_path"]));
                    $zip->addFile($this->localAdapter->path($file["real_path"]), $file["file_sortby"]);
                    $arrDeletePath[] = $file["real_path"];
                }
            }

            $res = $zip->close();

            foreach ($arrDeletePath as $path) {
                $this->localAdapter->delete($path);
            }

            if ($res === true) {
                $readStream = $this->localAdapter->readStream($zipPath);
                $this->soundblockAdapter->writeStream($zipPath, $readStream);
                $this->localAdapter->delete($zipPath);

                return ($zipPath);
            } else {
                throw new CannotWriteFileException();
            }
        } else {
            throw new CannotWriteFileException();
        }
    }

    /**
     * @param Collection $collection
     * @param \Illuminate\Database\Eloquent\Collection $files
     * @param User|null $objUser
     * @return string
     *
     * @throws FileNotFoundException
     */
    public function zipFiles(Collection $collection, $files, ?User $objUser = null): string {
        $srcPath = Soundblock::project_files_path($collection->project);
        $arrFiles = $this->getFileParams($srcPath, $files);

        if (empty($arrFiles)) {
            throw new FileNotFoundException("Any file not exists on storage.", 417);
        }


        if (!$this->localAdapter->exists(Soundblock::download_path() . Filesystem::DS . $objUser->user_uuid)) {
            $this->localAdapter->makeDirectory(Soundblock::download_path() . Filesystem::DS . $objUser->user_uuid);
        }

        return ($this->zip(Soundblock::download_zip_path(Util::uuid(), $objUser), $arrFiles));
    }

    /**
     * Copy files from "form" to "to"
     * @param array $arrFiles
     * @param string $from
     * @param string $to
     *
     * @return void
     */
    public function copyFiles($arrFiles, $from, $to) {
        if ($this->soundblockAdapter->exists($to)) {
            $this->soundblockAdapter->deleteDirectory($to);
        }
        $this->soundblockAdapter->makeDirectory($to);

        foreach ($arrFiles as $file) {
            $matchedPos = strpos($file, $from);
            $relativePath = substr($file, $matchedPos);
            $this->soundblockAdapter->copy($file, $to . Constant::Separator . $relativePath);
        }
    }

    public function copyFile($file, $dest) {
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $newFileBaseName = pathinfo($file, PATHINFO_BASENAME);
        $fileExt = pathinfo($file, PATHINFO_EXTENSION);
        $count = $this->countOfDuplicatedFiles($dest, $fileName, $fileExt);

        if ($count != 0) {
            $newFileBaseName = $fileName . "(" . ($count + 1) . ")" . $fileExt;
        }
        $this->soundblockAdapter->copy($file, $dest . Constant::Separator . $newFileBaseName);
        return ($newFileBaseName);
    }

    /**
     * @param string $strDestDir
     * @param string $strFileName
     * @param string $strExtension
     * @return int
     */
    public function countOfDuplicatedFiles(string $strDestDir, string $strFileName, string $strExtension): int {
        $allFiles = $this->soundblockAdapter->allFiles($strDestDir);
        $count = 0;

        foreach ($allFiles as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if (($filename === $strFileName || strpos($filename, $strFileName) !== false) && $extension === $strExtension)
                $count++;
        }

        return ($count);
    }

    public function zipMusic(Collection $collection) {
        $zip = new ZipArchive();
        $strProjectPath = Soundblock::project_files_path($collection->project);
        $strZipPath = Soundblock::deployment_project_zip_path($collection);

        if ($this->localAdapter->exists($strZipPath)) {
            $this->localAdapter->delete($strZipPath);
        }

        if (!$this->localAdapter->exists(Soundblock::deployment_project_path($collection->project))) {
            $this->localAdapter->makeDirectory(Soundblock::deployment_project_path($collection->project));
        }

        $arrMusic = $collection->tracks()->get();
        $objArtists = collect();

        if ($zip->open($this->localAdapter->path($strZipPath), ZipArchive::CREATE)) {
            foreach ($arrMusic as $music) {
                $objArtists->push($music->artists);
                $objFile = $music->file;
                $strRealPath = $strProjectPath . Constant::Separator . $objFile->file_uuid . "." .
                    pathinfo($objFile->file_name, PATHINFO_EXTENSION);

                if ($this->soundblockAdapter->exists($strRealPath)) {
                    $strTrackNumberPrefix = str_pad($music->track_number, 3, 0, STR_PAD_LEFT);
                    $strTrackVolumeNumberPrefix = str_pad($music->track_volume_number, 2, 0, STR_PAD_LEFT);
                    $strFileName = "{$strTrackVolumeNumberPrefix} - {$strTrackNumberPrefix} - {$music->file->file_title} - {$music->file_uuid}.wav";
                    $zip->addFromString("tracks/" . $strFileName, $this->soundblockAdapter->get($strRealPath));
                }
            }

            if ($this->soundblockAdapter->exists("public/" . Soundblock::project_artwork_path($collection->project))) {
                $projectArtworkPath = $this->soundblockAdapter->get("public/" . Soundblock::project_artwork_path($collection->project));
                $zip->addFromString("images/Project - " . $collection->project->project_title . " - " . $collection->project->project_uuid . ".png", $projectArtworkPath);
            }

            $objArtists = $objArtists->flatten(1);

            if (!empty($objArtists)) {
                $objArtists = $objArtists->unique("artist_uuid");
                foreach ($objArtists as $objArtist) {
                    $artistAvatarPath = "public/" . Soundblock::artists_avatar_path($objArtist);
                    if ($this->soundblockAdapter->exists($artistAvatarPath)) {
                        $zip->addFromString("images/" . $objArtist->avatar_name, $artistAvatarPath);
                    }
                }
            }

            $res = $zip->close();

            if ($res === true) {
                $readStream = $this->localAdapter->readStream($strZipPath);
                $this->officeAdapter->writeStream("public/soundblock/" . $strZipPath, $readStream, ["visibility" => "public"]);
                $this->localAdapter->delete($strZipPath);

                return ("soundblock/" . $strZipPath);
            } else {
                throw new CannotWriteFileException();
            }
        } else {
            throw new CannotWriteFileException();
        }
    }

    /**
     * Rename the name of file if exists already.
     * @param array $arrFiles
     * @return array $arrFiles
     */
    protected function renameIfExists(array $arrFiles): array {
        $count = 0;

        for ($i = 0; $i < count($arrFiles); $i++) {
            $objArray = new ArrayObject($arrFiles);
            $arrTempFiles = $objArray->getArrayCopy();
            array_splice($arrTempFiles, $i, 1);

            for ($j = 0; $j < count($arrTempFiles); $j++) {
                if ($arrFiles[$i]["file_sortby"] == $arrTempFiles[$j]["file_sortby"]) {
                    $count++;
                }
            }
            if ($count > 0) {
                $fileName = pathinfo($arrFiles[$i]["file_name"], PATHINFO_FILENAME);
                $fileExt = pathinfo($arrFiles[$i]["file_name"], PATHINFO_EXTENSION);
                $arrFiles[$i]["file_sortby"] = $arrFiles[$i]["file_path"] . Constant::Separator . $fileName . "(" . $count . ")." . $fileExt;

                return ($this->renameIfExists($arrFiles));
            }
        }

        return ($arrFiles);
    }

    /**
     * @param string $zipPath
     * @param string $fileName
     * @param string $filePath
     * @return bool
     */
    public function addFileToExistingZip(string $zipPath, string $fileName, string $filePath): bool{
        $zip = new ZipArchive;

        if ($zip->open($this->soundblockAdapter->path($zipPath))) {
            $zip->addFile($this->soundblockAdapter->path($filePath), $fileName);
            $zip->close();

            return (true);
        } else {
            throw new CannotWriteFileException();
        }
    }
}
