<?php

namespace App\Http\Controllers\Office\Merch\Apparel;

use Illuminate\Http\Response;
use App\Http\{
    Controllers\Controller,
    Requests\Apparel\CreateAttribute,
    Transformers\Apparel\Attribute as AttributeTransformer
};
use App\Services\Apparel\Attribute as AttributeService;
use App\Repositories\Apparel\Attribute as AttributeRepository;

/**
 * @group Office Merch
 *
 */
class Attributes extends Controller {
    /** @var AttributeService */
    private AttributeService $attributeService;
    /** @var AttributeRepository */
    private AttributeRepository $attributeRepository;

    /**
     * Attributes constructor.
     * @param AttributeRepository $attributeRepository
     * @param AttributeService $attributeService
     */
    public function __construct(AttributeRepository $attributeRepository, AttributeService $attributeService) {
        $this->attributeRepository = $attributeRepository;
        $this->attributeService = $attributeService;
    }

    /**
     * @param $strCategoryUUID
     * @param $strAttributeType
     * @return object
     */
    public function getCategoryAttributesByType($strCategoryUUID, $strAttributeType) {
        $objAttributes = $this->attributeRepository->getCategoryAttributeByType($strCategoryUUID, $strAttributeType);

        return ($this->apiReply($objAttributes, "", Response::HTTP_OK));
    }

    /**
     * @param CreateAttribute $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createAttribute(CreateAttribute $request) {
        $objAttribute = $this->attributeService->createAttribute($request->all());

        return ($this->item($objAttribute, new AttributeTransformer));
    }
}
