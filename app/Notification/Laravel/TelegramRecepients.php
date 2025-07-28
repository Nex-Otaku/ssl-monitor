<?php

namespace App\Notification\Laravel;

use App\Monitoring\Models\Monitor;
use App\Monitoring\Vo\DomainName;
use App\Notification\Recipient\Recipient;
use App\Notification\Recipient\RecipientsList;

class TelegramRecepients implements RecipientsList
{
    public function getRecipients(DomainName $domain): array
    {
        $chatIds = Monitor::join(
            'sites', 'sites.id', '=', 'monitors.site_id'
        )->where('sites.domain', '=', $domain->toString())
            ->pluck('monitors.user_tg_id')->toArray();

        $recipients = [];
        foreach ($chatIds as $chatId) {
            $recepient = new Recipient(true);
            $recepient->setChatId($chatId);
            $recipients[] = $recepient;
        }

        return $recipients;
    }
}
