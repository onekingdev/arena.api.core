<?php

namespace App\Http\Transformers\Apparel;

use App\Traits\StampCache;
use App\Models\Apparel\ProductPrice as ProductPriceModel;
use League\Fractal\TransformerAbstract;

class ProductPrice extends TransformerAbstract {

    use StampCache;

    public function transform(ProductPriceModel $objProductPrice)
    {
        $response = [
            "row_id"        => $objProductPrice["row_id"],
            "row_uuid"      => $objProductPrice["row_uuid"],
            "product_id"    => $objProductPrice["product_id"],
            "product_uuid"  => $objProductPrice["product_uuid"],
            "product_price" => $objProductPrice["product_price"],
            "range_min"     => $objProductPrice["range_min"],
            "range_max"     => $objProductPrice["range_max"]
        ];

        return(array_merge($response, $this->stamp($objProductPrice)));
    }
}
