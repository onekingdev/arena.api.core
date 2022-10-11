<?php

namespace Tests\Unit\Soundblock\Project;

use Faker\Factory;
use Tests\TestCase;
use ReflectionClass;
use App\Helpers\Util;
use App\Helpers\Client;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use App\Jobs\Zip\ExtractProject;
use App\Services\Soundblock\Collection;
use App\Models\{Common\QueueJob, Soundblock\Projects\Project, Soundblock\Accounts\Account, Users\User};

class ExtractProjectJobTest extends TestCase {
    /** @var User $user */
    private $user;

    /** @var Account $user */
    private $service;
    /**
     * @var Project
     */
    private $project;
    /**
     * @var array
     */
    private $dummyData;
    /**
     * @var string
     */
    private $uploadedFileName;
    /**
     * @var Collection
     */
    private $collectionService;

    public function setUp(): void {
        parent::setUp();

        DB::table("queue_jobs")->truncate();

        $this->collectionService = app(Collection::class);

        $this->user = User::find(1);
        $this->service = Account::find(1);

        Passport::actingAs($this->user);
        Client::checkingAs();

        $this->project = Project::factory()->create([
            "service_id" => $this->service->service_id,
            "service_uuid" => $this->service->service_uuid,
        ]);

        $this->dummyData = [
            [
                "org_file_sortby" => "22.psd",
                "file_title"      => "Happy Camp",
                "file_name"       => "Rising Star",
                "file_track"      => 3,
            ],
            [
                "org_file_sortby" => "Marshal Mathers.mp3",
                "file_title"      => "Happy Camp",
                "file_name"       => "Marshal Mathers.mp3",
            ],
            [
                "org_file_sortby" => "Me!.psd",
                "file_title"      => "^*_*^",
                "file_name"       => "Me!.psd",
            ],
        ];

        usort($this->dummyData, [Collection::class, "isVideo"]);

        $this->uploadedFileName = Util::uuid() . ".zip";
        bucket_storage("soundblock")->copy("default/artwork.png", Util::artwork_path($this->project));
        bucket_storage("soundblock")->copy("test/test.zip", Util::uploaded_file_path($this->uploadedFileName));
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testHandle() {
        $reflection = new ReflectionClass(Collection::class);
        $method = $reflection->getMethod("createQueueJobAndSilentAlert");
        $method->setAccessible(true);

        /** @var QueueJob */
        $queueJob = $method->invoke($this->collectionService);
        $this->assertInstanceOf(QueueJob::class, $queueJob);
        $faker = Factory::create();

        dispatch(new ExtractProject($queueJob, $this->uploadedFileName, $this->dummyData, $faker->name(), $this->project));

        bucket_storage("soundblock")->assertMissing(Util::uploaded_file_path($this->uploadedFileName));
    }
}
