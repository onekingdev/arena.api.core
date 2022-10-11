<?php

namespace App\Http\Transformers\User;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Users\Contact\UserContactPostal;

class Postal extends BaseTransformer
{

    use StampCache;

    public function transform(UserContactPostal $objPostal)
    {
        $response = [
            "postal_uuid" => $objPostal->row_uuid,
            "postal_type" => $objPostal->postal_type,
            "postal_street" => $objPostal->postal_street,
            "postal_city" => $objPostal->postal_city,
            "postal_zipcode" => $objPostal->postal_zipcode,
            "postal_country" => $objPostal->postal_country,
            "flag_primary" => $objPostal->flag_primary,
        ];
        $response = array_merge($response, $this->stamp($objPostal));

        return($response);
    }
}
