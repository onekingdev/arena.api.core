<?php

namespace App\Http\Transformers\Auth;

use League\Fractal\TransformerAbstract;
use App\Http\Transformers\User\User as UserTransformer;
use App\Models\{Core\Auth\AuthGroup as AuthGroupModel, Core\Auth\AuthPermission as AuthPermissionModel, BaseModel};

class AuthGroup extends TransformerAbstract
{

    protected $cacheTTL;

    public $availableIncludes = [

    ];

    protected $defaultIncludes = [

    ];

    protected $objPerm;

    public function __construct($arrIncludes = null, AuthPermissionModel $objPerm = null)
    {
        $this->cacheTTL = config("constant.cache_ttl");

        $this->objPerm = $objPerm;

        if ($arrIncludes)
        {
            foreach($arrIncludes as $item)
            {
                $item = strtolower($item);
                $this->availableIncludes []= $item;
                $this->defaultIncludes []= $item;
            }
        }

    }

    public function transform(AuthGroupModel $objAuthGroup)
    {
        $res = [
            "group_uuid" => $objAuthGroup->group_uuid,
            "auth_uuid" => $objAuthGroup->auth_uuid,
            "group_name" => $objAuthGroup->group_name,
            "group_memo" => $objAuthGroup->group_memo,
            BaseModel::STAMP_CREATED => $objAuthGroup->stamp_created,
            BaseModel::STAMP_CREATED_BY => $objAuthGroup->{BaseModel::STAMP_CREATED_BY},
            BaseModel::STAMP_UPDATED => $objAuthGroup->stamp_updated,
            BaseModel::STAMP_UPDATED_BY => $objAuthGroup->{BaseModel::STAMP_UPDATED_BY}
        ];

        if (isset($objAuthGroup->pivot->permission_uuid))
        {
            $res["permission"] = [
                "data" => [
                    "permission_uuid" => $objAuthGroup->pivot->permission_uuid,
                    "permission_value" => $objAuthGroup->pivot->permission_value,
                ]
            ];
        }
        return($res);
    }

    public function includeUsers(AuthGroupModel $objAuthGroup)
    {
        return($this->collection($objAuthGroup->users, new UserTransformer(["aliases", "emails"])));
    }

    public function includePermissions(AuthGroupModel $objAuthGroup)
    {
        if (!$this->objPerm)
        {
            return($this->collection($objAuthGroup->permissions, new AuthPermission()));
        } else {
            return($this->item($objAuthGroup->permissions()
                ->wherePivot("permission_id", $this->objPerm->permission_id)
                ->first(), new AuthPermission()));
        }

    }

}
