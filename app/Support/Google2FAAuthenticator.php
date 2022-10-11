<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\{Exceptions\InvalidSecretKey, Support\Authenticator};

class Google2FAAuthenticator extends Authenticator {

    protected function canPassWithoutCheckingOTP() {
        if ($this->getUser()->loginSecurity == null) {
            return (true);
        }

        return ($this->getUser()->loginSecurity->flag_passed);
    }

    protected function getGoogle2FASecretKey() {
        $secret = $this->getUser()->loginSecurity->{config("google2fa.otp_secret_column")};

        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey("Secret key cannot be empty");
        }

        return ($secret);
    }
}
