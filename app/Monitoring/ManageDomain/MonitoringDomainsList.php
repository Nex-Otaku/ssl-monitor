<?php

namespace App\Monitoring\ManageDomain;

interface MonitoringDomainsList
{
    /**
     * @return string[]
     */
    public function getDomains(): array;
}