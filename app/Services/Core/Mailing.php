<?php

namespace App\Services\Core;

use App\Models\Core\Mailing\Email as EmailModel;
use App\Contracts\Core\Mailing as MailingContract;
use App\Repositories\Core\Mailing\Emails as EmailsRepository;

class Mailing implements MailingContract{
    /**
     * @var EmailsRepository
     */
    private EmailsRepository $emailsRepo;

    /**
     * Mailing constructor.
     * @param EmailsRepository $emails
     */
    public function __construct(EmailsRepository $emails) {
        $this->emailsRepo = $emails;
    }

    /**
     * @param string $email
     * @param bool $isBetaUser
     * @return EmailModel
     */
    public function addEmail(string $email, bool $isBetaUser = false): EmailModel{
        $objEmail = $this->emailsRepo->create(["email" => $email, "is_beta_user" => $isBetaUser]);

        if(is_null($objEmail)){
            abort(404, "Email hasn't added.");
        }

        return ($objEmail);
    }

    /**
     * @param string $emailUuid
     * @return mixed
     */
    public function deleteEmailByUuid(string $emailUuid){
        $boolResult = $this->emailsRepo->deleteByUuid($emailUuid);

        if (!$boolResult){
            abort(404, "Email hasn't deleted.");
        }

        return ($boolResult);
    }
}
