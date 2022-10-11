<?php

namespace App\Services\Core;

use App\Repositories\Common\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Core\Page\AppStruct;
use App\Models\Core\AppsStruct as AppStructModel;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Contracts\Core\PageStructure as PageStructureContract;

class PageStructure implements PageStructureContract {
    /** @var AppStruct */
    private AppStruct $appStructRepository;
    /** @var App */
    private App $appRepository;

    private array $jsonKeys = AppStructModel::JSON_KEYS;

    /**
     * PageStructure constructor.
     * @param AppStruct $appStructRepository
     * @param App $appRepository
     */
    public function __construct(AppStruct $appStructRepository, App $appRepository) {
        $this->appStructRepository = $appStructRepository;
        $this->appRepository = $appRepository;
    }

    /**
     * @param string|null $strAppName
     * @return AppStructModel[]
     */
    public function getStructures(?string $strAppName = null): array {
        /** @var AppStructModel[] $objStructures */
        if (isset($strAppName)) {
            $objApp = $this->appRepository->findOneByName($strAppName);
            $objStructures = $objApp->structures;
        } else {
            $objStructures = $this->appStructRepository->all();
        }

        foreach ($objStructures as $key => $objStructure) {
            $objStructures[$key]["allowed_fields"] = $this->buildAllowedFields($objStructure);
            $objStructures[$key]["allowed_additional_content"] = $objStructure->struct_json[$this->getJsonKey("additionalContent")] ?? [];
        }

        return $objStructures->toArray();
    }

    /**
     * @param array $requestData
     * @return AppStructModel
     * @throws \Exception
     */
    public function createStruct(array $requestData): AppStructModel{
        $arrInsertData = [];
        $objApp = $this->appRepository->findOneByName($requestData["app_name"]);

        if (isset($requestData["parent_uuid"])){
            $objParentStruct = $this->appStructRepository->find($requestData["parent_uuid"]);
            $arrInsertData["parent_id"]   = $objParentStruct->struct_id;
            $arrInsertData["parent_uuid"] = $requestData["parent_uuid"];
        }
        $arrInsertData["app_id"]        = $objApp->app_id;
        $arrInsertData["app_uuid"]      = $objApp->app_uuid;
        $arrInsertData["struct_prefix"] = $requestData["struct_prefix"];
        $arrInsertData["struct_json"]["params"]       = $requestData["params"] ?? $requestData["params"];
        $arrInsertData["struct_json"]["content"]      = $requestData["content"] ?? $requestData["content"];
        $arrInsertData["struct_json"]["queryBuilder"] = $requestData["queryBuilder"] ?? $requestData["queryBuilder"];

        /** @var AppStructModel $objStruct*/
        $objStruct = $this->appStructRepository->create($arrInsertData);

        return ($objStruct);
    }

    /**
     * @param AppStructModel $objStruct
     * @return array|string[]
     */
    private function buildAllowedFields(AppStructModel $objStruct): array {
        /** @var array $arrayJsonValues */
        $arrayJsonValues = $objStruct->struct_json;
        $objStructModel = $this->resolveStructModel($arrayJsonValues);

        if (!isset($arrayJsonValues[$this->getJsonKey("queryParams")])) {
            return [];
        }

        if (is_string($arrayJsonValues[$this->getJsonKey("queryParams")])) {
            return [$arrayJsonValues[$this->getJsonKey("queryParams")]];
        }

        $allowedFields = [];

        foreach ($arrayJsonValues[$this->getJsonKey("queryParams")] as $fieldName => $paramOptions) {
            if (!is_array($paramOptions) || !isset($paramOptions[$this->getJsonKey("queryBuilder")])) {
                $allowedFields[$fieldName] = "*";

                continue;
            }

            $arrayQueryBuilderSettings = $paramOptions[$this->getJsonKey("queryBuilder")];

            [$objModel] = $this->resolveParamModel($arrayQueryBuilderSettings, $objStructModel);

            if (is_null($objModel)) {
                $allowedFields[$fieldName] = "*";

                continue;
            }

            if (!$objModel instanceof Model && !$objModel instanceof Relation) {
                $allowedFields[$fieldName] = "*";

                continue;
            }

            if (isset($arrayQueryBuilderSettings[$this->getJsonKey("queryWhere")]) &&
                is_array($arrayQueryBuilderSettings[$this->getJsonKey("queryWhere")])) {
                $objModel = $this->whereBuilder($arrayQueryBuilderSettings[$this->getJsonKey("queryWhere")], $objModel);
            }

            $objFields = $objModel->get();

            if (is_object($objFields)) {
                $objFields = $objFields->toArray();
            }

            $allowedFields[$fieldName] = $objFields;
        }

        return ($allowedFields);
    }

    /**
     * @param $arrayJsonValues
     * @return Builder|Model|Relation|object|null
     */
    private function resolveStructModel($arrayJsonValues) {
        $objStructModel = null;

        if (isset($arrayJsonValues[$this->getJsonKey("queryBuilder")])) {
            $structModelBuilderOptions = $arrayJsonValues[$this->getJsonKey("queryBuilder")];

            if (isset($structModelBuilderOptions[$this->getJsonKey("queryModel")])) {
                $objModelFromJson = resolve($structModelBuilderOptions[$this->getJsonKey("queryModel")]);

                if ($objModelFromJson instanceof Model && isset($structModelBuilderOptions[$this->getJsonKey("queryWhere")])) {
                    $objStructModel = $this->whereBuilder($structModelBuilderOptions[$this->getJsonKey("queryWhere")], $objModelFromJson)
                                           ->first();
                }
            }
        }

        return $objStructModel;
    }

