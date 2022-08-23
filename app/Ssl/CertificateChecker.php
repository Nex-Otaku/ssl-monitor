<?php

namespace App\Ssl\CheckCertificate\CertificateChecker;

interface CertificateChecker
{
    public function check(string $domain): CertificateInfo;
}