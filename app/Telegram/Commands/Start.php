<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;

class Start
{
    public static function getName(): string
    {
        return 'start';
    }

    public static function getDescription(): string
    {
        return 'Приветствие';
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('This is a command!');
    }
}
