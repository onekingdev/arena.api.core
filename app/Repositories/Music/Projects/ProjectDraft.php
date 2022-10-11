<?php

namespace App\Repositories\Music\Projects;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Music\Project\ProjectDraftVersion;
use App\Models\Music\Project\ProjectDraft as ProjectDraftModel;

class ProjectDraft extends BaseRepository {
    /**
     * ProjectDraft constructor.
     * @param ProjectDraftModel $model
     */
    public function __construct(ProjectDraftModel $model) {
        $this->model = $model;
    }

    /**
     * @param ProjectDraftModel $objDraft
     * @param array $arrVersionInfo
     * @return ProjectDraftVersion
     * @throws \Exception
     */
    public function saveVersion(ProjectDraftModel $objDraft, array $arrVersionInfo): ProjectDraftVersion {
        if (!empty($arrVersionInfo["tracks"]) && is_array($arrVersionInfo["tracks"])) {
            foreach ($arrVersionInfo["tracks"] as $trackKey => $arrTrack) {
                if (!isset($arrTrack["uuid"])) {
                    $arrVersionInfo["tracks"][$trackKey]["uuid"] = Util::uuid();
                }
            }
        }

        return $objDraft->versions()->create([
            "version_uuid" => Util::uuid(),
            "draft_uuid"   => $objDraft->draft_uuid,
            "draft_json"   => $arrVersionInfo,
        ]);
    }

    public function getDrafts(?int $perPage = 10) {
        $objBuilder = $this->model->with("versions");

        if (is_int($perPage)) {
            return $objBuilder->paginate($perPage);
        }

        return $objBuilder->get();
    }

    /**
     * @param ProjectDraftModel $objDraft
     * @param string|null $strVersion
     * @return ProjectDraftVersion|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object
     */
    public function findVersion(ProjectDraftModel $objDraft, ?string $strVersion = null) {
        if (is_string($strVersion)) {
            return $objDraft->versions()->where("version_uuid", $strVersion)->first();
        }

        return $objDraft->versions()->latest()->first();
    }
}
