<?php

namespace Tests\Unit\Soundblock\Service;

use App\Helpers\Util;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;
use Tests\TestCase;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use App\Models\Soundblock\Accounts\AccountPlan as ServicePlanModel;
use App\Contracts\Soundblock\Account\AccountPlan as ServicePlanContract;

class ServicePlanTest extends TestCase
{
    private ServicePlanContract $servicePlanService;
    private ServicePlanModel $servicePlanModel;
    private ServiceModel $serviceModel;
    private UserModel $userModel;

    public function setUp(): void {
        parent::setUp();

        $this->userModel = UserModel::factory()->create();
        $this->userModel->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->userModel->user_uuid]));

        $this->serviceModel = ServiceModel::factory()->create([
            "user_id" => $this->userModel->user_id,
            "user_uuid" => $this->userModel->user_uuid
        ]);
        $this->servicePlanModel = $this->serviceModel->plans()->create([
            "plan_uuid" => Util::uuid(),
            "service_uuid" => $this->serviceModel->service_uuid,
            "plan_cost" => 24.99,
            "service_date" => now(),
            "plan_type" => "Smart Block Storage",
            "flag_active" => 1,
            "version" => 1
        ]);
        $this->servicePlanService = resolve(ServicePlanContract::class);
    }

    public function testFind(){
        $objServicePlan = $this->servicePlanService->find($this->servicePlanModel->plan_uuid);

        $this->assertInstanceOf(ServicePlanModel::class, $objServicePlan);
        $this->assertEquals($objServicePlan->plan_uuid, $this->servicePlanModel->plan_uuid);
    }

    public function testCancel(){
        $objService = $this->servicePlanService->cancel($this->userModel);

        $this->assertInstanceOf(ServiceModel::class, $objService);
        $this->assertArrayHasKey("service_uuid", $objService);
        $this->assertArrayHasKey("user_uuid", $objService);
        $this->assertArrayHasKey("service_name", $objService);
        $this->assertArrayHasKey("flag_status", $objService);
        $this->assertArrayHasKey("accounting_version", $objService);
    }

    public function testCreate(){
        $objServicePlan = $this->servicePlanService->create($this->serviceModel, "Simple");

        $this->assertInstanceOf(ServicePlanModel::class, $objServicePlan);
        $this->assertArrayHasKey("service_uuid", $objServicePlan);
        $this->assertArrayHasKey("plan_cost", $objServicePlan);
        $this->assertArrayHasKey("plan_day", $objServicePlan);
        $this->assertArrayHasKey("plan_type", $objServicePlan);
        $this->assertArrayHasKey("flag_active", $objServicePlan);
        $this->assertArrayHasKey("version", $objServicePlan);
        $this->assertArrayHasKey("plan_uuid", $objServicePlan);
    }

    public function testUpdate(){
        $objServicePlan = $this->servicePlanService->update($this->userModel, "Simple Block Storage", 4.99);

        $this->assertInstanceOf(ServiceModel::class, $objServicePlan);
        $this->assertArrayHasKey("service_uuid", $objServicePlan);
        $this->assertArrayHasKey("user_uuid", $objServicePlan);
        $this->assertArrayHasKey("service_name", $objServicePlan);
        $this->assertArrayHasKey("flag_status", $objServicePlan);
        $this->assertArrayHasKey("accounting_version", $objServicePlan);
    }
}
