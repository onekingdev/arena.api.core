<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use League\Fractal\TransformerAbstract;
use App\Models\Soundblock\Files\FileHistory;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Files\File as FileModel;

class File extends TransformerAbstract
{
    use StampCache;

    protected string $bnHistory;
    protected string $objLatestCol;
    protected string $objPresentCol;
    public $availableIncludes = [

    ];

    protected $defaultIncludes = [

    ];

    public function __construct($arrIncludes = null, Collection $objLatestCol = null, $bnHistory = false)
    {
        $this->bnHistory = $bnHistory;

        $this->objLatestCol = $objLatestCol;

        if ($arrIncludes)
        {
            foreach($arrIncludes as $item)
            {
                $item = strtolower($item);
                $this->availableIncludes []= $item;
                $this->defaultIncludes []= $item;
            }
        }

    }

    public function transform(FileModel $objFile)
    {

        $response = [
            "file_uuid"             => $objFile->file_uuid,
            "file_name"             => $objFile->file_name,
            "file_path"             => $objFile->file_path,
            "file_title"            => $objFile->file_title,
            "file_category"         => $objFile->file_category,
            "file_sortby"           => $objFile->file_sortby,
            "file_size"             => $objFile->file_size,
            "meta"                  => $objFile->meta,
            FileModel::STAMP_CREATED     => $objFile->{FileModel::STAMP_CREATED},
            FileModel::STAMP_CREATED_BY  => $objFile->{FileModel::STAMP_CREATED_BY},
            FileModel::STAMP_UPDATED     => $objFile->{FileModel::STAMP_UPDATED},
            FileModel::STAMP_UPDATED_BY  => $objFile->{FileModel::STAMP_UPDATED_BY},
        ];

        if ($objFile->pivot)
        {
            if ($objFile->pivot->file_action && $objFile->pivot->file_category)
            {
                $response["file_action"] = $objFile->pivot->file_action;
                $response["file_category"] = $objFile->pivot->file_category;
                $response["file_memo"] = $objFile->pivot->file_memo;
            }
        }

        $historyFile = FileHistory::where("file_id", $objFile->file_id)
                                        ->orderBy("collection_id","desc")
                                        ->first();
        $arrHistory = array();
        if ($historyFile && false)
        {
            $historyItem = [
                "file_uuid" => $historyFile->file_uuid,
                "file_action" => $historyFile->file_action,
            ];
            array_push($arrHistory, array_merge($historyItem, $this->stamp($historyFile)));

            while($historyFile->parent)
            {
                $historyFile = $historyFile->parent()
                                            ->where("collection_id", "<>", $historyFile->collection_id)->first();
                $action = $historyFile->file_action;
                $historyItem = [
                    "file_uuid" => $historyFile->file_uuid,
                    "file_action" => $action,
                ];
                array_push($arrHistory,array_merge($historyItem, $this->stamp($historyFile)));
            }

            $response["file_history"] = $arrHistory;
        }

        return($response);
    }

    public function includeMusic(FileModel $objFile)
    {
        return($this->item($objFile->track, new Track));
    }

    public function includeVideo(FileModel $objFile)
    {
        return($this->item($objFile->video, new FileVideo(["track"])));
    }

    public function includeMerch(FileModel $objFile)
    {
        return($this->item($objFile->merch, new FileMerch));
    }

    public function includeOther(FileModel $objFile)
    {
        return($this->item($objFile->other, new FileOther));
    }

    protected function getRoot(Collection $objLatestCol, FileModel $objFile)
    {
        $arrObjFiles = $objLatestCol->files()->where("file_path", $objFile->file_path)->get();

        $arrRoot = array();
        foreach($arrObjFiles as $itemFile)
        {
            $historyFile = FileHistory::where("file_id", $itemFile->file_id)->orderBy("collection_id", "desc")->first();
            if ($historyFile) {
                while($historyFile->parent)
                {
                    $historyFile = $historyFile->parent()->where("collection_id", "<>", $historyFile->collection_id)->first();
                }
                array_push($arrRoot, ["file" => $itemFile, "root" => $historyFile]);
            }
        }

        $objRootFile = FileHistory::where("file_id", $objFile->file_id)->orderBy("collection_id", "desc")->first();

        while($objRootFile && $objRootFile->parent)
        {
            $objRootFile = $objRootFile->parent()
                                    ->where("collection_id", "<>", $objRootFile->collection_id)->first();
        }
        if (count($arrRoot) >0 && $objRootFile)
        {
            for ($i = 0; $i < count($arrRoot); $i++)
            {
                $root = $arrRoot[$i];

                if ($root["root"]->file_id == $objRootFile->file_id && $root["file"]->file_id == $objFile->file_id)
                {
                    return 0;
                }
                if ($root["root"]->file_id == $objRootFile->file_id && $root["file"]->file_id != $objFile->file_id)
                {
                    return 1;
                }
            }
        }

        return 2;
    }
}
