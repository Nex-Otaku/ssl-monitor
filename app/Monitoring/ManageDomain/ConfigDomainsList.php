<?php

namespace App\Monitoring\ManageDomain;

use App\Monitoring\Vo\DomainName;

use function config;

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
