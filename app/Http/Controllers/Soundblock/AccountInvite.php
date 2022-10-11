<?php

namespace App\Http\Controllers\Soundblock;

use Auth;
use App\Models\Users\User;
use Illuminate\Http\Response;
use App\Services\Common\Common;
use App\Http\Controllers\Controller;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class AccountInvite extends Controller {
    /** @var Common */
    private Common $commonService;

    /**
     * AccountInvite constructor.
     * @param Common $commonService
     */
    public function __construct(Common $commonService) {
        $this->commonService = $commonService;
    }

    public function getInvites() {
        /** @var User $objUser*/
        $objUser = Auth::user();

        return $this->apiReply($this->commonService->getAccountInvites($objUser));
    }

    public function acceptInvite(string $account) {
        /** @var User $objUser*/
        $objUser = Auth::user();
        $objAccount = $this->commonService->find($account);

        if ($objAccount) {
            return $this->apiReply($this->commonService->acceptInvite($objAccount, $objUser));
        }

        return ($this->apiReject(null, "Account not found.", Response::HTTP_BAD_REQUEST));
    }

    public function rejectInvite(string $account) {
        /** @var User $objUser*/
        $objUser = Auth::user();
        $objAccount = $this->commonService->find($account);

        if ($objAccount) {
            return $this->apiReply($this->commonService->rejectInvite($objAccount, $objUser));
        }

        return ($this->apiReject(null, "Account not found.", Response::HTTP_BAD_REQUEST));
    }
}
