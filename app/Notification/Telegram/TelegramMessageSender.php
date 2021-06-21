<?php

namespace App\Notification\Telegram;

interface TelegramMessageSender
{
    public function send(string $message): void;
}