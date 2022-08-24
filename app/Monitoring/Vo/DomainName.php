<?php

namespace App\Monitoring\Vo;

class DomainName
{
    private string $name;

    private function __construct(
        string $domainName
    )
    {
        if (!self::isValid($domainName)) {
            throw new \LogicException('Некорректный домен: ' . $domainName);
        }

        $this->name = self::normalize($domainName);
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public static function isValid(string $siteUrl): bool
    {
        return self::normalize($siteUrl) !== null;
    }

    private static function normalize(string $siteUrl): ?string
    {
        // TODO написать код извлечения домена из любой строки
        return $siteUrl;
    }

    public function toString(): string
    {
        return $this->name;
    }
}
