<?php

namespace Database\Factories\Soundblock\Projects\Deployments;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Soundblock\Projects\Deployments\Deployment;

class DeploymentFactory extends Factory {
    protected $model = Deployment::class;

    public function definition() {
        return [
            "deployment_uuid" => Util::uuid(),
            "deployment_status" => "Pending"
        ];
    }
}
