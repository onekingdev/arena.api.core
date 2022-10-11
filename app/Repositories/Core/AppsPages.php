<?php

namespace App\Repositories\Core;

use App\Models\Core\AppsPage as AppsPageModel;
use App\Repositories\BaseRepository;

class AppsPages extends BaseRepository {
    /**
     * ProductRepository constructor.
     * @param AppsPageModel $page
     */
    public function __construct(AppsPageModel $page) {
        $this->model = $page;
    }

    /**
     * @param string $pageURL
     * @param string $structUuid
     * @return mixed
     */
    public function findByUrl(string $pageURL, string $structUuid){
        $objPage = $this->model->where("struct_uuid", $structUuid)->where("page_url", $pageURL)->first();

        return ($objPage);
    }

    /**
     * @param string $pageUuid
     * @return mixed
     */
    public function findByUuid(string $pageUuid) {
        $objPage = $this->model->where("page_uuid", $pageUuid)->first();

        return ($objPage);
    }

    /**
     * @param string $pageUuid
     * @return mixed
     */
    public function delete(string $pageUuid) {
        $boolResult = $this->model->where("page_uuid", $pageUuid)->delete();

        return ($boolResult);
    }
}
