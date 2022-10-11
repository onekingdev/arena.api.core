<?php

namespace Tests\Unit\Soundblock\Collection;

use App\Services\Soundblock\Collection;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use Laravel\Passport\Passport;
use App\Models\Common\QueueJob;
use Illuminate\Http\UploadedFile;
use App\Models\Core\Auth\AuthGroup;
use Illuminate\Support\Facades\Config;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Files\File as FileModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Files\Directory as DirectoryModel;
use App\Models\Soundblock\Collections\Collection as CollectionModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;
use App\Contracts\Soundblock\Collection\Collection as CollectionContract;

class CollectionTest extends TestCase {
    private $user;
    private Collection $collectionService;
    private $collectionModel;
    private $serviceModel;
    private $projectModel;
    private $directoryModel;
    private FileModel $fileModel;

    public function setUp(): void {
        parent::setUp();

        Queue::fake();

        $this->user = UserModel::factory()->create();
        $this->directoryModel = DirectoryModel::factory()->create();
        $this->fileModel = FileModel::factory()->create([
            "file_category" => "music",
            "file_path"     => "Music",
        ]);

        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->serviceModel = ServiceModel::factory()->create([
            "user_id"   => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid,
        ]);
        $this->projectModel = $this->serviceModel->projects()->save(ProjectModel::factory()->make([
            "service_uuid" => $this->serviceModel->service_uuid
        ]));
        $this->collectionModel = $this->projectModel->collections()->save(CollectionModel::factory()->make([
            "project_uuid" => $this->projectModel->project_uuid,
        ]));
        $this->collectionModel->directories()->attach($this->directoryModel->directory_id, [
            "row_uuid"        => Util::uuid(),
            "directory_uuid"  => $this->directoryModel->directory_uuid,
            "collection_uuid" => $this->collectionModel->collection_uuid,
        ]);
        $this->collectionModel->files()->attach($this->fileModel->file_id, [
            "row_uuid"        => Util::uuid(),
            "file_uuid"       => $this->fileModel->file_uuid,
            "collection_uuid" => $this->collectionModel->collection_uuid,
        ]);
        $this->fileModel->music()->create([
            "row_uuid"      => Util::uuid(),
            "file_uuid"     => $this->fileModel->file_uuid,
            "file_track"    => 1,
            "file_duration" => 197,
            "file_isrc"     => "US-AEA-81-00001",
        ]);

        $this->fileModel->collectionshistory()->attach($this->collectionModel->collection_id, [
            "row_uuid"        => Util::uuid(),
            "collection_uuid" => $this->collectionModel->collection_uuid,
            "file_uuid"       => $this->fileModel->file_uuid,
            "file_action"     => "Created",
            "file_category"   => "music",
            "file_memo"       => "Test" . time(),
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

        $this->collectionService = resolve(CollectionContract::class);
    }

    public function testFindAllByProject() {
        $projectUuid = $this->projectModel->project_uuid;
        $objCollections = $this->collectionService->findAllByProject($projectUuid);

        foreach ($objCollections as $objCollection) {
            $this->assertInstanceOf(CollectionModel::class, $objCollection);
            $this->assertEquals($projectUuid, $objCollection->project_uuid);
        }
    }

    public function testGetTreeStructure() {
        $arrRes = $this->collectionService->getTreeStructure($this->collectionModel->collection_uuid);

        $this->assertArrayHasKey("music", $arrRes);
        $this->assertArrayHasKey("video", $arrRes);
        $this->assertArrayHasKey("merch", $arrRes);
        $this->assertArrayHasKey("other", $arrRes);
    }

    public function testFind() {
        $collectionUuid = $this->collectionModel->collection_uuid;
        $objCollection = $this->collectionService->find($collectionUuid);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
        $this->assertEquals($collectionUuid, $objCollection->collection_uuid);
    }

    public function testUploadFile() {
        $file = UploadedFile::fake()->image(rand(1, 1000) . ".png");
        $strFileName = $this->collectionService->uploadFile(["file" => $file]);

        $this->assertIsString($strFileName);
    }

    public function testCreate() {
        $objCollection = $this->collectionService->create($this->projectModel, ["collection_comment" => "test"]);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
        $this->assertEquals($this->projectModel->project_uuid, $objCollection->project_uuid);
    }

    public function testGetTracks() {
        $objFiles = $this->collectionService->getTracks($this->collectionModel->collection_uuid);

        foreach ($objFiles as $objFile) {
            $this->assertInstanceOf(FileModel::class, $objFile);
        }
    }

    public function testEditFile() {
        Passport::actingAs($this->user);
        $arrParams = [
            "project"            => $this->projectModel->project_uuid,
            "files"              => [
                [
                    "file_uuid"  => $this->fileModel->file_uuid,
                    "file_name"  => "test",
                    "file_title" => "test",
                ],
            ],
            "collection_comment" => "test",
        ];
        $objCollection = $this->collectionService->editFile($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    public function testGetFilesToAdd() {
        $arrFiles = [
            [
                "file_uuid" => FileModel::first(),
            ],
        ];
        $arrRes = $this->collectionService->getFilesToAdd($this->collectionModel->files, $arrFiles);

        foreach ($arrRes as $objFile) {
            $this->assertInstanceOf(FileModel::class, $objFile);
        }
    }

    public function testOrganizeMusics() {
        Passport::actingAs($this->user);
        $arrParams = [
            "collection"         => $this->collectionModel->collection_uuid,
            "files"              => [
                [
                    "file_uuid"  => $this->fileModel->file_uuid,
                    "file_track" => 1,
                ],
            ],
            "collection_comment" => "test",
        ];
        $objCollection = $this->collectionService->organizeMusics($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    public function testAddDirectory() {
        Passport::actingAs($this->user);
        $arrParams = [
            "project"            => $this->projectModel->project_uuid,
            "collection_comment" => "test",
            "file_category"      => "other",
            "directory_path"     => "test",
            "directory_name"     => "test",
        ];
        $objCollection = $this->collectionService->addDirectory($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    public function testEditDirectory() {
        Passport::actingAs($this->user);

        $arrParams = [
            "project"            => $this->projectModel->project_uuid,
            "directory_sortby"   => $this->directoryModel->directory_sortby,
            "new_directory_name" => "test",
            "collection_comment" => "test",
            "file_category"      => "test",
        ];

        $objCollection = $this->collectionService->editDirectory($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    public function testGetDirsToAdd() {
        $directoryModel = DirectoryModel::factory()->create();
        $arrDirs = [
            [
                "directory_uuid" => $directoryModel->directory_uuid,
            ],
        ];
        $objCollections = $this->collectionService->getDirsToAdd(DirectoryModel::orderBy("directory_id", "desc")
                                                                               ->get(), $arrDirs);

        foreach ($objCollections as $objDirectory) {
            $this->assertInstanceOf(DirectoryModel::class, $objDirectory);
        }
    }

    public function testRestore() {
        Passport::actingAs($this->user);
        $arrParams = [
            "files"              => [
                [
                    "file_uuid" => FileModel::first()->file_uuid,
                ],
            ],
            "collection"         => CollectionModel::first()->collection_uuid,
            "collection_comment" => "test",
        ];
        $objCollection = $this->collectionService->restore($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    public function testRevert() {
        Passport::actingAs($this->user);
        $collectionModel = $this->collectionService->create($this->projectModel, ["collection_comment" => "test"]);
        $fileModel = FileModel::factory()->create([
            "file_category" => "music",
            "file_path"     => "Music",
        ]);
        $fileModel->music()->create([
            "row_uuid"      => Util::uuid(),
            "file_uuid"     => $fileModel->file_uuid,
            "file_track"    => 1,
            "file_duration" => 197,
            "file_isrc"     => "US-AEA-81-00001",
        ]);

        $fileModel->collectionshistory()->attach($this->collectionModel->collection_id, [
            "row_uuid"        => Util::uuid(),
            "collection_uuid" => $this->collectionModel->collection_uuid,
            "file_uuid"       => $fileModel->file_uuid,
            "file_action"     => "Created",
            "file_category"   => "music",
            "file_memo"       => "Test" . time(),
        ]);
        $arrParams = [
            "files"              => [
                [
                    "file_uuid" => $fileModel->file_uuid,
                ],
            ],
            "collection"         => $collectionModel->collection_uuid,
            "collection_comment" => "test",
        ];
        $objCollection = $this->collectionService->revert($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    public function testDeleteFiles() {
        Passport::actingAs($this->user);
        $fileModel = FileModel::factory()->create(["file_category" => "other"]);
        $this->collectionModel->files()->attach($fileModel->file_id, [
            "row_uuid"        => Util::uuid(),
            "collection_uuid" => $this->collectionModel->collection_uuid,
            "file_uuid"       => $fileModel->file_uuid,
        ]);

        $arrParams = [
            "project"            => $this->projectModel->project_uuid,
            "files"              => [
                [
                    "file_uuid" => $fileModel,
                ],
            ],
            "collection_comment" => "test",
        ];

        $objCollection = $this->collectionService->deleteFiles($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    public function testZipFiles() {
        /* Set Auth User */
        Passport::actingAs($this->user);
        Queue::fake();

        /* Set Global App */
        $objApp = App::where("app_name", "soundblock")->first();
        Config::set("global.app", $objApp);

        /* Create Collection with File */
        $collectionModel = $this->collectionService->create($this->projectModel, ["collection_comment" => "test"]);
        $fileModel = FileModel::factory()->create(["file_category" => "other"]);
        $collectionModel->files()->attach($fileModel->file_id, [
            "row_uuid"        => Util::uuid(),
            "collection_uuid" => $collectionModel->collection_uuid,
            "file_uuid"       => $fileModel->file_uuid,
        ]);

        /* Create Array with Params */
        $arrParams = [
            "files" => [
                [
                    "file_uuid" => $fileModel->file_uuid,
                ],
            ],
        ];

        /* Call Method */
        $resQueueJob = $this->collectionService->zipFiles($collectionModel->collection_uuid, $arrParams);

        $this->assertInstanceOf(QueueJob::class, $resQueueJob);
    }

    public function testDeleteDirectory() {
        /* Set Auth User */
        Passport::actingAs($this->user);

        $collectionModel = $this->collectionService->create($this->projectModel, ["collection_comment" => "test"]);
        $directoryModel = DirectoryModel::factory()->create();

        $collectionModel->directories()->attach($directoryModel->directory_id, [
            "row_uuid"        => Util::uuid(),
            "collection_uuid" => $collectionModel->collection_uuid,
            "directory_uuid"  => $directoryModel->directory_uuid,
        ]);

        $arrParams = [
            "project"            => $this->projectModel->project_uuid,
            "directory"          => $directoryModel->directory_uuid,
            "file_category"      => "test",
            "collection_comment" => "test",
        ];

        $objCollection = $this->collectionService->deleteDirectory($arrParams);

        $this->assertInstanceOf(CollectionModel::class, $objCollection);
    }

    // TO DO
//    public function testFilesHistory(){
//        /* Create Collection with File */
//        $collectionModel = $this->collectionService->create($this->projectModel, ["collection_comment" => "test"]);
//        $fileModel = factory(FileModel::class)->create(["file_category" => "other"]);
//        $collectionModel->files()->attach($fileModel->file_id, [
//            "row_uuid" => Util::uuid(),
//            "collection_uuid" => $collectionModel->collection_uuid,
//            "file_uuid" => $fileModel->file_uuid
//        ]);
//        $fileModel->collectionshistory()->attach($collectionModel->collection_id, [
//            "row_uuid" => Util::uuid(),
//            "collection_uuid" => $collectionModel->collection_uuid,
//            "file_uuid" => $fileModel->file_uuid
//        ]);
//
//        $arrParams = [
//            "collection" => $collectionModel->collection_uuid,
//            "file_path" => $fileModel->file_path
//        ];
//
//        $res = $this->collectionService->filesHistory($arrParams);
//        dd($res);
//    }

    public function testGetOrderedTracks() {
        $objCollections = $this->collectionService->getOrderedTracks($this->collectionModel);

        foreach ($objCollections as $objCollection) {
            $this->assertInstanceOf(FileModel::class, $objCollection);
        }
    }

    public function testGetResources() {
        /* Create Collection with File */
        $collectionModel = $this->collectionService->create($this->projectModel, ["collection_comment" => "test"]);
        $fileModel = FileModel::factory()->create(["file_category" => "other", "file_path" => "test"]);
        $collectionModel->files()->attach($fileModel->file_id, [
            "row_uuid"        => Util::uuid(),
            "collection_uuid" => $collectionModel->collection_uuid,
            "file_uuid"       => $fileModel->file_uuid,
        ]);

        $objCollection = $this->collectionService->getResources($collectionModel->collection_uuid, $fileModel->file_path);

        $this->assertIsArray($objCollection);
    }

    public function testGetFilesHistory() {
        $arr = $this->collectionService->getFilesHistory($this->fileModel->file_uuid);

        foreach ($arr as $arrFile) {
            $this->assertArrayHasKey("file_uuid", $arrFile);
            $this->assertArrayHasKey("file_action", $arrFile);
            $this->assertArrayHasKey("stamp_created", $arrFile);
            $this->assertArrayHasKey("stamp_created_by", $arrFile);
            $this->assertArrayHasKey("stamp_updated", $arrFile);
            $this->assertArrayHasKey("stamp_updated_by", $arrFile);
        }
    }

    public function testGetCollectionFilesHistory() {
        $objCollections = $this->collectionService->getCollectionFilesHistory($this->collectionModel->collection_uuid);

        foreach ($objCollections as $objFile) {
            $this->assertInstanceOf(FileModel::class, $objFile);
        }
    }
}
