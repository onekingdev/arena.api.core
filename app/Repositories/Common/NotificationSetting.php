<?php

namespace App\Repositories\Common;

use App\Models\Notification\NotificationSetting as NotificationSettingModel;
use App\Repositories\BaseRepository;

class NotificationSetting extends BaseRepository {
    /**
     * @param NotificationSettingModel $objSetting
     */
    public function __construct(NotificationSettingModel $objSetting) {
        $this->model = $objSetting;
    }

    public function create(array $arrParams) {
        $this->model = $this->model->newInstance();
        return parent::create($arrParams);
    }
}
