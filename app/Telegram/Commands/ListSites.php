<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Nutgram;

class ListSites
{
    public static function getName(): string
    {
        return 'list';
    }

    public static function getDescription(): string
    {
        return 'Список отслеживаемых сайтов';
    }

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage('This is a command!');
    }
}
