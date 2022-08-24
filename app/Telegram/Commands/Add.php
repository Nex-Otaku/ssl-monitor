<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;

class Add
{
    public static function getName(): string
    {
        return 'add';
    }

    public static function getDescription(): string
    {
        return 'Добавить сайт в список';
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('This is a command!');
    }
}
