<?php

namespace App\Http\Transformers\Account;

use Util;
use App\Traits\StampCache;
use App\Http\Transformers\Account;
use League\Fractal\TransformerAbstract;
use App\Http\Transformers\Soundblock\Deployment;
use App\Models\{Soundblock\Files\File, Soundblock\Projects\Project as ProjectModel};

class Project extends TransformerAbstract
{
    use StampCache;

    protected $bnLatest;
    protected $bnExtract;
    protected $colIncludes = [];
    public $availableIncludes = [];
    protected $defaultIncludes = [];

    public function __construct($arrIncludes = null, $bnLatest = false, array $colIncludes = null, bool $bnExtract = false)
    {
        $this->bnLatest = $bnLatest;
        $this->colIncludes = $colIncludes;
        $this->bnExtract = $bnExtract;

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

    public function transform(ProjectModel $objProject)
    {
        $status = $objProject->contracts()->orderBy("contract_id", "desc")->value("flag_status");

        $response = [
            "project_uuid"  => $objProject->project_uuid,
            "project_title" => $objProject->project_title,
            "artwork"       => $objProject->artwork,
            "project_type"  => $objProject->project_type,
            "project_date"  => $objProject->project_date,
            "project_upc"   => $objProject->project_upc,
            "status"        => $status,
        ];

        if ($this->bnExtract) {
            $zipPath = Util::project_zip_path($objProject->project_uuid);
            $arrFiles = bucket_storage("soundblock")->allFiles($zipPath);

            $arrWhere = array();
            foreach ($arrFiles as $file) {
                $fileBaseName = pathinfo($file, PATHINFO_BASENAME);
                array_push($arrWhere, $fileBaseName);
            }

            $arrMusicFile = File::whereIn("file_uuid", $arrWhere)->where("file_category", "music")->get();
            $arrMusicFile->each(function ($item) use ($response) {
                $objMusicFile = $item->track;
                array_push($response["tracks"], [
                    "file_uuid" => $item->file_uuid,
                    "file_name" => $item->file_name,
                    "file_title" => $item->file_tilte,
                    "track_number" => $objMusicFile ? $objMusicFile->track_number : null,
                    "track_duration" => $objMusicFile ? $objMusicFile->track_duration : null,
                ]);
            });
        }

        return(array_merge($response, $this->stamp($objProject)));
    }

    public function includeDeployments(Project $objProject)
    {
        return($this->collection($objProject->deployments, new Deployment));
    }

    public function includeAccount(Project $objProject)
    {
        return($this->item($objProject->account, new Account(["plans"])));
    }

    public function includeTeam(Project $objProject)
    {
        return($this->item($objProject->team, new TeamTransformer(["users"])));
    }
}
