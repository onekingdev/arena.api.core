<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Core\App;
use Illuminate\Database\Seeder;
use App\Models\Apparel\Category;
use App\Models\Apparel\Attribute;

class AppStructureSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run() {
        /** @var App $objApparelApp */
        $objApparelApp = App::where("app_name", "apparel")->first();
        $objCategories = Category::all();

        foreach ($objCategories as $objCategory){
            $objApparelApp->structures()->create([
                "struct_uuid"   => Util::uuid(),
                "app_uuid"      => $objApparelApp->app_uuid,
                "struct_prefix" => strtolower($objCategory->category_name),
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
                                "value"  => $objCategory->category_name,
                            ],
                        ],
                    ],
                ],
            ]);
        }
    }
}
