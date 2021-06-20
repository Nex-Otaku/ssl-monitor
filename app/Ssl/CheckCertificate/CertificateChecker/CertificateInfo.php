<?php

namespace App\Ssl\CheckCertificate\CertificateChecker;

class CertificateInfo
{
    private string $domain;
    private string $expireDate;
    private bool   $isExpired;
    private int    $daysLeft;

    public function __construct(
        string $domain,
        string $expireDate,
        bool $isExpired,
        int $daysLeft
    )
    {
        $this->domain = $domain;
        $this->expireDate = $expireDate;
        $this->isExpired = $isExpired;
        $this->daysLeft = $daysLeft;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getExpireDate(): string
    {
        return $this->expireDate;
    }

    public function isExpired(): bool
    {
        return $this->isExpired;
    }

    public function daysLeft(): int
    {
        return $this->daysLeft;
    }
}