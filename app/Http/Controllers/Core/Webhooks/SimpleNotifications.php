<?php

namespace App\Http\Controllers\Core\Webhooks;

use App\Http\Controllers\Controller;
use App\Contracts\File\Music\Transcoder;
use App\Contracts\Core\Webhooks\SimpleNotification;

/**
 * @group Core Webhook
 *
 */
class SimpleNotifications extends Controller
{
    /** @var SimpleNotification */
    private SimpleNotification $snsService;
    /** @var Transcoder */
    private Transcoder $transcoder;

    /**
     * SimpleNotifications constructor.
     * @param SimpleNotification $snsService
     */
    public function __construct(SimpleNotification $snsService, Transcoder $transcoder) {
        $this->snsService = $snsService;
        $this->transcoder = $transcoder;
    }

    public function notification() {
        $strJsonRequest = file_get_contents('php://input');

        $arrRequest = json_decode($strJsonRequest, true);

        if (isset($arrRequest["Type"]) && $arrRequest["Type"] === "SubscriptionConfirmation") {
            $this->snsService->confirmSubscription($arrRequest);
        } elseif (isset($arrRequest["state"]) && isset($arrRequest["jobId"])) {
            $this->transcoder->updateStatus($arrRequest["jobId"], $arrRequest["state"]);
        } else {
            return $this->apiReject();
        }

        return response()->json('');
    }
}
