<?php

namespace App\Monitoring\Alert;

use App\Monitoring\ManageDomain\MonitoringDomainsList;
use App\Ssl\CheckCertificate\CertificateChecker\CertificateChecker;

class AlertChecker
{
    private MonitoringDomainsList $monitoringDomainsList;
    private CertificateChecker    $certificateChecker;

    public function __construct(
        MonitoringDomainsList $monitoringDomainsList,
        CertificateChecker $certificateChecker
    )
    {
        $this->monitoringDomainsList = $monitoringDomainsList;
        $this->certificateChecker = $certificateChecker;
    }

    public function alertExpiredDomains(): void
    {
        $domains = $this->monitoringDomainsList->getDomains();

        foreach ($domains as $domain) {
            $certificateInfo = $this->certificateChecker->check($domain);

            if ($certificateInfo->isExpired()) {
                $this->notifyExpired($domain);
            } elseif ($certificateInfo->daysLeft() <= 1) {
                $this->notifyLastDay($domain);
            } elseif ($certificateInfo->daysLeft() <= 3) {
                $this->notifyLastThreeDays($domain);
            } elseif ($certificateInfo->daysLeft() <= 7) {
                $this->notifyLastWeek($domain);
            }
        }
    }

    private function notifyExpired(string $domain): void
    {
        // TODO
    }

    private function notifyLastDay(string $domain): void
    {
        // TODO
    }

    private function notifyLastThreeDays(string $domain): void
    {
        // TODO
    }

    private function notifyLastWeek(string $domain): void
    {
        // TODO
    }
}