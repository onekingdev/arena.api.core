<?php

namespace Tests\Unit\Soundblock\Collection;

use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Collections\Collection as CollectionModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;
use App\Models\Soundblock\Collections\CollectionHistory as CollectionHistoryModel;
use App\Contracts\Soundblock\Collection\CollectionHistory  as CollectionHistoryContract;

class CollectionHistory extends TestCase
{
    private UserModel $user;
    private CollectionModel $collectionModel;
    private $collectionHistoryService;
    private CollectionHistoryModel $collectionHistoryModel;

    public function setUp(): void {
        parent::setUp();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->collectionHistoryService = resolve(CollectionHistoryContract::class);
        $this->collectionHistoryModel = CollectionHistoryModel::first();
        $this->collectionModel = CollectionModel::factory()->create();

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
        $objCollectionHistory = $this->collectionHistoryService->find($this->collectionHistoryModel->history_uuid);

        $this->assertInstanceOf(CollectionHistoryModel::class, $objCollectionHistory);
        $this->assertEquals($this->collectionHistoryModel->history_uuid, $objCollectionHistory->history_uuid);
    }

    public function testCreate(){
        $arrParams = [
            "collection_id" => $this->collectionModel->collection_id,
            "collection_uuid" => $this->collectionModel->collection_uuid,
            "history_category" => "Multiple",
            "history_size" => "802137",
            "file_action" => "Created",
            "history_comment" => "Multiple( " . $this->collectionModel->collection_uuid . " )"
        ];
        $objCollectionHistory = $this->collectionHistoryService->create($arrParams);

        $this->assertInstanceOf(CollectionHistoryModel::class, $objCollectionHistory);
        $this->assertEquals($this->collectionModel->collection_uuid, $objCollectionHistory->collection_uuid);
    }
}
