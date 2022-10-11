<?php

namespace App\Services\Soundblock;

use Util;
use App\Helpers\Filesystem\Soundblock;
use App\Repositories\Soundblock\FileHistory;
use App\Repositories\Soundblock\File as FileRepository;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use App\Models\{
    Soundblock\Files\File as FileModel,
    Soundblock\Track,
    Soundblock\Files\FileVideo,
    Soundblock\Files\FileMerch,
    Soundblock\Files\FileOther,
    Soundblock\Files\Directory,
    Soundblock\Projects\Project as ProjectModel,
};

class File {

    /** @var FileRepository */
    private FileRepository $fileRepo;
    /** @var FileHistory */
    private FileHistory $fileHistoryRepo;

    /**
     * File constructor.
     * @param FileRepository $file
     * @param FileHistory $fileHistoryRepo
     */
    public function __construct(FileRepository $file, FileHistory $fileHistoryRepo) {
        $this->fileRepo = $file;
        $this->fileHistoryRepo = $fileHistoryRepo;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id) {
        return ($this->fileRepo->findById($id));
    }

    public function getTimecodes(FileModel $objFile): array {
        $objMusic = $objFile->track;

        if (is_null($objMusic)) {
            throw new \Exception("Not A Music File.");
        }

        return [
            "preview_start" => $objMusic->preview_start,
            "preview_stop"  => $objMusic->preview_stop,
        ];
    }

    /**
     * @param FileModel $objFile
     * @return \App\Models\Soundblock\Files\FileHistory
     */
    public function getLatestFileHistory(FileModel $objFile): ?\App\Models\Soundblock\Files\FileHistory {
        return $this->fileHistoryRepo->getLatestHistoryByFile($objFile);
    }

    public function getTrackHistory(Track $objTrack){
        $objTrackHistory = $objTrack->history;

        return ($objTrackHistory->sortByDesc("stamp_created"));
    }

    /**
     * Create a file
     * @param array $arrFile
     * @return FileModel
     * @throws \Exception
     */
    public function create($arrFile): FileModel {
        $objFile = new FileModel();

        $objFile = $this->update($objFile, $arrFile);

        switch ($arrFile["file_category"]) {
            case "music":
            {
                $this->insertMusicRecord($objFile, $arrFile);
                break;
            }
            case "video":
            {
                $this->insertVideoRecord($objFile, $arrFile);
                break;
            }
            case "merch":
            {
                $this->insertMerchRecord($objFile, $arrFile);
                break;
            }
            case "files":
            {
                $this->insertOtherRecord($objFile);
                break;
            }
            default:
                break;
        }

        return ($objFile);
    }

    public function insertMusicRecord($objFile, $arrFile) {
        $objFileMusic = new Track();
        $objFileMusic->track_uuid = Util::uuid();
        $objFileMusic->file_id = $objFile->file_id;
        $objFileMusic->file_uuid = $objFile->file_uuid;

        if (is_int($arrFile["track_number"])) {
            $objFileMusic->track_number = $arrFile["track_number"];
        } else {
            throw new InvalidParameterException();
        }

        $objFileMusic->track_duration = $arrFile["track_duration"];

        if (isset($arrFile["track_isrc"])) {
            $objFileMusic->track_isrc = $arrFile["track_isrc"];
        }

        $objFileMusic->save();

        return $objFileMusic;
    }

    /**
     * @param $objFile
     * @param $arrFile
     * @return FileVideo
     * @throws \Exception
     */
    public function insertVideoRecord($objFile, $arrFile) {
        $objFileVideo = new FileVideo();
        $objFileVideo->row_uuid = Util::uuid();
        $objFileVideo->file_id = $objFile->file_id;
        $objFileVideo->file_uuid = $objFile->file_uuid;

        if (isset($arrFile["music_uuid"]) && isset($arrFile["music_id"])) {
            $objFileVideo["music_uuid"] = $arrFile["music_uuid"];
            $objFileVideo["music_id"] = $arrFile["music_id"];
        }

        if (isset($arrFile["file_isrc"])) {
            $objFileVideo->file_isrc = $arrFile["file_isrc"];
        }

        $objFileVideo->save();

        return $objFileVideo;
    }

