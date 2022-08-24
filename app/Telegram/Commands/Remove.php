<?php

namespace App\Telegram\Commands;

use App\Monitoring\Entities\MonitoringSite;
use App\Monitoring\Vo\DomainName;
use SergiX44\Nutgram\Nutgram;

class Remove
{
    public static function getName(): string
    {
        return 'remove';
    }

    public static function getDescription(): string
    {
        return 'Убрать сайт из списка: /remove [сайт]';
    }

    public static function getPattern(): string
    {
        return '/remove (.+)';
    }

    public function runCommandByName(Nutgram $bot): void
    {
        $bot->sendMessage('Пожалуйста, укажите сайт: /remove [сайт]');
    }

    public function runCommandByPattern(Nutgram $bot, string $siteUrl): void
    {
        if (!DomainName::isValid($siteUrl)) {
            $bot->sendMessage('Некорректный формат адреса сайта. Пример адреса: mysite.ru');

            return;
        }

        MonitoringSite::destroy(DomainName::fromString($siteUrl)->toString(), $bot->userId());
        $bot->sendMessage('Сайт удалён из отслеживания.');
    }
}
