<?php

namespace Tests\Feature\Soundblock\Project;

use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Users\User;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthModel;
use App\Models\Core\Auth\AuthPermission;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Users\Contact\UserContactEmail;
use App\Models\Soundblock\Projects\ProjectDraft;

class ProjectTest extends TestCase
{
    private Account $service;
    private User $user;
    private Project $project;

    public function setUp(): void {
        parent::setUp();
        Queue::fake();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $objApp = App::where("app_name", "soundblock")->firstOrFail();

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());

        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid,
        ])->setAppends([])->toArray());


        $this->project->team()->create([
            "team_uuid"    => Util::uuid(),
            "project_uuid" => $this->project->project_uuid,
        ]);

        $objContractPermission = AuthPermission::where("permission_name", "App.Soundblock.Account.Project.Create")
            ->first();

        $auth = AuthModel::where("auth_name", "App.Soundblock")->firstOrFail();
        /** @var AuthGroup $authGroup */
        $authGroupProject = AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $auth->auth_id,
            "auth_uuid"     => $auth->auth_uuid,
            "group_name"    => sprintf("App.Soundblock.Project.%s", $this->project->project_uuid),
            "group_memo"    => sprintf("App.Soundblock.Project.( %s )", $this->project->project_uuid),
            "flag_critical" => true,
        ]);

        $authGroupProject->users()->attach($this->user->user_id, [
            "row_uuid"   => Util::uuid(),
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
            "group_uuid" => $authGroupProject->group_uuid,
            "user_uuid"  => $this->user->user_uuid,
        ]);

        $authGroupProject->permissions()->attach($objContractPermission->permission_id, [
            "row_uuid"         => Util::uuid(),
            "group_uuid"       => $authGroupProject->group_uuid,
            "permission_uuid"  => $objContractPermission->permission_uuid,
            "permission_value" => true,
        ]);

        $authGroupProject->pusers()->attach($this->user->user_id, [
            "row_uuid"         => Util::uuid(),
            "group_uuid"       => $authGroupProject->group_uuid,
            "user_uuid"        => $this->user->user_uuid,
            "permission_id"    => $objContractPermission->permission_id,
            "permission_uuid"  => $objContractPermission->permission_uuid,
            "permission_value" => true,
        ]);

        $authGroupService = AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $auth->auth_id,
            "auth_uuid"     => $auth->auth_uuid,
            "group_name"    => sprintf("App.Soundblock.Account.%s", $this->service->service_uuid),
            "group_memo"    => sprintf("App.Soundblock.Account.( %s )", $this->service->service_uuid),
            "flag_critical" => true,
        ]);

        $authGroupService->users()->attach($this->user->user_id, [
            "row_uuid"   => Util::uuid(),
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
            "group_uuid" => $authGroupService->group_uuid,
            "user_uuid"  => $this->user->user_uuid,
        ]);

        $authGroupService->permissions()->attach($objContractPermission->permission_id, [
            "row_uuid"         => Util::uuid(),
            "group_uuid"       => $authGroupService->group_uuid,
            "permission_uuid"  => $objContractPermission->permission_uuid,
            "permission_value" => true,
        ]);

        $authGroupService->pusers()->attach($this->user->user_id, [
            "row_uuid"         => Util::uuid(),
            "group_uuid"       => $authGroupService->group_uuid,
            "user_uuid"        => $this->user->user_uuid,
            "permission_id"    => $objContractPermission->permission_id,
            "permission_uuid"  => $objContractPermission->permission_uuid,
            "permission_value" => true,
        ]);

        Passport::actingAs($this->user);
    }

    public function testIndexForSoundblock(){
        $response = $this->json("GET", "/soundblock/projects");

        $response->assertStatus(200)->assertJsonMissingValidationErrors();
    }

    public function testStoreForSoundblock(){
        Queue::fake();

        $objDraft = ProjectDraft::factory()->create();

        $arrayParams = [
            "service" => $this->service->service_uuid,
            "project_title" => "Test Project",
            "project_label" => "Test Label",
            "project_date" => "2020-01-01",
            "project_type" => "Album",
            "draft_uuid" => $objDraft->draft_uuid
        ];

        $response = $this->json("POST", "/soundblock/project", $arrayParams);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $response->assertJsonStructure([
            "data" => [
                "service_uuid",
                "project_title",
                "project_type",
                "project_date",
                "project_uuid",
                "stamp_created",
                "stamp_updated",
                "stamp_created_by",
                "stamp_updated_by",
                "artwork",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ]
        ]);
        $this->assertDatabaseHas("soundblock_projects", [
            "service_id"    => $this->service->service_id,
            "service_uuid"  => $this->service->service_uuid,
            "project_title" => "Test Project",
            "project_date"  => "2020-01-01",
            "project_type"  => "Album",
        ]);
    }

    public function testUpdate(){
        $arrayParams = [
            "title" => "Updated Test Name",
            "type" => "Album",
        ];

        $response = $this->json("PATCH", "/soundblock/project/".$this->project->project_uuid, $arrayParams);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $this->assertDatabaseHas("soundblock_projects", [
            "project_id"    => $this->project->project_id,
            "project_uuid"  => $this->project->project_uuid,
            "service_id"    => $this->service->service_id,
            "service_uuid"  => $this->service->service_uuid,
            "project_title" => "Updated Test Name",
            "project_type"  => "Album",
        ]);
    }

    public function testAddFile(){
        $file = UploadedFile::fake()->create("foo.zip", "800");
        $arrParams = [
            "project" => $this->project->project_uuid,
            "files" => $file
        ];

        $response = $this->json("POST", "/soundblock/project/file", $arrParams);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
    }

    // TO DO
