<?php

namespace App\Http\Transformers\Common;

use App\Http\Transformers\BaseTransformer;
use App\Models\Notification\NotificationSetting as NotificationSettingModel;
use App\Traits\StampCache;

class NotificationSetting extends BaseTransformer
{
    use StampCache;

    /**
     * @param NotificationSettingModel $objSetting
     * @return array
     */
    public function transform(NotificationSettingModel $objSetting)
    {
        $response = [
            "flag_apparel"          => $objSetting->flag_apparel,
            "flag_arena"            => $objSetting->flag_arena,
            "flag_catalog"          => $objSetting->flag_catalog,
            "flag_io"               => $objSetting->flag_io,
            "flag_merchandising"    => $objSetting->flag_merchandising,
            "flag_music"            => $objSetting->flag_music,
            "flag_office"           => $objSetting->flag_office,
            "flag_soundblock"       => $objSetting->flag_soundblock,
            "setting"               => $objSetting->setting
        ];

        return (array_merge($response, $this->stamp($objSetting)));
    }
}
