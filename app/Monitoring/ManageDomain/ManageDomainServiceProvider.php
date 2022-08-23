<?php

namespace App\Monitoring\ManageDomain;

use Illuminate\Support\ServiceProvider;

class ManageDomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MonitoringDomainsList::class, ConfigDomainsList::class);
    }
}
