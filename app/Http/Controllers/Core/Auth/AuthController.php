<?php

namespace App\Http\Controllers\Core\Auth;

use Auth;
use Route;
use Exception;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Contracts\Core\Auth\TwoFactor;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Services\{Auth as AuthService, Alias, Email, Phone, User as UserService};
use App\Http\Requests\Auth\{
    IsAuthorized,
    SignUp,
    Signin,
    RefreshToken,
    ResetPassword,
    CheckPassword,
    ForgotPassword,
    UpdatePassword
};

/**
 * @group Core Auth
 *
 */
class AuthController extends Controller {
    /** @var AuthService */
    protected AuthService $authService;
    /** @var UserService */
    protected UserService $userService;
    /** @var Alias */
    protected Alias $aliasService;
    /** @var Email */
    private Email $emailService;
    /** @var TwoFactor */
    private TwoFactor $twoFactor;
    /** @var Phone */
    private Phone $phoneService;

    /**
     * @param AuthService $authService
     * @param UserService $userService
     * @param Alias $aliasService
     * @param Email $emailService
     * @param Phone $phoneService
     * @param TwoFactor $twoFactor
     */
    public function __construct(AuthService $authService, UserService $userService, Alias $aliasService,
                                Email $emailService, Phone $phoneService, TwoFactor $twoFactor) {
        $this->authService = $authService;
        $this->userService = $userService;
        $this->aliasService = $aliasService;
        $this->emailService = $emailService;
        $this->phoneService = $phoneService;
        $this->twoFactor = $twoFactor;
    }

