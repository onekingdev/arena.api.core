<?php

namespace App\Http\Transformers\Apparel;

use App\Traits\StampCache;
use App\Models\Apparel\Attribute as AttributeModel;
use League\Fractal\TransformerAbstract;

class Attribute extends TransformerAbstract {

    use StampCache;

    public function transform(AttributeModel $objAttribute)
    {
        $response = [
            "attribute_id"   => $objAttribute["attribute_id"],
            "attribute_uuid" => $objAttribute["attribute_uuid"],
            "attribute_name" => $objAttribute["attribute_name"],
            "attribute_type" => $objAttribute["attribute_type"],
            "category_id"    => $objAttribute["category_id"],
            "category_uuid"  => $objAttribute["category_uuid"],
        ];

        return(array_merge($response, $this->stamp($objAttribute)));
    }
}
