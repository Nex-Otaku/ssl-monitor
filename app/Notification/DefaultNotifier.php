<?php

namespace App\Notification;

use App\Monitoring\DomainName;

class DefaultNotifier implements Notifier
{
    public function notifyDomainOwner(DomainName $domain, string $message): void
    {
        // TODO: Implement notifyDomainOwner() method.
    }
}