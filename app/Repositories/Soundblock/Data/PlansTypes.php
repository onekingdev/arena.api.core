<?php

namespace App\Repositories\Soundblock\Data;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Data\PlansType;

class PlansTypes extends BaseRepository {
    /**
     * ProjectsRoles constructor.
     * @param PlansType $model
     */
    public function __construct(PlansType $model) {
        $this->model = $model;
    }

    public function findTypeByName(string $planTypeName){
        return ($this->model->where("plan_name", $planTypeName)->firstOrFail());
    }

    public function findLatestByName(string $planTypeName){
        return ($this->model->where("plan_name", $planTypeName)->orderBy("plan_version", "desc")->firstOrFail());
    }

    public function getSimpleType(){
        return ($this->model->where("plan_level", 1)->orderBy("plan_version", "desc")->first());
    }
}
