<?php

namespace App\Ssl;

class CertificateInfo
{
    private string $domain;
    private string $expireDate;
    private bool   $isExpired;
    private int    $daysLeft;
    private string $issuerOrganization;

    public function __construct(
        string $domain,
        string $expireDate,
        bool $isExpired,
        int $daysLeft,
        string $issuerOrganization
    )
    {
        $this->domain = $domain;
        $this->expireDate = $expireDate;
        $this->isExpired = $isExpired;
        $this->daysLeft = $daysLeft;
        $this->issuerOrganization = $issuerOrganization;
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

    public function getIssuerOrganization(): string
    {
        return $this->issuerOrganization;
    }
}
