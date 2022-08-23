<?php

namespace App\DailyReport;

use App\DailyReport\Commands\DailyReportCommand;
use App\Notification\EchoNotifier;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DailyReportServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('daily-report:run')
                     ->timezone('Europe/Moscow')
                     ->dailyAt('11:00');
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

        $this->app->singleton('command.dailyReport', function () use ($app) {
            return new DailyReportCommand(
                $app->make(DailyReport::class),
                new EchoNotifier()
            );
        });

        $commands []= 'command.dailyReport';

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
                'command.dailyReport',
            ];
    }
}
