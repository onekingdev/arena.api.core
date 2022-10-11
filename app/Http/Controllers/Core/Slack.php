<?php

namespace App\Http\Controllers\Core;

use App\Contracts\Core\Slack as SlackContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\Slack\GithubAction;
use Illuminate\Http\Request;

/**
 * @group Core
 *
 */
class Slack extends Controller
{
    /**
     * @var SlackContract
     */
    private SlackContract $slackService;

    public function __construct(SlackContract $slackService) {
        $this->slackService = $slackService;
    }

    public function githubEvent(Request $request) {
        $this->slackService->githubNotification(config("slack.channels.commit"), json_decode($request->input("payload"), true));

        return $this->apiReply();
    }

    public function githubActionsEvent(GithubAction $request) {
        $this->slackService->githubActionNotification(config("slack.channels.action"), $request->all());

        return $this->apiReply();
    }
}
