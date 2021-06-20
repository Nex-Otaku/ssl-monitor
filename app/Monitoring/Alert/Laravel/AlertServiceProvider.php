<?php

namespace App\Monitoring\Alert\Laravel;

use App\Monitoring\Alert\AlertChecker;
use App\Monitoring\Alert\Laravel\Commands\AlertDryRunCommand;
use App\Notification\EchoNotifier;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AlertServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $this->app->singleton('command.alertDryRun', function () use ($app) {
            return new AlertDryRunCommand(
                $app->make(AlertChecker::class),
                new EchoNotifier()
            );
        });

        $this->commands(['command.alertDryRun']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.alertDryRun'];
    }
}
