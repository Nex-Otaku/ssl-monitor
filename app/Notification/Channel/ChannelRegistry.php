<?php

namespace App\Notification\Channel;

class ChannelRegistry
{
    private NotificationChannel $telegram;

    public function __construct()
    {
        $this->telegram = new NullNotificationChannel();
    }

    public function withTelegram(NotificationChannel $telegram): self
    {
        $new           = clone $this;
        $new->telegram = $telegram;

        return $new;
    }

    public function getTelegram(): NotificationChannel
    {
        return $this->telegram;
    }
}