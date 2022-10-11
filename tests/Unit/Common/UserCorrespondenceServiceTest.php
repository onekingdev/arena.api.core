<?php

namespace Tests\Unit\Common;

use App\Services\User\UserCorrespondence as UserCorrespondenceService;
use App\Models\{Core\App, Users\User, Users\UserCorrespondence, Users\Contact\UserContactEmail};
use Faker\Factory;
use Tests\TestCase;
use Util;

class UserCorrespondenceServiceTest extends TestCase
{

    /**
     * @var UserCorrespondenceService
     */
    private UserCorrespondenceService $correspondenceService;
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->correspondenceService = app(UserCorrespondenceService::class);
        $this->users = User::factory()->count(4)->create();

        foreach($this->users as $user) {
            $user->emails()->create(UserContactEmail::factory()->primary()->make([
                "row_uuid" => Util::uuid(),
                "user_uuid" => $user->user_uuid
            ])->makeVisible("row_uuid", "user_uuid")->toArray());
        }

    }

    public function testCreate()
    {
        $app = App::all()->random();
        $uuid = Util::uuid();
        $faker = Factory::create();
        $from = $faker->email;
        $text = $faker->text();
        $html = $faker->randomHtml();
        $subject = "Test Subject";
        foreach ($this->users as $user) {
            $correspondence = $this->correspondenceService->create([
                "email_id" => Util::random_str(),
                "email_uuid" => $uuid,
                "email_from" => $from,
                "email_subject" => $subject,
                "email_text" => $text,
                "email_html" => $html,
            ], $user, $app);
            $this->assertInstanceOf(UserCorrespondence::class, $correspondence);
        }

    }
}
