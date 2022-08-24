<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;

class Remove
{
    public static function getName(): string
    {
        return 'remove';
    }

    public static function getDescription(): string
    {
        return 'Убрать сайт из списка';
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('This is a command!');
    }
}
