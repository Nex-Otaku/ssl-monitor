<?php

namespace App\Notification;

use App\Monitoring\Vo\DomainName;

interface Notifier
{
    public function notifyDomainOwner(DomainName $domain, string $message): void;

    public function notifyAdmin(string $message): void;
}
