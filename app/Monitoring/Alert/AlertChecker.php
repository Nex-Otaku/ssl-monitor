<?php

namespace App\Monitoring\Alert;

use App\Monitoring\DomainName;
use App\Monitoring\ManageDomain\MonitoringDomainsList;
use App\Notification\Notifier;
use App\Ssl\CheckCertificate\CertificateChecker\CertificateChecker;

class AlertChecker
{
    private MonitoringDomainsList $monitoringDomainsList;
    private CertificateChecker    $certificateChecker;
    private Notifier              $notifier;

    public function __construct(
        MonitoringDomainsList $monitoringDomainsList,
        CertificateChecker $certificateChecker,
        Notifier $notifier
    )
    {
        $this->monitoringDomainsList = $monitoringDomainsList;
        $this->certificateChecker = $certificateChecker;
        $this->notifier = $notifier;
    }

    public function withNotifier(Notifier $notifier): self
    {
        $new = clone $this;
        $new->notifier = $notifier;

        return $new;
    }

    public function alertExpiredDomains(): void
    {
        $domains = $this->monitoringDomainsList->getDomains();

        foreach ($domains as $domain) {
            $certificateInfo = $this->certificateChecker->check($domain->toString());

            if ($certificateInfo->isExpired()) {
                $this->notifyExpired($domain);
            } elseif ($certificateInfo->daysLeft() === 1) {
                $this->notifyLastDay($domain);
            } elseif ($certificateInfo->daysLeft() === 3) {
                $this->notifyLastThreeDays($domain);
            } elseif ($certificateInfo->daysLeft() === 7) {
                $this->notifyLastWeek($domain);
            }
        }
    }

    private function notifyExpired(DomainName $domain): void
    {
        $this->notifier->notifyDomainOwner($domain, 'Срок действия сертификата SSL уже истёк. Срочно обновите сертификат!');
    }

    private function notifyLastDay(DomainName $domain): void
    {
        $this->notifier->notifyDomainOwner($domain, 'Срок действия сертификата SSL заканчивается сегодня. Обновите сертификат.');
    }

    private function notifyLastThreeDays(DomainName $domain): void
    {
        $this->notifier->notifyDomainOwner($domain, 'Осталось три дня, чтобы обновить сертификат SSL.');
    }

    private function notifyLastWeek(DomainName $domain): void
    {
        $this->notifier->notifyDomainOwner($domain, 'Осталась неделя, чтобы обновить сертификат SSL.');
    }
}