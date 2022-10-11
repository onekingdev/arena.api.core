<?php

namespace App\Http\Transformers\Office\Support;

use App\Traits\StampCache;
use App\Http\Transformers\Common\App;
use App\Http\Transformers\BaseTransformer;
use App\Models\Support\Support as SupportModel;

class Support extends BaseTransformer
{

    use StampCache;

    public function transform(SupportModel $objSupport)
    {
        $response = [
            "support_uuid" => $objSupport->support_uuid,
            "support_category" => $objSupport->support_category,
            "app" => [
                "data" => [
                    "app_uuid" => $objSupport->app_uuid,
                    "app_name" => $objSupport->app->app_name,
                ]
            ],
        ];

        return(array_merge($response, $this->stamp($objSupport)));
    }

    public function includeApp(SupportModel $objSupport)
    {
        return($this->item($objSupport->app, new App));
    }
}
