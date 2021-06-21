<?php

namespace App\Notification\Recipient;

use App\Monitoring\DomainName;

interface RecipientsList
{
    /**
     * @param DomainName $domain
     * @return Recipient[]
     */
    public function getRecipients(DomainName $domain): array;
}