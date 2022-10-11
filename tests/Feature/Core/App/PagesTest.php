<?php

namespace Tests\Feature\Core\App;

use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthPermission;
use App\Models\Users\Contact\UserContactEmail;
use Tests\TestCase;
use App\Models\Users\User;
use App\Models\Core\AppsPage;
use Laravel\Passport\Passport;

class PagesTest extends TestCase {
    /**
     * @var User
     */
    private User $user;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));
        $this->page = AppsPage::first();

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

        /** @var AuthPermission $objPermission */
        $objPermission = AuthPermission::where("permission_name", "App.Office.Access")->first();
        $objPermission->pusers()->attach($this->user->user_id, [
            "row_uuid"         => Util::uuid(),
            "group_id"         => $objGroup->group_id,
            "group_uuid"       => $objGroup->group_uuid,
            "user_uuid"        => $this->user->user_uuid,
            "permission_uuid"  => $objPermission->permission_uuid,
            "permission_value" => true,
        ]);

        $this->userWithoutPermission = User::factory()->create();
    }

    public function testGetPagesTest() {
        Passport::actingAs($this->user);

        $response = $this->get("/core/pages");
        $response->assertStatus(200);
    }

    public function testGetPageByUrlTest() {
        Passport::actingAs($this->user);

        $response = $this->get("/core/page/?page_url=" . $this->page->page_url . "&struct_uuid=" . $this->page->struct_uuid . "");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "page_uuid",
                "page_url",
                "meta",
                "params",
                "content",
                "app",
                "struct",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by",
            ],
        ]);

        $response->assertJsonFragment(["page_uuid" => $this->page->page_uuid]);
    }

    public function testGetPageByUuidTest() {
        Passport::actingAs($this->user);

        $response = $this->get("core/page/" . $this->page->page_uuid . "");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "page_uuid",
                "page_url",
                "meta",
                "params",
                "content",
                "app",
                "struct",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by",
            ],
        ]);
    }
}
