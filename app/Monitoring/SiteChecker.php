<?php

namespace App\Monitoring;

use App\Logger\Logger;
use App\Monitoring\Entities\MonitoringSite;
use App\Ssl\CertificateChecker;

class SiteChecker
{
    private Logger             $logger;

    private CertificateChecker $certificateChecker;

    public function __construct(
        CertificateChecker $certificateChecker
    ) {
        $this->certificateChecker = $certificateChecker;
    }

    public function checkSites(Logger $logger): void
    {
        $this->logger = $logger;
        $this->logger->write('Начали проверку сайтов.');

        $sites = MonitoringSite::all();
        $count = count($sites);
        $this->logger->write("Получили список сайтов. Всего сайтов для проверки: {$count}");

        foreach ($sites as $site) {
            $this->checkSite($site);
        }
    }

    private function checkSite(MonitoringSite $site): void
    {
        $this->logger->nextLine();
        $domainName = $site->getDomainName();
        $this->logger->write("Проверяем домен: {$domainName}");

        try {
            $certificateInfo = $this->certificateChecker->check($domainName);
        } catch (\Throwable $throwable) {
            $site->logCheckFail($throwable->getMessage());
            $this->logger->write((string) $throwable);

            return;
        }

        if ($certificateInfo->isExpired()) {
            $site->logCheckWarning('Сертификат истёк');
            $this->logger->write("Сертификат истёк.");
        } elseif ($certificateInfo->daysLeft() === 1) {
            $site->logCheckWarning('Сертификат действует последний день.');
            $this->logger->write('Сертификат действует последний день.');
        } elseif ($certificateInfo->daysLeft() === 2) {
            $site->logCheckWarning('Осталось два дня до истечения срока сертификата.');
            $this->logger->write('Осталось два дня до истечения срока сертификата.');
        } elseif ($certificateInfo->daysLeft() === 3) {
            $site->logCheckWarning('Осталось три дня до истечения срока сертификата.');
            $this->logger->write('Осталось три дня до истечения срока сертификата.');
        } elseif ($certificateInfo->daysLeft() === 4) {
            $site->logCheckWarning('Осталось четыре дня до истечения срока сертификата.');
            $this->logger->write('Осталось четыре дня до истечения срока сертификата.');
        } elseif ($certificateInfo->daysLeft() > 4 && $certificateInfo->daysLeft() < 7) {
            $site->logCheckWarning("Осталось {$certificateInfo->daysLeft()} дней до истечения срока сертификата.");
            $this->logger->write("Осталось {$certificateInfo->daysLeft()} дней до истечения срока сертификата.");
        } elseif ($certificateInfo->daysLeft() === 7) {
            $site->logCheckWarning('Осталась неделя до истечения срока сертификата.');
            $this->logger->write('Осталась неделя до истечения срока сертификата.');
        } else {
            $site->logCheckSuccess();
            $this->logger->write("[ OK ] Сертификат в полном порядке. Осталось дней: {$certificateInfo->daysLeft()}");
        }
    }
}
