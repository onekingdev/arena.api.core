<?php

namespace Tests\Unit\Core;

use Tests\TestCase;
use App\Models\Core\Mailing\Email as EmailModel;
use App\Contracts\Core\Mailing as MailingContract;

class Mailing extends TestCase
{
    private EmailModel      $email;
    private MailingContract $mailing;

    public function setUp(): void {
        parent::setUp();

        $this->email   = EmailModel::first();
        $this->mailing = resolve(MailingContract::class);
    }

    public function testAddMailToMailing(){
        $objMail = $this->mailing->addEmail("randomTest@email.com");

        $this->assertInstanceOf(EmailModel::class, $objMail);
        $this->assertEquals("randomTest@email.com", $objMail->email);
    }

    public function testDeleteMailByUuid(){
        $boolResult = $this->mailing->deleteEmailByUuid($this->email->row_uuid);

        $this->assertTrue($boolResult);
    }
}
