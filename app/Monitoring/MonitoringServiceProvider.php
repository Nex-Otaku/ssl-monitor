<?php

namespace App\Monitoring;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MonitoringServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('monitoring:check-sites')
                     ->hourly()
                     ->withoutOverlapping();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
