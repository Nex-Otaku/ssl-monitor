<?php

namespace App\Monitoring\ManageDomain\Laravel;

use App\Monitoring\ManageDomain\MonitoringDomainsList;
use Illuminate\Support\ServiceProvider;

class ManageDomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MonitoringDomainsList::class, ConfigDomainsList::class);
    }
}