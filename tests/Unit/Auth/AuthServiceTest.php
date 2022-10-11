<?php

namespace Tests\Unit\Auth;


use Tests\TestCase;
use App\Helpers\Util;
use App\Contracts\Auth\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\{Core\Auth\AuthGroup, Core\App,  Users\User};

class AuthServiceTest extends TestCase {
    /**
     * @var Auth
     */
    private Auth $authService;
    /**
     * @var App
     */
    private App $commonApp;

    public function setUp(): void {
        parent::setUp();

        $this->authService = resolve(Auth::class);
        $this->commonApp = App::where("app_name", "office")->first();

        $objApp = App::where("app_name", "office")->first();

        Config::set("global.app", $objApp);
    }

    public function testSuccessSuperuserAuth() {
        $user = User::factory()->create();

        /** @var AuthGroup $objAuthSuperuser */
        $objAuthSuperuser = AuthGroup::where("group_name", "Superuser")->first();
        $objAuthSuperuser->users()->attach($user->user_id, [
            "row_uuid"   => Util::uuid(),
            "group_uuid" => $objAuthSuperuser->group_uuid,
            "user_uuid"  => $user->user_uuid,
            "app_id"     => $this->commonApp->app_id,
            "app_uuid"   => $this->commonApp->app_uuid,
        ]);

        $isAuth = $this->authService->isAuthorize($user, "office", "App.Office","App.Office.Access");

        $this->assertTrue($isAuth);
    }

    public function testFailedUserInGroup() {
        $user = User::factory()->create();
        $this->expectExceptionMessage("Group Not Found.");
        $this->authService->isAuthorize($user,  "App.Office", "App.Office.Access", "office", false);
    }


    public function testSuccessUserInGroup() {
        $user = User::factory()->create();
        /** @var AuthGroup $objAuthGroup */
        $objAuthGroup = AuthGroup::where("group_name", "App.Office")->first();

        $objAuthGroup->users()->attach($user->user_id, [
            "row_uuid" =>  Util::uuid(),
            "group_uuid" => $objAuthGroup->group_uuid,
            "user_uuid"  => $user->user_uuid,
            "app_id"     => $this->commonApp->app_id,
            "app_uuid"   => $this->commonApp->app_uuid,
        ]);

        $isAuth = $this->authService->isAuthorize($user, "App.Office", "App.Office.Access", "office");

        $this->assertTrue($isAuth);
    }


    public function testUserPermission() {
        $user = User::factory()->create();
        /** @var AuthGroup $objAuthGroup */
        $objAuthGroup = AuthGroup::where("group_name", "App.Office")->first();
//        $objAuthPermission =

        $objAuthGroup->users()->attach($user->user_id, [
            "row_uuid" =>  Util::uuid(),
            "group_uuid" => $objAuthGroup->group_uuid,
            "user_uuid"  => $user->user_uuid,
            "app_id"     => $this->commonApp->app_id,
            "app_uuid"   => $this->commonApp->app_uuid,
        ]);

        $isAuth = $this->authService->isAuthorize($user, "App.Office", "App.Office.Access", "office");

        $this->assertTrue($isAuth);
    }
}
