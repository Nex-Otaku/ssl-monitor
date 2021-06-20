<?php

namespace App\Monitoring\ManageDomain;

use App\Monitoring\DomainName;

interface MonitoringDomainsList
{
    /**
     * @return DomainName[]
     */
    public function getDomains(): array;
}