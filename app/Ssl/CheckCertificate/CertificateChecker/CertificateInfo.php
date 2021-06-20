<?php

namespace App\Ssl\CheckCertificate\CertificateChecker;

class CertificateInfo
{
    private string $domain;
    private string $expireDate;

    public function __construct(
        string $domain,
        string $expireDate
    )
    {
        $this->domain = $domain;
        $this->expireDate = $expireDate;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getExpireDate(): string
    {
        return $this->expireDate;
    }
}