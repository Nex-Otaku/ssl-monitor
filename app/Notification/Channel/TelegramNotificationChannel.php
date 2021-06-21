<?php

namespace App\Notification\Channel;

use App\Monitoring\DomainName;
use App\Notification\Recipient\Recipient;

class TelegramNotificationChannel implements NotificationChannel
{
    public function sendDomainNotification(Recipient $recipient, DomainName $domain, string $message): void
    {
        // TODO: Implement sendDomainNotification() method.

        echo $message . "\n";
    }
}