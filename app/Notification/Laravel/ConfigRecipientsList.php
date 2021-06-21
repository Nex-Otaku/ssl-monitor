<?php

namespace App\Notification\Laravel;

use App\Monitoring\DomainName;
use App\Notification\Recipient\Recipient;
use App\Notification\Recipient\RecipientsList;

class ConfigRecipientsList implements RecipientsList
{
    public function getRecipients(DomainName $domain): array
    {
        return [
            new Recipient(true),
        ];
    }
}