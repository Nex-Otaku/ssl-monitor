<?php

namespace App\Ssl\CheckCertificate\CertificateChecker;

use Spatie\SslCertificate\SslCertificate;

class SpatieCertificateChecker implements CertificateChecker
{
    public function check(string $domain): CertificateInfo
    {
        $certificate = SslCertificate::createForHostName($domain);

        return new CertificateInfo(
            $certificate->getDomain(),
            $certificate->expirationDate()->format('d.m.Y'),
            $certificate->isExpired(),
            $certificate->daysUntilExpirationDate(),
            $certificate->getOrganization()
        );
    }
}