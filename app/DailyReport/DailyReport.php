<?php

namespace App\DailyReport;

use App\Notification\Notifier;

class DailyReport
{
    private Notifier $notifier;

    public function __construct(
        Notifier $notifier
    )
    {
        $this->notifier = $notifier;
    }

    public function withNotifier(Notifier $notifier): self
    {
        $new = clone $this;
        $new->notifier = $notifier;

        return $new;
    }

    public function send(): void
    {
        $this->notifier->notifyAdmin('Another day in paradise. Application is working just fine.');
    }
}