    /**
     * @param array $arrWhere
     * @param Model|Relation $objModel
     * @return Builder|Relation
     */
    private function whereBuilder(array $arrWhere, $objModel) {
        $queryBuilder = $objModel->newQuery();

        foreach ($arrWhere as $key => $whereFields) {
            if (is_array($whereFields) && isset($whereFields[$this->getJsonKey("queryValue")]) &&
                isset($whereFields[$this->getJsonKey("queryColumn")])) {
                $strOperator = $whereFields[$this->getJsonKey("queryOperator")] ?? "=";

                $queryBuilder = $queryBuilder->where($whereFields[$this->getJsonKey("queryColumn")], $strOperator,
                    $whereFields[$this->getJsonKey("queryValue")]);
            } else if (is_string($key) && is_string($whereFields)) {
                $queryBuilder = $queryBuilder->where($key, $whereFields);
            }
        }

        return ($queryBuilder);
    }

    /**
     * @param $paramOptions
     * @param Model $objStructModel
     * @return array
     */
    private function resolveParamModel($paramOptions, ?Model $objStructModel) {
        $objModel = null;
        $objResolvedModel = resolve($paramOptions[$this->getJsonKey("queryModel")]);

        if (isset($paramOptions[$this->getJsonKey("queryRelations")]) && is_object($objStructModel) &&
            method_exists($objStructModel, $paramOptions[$this->getJsonKey("queryRelations")])) {
            $objModel = $objStructModel->{$paramOptions[$this->getJsonKey("queryRelations")]}();
        } else if (isset($paramOptions[$this->getJsonKey("queryModel")])) {
            $objModel = $objResolvedModel;
        }

        return [$objModel, $objResolvedModel->uuid()];
    }

    /**
     * @param string $strStructPrefix
     * @return AppStructModel
     * @throws \Exception
     */
    public function getStructureByPrefix(string $strStructPrefix): AppStructModel {
        $objStructure = $this->appStructRepository->findByPrefix($strStructPrefix);

        if (is_null($objStructure)) {
            throw new \Exception("Structure Not Found.", 404);
        }

        $objStructure["allowed_fields"] = $this->buildAllowedFields($objStructure);
        $objStructure["allowed_additional_content"] = $objStructure->struct_json[$this->getJsonKey("additionalContent")] ?? [];

        return ($this->getStructParents($objStructure));
    }

    /**
     * @param string $strStructUUID
     * @return AppStructModel
     * @throws \Exception
     */
    public function getStructureByUuid(string $strStructUUID): AppStructModel {
        $objStructure = $this->appStructRepository->findByUuid($strStructUUID);

        if (is_null($objStructure)) {
            throw new \Exception("Structure Not Found.", 404);
        }

        $objStructure["allowed_fields"] = $this->buildAllowedFields($objStructure);
        $objStructure["allowed_additional_content"] = $objStructure->struct_json[$this->getJsonKey("additionalContent")] ?? [];

        return ($this->getStructParents($objStructure));
    }

    /**
     * @param string $structureUuid
     * @param string $param
     * @param string $value
     * @return bool
     * @throws \Exception
     */
    public function validateParams(string $structureUuid, string $param, string $value): bool {
        $objStructure = $this->appStructRepository->find($structureUuid);

        if (is_null($objStructure)) {
            throw new \Exception("Structure Not Found.", 404);
        }

        $arrJson = $objStructure->struct_json;

        if (!isset($arrJson[$this->getJsonKey("queryParams")])) {
            return true;
        }

        $arrParams = $arrJson[$this->getJsonKey("queryParams")][$param][$this->getJsonKey("queryBuilder")];
        $objStructModel = $this->resolveStructModel($arrJson);

        [$objParamModel, $strUuidField] = $this->resolveParamModel($arrParams, $objStructModel);

        $objQueryBuilder = $this->whereBuilder($arrParams[$this->getJsonKey("queryWhere")], $objParamModel)->where($strUuidField, $value);

        return ($objQueryBuilder->exists());
    }

    /**
     * @param string $structureUuid
     * @param string $content
     * @return bool
     * @throws \Exception
     */
    public function validateContent(string $structureUuid, string $content): bool {
        $objStructure = $this->appStructRepository->find($structureUuid);

        if (is_null($objStructure)) {
            throw new \Exception("Structure Not Found.", 404);
        }

        $arrJson = $objStructure->struct_json;

        if (!isset($arrJson[$this->getJsonKey("additionalContent")]) ||
            empty($arrJson[$this->getJsonKey("additionalContent")])) {
            return false;
        }

        return (array_search(strtolower($content), $arrJson[$this->getJsonKey("additionalContent")]) !== false);
    }

    /**
     * @param string $jsonKey
     * @return string|null
     */
    public function getJsonKey(string $jsonKey): ?string {
        return $this->jsonKeys[$jsonKey] ?? null;
    }

    /**
     * @param AppStructModel $objStruct
     * @return AppStructModel
     */
    private function getStructParents(AppStructModel $objStruct){
        if (isset($objStruct->parent_id)){
            $objStruct["parent"] = $this->getStructParents($objStruct->parent);
        }

        return ($objStruct);
    }
}
