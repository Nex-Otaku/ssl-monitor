<?php

namespace App\Ssl;

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
