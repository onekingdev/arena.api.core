<?php

namespace App\Http\Controllers\Core;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Core\CreateAppStruct;
use App\Contracts\Core\PageStructure as PageStructureContract;

/**
 * @group Core
 *
 */
class AppsStruct extends Controller
{
    private PageStructureContract $pageStructure;

    public function __construct(PageStructureContract $pageStructure){
        $this->pageStructure = $pageStructure;
    }

    /**
     * @return mixed
     */
    public function getAllStructures(){
        $objStructures = $this->pageStructure->getStructures();

        return ($this->apiReply($objStructures, "Success.", 200));
    }

    /**
     * @param string $strStructPrefix
     * @return mixed
     * @throws \Exception
     */
    public function getStructureByPrefix(string $strStructPrefix){
        $objStructure = $this->pageStructure->getStructureByPrefix($strStructPrefix);

        return ($this->apiReply($objStructure, "Success.", 200));
    }

    /**
     * @param string $strStructUUID
     * @return mixed
     * @throws \Exception
     */
    public function getStructureByUuid(string $strStructUUID){
        $objStructure = $this->pageStructure->getStructureByUuid($strStructUUID);

        return ($this->apiReply($objStructure, "Success.", 200));
    }

    /**
     * @param CreateAppStruct $request
     * @return mixed
     */
    public function createStruct(CreateAppStruct $request){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objStruct = $this->pageStructure->createStruct($request->only([
            "app_name",
            "parent_uuid",
            "struct_prefix",
            "content",
            "params",
            "queryBuilder"
        ]));

        return ($this->apiReply($objStruct, "Struct created successfully.", 200));
    }
}
