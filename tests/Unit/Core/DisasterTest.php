<?php

namespace Tests\Unit\Core;

use App\Contracts\Exceptions\Disaster;
use App\Exceptions\Core\Disaster\LedgerMicroserviceException;
use Tests\TestCase;

class DisasterTest extends TestCase {
    /**
     * @var Disaster
     */
    private $disaster;

    public function setUp(): void {
        parent::setUp();

        $this->disaster = resolve(Disaster::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testHandlingExceptions() {
        $strMsg = time();
        $objException = new LedgerMicroserviceException($strMsg, 203);

        $this->disaster->handleDisaster($objException);

        $this->assertDatabaseHas("log_errors", [
            "exception_class"   => get_class($objException),
            "exception_message" => $strMsg,
            "exception_code"    => 203,
        ]);
    }
}
