<?php

namespace App\Monitoring;

class DomainName
{
    private string $name;

    private function __construct(
        string $domainName
    )
    {
        $this->name = $domainName;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function toString(): string
    {
        return $this->name;
    }
}
