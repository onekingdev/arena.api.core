<?php

namespace App\Http\Controllers\Core;

use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\UserCorrespondence;
use App\Http\Middleware\Webhook as WebhookMiddleware;

/**
 * @group Core
 *
 */
class Webhook extends Controller {

    public function __construct() {
        $this->middleware(WebhookMiddleware::class);
    }

    /**
     * @param Request $request
     * @param UserCorrespondence $correspondenceService
     * @return void
     * @throws \Exception
     */
    public function __invoke(Request $request, UserCorrespondence $correspondenceService) {
        $data = $request->get("event-data");
        $emailId = $data["message"]["headers"]["message-id"];
        $correspondence = $correspondenceService->findByEmail($emailId);
        if ($correspondence) {
            Log::info('event', ["data" => $data]);
            if ($data["event"] === "delivered") {
                $correspondenceService->update($correspondence, ["flag_received" => true]);
            }

            if ($data["event"] === "opened" || $data["event"] === "clicked") {
                $correspondenceService->update($correspondence, ["flag_read" => true]);
            }
        }
    }
}
