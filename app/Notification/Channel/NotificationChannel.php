<?php

namespace App\Notification\Channel;

use App\Monitoring\DomainName;
use App\Notification\Recipient\Recipient;

interface NotificationChannel
{
    public function sendDomainNotification(Recipient $recipient, DomainName $domain, string $message): void;

    public function sendCustomNotification(Recipient $recipient, string $message): void;
}
