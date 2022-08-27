<?php

namespace App\Monitoring;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class MonitoringServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('monitoring:check-sites')
                     ->everyMinute()
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
