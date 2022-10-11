<?php

namespace App\Services\Apparel;

use Util;
use App\Repositories\Apparel\{Attribute as AttributeRepository, Category};

class Attribute {
    /**
     * @var AttributeRepository
     */
    private AttributeRepository $attributeRepo;
    /**
     * @var Category
     */
    private Category $categoryRepo;
    /**
     * @var Category
     */
    private Category $categoryService;

    /**
     * @param AttributeRepository $attributeRepo
     * @param Category $categoryRepo
     * @param Category $categoryService
     */
    public function __construct(AttributeRepository $attributeRepo, Category $categoryRepo, Category $categoryService) {
        $this->attributeRepo = $attributeRepo;
        $this->categoryRepo = $categoryRepo;
        $this->categoryService = $categoryService;
    }

    /**
     * @param string $categoryUuid
     * @return array
     */
    public function findAllByCategory(string $categoryUuid) {
        return ($this->attributeRepo->findAllByCategory($categoryUuid));
    }

    /**
     * @param $requestData
     * @return mixed
     * @throws \Exception
     */
    public function createAttribute($requestData){
        $objCategory = $this->categoryService->find($requestData["category_uuid"]);
        $arrAttributeData = array_merge($requestData, ["category_id" => $objCategory->category_id, "attribute_uuid" => Util::uuid()]);
        $objAttribute = $this->attributeRepo->create($arrAttributeData);

        return ($objAttribute);
    }
}