    /**
     * @param Signin $objRequest
     * @return object
     */
    public function signIn(Signin $objRequest) {
        request()->request->add([
            "grant_type"    => "password",
            "client_id"     => env("PASSWORD_CLIENT_ID"),
            "client_secret" => env("PASSWORD_CLIENT_SECRET"),
            "username"      => $objRequest->get("user"),
            "password"      => $objRequest->get("password"),
        ]);

        $response = Route::dispatch(Request::create("/oauth/token", "POST"));

        $data = json_decode($response->getContent(), true);

        if (!$response->isOk()) {
            return ($this->apiReject($data["response"], $data["status"]["message"], $response->getStatusCode()));
        }

        $objUser = $this->userService->findByEmailOrAlias($objRequest->get("user"));

        $objLoginSecurity = $objUser->loginSecurity;

        if (isset($objLoginSecurity) && $objLoginSecurity->flag_enabled) {
            if (!$objRequest->has("2fa_code")) {
                return $this->apiReject(null, "2FA Code Required.", 449);
            }

            $isValid = $this->twoFactor->verify($objUser, $objRequest->input("2fa_code"));

            if (!$isValid) {
                return $this->apiReject(null, "2FA Code Is Invalid.", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return ($this->apiReply([
            "auth"       => $data,
            "user"       => $objUser->user_uuid,
        ]));
    }

    /**
     * @return Response
     */
    public function signOut() {
        /** @var User $user */
        $user = Auth::user();
        $user->token()->revoke();

        return ($this->apiReply());
    }

    /**
     * @param SignUp $objRequest
     * @return object
     * @throws Exception
     */
    public function signUp(SignUp $objRequest) {
        $objUser = $this->userService->create($objRequest->only("name_first", "user_password"));
        $objEmail = $this->emailService->create($objRequest->input("email"), $objUser);
        $this->emailService->sendVerificationEmail($objEmail);

        if ($objRequest->has("phone_number", "phone_type")) {
            $this->phoneService->create($objRequest->only("phone_number", "phone_type"), $objUser);
        }

        request()->request->add([
            "grant_type"    => "password",
            "client_id"     => env("PASSWORD_CLIENT_ID"),
            "client_secret" => env("PASSWORD_CLIENT_SECRET"),
            "username"      => $objRequest->get("email"),
            "password"      => $objRequest->get("user_password"),
        ]);

        $response = Route::dispatch(Request::create("/oauth/token", "POST"));

        $data = json_decode($response->getContent(), true);

        if (!$response->isOk()) {
            return ($this->apiReject($data["response"], $data["status"]["message"], $response->getStatusCode()));
        }

        return ($this->apiReply([
            "auth" => $data,
            "user" => $objUser->user_uuid,
        ], "Please verified your email."));
    }


    public function userData() {
        /** @var User */
        $user = Auth::user();

        return ($this->apiReply($user->load(["aliases", "emails"])->append(["avatar"])));
    }

    public function userRefresh(RefreshToken $objRequest) {
        // if (!$objRequest->headers->has("Authorization")) {
        //     throw new UnauthorizedException();
        // }

        // Tokenize from the header.
        // $refreshToken = trim(preg_replace("/^(?:\s+)?Bearer\s/", "", $objRequest->header("Authorization")));

        request()->request->add([
            "grant_type"    => "refresh_token",
            "refresh_token" => $objRequest->refresh_token,
            "client_id"     => env("PASSWORD_CLIENT_ID"),
            "client_secret" => env("PASSWORD_CLIENT_SECRET"),
        ]);
        $response = Route::dispatch(Request::create("/oauth/token", "POST"));

        $data = json_decode($response->getContent(), true);

        if (!$response->isOk()) {
            return ($this->apiReject($data["response"], $data["status"]["message"], $response->getStatusCode()));
        }

        return ($this->apiReply($data));
    }

    public function checkPassword(CheckPassword $objRequest) {
        try {
            return ($this->apiReply([
                "data" => $this->authService->checkPassword($objRequest->current_password),
            ]));
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * @param ForgotPassword $request
     * @return mixed
     * @throws Exception
     */
    public function sendPasswordResetMail(ForgotPassword $request) {
        try {
            if (empty($request->all())) {
                abort(404, "No data provided");
            }

            if ($request->has("email")) {
                $objEmail = $this->emailService->find($request->email, true);

                if (is_null($objEmail)) {
                    abort(404, "User not found");
                }

                $user = $objEmail->user;
            } else if ($request->has("alias")) {
                $objAlias = $this->aliasService->find($request->alias);

                if (is_null($objAlias)) {
                    abort(404, "User not found");
                } else if (!$objAlias->flag_primary) {
                    abort(404, "Alias is not primary");
                }

                $user = $objAlias->user;
                $objEmail = $user->emails()->where("flag_primary", true)->first();
            } else if ($request->has("phone")) {
                $objPhone = $this->phoneService->findByPhone($request->phone);

                if (is_null($objPhone)) {
                    abort(404, "User not found");
                }

                $user = $objPhone->user;
                $objEmail = $user->emails()->where("flag_primary", true)->first();
            }

            if (!$objEmail->flag_verified) {
                abort(400, "This email is not verified yet.");
            }

            $this->authService->prepareForPasswordReset($user);

            return $this->apiReply();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function passwordReset(string $resetToken, ResetPassword $request, AuthService $authService) {
        try {
            $passwordReset = $authService->validateResetToken($resetToken);
            if (!$passwordReset) {
                abort(400, "This token is expired or invalid.");
            }
            $user = $authService->passwordReset($passwordReset, $request->new_password);

            return ($this->apiReply($user, "Reset your password", 202));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function changePassword(UpdatePassword $request, AuthService $authService) {
        try {
            if (!$authService->checkPassword($request->current_password)) {
                return $this->apiReject(null, "Invalid password", Response::HTTP_BAD_REQUEST);
            }

            $user = $authService->changePassword($request->new_password);

            return ($this->apiReply($user, "Changed your password", 202));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function isAuthorized(IsAuthorized $objRequest) {
        $bnAuth = is_authorized(AuthFacade::user(), $objRequest->input("group"), $objRequest->input("permission"));

        return $this->apiReply($bnAuth);
    }
}
