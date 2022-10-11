<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest() {
        $response = $this->get('/');
        $response->assertStatus(200);

    }

    public function testPing() {
        $response = $this->get('/status/ping');
        $response->assertStatus(200);

    }

}
