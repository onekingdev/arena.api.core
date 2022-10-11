<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Contracts\Core\Mailing as MailingContract;
use App\Http\Requests\Core\Mailing as MailingRequest;

/**
 * @group Core
 *
 */
class Mailing extends Controller
{
    private MailingContract $mailing;

    public function __construct(){
        $this->mailing = resolve(MailingContract::class);
    }

    /**
     * @param MailingRequest $request
     * @return mixed
     */
    public function addEmail(MailingRequest $request){
        $objEmail = $this->mailing->addEmail($request->input("email"), $request->input("beta_user"));

        return ($this->apiReply($objEmail, "Email added successfully.", 200));
    }

    /**
     * @param string $emailUuid
     * @return mixed
     */
    public function deleteEmailByUuid(string $emailUuid){
        $boolResult = $this->mailing->deleteEmailByUuid($emailUuid);

        return ($this->apiReply(null, "Email deleted successfully.", 200));
    }
}
