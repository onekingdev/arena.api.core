<?php

namespace Tests\Unit\Soundblock\Files;

use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use App\Models\Soundblock\Files\Directory as DirectoryModel;
use App\Contracts\Soundblock\Files\Directory as DirectoryContract;
use App\Models\Soundblock\Collections\Collection as CollectionModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;

class DirectoryTest extends TestCase
{
    private $user;
    private CollectionModel $collectionModel;
    private $directoryService;
    private $directoryModel;
    private $serviceModel;
    private $projectModel;

    public function setUp(): void {
        parent::setUp();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->directoryService = resolve(DirectoryContract::class);
        $this->directoryModel = DirectoryModel::factory()->create();

        $this->serviceModel = ServiceModel::factory()->create([
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid
        ]);
        $this->projectModel = $this->serviceModel->projects()->save(ProjectModel::factory()->make());
        $this->collectionModel = CollectionModel::factory()->create([
            "project_id" => $this->projectModel->project_id,
            "project_uuid" => $this->projectModel->project_uuid,
        ]);

        $this->collectionModel->directories()->attach($this->directoryModel->directory_id, [
            "row_uuid" => Util::uuid(),
            "collection_uuid" => $this->collectionModel->collection_uuid,
            "directory_uuid" => $this->directoryModel->directory_uuid
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

    public function testFind(){
        $objDirectory = $this->directoryService->find($this->directoryModel->directory_uuid);

        $this->assertInstanceOf(DirectoryModel::class, $objDirectory);
    }

    public function testFindByPath(){
        $objDirectory = $this->directoryService->findByPath($this->collectionModel, $this->directoryModel->directory_sortby);

        $this->assertInstanceOf(DirectoryModel::class, $objDirectory);
        $this->assertEquals($this->directoryModel->directory_uuid, $objDirectory->directory_uuid);
    }

    public function testFindAllByUnderPath(){
        $objCollections = $this->directoryService->findAllByUnderPath($this->collectionModel, $this->directoryModel->directory_path);

        foreach ($objCollections as $objDirectory){
            $this->assertInstanceOf(DirectoryModel::class, $objDirectory);
        }
    }

    public function testFindAllByPath(){
        $objCollections = $this->directoryService->findAllByPath($this->collectionModel, $this->directoryModel->directory_path);

        foreach ($objCollections as $objDirectory){
            $this->assertInstanceOf(DirectoryModel::class, $objDirectory);
        }
    }

    public function testCreate(){
        $objCollection = CollectionModel::factory()->create([
            "project_id" => $this->projectModel->project_id,
            "project_uuid" => $this->projectModel->project_uuid,
        ]);
        $arrDirectory = [
            "directory_path" => "Other",
            "directory_name" => "Test",
        ];
        $objDirectory = $this->directoryService->create($arrDirectory, $objCollection);

        $this->assertInstanceOf(DirectoryModel::class, $objDirectory);
    }

    public function testUpdate(){
        $arrDirectory = [
            "directory_name" => "NewDirName",
            "directory_path" => "Other",
        ];
        $objDirectory = $this->directoryService->update($this->directoryModel, $arrDirectory);

        $this->assertInstanceOf(DirectoryModel::class, $objDirectory);
        $this->assertEquals("NewDirName", $objDirectory->directory_name);
    }

    public function testGetParam(){
        $arrRes = $this->directoryService->getParam($this->directoryModel);

        $this->assertIsArray($arrRes);
        $this->assertArrayHasKey("directory_uuid", $arrRes);
        $this->assertArrayHasKey("directory_name", $arrRes);
        $this->assertArrayHasKey("directory_path", $arrRes);
        $this->assertArrayHasKey("directory_sortby", $arrRes);
    }
}
