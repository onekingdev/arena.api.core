<?php

namespace Tests\Unit\Core;

use Tests\TestCase;
use App\Helpers\Client;
use App\Models\Core\App as AppModel;

class HeadersTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private $clientHelper;
    /**
     * @var AppModel[]|\Illuminate\Database\Eloquent\Collection
     */
    private $apps;
    private array $platforms;

    public function setUp(): void {
        parent::setUp();

        $this->platforms = [
            "android",
            "web",
            "ios"
        ];
        $this->apps = AppModel::where("app_name", "!=", "soundblock.web")->get();
        $this->clientHelper = resolve(Client::class);
    }

    public function testValidateHostHeader(){
        foreach ($this->apps as $objApp) {
            foreach ($this->platforms as $platrofm) {
                $hostHeader = "app.arena." . $objApp->app_name . "." . $platrofm;

                $response = $this->clientHelper->validateHostHeader($hostHeader);
                $this->assertIsBool($response);
                $this->assertTrue($response);
            }
        }
    }
}
