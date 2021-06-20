<?php

namespace App\Notification\Laravel;

use App\Notification\DefaultNotifier;
use App\Notification\Notifier;
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
        $this->app->bind(Notifier::class, DefaultNotifier::class);
    }
}