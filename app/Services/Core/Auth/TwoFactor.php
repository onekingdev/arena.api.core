<?php

namespace App\Services\Core\Auth;

use Util;
use App\Models\Users\User;
use PragmaRX\Google2FALaravel\Google2FA;
use App\Contracts\Core\Auth\TwoFactor as TwoFactorContract;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TwoFactor implements TwoFactorContract {
    const COMPANY = "Arena";

    /**
     * @var Google2FA
     */
    private Google2FA $google2FA;

    public function __construct(Google2FA $google2FA) {
        $this->google2FA = $google2FA;
    }

    /**
     * @param User $objUser
     * @return array
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function generateSecrets(User $objUser): array {
        $strPrimaryEmail = $objUser->primary_email->user_auth_email ?? "";
        $prefix = str_pad($objUser->user_id, 10, 'X');

        $objLoginSecurity = $objUser->loginSecurity;

        if (is_null($objLoginSecurity)) {
            $strSecret = $this->google2FA->generateSecretKey(16, $prefix);

            $objUser->loginSecurity()->create([
                "row_uuid"         => Util::uuid(),
                "user_uuid"        => $objUser->user_uuid,
                "google2fa_secret" => $strSecret,
                "flag_enabled"     => false,
            ]);
        } else {
            $strSecret = $objLoginSecurity->google2fa_secret;

            $objUser->loginSecurity()->update([
                "flag_enabled" => true,
            ]);
        }

        $strQrCode = $this->google2FA->getQRCodeInline(self::COMPANY, $strPrimaryEmail, $strSecret);
        $strQrUrl = $this->google2FA->getQRCodeUrl(self::COMPANY, $strPrimaryEmail, $strSecret);

        return ["secret" => $strSecret, "qrCode" => $strQrCode, "url" => $strQrUrl, "enabled" => false];
    }

    /**
     * @param User $objUser
     * @return array
     */
    public function getSecrets(User $objUser): array {
        $strPrimaryEmail = $objUser->primary_email->user_auth_email ?? "";

        $objLoginSecurity = $objUser->loginSecurity;

        if (is_null($objLoginSecurity)) {
            throw new BadRequestHttpException("You Haven't Enabled 2FA");
        }

        $strSecret = $objLoginSecurity->google2fa_secret;
        $strQrCode = $this->google2FA->getQRCodeInline(self::COMPANY, $strPrimaryEmail, $strSecret);
        $strQrUrl = $this->google2FA->getQRCodeUrl(self::COMPANY, $strPrimaryEmail, $strSecret);

        return ["secret" => $strSecret, "qrCode" => $strQrCode, "url" => $strQrUrl, "enabled" => $objLoginSecurity->flag_enabled];
    }

    /**
     * @param User $objUser
     * @return User
     */
    public function removeSecrets(User $objUser) {
        $objLoginSecurity = $objUser->loginSecurity;

        if (is_null($objLoginSecurity) && !$objLoginSecurity->flag_enabled) {
            throw new BadRequestHttpException("You Haven't Enabled 2FA");
        }

        $objLoginSecurity->update([
            "flag_enabled" => false,
        ]);

        return $objUser;
    }

    /**
     * @param User $objUser
     * @param int $intCode
     * @return bool
     * @throws \PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException
     * @throws \PragmaRX\Google2FA\Exceptions\InvalidCharactersException
     * @throws \PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException
     */
    public function verify(User $objUser, int $intCode): bool {
        $objLoginSecurity = $objUser->loginSecurity;

        return $this->google2FA->verify(strval($intCode), $objLoginSecurity->google2fa_secret);
    }

    public function enableTwoFactor(User $objUser) {
        $objLoginSecurity = $objUser->loginSecurity;

        if (is_null($objLoginSecurity)) {
            throw new BadRequestHttpException("You Don't Have 2FA Secrets.");
        }

        $objLoginSecurity->flag_enabled = true;
        $objLoginSecurity->save();

        return $objUser;
    }
}