//    public function testConfirm(){
//        $arrParams = [
//            "project" => $this->project->project_uuid,
//            "file_name" => "Test",
//            "collection_comment" => "Test",
//            "is_zip" => 0,
//            "files" => [
//                "file_title" => "Title",
//                "file_name" => "Name",
//                "file_track" => "1",
//                "file_path" => "Path",
//                "track" => [
//                    "org_file_sortby" => "string",
//                    "file_uuid" => "uuid",
//                ]
//            ]
//        ];
//    }

    public function testArtwork(){
        $file = UploadedFile::fake()->image("testImage.jpg");
        $arrParams = [
            "project" => $this->project->project_uuid,
            "artwork" => $file
        ];

        $response = $this->json("POST", "/soundblock/project/artwork", $arrParams);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $response->assertJsonStructure([
            "data" => [
                "project_uuid",
                "service_uuid",
                "project_title",
                "project_type",
                "project_date",
                "project_upc",
                "artwork_name",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by",
                "artwork",
                "service" => [
                    "service_uuid",
                    "user_uuid",
                    "service_name",
                    "flag_status",
                    "accounting_version",
                    "service_holder",
                ]
            ],
            "status" => [
                "app",
                "code",
                "message",
            ]
        ]);
    }

    public function testUploadArtworkForDraft(){
        $file = UploadedFile::fake()->image("testImage.jpg");
        $arrParams = [
            "project" => $this->project->project_uuid,
            "artwork" => $file
        ];

        $response = $this->json("POST", "/soundblock/project/artwork", $arrParams);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $response->assertJsonStructure([
            "data" => [
                "project_uuid",
                "service_uuid",
                "project_title",
                "project_type",
                "project_date",
                "project_upc",
                "artwork_name",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by",
                "artwork",
                "service"
            ],
            "status" => [
                "app",
                "code",
                "message",
            ]
        ]);
    }

    // TO DO
//    public function testPingExtractingZip(){
//        $response = $this->json("GET", "/soundblock/ping-zip", ["project" => $this->project->project_uuid]);
//        dd(json_decode($response->getContent()));
//    }

    public function testShow(){
        $response = $this->json("GET", "/soundblock/project/".$this->project->project_uuid);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $response->assertJsonStructure([
            "data" => [
                "service_uuid",
                "project_title",
                "project_type",
                "project_date",
                "project_uuid",
                "stamp_created",
                "stamp_updated",
                "stamp_created_by",
                "stamp_updated_by",
                "artwork",
                "status"
            ],
            "status" => [
                "app",
                "code",
                "message",
            ]
        ]);
    }
}
