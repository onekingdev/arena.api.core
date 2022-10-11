<?php

namespace App\Http\Controllers\Core\Account;

use Auth;
use App\Models\Users\User;
use App\Http\Controllers\Controller;
use App\Services\Email as EmailService;
use App\Http\Transformers\User\Email as EmailTransformer;

/**
 * @group Core Account
 *
 */
class Email extends Controller {

    /**
     * @param string $hash
     * @param EmailService $emailService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function verifyEmail(string $hash, EmailService $emailService) {
        try {
            $objEmail = $emailService->verifyEmailByHash($hash);

            return ($this->item($objEmail, new EmailTransformer));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param string $email
     * @param EmailService $emailService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function sendVerifyEmailMessage(string $email, EmailService $emailService) {
        try {
            /** @var User */
            $objUser = Auth::user();
            $objEmail = $emailService->findForUser($objUser, $email);

            if (is_null($objEmail)) {
                abort(404, "Email Not Found.");
            }

            $objEmail = $emailService->sendVerificationEmail($objEmail);

            return ($this->item($objEmail, new EmailTransformer));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
