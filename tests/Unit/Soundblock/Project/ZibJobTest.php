<?php

namespace Tests\Unit\Soundblock\Project;

use App\Helpers\Client;
use App\Helpers\Util;
use App\Jobs\Zip\ExtractProject;
use App\Jobs\Zip\Zip;
use App\Models\Common\QueueJob;
use App\Models\Soundblock\Platform;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Users\User;
use App\Services\Soundblock\Collection;
use App\Services\Soundblock\Deployment;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use Tests\TestCase;
use ReflectionClass;

class ZibJobTest extends TestCase
{
    /**
     * @var Collection
     */
    private $collectionService;
    /** @var User */
    private $user;
    /** @var Account */
    private $service;
    /**
     * @var Deployment
     */
    private $deploymentService;
    /**
     * @var Project
     */
    private $project;
    /**
     * @var string
     */
    private $uploadedFileName;

    public function setUp(): void {
        parent::setUp();

        DB::table("queue_jobs")->truncate();

        $this->collectionService = app(Collection::class);
        $this->deploymentService = app(Deployment::class);


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

        $reflection = new ReflectionClass(Collection::class);
        $method = $reflection->getMethod("createQueueJobAndSilentAlert");
        $method->setAccessible(true);

        /** @var QueueJob */
        $queueJob = $method->invoke($this->collectionService);
        $this->assertInstanceOf(QueueJob::class, $queueJob);
        $faker = Factory::create();

        dispatch(new ExtractProject($queueJob, $this->uploadedFileName, $this->dummyData, $faker->name(), $this->project));

        DB::table("queue_jobs")->truncate();
    }

    public function testDownloadCollection() {
        bucket_storage("soundblock")->copy("test/test.zip", Util::uploaded_file_path($this->uploadedFileName));

        Client::checkingAs("app.arena.office.web");
        $latestCollection = $this->collectionService->findLatestByProject($this->project);
        $deployment = $this->deploymentService->create($this->project,  [Platform::all()->random()->platform_uuid]);
        $reflection = new ReflectionClass(Deployment::class);

        $method = $reflection->getMethod("createQueuJobAndAlert");
        $method->setAccessible(true);
        /** @var QueueJob */
        $queueJob = $method->invoke($this->deploymentService);
        $this->assertInstanceOf(QueueJob::class, $queueJob);
//        Queue::fake();
        dispatch(new Zip($queueJob, $deployment[0]['collection']));
    }

    public function testDownloadFiles() {
        bucket_storage("soundblock")->copy("test/test.zip", Util::uploaded_file_path($this->uploadedFileName));

        Client::checkingAs("app.arena.soundblock.web");
        $latestCollection = $this->collectionService->findLatestByProject($this->project);
        $files = $latestCollection->files->random(rand(1, $latestCollection->files->count()));

        $reflection = new ReflectionClass(Collection::class);
        $method = $reflection->getMethod("createQueueJobAndAlertForZip");
        $method->setAccessible(true);
        /** @var QueueJob */
        $queueJob = $method->invoke($this->collectionService);
        $this->assertInstanceOf(QueueJob::class, $queueJob);

        dispatch(new Zip($queueJob, $latestCollection, $files));
    }


}
