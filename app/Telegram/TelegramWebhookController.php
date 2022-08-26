<?php

namespace App\Telegram;

use App\Http\Controllers\Controller;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;

class TelegramWebhookController extends Controller
{
    /**
     * Handle the request.
     */
    public function handle(Nutgram $bot)
    {
        $bot->setRunningMode(Webhook::class);
        $bot->run();
    }
}