    /**
     * @param $objFile
     * @param $arrFile
     * @return FileMerch
     * @throws \Exception
     */
    public function insertMerchRecord($objFile, $arrFile) {
        $objFileMerch = new FileMerch();
        $objFileMerch->row_uuid = Util::uuid();
        $objFileMerch->file_id = $objFile->file_id;
        $objFileMerch->file_uuid = $objFile->file_uuid;

        if (isset($arrFile["file_sku"])) {
            $objFileMerch->file_sku = $arrFile["file_sku"];
        }

        $objFileMerch->save();

        return $objFileMerch;
    }

    /**
     * @param $objFile
     * @return FileOther
     * @throws \Exception
     */
    public function insertOtherRecord($objFile) {
        $objFileOther = new FileOther();
        $objFileOther->row_uuid = Util::uuid();
        $objFileOther->file_id = $objFile->file_id;
        $objFileOther->file_uuid = $objFile->file_uuid;
        $objFileOther->save();

        return $objFileOther;
    }

    /**
     * @param FileModel $objFile
     * @param float $startTimecode
     * @param float $stopTimecode
     * @return FileModel
     * @throws \Exception
     */
    public function addTimeCodes(FileModel $objFile, float $startTimecode, float $stopTimecode): FileModel {
        $objMusic = $objFile->track;

        if (is_null($objMusic)) {
            throw new \Exception("Not A Music File.");
        }

        $objMusic->preview_start = $startTimecode;
        $objMusic->preview_stop = $stopTimecode;

        $objMusic->save();

        return $objFile->load("track");
    }

    /**
     * @param ProjectModel $objProject
     * @param FileModel $objFile
     * @param string $strFilePath
     * @return FileModel
     * @throws \Exception
     */
    public function saveCoverImage(ProjectModel $objProject, FileModel $objFile, string $strFilePath): FileModel {
        $objMusic = $objFile->track;

        if (is_null($objMusic)) {
            throw new \Exception("Not A Music File.");
        }

        $strCoverPath = Soundblock::project_track_artwork($objProject, $objFile);
        bucket_storage("soundblock")->put($strCoverPath, fopen($strFilePath, 'r'), "public");

        return $objFile;
    }

    /**
     * @param FileModel $objFile
     * @param array $arrFile
     * @return FileModel
     * @throws \Exception
     */
    public function update(FileModel $objFile, array $arrFile): FileModel {
        if (!isset($arrFile["file"])) {
            $objFile->file_uuid = Util::uuid();
        } else {
            $objFile->file_uuid = $arrFile["file"];
        }

        $objFile->file_name = $arrFile["file_name"];
        $objFile->file_path = $arrFile["file_path"];
        $objFile->file_sortby = $arrFile["file_sortby"];
        $objFile->file_category = $arrFile["file_category"];
        $objFile->file_size = $arrFile["file_size"];
        $objFile->file_md5 = $arrFile["file_md5"];

        if (isset($arrFile["directory_id"]) && isset($arrFile["directory_uuid"])) {
            $objFile->directory_id = $arrFile["directory_id"];
            $objFile->directory_uuid = $arrFile["directory_uuid"];
        } else if (isset($arrFile["directory"]) && $arrFile["directory"] instanceof Directory) {
            $objFile->directory_id = $arrFile["directory"]->directory_id;
            $objFile->directory_uuid = $arrFile["directory"]->directory_uuid;
        } else {
//             throw new InvalidParameterException();
        }

        if (isset($arrFile["file_title"])) {
            $objFile->file_title = $arrFile["file_title"];
        }

        $objFile->save();

        return ($objFile);

    }
}
