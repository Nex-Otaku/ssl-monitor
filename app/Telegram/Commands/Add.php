<?php

namespace App\Telegram\Commands;

use App\Monitoring\Entities\MonitoringSite;
use App\Monitoring\Vo\DomainName;
use SergiX44\Nutgram\Nutgram;

class Add
{
    public static function getName(): string
    {
        return 'add';
    }

    public static function getDescription(): string
    {
        return 'Добавить сайт в список: /add [сайт]';
    }

    public static function getPattern(): string
    {
        return '/add (.+)';
    }

    public function runCommandByName(Nutgram $bot): void
    {
        $bot->sendMessage('Пожалуйста, укажите сайт: /add [сайт]');
    }

    public function runCommandByPattern(Nutgram $bot, string $siteUrl): void
    {
        if (!DomainName::isValid($siteUrl)) {
            $bot->sendMessage('Некорректный формат адреса сайта. Пример адреса: mysite.ru');

            return;
        }

        MonitoringSite::create(DomainName::fromString($siteUrl)->toString(), $bot->userId());
    }
}
