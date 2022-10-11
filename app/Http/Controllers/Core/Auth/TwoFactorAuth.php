<?php

namespace App\Http\Controllers\Core\Auth;

use App\Models\Users\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Core\Auth\TwoFactor;
use App\Http\Requests\Auth\Google2fa\EnableTwoFactor;

/**
 * @group Core Auth
 *
 */
class TwoFactorAuth extends Controller
{
    /**
     * @var TwoFactor
     */
    private TwoFactor $twoFactor;

    public function __construct(TwoFactor $twoFactor) {
        $this->twoFactor = $twoFactor;
    }


    /**
     * Generate 2FA Secrets
     * @responseFile 200 responses/auth/2fa_secrets.json
     *
     * @return mixed
     */
    public function generateSecret() {
        /** @var User $objUser */
        $objUser = Auth::user();
        $objLoginSecurity = $objUser->loginSecurity;

        if (is_object($objLoginSecurity)) {
            return $this->apiReject(null, "You Already Have 2FA Secrets.", Response::HTTP_BAD_REQUEST);
        }

        $twoFactorData = $this->twoFactor->generateSecrets($objUser);

        return $this->apiReply($twoFactorData);
    }

    /**
     * Get 2FA Secrets
     * @responseFile 200 responses/auth/2fa_secrets.json
     *
     * @return mixed
     */
    public function getSecret() {
        /** @var User $objUser */
        $objUser = Auth::user();
        $objLoginSecurity = $objUser->loginSecurity;

        if (is_null($objLoginSecurity)) {
            $twoFactorData = $this->twoFactor->generateSecrets($objUser);
        } else {
            $twoFactorData = $this->twoFactor->getSecrets($objUser);
        }

        return $this->apiReply($twoFactorData);
    }

    /**
     * Disable 2FA
     *
     * @return mixed
     */
    public function removeSecrets() {
        /** @var User $objUser */
        $objUser = Auth::user();
        $objLoginSecurity = $objUser->loginSecurity;

        if (is_null($objLoginSecurity) || !$objLoginSecurity->flag_enabled) {
            return $this->apiReject(null, "You Haven't Enabled 2FA.", Response::HTTP_BAD_REQUEST);
        }

        $this->twoFactor->removeSecrets($objUser);

        return $this->apiReply(null, "You Have Successfully Disabled 2FA");
    }

    /**
     * Verify 2FA Connected
     * @bodyParam auth_code string required One Time Code from Google Auth App.
     *
     * @param EnableTwoFactor $objRequest
     * @return mixed
     */
    public function verifyTwoFactorConnected(EnableTwoFactor $objRequest) {
        /** @var User $objUser */
        $objUser = Auth::user();

        $objLoginSecurity = $objUser->loginSecurity;

        if (is_null($objLoginSecurity)) {
            return $this->apiReject(null, "You Haven't Secret Tokens.", Response::HTTP_BAD_REQUEST);
        }

        if (is_object($objLoginSecurity) && $objLoginSecurity->flag_enabled) {
            return $this->apiReject(null, "You Have Already Enabled 2FA.", Response::HTTP_BAD_REQUEST);
        }

        $bnVerified = $this->twoFactor->verify($objUser, $objRequest->input("auth_code"));

        if (!$bnVerified) {
            return $this->apiReject(null, "Invalid Auth Code.", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->twoFactor->enableTwoFactor($objUser);

        return $this->apiReply(null, "You Have Successfully Verify 2FA.");
    }
}
