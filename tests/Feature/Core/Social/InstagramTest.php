<?php

namespace Tests\Feature\Core\Social;

use App\Helpers\Client;
use App\Models\Core\Social\Instagram;
use Tests\TestCase;

class InstagramTest extends TestCase {
    private ?int $totalImages;

    public function setUp(): void {
        parent::setUp();

        Client::checkingAs();

        $this->totalImages = Instagram::count();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetImagesWithoutParams() {
        $response = $this->get("/core/social/instagram");
        $response->assertStatus(200);

        $arrImages = json_decode($response->getContent(), true);
        $this->assertCount(20, $arrImages["data"]);
    }


    public function testLatestImages() {
        $latest = rand(1, $this->totalImages);

        $response = $this->get("/core/social/instagram?latest=$latest");
        $response->assertStatus(200);

        $arrImages = json_decode($response->getContent(), true);
        $this->assertCount($latest, $arrImages["data"]);
    }

    public function testRandomImages() {
        $random = rand(1, $this->totalImages);
        $response = $this->get("/core/social/instagram?random=$random");
        $response->assertStatus(200);

        $arrImages = json_decode($response->getContent(), true);
        $this->assertCount($random, $arrImages["data"]);
    }

    public function testMixedImages() {
        $random = rand(1, floor($this->totalImages / 2));
        $latest = rand(1, floor($this->totalImages / 2));

        $response = $this->get("/core/social/instagram?random=$random&latest=$latest");
        $response->assertStatus(200);

        $arrImages = json_decode($response->getContent(), true);
        $this->assertCount($latest + $random, $arrImages["data"]);
        $this->assertCount(0, collect($arrImages["data"])->duplicates());
    }
}
