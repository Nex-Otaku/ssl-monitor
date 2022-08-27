<?php

namespace Tests\Unit;

use App\Monitoring\Vo\DomainName;
use PHPUnit\Framework\TestCase;

class DomainNameTest extends TestCase
{
    public function test_empty()
    {
        $this->assertNotValid('');
    }

    public function test_simple()
    {
        $this->assertValid('123.ru');
    }

    public function test_two_level()
    {
        $this->assertValid('mail.ru');
    }

    public function test_three_level()
    {
        $this->assertValid('www.mail.ru');
    }

    public function test_http()
    {
        $this->assertValid('http://123.ru');
    }

    public function test_https()
    {
        $this->assertValid('https://123.ru');
    }

    public function test_ftp()
    {
        $this->assertNotValid('ftp://');
    }

    public function test_spaces_not_allowed()
    {
        $this->assertNotValid('123 .ru');
    }

    public function test_just_letters_not_allowed()
    {
        $this->assertNotValid('ru');
    }

    public function test_ignore_query()
    {
        $this->assertValid('https://123.ru/?blablabla');
    }

    private function assertValid(string $url)
    {
        $this->assertTrue($this->isValid($url));
    }

    private function assertNotValid(string $url)
    {
        $this->assertFalse($this->isValid($url));
    }

    private function isValid(string $url): bool
    {
        return DomainName::isValid($url);
    }
}
