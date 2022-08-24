<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;

class Status
{
    public static function getName(): string
    {
        return 'status';
    }

    public static function getDescription(): string
    {
        return 'Состояние';
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('This is a command!');
    }
}
