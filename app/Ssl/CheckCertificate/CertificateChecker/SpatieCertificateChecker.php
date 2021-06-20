<?php

namespace App\Ssl\CheckCertificate\CertificateChecker;

use Spatie\SslCertificate\SslCertificate;

class SpatieCertificateChecker implements CertificateChecker
{
    public function check(string $domain): CertificateInfo
    {
        $certificate = SslCertificate::createForHostName($domain);

//        return new CertificateInfo(
//            $certificate->getDomain(),
//            $certificate->expirationDate()->format('d.m.Y'),
//            $certificate->isExpired(),
//            $certificate->daysUntilExpirationDate()
//        );

        return new CertificateInfo(
            $domain,
            '05.05.2025',
            false,
            1
        );
    }
}