<?php

namespace App\Monitoring\ManageDomain\Laravel;

use App\Monitoring\ManageDomain\MonitoringDomainsList;

class ConfigDomainsList implements MonitoringDomainsList
{
    public function getDomains(): array
    {
        // TODO Сделать управление доменами.
        return config('monitoring.domains');
    }
}