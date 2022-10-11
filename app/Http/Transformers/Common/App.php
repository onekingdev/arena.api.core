<?php

namespace App\Http\Transformers\Common;

use App\Http\Transformers\BaseTransformer;
use App\Models\Core\App as AppModel;
use App\Traits\StampCache;

class App extends BaseTransformer
{
    use StampCache;
    public function transform(AppModel $objApp)
    {
        $response = [
            "app_uuid" => $objApp->app_uuid,
            "app_name" => $objApp->app_name,
            "app_platform" => $objApp->app_platform,
        ];
        return(array_merge($response, $this->stamp($objApp)));
    }
}
