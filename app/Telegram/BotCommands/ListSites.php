<?php

namespace App\Telegram\BotCommands;

use App\Monitoring\Entities\MonitoringSite;
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
        $bot->sendMessage($this->getMessage($bot->chatId()));
    }

    private function getMessage(int $userTgId): string
    {
        $sites = MonitoringSite::forTgUser($userTgId);

        if (count($sites) === 0) {
            return "У вас нет отслеживаемых сайтов. Добавьте сайт в список, и бот начнёт его отслеживать.\n";
        }

        $message = "Отслеживаемые сайты:\n\n";
        $counter = 0;

        foreach ($sites as $site) {
            $counter++;
            $message .= "{$counter}. " . $site->getDomainName() . " — {$site->getStatusLabel()}\n\n";
        }

        return $message;
    }
}
