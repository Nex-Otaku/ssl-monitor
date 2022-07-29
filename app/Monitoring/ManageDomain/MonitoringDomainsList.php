<?php

namespace App\Monitoring\ManageDomain;

use App\Monitoring\Vo\DomainName;

interface MonitoringDomainsList
{
    /**
     * @return DomainName[]
     */
    public function getDomains(): array;
}
