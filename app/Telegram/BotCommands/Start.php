<?php

namespace App\Telegram\BotCommands;

use App\Monitoring\Entities\MonitoringSite;
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
        $bot->sendMessage($this->getMessage($bot->userId()));
    }

    private function getMessage(int $userTgId): string
    {
        $message = "Бот следит за работой сайтов и оповещает вас о проблемах.\n\n";

        $sites = MonitoringSite::forTgUser($userTgId);

        if (count($sites) === 0) {
            $message .= "Добавьте сайт в список, и бот начнёт его отслеживать.\n";
        } else {
            $message .= "Отслеживаемые сайты:\n";

            foreach ($sites as $site) {
                $message .= $site->getDomainName() . "\n";
            }
        }

        return $message;
    }
}
