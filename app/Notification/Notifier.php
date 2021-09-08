<?php

namespace App\Notification;

use App\Monitoring\DomainName;

interface Notifier
{
    public function notifyDomainOwner(DomainName $domain, string $message): void;

    public function notifyAdmin(string $message): void;
}