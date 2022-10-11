<?php

namespace Tests\Feature\Soundblock\Collection;

use App\Events\Soundblock\CreateProject;
use App\Http\Requests\Soundblock\Directory\UpdateDirectory;
use App\Models\Users\Contact\UserContactEmail;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Users\User;
use Illuminate\Support\Facades\Queue;
use App\Models\Soundblock\{Projects\Project, Collections\Collection, Accounts\Account, Files\Directory};
use App\Repositories\Soundblock\Directory as DirectoryRepository;
use Client;
use Constant;
use Laravel\Passport\Passport;
use Log;
use Tests\TestCase;

class UpdateDirectoryTest extends TestCase
{

    /** @var User */
    private $user;
    /** @var Project */
    private $project;
    /** @var Account */
    private $service;
    /** @var Collection */
    private $collection;
    /** @var Directory */
    private $directory;
    /** @var DirectoryRepository */
    private DirectoryRepository $directoryRepo;
    /** @var string */
    private $category;
    private $validator;
    private $rules;

    public function setUp(): void
    {
        parent::setUp();
        $this->directoryRepo = app(DirectoryRepository::class);
        $this->validator = app()->get("validator");
        $this->rules = (new UpdateDirectory)->rules();
        $faker = Factory::create();
        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));
        Passport::actingAs($this->user);
        Client::checkingAs();
        $this->validator = app()->get("validator");
        $this->rules = (new UpdateDirectory)->rules();
        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());
        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid
        ])->setAppends([])->toArray());
        event(new CreateProject($this->project, $this->user));
        $this->collection = $this->project->collections()->create(Collection::factory()->make([
            "project_uuid" => $this->project->project_uuid
        ])->toArray());
        $this->category = collect(config("constant.soundblock.file_category"))->random();
        $directoryName = $faker->word();
        $this->directory = $this->directoryRepo->createModel([
            "directory_name" => $directoryName,
            "directory_path" => ucfirst($this->category),
            "directory_sortby" => ucfirst($this->category) . Constant::Separator . $directoryName,
        ], $this->collection);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateDirectory()
    {
        Queue::fake();
        $faker = Factory::create();
        $dummyData = [
            "project" => $this->project->project_uuid,
            "collection_comment" => $faker->word(),
            "directory_sortby" => $this->directory->directory_sortby,
            "file_category" => $this->category,
            "new_directory_name" => $faker->word()
        ];
        Log::info('message', $dummyData);
        $response = $this->json("PATCH", "/soundblock/project/collection/directory", $dummyData);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $arrCollection = json_decode($response->getContent(), true);

        /* Check Project in Response */
        $response->assertJsonFragment([
            "project_uuid" => $this->project->project_uuid,
        ]);
        $this->assertDatabaseHas("soundblock_collections_history", [
            "collection_uuid" => $arrCollection["data"][0]["collection_uuid"],
            "file_action" => "Modified"
        ]);
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function testUpdateDirectoryValiation(bool $shouldPass, array $mockedRequestData)
    {
        $response = $this->json("PATCH", "/soundblock/project/collection/directory", $mockedRequestData);
        $response->assertStatus(422);
        $this->assertEquals($shouldPass, $this->validate($mockedRequestData));
    }

    protected function validate(array $mockedRequestData)
    {
        return($this->validator->make($mockedRequestData, $this->rules)->passes());
    }

    public function validationProvider()
    {
        $faker = Factory::create();
        $category = collect(["music", "video", "merch", "other"])->random();

        return([
            "request_should_fail_when_no_directory_sortby_is_provided" => [
                "passed" => false,
                "data" => [
                    "project" => $this->project->project_uuid,
                    "collection_comment" => $faker->word,
                    "file_category" => $category,
                    "new_directory_name" => $faker->word
                ]
            ],
            "request_should_fail_when_no_project_is_provided" => [
                "passed" => false,
                "data" => [
                    "directory_sortby" => $this->directory->directory_sortby,
                    "file_category" => $category,
                    "collection_comment" => $faker->word,
                    "new_directory_name" => $faker->word
                ]
            ],
            "request_should_fail_when_no_new_directory_name_is_provided" => [
                "passed" => false,
                "data" => [
                    "project" => $this->project->project_uuid,
                    "directory_sortby" => $this->directory->directory_sortby,
                    "collection_comment" => $faker->word,
                    "file_category" => $category,
                ]
            ]
        ]);
    }
}
