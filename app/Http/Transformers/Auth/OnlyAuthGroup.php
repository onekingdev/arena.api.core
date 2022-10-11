<?php

namespace App\Http\Transformers\Auth;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\User\User;
use App\Models\Core\Auth\AuthGroup;
use App\Traits\StampCache;

class OnlyAuthGroup extends BaseTransformer
{

    use StampCache;

    public function transform(AuthGroup $objAuthGroup)
    {

        $response = [
            "group_uuid" => $objAuthGroup->group_uuid,
            "auth_uuid" => $objAuthGroup->auth_uuid,
            "group_name" => $objAuthGroup->group_name,
            "group_memo" => $objAuthGroup->group_memo,
        ];
        $response = array_merge($response, $this->stamp($objAuthGroup));

        return($response);
    }

    public function includeUsers(AuthGroup $objAuthGroup)
    {
        return($this->collection($objAuthGroup->users, new User(["aliases", "emails", "avatar"])));
    }

    public function includePermissions(AuthGroup $objAuthGroup)
    {
        return($this->collection($objAuthGroup->permissions, new AuthPermission));
    }

}
