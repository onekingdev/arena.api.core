<?php

namespace Tests\Unit\Soundblock\Project;

use App\Models\Core\Auth\AuthModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Projects\Team as TeamModel;
use App\Contracts\Soundblock\Projects\Team as TeamContract;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;

class TeamTest extends TestCase
{
    private TeamModel $teamModel;
    private $teamContract;
    private ProjectModel $projectModel;
    private $user;
    private $objApp;
    private $objAuth;
    private $serviceModel;

    public function setUp(): void {
        parent::setUp();

        $this->objApp = App::where("app_name", "soundblock")->first();
        $this->objAuth = AuthModel::where("auth_name", "App.Soundblock")->first();
        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));
        
        
        $this->serviceModel = ServiceModel::factory()->create([
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid
        ]);
        $this->projectModel = $this->serviceModel->projects()->save(ProjectModel::factory()->make());
        $this->teamModel = TeamModel::factory()->create([
            "project_id" => $this->projectModel->project_id,
            "project_uuid" => $this->projectModel->project_uuid,
        ]);
        $this->teamModel->users()->attach($this->user->user_id, [
            "row_uuid" => Util::uuid(),
            "team_uuid" => $this->teamModel->team_uuid,
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid,
            "user_role" => "Composer",
            "user_payout" => 100,
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

        Config::set("global.app", $this->objApp);
        Config::set("global.auth", $this->objAuth);
        AuthGroup::factory()->create([
            "auth_id"   => $this->objAuth->auth_id,
            "auth_uuid" => $this->objAuth->auth_uuid,
            "group_name" => Util::makeGroupName($this->objAuth, "project", $this->projectModel),
        ]);

        $this->teamContract = resolve(TeamContract::class);
    }

    public function testFind(){
        $objTeam = $this->teamContract->find($this->teamModel->team_uuid);

        $this->assertEquals($this->teamModel->team_uuid, $objTeam->team_uuid);
        $this->assertInstanceOf(TeamModel::class, $objTeam);
    }

    public function testFindByProject(){
        $objTeam = $this->teamContract->findByProject($this->projectModel->project_uuid);

        $this->assertEquals($this->projectModel->project_uuid, $objTeam->project_uuid);
        $this->assertInstanceOf(TeamModel::class, $objTeam);
    }

    public function testGetUsers(){
        $objTeam = $this->teamContract->getUsers($this->projectModel);

        $this->assertEquals($this->projectModel->project_uuid, $objTeam->project_uuid);
        $this->assertInstanceOf(TeamModel::class, $objTeam);
        $this->assertArrayHasKey("users", $objTeam);
    }

    public function testCreate(){
        $objProject = ProjectModel::factory()->create();
        $objTeam = $this->teamContract->create($objProject);

        $this->assertEquals($objProject->project_uuid, $objTeam->project_uuid);
        $this->assertInstanceOf(TeamModel::class, $objTeam);
    }

    public function testStoreMember(){
        $arrParams = [
            "user_auth_email" => $this->user->getPrimaryEmailAttribute()->user_auth_email,
            "team" => $this->teamModel->team_uuid,
            "user_role" => "Lawyer"
        ];
        $objUser = $this->teamContract->storeMember($arrParams);

        $this->assertInstanceOf(UserModel::class, $objUser);
        $this->assertEquals($this->user->user_uuid, $objUser->user_uuid);
    }

    public function testAddMembers(){
        $arrInfo = [
            [
                "email" => $this->user->getPrimaryEmailAttribute(),
                "user_role" => "Lawyer"
            ]
        ];
        $objTeam = $this->teamContract->addMembers($this->teamModel, $arrInfo);

        $this->assertEquals($this->teamModel->team_uuid, $objTeam->team_uuid);
        $this->assertInstanceOf(TeamModel::class, $objTeam);
    }

    public function testUpdate(){
        $users = $this->teamModel->users;
        $arrParams = [
            [
                "uuid" => $users[0]["user_uuid"],
                "role" => "New Test Role"
            ]
        ];

        $objTeamMembers = $this->teamContract->update($this->teamModel, $arrParams);
        $this->assertInstanceOf(Collection::class, $objTeamMembers);
    }

    public function testDelete(){
        $objAuthGroup = $this->teamContract->delete($this->projectModel, [$this->user], $this->user->groups()->first());

        $this->assertInstanceOf(AuthGroup::class, $objAuthGroup);
    }

    public function testRemindUser(){
        $newUser = UserModel::factory()->create();
        $newUser->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $arrParams = [
            "user_auth_email" => $newUser->getPrimaryEmailAttribute()->user_auth_email,
            "team" => $this->teamModel->team_uuid,
            "user_role" => "Lawyer"
        ];
        $objUser = $this->teamContract->storeMember($arrParams);
        $objUser->teams()
            ->where("soundblock_projects_teams_users.team_uuid", $this->teamModel->team_uuid)
            ->update(["soundblock_projects_teams_users.stamp_remind" => time() - 86500]);

        $boolResult = $this->teamContract->remind($this->teamModel->project, ["user_uuid" => $objUser->user_uuid]);

        $this->assertIsBool($boolResult);
        $this->assertTrue($boolResult);
    }

    public function testRemindInvite(){
        $arrParams = [
            "first_name" => "Test",
            "last_name" => "Invite Remind",
            "user_auth_email" => rand(10000, 100000) . "qwerty" . rand(10000, 100000) . "@arena.com",
            "team" => $this->teamModel->team_uuid,
            "user_role" => "Admin",
            "permissions" => [
                [
                    "permission_name" => "App.Soundblock.Project.Create",
                    "permissions_value" => 1
                ]
            ]
        ];
        $objInvite = $this->teamContract->storeMember($arrParams);
        $objInvite->update([
            "stamp_remind" => time() - 86500
        ]);

        $boolResult = $this->teamContract->remind($this->teamModel->project, ["invite_uuid" => $objInvite->invite_uuid]);

        $this->assertIsBool($boolResult);
        $this->assertTrue($boolResult);
    }
}
