<?php

namespace Database\Factories\Soundblock\Projects\Contracts;

use App\Models\Soundblock\Projects\Contracts\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory {
    protected $model = Contract::class;

    public function definition() {
        return [
            "flag_status" => "Pending"
        ];
    }

    public function active() {
        return $this->state(function (array $attributes) {
            return [
                "flag_status" => "Active"
            ];
        });
    }

    public function failed() {
        return $this->state(function (array $attributes) {
            return [
                "flag_status" => "Failed"
            ];
        });
    }

    public function modifying() {
        return $this->state(function (array $attributes) {
            return [
                "flag_status" => "Modifying"
            ];
        });
    }
}