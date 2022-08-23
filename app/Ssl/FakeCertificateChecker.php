<?php

namespace App\Ssl;

class FakeCertificateChecker implements CertificateChecker
{
    private CertificateInfo $fakeInfo;

    private function __construct(
        CertificateInfo $fakeInfo
    )
    {
        $this->fakeInfo = $fakeInfo;
    }

    public static function makeValid(string $domain): self
    {
        return new self(
            new CertificateInfo(
                $domain,
                '05.05.2025',
                false,
                100,
                'ACME Inc.'
            )
        );
    }

    public static function makeExpired(string $domain): self
    {
        return new self(
            new CertificateInfo(
                $domain,
                '05.05.2020',
                true,
                0,
                'ACME Inc.'
            )
        );
    }

    public function check(string $domain): CertificateInfo
    {
        return $this->fakeInfo;
    }
}
