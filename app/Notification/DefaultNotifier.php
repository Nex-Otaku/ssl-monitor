<?php

namespace App\Notification;

use App\Monitoring\DomainName;
use App\Notification\Channel\ChannelRegistry;
use App\Notification\Recipient\Recipient;
use App\Notification\Recipient\RecipientsList;

class DefaultNotifier implements Notifier
{
    private RecipientsList      $recipientsList;
    private ChannelRegistry     $channelRegistry;

    public function __construct(
        RecipientsList $recipientsList,
        ChannelRegistry $channelRegistry
    )
    {
        $this->recipientsList = $recipientsList;
        $this->channelRegistry = $channelRegistry;
    }

    public function notifyDomainOwner(DomainName $domain, string $message): void
    {
        if (!$this->isNotified($domain)) {
            return;
        }

        $recipients = $this->recipientsList->getRecipients($domain);

        foreach ($recipients as $recipient) {
            $this->sendNotification($recipient, $domain, $message);
        }
    }

    private function isNotified(DomainName $domain): bool
    {
        // TODO Сделать проверку, что уже отправляли сегодня уведомление по этому домену.
        return false;
    }

    private function sendNotification(Recipient $recipient, DomainName $domain, string $message): void
    {
        if ($recipient->isTelegram()) {
            $this->channelRegistry->getTelegram()->sendDomainNotification($recipient, $domain, $message);
        }
    }
}