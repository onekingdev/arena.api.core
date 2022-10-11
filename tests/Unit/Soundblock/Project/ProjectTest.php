<?php

namespace Tests\Unit\Soundblock\Project;

use App\Models\Core\Auth\AuthModel;
use App\Models\Core\Auth\AuthPermission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use App\Contracts\Soundblock\Projects\Project as ProjectContract;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;

class ProjectTest extends TestCase
{
    private ProjectModel $projectModel;
    private $user;
    private $projectService;
    private ServiceModel $serviceModel;

    public function setUp(): void {
        parent::setUp();

        /** @var App $objApp */
        $objApp = App::where("app_name", "soundblock")->first();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->projectService = resolve(ProjectContract::class);

        $this->serviceModel = ServiceModel::factory()->create([
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid
        ]);

        $this->projectModel = $this->serviceModel->projects()->save(ProjectModel::factory()->make());

        $auth = AuthModel::where("auth_name", "App.Soundblock")->firstOrFail();
        /** @var AuthGroup $authGroup */
        $authGroup = AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $auth->auth_id,
            "auth_uuid"     => $auth->auth_uuid,
            "group_name"    => sprintf("App.Soundblock.Project.%s", $this->projectModel->project_uuid),
            "group_memo"    => sprintf("App.Soundblock.Project.( %s )", $this->projectModel->project_uuid),
            "flag_critical" => true,
        ]);

        $authGroup->users()->attach($this->user->user_id, [
            "row_uuid"   => Util::uuid(),
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
            "group_uuid" => $authGroup->group_uuid,
            "user_uuid"  => $this->user->user_uuid,
        ]);

        $objContractPermission = AuthPermission::where("permission_name", "App.Soundblock.Account.Project.Contract")
                                               ->first();

        $authGroup->permissions()->attach($objContractPermission->permission_id, [
            "row_uuid"         => Util::uuid(),
            "group_uuid"       => $authGroup->group_uuid,
            "permission_uuid"  => $objContractPermission->permission_id,
            "permission_value" => true,
        ]);
    }

    public function testCreate(){
        Passport::actingAs($this->user);
        $objApp = App::where("app_name", "soundblock")->first();
        $objAuth = AuthModel::where("auth_name", "App.Soundblock")->first();
        Config::set("global.app", $objApp);
        Config::set("global.auth", $objAuth);

        $arrParams = [
            "service" => $this->serviceModel->service_uuid,
            "project_title" => "TestTitle",
            "project_label" => "TestLabel",
            "project_type" => "Album",
            "project_date" => "2020-08-18"
        ];
        $objProject = $this->projectService->create($arrParams);

        $this->assertInstanceOf(ProjectModel::class, $objProject);
        $this->assertEquals($this->serviceModel->service_uuid, $objProject->service_uuid);
    }

    public function testUploadArtwork(){
        $objProject = $this->projectService->uploadArtwork($this->projectModel, UploadedFile::fake()->image(rand(1, 1000) . ".png"));

        $this->assertInstanceOf(ProjectModel::class, $objProject);
    }

    public function testFindAll(){
        $objProjects = $this->projectService->findAll();

        foreach($objProjects as $objProject){
            $this->assertInstanceOf(ProjectModel::class, $objProject);
        }
    }

    public function testFindAllByDeployment(){
        $objProjects = $this->projectService->findAllByDeployment("Deployed");

        if (!empty($objProjects)) {
            foreach($objProjects as $objProject){
                $this->assertInstanceOf(ProjectModel::class, $objProject);
            }
        }

        $this->assertTrue(true);
    }

//    public function testPingExtractingZip(){
//        $res = $this->projectService->pingExtractingZip(["project" => $this->projectModel->project_uuid]);
//        dd($res);
//    }

    public function testFind(){
        $objProject = $this->projectService->find($this->projectModel->project_uuid);

        $this->assertInstanceOf(ProjectModel::class, $objProject);
        $this->assertEquals($this->projectModel->project_uuid, $objProject->project_uuid);
    }

//    public function testFindAllByUser(){
//        $objProjects = $this->projectService->findAllByUser(10, $this->user);
//        dd($objProjects);
//    }

    public function testFindUserProject(){
        $objProject = $this->projectService->findUserProject($this->projectModel->project_uuid, $this->user);

        $this->assertInstanceOf(ProjectModel::class, $objProject);
    }

//    public function testAddFile(){
//        $arrParams = [
//            "project" => $this->projectModel->project_uuid,
//            "files" => UploadedFile::fake()->image(rand(1, 1000) . ".png")
//        ];
//        $res = $this->projectService->addFile($arrParams);
//        dd($res);
//    }

    public function testStorePayment(){
        $objApp = App::where("app_name", "soundblock")->first();
        $objAuth = AuthModel::where("auth_name", "App.Soundblock")->first();
        Config::set("global.app", $objApp);
        Config::set("global.auth", $objAuth);

        $arrParams = [
            "members" => [
                [
                    "user_auth_email" => $this->user->getPrimaryEmailAttribute()->user_auth_email,
                    "user_name" => "TestName",
                    "user_payout" => 20,
                    "user_role" => "Lawyer"
                ]
            ]
        ];
        $objProject = $this->projectService->storePayment($this->projectModel, $arrParams);

        $this->assertInstanceOf(ProjectModel::class, $objProject);
    }

    public function testUpdate(){
        $arrParams = [
            "title" => "Updated Title",
            "type" => "Album",
            "date" => "2020-10-10",
        ];
        $objProject = $this->projectService->update($this->projectModel, $arrParams);

        $this->assertInstanceOf(ProjectModel::class, $objProject);
        $this->assertEquals("Updated Title", $objProject->project_title);
        $this->assertEquals("Album", $objProject->project_type);
        $this->assertEquals("2020-10-10", $objProject->project_date);
    }

    public function testGetUsers(){
        $collectionUsers = $this->projectService->getUsers(ProjectModel::first()->project_uuid);

        if (count($collectionUsers) > 0){
            foreach($collectionUsers as $objUser){
                $this->assertInstanceOf(UserModel::class, $objUser);
            }
        }
    }

    public function testCheckUserInProject(){
        $boolResult = $this->projectService->checkUserInProject(ProjectModel::first()->project_uuid, UserModel::first());

        $this->assertIsBool($boolResult);
    }

    public function testUploadArtworkForDraft(){
        $strFileName = $this->projectService->uploadArtworkForDraft(UploadedFile::fake()->image(rand(1, 1000) . ".png"));

        $this->assertIsString($strFileName);
    }
}
