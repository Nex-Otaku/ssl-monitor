<?php

namespace App\Notification\Telegram;

use App\Notification\Exception\FailedToSendNotification;
use App\Notification\Http\HttpClient;

class NoCodeApiTelegramMessageSender implements TelegramMessageSender
{
    private string     $apiUrl;
    private HttpClient $httpClient;

    public function __construct(
        string $apiUrl,
        HttpClient $httpClient
    )
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = $httpClient;
    }

    public function send(string $message): void
    {
        $response = $this->httpClient
            ->setHeader('Accept', 'application/json')
            ->addQueryParam('text', $message)
            ->post($this->apiUrl);

        if ($response->getStatusCode() !== 200) {
            throw FailedToSendNotification::noCodeApiFailed($response->getStatusCode());
        }
    }
}