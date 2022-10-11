<?php

namespace App\Contracts\Core;

use App\Models\Common\LogError;
use Laravel\Passport\Client;

interface Slack {
    public function githubNotification(string $channel, array $githubPayload): string;
    public function githubActionNotification(string $channel, array $githubPayload): string;
    public function exceptionNotification(LogError $logError): string;
    public function passportNotification(Client $client, array $ebInfo, string $errorMessage);
    public function qldbNotification(string $message, string $host, string $channel): void;
    public function supervisorNotification(string $queue, string $channel): void;
}