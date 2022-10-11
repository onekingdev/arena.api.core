<?php

namespace App\Http\Transformers\User;

use Client;
use App\Traits\StampCache;
use League\Fractal\TransformerAbstract;
use App\Http\Transformers\{Auth\AuthGroup,
    Auth\AuthPermission,
    Auth\OnlyAuthGroup,
    Soundblock\Contract};
use App\Models\{Core\Auth\AuthPermission as AuthPermissionModel, Users\User as UserModel};

class User extends TransformerAbstract
{
    use StampCache;

    public $availableIncludes = [

    ];

    protected $defaultIncludes = [

    ];

    protected $primaryonly;

    protected $objPerm;
    /**
     * @var null
     */
    private $arrIncludes;
    /**
     * @var array|null
     */
    private $arrFields;
    /**
     * @var \App\Models\Core\App
     */
    private $app;
    /**
     * @var array
     */
    private $pivotKeys;
    /**
     * @var string|null
     */
    private $pivotName;

    /**
     * UserTransformer constructor.
     * @param null $arrIncludes
     * @param bool $primaryonly
     * @param AuthPermissionModel|null $objPerm
     * @param array|null $arrFields
     * @param array $options
     */
    public function __construct($arrIncludes = null, bool $primaryonly = true, ?AuthPermissionModel $objPerm = null,
                                ?array $arrFields = null, array $options = []) {
        $this->primaryonly = $primaryonly;
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

        $this->arrIncludes = $arrIncludes;
        $this->arrFields = $arrFields;
        $this->app = Client::app();

        foreach($options as $optionName => $optionValue) {
            $this->{$optionName} = $optionValue;
        }
    }

    public function transform(UserModel $objUser)
    {
        $response = [
            "user_uuid" => $objUser->user_uuid,
            "name" => $objUser->name,
            "avatar" => $objUser->avatar
        ];

        if (isset($objUser["contract_member"])) {
            $response = array_merge($response, ["contract_member" => $objUser["contract_member"]]);
        }

        if(isset($objUser->pivot) && !empty($this->pivotKeys)) {
            $pivotKey = $this->pivotName ?? "pivot";

            $response[$pivotKey] = $objUser->pivot->only($this->pivotKeys);

            if(isset($response[$pivotKey]["user_role"])){
                $response["user_role"] = $response[$pivotKey]["user_role"];
                unset($response[$pivotKey]["user_role"]);
            }
        }

        $stamps = $this->stamp($objUser);
        if(isset($this->arrFields["select_fields"])) {
            $arrFieldsAliasMap = config("constant.autocomplete.users.fields_alias");
            $arrSelect = collect($arrFieldsAliasMap)->only($this->arrFields["select_fields"])->values()->all();
            $response = collect($response)->only($arrSelect)->all();
        }

        return array_merge($response, $stamps);
    }

    public function includeAliases(UserModel $objUser) {
        $fields = [];

        if(isset($this->arrFields["aliases_fields"])) {
            $fields = explode(",", $this->arrFields["aliases_fields"]);
            $alias = config('constant.autocomplete.users.fields_alias.relations.aliases');
            $fields = collect($alias)->only($fields)->values()->all();
        }

        if ($objUser->aliases) {
            if ($this->primaryonly) {
                return ($this->item($objUser->aliases()->where("flag_primary", true)->first(), new AuthAlias($fields)));
            } else {
                return ($this->collection($objUser->aliases, new AuthAlias($fields)));
            }
        }

    }

    public function includeEmails(UserModel $objUser) {
        $fields = [];

        if(isset($this->arrFields["emails_fields"])) {
            $fields = explode(",", $this->arrFields["emails_fields"]);
            $alias = config('constant.autocomplete.users.fields_alias.relations.emails');
            $fields = collect($alias)->only($fields)->values()->all();
        }

        if ($objUser->emails) {
            if ($this->primaryonly) {
                $query =  $objUser->emails()->where("flag_primary", true);
                return($this->item($query->first(), new Email($fields)));
            } else {
                $query = $objUser->emails();
                return($this->collection($query->get(), new Email($fields)));
            }
        }
    }

    public function includePhones(UserModel $objUser) {
        if ($this->primaryonly) {
            return($this->item($objUser->phones()->where("flag_primary", true)->first(), new Phone));
        } else {
            return($this->collection($objUser->phones, new Phone));
        }

    }

    public function includePostals(UserModel $objUser) {
        return($this->collection($objUser->postals, new Postal));
    }

    public function includePermissionsInGroup(UserModel $objUser) {
        if (!$this->objPerm) {
            return($this->collection($objUser->permissionsInGroup, new AuthPermission));
        } else {
            return($this->collection($objUser->permissionsInGroup()
                        ->wherePivot("permission_id", $this->objPerm->permission_id)
                        ->get(), new AuthPermission));
        }

    }

    public function includeGroupsWithPermissions(UserModel $objUser)
    {
        if (!$this->objPerm)
        {
            return($this->collection($objUser->groupsWithPermissions, new OnlyAuthGroup));
        } else {
            return($this->collection($objUser->groupsWithPermissions()
                                            ->wherePivot("permission_id", $this->objPerm->permission_id)
                                            ->get(), new AuthGroup));
        }
    }

    public function includePaypals(UserModel $objUser)
    {
        return($this->collection($objUser->paypals, new Paypal));
    }

    public function includeBankings(UserModel $objUser)
    {
        return($this->collection($objUser->bankings, new Banking));
    }

    public function includeContracts(UserModel $objUser)
    {
        return($this->collection($objUser->contracts, new Contract));
    }

    public function includeGroups(UserModel $objUser) {
        return $this->collection($objUser->groups, new AuthGroup(["permissions"]));
    }
}
