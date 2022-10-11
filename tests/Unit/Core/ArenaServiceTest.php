<?php

namespace Tests\Unit\Core;

use App\Contracts\Core\Arena;
use Faker\Factory;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Tests\TestCase;

class ArenaServiceTest extends TestCase {
    /**
     * @var Arena
     */
    private $arena;

    public function setUp(): void {
        parent::setUp();

        $this->arena = resolve(Arena::class);
    }

    public function testGettingCloudUrl() {
        $strCloudUrl = $this->arena->cloudUrl("account");
        $this->assertIsString($strCloudUrl);
        $this->assertEquals(config("arena.account.develop.aws.cloud.url"), $strCloudUrl);
    }

    public function testGettingCloudUrlByInvalidName() {
        $emptyValue = $this->arena->cloudUrl("INVALID_NAME");
        $this->assertNull($emptyValue);
    }

    public function testGettingAppUrl() {
        $strAppUrl = $this->arena->appUrl("account");
        $this->assertIsString($strAppUrl);
        $this->assertEquals(config("arena.account.develop.app.url"), $strAppUrl);
    }

    public function testGettingAppUrlByInvalidName() {
        $strAppUrl = $this->arena->appUrl("INVALID_NAME");
        $this->assertNull($strAppUrl);
    }

    public function testGettingAppUrlWithDefaultValue() {
        $objFaker = Factory::create();
        $strDefaultUrl = $objFaker->url;
        $strAppUrl = $this->arena->appUrl("account", $strDefaultUrl);
        $this->assertIsString($strAppUrl);
        $this->assertEquals(config("arena.account.develop.app.url"), $strAppUrl);
    }

    public function testGettingAppUrlWithDefaultValueByInvalidName() {
        $objFaker = Factory::create();
        $strDefaultUrl = $objFaker->url;
        $strAppUrl = $this->arena->appUrl("INVALID_NAME", $strDefaultUrl);
        $this->assertIsString($strAppUrl);
        $this->assertEquals($strDefaultUrl, $strAppUrl);
    }

    public function testGettingNotVersioningAppVar() {
        $strAppName = $this->arena->appVar("account", "app.name");
        $this->assertIsString($strAppName);
        $this->assertEquals(config("arena.account.app.name"), $strAppName);
    }

    public function testGettingNotVersioningInvalidAppVars() {
        $strAppName = $this->arena->appVar("INVALID_NAME", "app.name");
        $this->assertNull($strAppName);

        $strAppName = $this->arena->appVar("account", "invalid.name");
        $this->assertNull($strAppName);

        $strAppName = $this->arena->appVar("INVALID_NAME", "invalid.name");
        $this->assertNull($strAppName);
    }

    public function testGettingVersioningAppVar() {
        $strCloudId = $this->arena->appVar("account", "aws.cloud.id", true);
        $this->assertIsString($strCloudId);
        $this->assertEquals(config("arena.account.develop.aws.cloud.id"), $strCloudId);
    }

    public function testGettingVersioningInvalidAppVars() {
        $strAppName = $this->arena->appVar("INVALID_NAME", "aws.cloud.id", true);
        $this->assertNull($strAppName);

        $strAppName = $this->arena->appVar("account", "invalid.name",true);
        $this->assertNull($strAppName);

        $strAppName = $this->arena->appVar("INVALID_NAME", "invalid.name", true);
        $this->assertNull($strAppName);
    }

    public function testGettingBucketName() {
        $strBucketName = $this->arena->s3Bucket("account");
        $this->assertIsString($strBucketName);
        $this->assertEquals(config("arena.account.develop.aws.bucket.name"), $strBucketName);
    }

    public function testGettingBucketNameByInvalidName() {
        $strBucketName = $this->arena->s3Bucket("INVALID_NAME");
        $this->assertNull($strBucketName);
    }

    public function testGettingBucketStorage() {
        /** @var FilesystemAdapter $objStorage */
        $objStorage = $this->arena->s3Storage("account");
        $this->assertInstanceOf(FilesystemAdapter::class, $objStorage);
        /** @var AwsS3Adapter $s3Adapter */
        $s3Adapter = $objStorage->getDriver()->getAdapter();
        $this->assertEquals(config("arena.account.develop.aws.bucket.name"), $s3Adapter->getBucket());
    }

    public function testGettingBucketStorageByInvalidName() {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Bucket Not Found.");
        $this->expectExceptionCode(404);
        $this->arena->s3Storage("INVALID NAME");
    }

}
