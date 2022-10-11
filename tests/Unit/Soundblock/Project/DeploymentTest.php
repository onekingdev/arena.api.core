<?php

namespace Tests\Unit\Soundblock\Project;

use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Users\User as UserModel;
use App\Models\Common\QueueJob as QueueJobModel;
use App\Models\Soundblock\Platform as PlatformModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use Illuminate\Support\{Collection, Facades\Queue, Facades\Config};
use App\Models\Soundblock\Collections\Collection as CollectionModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;
use App\Contracts\Soundblock\Projects\Deployment as DeploymentContract;
use App\Models\Soundblock\Projects\Deployments\Deployment as DeploymentModel;
use App\Models\Soundblock\Projects\Deployments\DeploymentStatus as DeploymentStatusModel;

class DeploymentTest extends TestCase
{
    private $user;
    private $deploymentService;
    private $serviceModel;
    private $projectModel;
    private $collectionModel;
    private $deploymentModel;

    public function setUp(): void {
        parent::setUp();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->deploymentService = resolve(DeploymentContract::class);
        $this->serviceModel = ServiceModel::factory()->create([
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid
        ]);
        $this->projectModel = $this->serviceModel->projects()->save(ProjectModel::factory()->make());
        $this->collectionModel = CollectionModel::factory()->create([
            "project_id" => $this->projectModel->project_id,
            "project_uuid" => $this->projectModel->project_uuid,
        ]);

        $this->deploymentModel = DeploymentModel::factory()->create([
            "project_id" => $this->projectModel->project_id,
            "project_uuid" => $this->projectModel->project_uuid,
            "collection_id" => $this->collectionModel->collection_id,
            "collection_uuid" => $this->collectionModel->collection_uuid,
            "platform_id" => PlatformModel::first()->platform_id,
            "platform_uuid" => PlatformModel::first()->platform_uuid,
        ]);

        /** @var App $objApp */
        $objApp = App::where("app_name", "office")->first();

        /** @var AuthGroup $objGroup */
        $objGroup = AuthGroup::where("group_name", "App.Office")->first();
        $objGroup->users()->attach($this->user->user_id, [
            "row_uuid"   => Util::uuid(),
            "user_uuid"  => $this->user->user_uuid,
            "group_uuid" => $objGroup->group_uuid,
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
        ]);
    }

    public function testCreateMultiple(){
        /* Set Global App */
        $objApp = App::where("app_name", "soundblock")->first();
        Config::set("global.app", $objApp);
        /* Set Params */
        $arrParams = [
            "deployments" => [
                [
                    "project" => $this->projectModel->project_uuid,
                    "platform" => [PlatformModel::where("platform_id", "!=", $this->deploymentModel->platform_id)->first()->platform_uuid]
                ]
            ]
        ];

        $objCollections = $this->deploymentService->createMultiple($arrParams);
        foreach ($objCollections as $objDeployment){
            $this->assertInstanceOf(Collection::class, $objDeployment);
        }
    }

    public function testCreate(){
        /* Set Global App */
        $objApp = App::where("app_name", "soundblock")->first();
        Config::set("global.app", $objApp);

        $objDeployment = $this->deploymentService->create($this->projectModel,
            [PlatformModel::where("platform_id", "!=", $this->deploymentModel->platform_id)->first()->platform_uuid]
        );

        $this->assertInstanceOf(Collection::class, $objDeployment);
    }

    public function testCreateDeploymentStatus(){
        $objDeploymentStatus = $this->deploymentService->createDeploymentStatus($this->deploymentModel);

        $this->assertInstanceOf(DeploymentStatusModel::class, $objDeploymentStatus);
        $this->assertEquals($this->deploymentModel->deployment_uuid, $objDeploymentStatus->deployment_uuid);
    }

    public function testFindAllByProject(){
        $objCollections = $this->deploymentService->findAllByProject(ProjectModel::first()->project_uuid);

        foreach ($objCollections as $objDeployment){
            $this->assertInstanceOf(DeploymentModel::class, $objDeployment);
        }
    }

    public function testUpdateDeploymentStatus(){
        $objDeploymentStatus = $this->deploymentService->createDeploymentStatus($this->deploymentModel);

        $arrParams = [
            "deployment_status" => "failed"
        ];
        $objDeployment = $this->deploymentService->update($this->deploymentModel, $arrParams);

        $objDeploymentStatus = $this->deploymentService->updateDeploymentStatus($objDeploymentStatus, $objDeployment);

        $this->assertInstanceOf(DeploymentStatusModel::class, $objDeploymentStatus);
        $this->assertEquals($objDeploymentStatus->deployment_status, $objDeployment->deployment_status);
    }

    public function testZipCollection(){
        /* Set Auth User */
        Passport::actingAs($this->user);
        Queue::fake();


        /* Set Global App */
        $objApp = App::where("app_name", "soundblock")->first();
        Config::set("global.app", $objApp);

        $objQueueQob = $this->deploymentService->zipCollection($this->deploymentModel->deployment_uuid);

        $this->assertInstanceOf(QueueJobModel::class, $objQueueQob);
    }

    public function testFind(){
        $objDeployment = $this->deploymentService->find($this->deploymentModel->deployment_uuid);

        $this->assertInstanceOf(DeploymentModel::class, $objDeployment);
        $this->assertEquals($this->deploymentModel->deployment_uuid, $objDeployment->deployment_uuid);
    }

    public function testFindLatest(){
        $objDeployment = $this->deploymentService->findLatest($this->projectModel);

        $this->assertInstanceOf(DeploymentModel::class, $objDeployment);
        $this->assertEquals($this->projectModel->project_uuid, $objDeployment->project_uuid);
    }

//    public function testDownload(){
//        $res = $this->deploymentService->download($this->collectionModel->collection_uuid);
//        dd($res);
//    }

    public function testUpdate(){
        $arrParams = [
            "deployment_status" => "failed"
        ];

        $objDeployment = $this->deploymentService->update($this->deploymentModel, $arrParams);

        $this->assertInstanceOf(DeploymentModel::class, $objDeployment);
        $this->assertEquals("failed", $objDeployment->deployment_status);
    }
}
