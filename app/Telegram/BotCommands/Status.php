<?php

namespace App\Telegram\Commands;

use App\Monitoring\Entities\MonitoringSite;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

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
        $bot->sendMessage(
            $this->getMessage($bot->userId()),
            [
                'parse_mode' => ParseMode::HTML,
            ]
        );
    }

    private function getMessage(int $userTgId): string
    {
        $sites = MonitoringSite::forTgUser($userTgId);

        if (count($sites) === 0) {
            return "Сайтов нет";
        }

        $okCount = 0;
        $warningCount = 0;
        $failCount = 0;

        foreach ($sites as $site) {
            if ($site->isOk()) {
                $okCount++;
            }

            if ($site->isWarning()) {
                $warningCount++;
            }

            if ($site->isFail()) {
                $failCount++;
            }
        }

        $total = count($sites);
        $nodataCount = $total - $okCount - $warningCount - $failCount;

        $okLabel = "✅ {$okCount}";

        $warningLabel = ($warningCount > 0)
            ? " / ⚠ {$warningCount}"
            : '';

        $failLabel = ($failCount > 0)
            ? " / ❌ {$failCount}"
            : '';

        $nodataLabel = ($nodataCount > 0)
            ? " / ❓ {$nodataCount}"
            : '';

        return "Сайты: {$okLabel}{$warningLabel}{$failLabel}{$nodataLabel}, всего {$total}";
    }
}
