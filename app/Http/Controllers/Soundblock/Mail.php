<?php

namespace App\Http\Controllers\Soundblock;

use App\Services\Email;
use App\Http\Controllers\Controller;
use App\Http\Transformers\User\Email as EmailTransformer;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Mail extends Controller
{
    public function verifyEmail(Email $emailService, string $hash) {
        $objEmail = $emailService->verifyEmailByHash($hash);

        return ($this->item($objEmail, new EmailTransformer));
    }
}
