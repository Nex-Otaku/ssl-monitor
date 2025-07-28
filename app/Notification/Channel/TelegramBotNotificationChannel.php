<?php

namespace App\Notification\Channel;

use App\Monitoring\Vo\DomainName;
use App\Notification\Recipient\Recipient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;

class TelegramBotNotificationChannel implements NotificationChannel
{
    public function sendDomainNotification(Recipient $recipient, DomainName $domain, string $message): void
    {
        $token = env('TELEGRAM_TOKEN');
        $response = Http::post("https://api.telegram.org/bot$token/sendMessage", [
            'chat_id' => $recipient->getChatId(),
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        if ($response->failed()) {
            Log::error('Telegram error', $response->json());
        }
    }

    public function sendCustomNotification(Recipient $recipient, string $message): void
    {
        // Ничего не отправляем
    }
}
