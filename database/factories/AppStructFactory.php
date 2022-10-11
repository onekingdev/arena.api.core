<?php

namespace Database\Factories;

use App\Models\Core\AppsStruct;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppStructFactory extends Factory {

    protected $model = AppsStruct::class;

    public function definition() {
        return [
            "struct_uuid" => Util::uuid(),
        ];
    }
}