<?php

namespace App\Notification\Channel;

use App\Monitoring\DomainName;
use App\Notification\Recipient\Recipient;
use App\Notification\Telegram\TelegramMessageSender;

class TelegramNotificationChannel implements NotificationChannel
{
    private TelegramMessageSender $telegramMessageSender;

    public function __construct(
        TelegramMessageSender $telegramMessageSender
    )
    {
        $this->telegramMessageSender = $telegramMessageSender;
    }

    public function sendDomainNotification(Recipient $recipient, DomainName $domain, string $message): void
    {
        $this->telegramMessageSender->send($message);
    }

    public function sendCustomNotification(Recipient $recipient, string $message): void
    {
        $this->telegramMessageSender->send($message);
    }
}
