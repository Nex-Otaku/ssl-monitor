<?php

namespace App\Notification\Laravel;

use App\Common\Logger\Logger;
use App\Common\Logger\NullLogger;
use App\Notification\Http\GuzzleHttpClient;
use App\Notification\Http\HttpClient;
use App\Notification\Channel\ChannelRegistry;
use App\Notification\DefaultNotifier;
use App\Notification\Laravel\Commands\TestNotificationCommand;
use App\Notification\Notifier;
use App\Notification\Recipient\RecipientsList;
use App\Notification\Channel\TelegramNotificationChannel;
use App\Notification\Telegram\NoCodeApiTelegramMessageSender;
use App\Notification\Telegram\TelegramMessageSender;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $this->app->bind(Notifier::class, DefaultNotifier::class);
        $this->app->bind(RecipientsList::class, ConfigRecipientsList::class);
        $this->app->bind(HttpClient::class, GuzzleHttpClient::class);
        $this->app->bind(Logger::class, NullLogger::class);

        $this->app->bind(TelegramMessageSender::class, function () use ($app) {
            return new NoCodeApiTelegramMessageSender(
                config('nocodeapi.defaultNotificationApiUrl'),
                $app->make(HttpClient::class)
            );
        });

        $this->app->when(DefaultNotifier::class)
            ->needs(ChannelRegistry::class)
            ->give(function () use ($app) {
                return (new ChannelRegistry())
                    ->withTelegram($app->make(TelegramNotificationChannel::class));
            });

        $this->app->singleton('command.notificationTest', function () use ($app) {
            return new TestNotificationCommand(
                $app->make(TelegramNotificationChannel::class),
            );
        });

        $this->commands(['command.notificationTest']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.notificationTest'];
    }
}