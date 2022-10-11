<?php

namespace App\Http\Controllers\Soundblock;

use App\Http\Controllers\Controller;
use App\Services\Auth as AuthService;
use App\Http\Requests\Auth\ResetPassword;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class AuthController extends Controller
{
    /** @var AuthService */
    private AuthService $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * @param string $resetToken
     * @param ResetPassword $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|object
     * @throws \Exception
     */
    public function passwordReset(string $resetToken, ResetPassword $request) {
        try {
            $passwordReset = $this->authService->validateResetToken($resetToken);
            if (!$passwordReset) {
                abort(400, "This token is expired or invalid.");
            }
            $user = $this->authService->passwordReset($passwordReset, $request->new_password);

            return ($this->apiReply($user, "Reset your password", 202));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
