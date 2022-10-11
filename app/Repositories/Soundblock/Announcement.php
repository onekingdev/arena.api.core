<?php

namespace App\Repositories\Soundblock;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Announcement as AnnouncementModel;

class Announcement extends BaseRepository {

    /**
     * Announcement constructor.
     * @param AnnouncementModel $model
     */
    public function __construct(AnnouncementModel $model) {
        $this->model = $model;
    }

    /**
     * @param array $searchParams
     * @param int $perPage
     * @return array
     */
    public function findAllWhere(array $searchParams, int $perPage){
        $query = $this->model->newQuery()->latest();

        if (isset($searchParams["flag_homepage"])) {
            $query = $query->where("flag_homepage", $searchParams["flag_homepage"]);
        }

        if (isset($searchParams["flag_projectspage"])) {
            $query = $query->where("flag_projectspage", $searchParams["flag_projectspage"]);
        }

        if (isset($searchParams["flag_email"])) {
            $query = $query->where("flag_email", $searchParams["flag_email"]);
        }

        [$query, $availableMetaData] = $this->applyMetaFilters($searchParams, $query);

        return ([$query->paginate($perPage), $availableMetaData]);
    }
}
