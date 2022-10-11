<?php


namespace App\Services\Core\Webhooks;


use App\Contracts\Core\Webhooks\SimpleNotification as SimpleNotificationContract;
use GuzzleHttp\Client;

class SimpleNotification implements SimpleNotificationContract {
    /**
     * @var Client
     */
    private Client $http;

    public function __construct(Client $http) {
        $this->http = $http;
    }

    public function confirmSubscription(array $confirmationData): bool {
        if (!isset($confirmationData["SubscribeURL"])) {
            throw new \Exception("Invalid Subscription Payload.");
        }

        try{
            $response = $this->http->get($confirmationData["SubscribeURL"]);
            $response->getBody()->getContents();
        } catch (\Exception $exception) {
            throw new \Exception("Failed Subscription Confirmation.");
        }

        return true;
    }
}