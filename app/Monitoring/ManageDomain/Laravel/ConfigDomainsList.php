<?php

namespace App\Monitoring\ManageDomain\Laravel;

use App\Monitoring\ManageDomain\MonitoringDomainsList;
use App\Monitoring\Vo\DomainName;

class ConfigDomainsList implements MonitoringDomainsList
{
    public function getDomains(): array
    {
        // TODO Сделать управление доменами.
        $domains = config('monitoring.domains');
        $domainNames = [];

        foreach ($domains as $domain) {
            $domainNames []= DomainName::fromString($domain);
        }

        return $domainNames;
    }
}
