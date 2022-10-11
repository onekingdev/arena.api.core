<?php

namespace App\Http\Transformers\Auth;

use App\Http\Transformers\BaseTransformer;
use App\Models\Core\Auth\AuthPermission as AuthPermissionModel;
use App\Traits\StampCache;

class AuthPermission extends BaseTransformer
{

    use StampCache;
    public function transform(AuthPermissionModel $objAuthPerm)
    {

        $response = [
            "permission_uuid" => $objAuthPerm->permission_uuid,
            "permission_name" => $objAuthPerm->permission_name,
            "permission_memo" => $objAuthPerm->permission_memo,
        ];

        if (isset($objAuthPerm->pivot))
        {
            $response["permission_value"] = $objAuthPerm->pivot->permission_value;
        }
        $response = array_merge($response, $this->stamp($objAuthPerm));

        return($response);
    }
}
