<?php

namespace App\Alert;

use App\Logger\Logger;
use App\Monitoring\ManageDomain\MonitoringDomainsList;
use App\Monitoring\Vo\DomainName;
use App\Notification\Notifier;
use App\Ssl\CertificateChecker;
use App\Ssl\CertificateInfo;

class AlertChecker
{
    private MonitoringDomainsList $monitoringDomainsList;
    private CertificateChecker    $certificateChecker;
    private Notifier              $notifier;
    private Logger                $logger;

    public function __construct(
        MonitoringDomainsList $monitoringDomainsList,
        CertificateChecker $certificateChecker,
        Notifier $notifier,
        Logger $logger
    )
    {
        $this->monitoringDomainsList = $monitoringDomainsList;
        $this->certificateChecker = $certificateChecker;
        $this->notifier = $notifier;
        $this->logger = $logger;
    }

    public function withNotifier(Notifier $notifier): self
    {
        $new = clone $this;
        $new->notifier = $notifier;

        return $new;
    }

    public function withLogger(Logger $logger): self
    {
        $new         = clone $this;
        $new->logger = $logger;

        return $new;
    }

    public function alertExpiredDomains(): void
    {
        $this->logger->write('Начали проверку SSL сертификатов.');

        $domains = $this->monitoringDomainsList->getDomains();
        $domainsCount = count($domains);
        $this->logger->write("Получили список доменов. Всего доменов для проверки: {$domainsCount}");

        foreach ($domains as $domain) {
            $this->logger->nextLine();
            $this->logger->write("Проверяем домен: {$domain->toString()}");

            $certificateInfo = $this->certificateChecker->check($domain->toString());

            if ($certificateInfo->isExpired()) {
                $this->notifyExpired($domain);
                $this->logger->write("Сертификат истёк. Отправлено уведомление.");
            } elseif ($certificateInfo->daysLeft() === 1) {
                $this->notifyLastDay($domain);
                $this->logger->write("Сертификат действует последний день. Отправлено уведомление.");
            } elseif ($certificateInfo->daysLeft() === 3) {
                $this->notifyLastThreeDays($domain);
                $this->logger->write("Осталось три дня до истечения срока сертификата. Отправлено уведомление.");
            } elseif ($certificateInfo->daysLeft() === 7) {
                $this->notifyLastWeek($domain);
                $this->logger->write("Осталась неделя до истечения срока сертификата. Отправлено уведомление.");
            } else {
                $this->notifyOk($domain, $certificateInfo);
                $this->logger->write("[ OK ] Сертификат в полном порядке. Осталось дней: {$certificateInfo->daysLeft()}");
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

    private function notifyOk(DomainName $domain, CertificateInfo $info): void
    {
        $this->notifier->notifyDomainOwner($domain, "[ OK ] Сертификат в полном порядке. Осталось дней: {$info->daysLeft()}");
    }
}
