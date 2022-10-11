<?php

namespace App\Http\Transformers\Core;

use App\Models\Core\AppsPage as AppsPageModel;
use App\Traits\StampCache;
use League\Fractal\TransformerAbstract;

class AppsPage extends TransformerAbstract {

    use StampCache;

    public function transform(AppsPageModel $page) {
        $response = [
            "page_uuid" => $page->page_uuid,
            "page_url"  => $page->page_url,
            "app"       => $page->struct->app,
            "struct"    => $page->struct,
            "meta"      => $page->page_json["meta"] ?? [],
            "params"    => $page->page_json["params"] ?? [],
            "content"   => $page->page_json["content"] ?? [],
        ];

        $arrReturn = array_merge($response, $this->stamp($page));

        if (isset($arrReturn["meta"]["page_image"])) {
            foreach ($arrReturn["meta"]["page_image"] as $key => $value){
                if (!is_null($value)){
                    $arrReturn["meta"]["page_image"][$key] = env("CORE_CLOUD") . DIRECTORY_SEPARATOR . "pages" .
                        DIRECTORY_SEPARATOR . $page->page_json["meta"]["page_image"][$key];
                }
            }
        }

        return ($arrReturn);
    }
}
