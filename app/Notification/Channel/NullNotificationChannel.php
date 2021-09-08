<?php

namespace App\Notification\Channel;

use App\Monitoring\DomainName;
use App\Notification\Recipient\Recipient;

class NullNotificationChannel implements NotificationChannel
{
    public function sendDomainNotification(Recipient $recipient, DomainName $domain, string $message): void
    {
        // Не делаем ничего.
    }

    public function sendCustomNotification(Recipient $recipient, string $message): void
    {
        // Не делаем ничего.
    }
}