<?php

namespace Tests\Unit\Soundblock\Invite;

use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthModel;
use Illuminate\Support\Facades\Config;
use App\Models\Users\User as UserModel;
use App\Models\Soundblock\Invites as InvitesModel;
use App\Models\Core\Auth\AuthGroup as AuthGroupModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use App\Contracts\Soundblock\Invite\Invite as InviteContract;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;
use App\Models\Soundblock\Projects\Contracts\Contract as ContractModel;

class InviteTest extends TestCase
{
    private UserModel $user;
    private InvitesModel $inviteModel;
    private ProjectModel $project;
    private ServiceModel $serviceModel;
    private ContractModel $contract;
    private InviteContract $inviteService;

    public function setUp(): void {
        parent::setUp();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));
        $this->inviteService = resolve(InviteContract::class);
        $this->serviceModel = ServiceModel::factory()->create([
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid
        ]);
        $this->project = $this->serviceModel->projects()->save(ProjectModel::factory()->make());
        $this->contract = $this->project->contracts()->save(ContractModel::factory()->make([
            "contract_uuid" => Util::uuid(),
            "service_id" => $this->serviceModel->service_id,
            "service_uuid" => $this->serviceModel->service_uuid,
            "project_id" => $this->project->project_id,
            "project_uuid" => $this->project->project_uuid,
            "contract_version" => 1
        ]));
        $this->inviteModel = InvitesModel::factory()->create([
            "model_class" => "App\Models\Soundblock\Projects\Contracts\Contract",
            "model_id" => $this->contract->contract_id,
            "invite_role" => "test",
            "invite_payout" => 100
        ]);
    }

    public function testGetInviteByHash(){
        $objInvite = $this->inviteService->getInviteByHash($this->inviteModel->invite_hash);

        $this->assertInstanceOf(InvitesModel::class, $objInvite);
        $this->assertEquals($objInvite->invite_hash, $this->inviteModel->invite_hash);
    }

    public function testGetInviteByEmail(){
        $objInvite = $this->inviteService->getInviteByEmail($this->inviteModel->invite_email);

        $this->assertInstanceOf(InvitesModel::class, $objInvite);
        $this->assertEquals($objInvite->invite_email, $this->inviteModel->invite_email);
    }

    public function testUseInvite(){
        Passport::actingAs($this->user);
        $objApp = App::where("app_name", "soundblock")->first();
        $objAuth = AuthModel::where("auth_name", "App.Soundblock")->first();
        Config::set("global.app", $objApp);
        Config::set("global.auth", $objAuth);

        AuthGroupModel::factory()->create([
            "auth_id" => $objAuth->auth_id,
            "auth_uuid" => $objAuth->auth_uuid,
            "group_name" => "App.Soundblock.Project." . $this->project->project_uuid,
            "group_memo" => "App.Soundblock.Project.( " . $this->project->project_uuid . " )",
        ]);
        AuthGroupModel::factory()->create([
            "auth_id" => $objAuth->auth_id,
            "auth_uuid" => $objAuth->auth_uuid,
            "group_name" => "App.Soundblock.Account." . $this->serviceModel->service_uuid,
            "group_memo" => "App.Soundblock.Account.( " . $this->serviceModel->service_uuid . " )",
        ]);

        $userData = [
            "email"         => $this->inviteModel->invite_email,
            "name_last"     => "testLastName",
            "name_first"    => $this->inviteModel->invite_name,
            "name_middle"   => "Middle",
            "user_password" => 'testpass',
        ];

        $objUser = $this->inviteService->useInvite($this->inviteModel, $userData);

        $this->assertArrayHasKey("user_uuid", $objUser);
        $this->assertArrayHasKey("name", $objUser);
        $this->assertArrayHasKey("primary_email", $objUser);
    }
}
