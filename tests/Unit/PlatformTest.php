<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Soundblock\Platform as PlatformModel;
use App\Contracts\Soundblock\Platform as PlatformContract;

class PlatformTest extends TestCase
{
    private $platformService;

    public function setUp(): void{
        parent::setUp();

        $this->platformService = resolve(PlatformContract::class);
    }

    public function testCreate(){
        $arrParams = [
            "name" => "TestName"
        ];
        $objPlatform = $this->platformService->create($arrParams);

        $this->assertInstanceOf(PlatformModel::class, $objPlatform);
        $this->assertEquals("TestName", $objPlatform->name);
    }

    public function testFind(){
        $objPlatformModel = PlatformModel::first();
        $objPlatform = $this->platformService->find($objPlatformModel->platform_uuid);

        $this->assertInstanceOf(PlatformModel::class, $objPlatform);
        $this->assertEquals($objPlatformModel->platform_uuid, $objPlatform->platform_uuid);
    }

    public function testFindAll(){
        $collection = $this->platformService->findAll();

        foreach ($collection as $objPlatform){
            $this->assertInstanceOf(PlatformModel::class, $objPlatform);
        }
    }

    public function testUpdate(){
        $arrParams = [
            "name" => "NewTestName"
        ];
        $objPlatformLast = PlatformModel::orderBy("platform_id", "desc")->first();
        $objPlatform = $this->platformService->update($objPlatformLast, $arrParams);

        $this->assertInstanceOf(PlatformModel::class, $objPlatform);
        $this->assertEquals("NewTestName", $objPlatform->name);
    }
}
