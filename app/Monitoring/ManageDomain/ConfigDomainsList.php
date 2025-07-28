<?php

namespace App\Monitoring\ManageDomain;

use App\Monitoring\Models\Site;
use App\Monitoring\Vo\DomainName;

use function config;

class ConfigDomainsList implements MonitoringDomainsList
{
    public function getDomains(): array
    {
        $domains = Site::all()->pluck('domain')->toArray();
        $domainNames = [];

        foreach ($domains as $domain) {
            $domainNames []= DomainName::fromString($domain);
        }

        return $domainNames;
    }
}
