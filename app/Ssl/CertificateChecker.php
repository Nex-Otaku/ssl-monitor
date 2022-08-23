<?php

namespace App\Ssl;

interface CertificateChecker
{
    public function check(string $domain): CertificateInfo;
}
