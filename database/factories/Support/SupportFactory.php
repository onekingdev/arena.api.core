<?php

namespace Database\Factories\Support;

use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Support\Support;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Support::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $objApp = App::where("app_name", "office")->first();
        return [
            "support_uuid" => Util::uuid(),
            "app_id" => $objApp->app_id,
            "app_uuid" => $objApp->app_uuid,
            "support_category" => "Customer Service"
        ];
    }
}
