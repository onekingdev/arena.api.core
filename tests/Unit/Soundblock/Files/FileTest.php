<?php

namespace Tests\Unit\Soundblock\Files;

use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Files\File as FileModel;
use App\Contracts\Soundblock\Files\File as FileContract;
use App\Models\Soundblock\Files\FileMusic as FileMusicModel;
use App\Models\Soundblock\Files\FileVideo as FileVideoModel;
use App\Models\Soundblock\Files\FileMerch as FileMerchModel;
use App\Models\Soundblock\Files\FileOther as FileOtherModel;
use App\Models\Soundblock\Collections\Collection as CollectionModel;
use App\Models\Soundblock\Projects\ProjectDraft as ProjectDraftModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;

class FileTest extends TestCase
{
    private $user;
    private $fileService;
    /**
     * @var FileModel
     */
    private FileModel $fileModel;
    /**
     * @var CollectionModel
     */
    private CollectionModel $collectionModel;

    public function setUp(): void {
        parent::setUp();

        $this->fileService = resolve(FileContract::class);
        $this->fileModel = new FileModel();
        $this->collectionModel = new CollectionModel();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

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

    public function testFindWhere(){
        $arrWhere = [];
        foreach($this->fileModel->paginate(3) as $file){
            array_push($arrWhere, [ "file_uuid" => $file->file_uuid ] );
        }

        $objFiles = $this->fileService->findWhere($arrWhere);

        foreach($objFiles as $objFile){
            $this->assertInstanceOf(FileModel::class, $objFile);
        }
        $this->assertCount(3, $objFiles);
    }

    public function testCreateInCollection(){
        $name = rand(1, 1000) . ".png";
        $arrFile = [
            "file_name" => $name,
            "file_path" => "path",
            "file_sortby" => "Other/" . $name,
            "file_category" => "other",
            "file_size" => 103332,
            "file_md5" => md5($name),
            "file_title" => "Test",
        ];
        $objFile = $this->fileService->createInCollection($arrFile, $this->collectionModel->first(), $this->user);

        $this->assertInstanceOf(FilemOdel::class, $objFile);
        $this->assertEquals($name, $objFile->file_name);
    }

    public function testCreate(){
        $name = rand(1, 1000) . ".png";
        $arrFile = [
            "file_name" => $name,
            "file_path" => "path",
            "file_sortby" => "Other/" . $name,
            "file_category" => "other",
            "file_size" => 103332,
            "file_md5" => md5($name),
            "file_title" => "Test",
        ];
        $objFile = $this->fileService->create($arrFile);

        $this->assertInstanceOf(FilemOdel::class, $objFile);
        $this->assertEquals($name, $objFile->file_name);
    }

    public function testUpdate(){
        $name = rand(1, 1000) . ".png";
        $arrFile = [
            "file" => $this->fileModel->first()->file_uuid,
            "file_name" => $name,
            "file_path" => "path",
            "file_sortby" => "Other/" . $name,
            "file_category" => "other",
            "file_size" => 103332,
            "file_md5" => md5($name),
            "file_title" => "Test",
        ];
        $objFile = $this->fileService->update($this->fileModel->first(), $arrFile);

        $this->assertInstanceOf(FilemOdel::class, $objFile);
        $this->assertEquals($name, $objFile->file_name);
    }

    public function testInsertMusicRecord(){
        $fileMusic = FileModel::factory()->create(["file_category" => "music"]);
        $arrFile = [
            "file_track" => rand(1, 10),
            "file_duration" => rand(100, 200),
        ];
        $objFile = $this->fileService->insertMusicRecord($fileMusic, $arrFile);

        $this->assertInstanceOf(FileMusicModel::class, $objFile);
    }

    public function testInsertVideoRecord(){
        $arrFile = [
            "file_isrc" => "NOX001212345"
        ];
        $fileVideo = FileModel::factory()->create(["file_category" => "video"]);
        $objFile = $this->fileService->insertVideoRecord($fileVideo, $arrFile);

        $this->assertInstanceOf(FileVideoModel::class, $objFile);
    }

    public function testInsertMerchRecord(){
        $arrFile = [
            "file_sku" => "4225-776-3234"
        ];
        $fileMerch = FileModel::factory()->create(["file_category" => "merch"]);
        $objFile = $this->fileService->insertMerchRecord($fileMerch, $arrFile);

        $this->assertInstanceOf(FileMerchModel::class, $objFile);
    }

    public function testInsertOtherRecord(){
        $fileOther = FileModel::factory()->create(["file_category" => "other"]);
        $objFile = $this->fileService->insertOtherRecord($fileOther);

        $this->assertInstanceOf(FileOtherModel::class, $objFile);
    }

    public function testCreateInDraft(){
        $name = rand(1, 1000) . ".png";
        $arrFile = [
            "file_name" => $name,
            "file_path" => "path",
            "file_sortby" => "Other/" . $name,
            "file_category" => "other",
            "file_size" => 103332,
            "file_md5" => md5($name),
            "file_title" => "Test",
        ];
        $objDraft = $this->fileService->createInDraft($arrFile, ProjectDraftModel::first());

        $this->assertInstanceOf(ProjectDraftModel::class, $objDraft);
    }

    public function testUpdateMusicFile(){
        $fileMusic = FileModel::factory()->create(["file_category" => "music"]);
        $checkTrack = rand(1, 10);
        $arrFile = [
            "file_track" => rand(1, 10),
            "file_duration" => rand(100, 200),
        ];
        $this->fileService->insertMusicRecord($fileMusic, $arrFile);
        $objFile = $this->fileService->updateMusicFile($fileMusic, $checkTrack);

        $this->assertInstanceOf(FileModel::class, $objFile);
        $this->assertEquals($objFile->music->file_track, $checkTrack);
    }

    public function testFind(){
        $fileMusic = FileModel::factory()->create(["file_category" => "music"]);
        $objFile = $this->fileService->find($fileMusic->file_uuid);

        $this->assertInstanceOf(FileModel::class, $objFile);
        $this->assertEquals($fileMusic->file_uuid, $objFile->file_uuid);
    }

    public function testGetParam(){
        $fileMusic = FileModel::factory()->create(["file_category" => "music"]);
        $arrFile = [
            "file_track" => rand(1, 10),
            "file_duration" => rand(100, 200),
        ];
        $this->fileService->insertMusicRecord($fileMusic, $arrFile);
        $arrRes = $this->fileService->getParam($fileMusic, false);

        $this->assertArrayHasKey("file_uuid", $arrRes);
        $this->assertEquals($fileMusic->file_uuid, $arrRes["file_uuid"]);
    }

    public function testAddTimeCodes(){
        $fileMusic = FileModel::factory()->create(["file_category" => "music"]);
        $arrFile = [
            "file_track" => rand(1, 10),
            "file_duration" => rand(100, 200),
        ];
        $this->fileService->insertMusicRecord($fileMusic, $arrFile);
        $objFile = $this->fileService->addTimeCodes($fileMusic, 0.10, 0.40);

        $this->assertInstanceOf(FileModel::class, $objFile);
    }

    public function testGetTimecodes(){
        $fileMusic = FileModel::factory()->create(["file_category" => "music"]);
        $arrFile = [
            "file_track" => rand(1, 10),
            "file_duration" => rand(100, 200),
            "preview_start" => "0:10",
            "preview_stop" => "0:40",
        ];
        $this->fileService->insertMusicRecord($fileMusic, $arrFile);
        $arrRes = $this->fileService->getTimecodes($fileMusic);

        $this->assertIsArray($arrRes);
        $this->assertArrayHasKey("preview_start", $arrRes);
        $this->assertArrayHasKey("preview_stop", $arrRes);
    }
}
