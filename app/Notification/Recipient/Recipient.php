<?php

namespace App\Notification\Recipient;

class Recipient
{
    private bool $isTelegram;
    private ?int $chatId;

    public function __construct(
        bool $isTelegram
    )
    {
        $this->isTelegram = $isTelegram;
        $this->chatId = null;
    }

    public function isTelegram(): bool
    {
        return $this->isTelegram;
    }

    public function setChatId(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }
}
