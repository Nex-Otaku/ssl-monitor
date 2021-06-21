<?php

namespace App\Notification\Recipient;

class Recipient
{
    private bool $isTelegram;

    public function __construct(
        bool $isTelegram
    )
    {
        $this->isTelegram = $isTelegram;
    }

    public function isTelegram(): bool
    {
        return $this->isTelegram;
    }
}