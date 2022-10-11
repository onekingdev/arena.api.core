<?php

namespace Tests\Unit\Core\Pages;

use App\Models\Apparel\Attribute;
use App\Models\Apparel\Category;
use App\Models\Core\App;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\AppsStruct;
use App\Contracts\Core\PageStructure as PageStructureContract;

class PageStructureTest extends TestCase {
    /**
     * @var PageStructureContract
     */
    private PageStructureContract $pageStruct;
    /**
     * @var App
     */
    private App $appModel;
    /**
     * @var Category
     */
    private Category $category;
    /**
     * @var string[]
     */
    private array $states;

    /**
     * @var Attribute[]
     */
    private array $attributes;

    private AppsStruct $structInstance;

    public function setUp(): void {
        parent::setUp();

        $this->states = ["color", "size", "style", "weight"];
        $this->pageStruct = resolve(PageStructureContract::class);

        $this->appModel = App::where("app_name", "apparel")->first();

        $this->category = Category::factory()->create();

        foreach ($this->states as $states) {
            $this->attributes[$states] = $this->category->attributes()->create(Attribute::factory()->{$states}()->make([
                "category_uuid" => $this->category->category_uuid,
            ])->toArray());
        }

        $this->structInstance = $this->appModel->structures()->create([
            "struct_uuid"   => Util::uuid(),
            "app_uuid"      => $this->appModel->app_uuid,
            "struct_prefix" => strtolower($this->category->category_name),
            "struct_json"   => [
                "content"      => [
                    "header",
                    "footer",
                ],
                "params"       => [
                    "color"  => [
                        "queryBuilder" => [
                            "model"        => Attribute::class,
                            "relationship" => "attributes",
                            "where"        => [
                                [
                                    "column" => "attribute_type",
                                    "value"  => "color",
                                ],
                            ],
                        ],
                    ],
                    "style"  => [
                        "queryBuilder" => [
                            "model"        => Attribute::class,
                            "relationship" => "attributes",
                            "where"        => [
                                [
                                    "column" => "attribute_type",
                                    "value"  => "style",
                                ],
                            ],
                        ],
                    ],
                    "weight" => [
                        "queryBuilder" => [
                            "model"        => Attribute::class,
                            "relationship" => "attributes",
                            "where"        => [
                                [
                                    "column" => "attribute_type",
                                    "value"  => "weight",
                                ],
                            ],
                        ],
                    ],
                    "size"   => [
                        "queryBuilder" => [
                            "model"        => Attribute::class,
                            "relationship" => "attributes",
                            "where"        => [
                                "attribute_type" => "size",
                            ],
                        ],
                    ],
                ],
                "queryBuilder" => [
                    "model" => Category::class,
                    "where" => [
                        [
                            "column" => "category_name",
                            "value"  => $this->category->category_name,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testGetAllStructures() {
        $count = AppsStruct::count();
        $arrStructures = $this->pageStruct->getStructures();

        $this->assertIsArray($arrStructures);
        $this->assertCount($count, $arrStructures);

        foreach ($arrStructures as $struct) {
            $this->assertArrayHasKey("struct_uuid", $struct);
            $this->assertArrayHasKey("app_uuid", $struct);
            $this->assertArrayHasKey("parent_uuid", $struct);
            $this->assertArrayHasKey("struct_prefix", $struct);
            $this->assertArrayHasKey("stamp_created", $struct);
            $this->assertArrayHasKey("stamp_created_by", $struct);
            $this->assertArrayHasKey("stamp_updated", $struct);
            $this->assertArrayHasKey("stamp_updated_by", $struct);
            $this->assertArrayHasKey("allowed_fields", $struct);
            $this->assertArrayHasKey("allowed_additional_content", $struct);
        }

    }

    public function testGetStructureByPrefix() {
        $objStructure = $this->pageStruct->getStructureByPrefix($this->category->category_name);
        $this->assertInstanceOf(AppsStruct::class, $objStructure);
        $this->assertEquals($this->structInstance->struct_id, $objStructure->struct_id);

        $this->assertTrue(isset($objStructure->allowed_fields));

        $allowedFields = $objStructure->allowed_fields;

        $this->assertCount(count($this->states), $allowedFields);

        foreach ($this->attributes as $state => $attribute) {
            $this->assertArrayHasKey($state, $allowedFields);

            $this->assertCount(is_array($attribute) ? count($attribute) : 1, $allowedFields[$state]);

            if (is_object($attribute)) {
                $arrAttribute = collect($allowedFields[$state])->where("attribute_uuid", $attribute->attribute_uuid)->first();

                $this->assertIsArray($arrAttribute);
            }
        }

        $this->assertTrue(isset($objStructure->allowed_additional_content));

        $arrAdditionalContent = $objStructure->allowed_additional_content;
        $structContent = $this->structInstance->struct_json["content"];

        $this->assertCount(count($structContent), $arrAdditionalContent);
        $this->assertEquals($structContent, $arrAdditionalContent);
    }


    public function testGetStructureByInvalidPrefix() {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("Structure Not Found.");
        $arrStructure = $this->pageStruct->getStructureByPrefix(time());
    }

    public function testGetStructureByUuid() {
        $objStructure = $this->pageStruct->getStructureByUuid($this->structInstance->struct_uuid);
        $this->assertInstanceOf(AppsStruct::class, $objStructure);
        $this->assertEquals($this->structInstance->struct_id, $objStructure->struct_id);

        $this->assertTrue(isset($objStructure->allowed_fields));

        $allowedFields = $objStructure->allowed_fields;

        $this->assertCount(count($this->states), $allowedFields);

        foreach ($this->attributes as $state => $attribute) {
            $this->assertArrayHasKey($state, $allowedFields);

            $this->assertCount(is_array($attribute) ? count($attribute) : 1, $allowedFields[$state]);

            if (is_object($attribute)) {
                $arrAttribute = collect($allowedFields[$state])->where("attribute_uuid", $attribute->attribute_uuid)->first();

                $this->assertIsArray($arrAttribute);
            }
        }

        $this->assertTrue(isset($objStructure->allowed_additional_content));

        $arrAdditionalContent = $objStructure->allowed_additional_content;
        $structContent = $this->structInstance->struct_json["content"];

        $this->assertCount(count($structContent), $arrAdditionalContent);
        $this->assertEquals($structContent, $arrAdditionalContent);
    }

    public function testGetStructureByInvalidUuid() {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("Structure Not Found.");
        $arrStructure = $this->pageStruct->getStructureByUuid(Util::uuid());
    }

    public function testValidateParams() {
        $arrStructure = $this->pageStruct->validateParams($this->structInstance->struct_uuid, "color",
            $this->attributes["color"]->attribute_uuid);

        $this->assertIsBool($arrStructure);
        $this->assertTrue($arrStructure);
    }

    public function testValidateParamsNotPass() {
        $arrStructure = $this->pageStruct->validateParams($this->structInstance->struct_uuid, "color", Util::uuid());

        $this->assertIsBool($arrStructure);
        $this->assertFalse($arrStructure);
    }

    public function testValidateContent() {
        $arrStructure = $this->pageStruct->validateContent($this->structInstance->struct_uuid, "header");

        $this->assertIsBool($arrStructure);
        $this->assertTrue($arrStructure);
    }

    public function testValidateContentNotPass() {
        $arrStructure = $this->pageStruct->validateContent($this->structInstance->struct_uuid, "invalidKey");

        $this->assertIsBool($arrStructure);
        $this->assertFalse($arrStructure);
    }
}
