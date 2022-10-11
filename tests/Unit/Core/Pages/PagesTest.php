<?php

namespace Tests\Unit\Core\Pages;

use App\Helpers\Util;
use App\Models\Apparel\Attribute;
use App\Models\Apparel\Category;
use App\Models\Core\App;
use App\Models\Core\AppsPage;
use Faker\Factory;
use Tests\TestCase;
use App\Contracts\Core\AppsPages as AppsPagesContract;

class PagesTest extends TestCase {
    private AppsPagesContract $pageStructService;
    private array $attributes = [];
    /**
     * @var string[]
     */
    private array $states;
    private $appModel;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $category;
    private $structInstance;
    private $appPage;

    public function setUp(): void {
        parent::setUp();
        $faker = Factory::create();

        $this->pageStructService = resolve(AppsPagesContract::class);

        $this->states = ["color", "size", "style", "weight"];
        $this->appModel = App::where("app_name", "apparel")->first();

        $this->category = Category::factory()->create();

        foreach ($this->states as $states) {
            $this->attributes[$states][] = $this->category->attributes()->create(Attribute::factory($states)->make([
                "category_uuid" => $this->category->category_uuid,
            ])->toArray())->value("attribute_uuid");
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

        $this->appPage = $this->structInstance->pages()->create(AppsPage::factory()->make([
            "struct_uuid" => $this->structInstance->struct_uuid,
            "page_json"   => [
                "meta" => [
                    "flag_twitter"     => 0,
                    "page_title"       => implode(" ", $faker->words(3)) . time(),
                    "page_description" => "description",
                    "page_keywords"    => "keyword",
                ],
                "params" => $this->attributes,
                "content" => [
                    "header" => $faker->randomHtml()
                ]
            ]
        ])->toArray());

//        dd($this->appPage->page_json);
//
//        dd($this->appPage);
    }


    public function testGetAllPages() {
        $count = AppsPage::count();
        $arrPages = $this->pageStructService->getPages();

        $this->assertCount($count, $arrPages);
    }

    public function testGetPageByUrl() {
        $objPage = $this->pageStructService->getPageByURL($this->appPage->page_url, $this->appPage->struct_uuid);
        $this->assertInstanceOf(AppsPage::class, $objPage);
        $this->assertEquals($objPage->page_uuid, $this->appPage->page_uuid);
    }

    public function testGetPageByInvalidUrl() {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("Page Not Found.");
        $arrStructure = $this->pageStructService->getPageByURL(time(), time());
    }

    public function testGetPageByUuid() {
        $objPage = $this->pageStructService->getPageByUuid($this->appPage->page_uuid);
        $this->assertInstanceOf(AppsPage::class, $objPage);
        $this->assertEquals($objPage->page_uuid, $this->appPage->page_uuid);
    }

    public function testGetInvalidPageByUuid() {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("Page Not Found.");
        $arrStructure = $this->pageStructService->getPageByUuid(Util::uuid());
    }
}
