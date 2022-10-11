<?php

namespace Database\Factories\Core;

use App\Helpers\Util;
use App\Models\Core\AppsPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppsPageFactory extends Factory {

    protected $model = AppsPage::class;

    public function definition() {
        return [
            "page_uuid"  => Util::uuid(),
            "page_url"   => $this->faker->word . time(),
        ];
    }
}

