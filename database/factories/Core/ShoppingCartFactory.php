<?php

namespace Database\Factories\Core;

use App\Helpers\Util;
use App\Models\Core\ShoppingCart;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShoppingCartFactory extends Factory {
    protected $model = ShoppingCart::class;

    public function definition() {
        return [
            "row_uuid"       => Util::uuid(),
            "user_ip"        => "127.0.0.1",
            "payment_id"     => "pi_" . $this->faker->numberBetween(1000, 20000),
            "payment_method" => "pm_" . $this->faker->numberBetween(1000, 20000),
            "status"         => "new"
        ];
    }
}
