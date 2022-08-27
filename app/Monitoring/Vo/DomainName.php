<?php

namespace App\Monitoring\Vo;

use Illuminate\Support\Str;

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
        $value = trim(strtolower($siteUrl));

        if ($value === '') {
            return null;
        }

        $value = self::cutFromStart($value, 'http://');
        $value = self::cutFromStart($value, 'https://');
        $value = self::beforeSlash($value);

        if ($value === '') {
            return null;
        }

        $isValidDomainName = preg_match(
            '/^(?!-)[A-Za-z0-9-]+([\\-\\.]{1}[a-z0-9]+)*\\.[A-Za-z]{2,6}$/i',
            $value
        );

        return $isValidDomainName ? $value : null;
    }

    private static function cutFromStart(string $source, string $cut): string
    {
        if (!Str::startsWith($source, $cut)) {
            return $source;
        }

        return substr($source, strlen($cut));
    }

    private static function beforeSlash(string $value): string
    {
        return Str::before($value, '/');
    }

    public function toString(): string
    {
        return $this->name;
    }
}
