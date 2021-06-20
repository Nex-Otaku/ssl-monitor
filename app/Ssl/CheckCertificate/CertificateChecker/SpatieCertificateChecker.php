<?php

namespace App\Ssl\CheckCertificate\CertificateChecker;

class SpatieCertificateChecker implements CertificateChecker
{
    public function check(string $domain): CertificateInfo
    {
        // TODO: Implement check() method.
        return new CertificateInfo(
            $domain,
            '05.05.2033'
        );
    }
}