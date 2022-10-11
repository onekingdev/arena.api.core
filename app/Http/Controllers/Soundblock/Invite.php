<?php

namespace App\Http\Controllers\Soundblock;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Soundblock\Invites;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Contracts\Soundblock\Invite\Invite as InviteContract;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\{
    Controllers\Controller,
    Requests\Soundblock\Invite\InviteSignIn,
    Requests\Soundblock\Invite\InviteSignUp,
    Transformers\Soundblock\Invite as InviteTransformer
};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Invite extends Controller {
    /** @var Invites */
    private Invites $invites;
    /** @var InviteContract */
    private InviteContract $inviteService;

    /**
     * Invite constructor.
     * @param Invites $invites
     * @param InviteContract $inviteService
     */
    public function __construct(Invites $invites, InviteContract $inviteService) {
        $this->invites = $invites;
        $this->inviteService = $inviteService;
    }

    /**
     * @param string $inviteHash
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|Response|object
     * @throws Exception
     */
    public function getInvite(string $inviteHash) {
        $objInvite = $this->inviteService->getInviteByHash($inviteHash);

        if ($objInvite->flag_used) {
            return ($this->apiReject(null, "This invite already been used.", Response::HTTP_BAD_REQUEST));
        }

        return $this->item($objInvite, new InviteTransformer());
    }

    /**
     * @param $inviteHash
     * @param InviteSignUp $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed|object
     * @throws Exception
     */
    public function signUp($inviteHash, InviteSignUp $objRequest) {
        try {
            $objInvite = $this->inviteService->getInviteByHash($inviteHash);

            if ($objInvite->flag_used) {
                throw new AccessDeniedHttpException("This invite has already used.");
            }

            $objUser = $this->inviteService->useInvite($objInvite, $objRequest->all());

            request()->request->add([
                "grant_type"    => "password",
                "client_id"     => env("PASSWORD_CLIENT_ID"),
                "client_secret" => env("PASSWORD_CLIENT_SECRET"),
                "username"      => $objInvite->invite_email,
                "password"      => $objRequest->get("user_password"),
            ]);

            $response = Route::dispatch(Request::create("/oauth/token", "POST"));

            $data = json_decode($response->getContent(), true);

            if (!$response->isOk()) {
                return ($data);
            }

            return ($this->apiReply([
                "auth" => $data,
                "user" => $objUser->user_uuid,
            ]));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $inviteHash
     * @param InviteSignIn $objRequest
     * @return mixed
     * @throws Exception
     */
    public function signIn($inviteHash, InviteSignIn $objRequest) {
        try {
            $objInvite = $this->inviteService->getInviteByHash($inviteHash);

            if ($objInvite->flag_used) {
                throw new AccessDeniedHttpException("This invite has already used.");
            }

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
                return ($data);
            }

            $objUser = $this->inviteService->inviteSignIn($objInvite, $objRequest->all());

            return ($this->apiReply([
                "auth" => $data,
                "user" => $objUser->user_uuid,
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Request $objRequest
     * @return JsonResponse
     */
    public function getInviteHash(Request $objRequest) {
        if (!$objRequest->has("email")) {
            abort(400, "Email field is required.");
        }
        $objUser = Auth::user();
        $adminsIds = range(1, 6);

        if (array_search($objUser->user_id, $adminsIds) === false) {
            abort(404);
        }

        $objInvite = $this->inviteService->getInviteByEmail($objRequest->input("email"));

        if (is_null($objInvite)) {
            abort(404, "Invite Not Found");
        }

        return response()->json($objInvite);
    }
}
