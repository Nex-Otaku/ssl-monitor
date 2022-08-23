<?php

namespace App\Alert;

use App\Alert\Commands\AlertDryRunCommand;
use App\Alert\Commands\AlertSslCertificatesCommand;
use App\Notification\EchoNotifier;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AlertServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('alert:ssl-certificates')
                     ->timezone('Europe/Moscow')
                     ->dailyAt('10:00');
        });
    }

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

        $commands []= 'command.alertDryRun';

        $this->app->singleton('command.alertSslCertificates', function () use ($app) {
            return new AlertSslCertificatesCommand(
                $app->make(AlertChecker::class)
            );
        });

        $commands []= 'command.alertSslCertificates';

        $this->commands($commands);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
                'command.alertDryRun',
                'command.alertSslCertificates',
            ];
    }
}
