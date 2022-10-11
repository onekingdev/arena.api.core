<?php

namespace Tests\Feature\Soundblock\Collection;

use App\Models\Users\Contact\UserContactEmail;
use Client;
use Faker\Factory;
use Tests\TestCase;
use App\Models\Users\User;
use Laravel\Passport\Passport;
use App\Events\Soundblock\CreateProject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Soundblock\Directory\AddDirectory;
use App\Models\Soundblock\{Accounts\Account, Projects\Project};

class AddDirectoryTest extends TestCase
{

    /** @var User */
    private $user;
    /** @var Account */
    private $service;
    /** @var Project */
    private $project;
    /** @var array */
    private $dummyData;
    /** @var array */
    private $categories;
    private $validator;
    private $rules;

    public function setUp(): void {
        parent::setUp();

        $faker = Factory::create();
        $this->validator = app()->get("validator");
        $this->rules = (new AddDirectory)->rules();
        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));
        Client::checkingAs();
        Passport::actingAs($this->user);
        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid"         => $this->user->user_uuid
        ])->setAppends([])->setHidden([])->toArray());

        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid
        ])->setAppends([])->toArray());
        event(new CreateProject($this->project, $this->user));
        $category = collect(config("constant.soundblock.file_category"))->random();
        $this->dummyData = [
            "directory_name" => $faker->word,
            "project" => $this->project->project_uuid,
            "collection_comment" => $faker->word,
            "file_category" => $category,
            "directory_path" => ucfirst($category)
        ];
    }

    public function testAddDirectory()
    {
        $response = $this->json("POST", "/soundblock/project/collection/directory", $this->dummyData);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $arrCollection = json_decode($response->getContent(), true);

        /* Check Project in Response */
        $response->assertJsonFragment([
            "project_uuid" => $this->project->project_uuid,
        ]);
        /* Check if collection created in database */
        $this->assertDatabaseHas("soundblock_collections", [
            "collection_uuid" => $arrCollection["data"][0]["collection_uuid"]
        ]);
        /* Check if directory created in database */
        $this->assertDatabaseHas("soundblock_collections_directories", [
            "collection_uuid" => $arrCollection["data"][0]["collection_uuid"],
        ]);
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function testAddDirectoryValidation(bool $shouldPass, array $mockedRequestData)
    {
        $response = $this->json("POST", "/soundblock/project/collection/directory", $mockedRequestData);
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
            "request_should_fail_when_no_directory_name_is_provided" => [
                "passed" => false,
                "data" => [
                    "project" => $this->project->project_uuid,
                    "file_category" => $category,
                    "directory_path" => ucfirst($category),
                    "collection_comment" => $faker->word
                ]
            ],
            "request_should_fail_when_no_project_is_provided" => [
                "passed" => false,
                "data" => [
                    "directory_name" => $faker->word,
                    "file_category" => $category,
                    "directory_path" => ucfirst($category),
                    "collection_comment" => $faker->word
                ]
            ]
        ]);
    }
}
