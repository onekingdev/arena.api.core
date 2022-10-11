<?php

namespace App\Repositories\Common;

use App\Models\Core\App as AppModel;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection as SupportCollection;

class App extends BaseRepository {

    public function __construct(AppModel $objApp) {
        $this->model = $objApp;
    }

    /**
     * @param string $strName
     * @return AppModel
     */
    public function findOneByName(string $strName): AppModel {
        return ($this->model->where("app_name", $strName)->firstOrFail());
    }

    /**
     * @return SupportCollection
     */
    public function findAll(): SupportCollection {
        return ($this->model->all());
    }
}
